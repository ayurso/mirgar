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

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');


class DJClassifiedsControllerSearchAlerts extends JControllerLegacy {
	
	function addSearch(){
		
		$app	= JFactory::getApplication();	
		$uri	= JRequest::getVar('url');
		$db 	= JFactory::getDBO();
		$user 	= JFactory::getUser();
		$par 	= JComponentHelper::getParams( 'com_djclassifieds' );
	    $date_now = date("Y-m-d H:i:s");
		
		$uri_d = base64_decode($uri);
		$u = JURI::getInstance( $uri_d );
		$uri_a = json_encode($u->getQuery( true ));
		
		if($user->id >0){
			$db = & JFactory::getDBO();
		 	$query="INSERT INTO #__djcf_search_alerts (`user_id`, `search_url`, `search_query`, `created` , `last_check`) "
				  ." VALUES ( '".$user->id."', '".addslashes($uri)."', '".addslashes($uri_a)."','".$date_now."','".$date_now."')";
			$db->setQuery($query);
			$db->query();															
			$msg = JText::_('COM_DJCLASSIFIEDS_SEARCH_RESULTS_ADDED_TO_SAVED');							
		}else{				
			$uri_r = 'index.php?option=com_djclassifieds&view=searchalerts&task=addSearch&url='.$uri.'';
			$login_url = JRoute::_('index.php?option=com_users&view=login&return='.base64_encode($uri_r),false);
			$app->redirect($login_url,JText::_('COM_DJCLASSIFIEDS_PLEASE_LOGIN'));
		}
		
		
		$follow_url = 'index.php?option=com_djclassifieds&view=searchalerts';
					
		$menus	= $app->getMenu('site');
		$menu_sf = $menus->getItems('link','index.php?option=com_djclassifieds&view=searchalerts',1);						  
	    if($menu_sf){
			$follow_url .= '&Itemid='.$menu_sf->id;
	    }
		
		$link = JRoute::_($follow_url,false);
		$app->redirect($link,$msg,$m_type);	
	}

	function deleteSearch(){
		$app	= JFactory::getApplication();	
		$id		= JRequest::getInt('id', 0);
		$db 	= JFactory::getDBO();
		$user 	= JFactory::getUser();
		$itemid	= JRequest::getVar('Itemid');
		$par 	= JComponentHelper::getParams( 'com_djclassifieds' );		
		
		$m_type = '';		
		//if($par->get('favourite','1')){				
			if($user->id >0){										
				$query="DELETE FROM #__djcf_search_alerts WHERE id=".$id." AND user_id=".$user->id." ";
				$db->setQuery($query);
				$db->query();
				
				$msg = JText::_('COM_DJCLASSIFIEDS_SEARCH_RESULTS_REMOVED_FROM_SAVED');							
			}else{				
		     	$msg = JText::_('COM_DJCLASSIFIEDS_PLEASE_LOGIN');
				$m_type= 'error';
			}
		//}else{
		 //   $msg = JText::_('COM_DJCLASSIFIEDS_FUNCTION_NOT_AVAILABLE');
		//	$m_type= 'error';
		//}
		
		$link = 'index.php?option=com_djclassifieds&view=searchalerts&Itemid='.$itemid;
		$link = JRoute::_($link,true);
		$app->redirect($link,$msg,$m_type);	
	}
	
}

?>