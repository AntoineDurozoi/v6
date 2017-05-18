<?php
defined( '_JEXEC' ) or die();
/**
 * @version 1: isApplicationCompleted.php 89 2016-06-02 Benjamin Rivalland
 * @package Fabrik
 * @copyright Copyright (C) 2016 eMundus. All rights reserved.
 * @license GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 * @description Vérification avant envoie du dossier que le dossier est bien complet
 */

$mainframe = JFactory::getApplication();
$jinput = $mainframe->input;
$itemid = $jinput->get('Itemid');

if ($jinput->get('view') == 'form') {
	 require_once (JPATH_SITE.DS.'components'.DS.'com_emundus'.DS.'helpers'.DS.'menu.php');
	 require_once (JPATH_SITE.DS.'components'.DS.'com_emundus'.DS.'models'.DS.'application.php');
	 require_once (JPATH_SITE.DS.'components'.DS.'com_emundus'.DS.'models'.DS.'files.php');

	$user = JFactory::getUser();

	$params = JComponentHelper::getParams('com_emundus');
	$application_fee = $params->get('application_fee', 0);

	$application = new EmundusModelApplication;
	$attachments = $application->getAttachmentsProgress($user->id, $user->profile, $user->fnum);
	$forms = $application->getFormsProgress($user->id, $user->profile, $user->fnum);

	if ($application_fee == 1) {
		$fnumInfos = EmundusModelFiles::getFnumInfos($user->fnum);
		if (count($fnumInfos) > 0) {
			$paid = count($application->getHikashopOrder($fnumInfos))>0?1:0;

			if (!$paid && $attachments >= 100 && $forms >= 100) {
				$checkout_url = $application->getHikashopCheckoutUrl($user->profile);
				$mainframe->redirect(JRoute::_($checkout_url));
			} else {
				$mainframe->redirect( "index.php?option=com_emundus&view=checklist&Itemid=".$itemid, JText::_('INCOMPLETE_APPLICATION'));
			}
		} else {
			$mainframe->redirect('index.php');
		}

	}	

	if($attachments < 100 || $forms < 100){
		$mainframe->redirect( "index.php?option=com_emundus&view=checklist&Itemid=".$itemid, JText::_('INCOMPLETE_APPLICATION'));
	}
}

?>