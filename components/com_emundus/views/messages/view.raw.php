<?php
/**
 * @package    Joomla
 * @subpackage emundus
 *             components/com_emundus/emundus.php
 * @link       http://www.emundus.fr
 * @license    GNU/GPL
 * @author     Hugo Moracchini
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML View class for the Emundus Component
 *
 * @package Emundus
 */

class EmundusViewMessages extends JViewLegacy {

	var $user_id = null;
	var $user_name = null;
	var $messages = null;
	var $message_contacts = null;
	var $other_user = null;
	var $offers = null;

	public function __construct($config = array()) {
		require_once (JPATH_COMPONENT.DS.'helpers'.DS.'access.php');
		require_once (JPATH_COMPONENT.DS.'models'.DS.'messages.php');
		parent::__construct($config);
	}

    public function display($tpl = null) {

		$current_user = JFactory::getUser();
    	if (!EmundusHelperAccess::asApplicantAccessLevel($current_user->id)) {
		    die(JText::_('RESTRICTED_ACCESS'));
	    }

        $m_messages = new EmundusModelMessages();

        $jinput = JFactory::getApplication()->input;
        $tmpl = $jinput->get->get('layout', 'default');

        if ($tmpl === 'chat') {
	        $this->other_user = $jinput->get->getInt('chatid', null);
            $this->messages = $m_messages->loadMessages($this->other_user);
            $this->user_id = $current_user->id;

	        require_once (JPATH_COMPONENT.DS.'models'.DS.'cifre.php');
	        $m_cifre = new EmundusModelCifre();
            $this->offers = $m_cifre->getOffersBetweenUsers($this->user_id, $this->other_user);

        } elseif ($tmpl === 'default') {
	        $this->message_contacts = $m_messages->getContacts();
            $this->user_id = $current_user->id;
            $this->user_name = $current_user->name;
        }

		parent::display($tpl);
    }
}