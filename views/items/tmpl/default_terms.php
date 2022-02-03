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

JHTML::_('behavior.framework');
JHTML::_('behavior.tooltip');
$toolTipArray = array('className'=>'djcf');
JHTML::_('behavior.tooltip', '.Tips1', $toolTipArray);

$par	 = JComponentHelper::getParams( 'com_djclassifieds' );
$config  = JFactory::getConfig();
$app	 = JFactory::getApplication();
$user	 = JFactory::getUser();
$Itemid  = JRequest::getVar('Itemid', 0,'', 'int');

$pageclass_sfx ='';
if($Itemid){
	$menu_item = $app->getMenu()->getItem($Itemid);
	$pc_sfx = $menu_item->params->get('pageclass_sfx');
	if($pc_sfx){$pageclass_sfx =' '.$pc_sfx;}
}

$mod_attribs=array();
$mod_attribs['style'] = 'xhtml';

?> 
<div id="dj-classifieds" class="djcf_warning18 clearfix djcftheme-<?php echo $this->theme;?><?php echo $pageclass_sfx;?>">
	<div class="djcf_warning_outer clearfix">
		<div class="title_top"><?php echo JText::_('COM_DJCLASSIFIEDS_WARNING_18_TITLE');?></div>
		<div class="djcf_warning_outer_in">
			<?php $modules_djcf = &JModuleHelper::getModules('djcf-warning18-top');
				if(count($modules_djcf)>0){
					echo '<div class="djcf-war-top clearfix">';
					foreach (array_keys($modules_djcf) as $m){
						echo JModuleHelper::renderModule($modules_djcf[$m],$mod_attribs);
					}
					echo'</div>';		
				}	?>
			<div class="djcf_war_content">
				<?php echo JText::_('COM_DJCLASSIFIEDS_WARNING_18_CONTENT');?>
			</div>                	
			<?php $modules_djcf = &JModuleHelper::getModules('djcf-warning18-center');
				if(count($modules_djcf)>0){
					echo '<div class="djcf-war-center clearfix">';
					foreach (array_keys($modules_djcf) as $m){
						echo JModuleHelper::renderModule($modules_djcf[$m],$mod_attribs);
					}
					echo'</div>';		
				}	?>
			<?php
			if($par->get('restriction_18_art',0)){ ?>
				<div class="djcf_war_link">
					<?php
					if($par->get('restriction_18_art',0)==1){
						echo '<a href="'.$this->terms_link.'" target="_blank">'.JText::_('COM_DJCLASSIFIEDS_TERMS_AND_CONDITIONS').'</a>';
					}else if($par->get('restriction_18_art',0)==2){
						echo '<a href="'.$this->terms_link.'" rel="{size: {x: 700, y: 500}, handler:\'iframe\'}" class="modal" target="_blank">'.JText::_('COM_DJCLASSIFIEDS_TERMS_AND_CONDITIONS').'</a>';
					}
					?>
				</div>
			<?php } ?>				
			<?php $modules_djcf = &JModuleHelper::getModules('djcf-warning18-bottom');
				if(count($modules_djcf)>0){
					echo '<div class="djcf-war-bottom clearfix">';
					foreach (array_keys($modules_djcf) as $m){
						echo JModuleHelper::renderModule($modules_djcf[$m],$mod_attribs);
					}
					echo'</div>';		
				}	?>			
			<div class="djcf_war_buttons">
				<a class="djcf_war_cancel button" href="<?php echo JURI::base();?>">
					<?php echo JText::_('COM_DJCLASSIFIEDS_WARNING_18_BUTTON_CANCEL'); ?>
				</a>
				<button onclick="djcfAccept18()" class="djcf_war_accept button" >
					<?php echo JText::_('COM_DJCLASSIFIEDS_WARNING_18_ACCEPT');?>
				</button>
				<div class="clear_both"></div>
			</div>      
			<div class="clear_both"></div>        	 					 					
		</div>	
	</div> 
</div>
<script type="text/javascript">
	function djcfAccept18(){	
	  	var exdate=new Date();
	  	exdate.setDate(exdate.getDate() + 1);
	  	document.cookie = "djcf_warning18=1; expires=" + exdate.toUTCString();
	  	location.reload(); 
	}
</script>