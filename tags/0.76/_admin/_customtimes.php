<?php 
$datecode=$_GET['dc'];

$countIt=mysql_query("SELECT * FROM skedmaker_custom WHERE datecode='$datecode'");
$total_dc=mysql_num_rows($countIt);


$countIt=mysql_query("SELECT * FROM skedmaker_custom_timeframes WHERE datecode='$datecode'");
$total_tc=mysql_num_rows($countIt);

$result=mysql_query("SELECT * FROM skedmaker_custom WHERE datecode='$datecode' LIMIT 1");
while($row = mysql_fetch_array($result)){
	$customName=SM_d($row['name']);
}

//==================================================================================================
//======= DELETE Timeframe
//==================================================================================================
if($op=='deltime'){
	$timecode=$_GET['tc'];
	$saveIt=mysql_query("DELETE from skedmaker_custom_timeframes WHERE timecode='$timecode'");
	if(!$saveIt){
		SM_redBox("Could not delete time frame, try again later.", 800, 21);
	}else{
		SM_greenBox("Deleted Timeframe!", 800, 21);
		SM_redirect($smadmin."&v=customtimes&dc=".$datecode."&", 500);
		die();
	}
}

//================================================================================================== 
//======= ADD / EDIT TIMEFRAMES
//==================================================================================================
if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['op']=="addedit"){
	$setmultiple=$_POST['setmultiple'];
	$starthour=$_POST['starthour'];
	$startminute=$_POST['startminute'];
	$endhour=$_POST['endhour'];
	$endminute=$_POST['endminute'];

	if($endhour=="" || $endminute==""){$errorMessage="y"; $errorStart='y';}
	if($starthour=="" || $startminute==""){$errorMessage="y"; $errorEnd='y';}

	$check_starttime=SM_timestamp("1975-06-06 ".$starthour.":".$startminute.".00");
	$check_endtime=SM_timestamp("1975-06-06 ".$endhour.":".$endminute.".00");
	if($check_starttime>$check_endtime){$errorMessage="y"; $errorEnd='y';}
	

	if($errorMessage==""){
		//-- EDIT
		if($_GET['tc']!=""){
			$timecode=$_GET['tc'];
			$saveIt=mysql_query("UPDATE skedmaker_custom_timeframes SET multiple='$setmultiple', starthour='$starthour', startminute='$startminute', endhour='$endhour', endminute='$endminute' WHERE timecode='$timecode' LIMIT 1")or die(mysql_error());
			$save_message="Edited Timeframe!";
		//-- NEW
		}else{
			$timecode=SM_code();
			$saveIt=mysql_query("INSERT INTO skedmaker_custom_timeframes (name, date, showDate, multiple, starthour, startminute, endhour, endminute, datecode, timecode)VALUES('$name', '$today', '$showDate', '$setmultiple', '$starthour', '$startminute', '$endhour', '$endminute', '$datecode', '$timecode')")or die(mysql_error());
			$save_message="Saved Time Frame!";
		}

		//======= SAVE IT
		if(!$saveIt){
			SM_redBox("Could not save the timeframe, try again later.", 800, 21);
		}else{
			SM_greenBox($save_message, 800, 21);
			SM_redirect($smadmin."&v=customtimes&dc=".$datecode."&", 500);
			die();
		}
	}
}
//==================================================================================================
//======= EDIT / NEW
//==================================================================================================
SM_title("Add Time Frames", "btn_timeframes32_reg.png", "?v=customtimes&amp;dc=".$_GET['dc']."&amp;tc=".$_GET['tc']."&amp;"); 
if($total_dc>0){ 
	if($_GET['tc']!=""){
		$timecode=$_GET['tc'];
		$result=mysql_query("SELECT * FROM skedmaker_custom_timeframes WHERE datecode='$datecode' AND timecode='$timecode'");
		while($row = mysql_fetch_array($result)){
			$starthour=SM_d($row['starthour']);
			$startminute=SM_d($row['startminute']);
			$endhour=SM_d($row['endhour']);
			$endminute=SM_d($row['endminute']);
			$setmultiple=SM_d($row['multiple']);
			$timecode=SM_d($row['timecode']);
			$starttime=SM_showTime($starthour, $startminute);
			$endtime=SM_showTime($endhour, $endminute);
		}
	}

if($errorMessage!=""){SM_redBox("There was an error, correct the fields in red below...", 800, 21); echo "<bR>";}
?>
<form name="form1" method="post" action="<?php echo $smadmin;?>&amp;v=customtimes&amp;op=addedit&amp;dc=<?php echo $_GET['dc']; if($_GET['tc']!=""){echo "&amp;tc=".$_GET['tc'];}?>&amp;" style="margin:0px;">
<table class='cc800'><tr>
<td class='blueBanner1'>
<?php if($_GET['tc']!=""){echo "Editing Timeframe for ".$customName;}else{echo "Add More Timeframes to '".$customName."'";} ?>
</td></tr>

<td class='blueBanner2' style='padding:0px;'>
<?php SM_menu();?><br>
<table class='cc100'>
<?php if($_GET['tc']!=""){ ?><tr><td colspan='2' style='padding:7px; text-align:center;'><?php SM_blueBox("<br>You are editing a timeframe. <a href='".$smadmin."&amp;v=customtimes&amp;dc=".$_GET['dc']."' class='sked'>Click here to add a new timeframe.<br><br>","100%", 16);?></td></tr><?php } ?>
<tr>
<td class='label150'><?php SM_check_text("Start Time:", $errorStart);?></td>
<td class="pad7" style='width:650px;'>
<select name="starthour" id="starthour" class='form_select'><?php SM_hours($starthour,0);?></select>
<select name="startminute" id="startminute" class='form_select'>
<option value=''>Minute...</option>
<option <?php if($startminute=="00"){?> selected='selected'<?php } ?>>00</option>
<option <?php if($startminute=="15"){?> selected='selected'<?php } ?>>15</option>
<option <?php if($startminute=="30"){?> selected='selected'<?php } ?>>30</option>
<option <?php if($startminute=="45"){?> selected='selected'<?php } ?>>45</option>
</select>
</td></tr>

<td class='label150'><?php SM_check_text("End Time:", $errorEnd);?></td>
<td class="pad7" style='width:650px;'>
<select name="endhour" id="endhour" class='form_select'><?php SM_hours($endhour,0);?></select>
<select name="endminute" id="endminute" class='form_select'>
<option value=''>Minute...</option>
<option <?php if($endminute=="00"){?> selected='selected'<?php } ?>>00</option>
<option <?php if($endminute=="15"){?> selected='selected'<?php } ?>>15</option>
<option <?php if($endminute=="30"){?> selected='selected'<?php } ?>>30</option>
<option <?php if($endminute=="45"){?> selected='selected'<?php } ?>>45</option>
</select>
</td></tr>

<tr><td class="label150"># Appointments:</td>
<td class="pad7" style='width:650px;'><select name="setmultiple" id="setmultiple" class='form_select'><?php SM_multiple($setmultiple); ?></select></td>
</tr>

<tr><td class='label150' style='padding-bottom:21px;'><a href='<?php echo $smadmin;?>&amp;v=customdays&amp;op=new&amp;' class='sked'><span class='smallG'>< Back to list</span></a></td>
<td class='pad7' style='padding-bottom:21px;'><input type="submit" name="button" id="button" value="<?php if($_GET['tc']!=""){echo "Save Edits";}else{echo "Add Timeframe";}?>"></td>
</tr>

</table>
</td></tr></table>
</form>
<br>

<?php 
//==================================================================================================
//======= LIST
//==================================================================================================

if($total_tc>0){

	$result=mysql_query("SELECT name FROM skedmaker_custom WHERE datecode='$datecode' LIMIT 1");
	while($row=mysql_fetch_array($result)){$DBname=SM_d($row['name']);}
	?>
	<table class='cc800'>
    <tr><td class='blueBanner1'>Current Time Frames for '<?php echo $DBname; ?>'</td></tr>
    <tr><td class='blueBanner2' style='padding:0px;'>
	<table class='cc100'><tr style='background-color:#666;'>
	<td class='pad7' style='padding-left:14px; width:150px;'><span style='font-weight:bold; color:#fff;'>Start Time</span></td>
	<td class='pad7' style='width:150px;'><span style='font-weight:bold; color:#fff;'>End Time</span></td>
	<td class='pad7' style='width:250px;'><span style='font-weight:bold; color:#fff;'># Appointments Allowed</span></td>
	<td class='pad7' style='width:150px;'><b></b></td>
	<td class='pad7' style='width:50px;'><b></b></td>
	<td class='pad7' style='width:50px;'><b></b></td>
	</tr>
<?php
	$result=mysql_query("SELECT * FROM skedmaker_custom_timeframes WHERE datecode='$datecode' ORDER BY starthour, startminute");
	while($row = mysql_fetch_array($result)){
		$LIST_starthour=SM_d($row['starthour']);
		$LIST_startminute=SM_d($row['startminute']);
		$LIST_endhour=SM_d($row['endhour']);
		$LIST_endminute=SM_d($row['endminute']);
		$LIST_setmultiple=SM_d($row['multiple']);
		$LIST_timecode=SM_d($row['timecode']);
		$LIST_starttime=SM_showTime($LIST_starthour, $LIST_startminute);
		$LIST_endtime=SM_showTime($LIST_endhour, $LIST_endminute);
		$stagger=SM_stagger($stagger);
		?>
		<td class='list_left' style='padding-left:14px; border-left:0px; width:150px'><?php echo $LIST_starttime; ?></td>
		<td class='list_center' style='width:150px;'><?php echo $LIST_endtime;?></td>
		<td class='pad7' style='width:150px;'><?php echo $LIST_setmultiple;?></td>
		<td class='list_center' style='width:250px;'>&nbsp;</td>
		<td class='pad7' style='width:50px;'><a href='<?php echo $smadmin;?>&amp;v=customtimes&amp;op=new&amp;dc=<?php echo $datecode;?>&amp;tc=<?php echo $LIST_timecode;?>&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_edit16_reg.png' alt='Edit' style='border:0px;'></a></td>
		<td class='pad7' style='width:50px;'><a href='<?php echo $smadmin;?>&amp;v=customtimes&amp;op=deltime&amp;dc=<?php echo $datecode;?>&amp;tc=<?php echo $LIST_timecode;?>&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_delete16_reg.png' alt='Delete' style='border:0px;'></a></td>
		</tr>
<?php 	} ?>
	</table>
    </td></tr></table>
<?php 
}else{
	SM_blueBox("<bR>No timeframes yet for this Custom Day.<bR><bR>", 800, 21);	
}
}else{
	SM_redBox("Sorry, this is not a valid Custom Day Setting.", 800, 21); ?>
    <bR><bR>
    <table class='cc800'>
    <tr><td class='blueBanner2' style='padding:0px;'>
    <table class='cc100'><tr>
    <td class='nopad' style='width:40%;'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=customdays&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_custom16reg.png' class='btn' alt='Select a different custom setting' />Select a Different Custom Setting</a></div></td>
    <td class='nopad' style='width:18%;'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=home&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_home16_reg.png' class='btn' alt='Admin Home'/>Admin Home</a></div></td>
    <td class='nopad' style='width:42%;'>&nbsp;</td>
    </tr></table>
    </td></tr></table>
<?php
} 
SM_foot();
?>