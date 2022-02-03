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

class DjclassifiedsModelRenewItem extends JModelLegacy{	

	function getItem()
	{
		$app	= JFactory::getApplication();
		$id 	= JRequest::getVar('id', 0, '', 'int' );	       
        $row 	= JTable::getInstance('Items', 'DJClassifiedsTable');
		if($id>0){						
			$user=JFactory::getUser();			
			$row->load($id);
			
			if($user->id!=$row->user_id || $user->id==0){
				$message = JText::_("COM_DJCLASSIFIEDS_WRONG_AD");
				$redirect= 'index.php?option=com_djclassifieds&view=additem' ;
				$app->redirect($redirect,$message,'error');		
			}
		}
	  	
        return $row;
	}
	

	
	function getCategory($id){
			$db	= JFactory::getDBO();
			$query = "SELECT c.* FROM #__djcf_categories c "
					."WHERE c.id= ".$id." LIMIT 1 ";
	
			$db->setQuery($query);
			$category=$db->loadObject();
	
			return $category;
	}
		
	function getOrganisation($oid){
	    $db= JFactory::getDBO();
		$query = "SELECT c.* FROM #__organisations c WHERE id='".$oid."' LIMIT 1 ";
		$db->setQuery($query);
		$org=$db->loadObject();
		return $org;
	    
	}
	

	function getDays($cat_id){
			$db= JFactory::getDBO();
			
			$query = "SELECT d.*, IFNULL(c.cat_c,0) AS cat_c FROM #__djcf_days d "
					."LEFT JOIN (SELECT COUNT(id) as cat_c, day_id FROM #__djcf_days_xref GROUP BY day_id) c ON c.day_id=d.id "
					."WHERE d.published=1 AND (c.cat_c IS NULL OR d.id IN
							(SELECT day_id FROM #__djcf_days_xref WHERE cat_id='".$id."')  )"
					."ORDER BY d.days ";

					$db->setQuery($query);
					$days=$db->loadObjectList('days');			
	
			$db->setQuery($query);
			$days=$db->loadObjectList();
			
	
			return $days;
	}	

	function getPromotions(){
			$db= JFactory::getDBO();
			$query = "SELECT p.*, '' as prices FROM #__djcf_promotions p "
					."WHERE p.published=1 "
					."ORDER BY p.ordering,p.id ";
	
			$db->setQuery($query);
			$promotions=$db->loadObjectList('id');
						
			$query = "SELECT p.* FROM #__djcf_promotions_prices p "
					."ORDER BY p.days ";
			$db->setQuery($query);
			$prom_prices=$db->loadObjectList();		
			
				foreach($prom_prices as $pp){
					if(isset($promotions[$pp->prom_id])){
						if(!is_array($promotions[$pp->prom_id]->prices)){
							$promotions[$pp->prom_id]->prices = array();
						}	
						$promotions[$pp->prom_id]->prices[$pp->days]=$pp;
					}
				}
			
			//echo '<pre>';print_r($promotions);die();			
	
			return $promotions;
	}	
	
	function getItemPromotions($id){
		$promotions = '';
		if($id){
			$db= JFactory::getDBO();
			$query = "SELECT p.* FROM #__djcf_items_promotions p "
					."WHERE item_id=".$id;
	
					$db->setQuery($query);
					$promotions=$db->loadObjectList('prom_id');
					//echo '<pre>';print_r($promotions);die();
		}
		return $promotions;
	}
	
}