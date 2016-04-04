<?php
/**
* @version		$Id: mod_emundusflow.php 7692 2007-06-08 20:41:29Z tcp $
* @package		Joomla
* @copyright	Copyright (C) 2016 emundus.fr. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$user = JFactory::getUser();

if (isset($user->fnum) && !empty($user->fnum)) {

	require_once (JPATH_SITE.DS.'components'.DS.'com_emundus'.DS.'helpers'.DS.'menu.php');
	require_once (JPATH_SITE.DS.'components'.DS.'com_emundus'.DS.'models'.DS.'checklist.php');
	require_once (JPATH_SITE.DS.'components'.DS.'com_emundus'.DS.'models'.DS.'application.php');
	require_once (JPATH_SITE.DS.'components'.DS.'com_emundus'.DS.'models'.DS.'files.php');

	$document = JFactory::getDocument();
	$document->addStyleSheet( JURI::base()."media/com_emundus/lib/Semantic-UI-CSS-master/semantic.min.css" );

	$jinput = JFactory::getApplication()->input;
	$option = $jinput->get('option');
	$view = $jinput->get('view');


	$db = JFactory::getDBO();

	$params = JComponentHelper::getParams('com_emundus');
	$applicant_can_renew = $params->get('applicant_can_renew');
	$show_programme = $params->get('show_programme', 1);
	$application_fees  = $params->get('application_fees', 0);

	$checklist = new EmundusModelChecklist;
	$application = new EmundusModelApplication;
	//$files = new EmundusModelFiles;

	$fnumInfos = EmundusModelFiles::getFnumInfos($user->fnum);
	$paid = count($application->getHikashopOrder($fnumInfos))>0?1:0;
	$attachments = $application->getAttachmentsProgress($user->id, $user->profile, $user->fnum);
	$forms = $application->getFormsProgress($user->id, $user->profile, $user->fnum);
	$current_application = $application->getApplication($user->fnum);
	$sent = $checklist->getSent();
	$confirm_form_url = $checklist->getConfirmUrl();
	

	require(JModuleHelper::getLayoutPath('mod_emundusflow'));
}