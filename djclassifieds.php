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


defined('_JEXEC') or die('Restricted access');
//error_reporting(E_STRICT);
if(!defined("DS")){
	define('DS',DIRECTORY_SEPARATOR);
}
$par = JComponentHelper::getParams( 'com_djclassifieds' );

require_once(JPATH_COMPONENT.DS.'defines.djclassifieds.php');

require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'djcategory.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'djimage.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'djregion.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'djnotify.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'djtheme.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'djtype.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'djseo.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'djgeocoder.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'djupload.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'djsocial.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'djparams.php');
require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'djpayment.php');

if($par->get('date_persian',0)){
	require_once(JPATH_COMPONENT_ADMINISTRATOR.DS.'lib'.DS.'persiancalendar.php');	
}

JPluginHelper::importPlugin('djclassifieds');

/*
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'route.php');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'html.php');
require_once(JPATH_COMPONENT.DS.'helpers'.DS.'theme.php');
*/

$document= JFactory::getDocument();
	
	if(JRequest::getVar('view')=='item'){
		if($par->get('lightbox_type','slimbox')=='picbox'){
			$assets=JURI::base(true).'/components/com_djclassifieds/assets/picbox/';
			$document->addScript($assets.'js/picbox.js');
			$document->addStyleSheet($assets.'css/picbox.css');
		}else if($par->get('lightbox_type','slimbox')=='magnific'){
			$assets=JURI::base(true).'/media/djextensions/magnific/';
			$document->addScript($assets.'magnific.js');
			$document->addStyleSheet($assets.'magnific.css');
		}else{
			$assets=JURI::base(true).'/components/com_djclassifieds/assets/slimbox-1.8/';	
			$document->addScript($assets.'js/slimbox.js');
			$document->addStyleSheet($assets.'css/slimbox.css');
		}
	}
	if(JRequest::getVar('view')!='item' && JRequest::getVar('view')!='items'){
		DJClassifiedsTheme::includeCSSfiles();
	}

	JHTML::_('behavior.calendar');
	//$document->addScript(JURI::root()."media/system/js/calendar-setup.js");
	//$document->addStyleSheet(JURI::root()."media/system/css/calendar-jos.css");
	$document->addScript("media/system/js/calendar-setup.js");
	$document->addStyleSheet("media/system/css/calendar-jos.css");

	require_once(JPATH_COMPONENT.DS.'controller.php');
	$lang = JFactory::GetLanguage();				
		
	if ($lang->getTag() != 'en-GB') {
		$lang = JFactory::getLanguage();
		$lang->load('com_djclassifieds', JPATH_SITE.'/components/com_djclassifieds', 'en-GB', true, false);
		if($lang->getTag()=='pl-PL'){
			$lang->load('com_djclassifieds', JPATH_SITE.'/components/com_djclassifieds', '', true, false);	
		}else{
			$lang->load('com_djclassifieds', JPATH_SITE, '', true, false);	
		}					
	}
	
	DJClassifiedsPayment::updatePromotions();

	$view=JRequest::getCmd('view','show');
	if($view=='item' || $view=='items' || $view=='additem' || $view=='payment' || $view=='renewitem' || $view=='profileedit' || $view=='contact' || $view=='checkout' || $view=='registration' || $view=='api' || $view=='searchalerts'){
		$path = JPATH_COMPONENT.DS.'controllers'.DS.$view.'.php'; 
		jimport('joomla.filesystem.file');	
		if(!JFile::exists($path)){
		
			JError::raiseError('500',JText::_('Unknown controller'));
		}
		
		$c = 'DJClassifiedsController'.ucfirst($view);
		JLoader::register($c, $path);
		$controller = new $c();	
		
	}else{
		$controller = JControllerLegacy::getInstance('djclassifieds');
	}
	
	$controller->execute(JFactory::getApplication()->input->get('task'));
	$controller->redirect();

?>