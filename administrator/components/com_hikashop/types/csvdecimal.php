<?php
/**
 * @package	HikaShop for Joomla!
 * @version	3.2.2
 * @author	hikashop.com
 * @copyright	(C) 2010-2018 HIKARI SOFTWARE. All rights reserved.
 * @license	GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
defined('_JEXEC') or die('Restricted access');
?><?php
class hikashopCsvDecimalType{
	function load(){
		$this->values = array();
		$this->values[] = JHTML::_('select.option', ',',JText::_('COMMA'));
		$this->values[] = JHTML::_('select.option', '.',JText::_('DOT'));
	}
	function display($map,$value){
		$this->load();
		return JHTML::_('select.genericlist',   $this->values, $map, 'class="inputbox" size="1"', 'value', 'text', $value );
	}
}
