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

class DjclassifiedsModelProfileEdit extends JModelLegacy{	
	
	function getProfile()
	{
		$app	= JFactory::getApplication();
		$row 	= JTable::getInstance('Profiles', 'DJClassifiedsTable');		
		$db		= JFactory::getDBO();
		$user	= JFactory::getUser();
		
		if($user->id){
			$row->load($user->id);
		}
		
		//echo '<pre>';print_r($row);die();
	
		return $row;
	}
	
	function getCustomFields($profile){
		$par 	= JComponentHelper::getParams( 'com_djclassifieds' );
		$db 	= JFactory::getDBO();
		$user 	= JFactory::getUser();		
		
		$w_groups = ' AND f.group_id=0 ';
		if($profile->group_id){
			$w_groups = ' AND (f.group_id=0 OR f.group_id='.$profile->group_id.')';
		}
		
		$query ="SELECT f.*, v.value, v.value_date, v.value_date_to FROM #__djcf_fields f "
				."LEFT JOIN (SELECT * FROM #__djcf_fields_values_profile WHERE user_id=".$user->id.") v "
						."ON v.field_id=f.id "
				."WHERE f.published=1 AND f.source=2 AND f.edition_blocked=0 ".$w_groups." "
				."ORDER BY f.ordering";
		$db->setQuery($query);
		$fields_list =$db->loadObjectList();
		//echo '<pre>'; print_r($db);print_r($fields_list);die();
			
		return $fields_list;
		
	}	
	
	function getCustomValuesCount(){
		$db 	= JFactory::getDBO();
		$user 	= JFactory::getUser();
		
		$query ="SELECT count(id) FROM #__djcf_fields_values_profile WHERE user_id=".$user->id;
		$db->setQuery($query);
		$values_c =$db->loadResult();
			
		return $values_c;		
	}
	

	function getProfileImage(){		
		$db= JFactory::getDBO();
		$user 	= JFactory::getUser();
		
			$query = "SELECT * FROM #__djcf_images WHERE item_id=".$user->id." AND type='profile' ORDER BY ordering LIMIT 1";
			$db->setQuery($query);
			$image=$db->loadObject();
	
		return $image;
	}
	
	function getRegions(){
		$db	= JFactory::getDBO();
		$query = "SELECT r.* FROM #__djcf_regions r "
				."WHERE r.published=1 "
				."ORDER BY r.parent_id, r.name COLLATE utf8_polish_ci ";
	
				$db->setQuery($query);
				$regions=$db->loadObjectList();
	
				return $regions;
	}
	
	
}

