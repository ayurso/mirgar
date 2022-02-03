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


class DJclassifiedsViewGhostad extends JViewLegacy{
		
	public function __construct($config = array())
	{
		parent::__construct($config);				
		
		$this->_addPath('template', JPATH_COMPONENT.  '/themes/default/views/ghostad');
		$par = JComponentHelper::getParams( 'com_djclassifieds' );
		$theme = $par->get('theme','default');
		if ($theme && $theme != 'default') {
			$this->_addPath('template', JPATH_COMPONENT.  '/themes/'.$theme.'/views/ghostad');
		}
	}	
	
	function display($tpl = null){
		
		$par 	    = JComponentHelper::getParams( 'com_djclassifieds' );
		$document   = JFactory::getDocument();
		$app	    = JFactory::getApplication();
		$theme 		= $par->get('theme','default');
		$user 		= JFactory::getUser();
		
		JTable::addIncludePath(JPATH_ROOT.'/administrator/components/com_djclassifieds/tables');
		$item = JTable::getInstance('GhostAds', 'DJClassifiedsTable');
		
		$item_id = $app->input->getInt('id');
		$item->load(array('item_id'=>$item_id));
		
		if($item->user_id!=$user->id && $item->access_view){		
			$groups_acl = ','.implode(',', $user->getAuthorisedViewLevels()).',';
			if(!strstr($groups_acl,','.$item->access_view.',')){
				DJClassifiedsTheme::djAccessRestriction();
			}
		}
		
		$document->setTitle($item->name);										
		
		$pathway = $app->getPathway();
		$pathway->addItem($item->name);
		
		$this->assignRef('item',$item);
		$this->assignRef('theme',$theme);
		$this->assignRef('params',$par);
		
		parent::display($tpl);
	}

}




