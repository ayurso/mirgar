<?php
/**
* @version 2.0
* @package MIRGAR
* @copyright Copyright (C) 2020 mirgar.ga LTD, All rights reserved.
* @license http://www.gnu.org/licenses GNU/GPL
* @author url: https://mirgar.ga
* @author email mirgarmon@ya.ru
* компонент "Обращения" для Joomla3 
* ВАШИ ОБРАЩЕНИЯ
*/
defined ('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class DJClassifiedsViewUseritems extends JViewLegacy{

	public function __construct($config = array())
	{
		parent::__construct($config);
		$this->_addPath('template', JPATH_COMPONENT.  '/themes/default/views/useritems');
		$par = JComponentHelper::getParams( 'com_djclassifieds' );
		$theme = $par->get('theme','default');
		if ($theme && $theme != 'default') {
			$this->_addPath('template', JPATH_COMPONENT.  '/themes/'.$theme.'/views/useritems');
		}
	}	
	
	public function display($tpl = null)
	{
		global $mainframe;
		$par 	= JComponentHelper::getParams( 'com_djclassifieds' );
		$app 	= JFactory::getApplication();
		$user 	= JFactory::getUser();
		$model 	= $this->getModel();
		$t 		= JRequest::getVar('t', '');
		$token 	= JRequest::getVar('token', '');
		$id 	= JRequest::getInt('id', 0);
		$dispatcher	= JDispatcher::getInstance();
		$type   = JRequest::getVar('type','');
		
		
		
			$types = $model->getTypes();
			$this->assignRef('types', $types);
		
		if ($par->get('rss_feed', 1) == 1){
			$link	= '&format=feed&limitstart=';
			$attribs = array('type' => 'application/rss+xml', 'title' => 'RSS 2.0');
			$document->addHeadLink(JRoute::_($link.'&type=rss',false), 'alternate', 'rel', $attribs);
			$attribs = array('type' => 'application/atom+xml', 'title' => 'Atom 1.0');
			$document->addHeadLink(JRoute::_($link.'&type=atom',false), 'alternate', 'rel', $attribs);
		}				
		
		
		if($id && $t=='delete' && $user->id){			
			$item= $model->getItem();
			$this->assignRef('item', $item);
			$tpl = 'delete';
		}else if($token && $t=='delete'){			
			$item= $model->getItemToken();
			$this->assignRef('item', $item);
			$tpl = 'delete';
		}else if($user->id=='0'){
			$uri = JFactory::getURI();
			$login_url = JRoute::_('index.php?option=com_users&view=login&return='.base64_encode($uri),false);
			$app->redirect($login_url,JText::_('COM_DJCLASSIFIEDS_PLEASE_LOGIN'));
		}else{
			$items= $model->getItems();
			$countitems = $model->getCountItems();
			$special_prices = $dispatcher->trigger('onItemEditFormSpecialPrices', array ());
			if($special_prices){
				if(is_array($special_prices[0])){$special_prices = $special_prices[0];}	
			}
			
			
				$limit	= JRequest::getVar('limit', $par->get('limit_djitem_show'), '', 'int');
				$limitstart	= JRequest::getVar('limitstart', 0, '', 'int');
				$pagination = new JPagination( $countitems, $limitstart, $limit );
	
			$this->assignRef('items', $items);		
			$this->assignRef('pagination', $pagination);
			$this->assignRef('special_prices',$special_prices);
			
		}
		  parent::display($tpl);		  
	}

}