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
jimport('joomla.html.pagination');

class DJClassifiedsViewPoints extends JViewLegacy{

	public function __construct($config = array())
	{
		parent::__construct($config);
		$this->_addPath('template', JPATH_COMPONENT.  '/themes/default/views/points');
		$par = JComponentHelper::getParams( 'com_djclassifieds' );
		$theme = $par->get('theme','default');
		if ($theme && $theme != 'default') {
			$this->_addPath('template', JPATH_COMPONENT.  '/themes/'.$theme.'/views/points');
		}
	}	
	
	function display($tpl = null)
	{
		global $mainframe;
		$par 		= JComponentHelper::getParams( 'com_djclassifieds' );
		$app		= JFactory::getApplication();
		$user 		= JFactory::getUser();
		$dispatcher	= JDispatcher::getInstance();
		
		/*if($user->id=='0'){
			$uri = JFactory::getURI();
			$login_url = JRoute::_('index.php?option=com_users&view=login&return='.base64_encode($uri));
			$app->redirect($login_url,JText::_('COM_DJCLASSIFIEDS_PLEASE_LOGIN'));
		}else{*/
		    
			$model = $this->getModel();
			$points= $model->getPoints();	
			$plugin_points_top = $dispatcher->trigger('onBeforePointsPackagesList', array ());
			$plugin_points_bottom = $dispatcher->trigger('onAfterPointsPackagesList', array ());
			
			$this->assignRef('points', $points);
			$this->assignRef('plugin_points_top', $plugin_points_top);
			$this->assignRef('plugin_points_bottom', $plugin_points_bottom);
		//}
		  parent::display();		  
	}

}




