<?php
defined( '_JEXEC' ) or die();
/**
 * @version 1: final_grade.php 89 2015-06-15 Benjamin Rivalland
 * @package Fabrik
 * @copyright Copyright (C) 2008 eMundus SAS. All rights reserved.
 * @license GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 * @description Validation finale du dossier de candidature
 */

$baseurl 	= JURI::base(true);
$db 		= JFactory::getDBO();
$jinput 	= JFactory::getApplication()->input;

$sid 	= $jinput->get('jos_emundus_final_grade___student_id');
$fnum 	= $jinput->get('jos_emundus_final_grade___fnum');
$status = $jinput->get('jos_emundus_final_grade___final_grade', null, 'ARRAY');

if (!empty($status[0])) {

	switch ($status[0]) {

		case 4:
			$step = 7;
			break;

		case 3:
			$step = 8;
			break;

		case 2:
			$step = 4;
			break;

	}

	$query = 'UPDATE #__emundus_campaign_candidature SET status='.$step.' WHERE fnum like '. $db->Quote($fnum).' AND applicant_id='.$sid;

	try {

		$db->setQuery($query);
		$db->execute();

	} catch(Exception $e) {
	    throw $e;
	}


	if ($status[0] == 4) {

		$query = 'UPDATE #__emundus_users SET profile=8 WHERE user_id = '.$sid;

		try {

			$db->setQuery($query);
			$db->execute();

		} catch(Exception $e) {
			throw $e;
		}

	}

}
?>