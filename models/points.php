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

class DjclassifiedsModelPoints extends JModelLegacy{		
	
	function getPoints(){
			$db= JFactory::getDBO();
			$user = JFactory::getUser();
			$g_list = '0';
			if($user->groups){
				$g_list = implode(',',$user->groups);	
			}									
			if (!$g_list){
				$g_list = '0';
			}
				
			$query = "SELECT p.* ,g.g_active, ga.g_all FROM #__djcf_points p "
					."LEFT JOIN (SELECT COUNT(id) as g_active, points_id FROM #__djcf_points_groups g " 
				   				."WHERE group_id in(".$g_list.") GROUP BY points_id ) g ON g.points_id=p.id "
				   	."LEFT JOIN (SELECT COUNT(id) as g_all, points_id FROM #__djcf_points_groups g " 
				   				." GROUP BY points_id ) ga ON ga.points_id=p.id "
					."WHERE p.published=1 AND (g.g_active>0 OR ga.g_all IS NULL) "
					."ORDER BY p.ordering ";
	
			$db->setQuery($query);
			$points=$db->loadObjectList();
			//echo '<pre>';print_r($db);print_r($points);die();
	
			return $points;
	}
		
	
}

