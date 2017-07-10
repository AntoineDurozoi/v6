<?php
/**
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

defined('_JEXEC') or die;

require_once dirname(__FILE__).'/helper.php';

$user = JFactory::getUser();

// Añadido ACL (Si se deniega el acceso a la administración de Securitycheck Pro el módulo no será mostrado)
if ( $user->authorise('core.manage','com_securitycheckpro') ){
	$buttons = modScpadminQuickIconsHelper::getButtons($params);
	require JModuleHelper::getLayoutPath('mod_scpadmin_quickicons', $params->get('layout', 'default'));
}