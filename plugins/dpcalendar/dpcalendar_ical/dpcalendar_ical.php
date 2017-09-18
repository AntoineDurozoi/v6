<?php
/**
 * @package    DPCalendar
 * @author     Digital Peak http://www.digital-peak.com
 * @copyright  Copyright (C) 2007 - 2016 Digital Peak. All rights reserved.
 * @license    http://www.gnu.org/licenses/gpl.html GNU/GPL
 */
defined('_JEXEC') or die();

JLoader::import('components.com_dpcalendar.libraries.dpcalendar.syncplugin', JPATH_ADMINISTRATOR);
if (! class_exists('DPCalendarSyncPlugin'))
{
	return;
}

class PlgDPCalendarDPCalendar_Ical extends DPCalendarSyncPlugin
{

	protected $identifier = 'i';
}
