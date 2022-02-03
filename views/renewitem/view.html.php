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

jimport('joomla.application.component.view');


class DJClassifiedsViewRenewitem extends JViewLegacy{

	public function __construct($config = array())
	{
		parent::__construct($config);
		$this->_addPath('template', JPATH_COMPONENT.  '/themes/default/views/renewitem');
		$par = JComponentHelper::getParams( 'com_djclassifieds' );
		$theme = $par->get('theme','default');
		if ($theme && $theme != 'default') {
			$this->_addPath('template', JPATH_COMPONENT.  '/themes/'.$theme.'/views/renewitem');
		}
	}
	
	function display($tpl = NULL){
		global $mainframe;
		$par 		= JComponentHelper::getParams( 'com_djclassifieds' );
		$session 	= JFactory::getSession();		
		$val 		= $session->get('captcha_sta','0');
		$user 		= JFactory::getUser();
		$app 		= JFactory::getApplication();		
		$it 		= JRequest::getInt('Itemid');
		//echo $val;
		
		if($user->id=='0'){
			$uri = JFactory::getURI();
			$login_url = JRoute::_('index.php?option=com_users&view=login&return='.base64_encode($uri),false);
			$app->redirect($login_url,JText::_('COM_DJCLASSIFIEDS_PLEASE_LOGIN'));
		}else{		 
			if(JRequest::getVar('id', 0, '', 'int' )==0){
				$message = JText::_('COM_DJCLASSIFIEDS_WRONG_AD');
				$redirect="index.php?option=com_djclassifieds&view=useritems&Itemid=".$it;
				$redirect = JRoute::_($redirect,false);
				$app->redirect($redirect, $message,'error');
			}else{				
				$model 		= $this->getModel();				
				$item 		= $model->getItem();
			
				if($par->get('durations_list',1)==0 && $par->get('promotion',0)==0){
					$redirect="index.php?option=com_djclassifieds&view=item&task=renew&id=".$item->id."&Itemid=".$it;
					$redirect = JRoute::_($redirect,false);
					$app->redirect($redirect, $message);
				}
				
				$category = $model->getCategory($item->cat_id);			
				$days='';
				if($par->get('durations_list',1)>0){
					$days = $model->getDays($item->cat_id);				
				}
				
				if($par->get('promotion')=='1'){
					$promotions = $model->getPromotions();
					$this->assignRef('promotions',$promotions);
					$item_promotions = $model->getItemPromotions($item->id);
					$this->assignRef('item_promotions',$item_promotions);
				}	
			
				$this->assignRef('item',$item);
				$this->assignRef('category',$category);
				$this->assignRef('days',$days);
        		parent::display();			
			}
		}
	}

}




