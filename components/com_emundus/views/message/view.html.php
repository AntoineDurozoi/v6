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

class EmundusViewMessage extends JViewLegacy {


	public function __construct($config = array()) {

		require_once (JPATH_COMPONENT.DS.'helpers'.DS.'access.php');
		require_once (JPATH_COMPONENT.DS.'models'.DS.'messages.php');
		require_once (JPATH_COMPONENT.DS.'models'.DS.'files.php');
		require_once (JPATH_COMPONENT.DS.'models'.DS.'application.php');

		parent::__construct($config);

	}

    public function display($tpl = null) {

		$current_user = JFactory::getUser();

    	if (!EmundusHelperAccess::asPartnerAccessLevel($current_user->id))
			die (JText::_('RESTRICTED_ACCESS'));

		// List of fnum is sent via GET in JSON format.
	    $jinput = JFactory::getApplication()->input;
		$fnums = $jinput->getString('fnums', null);
		$fnums = (array) json_decode(stripslashes($fnums));

	    $document = JFactory::getDocument();
		$document->addStyleSheet("media/com_emundus/css/emundus.css");
		$document->addStyleSheet("media/com_emundus/lib/chosen/chosen.min.css");
		$document->addScript("media/com_emundus/lib/jquery-1.10.2.min.js");
		$document->addScript("media/com_emundus/lib/chosen/chosen.jquery.min.js");

		$m_files = new EmundusModelFiles();
		$m_application = new EmundusModelApplication();

		// If we are selecting all fnums: we get them using the files model
		if (!is_array($fnums) || count($fnums) == 0 || @$fnums[0] == "all") {
			$fnums = $m_files->getAllFnums();
			$fnums_infos = $m_files->getFnumsInfos($fnums, 'object');
			$fnums = $fnums_infos;
		}

		$fnum_array = array();

		$tables = array('jos_users.name', 'jos_users.username', 'jos_users.email', 'jos_users.id');
		foreach ($fnums as $fnum) {
			if (EmundusHelperAccess::asAccessAction(9, 'c', $current_user->id, $fnum->fnum) && !empty($fnum->sid)) {
				$user = $m_application->getApplicantInfos($fnum->sid, $tables);
				$user['campaign_id'] = $fnum->cid;
				$users[] = $user;
			}
		}

		$this->assignRef('users', $users);

		parent::display($tpl);

    }
}
?>