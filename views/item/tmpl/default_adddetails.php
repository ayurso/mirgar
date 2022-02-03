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
$par = JComponentHelper::getParams( 'com_djclassifieds' );
$app = JFactory::getApplication();
$item = $this->item;

 if((int)$par->get('showaddetails','1')){?>
	<div class="additional"><h2><?php echo JText::_('COM_DJCLASSIFIEDS_AD_DETAILS'); ?></h2>
		<div class="row">
			<span class="row_label"><?php echo JText::_('COM_DJCLASSIFIEDS_AD_ID'); ?>:</span>
			<span class="row_value"><?php echo $item->id; ?></span>
		</div>
		<div class="row">
			<span class="row_label"><?php echo JText::_('COM_DJCLASSIFIEDS_DISPLAYED'); ?>:</span>
			<span class="row_value"><?php echo $item->display; ?></span>
		</div>
		<?php if($par->get('show_ad_added_date','1')==2){?>
		<div class="row">
			<span class="row_label"><?php echo JText::_('COM_DJCLASSIFIEDS_AD_ADDED'); ?></span>
			<span class="row_value">
				<?php echo DJClassifiedsTheme::formatDate(strtotime($item->date_start));  ?>
			</span>
		</div>
		<?php } ?>
		<?php if($par->get('show_ad_modified_date','1')==2 && $item->date_mod!='0000-00-00 00:00:00'){?>
			<div class="row">
				<span class="row_label"><?php echo JText::_('COM_DJCLASSIFIEDS_AD_MODIFIED'); ?>:</span>
				<span class="row_value">
					<?php echo DJClassifiedsTheme::formatDate(strtotime($item->date_mod),'',$par->get('date_format_type_item',0)); ?>
				</span>
			</div>
		<?php  } ?>					
		<div class="row">
			<span class="row_label"><?php echo JText::_('COM_DJCLASSIFIEDS_AD_EXPIRES'); ?>:</span>
			<span class="row_value">
				<?php echo DJClassifiedsTheme::formatDate(strtotime($item->date_exp));  ?>
			</span>
		</div>
		<?php if(count($item->extra_cats)){?>
		<div class="row">
			<span class="row_label"><?php echo JText::_('COM_DJCLASSIFIEDS_IN_CATEGORIES'); ?>:</span>
			<span class="row_value">
				<?php
				echo '<a href="'.DJClassifiedsSEO::getCategoryRoute($item->cat_id.':'.$item->c_alias).'" >'.$item->c_name.'</a>';
				foreach($item->extra_cats as $ecat){					
					echo ', <a href="'.DJClassifiedsSEO::getCategoryRoute($ecat->id.':'.$ecat->alias).'" >'.$ecat->name.'</a>';
				} ?>
			</span>
		</div>
		<?php } ?>	
		
		
	</div>
<?php } ?>