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
$item = $this->item;
?>
<div id="dj-classifieds" class="djcftheme-<?php echo $par->get('theme','default');?>">
	<?php	$modules_djcf = &JModuleHelper::getModules('djcf-payment-top');
		if(count($modules_djcf)>0){
			echo '<div class="djcf-payment-top clearfix">';
			foreach (array_keys($modules_djcf) as $m){
				echo JModuleHelper::renderModule($modules_djcf[$m],$mod_attribs);
			}
			echo'</div>';		
		}	
		
		$this->dispatcher->trigger( 'onBeforeShowPaymentsList',array(&$par));
		?>
	<table cellpadding="0" cellspacing="0" width="98%" border="0" class="paymentdetails first">
		<tr>
			<td class="td_title">
				<h2><?php echo JText::_('COM_DJCLASSIFIEDS_PAYMENT_DETAILS');?></h2>
			</td>
		</tr>
		<tr>
			<td class="td_pdetails">
				<?php 																												
					echo '<div class="pd_row pd_row_advert"><span>'.JText::_('COM_DJCLASSIFIEDS_ADVERT').'</span>';
					echo '<span class="advert">';
						echo '<a href="'.DJClassifiedsSEO::getItemRoute($item->id.':'.$item->alias,$item->cat_id.':'.$item->c_alias,$item->region_id.':'.$item->r_name).'" >';
							if(isset($this->item_images[0])){ ?>
								<img style="margin-right:10px;height: 100px;" alt="<?php echo $item->name; ?>" src="<?php echo JURI::base(true).$this->item_images[0]->thumb_s;?>" />
							<?php }
							echo $item->name;						
						echo '</a>'; 
					echo '</span></div>';
					
					echo '<div class="pd_row"><span>'.JText::_('COM_DJCLASSIFIEDS_PRICE').'</span>';
					echo '<span class="price">'.DJClassifiedsTheme::priceFormat($this->offer->price,$par->get('unit_price',''),2).'</span></div>';

					if($this->quantity){
						echo '<div class="pd_row"><span>'.JText::_('COM_DJCLASSIFIEDS_QUANTITY').'</span>';
						echo '<span class="price">'.$this->quantity.'</span></div>';
					}
					if(count($this->plugin_payments)){
						foreach($this->plugin_payments as $extra_p){
							echo $extra_p;
						}
					}					
					if($par->get('vat_value','-1')>-1){
						$p_net = round($this->price_total/(1+($par->get('vat_value','-1')*0.01)),2);
						echo '<div class="pd_row pd_row_net"><span>'.JText::_('COM_DJCLASSIFIEDS_NET_COST').'</span>';
							echo '<span class="price">'.DJClassifiedsTheme::priceFormat($p_net,$par->get('unit_price','')).'</span>';
						echo '</div>';
						echo '<div class="pd_row_tax"><span>'.JText::_('COM_DJCLASSIFIEDS_TAX').' ('.$par->get('vat_value','-1').'%)</span>';
							echo '<span class="price">'.DJClassifiedsTheme::priceFormat($this->price_total-$p_net,$par->get('unit_price',''),2).'</span>';
						echo '</div>';
					}
					
					echo '<div class="pd_row pd_row_total"><span>'.JText::_('COM_DJCLASSIFIEDS_PRICE').'</span>';
					echo '<span class="price">'.DJClassifiedsTheme::priceFormat($this->price_total,$par->get('unit_price',''),2).'</span></div>';
					
				?>
			</td>
		</tr>			
	</table>
		<?php	$modules_djcf = &JModuleHelper::getModules('djcf-payment-middle');
		if(count($modules_djcf)>0){
			echo '<div class="djcf-payment-middle clearfix">';
			foreach (array_keys($modules_djcf) as $m){
				echo JModuleHelper::renderModule($modules_djcf[$m],$mod_attribs);
			}
			echo'</div>';		
		}	?>
		<?php 	
		if(count($this->plugin_sections)){
			foreach($this->plugin_sections as $extra_section){
				echo $extra_section;
			}
		}	?>						
	<table cellpadding="0" cellspacing="0" width="98%" border="0" class="paymentdetails">
		<tr>
			<td class="td_title">
				<h2><?php echo JText::_("COM_DJCLASSIFIEDS_PAYMENT_METHODS"); ?></h2>
			</td>
		</tr>
		<tr>
			<td class="table_payment">
				<table cellpadding="0" cellspacing="0" width="100%" border="0">
					<?php
	
						$i = 0;					
						foreach($this->PaymentMethodDetails AS $pminfo)
						{
							if($pminfo=='' || ($points_a==2 && strpos($pminfo,'ptype=djcfAltaUserPoints')==false)){
								continue;
							}
							//$paymentLogoPath = JURI::root()."plugins/djclassifiedspayment/".$this->plugin_info[$i]->name."/images/".$pminfo["logo"];
							?>
								<tr>
									<td class="payment_td">
										<?php echo $pminfo; ?>
									</td>
								</tr>
							<?php
							$i++;
						}
					?>
				</table>
			</td>
		</tr>
	</table>
			<?php	$modules_djcf = &JModuleHelper::getModules('djcf-payment-bottom');
		if(count($modules_djcf)>0){
			echo '<div class="djcf-payment-bottom clearfix">';
			foreach (array_keys($modules_djcf) as $m){
				echo JModuleHelper::renderModule($modules_djcf[$m],$mod_attribs);
			}
			echo'</div>';		
		}	?>
</div>