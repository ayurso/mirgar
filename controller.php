<?php

defined ('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');

class DJClassifiedsController extends JControllerLegacy {

	function __construct($config = array())
	{
		parent::__construct($config);
		$lang = JFactory::GetLanguage();
		$lang->load('com_djclassifieds');				

		$par = JComponentHelper::getParams( 'com_djclassifieds' );
		$notify_days = $par->get('notify_days','0');

		if($notify_days>0 && $par->get('notify_days_trigger','1')==2 ){
			DJClassifiedsNotify::notifyExpired(5,0); 
		}
		//$this->registerTask( 'modfp',  'getFrontpageXMLData' );
	}
	
	
	function processPayment()
	{
		JRequest::setVar( 'view', 'payment' );
		JRequest::setVar( 'layout', 'process' );
		parent::display();
	}
	
	function paymentReturn(){
		$app = JFactory::getApplication();	
		$id = JRequest::getInt("id","");
		$cid = JRequest::getInt("cid","");
		$itemid = JRequest::getInt("Itemid","");
		$r = JRequest::getVar("r","");
		
		if($r=='ok'){
			//$redirect= 'index.php?option=com_djclassifieds&view=item&id='.$id.'&cid='.$cid.'&Itemid='.$itemid;
			$message=JTExt::_('COM_DJCLASSIFIEDS_THANKS_FOR_PAYMENT_WAIT_FOR_CONFIRMATION');	
		}else{					
			$message=JTExt::_('COM_DJCLASSIFIEDS_PAYMENT_CANCELED');
		}
		//$redirect= 'index.php?option=com_djclassifieds&view=items&cid=0&Itemid='.$itemid;
		$redirect=DJClassifiedsSEO::getCategoryRoute('0:all');
		$redirect = JRoute::_($redirect,false);
		$app->redirect($redirect, $message);
	}
	
	function cronNotifications(){
		$dispatcher = JDispatcher::getInstance();
		$par = JComponentHelper::getParams( 'com_djclassifieds' );
		$notify_days = $par->get('notify_days','0');

		if($notify_days>0 && $par->get('notify_days_trigger','1')==3 ){
			DJClassifiedsNotify::notifyExpired(0,0);
		}
		
		if($par->get('auctions','0')==1 ){
			DJClassifiedsNotify::notifyAuctions();
		}
		
		$dispatcher->trigger('onAfterDJClassifiedsCronNotifications', array());
		
		die('done');
	}

	function cronOptimize(){

		$app = JFactory::getApplication();
		$par = JComponentHelper::getParams( 'com_djclassifieds' );

		$db =  JFactory::getDBO();
		$query = "SELECT * FROM #__djcf_images WHERE optimized=0 LIMIT 1";
		$db->setQuery($query);
		$image = $db->loadObject();
		
		if($image){			
			$path = JPATH_SITE.$image->path.$image->name;
			if (JFile::exists($path.'.'.$image->ext)){
				if (JFile::exists($path.'_thb.'.$image->ext)){
					DJClassifiedsImage::resmushitThumbnails($path.'_thb.'.$image->ext);
				}
				if (JFile::exists($path.'_th.'.$image->ext)){
					DJClassifiedsImage::resmushitThumbnails($path.'_th.'.$image->ext);
				}
				if (JFile::exists($path.'_thm.'.$image->ext)){
					DJClassifiedsImage::resmushitThumbnails($path.'_thm.'.$image->ext);
				}
				if (JFile::exists($path.'_ths.'.$image->ext)){
					DJClassifiedsImage::resmushitThumbnails($path.'_ths.'.$image->ext);
				}						
			}
			$query = "UPDATE #__djcf_images SET optimized=1 WHERE id =  ".$image->id." ";
			$db->setQuery($query);
			$db->query();
			echo 'Optymizing '.$image->id;						
			header("refresh: 0; url=".JURI::base().'index.php?option=com_djclassifieds&task=cronOptimize');
		}else{
			die('done');
		}	
		die();
	}	
	
	function cronSearchNotifications(){
		JPluginHelper::importPlugin('djclassifieds');
		$dispatcher	= JDispatcher::getInstance();
		
		if($dispatcher->trigger('updateSearchAlerts', array ())){
			DJClassifiedsNotify::notifiSearchAlerts();
		}						
		
		die('done');
	}
	
	public function upload() {	
		$user = JFactory::getUser();			
		DJUploadHelper::upload();
		return true;
	}
	
	function download() {
		$app		= JFactory::getApplication();
		$user		= JFactory::getUser();
		$db			= JFactory::getDbo();
		$file_id = 	$app->input->getInt('fid',0);
		
	 
		if (!DJClassifiedsFileHelper::getFile($file_id)){
			throw new Exception('', 404);
			return false;
		}
		//test
		$app->close();
				//return true;
	}
	
}	