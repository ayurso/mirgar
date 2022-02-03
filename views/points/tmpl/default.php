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
JHTML::_('behavior.framework' );
JHTML::_('behavior.formvalidation');
JHTML::_('behavior.modal');
$par = JComponentHelper::getParams( 'com_djclassifieds' );
?>
<div id="dj-classifieds" class="clearfix djcftheme-<?php echo $par->get('theme','default');?>">
<div class="pointspackages djcf_outer">
	<div class="title_top"><?php echo JText::_("COM_DJCLASSIFIEDS_POINTS_PACKAGES"); ?></div>
	<div class="djcf_outer_in paymentdetails">
		<?php	
		   if(count($this->plugin_points_top)){
				foreach($this->plugin_points_top as $plugin_top){
					echo $plugin_top;
				}
			}
			$i = 0;					
			foreach($this->points AS $point)
			{							
				?>
					<div class="djcf_prow"><div class="djcf_prow_in">								
						<div class="djcf_prow_col_desc">
							<h3><?php echo $point->name; ?></h3>
							<div class="djcf_prow_desc_row">	
								<?php echo JText::_("COM_DJCLASSIFIEDS_POINTS").': '.$point->points; ?><br />													
								<?php echo JText::_("COM_DJCLASSIFIEDS_COST_PER_POINT").': '.DJClassifiedsTheme::priceFormat(round($point->price/$point->points,4),$par->get('unit_price',''),2); ?>
							</div>
							<?php  if($point->description){	?>
								<div class="djcf_prow_desc_row djcf_prow_main_desc">																
									<?php echo $point->description; ?>
								</div>												
							<?php } ?>	
						</div>
						<div class="djcf_prow_col_buynow">
							<div class="pp_price"><?php echo DJClassifiedsTheme::priceFormat($point->price,$par->get('unit_price','')); ?></div>
							<a class="button" href="index.php?option=com_djclassifieds&view=payment&type=points&id=<?php echo $point->id?>">
								<?php echo JText::_('COM_DJCLASSIFIEDS_BUY_NOW'); ?>
							</a>
						</div>
					</div></div>
				<?php
				$i++;
			}
			
			if(count($this->plugin_points_bottom)){
				foreach($this->plugin_points_bottom as $plugin_bottom){
					echo $plugin_bottom;
				}
			}
		?>
	</div>
</div>
</div>