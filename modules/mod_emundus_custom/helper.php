<?php
/**
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
use Joomla\CMS\Date\Date;

/**
 * @package		Joomla.Site
 * @subpackage	mod_emunduscustom
 * @since		1.5
 */
class modEmundusCustomHelper {

	public function __construct() {}

	/**
	 * Ajax function intended for the Nantes custom AJAX only version of this module.
	 *
	 * @since version
	 */
	static function nantesGetAvailableSpacesAjax() {

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$fnum = JFactory::getApplication()->input->post->get('fnum');
		if (empty($fnum)) {
			die(json_encode((object)['status' => false, 'msg' => 'Aucun numéro de dossier envoyé.']));
		}

		$query->select($db->quoteName(['tu.max_occupants', 'cc.campaign_id', 'c.training']))
			->from($db->quoteName('#__emundus_campaign_candidature', 'cc'))
			->leftJoin($db->quoteName('#__emundus_setup_campaigns', 'c').' ON '.$db->quoteName('c.id').' = '.$db->quoteName('cc.campaign_id'))
			->leftJoin($db->quoteName('#__emundus_setup_teaching_unity', 'tu').' ON '.$db->quoteName('tu.code').' = '.$db->quoteName('c.training'))
			->where($db->quoteName('cc.fnum').' LIKE '.$db->quote($fnum));
		$db->setQuery($query);
		try {
			$res = $db->loadObject();
		} catch (Exception $e) {
			die($query->__toString());
		}

		if (empty($res->max_occupants)) {
			die(json_encode((object)['status' => true, 'msg' => 'Candidat inscrit.', 'attente' => false]));
		}

		// If user is from program FCESHU or FCSEXO then the $occupants needs to be from all of THOSE cc entries combined.
		if ($res->training == 'FCESHU' || $res->training == 'FCSEXO') {
			$query->clear()->select($db->quoteName('d.id'))
				->from($db->quoteName('#__emundus_campaign_candidature', 'cc'))
				->leftJoin($db->quoteName('#__emundus_setup_campaigns', 'c').' ON '.$db->quoteName('c.id').' = '.$db->quoteName('cc.campaign_id'))
				->leftJoin($db->quoteName('#__emundus_setup_teaching_unity', 'tu').' ON ('.$db->quoteName('c.training').' = '.$db->quoteName('tu.code').' AND '.$db->quoteName('c.year').' = '.$db->quoteName('tu.schoolyear').')')
				->leftJoin($db->quoteName('#__emundus_final_grade', 'd').' ON '.$db->quoteName('cc.fnum').' = '.$db->quoteName('d.fnum'))
				->where($db->quoteName('d.final_grade').' LIKE '.$db->quote('2').' AND '.$db->quoteName('c.training').' IN ('.$db->quote('FCESHU').', '.$db->quote('FCSEXO').') AND '.$db->quoteName('c.published').' = 1 AND '.$db->quoteName('c.start_date').' <= NOW() AND '.$db->quoteName('tu.date_end').' >= NOW()');
		} else {
			$query->clear()->select($db->quoteName('d.id'))
				->from($db->quoteName('#__emundus_campaign_candidature', 'cc'))
				->leftJoin($db->quoteName('#__emundus_final_grade', 'd').' ON '.$db->quoteName('cc.fnum').' = '.$db->quoteName('d.fnum'))
				->where($db->quoteName('d.final_grade').' LIKE '.$db->quote('2').' AND '.$db->quoteName('cc.campaign_id').' = '.$res->campaign_id);
		}
		$db->setQuery($query);
		try {
			$occupants = count($db->loadColumn());
		} catch (Exception $e) {
			die($query->__toString());
		}

		if ($occupants >= $res->max_occupants) {
			die(json_encode((object)['status' => true, 'msg' => 'Attente', 'attente' => true]));
		} else {
			die(json_encode((object)['status' => true, 'msg' => ($res->max_occupants - $occupants). ' places restantes', 'attente' => false]));
		}
	}


	/**
	 * Ajax function to insert/update FG table for Nantes.
	 *
	 * @since version
	 */
	static function nantesPostFinalGradeAjax() {

		jimport('joomla.log.log');
		JLog::addLogger(['text_file' => 'com_emundus.nantesFG.php'], JLog::ALL, ['com_emundus']);

		$user = JFactory::getUser();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$jinput = JFactory::getApplication()->input;
		$fnum = $jinput->post->get('fnum');
		$decision = (int)$jinput->post->getInt('decision');
		$wait_rank = (int)$jinput->post->getInt('waitlistRank', 0);
		$comment = $jinput->post->get('comment', '');

		if (empty($fnum) || empty($decision)) {
			JLog::add('Aucun numéro de dossier ou décision envoyé.', JLog::ERROR, 'com_emundus');
			die(json_encode((object)['status' => false, 'msg' => 'Aucun numéro de dossier ou décision envoyé.']));
		}

		if ($decision === 8 && empty($wait_rank)) {
			JLog::add('Décision en liste d\'attente sans rang envoyé.', JLog::ERROR, 'com_emundus');
			die(json_encode((object)['status' => false, 'msg' => 'Aucun rang de liste d\'atttente envoyé.']));
		}

		$query->select($db->quoteName('id'))
			->from($db->quoteName('#__emundus_final_grade', 'fg'))
			->where($db->quoteName('fg.fnum').' LIKE '.$db->quote($fnum));
		$db->setQuery($query);
		try {
			$fg_id = $db->loadResult();
		} catch (Exception $e) {
			$fg_id = null;
		}

		$query->clear()
			->select($db->quoteName(['va_accord', 'dispense']))
			->from($db->quoteName('#__emundus_evaluations'))
			->where($db->quoteName('fnum').' LIKE '.$db->quote($fnum));
		$db->setQuery($query);
		try {
			$eval_special = $db->loadObjectList();
		} catch (Exception $e) {
			$eval_special = [];
		}

		// Rebuilding the logic of the calc fields in the commission form.
		$va_accepted = false;
		$eval_dispence = false;
		if (!empty($eval_special)) {
			foreach ($eval_special as $esp) {
				if ($esp->va_accord === 'Oui') {
					$va_accepted = true;
				}
				if ($esp->dispence === 'Oui') {
					$eval_dispence = true;
				}
			}
		}

		$va_accepted = $va_accepted?'Oui':'Non';
		$eval_dispence = $eval_dispence?'Oui':'Non';

		if (!empty($fg_id)) {

			$query->clear()
				->update($db->quoteName('#__emundus_final_grade'));

			$fields = [
				$db->quoteName('final_grade').' = '.$db->quote($decision),
				$db->quoteName('info1').' = '.$db->quote($comment),
				$db->quoteName('va_accepted').' = '.$db->quote($va_accepted),
				$db->quoteName('eval_dispence').' = '.$db->quote($eval_dispence)
			];

			if ($decision === 8) {
				$fields[] = $db->quoteName('waiting_list_rank').' = '.$db->quote($wait_rank);
			}

			$query->set($fields)
				->where($db->quoteName('id').' = '.$fg_id);
			$db->setQuery($query);

			try {
				$db->execute();
				die(json_encode((object)['status' => true, 'msg' => 'Commission mise à jour.']));
			} catch (Exception $e) {
				JLog::add('Erreur de sauvegarde de commission -> '.$e->getMessage(), JLog::ERROR, 'com_emundus');
				die(json_encode((object)['status' => false, 'msg' => 'Erreur de sauvegarde de commission.']));
			}

		} else {

			$offset = JFactory::getApplication()->get('offset', 'UTC');
			try {
				$dateTime = new DateTime(gmdate("Y-m-d H:i:s"), new DateTimeZone('UTC'));
				$dateTime = $dateTime->setTimezone(new DateTimeZone($offset));
				$now = $dateTime->format('Y-m-d H:i:s');
			} catch (Exception $e) {
				$now = new Date();
				$now = $now->toSql();
			}

			$query->clear()
				->insert($db->quoteName('#__emundus_final_grade'))
				->columns($db->quoteName(['time_date', 'fnum', 'student_id', 'user', 'final_grade', 'va_accepted', 'waiting_list_rank', 'info1', 'campaign_id', 'eval_dispence']))
				->values($db->quote($now).', '.$db->quote($fnum).', '.(int)substr($fnum, -7).', '.$user->id.', '.$db->quote($decision).', '.$db->quote($va_accepted).', '.$db->quote($wait_rank).', '.$db->quote($comment).', '.(int)substr($fnum, 14, 7).', '.$db->quote($eval_dispence));
			$db->setQuery($query);

			try {
				$db->execute();
				die(json_encode((object)['status' => true, 'msg' => 'Commission ajoutée.']));
			} catch (Exception $e) {
				JLog::add('Erreur de sauvegarde de commission -> '.$e->getMessage(), JLog::ERROR, 'com_emundus');
				die(json_encode((object)['status' => false, 'msg' => 'Erreur de sauvegarde de commission.']));
			}
		}
	}



    /**
     * Ajax function confirm all evaluations for an evaluator
     *
     * @since version
     */
    static function confirmAllEvaluationsAjax() {

        $user = JFactory::getUser();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
            ->update($db->quoteName('#__emundus_evaluations'))
            ->set($db->quoteName('confirm') . ' = 1')
            ->where($db->quoteName('user') . ' = '. $user->id);
        $db->setQuery($query);

        try {
            $db->execute();
            die(json_encode((object)['status' => true, 'msg' => JText::_('MOD_EVAL_CONFIRM')]));
        } catch (Exception $e) {
            die(json_encode((object)['status' => false, 'msg' => JText::_('MOD_EVAL_CONFIRM_ERROR')]));
        }
    }
}
