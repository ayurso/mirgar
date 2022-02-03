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
require_once(JPATH_COMPONENT.DS.'assets'.DS.'recaptchalib.php');
$par 		= JComponentHelper::getParams( 'com_djclassifieds' );
$config = JFactory::getConfig();
$publickey = $par->get('captcha_publickey',"6LfzhgkAAAAAAL9RlsE0x-hR2H43IgOFfrt0BxI0"); 
$privatekey = $par->get('captcha_privatekey',"6LfzhgkAAAAAAOJNzAjPz3vXlX-Bw0l-sqDgipgs");
$captcha_type = $par->get('captcha_type','recaptcha'); 
if($captcha_type=='nocaptcha'){
	$document= JFactory::getDocument();
	$document->addScript("https://www.google.com/recaptcha/api.js");	
}

?>

<div id="dj-classifieds" class="clearfix">
	<div class="dj-additem clearfix" >
		<div class="title_top"><?php echo JText::_('COM_DJCLASSIFIEDS_NEW_AD_VERIFICATION'); ?></div>		
		<script type="text/javascript">
		 	var RecaptchaOptions = {
		    	theme : '<?php echo $par->get('captcha_theme','red'); ?>'
		 	};
		 </script>
		<form action="<?php echo JURI::base(); ?>index.php" method="post" id="djForm" name="djForm" enctype='multipart/form-data'>
		
		<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
			<tr>
				<td class="captcha">
					<?php 
					if($captcha_type=='recaptcha'){
						$error = '';
						$menu_add = JFactory::getApplication()->getMenu('site')->getItems('link','index.php?option=com_djclassifieds&view=additem',1);
						$menu_secure = $menu_add ? $menu_add->params->get('secure') : 0;
						if(($config->get('force_ssl',0)==2) || $menu_secure!=0){
							echo recaptcha_get_html($publickey, $error,true);
						}else{
							echo recaptcha_get_html($publickey, $error);
						}
					}else if($captcha_type=='nocaptcha'){ ?>										
						<div class="g-recaptcha" data-sitekey="<?php echo $publickey; ?>"></div>
					<?php } ?>
				</td>
			</tr>
			
			</table>
			
			<button class="button" type="submit" id="submit_b" ><?php echo JText::_('COM_DJCLASSIFIEDS_CONTINUE'); ?></button>
			<input type="hidden" name="view" value="additem" />
			<input type="hidden" name="option" value="com_djclassifieds" />
			<input type="hidden" name="Itemid" value="<?php echo JRequest::getCMD('Itemid', '' ); ?>">
			<input type="hidden" name="layout" value="default" />
			<input type="hidden" name="task" value="captcha" />
			<input type="hidden" name="id" value="0" />
			<input type="hidden" name="token" value="<?php echo JRequest::getCMD('token', '' );?>" />
			<input type="hidden" name="subscr_id" value="<?php echo JRequest::getCMD('subscr_id', '' );?>" />
			
			<?php echo JHTML::_( 'form.token' ); ?>
	    </form>
	</div>
</div>

    