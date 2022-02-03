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

class DjclassifiedsModelCategories extends JModelLegacy{	
	
		function getParams() {
		if (!isset($this->_params)) {
			$params = JComponentHelper::getParams( 'com_djclassifieds' );
			$app	= JFactory::getApplication();
			$mparams = ($app->getParams()); 
			$params->merge($mparams);
			$this->_params = $params;
		}
		return $this->_params;
	}	
	
	function getCatImages(){
		$db= JFactory::getDBO();
		$query = "SELECT * FROM #__djcf_images WHERE type='category' GROUP BY item_id ";
		$db->setQuery($query);
		$cat_img=$db->loadObjectList('item_id');
		//echo '<pre>';print_r($db);print_r($cat_img);die();
		return $cat_img;
	}
	
}

