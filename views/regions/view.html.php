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

class DJClassifiedsViewRegions extends JViewLegacy{

	public function __construct($config = array())
	{
		parent::__construct($config);
		$this->_addPath('template', JPATH_COMPONENT.  '/themes/default/views/regions');
		$par = JComponentHelper::getParams( 'com_djclassifieds' );
		$theme = $par->get('theme','default');
		if ($theme && $theme != 'default') {
			$this->_addPath('template', JPATH_COMPONENT.  '/themes/'.$theme.'/views/regions');
		}
	}	
	
	function display($tpl = null){
					
		$document = JFactory::getDocument();
		//$par = &JComponentHelper::getParams( 'com_djclassifieds' );
		$app	= JFactory::getApplication();
		$model = $this->getModel();
		$par = $model->getParams();
				
		$regs= DJClassifiedsRegion::getRegAllItemsCount(1,0,1);
	//	echo '<pre>';print_r($cats);die();			
		
		$this->assignRef('regs',$regs);
		$this->assignRef('par',$par);

        parent::display($tpl);
	}

}




