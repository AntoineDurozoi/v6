<?php
/**
 * ControlCenter View para el Componente Securitycheckpro
 * @ author Jose A. Luque
 * @ Copyright (c) 2011 - Jose A. Luque
 *
 * @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

// Protect from unauthorized access
defined('_JEXEC') or die('Restricted Access');

class SecuritycheckprosViewControlCenter extends SecuritycheckproView
{
    
    protected $state;

    function __construct()
    {
        parent::__construct();    
    }

    /**
     Securitycheckpros view m�todo 'display'
     **/
    function display($tpl = null)
    {

        JToolBarHelper::title(JText::_('Securitycheck Pro').' | ' .JText::_('COM_SECURITYCHECKPRO_CPANEL_CONTROLCENTER_TEXT'), 'securitycheckpro');

        // Obtenemos el modelo
        $model = $this->getModel();

        //  Par�metros del plugin
        $items= $model->getControlCenterConfig();

        // Informaci�n para la barra de navegaci�n
        $logs_pending = $model->LogsPending();
        $trackactions_plugin_exists = $model->PluginStatus(8);
        $this->logs_pending = $logs_pending;
        $this->trackactions_plugin_exists = $trackactions_plugin_exists;

        // Extraemos los elementos que nos interesan...
        $control_center_enabled= null;
        $secret_key= null;


        if (!is_null($items['control_center_enabled'])) {
            $control_center_enabled = $items['control_center_enabled'];    
        }

        if (!is_null($items['secret_key'])) {
            $secret_key = $items['secret_key'];    
        }

        // ... y los ponemos en el template
        $this->control_center_enabled = $control_center_enabled;
        $this->secret_key = $secret_key;


        parent::display($tpl);
    }
}