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

class DjclassifiedsModelUserPoints extends JModelLegacy{	
	
	function getPoints(){
		
		$par 		= JComponentHelper::getParams( 'com_djclassifieds' );
		$limit		= JRequest::getVar('limit', $par->get('limit_djitem_show'), '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
		$user 		= JFactory::getUser();			 
		$order		= JRequest::getCmd('order', $par->get('items_ordering','date_e'));
		$ord_t 		= JRequest::getCmd('ord_t', $par->get('items_ordering_dir','desc'));
			
			$ord="p.date ";
			
			if($order=="points"){
				$ord="p.points ";
			}				
		
			if($ord_t == 'desc'){
				$ord .= 'DESC';
			}else{
				$ord .= 'ASC';
			}
			
			$query = "SELECT p.* FROM #__djcf_users_points p "
					."WHERE p.user_id='".$user->id."' "
					."ORDER BY  ".$ord."";
		
			$points = $this->_getList($query, $limitstart, $limit);	
			
				//$db= JFactory::getDBO();$db->setQuery($query);$points=$db->loadObjectList();
				//echo '<pre>';print_r($db);print_r($points);echo '<pre>';die();	
			return $points;
	}
	
	function getCountPoints(){
					
			$user = JFactory::getUser();
			$query = "SELECT count(p.id)FROM #__djcf_users_points p "
					."WHERE p.user_id='".$user->id."' ";				
						
				$db= JFactory::getDBO();
				$db->setQuery($query);
				$points_count=$db->loadResult();
				
				//echo '<pre>';print_r($db);print_r($points_count);echo '<pre>';die();	
			return $points_count;
	}	
	
	function getUserPoints(){
					
			$user = JFactory::getUser();
			$query = "SELECT SUM(p.points)FROM #__djcf_users_points p "
					."WHERE p.user_id='".$user->id."' ";				
						
				$db= JFactory::getDBO();
				$db->setQuery($query);
				$points_count=$db->loadResult();
				
				if(!$points_count){
					$points_count = 0;
				}
				
				//echo '<pre>';print_r($db);print_r($points_count);echo '<pre>';die();	
			return $points_count;
	}	
	
}

