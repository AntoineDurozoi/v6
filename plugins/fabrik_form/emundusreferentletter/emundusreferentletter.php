<?php
/**
 * @version 2: emundusReferentLetter 2018-04-25 Hugo Moracchini
 * @package Fabrik
 * @copyright Copyright (C) 2018 emundus.fr. All rights reserved.
 * @license GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 * @description Redirection et chainage des formulaires suivant le profile de l'utilisateur
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

// Require the abstract plugin class
require_once COM_FABRIK_FRONTEND . '/models/plugin-form.php';

/**
 * Create a Joomla user from the forms data
 *
 * @package     Joomla.Plugin
 * @subpackage  Fabrik.form.juseremundus
 * @since       3.0
 */

class PlgFabrik_FormEmundusReferentLetter extends plgFabrik_Form
{
	/**
	 * Status field
	 *
	 * @var  string
	 */
	protected $URLfield = '';

	/**
	 * Get an element name
	 *
	 * @param   string  $pname  Params property name to look up
	 * @param   bool    $short  Short (true) or full (false) element name, default false/full
	 *
	 * @return	string	element full name
	 */
	public function getFieldName($pname, $short = false)
	{
		$params = $this->getParams();

		if ($params->get($pname) == '')
		{
			return '';
		}

		$elementModel = FabrikWorker::getPluginManager()->getElementPlugin($params->get($pname));

		return $short ? $elementModel->getElement()->name : $elementModel->getFullName();
	}

	/**
	 * Get the fields value regardless of whether its in joined data or no
	 *
	 * @param   string  $pname    Params property name to get the value for
	 * @param   mixed   $default  Default value
	 *
	 * @return  mixed  value
	 */
	public function getParam($pname, $default = '')
	{
		$params = $this->getParams();

		if ($params->get($pname) == '')
		{
			return $default;
		}

		return $params->get($pname);
	}

	/**
	 * Main script.
	 *
	 * @return  bool
	 * @throws Exception
	 */
	public function onBeforeCalculations() {

		jimport('joomla.utilities.utility');
		jimport('joomla.log.log');
		JLog::addLogger(['text_file' => 'com_emundus.filerequest.php'], JLog::ALL, ['com_emundus']);

		include_once (JPATH_BASE.'/components/com_emundus/models/files.php');
		include_once (JPATH_BASE.'/components/com_emundus/models/emails.php');

		$baseurl    = JURI::root();
		$db         = JFactory::getDBO();
		$app        = JFactory::getApplication();
		$jinput     = $app->input;

		$offset = $app->get('offset', 'UTC');
		try {
			$dateTime = new DateTime(gmdate("Y-m-d H:i:s"), new DateTimeZone('UTC'));
			$dateTime = $dateTime->setTimezone(new DateTimeZone($offset));
			$now = $dateTime->format('Y-m-d H:i:s');
		} catch (Exception $e) {
			echo $e->getMessage() . '<br />';
		}

		$student_id = $jinput->get('jos_emundus_references___user')[0];
		$fnum       = $jinput->get('jos_emundus_references___fnum');

		$recipients = array();
		$recipients[] = array('attachment_id' => $jinput->get('jos_emundus_references___attachment_id_1', 4), 'email' => $jinput->getString('jos_emundus_references___Email_1', ''),'name'=>$jinput->getString('jos_emundus_references___Last_Name_1', JText::_('CIVILITY_MR').'/'.JText::_('CIVILITY_MRS')),'firstname'=>$jinput->getString('jos_emundus_references___First_Name_1', ''));
		$recipients[] = array('attachment_id' => $jinput->get('jos_emundus_references___attachment_id_2', 6), 'email' => $jinput->getString('jos_emundus_references___Email_2', ''),'name'=>$jinput->getString('jos_emundus_references___Last_Name_2', JText::_('CIVILITY_MR').'/'.JText::_('CIVILITY_MRS')),'firstname'=>$jinput->getString('jos_emundus_references___First_Name_1', ''));
		$recipients[] = array('attachment_id' => $jinput->get('jos_emundus_references___attachment_id_3', 21), 'email' => $jinput->getString('jos_emundus_references___Email_3', ''),'name'=>$jinput->getString('jos_emundus_references___Last_Name_3', JText::_('CIVILITY_MR').'/'.JText::_('CIVILITY_MRS')),'firstname'=>$jinput->getString('jos_emundus_references___First_Name_1', ''));
		$recipients[] = array('attachment_id' => $jinput->get('jos_emundus_references___attachment_id_4', 19), 'email' => $jinput->getString('jos_emundus_references___Email_4', ''),'name'=>$jinput->getString('jos_emundus_references___Last_Name_4', JText::_('CIVILITY_MR').'/'.JText::_('CIVILITY_MRS')),'firstname'=>$jinput->getString('jos_emundus_references___First_Name_1', ''));

		$student = JFactory::getUser($student_id);
		$current_user = JFactory::getSession()->get('emundusUser');
		if (empty($current_user->fnum) || !isset($current_user->fnum)) {
			$current_user->fnum = $fnum;
		}

		$url = $this->getParam('url');
		$sef_url = $this->getParam('sef_url', false);
		$email_tmpl = $this->getParam('email_tmpl', 'referent_letter');

		// Récupération des données du mail
		$query = 'SELECT id, subject, emailfrom, name, message
                FROM #__emundus_setup_emails
                WHERE lbl="'.$email_tmpl.'"';
		$db->setQuery($query);
		$db->execute();
		$obj = $db->loadObjectList();

		// Récupération de la pièce jointe : modele de lettre
		$query = 'SELECT esp.reference_letter
                FROM #__emundus_setup_profiles as esp
                WHERE esp.id = '.$current_user->profile;
		$db->setQuery($query);
		$db->execute();
		$obj_letter = $db->loadRowList();

		//////////////////////////  SET FILES REQUEST  /////////////////////////////
		//
		// Génération de l'id du prochain fichier qui devra être ajouté par le referent
		$m_files = new EmundusModelFiles;
		$m_emails = new EmundusModelEmails;

		$fnum_detail = $m_files->getFnumInfos($current_user->fnum);

		// setup mail
		$email_from_sys = $app->getCfg('mailfrom');

		$from = $obj[0]->emailfrom;
		$fromname = $obj[0]->name;

		$sender = array(
			$email_from_sys,
			$fromname
		);
		$attachment = array();
		if (!empty($obj_letter[0][0])) {
			$attachment[] = JPATH_BASE.str_replace("\\", "/", $obj_letter[0][0]);
		}

		foreach ($recipients as $recipient) {
			if (isset($recipient['email']) && !empty($recipient['email'])) {
				
				$attachment_id = $recipient['attachment_id']; //ID provenant de la table emundus_attachments
				
				$query = 'SELECT count(id) as cpt FROM #__emundus_files_request 
							WHERE student_id='.$student->id.' AND attachment_id='.$attachment_id.' AND uploaded=1 AND fnum like '.$db->Quote($current_user->fnum);

				$db->setQuery($query);
				$db->execute();
				$is_uploaded = $db->loadResult();

				if ($is_uploaded == 0) {
					$key = md5(date('Y-m-d h:m:i').'::'.$fnum.'::'.$student_id.'::'.$attachment_id.'::'.rand());
					// 2. MAJ de la table emundus_files_request
					$query = 'INSERT INTO #__emundus_files_request (time_date, student_id, keyid, attachment_id, campaign_id, fnum, email) 
                          VALUES ('.$db->Quote($now).', '.$student->id.', '.$db->Quote($key).', '.$attachment_id.', '.$fnum_detail['id'].', '.$db->Quote($current_user->fnum).', '.$db->Quote($recipient['email']).')';

					$db->setQuery($query);
					$db->execute();
					$request_id = $db->insertid();

					// 3. Envoi du lien vers lequel le professeur va pouvoir uploader la lettre de référence
					if ($sef_url === 'true') {
						$link_upload = $baseurl.$url.'?keyid='.$key.'&sid='.$student->id;
					} else {
						$link_upload = $baseurl.$url.'&keyid='.$key.'&sid='.$student->id;
					}

					$post = [
						'ID'             => $student->id,
						'NAME'           => $student->name,
						'EMAIL'          => $student->email,
						'UPLOAD_URL'     => $link_upload,
						'PROGRAMME_NAME' => $fnum_detail['label'],
						'FNUM'           => $fnum,
						'USER_NAME'      => $fnum_detail['name'],
						'CAMPAIGN_LABEL' => $fnum_detail['label'],
						'SITE_URL'       => JURI::base(),
						'USER_EMAIL'     => $fnum_detail['email'],
                        'REFERENT_NAME'  => $recipient['name'],
                        'REFERENT_FIRST_NAME'  => $recipient['firstname']
					];
					$tags = $m_emails->setTags($fnum_detail['applicant_id'], $post, $fnum);
					$subject = preg_replace($tags['patterns'], $tags['replacements'], $obj[0]->subject);
					$body = preg_replace($tags['patterns'], $tags['replacements'], $obj[0]->message);

					$body = $m_emails->setTagsFabrik($body, [$fnum_detail['fnum']]);
					$subject = $m_emails->setTagsFabrik($subject, [$fnum_detail['fnum']]);

					$to = array($recipient['email']);

					$mailer = JFactory::getMailer();
					$mailer->setSender($sender);
					$mailer->addReplyTo($from, $fromname);
					$mailer->addRecipient($to);
					$mailer->setSubject($subject);
					$mailer->isHTML(true);
					$mailer->Encoding = 'base64';
					$mailer->setBody($body);
					$mailer->addAttachment($attachment);

					$send = $mailer->Send();
					if ($send !== true) {

						JFactory::getApplication()->enqueueMessage(JText::_('MESSAGE_NOT_SENT').' : '.$recipient['email'], 'error');
						JLog::add($send->__toString(), JLog::ERROR, 'com_emundus');

					} else {

						JFactory::getApplication()->enqueueMessage(JText::_('MESSAGE_SENT').' : '.$recipient['email'], 'message');
						$body = JText::_('SENT_TO'). ' '.$recipient['email'].'<br><a href="index.php?option=com_fabrik&view=details&formid=264&rowid='.$request_id.'&listid=273" target="_blank">'.JText::_('INVITATION_LINK').'</a><br>'.$body;

						$sql = "INSERT INTO `#__messages` (`user_id_from`, `user_id_to`, `subject`, `message`, `date_time`)
                            VALUES ('62', '-1', ".$db->quote($subject).", ".$db->quote($body).", ".$db->quote($now).")";
						$db->setQuery($sql);
						try {
							$db->execute();
						} catch (Exception $e) {
							// catch any database errors.
						}

					}
					unset($replacements);
					unset($mailer);
				}
			}
		}
		return true;
	}


	// 1. Génération aléatoire de l'ID
	function rand_string($len, $chars = 'abcdefghijklmnopqrstuvwxyz0123456789') {
		$string = '';
		for ($i = 0; $i < $len; $i++) {
			$pos = rand(0, strlen($chars)-1);
			$string .= $chars{$pos};
		}
		return $string;
	}


	/**
	 * Raise an error - depends on whether you are in admin or not as to what to do
	 *
	 * @param   array   &$err    Form models error array
	 * @param   string   $field  Name
	 * @param   string   $msg    Message
	 *
	 * @return  void
	 * @throws Exception
	 */
	protected function raiseError(&$err, $field, $msg) {
		$app = JFactory::getApplication();

		if ($app->isAdmin()) {
			$app->enqueueMessage($msg, 'notice');
		} else {
			$err[$field][0][] = $msg;
		}
	}
}
