<?php

defined ('_JEXEC') or die('Restricted access');
$par = JComponentHelper::getParams( 'com_djclassifieds' );
$app = JFactory::getApplication();

$item = $this->item;
$main_img_width = $par->get('gallery_width','200')-4;
$thumbs_limit = $par->get('gallery_thumbs_in_row','3');
$thumb_width = round(($par->get('gallery_width','200')/$thumbs_limit)-14);
$djMediaTools = ($par->get('djmediatools_integration', 0) == '1' && $par->get('djmediatools_album_item', 0) > 0) ? $par->get('djmediatools_album_item', 0) : false;
$djMediaToolsMinimum = (int)$par->get('djmediatools_minimum', 1);
JHtml::_('jquery.framework');
?>

	<div class="images_wrap" style="width:<?php echo $par->get('gallery_width','200');?>px"><div class="images">
		<?php if ($djMediaTools > 0 && count($this->item_images2) >= $djMediaToolsMinimum) {?>
			<div class="djc_images">
			<?php echo JHtml::_('content.prepare', '{djmedia '.(int)$djMediaTools.'}', $par, 'com_djclassifieds.item.djmediatools'); ?>
			</div>
		<?php } else { ?>
				<div class="djc_images">
					<div class="djc_mainimage">
					<?php if(count($this->item_images2)){ ?>
						<a id="djc_mainimagelink2" rel="djc_lb_0" title="<?php echo $item->name; ?>" href="<?php echo JURI::base(true).$this->item_images2[0]->thumb_b; ?>">
							<img id="djc_mainimage2" alt="<?php echo $item->name; ?>" src="<?php echo JURI::base(true).$this->item_images2[0]->thumb_b;?>" />
						</a>
					<?php }else{?>	
						<?php if($par->get('blank_img_source','0')==1){ ?>
							<img id="djc_mainimage2" class="djc_mainimage_no_image" style="width:<?php echo $par->get('gallery_width','200');?>px" alt="<?php echo $item->name; ?>" src="<?php echo DJClassifiedsImage::getCatImage($item->cat_id);?>" />
						<?php }else{ ?>
							<img id="djc_mainimage2" class="djc_mainimage_no_image" style="width:<?php echo $par->get('gallery_width','200');?>px" alt="<?php echo $item->name; ?>" src="<?php echo JURI::base(true).$par->get('blank_img_path','/components/com_djclassifieds/assets/images/').'no-image-big.png';?>" />
						<?php } ?>														
					<?php }?>	
					</div>
					<?php
					if (count($this->item_images2) > 1) { ?>
						<div class="djc_thumbnails djc_thumbs_gal<?php echo $thumbs_limit;?> " id="djc_thumbnails2">
						<?php foreach($this->item_images2 as $im=>$img){
								if($im>0 && $im%$thumbs_limit==0){
									$new_row_class = ' new_row';
								}else{
									$new_row_class = '';
								}
							 ?>
							<div class="djc_thumbnail djc_thumb_row<?php echo $new_row_class;?>">
								<a rel="<?php echo JURI::base(true).$img->thumb_b;?>" title="<?php echo $img->caption; ?>" href="<?php echo JURI::base(true).$img->thumb_b;?>">
									<img  alt="<?php echo $img->caption; ?>" src="<?php echo JURI::base(true).$img->thumb_s;?>" />
								</a>
							</div>
							<?php } ?>
							<div class="clear_both"></div>
						</div>
					<?php } ?>
					<?php for($ii=0; $ii<count($this->item_images2);$ii++ ){ ?>
						<a id="djc_lb_<?php echo $ii; ?>" class="lightbox-djitem" rel="lightbox-djitem" title="<?php echo $this->item_images2[$ii]->caption;?>" href="<?php echo JURI::base(true).$this->item_images2[$ii]->thumb_b;?>" style="display: none;"></a>
					<?php } ?>
				</div>	
			<?php } ?>
			</div></div>			
	<script type="text/javascript">
		this.DJCFImageSwitcher2 = function (){
			var mainimagelink = document.id('djc_mainimagelink2');
			var mainimage = document.id('djc_mainimage2');
			var thumbs = document.id('djc_thumbnails2') ? document.id('djc_thumbnails2').getElements('img') : null;
			var thumblinks = document.id('djc_thumbnails2') ? document.id('djc_thumbnails2').getElements('a') : null;

			<?php  if($par->get('lightbox_type','slimbox')!='magnific'){ ?>
				if(mainimagelink && mainimage) {
					mainimagelink.removeEvents('click').addEvent('click', function(evt) {
						var rel = mainimagelink.rel;
						document.id(rel).fireEvent('click', document.id(rel));
			
						//if(!/android|iphone|ipod|series60|symbian|windows ce|blackberry/i.test(navigator.userAgent)) {
							return false;
						//}
						//return true;
					});
				}
			<?php } ?>
			
			if (!mainimage || !mainimagelink || !thumblinks || !thumbs) return false;
			
			thumblinks.each(function(thumblink,index){
				var fx = new Fx.Tween(mainimage, {link: 'cancel', duration: 200});
		
				thumblink.addEvent('click',function(event){
					event.preventDefault();
					//new Event(element).stop();
					/*
					mainimage.onload = function() {
						fx.start('opacity',0,1);
					};
					*/
					var img = new Image();
					img.onload = function() {
						fx.start('opacity',0,1);
					};
					
					fx.start('opacity',1,0).chain(function(){
						mainimagelink.href = thumblink.href;
						mainimagelink.title = thumblink.title;
						mainimagelink.rel = 'djc_lb_'+index;
						img.src = thumblink.rel;
						mainimage.src = img.src;
						mainimage.alt = thumblink.title;
					});
					return false;
				});
			});
		}; 
								 
		window.addEvent('load', function(){	
			var img_width = document.id('dj-classifieds2').getElement('.djc_images').getSize().x;
			var dj_item = document.id('dj-classifieds2').getElement('.djcf_images_generaldet_box').getSize().x;
			var general_det = dj_item-img_width-1; 
			if(general_det<150){
				document.id('dj-classifieds2').getElement('.general_det').addClass('general_det_s');
			}		
			if(general_det<301){
				document.id('dj-classifieds2').getElement('.general_det').addClass('general_det_m');
			}	
			document.id('dj-classifieds2').getElement('.general_det').setStyle('width',general_det) ; 		
		});
		window.addEvent('domready', function(){		
			DJCFImageSwitcher2();
		});
	</script>				
	<?php  if($par->get('lightbox_type','slimbox')=='magnific'){ ?>
		<script type="text/javascript">
			!function($){

				$(document).ready(function(){
					
					$('#djc_mainimagelink2').click(function(e) {
					    e.preventDefault();
					    var rel = $(this).attr('rel');
						console.log(rel);
						$('#'+rel).click();
						
					   
					});
					
					
					$('.lightbox-djitem').magnificPopup({
						
						//$(this).magnificPopup({
					       // delegate: '.dj-slide-link', // the selector for gallery item
					        type: 'image',
					        mainClass: 'mfp-img-mobile',
					        gallery: {
					          enabled: true
					        },
							image: {
								verticalFit: true,
								titleSrc: 'title'
							},
							iframe: {
								patterns: {
									youtube: null,
									vimeo: null,
									link: {
										index: '/',
										src: '%id%'
									}
								}
							}
					   // });
					});
				});
			}(jQuery);
		
		</script>				
	<?php } ?>