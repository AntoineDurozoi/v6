<?php
/**
 * @package     Joomla
 * @subpackage  com_emundus_onboard
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$document = JFactory::getDocument();
$document->addScript('media/com_emundus_onboard/chunk-vendors.js');
$document->addStyleSheet('media/com_emundus_onboard/app.css');

JText::script('COM_EMUNDUS_ONBOARD_FROM');
JText::script('COM_EMUNDUS_ONBOARD_TO');
JText::script('COM_EMUNDUS_ONBOARD_SINCE');
JText::script('COM_EMUNDUS_ONBOARD_MODIFY');
JText::script('COM_EMUNDUS_ONBOARD_CAMPAIGN');
JText::script('COM_EMUNDUS_ONBOARD_CHOOSE_FORM');
JText::script('COM_EMUNDUS_ONBOARD_CHOOSE_EVALUATOR_GROUP');
JText::script('COM_EMUNDUS_ONBOARD_CHOOSE_EMAIL_TRIGGER');
JText::script('COM_EMUNDUS_ONBOARD_CHOOSE_EVALUATION_GRID');
JText::script('COM_EMUNDUS_ONBOARD_ADD_RETOUR');
JText::script('COM_EMUNDUS_ONBOARD_ADD_CONTINUER');
JText::script('COM_EMUNDUS_ONBOARD_ADDCAMP_STARTDATE');
JText::script('COM_EMUNDUS_ONBOARD_FORMDESCRIPTION');
JText::script('COM_EMUNDUS_ONBOARD_ADDCAMP_ENDDATE');
JText::script('CREATE');
JText::script('RETRIEVE');
JText::script('UPDATE');
JText::script('DELETE');

$lang = JFactory::getLanguage();
$actualLanguage = substr($lang->getTag(), 0, 2);


?>

<div id="em-addForm-vue" form="<?= $this->id ?>" actualLanguage="<?= $actualLanguage ?>"></div>

<script src="media/com_emundus_onboard/app.js"></script>
