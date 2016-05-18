<?php

/**
 * @version     1.0.0
 * @package     com_emundus
 * @copyright   Copyright (C) 2016 emundus.fr. Tous droits réservés.
 * @license     GNU General Public License version 2 ou version ultérieure ; Voir LICENSE.txt
 * @author      emundus <dev@emundus.fr> - http://www.emundus.fr
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Ametys controller class.
 */
class EmundusControllerAmetys extends EmundusController {

    /**
     * Method to display tools.
     *
     * @return  void
     * @since   1.6
     */
    function display(){
        // Set a default view if none exists
        if ( ! JRequest::getCmd( 'view' ) ){
            $default = 'default';
            JRequest::setVar('view', $default );
        }
        parent::display();
    }   

}
