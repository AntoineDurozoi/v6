<?php
defined('_JEXEC') or die();
/**
 * @version 6.3.4: emundus-campaign-multi.php 89 2019-12-27 Hugo Moracchini
 * @package Fabrik
 * @copyright Copyright (C) 2018 eMundus. All rights reserved.
 * @license GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 * @description This plugin combines campaign_check and campaign while allowing multiple users to be registered to a campaign at once by another.
 */

$db = JFactory::getDBO();
$query = $db->getQuery(true);
$current_user = JFactory::getUser();
$application = Jfactory::getApplication();

$campaign_id = $data['jos_emundus_campaign_candidature___campaign_id_raw'][0];
$company_id = $data['jos_emundus_campaign_candidature___company_id_raw'][0];

if (!empty($company_id) && $company_id != -1) {
	$users = $data['___applicant_id_raw'];
} else {
	$users[0][0] = $current_user->id;
}

JLog::addLogger(array('text_file' => 'com_emundus.emundus-campaign-multi.php'), JLog::ALL, array('com_emundus'));

$eMConfig = JComponentHelper::getParams('com_emundus');
$applicant_can_renew = $eMConfig->get('applicant_can_renew', '0');

$query->select($db->quoteName('profile_id'))
	->from($db->quoteName('#__emundus_setup_campaigns'))
	->where($db->quoteName('id').' = '.$campaign_id);
$db->setQuery($query);
try {
	$profile = $db->loadResult();
} catch(Exception $e) {
	JLog::add(JUri::getInstance().' :: USER ID : '.$current_user->id.' -> '.$query->__toString(), JLog::ERROR, 'com_emundus');
	JError::raiseError(500, $query);
}

// Prepare insertion of data (it is not done via the Fabrik form, we do it manually to handle repeat groups multiplying the data set).
$values = [];
$rights_values = [];
$profile_values = [];
$users_registered = [];

foreach ($users as $user) {

	$user_id = $user[0];

	// Don't allow the same user to be signed up twice.
	if (in_array($user_id, $users_registered)) {
		continue;
	}
	
	$users_registered[] = $user_id;
	switch ($applicant_can_renew) {

	    // Cannot create new campaigns at all.
	    case 0:
	    	$query->clear()->select($db->quoteName('id'))
			    ->from($db->quoteName('#__emundus_campaign_candidature'))
			    ->where($db->quoteName('applicant_id').' = '.$user_id);
		    try {
			    if (!empty($db->loadResult())) {
				    JLog::add('User: '.$user_id.' already has a file.', JLog::ERROR, 'com_emundus');
				    $application->enqueueMessage('User already has a file open and cannot have multiple.', 'error');
				    continue 2;
			    }
		    } catch(Exception $e) {
			    JLog::add(JUri::getInstance().' :: USER ID : '.$current_user->id.' -> '.$query->__toString(), JLog::ERROR, 'com_emundus');
			    JError::raiseError(500, $query);
		    }
	        break;

		// If the applicant can only have one file per campaign.
		case 2:
			$query->clear()->select($db->quoteName('campaign_id'))
				->from($db->quoteName('#__emundus_campaign_candidature'))
				->where($db->quoteName('applicant_id').' = '.$user_id);
			$db->setQuery($query);

			try {
				if (in_array($campaign_id, $db->loadColumn())) {
					JLog::add('User: '.$user_id.' already has a file for campaign id: '.$campaign_id, JLog::ERROR, 'com_emundus');
					$application->enqueueMessage(JText::_('COM_EMUNDUS_USER_ALREADY_SIGNED_UP'), 'error');
					continue 2;
				}
			} catch (Exception $e) {
				JLog::add('plugin/emundus_campaign SQL error at query : '.$query->__toString(), JLog::ERROR, 'com_emundus');
			}
			break;

	    // If the applicant can only have one file per school year.
		case 3:
			$years_query = 'SELECT id
						FROM #__emundus_setup_campaigns
						WHERE published = 1
						AND end_date >= NOW()
						AND start_date <= NOW()
						AND year NOT IN (
							select sc.year
							from #__emundus_campaign_candidature as cc
							LEFT JOIN #__emundus_setup_campaigns as sc ON sc.id = cc.campaign_id
							where applicant_id='. $user_id.'
						)';
			$db->setQuery($years_query);

			try {
				if (!in_array($campaign_id, $db->loadColumn())) {
					JLog::add('User: '.$user_id.' already has a file for year belong to campaign: '.$campaign_id, JLog::ERROR, 'com_emundus');
					$application->enqueueMessage('User already has a file for this year.', 'error');
					continue 2;
				}
			} catch (Exception $e) {
				JLog::add('plugin/emundus_campaign SQL error at query :'.$years_query, JLog::ERROR, 'com_emundus');
			}
			break;

		default:
			break;
	}


	if (!empty($company_id) && $company_id != -1) {
		require_once (JPATH_BASE.DS.'components'.DS.'com_emundus'.DS.'models'.DS.'formations.php');
		$m_formations = new EmundusModelFormations();

		// Check that the user is in a company that we can add fnums to.
		if (!$m_formations->checkHRUser($current_user->id, $user_id)) {
			JLog::add('User: '.$current_user->id.' does not have the rights to add this user: '.$user_id, JLog::ERROR, 'com_emundus');
			$application->enqueueMessage(JTEXT::_('COM_EMUNDUS_NO_RIGHTS_TO_REGISTER'), 'error');
			continue;
		}

		// Check that the user is in the company we are adding the fnum for.
		if (!$m_formations->checkCompanyUser($user_id, $company_id)) {
			JLog::add('User: '.$user_id.' is not in the company: '.$company_id, JLog::ERROR, 'com_emundus');
			$application->enqueueMessage(JTEXT::_('COM_EMUNDUS_USER_NOT_IN_COMPANY'), 'error');
			continue;
		}
	}

	// Generate new fnum
	$fnum = date('YmdHis').str_pad($campaign_id, 7, '0', STR_PAD_LEFT).str_pad($user_id, 7, '0', STR_PAD_LEFT);

	// Build values to insert into the table.
	if (!empty($company_id) && $company_id != -1) {
		$values[] = $user_id.', '.$current_user->id.', '.$campaign_id.', '.$db->quote($fnum).', '.$company_id;
	} else {
		$values[] = $user_id.', '.$current_user->id.', '.$campaign_id.', '.$db->quote($fnum);
	}

	// give the user all rights on that file
    $rights_values[] = $current_user->id.', 1, '.$db->quote($fnum).', 1, 1, 1, 1';

	// build profiles to assign.
	$profile_values[] = $user_id.', '.$profile;
}


if (!empty($profile_values)) {
	// Insert data in #__emundus_users_profiles
	$query->clear()
		->insert($db->quoteName('#__emundus_users_profiles'))
		->columns($db->quoteName(['user_id','profile_id']))
		->values($profile_values);
	$db->setQuery($query);
	try {
		$db->execute();
	} catch(Exception $e) {
		JLog::add(JUri::getInstance().' :: USER ID : '.$current_user->id.' -> '.$query->__toString(), JLog::ERROR, 'com_emundus');
		JError::raiseError(500, 'Could not assign profiles to users.');
	}
}

if (!empty($values)) {
	// Prepare query used for multiline insert.
	$columns = ['applicant_id', 'user_id', 'campaign_id', 'fnum'];
	if (!empty($company_id) && $company_id != -1) {
		$columns[] = 'company_id';
	}

	$cc_ids = [];
	foreach ($values as $value) {
		// Insert rows into the CC table.
		$query->clear()
			->insert($db->quoteName('#__emundus_campaign_candidature'))
			->columns($db->quoteName($columns))
			->values($value);
		$db->setQuery($query);

		try {
			$db->execute();
			$cc_ids[] = $db->insertid();
		} catch(Exception $e) {
			JLog::add('Error inserting candidatures in plugin/emundus-campaign-multi in query: '.$query->__toString(), JLog::ERROR, 'com_emundus');
			JError::raiseError(500, 'Could not create candidatures.');
		}
	}
}

if (!empty($rights_values)) {
	// Prepare query used for multiline insert.
	$columns = ['user_id', 'action_id', 'fnum', 'c', 'r', 'u', 'd'];

	// Insert rows into the em_user_assoc table.
	$query->clear()
	    ->insert($db->quoteName('#__emundus_users_assoc'))
	    ->columns($columns)
	    ->values($rights_values);
	$db->setQuery($query);
	try {
	    $db->execute();
	} catch(Exception $e) {
	    JLog::add('Error inserting rights in plugin/emundus-campaign-multi in query: '.$query->__toString(), JLog::ERROR, 'com_emundus');
	    JError::raiseError(500, 'Could not create rights.');
	}

    $application->enqueueMessage(JText::_('CAMPAIGN_MULTI_SUCCESS'), 'message');
}


// Now that the main CC logic is done, we need to generate the .log file which will be written to the FTP directory to be used by Migal in order ot import the data into GesCOF.
// This is a bit tricky, we need to get the information about the inscription as well as the users, all in one single dimentional array, .log files do not have multiple lines.
$query->clear()
	->select([$db->quoteName('cc.id','IdResa'), $db->quoteName('tu.session_code', 'NumSession'), $db->quoteName('eu.lastname', 'Societe_Lib'), $db->quoteName('eu.telephone', 'TelSociete'), $db->quoteName('eu.email', 'EmailContact'), $db->quoteName('eu.telephone', 'TelContact'), $db->quoteName('eu.firstname'), $db->quoteName('eu.civility'), $db->quoteName('tu.days', 'Nbjours'), $db->quoteName('location_title', 'Lieuforma'), $db->quoteName('cc.date_time', 'dateresa'), $db->quoteName('eu.adresse', 'SocieteAdresse1'), $db->quoteName('eu.code_postale', 'SocieteCP'), $db->quoteName('eu.city', 'SocieteVille')])
	->from($db->quoteName('#__emundus_campaign_candidature', 'cc'))
	->leftJoin($db->quoteName('#__emundus_setup_campaigns', 'c').' ON '.$db->quoteName('cc.campaign_id').' = '.$db->quoteName('c.id'))
	->leftJoin($db->quoteName('#__emundus_setup_teaching_unity', 'tu').' ON '.$db->quoteName('c.session_code').' = '.$db->quoteName('tu.session_code'))
	->leftJoin($db->quoteName('#__emundus_users', 'eu').' ON '.$db->quoteName('cc.user_id').' = '.$db->quoteName('eu.user_id'))
	->where($db->quoteName('cc.id').' = '.$cc_ids[0]);
$db->setQuery($query);

try {
	$inscription = $db->loadAssoc();
} catch (Exception $e) {
	return false;
}

if (empty($inscription)) {
	return false;
}

$query->clear()
	->select([$db->quoteName('eu.lastname'), $db->quoteName('eu.firstname'), $db->quoteName('eu.telephone'), $db->quoteName('eu.civility'), $db->quoteName('ent.position'), $db->quoteName('eu.email')])
	->from($db->quoteName('#__emundus_campaign_candidature', 'cc'))
	->leftJoin($db->quoteName('#__emundus_users', 'eu').' ON '.$db->quoteName('cc.applicant_id').' = '.$db->quoteName('eu.user_id'))
	->leftJoin($db->quoteName('#__emundus_user_entreprise', 'ent').' ON '.$db->quoteName('ent.user').' = '.$db->quoteName('eu.user_id').' AND '.$db->quoteName('ent.cid').' = '.$db->quoteName('cc.company_id'))
	->where($db->quoteName('cc.id').' IN ('.implode(',',$cc_ids).')');
$db->setQuery($query);

try {
	$users_registered = $db->loadAssocList();
} catch (Exception $e) {
	return false;
}

// We need to make any programmatic changes to data before import.
// If the person is signed up under a company, that's the societe, if they are alone, it's themselves.
if (!empty($company_id) && $company_id != -1) {

	$query->clear()
		->select([$db->quoteName('raison_sociale'), $db->quoteName('telephone'), $db->quoteName('civility'), $db->quoteName('prenom'), $db->quoteName('nom'), $db->quoteName('email'), $db->quoteName('adresse'), $db->quoteName('code_postal'), $db->quoteName('ville'), $db->quoteName('fonction')])
		->from($db->quoteName('#__emundus_entreprise'))
		->where($db->quoteName('id').' = '.$company_id);
	$db->setQuery($query);

	try {
		$company = $db->loadAssoc();
	} catch (Exception $e) {
		return false;
	}

	// Assign the company values as ovverides to the user values. This preserves the order of the array as well.
	$inscription['Societe_Lib'] = $company['raison_sociale'];
	$inscription['TelSociete'] = $company['telephone'];
	$inscription['Contact'] = strtoupper($company['nom']).'/'.ucfirst(strtolower($company['prenom'])).'#'.strtoupper($company['civility']);
	$inscription['TelContact'] = $company['telephone'];
	$inscription['EmailContact'] = $company['email'];
	$inscription['SocieteAdresse1'] = $company['adresse'];
	$inscription['SocieteCP'] = $company['code_postal'];
	$inscription['SocieteVille'] = $company['ville'];

} else {
	$inscription['Societe_Lib'] = $inscription['Societe_Lib'].' '.$inscription['firstname'];
	$inscription['Contact'] = strtoupper($inscription['Societe_Lib']).'/'.ucfirst(strtolower($inscription['firstname'])).'#'.strtoupper($inscription['civility']);
}

// We need to add the participants now, this is done by breaking down the array and adding the corresponding data in its' place.
$participants = [];
for ($i = 0; $i <= 10; $i++) {

	// TODO: We do not have the numeroStagiaire, how do we get it ?
	$participants['NumParticipant_'.($i+1)] = '';

	if (!empty($users_registered[$i]['lastname']) && !empty($users_registered[$i]['firstname'])) {

		// This is because the civilities actually need to be the IDs found in gesCOF for retro-compatibility reasons.
		if ($users_registered[$i]['civility'] == 'M') {
			$civility = 1;
		} elseif (strtoupper($users_registered[$i]['civility']) == 'MME') {
			// TODO: Verify if MME = 2 or 3.
			$civility = 2;
		} else {
			$civility = '';
		}

		$participants['NomParticipant_'.($i+1).'/PrenomParticipant_'.($i+1).'#TitreParticipant_'.($i+1)] = strtoupper($users_registered[$i]['lastname']).'/'.ucfirst(strtolower($users_registered[$i]['firstname'])).'#'.$civility;
		$participants['EmailParticipant_'.($i+1)] = $users_registered[$i]['email'];
		$participants['FonctionParticipant_'.($i+1)] = $users_registered[$i]['position'];
	} else {
		$participants['NomParticipant_'.($i+1).'/PrenomParticipant_'.($i+1).'#TitreParticipant_'.($i+1)] = '';
		$participants['EmailParticipant_'.($i+1)] = '';
		$participants['FonctionParticipant_'.($i+1)] = '';
	}

	$participants['NumcParticipant_'.($i+1)] = '';
}

/*
 * This is the formatting of the export file so that it has the same format as the .log file.
 * Some precisions: the type of internship is INTRA, for now?
 */
$export = [
	'IdResa' => $inscription['IdResa'],
	'NumSession' => $inscription['NumSession'],
	'DossierCom' => '',
	'InitialesCom' => '',
	'societe' => '',
	'Societe_Lib' => $inscription['Societe_Lib'],
	'TelSociete' => $inscription['TelSociete'],
	'Contact' => $inscription['Contact'],
	'TelContact' => $inscription['TelContact'],
	'EmailContact' => $inscription['EmailContact'],
	'Typestage' => 'INTER',
	'Nbjours' => $inscription['Nbjours'],
	'Lieuforma' => $inscription['Lieuforma'],
	'Budgetglobal' => '',
	'Dateprevis' => date('Y-m-d H:i:s'),
	'Pourcentage' => '',
	'Observation' => '',
	'Nbparticipant' => count($users_registered)
];
$export = array_merge($export, $participants);
$export = array_merge($export, [
	'dateresa' => date('Y-m-d H:i:s'),
	'PaimentEnLigne' => '',
	'PaiementEnLigneDate' => '',
	'PaiementEnLigneRef' => '',
	'FaxSociete' => '',
	'SocieteAdresse1' => $inscription['SocieteAdresse1'],
	'SocieteAdresse2' => '',
	'SocieteAdresse3' => '',
	'SocieteCP' => $inscription['SocieteCP'],
	'SocieteVille' => $inscription['SocieteVille'],
	'SocietePays' => '',
	'FaxContact' => '',
	'FonctionContact' => isset($company['fonction'])?$company['fonction']:'',
	'NumFinanceur' => '',
	'FiRS' => '',
	'FiAdresse1' => '',
	'FiAdresse2' => '',
	'FiAdresse3' => '',
	'FiCP' => '',
	'FiVille' => '',
	'FiPays' => '',
	'FiTel' => '',
	'FiFax' => ''
]);

// The Migal file has a LOT of lines such as PersoParticipantX_X which I don't think are useful.
// We are padding the array with some empty strings to get it to the right length, I don't know if that's useful but hey... why not ¯\_(ツ)_/¯
$export = array_pad($export, 178, '');

// Log file is named using today's date and a unique ID.
$log_file_name = DS.'datas'.DS.'xml'.DS.'export'.DS.'inscription'.DS.uniqid(date('Y-m-d-H-i-s').'-').'.log';
ob_start();
$df = fopen($log_file_name, 'w');
fputcsv($df, $export , ';');
fclose($df);
ob_get_clean();
