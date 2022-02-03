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

class DjclassifiedsModelCheckout extends JModelLegacy{	
	
	function getItem($id){
		$db   = JFactory::getDBO();
		$app  = JFactory::getApplication();		
		$date_now = date("Y-m-d H:i:s");
		$quantity = JRequest::getInt('quantity', 0);
		$query ="SELECT i.*, c.name as c_name, c.alias as c_alias, r.name as r_name FROM #__djcf_items i "
			   ."LEFT JOIN #__djcf_categories c ON c.id=i.cat_id "
			   ."LEFT JOIN #__djcf_regions r ON r.id=i.region_id "
			   ."WHERE i.id=".$id." AND i.published=1 AND c.published=1 AND i.date_start <= '".$date_now."' AND i.date_exp >= '".$date_now."' LIMIT 1";
		$db->setQuery($query);
		$item = $db->loadObject();

		if(!$item){
			$redirect=DJClassifiedsSEO::getCategoryRoute('0:all');
			$message = JText::_("COM_DJCLASSIFIEDS_ITEM_NOT_AVAILABLE");
			$redirect = JRoute::_($redirect,false);
			$app->redirect($redirect,$message);
		}else if($quantity>$item->quantity){
			$redirect = DJClassifiedsSEO::getItemRoute($item->id.':'.$item->alias,$item->cat_id.':'.$item->c_alias);
			$message = JText::_("COM_DJCLASSIFIEDS_NUMBER_OF_PRODUCTS_IS_LESS_THEN_SELECTED");
			$redirect = JRoute::_($redirect,false);
			$app->redirect($redirect,$message);
		}
		
		return $item;
	}	
	
	
	function getItemOptions($id,$opt_id){
		$db   = JFactory::getDBO();
		$app  = JFactory::getApplication();

			$query ="SELECT f.* FROM #__djcf_fields_values_sale f "
					."WHERE f.id=".$opt_id." AND f.item_id =".$id." ORDER BY f.id";
			$db->setQuery($query);
			$item_opt =$db->loadObject();
			
			$opt_name = '';
			if($item_opt){
				$options = json_decode($item_opt->options);							
				foreach($options as $o){
					if($opt_name){ $opt_name .= ' - ';}
					$opt_name .= $o->label.': '.$o->value;
				}
			}
									
		return $opt_name;
	}
	
	
	
}

