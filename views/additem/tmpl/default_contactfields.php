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
JHTML::_('behavior.keepalive');
JHTML::_('behavior.formvalidation');
JHTML::_('behavior.modal');
JHTML::_('behavior.calendar');
$toolTipArray = array('className'=>'djcf_label');
JHTML::_('behavior.tooltip', '.Tips1', $toolTipArray);
$par = $this->par;
$id = JRequest::getVar('id', 0, '', 'int' );
$copy = JRequest::getVar('copy', 0, '', 'int' );
$token = JRequest::getCMD('token', '' );

	
	foreach($this->custom_contact_fields as $fl){
		echo '<div class="djform_row djrow_'.$fl->name.'">';
		if($fl->type=="inputbox"){
			if($id>0 || $token || $copy){
				$fl_value = $fl->value;
			}else{
				$fl_value = $fl->default_value;
			}
			$fl_value = htmlspecialchars($fl_value);

			$val_class='';
			$req = '';
			$fl_cl = '';
			if($fl->required){
				$fl_cl = 'inputbox required';
				$req = ' * ';
			}else{
				$fl_cl = 'inputbox';
			}
			
			if($fl->numbers_only){
				$fl_cl .= ' validate-numeric';
			}
			$cl = 'class="'.$fl_cl.'" ';
			

			if($par->get('show_tooltips_newad','0') && $fl->description){
				echo '<label class="label Tips1" for="dj'.$fl->name.'" title="'.$fl->description.'" id="dj'.$fl->name.'-lbl" >'.$fl->label.$req;
				echo ' <img src="'.JURI::base(true).'/components/com_djclassifieds/assets/images/tip.png" alt="?" />';
				echo '</label>';
			}else{
				echo '<label class="label" for="dj'.$fl->name.'" id="dj'.$fl->name.'-lbl" >'.$fl->label.$req.'</label>';
			}

			echo '<div class="djform_field">';

			echo '<input '.$cl.' type="text" id="dj'.$fl->name.'" name="'.$fl->name.'" '.$fl->params;
			echo ' value="'.$fl_value.'" ';
			echo ' />';
		}else if($fl->type=="textarea"){
			if($id>0 || $token || $copy){
				$fl_value = $fl->value;
			}else{
				$fl_value = $fl->default_value;
			}
			$fl_value = htmlspecialchars($fl_value);

			$val_class='';
			$req = '';
			if($fl->required){
				$cl = 'class="inputbox required" ';
				$req = ' * ';
			}else{
				$cl = 'class="inputbox"';
			}

			if($par->get('show_tooltips_newad','0') && $fl->description){
				echo '<label class="label Tips1" for="dj'.$fl->name.'" title="'.$fl->description.'" id="dj'.$fl->name.'-lbl" >'.$fl->label.$req;
				echo ' <img src="'.JURI::base(true).'/components/com_djclassifieds/assets/images/tip.png" alt="?" />';
				echo '</label>';
			}else{
				echo '<label class="label" for="dj'.$fl->name.'" id="dj'.$fl->name.'-lbl">'.$fl->label.$req.'</label>';
			}
			echo '<div class="djform_field">';
			echo '<textarea '.$cl.' id="dj'.$fl->name.'" name="'.$fl->name.'" '.$fl->params.' />';
			echo $fl_value;
			echo '</textarea>';
		}else if($fl->type=="selectlist"){
			if($id>0 || $token || $copy){
				$fl_value=$fl->value;
			}else{
				$fl_value=$fl->default_value;
			}

			$val_class='';
			$req = '';
			if($fl->required){
				$cl = 'class="inputbox required" ';
				$req = ' * ';
			}else{
				$cl = 'class="inputbox"';
			}

			if($par->get('show_tooltips_newad','0') && $fl->description){
				echo '<label class="label Tips1" for="dj'.$fl->name.'" title="'.$fl->description.'" id="dj'.$fl->name.'-lbl" >'.$fl->label.$req;
				echo ' <img src="'.JURI::base(true).'/components/com_djclassifieds/assets/images/tip.png" alt="?" />';
				echo '</label>';
			}else{
				echo '<label class="label" for="dj'.$fl->name.'" id="dj'.$fl->name.'-lbl">'.$fl->label.$req.'</label>';
			}
			echo '<div class="djform_field">';
			echo '<select '.$cl.' id="dj'.$fl->name.'" name="'.$fl->name.'" '.$fl->params.' >';
			if(substr($fl->values, -1)==';'){
				$fl->values = substr($fl->values, 0,-1);
			}
			$val = explode(';', $fl->values);
			for($i=0;$i<count($val);$i++){
				if($fl_value==$val[$i]){
					$sel="selected";
				}else{
					$sel="";
				}
				echo '<option '.$sel.' value="'.$val[$i].'">'.$val[$i].'</option>';
			}

			echo '</select>';
		}else if($fl->type=="radio"){
			if($id>0 || $token || $copy){
				$fl_value=$fl->value;
			}else{
				$fl_value=$fl->default_value;
			}

			$val_class='';
			$req = '';
			if($fl->required){
				$cl = 'class="required validate-radio" ';
				$req = ' * ';
			}else{
				$cl = 'class=""';
			}

			if($par->get('show_tooltips_newad','0') && $fl->description){
				echo '<label class="label Tips1" for="dj'.$fl->name.'" title="'.$fl->description.'" id="dj'.$fl->name.'-lbl" >'.$fl->label.$req;
				echo ' <img src="'.JURI::base(true).'/components/com_djclassifieds/assets/images/tip.png" alt="?" />';
				echo '</label>';
			}else{
				echo '<label class="label" for="dj'.$fl->name.'" id="dj'.$fl->name.'-lbl">'.$fl->label.$req.'</label>';
			}
			echo '<div class="djform_field">';
			if(substr($fl->values, -1)==';'){
				$fl->values = substr($fl->values, 0,-1);
			}
			$val = explode(';', $fl->values);
			echo '<div class="radiofield_box" style="float:left">';
			for($i=0;$i<count($val);$i++){
				$checked = '';
				if($fl_value == $val[$i]){
					$checked = 'CHECKED';
				}

				echo '<div style="float:left;"><input type="radio" '.$cl.'  '.$checked.' value ="'.$val[$i].'" name="'.$fl->name.'" /><span class="radio_label">'.$val[$i].'</span></div>';
				echo '<div class="clear_both"></div>';
			}
			echo '</div>';
		}else if($fl->type=="checkbox"){
			$val_class='';
			$req = '';
			if($id>0 || $token || $copy){
				$fl_value = $fl->value;
			}else{
				$fl_value = $fl->default_value;
			}

			if($fl->required){
				$cl = 'class="checkboxes required" ';
				$req = ' * ';
			}else{
				$cl = 'class=""';
			}
			if($par->get('show_tooltips_newad','0') && $fl->description){
				echo '<label class="label Tips1" for="dj'.$fl->name.'" title="'.$fl->description.'" id="dj'.$fl->name.'-lbl" >'.$fl->label.$req;
				echo ' <img src="'.JURI::base(true).'/components/com_djclassifieds/assets/images/tip.png" alt="?" />';
				echo '</label>';
			}else{
				echo '<label class="label" for="dj'.$fl->name.'" id="dj'.$fl->name.'-lbl">'.$fl->label.$req.'</label>';
			}
			echo '<div class="djform_field">';
			if(substr($fl->values, -1)==';'){
				$fl->values = substr($fl->values, 0,-1);
			}
			$val = explode(';', $fl->values);
			echo '<div class="radiofield_box" style="float:left">';
			echo '<fieldset id="dj'.$fl->name.'" '.$cl.' >';
			for($i=0;$i<count($val);$i++){
				$checked = '';
				if($id>0 || $token || $copy){
					if(strstr($fl->value,';'.$val[$i].';' )){
						$checked = 'CHECKED';
					}
				}else{
					$def_val = explode(';', $fl->default_value);
					for($d=0;$d<count($def_val);$d++){
						if($def_val[$d] == $val[$i]){
							$checked = 'CHECKED';
						}
					}

				}

				echo '<div style="float:left;"><input type="checkbox" id="dj'.$fl->name.$i.'" class="checkbox" '.$checked.' value ="'.$val[$i].'" name="'.$fl->name.'[]" /><span class="radio_label">'.$val[$i].'</span></div>';
				echo '<div class="clear_both"></div>';
			}
			echo '</fieldset>';
			echo '</div>';
		}else if($fl->type=="date"){


			if($id>0 || $token || $copy){
				$fl_value = $fl->value_date;
			}else{
				if($fl->default_value=='current_date'){
					$fl_value = date("Y-m-d");
				}else{
					$fl_value = $fl->default_value;
				}
			}

			$val_class='';
			$req = '';
			if($fl->required){
				$cl = 'class="inputbox required djcalendar" ';
				$req = ' * ';
			}else{
				$cl = 'class="inputbox djcalendar"';
			}

			if($par->get('show_tooltips_newad','0') && $fl->description){
				echo '<label class="label Tips1" for="dj'.$fl->name.'" title="'.$fl->description.'" id="dj'.$fl->name.'-lbl" >'.$fl->label.$req;
				echo ' <img src="'.JURI::base(true).'/components/com_djclassifieds/assets/images/tip.png" alt="?" />';
				echo '</label>';
			}else{
				echo '<label class="label" for="dj'.$fl->name.'" id="dj'.$fl->name.'-lbl" >'.$fl->label.$req.'</label>';
			}

			echo '<div class="djform_field">';

			echo '<input '.$cl.' type="text" size="10" maxlenght="19" id="dj'.$fl->name.'" name="'.$fl->name.'" '.$fl->params;
			echo ' value="'.$fl_value.'" ';
			echo ' />';
			echo ' <img class="calendar" src="'.JURI::base(true).'/components/com_djclassifieds/assets/images/calendar.png" alt="calendar" id="dj'.$fl->name.'button" />';


		}else if($fl->type=="date_from_to"){


			if($id>0 || $token || $copy){
				$fl_value = $fl->value_date;
				$fl_value_to = $fl->value_date_to;
			}else{
				if($fl->default_value=='current_date'){
					$fl_value = date("Y-m-d");
					$fl_value_to = date("Y-m-d");
				}else{
					$fl_value = $fl->default_value;
					$fl_value_to = $fl->default_value;
				}
			}

			$val_class='';
			$req = '';
			if($fl->required){
				$cl = 'class="inputbox required djcalendar" ';
				$req = ' * ';
			}else{
				$cl = 'class="inputbox djcalendar"';
			}

			if($par->get('show_tooltips_newad','0') && $fl->description){
				echo '<label class="label Tips1" for="dj'.$fl->name.'" title="'.$fl->description.'" id="dj'.$fl->name.'-lbl" >'.$fl->label.$req;
				echo ' <img src="'.JURI::base(true).'/components/com_djclassifieds/assets/images/tip.png" alt="?" />';
				echo '</label>';
			}else{
				echo '<label class="label" for="dj'.$fl->name.'" id="dj'.$fl->name.'-lbl" >'.$fl->label.$req.'</label>';
			}

			echo '<div class="djform_field">';

			echo '<input '.$cl.' type="text" size="10" maxlenght="19" id="dj'.$fl->name.'" name="'.$fl->name.'" '.$fl->params;
			echo ' value="'.$fl_value.'" ';
			echo ' />';
			echo ' <img class="calendar" src="'.JURI::base(true).'/components/com_djclassifieds/assets/images/calendar.png" alt="calendar" id="dj'.$fl->name.'button" />';
			
			echo '<span class="date_from_to_sep"> - </span>';
			
			echo '<input '.$cl.' type="text" size="10" maxlenght="19" id="dj'.$fl->name.'_to" name="'.$fl->name.'_to" '.$fl->params;
			echo ' value="'.$fl_value_to.'" '; 
			echo ' />';
			echo ' <img class="calendar" src="'.JURI::base(true).'/components/com_djclassifieds/assets/images/calendar.png" alt="calendar" id="dj'.$fl->name.'_tobutton" />';
				


		}else if($fl->type=="link"){
			if($id>0 || $token || $copy){
				$fl_value = $fl->value;
			}else{
				$fl_value = $fl->default_value;
			}
			$fl_value = htmlspecialchars($fl_value);

			$val_class='';
			$req = '';
			if($fl->required){
				$cl = 'class="inputbox required" ';
				$req = ' * ';
			}else{
				$cl = 'class="inputbox"';
			}

			if($par->get('show_tooltips_newad','0') && $fl->description){
				echo '<label class="label Tips1" for="dj'.$fl->name.'" title="'.$fl->description.'" id="dj'.$fl->name.'-lbl" >'.$fl->label.$req;
				echo ' <img src="'.JURI::base(true).'/components/com_djclassifieds/assets/images/tip.png" alt="?" />';
				echo '</label>';
			}else{
				echo '<label class="label" for="dj'.$fl->name.'" id="dj'.$fl->name.'-lbl" >'.$fl->label.$req.'</label>';
			}

			echo '<div class="djform_field">';

			echo '<input '.$cl.' type="text" id="dj'.$fl->name.'" name="'.$fl->name.'" '.$fl->params;
			echo ' value="'.$fl_value.'" ';
			echo ' />';
		}else{
			echo '<div class="djform_field">';
		}

		echo '</div><div class="clear_both"></div>';
		echo '</div>';
	}






?>