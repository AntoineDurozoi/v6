<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2016 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

JLoader::import('components.com_dpcalendar.helpers.dpcalendar', JPATH_ADMINISTRATOR);
if (! class_exists('DPCalendarHelper'))
{
	return;
}

JLoader::import('joomla.application.component.model');
JModelLegacy::addIncludePath(JPATH_SITE . DS . 'components' . DS . 'com_dpcalendar' . DS . 'models', 'DPCalendarModel');

$model = JModelLegacy::getInstance('Calendar', 'DPCalendarModel');
$model->getState();
$model->setState('filter.parentIds', $params->get('ids', array(
		'root'
)));
$ids = array();
foreach ($model->getItems() as $calendar)
{
	$ids[] = $calendar->id;
}
$params->set('ids', $ids);

require JModuleHelper::getLayoutPath('mod_dpcalendar_map', $params->get('layout', 'default'));
