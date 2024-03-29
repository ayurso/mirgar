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

class DjclassifiedsModelRegistration extends JModelLegacy{	
	
	function getTermsLink($id){
			$db= JFactory::getDBO();
			$query = "SELECT a.id, a.alias, a.catid, c.alias as c_alias FROM #__content a "
					."LEFT JOIN #__categories c ON c.id=a.catid "
					."WHERE a.state=1 AND a.id=".$id;
			
			$db->setQuery($query);
			$article=$db->loadObject();
			
			return $article;	
	}



	
	function getCustomContactFields(){
		global $mainframe;
		$par 	= JComponentHelper::getParams( 'com_djclassifieds' );
		$db 	= JFactory::getDBO();
		$user 	= JFactory::getUser();		
		
		$query ="SELECT f.* FROM #__djcf_fields f "
				."WHERE f.published=1 AND f.source=2 AND f.in_registration=1 AND f.group_id=0 ORDER BY f.ordering";
		$db->setQuery($query);
		$fields_list =$db->loadObjectList();
		//echo '<pre>'; print_r($db);print_r($fields_list);die();
			
		return $fields_list;
		
	}	
	
	

	function getCustomFieldsGroups(){
		global $mainframe;
		$par 	= JComponentHelper::getParams( 'com_djclassifieds' );
		$db 	= JFactory::getDBO();
		$user 	= JFactory::getUser();
	
		$query ="SELECT g.* FROM #__djcf_fields_groups g "
				."WHERE g.source=2 ORDER BY g.ordering";
				$db->setQuery($query);
				$fields_list =$db->loadObjectList();
				//echo '<pre>'; print_r($db);print_r($fields_list);die();
					
				return $fields_list;
	}	
	
}

