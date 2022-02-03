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
$app	 = JFactory::getApplication();
$Itemid = JRequest::getInt('Itemid', 0);

if($Itemid){
	$menu_item = $app->getMenu()->getItem($Itemid);
	if($menu_item){
		$pc_sfx = $menu_item->params->get('pageclass_sfx');
	}
	if($pc_sfx){$pageclass_sfx =' '.$pc_sfx;}
	$active_m = $app->getMenu('site')->getActive();
}
?>
<div id="dj-classifieds" class="clearfix registration-complete djcftheme-<?php echo $this->theme;?><?php echo $pageclass_sfx;?>">
<?php
	if($Itemid){
		if($active_m->params->get('show_page_heading','1')){
			echo '<h1 class="main_cat_title">'; 
				if($active_m->params->get('page_title','')){
					echo $active_m->params->get('page_title','');
				}else{
					echo $active_m->title;
				}
			echo '</h1>';	
		}
	} ?>
</div>

