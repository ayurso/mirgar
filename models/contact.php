<?php
/**
* @version 2.0
* @package MIRGAR
* @copyright Copyright (C) 2020 mirgar.ga LTD, All rights reserved.
* @license http://www.gnu.org/licenses GNU/GPL
* @author url: https://mirgar.ga
* @author email mirgarmon@ya.ru
* компонент "Обращения" для Joomla3 
*/
defined ('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

JTable::addIncludePath(JPATH_COMPONENT.DS.'tables');

class DjclassifiedsModelContact extends JModelLegacy{	
	
	function getItem(){
		$app	= JFactory::getApplication();
		$id 	= JRequest::getInt('id', 0);
		$db		= JFactory::getDBO();

			$query = "SELECT i.* FROM #__djcf_items i "
					."WHERE i.id= ".$id." LIMIT 1 ";
	
			$db->setQuery($query);
			$item=$db->loadObject();
	
		return $item;
	}
	
	function getBid(){
		$app	= JFactory::getApplication();
		$bid 	= JRequest::getInt('bid', 0);
		$id 	= JRequest::getInt('id', 0);
		$db		= JFactory::getDBO();
	
		$query = "SELECT a.* FROM #__djcf_auctions a "
				."WHERE a.id= ".$bid." AND a.item_id= ".$id." LIMIT 1 ";
	
		$db->setQuery($query);
		$bid=$db->loadObject();
	
		return $bid;
	}
	
	
}

