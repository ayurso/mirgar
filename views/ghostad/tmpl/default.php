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

$mod_attribs = array('style'=>'xhtml');
?>
<div id="dj-classifieds" class="clearfix djcftheme-<?php echo $this->theme;?> <?php echo $this->params->get( 'pageclass_sfx' ); ?>">
	<?php
		$modules_djcf = JModuleHelper::getModules('djcf-top');
		if(count($modules_djcf)>0){
			echo '<div class="djcf-ad-top clearfix">';
			foreach (array_keys($modules_djcf) as $m){
				echo JModuleHelper::renderModule($modules_djcf[$m],$mod_attribs);
			}
			echo'</div>';		
		}
	?>
			
	<div class="dj-item ghost">
		<div class="title_top info">
			<h2><?php echo $this->escape($this->item->name) ?> <small class="badge badge-important"><?php echo JText::_('COM_DJCLASSIFIEDS_GHOST_AD') ?></small></h2>
		</div>
		
		<div class="dj-item-in">
			
			<?php echo JHTML::_('content.prepare', $this->item->content); ?>
			
		</div>
	</div>	
	
	<?php 
		$modules_djcf = &JModuleHelper::getModules('djcf-bottom');
		if(count($modules_djcf)>0){
			echo '<div class="djcf-ad-bottom clearfix">';
			foreach (array_keys($modules_djcf) as $m){
				echo JModuleHelper::renderModule($modules_djcf[$m],$mod_attribs);
			}
			echo'</div>';
		}
	?>
</div>
