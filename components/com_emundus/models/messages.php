<?php
/**
 * Messages model used for the new message dialog.
 *
 * @package    Joomla
 * @subpackage eMundus
 *             components/com_emundus/emundus.php
 * @link       http://www.emundus.fr
 * @license    GNU/GPL
 */

// No direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

class EmundusModelMessages extends JModelList {

    /**
     * Constructor
     *
     * @since 3.8.6
     */
    public function __construct() {

    }

    /**
     * Gets all published message templates of a certain type.
     *
     * @param Int $type The type of email to get, type 2 is by default (Templates).
     * @return Boolean False if the query fails and nothing can be loaded.
     * @return Array AN array of objects describing the messages. (sender, subject, body, etc..)
     */
    function getAllMessages($type = 2) {

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);

        $query->select('*')
                ->from($db->quoteName('#__emundus_setup_emails'))
                ->where($db->quoteName('type').' IN ('.$db->Quote($type).') AND published=1');

        try {

            $db->setQuery($query);
            return $db->loadObjectList();

        } catch (Exception $e) {
            JLog::add('Error getting emails in model/messages at query : '.$query->__toString(), JLog::ERROR, 'com_emundus');
            return false;
        }

	}


    /**
     * Gets all published message categories of a certain type.
     *
     * @param Int $type The type of category to get, type 2 is by default (Templates).
     * @return Boolean False if the query fails and nothing can be loaded.
     * @return Array An array of the categories.
     */
	function getAllCategories($type = 2) {

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);

        $query->select('DISTINCT(category)')
                ->from($db->quoteName('#__emundus_setup_emails'))
                ->where($db->quoteName('type').' IN ('.$db->Quote($type).') AND published=1');

        try {

            $db->setQuery($query);
            return $db->loadColumn();

        } catch (Exception $e) {
            JLog::add('Error getting email categories in model/messages at query : '.$query->__toString(), JLog::ERROR, 'com_emundus');
            return false;
        }

    }


    /**
     * Gets all published attachements unless a filter is active.
     *
     * @return Boolean False if the query fails and nothing can be loaded.
     * @return Array An array of objects describing attachements.
     */
    function getAttachements() {

        $db = JFactory::getDbo();
        $session = JFactory::getSession();

        $filt_params = $session->get('filt_params');

        $query = $db->getQuery(true);

        // Get all info about the attachements in the table.
        $query->select('a.*')
                ->from($db->quoteName('#__emundus_setup_attachments', 'a'));

        $where = '1 = 1 ';

        // if a filter is added then we need to filter out the attachemnts that dont match.
        if (isset($filt_params['campaign'][0]) && $filt_params['campaign'][0] != '%') {

            // Joins are added in the ifs, even though some are redundant it's better than doing tons of joins when not needed.
            $query->leftJoin($db->quoteName('#__emundus_setup_attachment_profiles', 'ap').' ON '.$db->QuoteName('ap.attachment_id').' = '.$db->QuoteName('a.id'))
                    ->leftJoin($db->quoteName('#__emundus_setup_profiles', 'p').' ON '.$db->QuoteName('ap.profile_id').' = '.$db->QuoteName('p.id'))
                    ->leftJoin($db->quoteName('#__emundus_setup_campaigns', 'c').' ON '.$db->QuoteName('c.profile_id').' = '.$db->QuoteName('p.id'));

            $where .= ' AND '.$db->quoteName('c.id').' LIKE '.$filt_params['campaign'][0];

        } else if (isset($filt_params['programme'][0]) && $filt_params['programme'][0] != '%') {

            $query->leftJoin($db->quoteName('#__emundus_setup_attachment_profiles', 'ap').' ON '.$db->QuoteName('ap.attachment_id').' = '.$db->QuoteName('a.id'))
                    ->leftJoin($db->quoteName('#__emundus_setup_profiles', 'p').' ON '.$db->QuoteName('ap.profile_id').' = '.$db->QuoteName('p.id'))
                    ->leftJoin($db->quoteName('#__emundus_setup_campaigns', 'c').' ON '.$db->QuoteName('c.profile_id').' = '.$db->QuoteName('p.id'))
                    ->leftJoin($db->quoteName('#__emundus_setup_programmes', 'pr').' ON '.$db->QuoteName('c.training').' = '.$db->QuoteName('pr.code'));

            $where .= ' AND '.$db->quoteName('pr.code').' LIKE '.$db->Quote($filt_params['programme'][0]);

        }

        $query->where($where.' AND '.$db->quoteName('a.published').'=1');

        try {

            $db->setQuery($query);
            return $db->loadObjectList();

        } catch (Exception $e) {
            JLog::add('Error getting attachements in model/messages at query : '.$query->__toString(), JLog::ERROR, 'com_emundus');
            return false;
        }

    }


    /**
     * Gets all published letters unless a filter is active.
     *
     * @return Boolean False if the query fails and nothing can be loaded.
     * @return Array An array of objects describing letters.
     */
    function getLetters() {

        $db = JFactory::getDbo();
        $session = JFactory::getSession();

        $filt_params = $session->get('filt_params');

        $query = $db->getQuery(true);

        // Get all info about the letters in the table.
        $query->select('l.*')
                ->from($db->quoteName('#__emundus_setup_letters', 'l'));

        // if a filter is added then we need to filter out the letters that dont match.
        if (isset($filt_params['campaign'][0]) && $filt_params['campaign'][0] != '%') {

            $query->leftJoin($db->quoteName('#__emundus_setup_programmes', 'p').' ON '.$db->QuoteName('l.code').' = '.$db->QuoteName('p.code'))
                    ->leftJoin($db->quoteName('#__emundus_setup_campaigns', 'c').' ON '.$db->QuoteName('c.profile_id').' = '.$db->QuoteName('p.id'))
                    ->where($db->quoteName('c.id').' LIKE '.$filt_params['campaign'][0]);

        } else if (isset($filt_params['programme'][0]) && $filt_params['programme'][0] != '%') {

            $query->where($db->quoteName('l.code').' LIKE '.$db->Quote($filt_params['programme'][0]));

        }

        try {

            $db->setQuery($query);
            return $db->loadObjectList();

        } catch (Exception $e) {
            JLog::add('Error getting letters in model/messages at query : '.$query->__toString(), JLog::ERROR, 'com_emundus');
            return false;
        }

    }


    /**
     * Gets a message template.
     *
     * Gets selected template from POST data.
     * Returns a JSON containing the template info.
     */
	function getTemplate() {

		$db = JFactory::getDBO();
        $select = JRequest::getVar('select', null, 'POST', 'none', 0);

        $query = $db->getQuery(true);

        $query->select('*')
                ->from($db->quoteName('#__emundus_setup_emails'))
                ->where($db->quoteName('id').' = '.$select);

        try {

            $db->setQuery($query);
            $email = $db->loadObject();

        } catch (Exception $e) {
            JLog::add('Error getting template in model/messages at query :'.$query->__toString(), JLog::ERROR, 'com_emundus');
            echo json_encode((object)(array('status' => false)));
            die();
        }

        echo json_encode((object)(array('status' => true, 'tmpl' => $email)));
		die();

	}


}

?>