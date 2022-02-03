<?php
//**
* @version 2.0
* @package MIRGAR
* @copyright Copyright (C) 2020 mirgar.ga LTD, All rights reserved.
* @license http://www.gnu.org/licenses GNU/GPL
* @author url: https://mirgar.ga
* @author email mirgarmon@ya.ru
* компонент "Обращения" для Joomla3 
*/
defined ('_JEXEC') or die('Restricted access');
jimport( 'joomla.application.component.view' );

class DJClassifiedsViewCheckout extends JViewLegacy{

	public function __construct($config = array())
	{
		parent::__construct($config);
		$this->_addPath('template', JPATH_COMPONENT.  '/themes/default/views/checkout');
		$par = JComponentHelper::getParams( 'com_djclassifieds' );
		$theme = $par->get('theme','default');
		if ($theme && $theme != 'default') {
			$this->_addPath('template', JPATH_COMPONENT.  '/themes/'.$theme.'/views/checkout');
		}
	}

	function display( $tpl = null ){
		$app		= JFactory::getApplication();
		$params 	= $app->getParams();
		$user		= JFactory::getUser();
		$id 		= JRequest::getInt("item_id","0");
		$cid 		= JRequest::getInt("cid","0");						
		$par 		= JComponentHelper::getParams( 'com_djclassifieds' );
		$model 		= $this->getModel();		 		
		$quantity   = JRequest::getInt('quantity',1);
		$dispatcher	= JDispatcher::getInstance();
		$buynow_opt = JRequest::getInt("buynow_option","0");
		
			$item = $model->getItem($id);
			$item_options = $model->getItemOptions($id,$buynow_opt);
			$extra_payments = $dispatcher->trigger('onPrepareCheckouPaymentList', array (& $item, & $par, $quantity ));
			$extra_form = $dispatcher->trigger('onPrepareCheckouPaymentForm', array (& $item, & $par, $quantity ));
			
			$this->assignRef("item",$item);
			$this->assignRef("item_options",$item_options);
			$this->assignRef("extra_payments",$extra_payments);
			$this->assignRef("extra_form",$extra_form);

		parent::display();
	}
}
