<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_users_latest
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the latest functions only once
require_once dirname(__FILE__).'/helper.php';
include_once(JPATH_BASE.DS.'components'.DS.'com_emundus'.DS.'models'.DS.'application.php');
require_once(JPATH_SITE.DS.'components'.DS.'com_emundus'.DS.'models'.DS.'checklist.php');
include_once(JPATH_BASE.DS.'components'.DS.'com_emundus'.DS.'helpers'.DS.'menu.php');

$description		 		= $params->get('description', 1);
$show_add_application 		= $params->get('show_add_application', 1);
$position_add_application 	= (int)$params->get('position_add_application', 0);
$applications		= modemundusApplicationsHelper::getApplications($params);
$linknames 			= $params->get('linknames', 0);
$moduleclass_sfx 	= htmlspecialchars($params->get('moduleclass_sfx'));
$user 				= JFactory::getUser();

$m_application 		= new EmundusModelApplication;
$checklist 			= new EmundusModelChecklist;

if (isset($user->fnum) && !empty($user->fnum)) {
	$attachments 		= $m_application->getAttachmentsProgress($user->id, $user->profile, $user->fnum);
	$forms 				= $m_application->getFormsProgress($user->id, $user->profile, $user->fnum);
	$progress 			= ($attachments + $forms)/2;
	$confirm_form_url 	= $checklist->getConfirmUrl(); 
}

require JModuleHelper::getLayoutPath('mod_emundus_applications', $params->get('layout', 'default'));
