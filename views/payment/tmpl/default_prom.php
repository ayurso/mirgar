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
$points_a = $par->get('points',0);
$points_total= $par->get('promotion_move_top_points',0);
?>
<div id="dj-classifieds" class="djcftheme-<?php echo $par->get('theme','default');?>">
	<?php	$modules_djcf = &JModuleHelper::getModules('djcf-payment-top');
		if(count($modules_djcf)>0){
			echo '<div class="djcf-payment-top clearfix">';
			foreach (array_keys($modules_djcf) as $m){
				echo JModuleHelper::renderModule($modules_djcf[$m],$mod_attribs);
			}
			echo'</div>';		
		}	?>
	<table cellpadding="0" cellspacing="0" width="98%" border="0" class="paymentdetails first">
		<tr>
			<td class="td_title">
				<h2><?php echo JText::_('COM_DJCLASSIFIEDS_PAYMENT_DETAILS');?></h2>
			</td>
		</tr>
		<tr>
			<td class="td_pdetails">
				<?php 																												
					echo '<div class="pd_row"><span>'.JText::_('COM_DJCLASSIFIEDS_PROMOTION_MOVE_TO_TOP').'</span>';
					echo '<span class="price">';
						if($points_a!=2){
							echo DJClassifiedsTheme::priceFormat($par->get('promotion_move_top_price',0),$par->get('unit_price','EUR'));
						}
						 if($par->get('promotion_move_top_points',0) && $points_a){
						 	if($points_a!=2){
						 		echo '&nbsp-&nbsp';
						 	}
							echo $par->get('promotion_move_top_points',0).' '.JTEXT::_('COM_DJCLASSIFIEDS_POINTS_SHORT');
						 }
					echo '</span></div>';
					if(count($this->plugin_payments)){
						foreach($this->plugin_payments as $extra_p){
							echo $extra_p;
						}
					}
					if($par->get('vat_value','-1')>-1 && $points_a!=2){
						$p_net = round($this->price_total/(1+($par->get('vat_value','-1')*0.01)),2);
						echo '<div class="pd_row_net"><span>'.JText::_('COM_DJCLASSIFIEDS_NET_COST').'</span>';
							echo '<span class="price">'.DJClassifiedsTheme::priceFormat($p_net,$par->get('unit_price','')).'</span>';
						echo '</div>';
						echo '<div class="pd_row_tax"><span>'.JText::_('COM_DJCLASSIFIEDS_TAX').' ('.$par->get('vat_value','-1').'%)</span>';
							echo '<span class="price">'.DJClassifiedsTheme::priceFormat($this->price_total-$p_net,$par->get('unit_price','')).'</span>';
						echo '</div>';
					}
					
					echo '<div class="pd_row_total"><span>'.JText::_('COM_DJCLASSIFIEDS_PRICE').'</span>';
					echo '<span class="price">';
						if($points_a!=2){
							echo DJClassifiedsTheme::priceFormat($this->price_total,$par->get('unit_price','EUR'));
						}
						 if($par->get('promotion_move_top_points',0) && $points_a){
						 	if($points_a!=2){
						 		echo '&nbsp-&nbsp';
						 	}
							echo $par->get('promotion_move_top_points',0).' '.JTEXT::_('COM_DJCLASSIFIEDS_POINTS_SHORT');
						 }
					echo '</span></div>';
					
					if($par->get('terms',1)>0 && $par->get('terms_article_id',0)>0 && $this->terms_link){ ?>
						<div class="pd_row pd_terms" >
					    	<div class="terms_and_conditions" styles="text-align:center;margin-top:10px;">
					                <input type="checkbox" name="terms_and_conditions" id="terms_and_conditions0" value="1" class="inputbox" />                	
									<?php 					 
									echo ' <span class="label_terms" for="terms_and_conditions" id="terms_and_conditions-lbl" >'.JText::_('COM_DJCLASSIFIEDS_I_AGREE_TO_THE').' </span>';					
									if($par->get('terms',0)==1){
										echo '<a href="'.$this->terms_link.'" target="_blank">'.JText::_('COM_DJCLASSIFIEDS_TERMS_AND_CONDITIONS').'</a>';
									}else if($par->get('terms',0)==2){
										echo '<a href="'.$this->terms_link.'" rel="{size: {x: 700, y: 500}, handler:\'iframe\'}" class="modal" target="_blank">'.JText::_('COM_DJCLASSIFIEDS_TERMS_AND_CONDITIONS').'</a>';
									} ?> *
					                <div class="clear_both"></div>
					     	</div>
					     </div>
				<?php } ?>
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
		}	
		
		$this->dispatcher->trigger( 'onBeforeShowPaymentsList',array(&$par));
		?>						
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
					if($par->get('points',0) && $points_total){ ?>
							<tr>
								<td class="payment_td">
									<table width="100%" cellspacing="0" cellpadding="5" border="0">
										<tr>
											<td width="160" align="center" class="td1">
												<img title="<?php echo JText::_('COM_DJCLASSIFIEDS_POINTS')?>" src="components/com_djclassifieds/assets/images/points.png">
											</td>
											<td class="td2">
												<h2><?php echo JText::_('COM_DJCLASSIFIEDS_POINTS_PACKAGE')?></h2>
												<p style="text-align:left;"><?php echo JText::_('COM_DJCLASSIFIEDS_POINTS_AVAILABLE').': '.$this->user_points;?></p>
											</td>
											<td width="130" align="center" class="td3">
												<?php 
												if($this->user_points>=$points_total){ 
													echo '<a class="button" href="index.php?option=com_djclassifieds&view=payment&task=payPoints&id='.$this->item->id.'&type=prom_top" style="text-decoration:none;">'.JText::_('COM_DJCLASSIFIEDS_USE_POINTS').'</a>';	
												}else{ 
													echo '<a target="_blank" class="button" href="'.JRoute::_('index.php?option=com_djclassifieds&view=points'.$itemid,false).'" style="text-decoration:none;">'.JText::_('COM_DJCLASSIFIEDS_BUY_POINTS').'</a>';	
												} ?>
												
											</td>
									</tr>
									</table>
								</td>
							</tr>
						<?php }
						$i = 0;					
						//if($points_a!=2){
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
						//}
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
<?php if($par->get('terms',1)>0 && $par->get('terms_article_id',0)>0 && $this->terms_link){ ?>
<script type="text/javascript">
	jQuery( document ).ready(function() {
	var pbuttons = jQuery('.paymentdetails .td3 a.button'); 
		pbuttons.each(function(i,pbutton){
			jQuery(pbutton).click(function(e) {
				if(!jQuery('#terms_and_conditions0').is(":checked")){
					alert('<?php echo addslashes(JText::_('COM_DJCLASSIFIEDS_PLEASE_ACCEPT_TERMS_AND_CONDITIONS'));?>');
					e.preventDefault();
				}		        
		    });				
		});
	});		
</script>
<?php } ?>