<?php
defined('_JEXEC') or die();
/**
 * @version 1.5: emundus-expert_check.php 89 2017-10-01 Benjamin Rivalland
 * @package Fabrik
 * @copyright Copyright (C) 2008-2013 eMundus SAS. All rights reserved.
 * @license GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 * @description Vérification de l'autorisation d'accès à un dossier par un expert
 */

$app = JFactory::getApplication();
$jinput = $app->input;
$key_id = $jinput->get->get('keyid');
$campaign_id = $jinput->get->get('cid');
$formid = $jinput->get->get('formid');

$baseurl = JURI::base();
$db = JFactory::getDBO();

$query = $db->getQuery(true);
$query->select('*')
	->from($db->quoteName('#__emundus_files_request'))
	->where($db->quoteName('keyid').' LIKE '.$db->quote($key_id).' AND ('.$db->quoteName('uploaded').' = 0 OR '.$db->quoteName('uploaded').' IS NULL)');
$db->setQuery($query);
$obj = $db->loadObject();

if (isset($obj)) {

	$s = $jinput->get->getInt('s');
	if ($s !== 1) {

		$link_upload = $baseurl.'index.php?option=com_fabrik&view=form&formid='.$formid.'&jos_emundus_files_request___attachment_id='.$obj->attachment_id.'&jos_emundus_files_request___campaign_id='.$obj->campaign_id.'&keyid='.$key_id.'&cid='.$campaign_id.'&rowid='.$obj->id.'&s=1';
		$app->redirect($link_upload);

	} else {

		$up_attachment = $jinput->get('jos_emundus_files_request___attachment_id');
		$attachment_id = !empty($up_attachment)?$jinput->get('jos_emundus_files_request___attachment_id'):$jinput->get->get('jos_emundus_files_request___attachment_id');

		if (empty($key_id) || empty($attachment_id) || $attachment_id != $obj->attachment_id) {
			$app->redirect(JURI::base());
			throw new Exception(JText::_('ERROR: please try again'), 500);
		}
	}

} else {
	$app->enqueueMessage(JText::_('PLEASE_LOGIN'), 'message');
	$app->redirect($baseurl.'index.php?option=com_users&view=login');
	exit();
}
