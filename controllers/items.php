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


class DJClassifiedsControllerItems extends JControllerLegacy {
	function parsesearch(){
		$app	=   JFactory::getApplication();		
		$Itemid = JRequest::getInt('Itemid',0);
		if($Itemid){
			$menus	= $app->getMenu('site');
			$result_page = $menus->getItem($Itemid);
			$link = JRoute::_($result_page->link.'&Itemid='.$Itemid.'&se=1',false);
		}else{
			$link = 'index.php?option=com_djclassifieds&view=items&cid=0&se=1';
			$link = JRoute::_($link,false);
		}
		
		
		
		
		//$link = 'index.php?option=com_djclassifieds&view=items';
		//$link .= '&Itemid='.$Itemid;
		/*if(JRequest::getVar('layout','')=='blog'){
			$link .= '&layout=blog';
		}*/
		
				
		foreach($_GET as $key=>$input){
			if($key=='task' || $key=='se'){
				continue;
			}
			if(is_array($input)){
				if(end($input)==''){
					array_pop($input);
				}
				$link .='&'.$key.'='.urlencode(implode(',', $input));
			}else{
				$link .='&'.$key.'='.urlencode($input);
			}
								 
		}
		//echo $link; die();
		/*echo '<pre>';
		echo $link;
		print_r($_POST);
		print_r($_GET);die();
		if(isset($_GET['se_regs'])){
			$reg_id= end($_GET['se_regs']);
			if($reg_id=='' && count($_GET['se_regs'])>2){
				$reg_id =$_GET['se_regs'][count($_GET['se_regs'])-2];
			}
			$reg_id=(int)$reg_id;
		}*/
		//$link = JRoute::_($link,false);
		$app->redirect($link);
		die();
	}
	
	function processPayment()
	{
		JRequest::setVar( 'view', 'payment' );
		JRequest::setVar( 'layout', 'process' );
		parent::display();
	}
	
}