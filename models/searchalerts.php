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

class DjclassifiedsModelSearchAlerts extends JModelLegacy{	
	
	
	function getItems(){
		$par 		= JComponentHelper::getParams( 'com_djclassifieds' );
		$limit		= JRequest::getVar('limit', $par->get('limit_djitem_show'), '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
		$user 		= JFactory::getUser();
		$db			= JFactory::getDBO();
			 
			 $order = JRequest::getCmd('order', $par->get('items_ordering','date_e'));
			 $ord_t = JRequest::getCmd('ord_t', $par->get('items_ordering_dir','desc'));
			
			$ord="s.created ";			
		
			if($ord_t == 'desc'){
				$ord .= 'DESC';
			}else{
				$ord .= 'ASC';
			}
		
			
			$query = "SELECT s.* FROM #__djcf_search_alerts s "
					."WHERE s.user_id='".$user->id."' " 
					."ORDER BY  ".$ord."";
		
			$items = $this->_getList($query, $limitstart, $limit);	
			
			
				foreach($items as &$item){
					$item->params = json_decode($item->search_query);
					$item->category = '- - -';
					$item->region = '- - -';
					$item->phrase = '- - -';
					if(isset($item->params->search)){
						if($item->params->search){
							$item->phrase = $item->params->search;		
						}	
					}		
					
					if(isset($item->params->se_cats)){
						if($item->params->se_cats){
							$cats_a = explode(',', $item->params->se_cats);
							$cat_id = intval(str_ireplace('p', '', end($cats_a)));
							if($cat_id){
								$cat_path = DJClassifiedsCategory::getParentPath(1,$cat_id);
								$item->category = '';
								foreach($cat_path as $c){
									if($item->category){$item->category .= ', '; }
									$item->category .=	$c->name;
								}
							} 									
						}	
					}
					
					if(isset($item->params->se_regs)){
						if($item->params->se_regs){
							$regs_a = explode(',', $item->params->se_regs);
							$reg_id = intval(str_ireplace('p', '', end($regs_a)));
							if($reg_id){
								$reg_path = DJClassifiedsRegion::getParentPath($reg_id);
								$item->region = '';
								foreach($reg_path as $r){
									if($item->region){$item->region .= ', '; }
									$item->region .=	$r->name;
									
								}
							} 									
						}	
					}
					
					if(isset($item->params->se_address)){
						if($item->params->se_address){				
							if($item->region && $item->region!= '- - -'){$item->region .= ', '; }
							$item->region =	$item->params->se_address;																								
						}	
					}else if(isset($item->params->se_postcode)){
						if($item->params->se_postcode){
							if($item->region && $item->region!= '- - -'){$item->region .= ', '; }
							$item->region =	$item->params->se_postcode;																								
						}	
					}					
								
				}
						
				//$db= JFactory::getDBO();$db->setQuery($query);$items=$db->loadObjectList();
				//echo '<pre>';print_r($db);print_r($items);echo '<pre>';die();	
				//echo '<pre>';print_r($items);echo '<pre>';die();
			return $items;
	}
	
	function getCountItems(){
			$db= JFactory::getDBO();
			$user = JFactory::getUser();			
			
			$query = "SELECT count(s.id) FROM #__djcf_search_alerts s "
					."WHERE s.user_id='".$user->id."' ";			
										
				$db->setQuery($query);
				$items_count=$db->loadResult();
				
				//echo '<pre>';print_r($db);print_r($items_count);echo '<pre>';die();	
			return $items_count;
	}	

	function getCustomFields(){
			$db= JFactory::getDBO();
			$user = JFactory::getUser();			
			
			$query = "SELECT * FROM #__djcf_fields  "
					."WHERE published=1 ";			
										
				$db->setQuery($query);
				$fields=$db->loadObjectList('id');
				
				//echo '<pre>';print_r($db);print_r($fields);echo '<pre>';die();	
			return $fields;
	}	
	
	
}

