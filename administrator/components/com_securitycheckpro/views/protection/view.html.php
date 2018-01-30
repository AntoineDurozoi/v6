<?php
/**
* Protection View para el Componente Securitycheckpro
* @ author Jose A. Luque
* @ Copyright (c) 2011 - Jose A. Luque
* @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
*/

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

// Load framework base classes
jimport('joomla.application.component.view');

class SecuritycheckprosViewProtection extends JViewLegacy
{
protected $state;

/**
* Securitycheckpros view m�todo 'display'
**/
function display($tpl = null)
{

JToolBarHelper::title( JText::_( 'Securitycheck Pro' ).' | ' .JText::_('COM_SECURITYCHECKPRO_CPANEL_HTACCESS_PROTECTION_TEXT'), 'securitycheckpro' );
// Si existe el fichero .htaccess, mostramos la opci�n para borrarlo.
// Obtenemos el modelo
$model = $this->getModel();
// ... y el tipo de servidor web
$mainframe = JFactory::getApplication();
$server = $mainframe->getUserState("server",'apache');

if ( ($server == 'apache') || ($server == 'iis') ) {
	if ( $model->ExistsFile('.htaccess.original') ) {
		JToolBarHelper::custom('restore_htaccess','redo-2','redo-2','COM_SECURITYCHECKPRO_RESTORE_HTACCESS');
	}
	if ( $model->ExistsFile('.htaccess') ) {
		JToolBarHelper::custom('delete_htaccess','file-remove','file-remove','COM_SECURITYCHECKPRO_DELETE_HTACCESS');
	}
	JToolBarHelper::custom('protect','key','key','COM_SECURITYCHECKPRO_PROTECT');
} else if ( $server == 'nginx' ) {
	JToolBarHelper::custom('generate_rules','key','key','COM_SECURITYCHECKPRO_GENERATE_RULES');
}

JToolBarHelper::apply();

// Obtenemos la configuraci�n actual...
$config = $model->getConfig();
// ... y la que hemos aplicado en el fichero .htaccess existente
$config_applied = $model->GetconfigApplied();

$this->assign('protection_config', $config);
$this->assign('config_applied', $config_applied);
$this->assign('ExistsHtaccess',	$model->ExistsFile('.htaccess'));
$this->assignRef('server', $server);

// Extraemos informaci�n necesaria 
require_once JPATH_ROOT.'/administrator/components/com_securitycheckpro/library/model.php';
$common_model = new SecuritycheckproModel();

$logs_pending = $common_model->LogsPending();
$trackactions_plugin_exists = $common_model->PluginStatus(8);
$this->assignRef('logs_pending', $logs_pending);
$this->assignRef('trackactions_plugin_exists', $trackactions_plugin_exists);	

parent::display($tpl);
}
}