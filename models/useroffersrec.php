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

class DjclassifiedsModelUserOffersRec extends JModelLegacy{	
	
	function getOffers(){
		
		$par 		= JComponentHelper::getParams( 'com_djclassifieds' );
		$limit		= JRequest::getVar('limit', $par->get('limit_djitem_show'), '', 'int');
		$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
		$user 		= JFactory::getUser();			 
		$order		= JRequest::getCmd('order', $par->get('items_ordering','date_e'));
		$ord_t 		= JRequest::getCmd('ord_t', $par->get('items_ordering_dir','desc'));
		$db			= JFactory::getDBO();
			
			$ord="o.date ";
			
			/*if($order=="points"){
				$ord="p.points ";
			}*/				
		
			if($ord_t == 'asc'){
				$ord .= 'ASC';
			}else{
				$ord .= 'DESC';
			}
			
			if($par->get('authorname','name')=='name'){
				$u_name = 'u.name as username';
			}else{
				$u_name = 'u.username';
			}
			
			$query = "SELECT o.*, i.name as i_name, i.alias as i_alias, i.cat_id, i.region_id, i.currency, c.alias as c_alias,r.name as r_name, ".$u_name.", u.email FROM #__djcf_offers o, #__users u, #__djcf_items i "
					."LEFT JOIN #__djcf_categories c ON c.id=i.cat_id "					
					."LEFT JOIN #__djcf_regions r ON r.id=i.region_id "		
					."WHERE o.item_id=i.id AND u.id=o.user_id AND i.user_id='".$user->id."'  "
					."ORDER BY  ".$ord." ";
		
			$offers = $this->_getList($query, $limitstart, $limit);	
			
				//$db->setQuery($query);
				//$plans=$db->loadObjectList();

				if(count($offers)){
					$users_id = array();
					$id_list= '';
					foreach($offers as $offer){
						if($id_list){
							$id_list .= ','.$offer->item_id;
						}else{
							$id_list .= $offer->item_id;
						}
						if($offer->user_id){
							$users_id[$offer->user_id] = $offer->user_id; 
						}						
					}
					
					$items_img = DJClassifiedsImage::getAdsImages($id_list);
					$users_ids = implode(',', $users_id);
					$user_items_c = '';
					if($users_ids){
						$date_now = date("Y-m-d H:i:s");
						$query = "SELECT user_id , COUNT(i.id) as user_items_c FROM #__djcf_items i "
								."WHERE i.published=1 AND i.date_exp>'".$date_now."' AND i.user_id  IN (".$users_ids.") "
								."GROUP BY user_id";
						$db->setQuery($query);
						$user_items_c=$db->loadObjectList('user_id');
					}
					
					
					for($i=0;$i<count($offers);$i++){		
						$offers[$i]->i_user_items_count = '';
						if(isset($user_items_c[$offers[$i]->user_id])){
							$offers[$i]->i_user_items_count= $user_items_c[$offers[$i]->user_id]->user_items_c;
						}						
						$img_found =0;
						$offers[$i]->images = array();
						foreach($items_img as $img){
							if($offers[$i]->item_id==$img->item_id){
								$img_found =1;
								$offers[$i]->images[]=$img;
							}else if($img_found){
								break;
							}
						}																		
					}
					
				}				
				
				//echo '<pre>';print_r($db);print_r($offers);echo '<pre>';die();	
			return $offers;
	}
	
	function getCountOffers(){
					
			$user = JFactory::getUser();
			$query = "SELECT count(o.id) FROM #__djcf_offers o, #__djcf_items i "
					."WHERE i.id=o.item_id AND i.user_id='".$user->id."' ";				
						
				$db= JFactory::getDBO();
				$db->setQuery($query);
				$offers_count=$db->loadResult();
								
				//echo '<pre>';print_r($db);print_r($orders_count);echo '<pre>';die();	
			return $offers_count;
	}	
	
	
}

