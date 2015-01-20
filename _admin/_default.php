<?
if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['v']=='default'){
	$errorMessage="";
	$weekday=$_POST['this_weekday'];
	$weekday_live=$_POST[$weekday.'_live'];
	$weekday_increment=$_POST[$weekday.'_increment'];
	$weekday_multiple=$_POST[$weekday.'_multiple'];
	$weekday_openhour=$_POST[$weekday.'_openhour'];
 	$weekday_openminute=$_POST[$weekday.'_openminute'];
	$weekday_breakhour=$_POST[$weekday.'_breakhour'];
	$weekday_breakminute=$_POST[$weekday.'_breakminute'];
	$weekday_returnhour=$_POST[$weekday.'_returnhour'];
	$weekday_returnminute=$_POST[$weekday.'_returnminute'];
	$weekday_closehour=$_POST[$weekday.'_closehour'];
	$weekday_closeminute=$_POST[$weekday.'_closeminute'];

	$weekday_Open=$weekday_openhour.$weekday_openminute;
	$weekday_Break=$weekday_breakhour.$weekday_breakminute;
	$weekday_Return=$weekday_returnhour.$weekday_returnminute;
	$weekday_Close=$weekday_closehour.$weekday_closeminute;

	if($weekday_Break!="" && $weekday_Return!=""){$weekday_IsBreak='y';}else{$weekday_IsBreak='n';}

	//======= CHECKS
	if($weekday_live=='y'){
		if($weekday_IsBreak=="n"){
			if($weekday_Open>$weekday_Close){$errorMessage="weekday_Open"; ${'error_'.$weekday."_Open"}='y';}
			if($weekday_Close<$weekday_Open){$errorMessage="weekday_Close"; ${'error_'.$weekday."_Close"}='y';}
		}else{
			if($weekday_Open>$weekday_Break || $weekday_Open>$weekday_Return || $weekday_Open>$weekday_Close){$errorMessage="weekday_Open"; ${'error_'.$weekday."_Open"}='y';}
			if($weekday_Break>$weekday_Return || $weekday_Break>$weekday_Close || $weekday_Break<$weekday_Open){$errorMessage="weekday_Break"; ${'error_'.$weekday."_Break"}='y';}
			if($weekday_Return>$weekday_Close || $weekday_Return<$weekday_Break || $weekday_Return<$weekday_Open){$errorMessage="weekday_Return"; ${'error_'.$weekday."_Return"}='y';}
			if($weekday_Close<$weekday_Return || $weekday_Close<$weekday_Break || $weekday_Close<$weekday_Open){$errorMessage="weekday_Close"; ${'error_'.$weekday."_Close"}='y';}
		}

		if($weekday_openhour!="" && $weekday_openminute==""){$errorMessage="weekday_Open"; ${'error_'.$weekday."_Open"}='y';}
		if($weekday_openhour=="" && $weekday_openminute!=""){$errorMessage="weekday_Open"; ${'error_'.$weekday."_Open"}='y';}
		if($weekday_breakhour!="" && $weekday_breakminute==""){$errorMessage="weekday_Break"; ${'error_'.$weekday."_Break"}='y';}
		if($weekday_breakhour=="" && $weekday_breakminute!=""){$errorMessage="weekday_Break"; ${'error_'.$weekday."_Break"}='y';}
		if($weekday_returnhour!="" && $weekday_returnminute==""){$errorMessage="weekday_Return"; ${'error_'.$weekday."_Return"}='y';}
		if($weekday_returnhour=="" && $weekday_returnminute!=""){$errorMessage="weekday_Return"; ${'error_'.$weekday."_Return"}='y';}
		if($weekday_closehour!="" && $weekday_closeminute==""){$errorMessage="weekday_Close"; ${'error_'.$weekday."_Close"}='y';}
		if($weekday_closehour=="" && $weekday_closeminute!=""){$errorMessage="weekday_Close"; ${'error_'.$weekday."_Close"}='y';}
		if($weekday_Open!="" && $weekday_Close==""){$errorMessage="weekday_Close"; ${'error_'.$weekday."_Open"}='y'; ${'error_'.$weekday."_Close"}='y';}
		if($weekday_Open=="" && $weekday_Close!=""){$errorMessage="weekday_Open"; ${'error_'.$weekday."_Open"}='y'; ${'error_'.$weekday."_Close"}='y';}
		if($weekday_Break!="" && $weekday_Return==""){$errorMessage="weekday_Return"; ${'error_'.$weekday."_Break"}='y'; ${'error_'.$weekday."_Return"}='y';}
		if($weekday_Break=="" && $weekday_Return!=""){$errorMessage="weekday_Break"; ${'error_'.$weekday."_Break"}='y'; ${'error_'.$weekday."_Return"}='y';}


//		if($weekday_openminute=="15" && $weekday_increment!="quarter"){$errorMessage="y"; ${'error_'.$weekday."_length_open"}='y';}
//		if($weekday_closeminute=="15" && $weekday_increment!="quarter"){$errorMessage="y"; ${'error_'.$weekday."_length_close"}='y';}
//		if(($weekday_openminute=="30" || $weekday_open_minute=="00") && $weekday_increment!="halfhour"){$errorMessage="y"; ${'error_'.$weekday."_length_open"}='y';}
//		if(($weekday_closeminute=="30"  || $weekday_open_minute=="00")&& $weekday_increment!="halfhour"){$errorMessage="y"; ${'error_'.$weekday."_length_close"}='y';}
//		if($weekeday_increment==$weekday_openminute=="30" && $weekday_increment!="Half Hour"){$errorMessage="y"; $errorOpenIncrement="y";}

	}

	//======= SAVE
	if($errorMessage==""){
		$updateIt=mysql_query("UPDATE skedmaker_users SET ".$weekday."live='$weekday_live', ".$weekday."increment='$weekday_increment', ".$weekday."multiple='$weekday_multiple', ".$weekday."openhour='$weekday_openhour', ".$weekday."openminute='$weekday_openminute', ".$weekday."breakhour='$weekday_breakhour', ".$weekday."breakminute='$weekday_breakminute', ".$weekday."returnhour='$weekday_returnhour', ".$weekday."returnminute='$weekday_returnminute', ".$weekday."closehour='$weekday_closehour', ".$weekday."closeminute='$weekday_closeminute'") or die(mysql_error());
		if(!$updateIt){
			SM_redBox("Sorry, could not update your default settings.<br><br>Please try again later.", "100%",21);
		}else{
			SM_greenBox("Saved ".ucwords($weekday)."!", "100%", 21);
			SM_redirect($smadmin."&v=default&#".$weekday, 500);
			die();
		}
	}
}

SM_title("Default Schedule Settings", "btn_settings32_reg.png", $smadmin."&v=default&amp;"); 
?>

<table class='cc800'>
<tr><td class='blueBanner1'>Select the default settings for each day of your schedule.</td></tr>
<tr><td class='blueBanner2' style='padding:0px;'>
<?php SM_menu();?>
<table class='cc100'><tr><td class='pad14'>
<table style='border-spacing:7px; border-collapse:separate; width:100%;'><tr>
<td class='pad7b2' style='text-align:center;'><div class='navDefaultDays'><a href='#monday'>Monday</a></div></td>
<td class='pad7b2' style='text-align:center;'><div class='navDefaultDays'><a href='#tuesday'>Tuesday</a></div></td>
<td class='pad7b2' style='text-align:center;'><div class='navDefaultDays'><a href='#wednesday'>Wednesday</a></div></td>
<td class='pad7b2' style='text-align:center;'><div class='navDefaultDays'><a href='#thursday'>Thursday</a></div></td>
<td class='pad7b2' style='text-align:center;'><div class='navDefaultDays'><a href='#friday'>Friday</a></div></td>
<td class='pad7b2' style='text-align:center;'><div class='navDefaultDays'><a href='#saturday'>Saturday</a></div></td>
<td class='pad7b2' style='text-align:center;'><div class='navDefaultDays'><a href='#sunday'>Sunday</a></div></td>
</tr>
</table>
<br />

To set up a more complicated set of timeframes and apply them to specific days of the year, create a <a href='<?php echo $smadmin;?>&amp;v=customdays&amp;' class='sked'>Custom Day Setting here</a>.
<br />
</td></tr></table>
</td></tr></table>

<?php 
SM_day_settings("monday",  $error_monday_Open, $error_monday_Break, $error_monday_Return, $error_monday_Close, $errorMessage, $error_monday_length_open, $error_monday_length_close);
SM_day_settings("tuesday", $error_tuesday_Open, $error_tuesday_Break, $error_tuesday_Return, $error_tuesday_Close, $errorMessage, $error_tuesday_length_open, $error_tuesday_length_close);
SM_day_settings("wednesday", $error_wednesday_Open, $error_wednesday_Break, $error_wednesday_Return, $error_wednesday_Close, $errorMessage, $error_wednesday_length_open, $error_wednesday_length_close);
SM_day_settings("thursday", $error_thursday_Open, $error_thursday_Break, $error_thursday_Return, $error_thursday_Close, $errorMessage, $error_thursday_length_open, $error_thursday_length_close);
SM_day_settings("friday", $error_friday_Open, $error_friday_Break, $error_friday_Return, $error_friday_Close, $errorMessage, $error_friday_length_open, $error_friday_length_close);
SM_day_settings("saturday", $error_saturday_Open, $error_saturday_Break, $error_saturday_Return, $error_saturday_Close, $errorMessage, $error_saturday_length_open, $error_saturday_length_close);
SM_day_settings("sunday", $error_sunday_Open, $error_sunday_Break, $error_sunday_Return, $error_sunday_Close, $errorMessage, $error_sunday_length_open, $error_sunday_length_close);
?>