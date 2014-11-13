<?php 
//------- get current day month year
$month=date('m');
$year=date('Y');
$datecode=$_GET['dc'];

$result=mysql_query("SELECT name FROM skedmaker_custom WHERE datecode='$datecode' AND name!='' LIMIT 1");
while($row = mysql_fetch_array($result)) {$customName=SM_d($row['name']);}

if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['v']=='customapply' && $_GET['op']!="removecustom"){
	for($loopMonth=$month; $loopMonth<13; $loopMonth++){
		$first_day = mktime(0,0,0,$loopMonth, 1, $year); //generate the first day of the month  
		$firstDigit=substr($loopMonth, 0, 1);

		if($loopMonth<10 && $firstDigit!=0){$loopMonth="0".$loopMonth;}
		$title=date('F', $first_day); //get the month name

		$dayLimit=date('d');
		$monthLimit=date('m');
		$yearLimit=date('Y');

		//Here we find out what day of the week the first day of the month falls on 
		$day_of_week = date('D', $first_day) ;
		//Once we know what day of the week it falls on, we know how many blank days occure before it. If the first day of the week is a Sunday then it would be zero
		switch($day_of_week){
			case "Sun": $blank = 0; break;
			case "Mon": $blank = 1; break;
			case "Tue": $blank = 2; break;
			case "Wed": $blank = 3; break;
			case "Thu": $blank = 4; break;
			case "Fri": $blank = 5; break;
			case "Sat": $blank = 6; break;
		}
		//We then determine how many days are in the current month 
		$days_in_month = cal_days_in_month(0, $loopMonth, $year);
		
		$day_count = 1;  
		//take care of blank days
		while ($blank>0){
			$blank = $blank-1;
			$day_count++;
		}

		//set first day of the month to 1
		$day_num = 1;
		//count up the days, untill we've done all of them in the month 
		while($day_num <= $days_in_month){
			if($day_num<10){
				$day_num="0".$day_num;
			}
			$theCheckBox=$_POST[$year."-".$loopMonth."-".$day_num];

			//------- SAVING TO DB
			if($theCheckBox!=""){
//				echo $theCheckBox."<bR>";
				$customChunk=explode("-", $theCheckBox);
				$customYear=$customChunk[0];
				$customMonth=$customChunk[1];
				$customDay=$customChunk[2];

				$customMonthDisplay=SM_displayMonth($customMonth);
				$customDateDisplay=$customMonthDisplay." ".$customDay.", ".$customYear;

				$customdate=$customYear."-".$customMonth."-".$customDay;
				$DBcode=SM_code();
				$saveIt=mysql_query("INSERT INTO skedmaker_custom_sked (datecode, date, year, month, day, weekday, name, code)VALUES('$datecode', '$theCheckBox', '$customYear', '$customMonth', '$customDay', '$weekday', '$customName', '$DBcode')")or die(mysql_error());
				if(!$saveIt){
					SM_redBox("Could not save ".$customDateDisplay." as a custom day, try again later", 800, 18);
				}else{
					SM_greenBox("Saved $customDateDisplay as custom day '$customName'", 800, 18);
					$save_SUCCESS='y';
				}
			}
			$day_num++;
			$day_count++;
		}
		$day=1;
	}

///////////////////////////////////////////////////////////////// SECOND YEAR //////////////////////////////////////////////////////////////////////

$year++;

	for($loopMonth=1; $loopMonth<13; $loopMonth++){
		$first_day = mktime(0,0,0,$loopMonth, 1, $year); //generate the first day of the month  
		$firstDigit=substr($loopMonth, 0, 1);

		if($loopMonth<10 && $firstDigit!=0){$loopMonth="0".$loopMonth;}
		$title=date('F', $first_day); //get the month name

		$dayLimit=date('d');
		$monthLimit=date('m');
		$yearLimit=date('Y');

		//Here we find out what day of the week the first day of the month falls on 
		$day_of_week = date('D', $first_day) ;
		//Once we know what day of the week it falls on, we know how many blank days occure before it. If the first day of the week is a Sunday then it would be zero
		switch($day_of_week){
			case "Sun": $blank = 0; break;
			case "Mon": $blank = 1; break;
			case "Tue": $blank = 2; break;
			case "Wed": $blank = 3; break;
			case "Thu": $blank = 4; break;
			case "Fri": $blank = 5; break;
			case "Sat": $blank = 6; break;
		}
		//We then determine how many days are in the current month 
		$days_in_month = cal_days_in_month(0, $loopMonth, $year);
		
		$day_count = 1;  
		//take care of blank days
		while ($blank>0){
			$blank = $blank-1;
			$day_count++;
		}

		//set first day of the month to 1
		$day_num = 1;
		//count up the days, untill we've done all of them in the month 
		while($day_num <= $days_in_month){
			if($day_num<10){
				$day_num="0".$day_num;
			}
			$theCheckBox=$_POST[$year."-".$loopMonth."-".$day_num];

			//------- SAVING TO DB
			if($theCheckBox!=""){
//				echo $theCheckBox."<bR>";
				$customChunk=explode("-", $theCheckBox);
				$customYear=$customChunk[0];
				$customMonth=$customChunk[1];
				$customDay=$customChunk[2];

				$customMonthDisplay=SM_displayMonth($customMonth);
				$customDateDisplay=$customMonthDisplay." ".$customDay.", ".$customYear;

				$customdate=$customYear."-".$customMonth."-".$customDay;
				$DBcode=SM_code();
				$saveIt=mysql_query("INSERT INTO skedmaker_custom_sked (datecode, date, year, month, day, weekday, name, code)VALUES('$datecode', '$theCheckBox', '$customYear', '$customMonth', '$customDay', '$weekday', '$customName', '$DBcode')")or die(mysql_error());
				if(!$saveIt){
					SM_redBox("Could not save $customDateDisplay as a custom day, try again later", 800, 16);
				}else{
					echo "<span class='greenText'>Saved $customDateDisplay as custom day '$customName'</span><br>";
					$save_SUCCESS='y';
				}
			}
			$day_num++;
			$day_count++;
		}
		$day=1;
	}
	if($save_SUCCESS=='y'){SM_redirect($smadmin."&v=customapply&dc=".$_GET['dc']."&", 1000); die();}
}

//==================================================================================================
//======= DELETE
//==================================================================================================
$customskedcode=$_GET['csc'];
$bulkReturn=$_GET['blkrtn'];


$month=date('m');
$year=date('Y');
$datecode=$_GET['dc'];

SM_remove_custom_from_day($customskedcode, $bulkReturn, $year, $month, $day, $weekday);

//////////////////////////////////////////////////////////////////////////////////////////////////
//------- MAIN CONTENT STARTS
//////////////////////////////////////////////////////////////////////////////////////////////////
?>
<table class='cc800'>
<tr><td class='pad7'><a href='<?php echo $smadmin;?>&amp;v=customapply&amp;' class='header'><img src='<?php echo $sm_btns_dir;?>btn_stamp32_reg.png' class='btn'/>Apply or Remove Custom Settings</a></td></tr></table>
<?php
//-- make sure the user has custom days set up
$ch=mysql_query("SELECT * FROM skedmaker_custom");
$any=mysql_num_rows($ch);
if($any<=0){
	SM_blueBox("You don't have any custom days set up yet...", 800, 18);
	echo "<table class='cc800'><tr><td class='b2-only' style='padding:21px;'>";
	echo "<a href='".$smadmin."&amp;v=customdays&amp;' class='sked'>";
	echo "<img src='".$sm_btns_dir."btn_custom16_reg.png' style='border:0px; margin-right:14px; vertical-align:middle' />Click here to create a new custom day</a>";
	echo "</td></tr></table>";
	SM_foot();
}

if($_GET['dc']==""){ ?>
	<table class='cc800'><tr><td class='blueBanner1'>Your Current Custom Days</td></tr>
    <tr><td class='blueBanner2' style='padding:0px;'>
	<?php SM_menu();?>
    <table class='cc100'>
	<tr>
	  <td class='pad14' style='padding-bottom:3px;'><b>Below are the custom days you have set up for your schedule.</b></td></tr>
    <tr>
      <td class='pad14' style='padding-bottom:4px;'><b>Start by clicking on the name of a setting you want to use to select it.</b></td></tr>
<tr><td class='pad14' style='padding-bottom:0px;'><b>Then you will be directed to a list of days where you can apply this setting.</b></td></tr>
    <tr><td class='pad7'><div class='navMenuRound' style='width:500px;'><a href='<?php echo $smadmin;?>&amp;v=customdays&amp;op=new&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_custom16_reg.png' class='btn'/>Click Here to Edit Existing or Add New Custom Settings</a></div></td></tr>
    </table>

	<table class='cc100'>
	<tr>
    <td class='pad7' style='padding-left:14px;background-color:#666;'><span style='font-weight:bold; color:#fff;'>Name</span></td>
    <td class='pad7' style='background-color:#666;'><span style='font-weight:bold; color:#fff;'># Timeframes</span></td>
	<td class='pad7' style='background-color:#666;'><span style='font-weight:bold; color:#fff;'>Start Time</span></td>
	<td class='pad7' style='background-color:#666;'><span style='font-weight:bold; color:#fff;'>End Time</span></td>    
    </tr>
	<?php
    $result=mysql_query("SELECT * FROM skedmaker_custom ORDER BY name");
	while($row = mysql_fetch_array($result)) {
		$name=SM_d($row['name']);
		$DBdatecode=SM_d($row['datecode']);

		$countIt=mysql_query("SELECT * FROM skedmaker_custom_timeframes WHERE datecode='$DBdatecode' AND timecode!=''")or die(mysql_query());
		$total=mysql_num_rows($countIt);

	    $result_START=mysql_query("SELECT * FROM skedmaker_custom WHERE datecode='$DBdatecode' && timecode!='' ORDER BY starthour LIMIT 1");
		while($row_START=mysql_fetch_array($result_START)){$TS_START=strtotime("6/6/1975 ".SM_d($row_START['starthour']).":".SM_d($row_START['startminute']));}

	    $result_END=mysql_query("SELECT * FROM skedmaker_custom WHERE datecode='$DBdatecode' && timecode!='' ORDER BY starthour DESC LIMIT 1");
		while($row_END=mysql_fetch_array($result_END)){$TS_END=strtotime("6/6/1975 ".SM_d($row_END['starthour']).":".SM_d($row_END['startminute']));}

		$starttime=date("h:i a", $TS_START);
		$endtime=date("h:i a", $TS_END);

		if($savename!=$name){
			$stagger=SM_stagger($stagger);
			echo "<td class='list_left' style='border-left:0px; width:35%;'><div class='navNotes'><a href='".$smadmin."&amp;v=customapply&amp;dc=".$DBdatecode."&amp;' class='sked'><span style='font-weight:normal; color:#000;'>$name</span></a></div></td>";
			echo "<td class='list_center' style='width:25%;'>".$total." timeframes</td>";
			echo "<td class='list_center' style='width:20%;'>".$starttime."</td>";
			echo "<td class='list_center' style='width:20%;'>".$endtime."</td></tr>";
		}
		$savename=$name;
	} ?>
</table>
</td></tr></table>
<?php 	SM_foot();
}

//==================================================================================================
//======= CURRENTLY SELECTED
//==================================================================================================
$result=mysql_query("SELECT name FROM skedmaker_custom WHERE datecode='$datecode' AND name!='' LIMIT 1");
while($row = mysql_fetch_array($result)){$customName=SM_d($row['name']);}
?>
<table class='cc800'>
<tr><td class='blueBanner1'>Currently selected: '<?php echo $customName;?>'</td></tr>
<tr><td class='blueBanner2' style='padding:0px;'>
<table class='cc100'><tr class='menu'>
<td class='menu' style='width:40%;'><div class='navMenuSM'><a href='<?php echo $smadmin;?>&amp;v=customapply&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_stamp16_reg.png' class='btn' />Select a Different Custom Setting</a></div></td>
<td class='menu' style='width:30%;'><div class='navMenuSM'><a href='<?php echo $smadmin;?>&amp;v=customdays&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_custom16_reg.png'  class='btn' />Open Custom Settings</a></div></td>
<td class='menu' style='width:18%;'><div class='navMenuSM'><a href='<?php echo $smadmin;?>&amp;v=home&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_home16_reg.png' class='btn'/>Admin Home</a></div></td>
<td class='menu' style='width:12%;'>&nbsp;</td>
</tr></table>

<table class-'cc100'><tr><td class='pad14'>
<b>Check the dates below where you want to apply the custom day: '<?php echo $customName; ?>'.</b>
<br><br>
<b>Click 'Save' anywhere on the page and each checked date will have this setting applied to it.</b>
<br><br>
<b>Dates that already have a custom day applied are marked in green.</b>
<br /><br />
<b>Click the trash icon to remove the setting.</b>
<br /><br />
<span class='smallG'>Note: Skedmaker displays your calendar for one year into the future from the present day. However, you are able to check off bulk custom days up to two years ahead of time. These days will not show on your calendar until they are within the display range of one year. This option allows you to mark custom days on your shedule ahead of the date clients will be allowed to book them.</span>
</td></tr></table>
</td></tr></table>
<br />

<?php 
function SM_create_bulk_calendar($month, $year, $second_year, $customName){ 
	global $smadmin; 
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
if($second_year=='y'){$use_for_loop_month=1;}else{$use_for_loop_month=$month;}

for($loopMonth=$use_for_loop_month; $loopMonth<13; $loopMonth++){
	//generate the first day of the month  
	$first_day = mktime(0,0,0,$loopMonth, 1, $year);
	$firstDigit=substr($loopMonth, 0, 1);
	
	if($loopMonth<10 && $firstDigit!=0){$loopMonth="0".$loopMonth;}
	//get the month name
	$title=date('F', $first_day);
	
	$dayLimit=date('d');
	$monthLimit=date('m');
	$yearLimit=date('Y');
	
	//Here we find out what day of the week the first day of the month falls on 
	$day_of_week = date('D', $first_day) ;
	//Once we know what day of the week it falls on, we know how many blank days occure before it. If the first day of the week is a Sunday then it would be zero
	switch($day_of_week){
		case "Sun": $blank = 0; break;
		case "Mon": $blank = 1; break;
		case "Tue": $blank = 2; break;
		case "Wed": $blank = 3; break;
		case "Thu": $blank = 4; break;
		case "Fri": $blank = 5; break;
		case "Sat": $blank = 6; break;
	}
	//We then determine how many days are in the current month 
	$days_in_month = cal_days_in_month(0, $loopMonth, $year);

	//Here we start building the table heads
	// this shows the month and year in a banner
	
	if($second_loop=='y'){
		echo "<tr><td class='tab-bottom-left' colspan='2'>&nbsp;</td><td class='tab-bottom-right'>&nbsp;</td></tr>"; // close off the previous table, cant find a better way than this, oh well!
		echo "<tr><td class='pad7' colspan='2'>&nbsp;</td><td class='pad7'>&nbsp;</td></tr>";
	}

	echo "<table class='cc800'><tr><td class='blueBanner1' colspan='4'>".$title." ".$year."</span></td></tr>";
	// this shows the weekdays 

	$second_loop='y';

	$day_count = 1;  
	//take care of blank days
	while ($blank>0){
		$blank = $blank-1;
		$day_count++;
	}

	//set first day of the month to 1
	$day_num = 1;
	//count up the days, untill we've done all of them in the month 
	while($day_num <= $days_in_month){
		if($day_num<10){$day_num="0".$day_num;}

		//-- check to see if the date is already in the custom DB for this user.
		$loopDate=$year."-".$loopMonth."-".$day_num;
		$alreadyCustom=mysql_query("SELECT * FROM skedmaker_custom_sked WHERE date='$loopDate'");
		$isCustom=mysql_num_rows($alreadyCustom);

		$stagger=SM_stagger($stagger);

		$displayMonth=SM_displayMonth($loopMonth);
		$displayWeekday=SM_displayWeekday($day_count);

		$finalDate=$displayWeekday.", ".$displayMonth." ".$day_num;
		$anchor="a".$year.$loopMonth.$day_num;

		echo "<td class='list_left' style='width:225px; padding-left:14px; border-right:0px;'><a name='".$anchor."'></a>".$finalDate."</td>";

		// -- NOT A CUSTOM
		if($isCustom<=0){ 
			echo "<td style='width:450px;' class='pad7'><div class='navMenuRound' style='display:hide; cursor:pointer'><a href='#'  class='sked' style='vertical-align:center; cursor:pointer'><input name='$year-$loopMonth-$day_num' type='checkbox' style='width:25px; margin-left:7px; cursor:pointer;' id='$year-$loopMonth-$day_num' value='$year-$loopMonth-$day_num'/>";
			echo "<label for='$year-$loopMonth-$day_num'>Check to apply '".$customName."' to this day</label></a></div></td>";
			echo "<td class='list_right' style='width:50px; border-left:0px;'><input type='submit' name='button' id='button' value='Save' /></td></tr>";
		// -- ALREADY SET TO A CUSTOM
		}else{
			$getExist=mysql_query("SELECT * FROM skedmaker_custom_sked WHERE date='$loopDate' AND name!=''");
			while($rowExist = mysql_fetch_array($getExist)){
				$nameExist=SM_d($rowExist['name']);
				$codeExist=SM_d($rowExist['code']);
			}
			echo "<td style='width:550px;' class='pad7'><span class='greenText'>'$nameExist' is currently applied to this day.</span></td>";
			echo "<td style='width:50px;' class='list_right' align='center'><a href='".$smadmin."&amp;op=removecustom&amp;csc=".$codeExist."&amp;blkrtn=".$anchor."&amp;dc=".$_GET['dc']."' class='sked'><img src='".$sm_btns_dir."btn_delete16_reg.png' border='0px'></a></div>";
		}
		echo "</tr>";

//		echo $data;
		$day_num++;  $day_count++;
		//start a new row every week 
		if ($day_count > 7) {$day_count = 1;}
	}

}
}
?>
<form id="" name="form1" method="post" action="<?php echo $smadmin;?>&amp;v=customapply&amp;dc=<?php echo $_GET['dc'];?>&amp;">
<?php 
SM_create_bulk_calendar($month, $year, "no", $customName);
//======= 2nd year
$year++;
SM_create_bulk_calendar($month, $year, "y", $customName); 
?>
</form>