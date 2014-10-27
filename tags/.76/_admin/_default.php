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
		if($weekday_closehour=="" && $weekday_closeminute!=""){$errorMessage="weekday_CLose"; ${'error_'.$weekday."_Close"}='y';}
		if($weekday_Open!="" && $weekday_Close==""){$errorMessage="weekday_Close"; ${'error_'.$weekday."_Open"}='y'; ${'error_'.$weekday."_Close"}='y';}
		if($weekday_Open=="" && $weekday_Close!=""){$errorMessage="weekday_Open"; ${'error_'.$weekday."_Open"}='y'; ${'error_'.$weekday."_Close"}='y';}
		if($weekday_Break!="" && $weekday_Return==""){$errorMessage="weekday_Return"; ${'error_'.$weekday."_Break"}='y'; ${'error_'.$weekday."_Return"}='y';}
		if($weekday_Break=="" && $weekday_Return!=""){$errorMessage="weekday_Break"; ${'error_'.$weekday."_Break"}='y'; ${'error_'.$weekday."_Return"}='y';}
	}

	//======= SAVE
	if($errorMessage==""){
		$updateIt=mysql_query("UPDATE skedmaker_users SET ".$weekday."live='$weekday_live', ".$weekday."increment='$weekday_increment', ".$weekday."multiple='$weekday_multiple', ".$weekday."openhour='$weekday_openhour', ".$weekday."openminute='$weekday_openminute', ".$weekday."breakhour='$weekday_breakhour', ".$weekday."breakminute='$weekday_breakminute', ".$weekday."returnhour='$weekday_returnhour', ".$weekday."returnminute='$weekday_returnminute', ".$weekday."closehour='$weekday_closehour', ".$weekday."closeminute='$weekday_closeminute'") or die(mysql_error());
		if(!$updateIt){
			SM_redBox("Sorry, could not update your default settings.<br><br>Please try again later.", 800,21);
		}else{
			SM_greenBox("Saved ".ucwords($weekday)."!", 800, 21);
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
<td class='g666'><div class='nav666'><a href='#monday' class='sked'><span style='font-size:12px;'>Monday</span></a></div></td>
<td class='g666'><div class='nav666'><a href='#tuesday' class='sked'><span style='font-size:12px;'>Tuesday</a></div></td>
<td class='g666'><div class='nav666'><a href='#wednesday' class='sked'><span style='font-size:12px;'>Wednesday</a></div></td>
<td class='g666'><div class='nav666'><a href='#thursday' class='sked'><span style='font-size:12px;'>Thursday</a></div></td>
<td class='g666'><div class='nav666'><a href='#friday' class='sked'><span style='font-size:12px;'>Friday</a></div></td>
<td class='g666'><div class='nav666'><a href='#saturday' class='sked'><span style='font-size:12px;'>Saturday</a></div></td>
<td class='g666'><div class='nav666'><a href='#sunday' class='sked'><span style='font-size:12px;'>Sunday</a></div></td>
</tr>
</table>
<br />

To set up a more complicated set of timeframes and apply them to specific days of the year, create a <a href='<?php echo $smadmin;?>&amp;v=customdays&amp;' class='sked'>Custom Day Setting here</a>.
<br />
<!-- <a href='?op=cntct&amp;sc=home' style='font-weight:normal'><span class='smallG'>Please contact us if you need help.</span></a> -->
</td></tr></table>
</td></tr></table>

<?php 
SM_day_settings("monday",  $error_monday_Open, $error_monday_Break, $error_monday_Return, $error_monday_Close, $errorMessage);
SM_day_settings("tuesday", $error_tuesday_Open, $error_tuesday_Break, $error_tuesday_Return, $error_tuesday_Close, $errorMessage);
SM_day_settings("wednesday", $error_wednesday_Open, $error_wednesday_Break, $error_wednesday_Return, $error_wednesday_Close, $errorMessage);
SM_day_settings("thursday", $error_thursday_Open, $error_thursday_Break, $error_thursday_Return, $error_thursday_Close, $errorMessage);
SM_day_settings("friday", $error_friday_Open, $error_friday_Break, $error_friday_Return, $error_friday_Close, $errorMessage);
SM_day_settings("saturday", $error_saturday_Open, $error_saturday_Break, $error_saturday_Return, $error_saturday_Close, $errorMessage);
SM_day_settings("sunday", $error_sunday_Open, $error_sunday_Break, $error_sunday_Return, $error_sunday_Close, $errorMessage);
?>