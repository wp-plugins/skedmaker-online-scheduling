<?php
$datecode=$_GET['dc'];
$timecode=$_GET['tc'];
$year=$_GET['year'];
$month=$_GET['month'];
$day=$_GET['day'];
$weekday=$_GET['weekday'];


//======= DELETE CONFIRM
if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['op']=="deleteconfirm"){
	if($_GET['dc']!=""){
		$deleteIt=mysql_query("DELETE FROM skedmaker_custom WHERE datecode='$datecode'");	
		$clearSked=mysql_query("DELETE FROM skedmaker_custom_sked WHERE datecode='$datecode'");
		$clearTimeframes=mysql_query("DELETE FROM skedmaker_custom_timeframes WHERE datecode='$datecode'");
	
		if(!$deleteIt || !$clearSked || !$clearTimeframes){
			SM_redBox("Error deleteing, try again later", 800, 21);
		}else{
			SM_greenBox("Deleted Custom Setting!", 800, 21);
			SM_redirect($smadmin."&v=customdays&", 500);
			die();
		}
	}
}
//======= DELETE CHECK
if($_GET['op']=="delete"){
	$result=mysql_query("SELECT name FROM skedmaker_custom WHERE datecode='$datecode' AND starthour='' LIMIT 1");
	while($row=mysql_fetch_array($result)){$DBname=SM_d($row['name']);}
	SM_title("Delete Custom Setting", "btn_delete32_reg.png", "");
			?>
			<form name='formdc' method='post' action='<?php echo $smadmin;?>&amp;v=customdays&amp;op=deleteconfirm&amp;dc=<?php echo $_GET['dc'];?>&amp;' style='margin:0px; border:0px'>
			<table class='cc800'>
            <tr><td class='blueBanner1'><?php echo $DBname; ?></td></tr>
            <tr><td class='blueBanner2' style='padding:0px'>
			<?php SM_menu(); ?>
			<table class='cc100'><tr><td class='pad14' style='text-align:center;'>
			<?php SM_redBox("Are you SURE you want to delete this custom setting?", 750, 21); ?>
			</td></tr></table>
			<table class='cc100'>
			<tr><td class='pad14' colspan='2'><b>All days set to "<?php echo $DBname;?>" will revert back to default weekday settings.</b></td></tr>
			<tr><td class='label100'><a href='<?php echo $smadmin;?>&amp;v=customdays&amp;' class='smallG'>Back to List</a></td><td class='pad14' style='width:600px;'><input type='submit' name='button' id='trash' value='Yes, Delete <?php echo $DBname;?>'/></td></tr>
			</table></td></tr></table>
			</form>
<br />
	<?php SM_upcoming_warning($_GET['dc']); ?>
	<table class='cc800'>
    <tr><td class='blueBanner1'>Current Time Frames for '<?php echo $DBname; ?>'</td></tr>
    <tr><td class='blueBanner2' style='padding:0px;'>
	<table class='cc100'><tr style='background-color:#666;'>
	<td class='pad7' style='width:150px; padding-left:14px;'><span style='font-weight:bold; color:#fff;'>Start Time</span></td>
	<td class='pad7' style='width:150px;'><span style='font-weight:bold; color:#fff;'>End Time</span></td>
	<td class='pad7' style='width:150px;'><span style='font-weight:bold; color:#fff;'># Appointments</span></td>
	</tr>
	<?php
	$result=mysql_query("SELECT * FROM skedmaker_custom_timeframes WHERE datecode='$datecode' AND starthour!='' ORDER BY starthour, startminute");
	while($row = mysql_fetch_array($result)){
		$LIST_starthour=SM_d($row['starthour']);
		$LIST_startminute=SM_d($row['startminute']);
		$LIST_endhour=SM_d($row['endhour']);
		$LIST_endminute=SM_d($row['endminute']);
		$LIST_setmultiple=SM_d($row['multiple']);
		$LIST_timecode=SM_d($row['timecode']);
		$LIST_starttime=showTime($LIST_starthour, $LIST_startminute);
		$LIST_endtime=showTime($LIST_endhour, $LIST_endminute);
		$stagger=SM_stagger($stagger);
		?>
		<td class='pad7' style='width:150px; padding-left:14px;'><?php echo $LIST_starttime; ?></td>
		<td class='pad7' style='width:150px;'><?php echo $LIST_endtime;?></td>
		<td class='pad7' style='width:150px;'><?php echo $LIST_setmultiple;?></td>
		</tr>
<?php 	} ?>
	</table>
    </td></tr></table>
<?php 
SM_foot();
} ?>

<?php 
//================================================================================================== 
//======= CREATE NEW CUSTOM DAY
//==================================================================================================
if ($_SERVER['REQUEST_METHOD']=='POST' && ($_GET['op']=="new" || $_GET['op']=="edit")){
	$errorMessage="";	
	$name=SM_e($_POST['name']);
	if(ereg('[^A-Za-z0-9[:space:].-]', $name)){$errorMessage='y'; $errorAlphaNum='y';}
	if($name==""){$errorMessage='y'; $errorName='y';}
	$datecode=SM_code();

	if($_GET['c']==""){
		$saveIt=mysql_query("INSERT INTO skedmaker_custom (name, datecode)VALUES('$name', '$datecode')")or die(mysql_error());
		$redirect=$smadmin."&v=customtimes&dc=".$datecode."&";
		$save_message="Created Custom Day!";
	}else{
		$code=$_GET['c'];
		$saveIt=mysql_query("UPDATE skedmaker_custom SET name='$name' WHERE datecode='$code'")or die(mysql_error());
		$save_message="Saved Edits!";
		$redirect=$smadmin."&v=customdays&";
	}
	if(!$saveIt){
		SM_redBox("Could not create, try again later.", 800, 21);
	}else{
		SM_greenBox($save_message, 800, 21);
		SM_redirect($redirect, 1000);
		die();
	}
}
SM_title("Custom Day Settings", "btn_custom32_reg.png", "?v=customdays"); 
//==================================================================================================
//======= LIST
//==================================================================================================
$total=mysql_num_rows(mysql_query("SELECT * FROM skedmaker_custom ORDER BY name"));
if($total>0){ ?>
<table class='cc800'><tr><td class='blueBanner1'>Your Current Custom Days</td></tr>
	<tr><td class='blueBanner2' style='padding:0px;' valign='top'>
	<?php SM_menu();?>
	<table class='cc100'>
	<tr><td class='pad14' style='padding-bottom:4px;'><b>Below is a list of the Custom Days Settings you have created.</b></td></tr>
    <tr><td class='pad14' style='padding-bottom:4px;'><b>Click a setting name or the clock icon to add, remove or edit time frames.</b></td></tr>
    <tr><td class='pad7'><div class='navMenuRound' style='width:325px'><a href='<?php echo $smadmin;?>&amp;v=customapply&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_stamp16_reg.png' class='btn'/>Apply or Remove Custom Settings</a></div></td></tr>
    </table>

	<table class='cc100'>
	<tr style='background-color:#666;'>
    <td class='pad7' style='padding-left:14px'><span style='font-weight:bold; color:#fff;'>Name</span></td>
    <td class='pad7'><span style='font-weight:bold; color:#fff;'># Time frames</span></td>
	<td class='pad7'><span style='font-weight:bold; color:#fff;'>First Apt.</span></td>
	<td class='pad7'><span style='font-weight:bold; color:#fff;'>Last Apt.</span></td>    
    <td class='pad7' colspan='3'><span class='whiteBold'>Actions</span></td>    
    </tr>
	<?php
    $result=mysql_query("SELECT * FROM skedmaker_custom ORDER BY name");
	while($row = mysql_fetch_array($result)){
		$name=SM_d($row['name']);
		$DBdatecode=SM_d($row['datecode']);

		$countIt=mysql_query("SELECT * FROM skedmaker_custom_timeframes WHERE datecode='$DBdatecode'")or die(mysql_query());
		$total_timeframes=mysql_num_rows($countIt);

	    $result_START=mysql_query("SELECT * FROM skedmaker_custom_timeframes WHERE datecode='$DBdatecode' ORDER BY starthour LIMIT 1");
		while($row_START=mysql_fetch_array($result_START)){$TS_START=strtotime("6/6/1975 ".SM_d($row_START['starthour']).":".SM_d($row_START['startminute']));}
		
	    $result_END=mysql_query("SELECT * FROM skedmaker_custom_timeframes WHERE datecode='$DBdatecode' ORDER BY starthour DESC LIMIT 1");
		while($row_END=mysql_fetch_array($result_END)){$TS_END=strtotime("6/6/1975 ".SM_d($row_END['starthour']).":".SM_d($row_END['startminute']));}

		$starttime=date("g:i a", $TS_START);
		$endtime=date("g:i a", $TS_END);

		$stagger=SM_stagger($stagger);
		echo "<td class='list_left' style='border-left:0px; width:25%;'><div class='navMenuSM'><a href='".$smadmin."&amp;v=customtimes&amp;dc=".$DBdatecode."&amp;' class='b2w'><span style='font-weight:normal;'>$name</span></a></div></td>";
		echo "<td class='list_center' style='width:25%;'>".$total_timeframes." time frames</td>";
		echo "<td class='list_center' style='width:20%;'>".$starttime."</td>";
		echo "<td class='list_center' style='width:20%;'>".$endtime."</td>";
		echo "<td class='nopad' style='padding-left:3px; width:3%;'><a href='".$smadmin."&amp;v=customtimes&amp;dc=".$DBdatecode."&amp;' title='Add Time Frames' class='sked'><img src='".$sm_btns_dir."btn_timeframes16_reg.png' border='0px'></a></td>";
		echo "<td class='nopad' style='width:3%;'><a href='".$smadmin."&amp;v=customdays&amp;op=edit&amp;c=".$DBdatecode."&amp;' title='Edit Name' class='sked'><img src='".$sm_btns_dir."btn_edit16_reg.png' style='border:0px;' alt='Edit'></a></td>";
		echo "<td class='nopad' style='width:4%;'><a href='".$smadmin."&amp;v=customdays&amp;op=delete&amp;dc=".$DBdatecode."&amp;' title='Delete' class='sked'><img src='".$sm_btns_dir."btn_delete16_reg.png' style='border:0px;' alt='Delete'></a></td></tr>";
	} ?>
</table>
</td></tr></table>
<br />
<?php 
} 

if($_GET['c']!=""){
	$code=$_GET['c'];
	$result=mysql_query("SELECT * FROM skedmaker_custom WHERE datecode='$code' AND name!='' ORDER BY name");
	while($row = mysql_fetch_array($result)) {
		$new_name=SM_d($row['name']);
		$DBdatecode=SM_d($row['datecode']);
	}
	$action_URL=$smadmin."&amp;v=customdays&amp;op=edit&amp;c=".$DBdatecode."&amp;";
}else{
	$action_URL=$smadmin."&amp;v=customdays&amp;op=new&amp;";
}
?>
<!--================================================================================================== 
======= CREATE NEW 
==================================================================================================-->    
<form name="form2" method="post" action="<?php echo $action_URL;?>" style='margin:0px; border:0px;'>
<table class='cc800'><tr><td class='blueBanner1'><?php if($_GET['c']!=""){ ?>Editing: <?php echo $new_name; }else{ ?>Create A New Custom Day Setting<?php } ?></td></tr>
<tr><td class='blueBanner2'>
<table class='cc100'>
<tr><td colspan="2" class='pad7'>
<?php if($name==""){SM_redBox("You don't have any custom days set up.<br><br>Start by naming a custom day template below.", 750, 16);}?>
<?php if ($name!=""){ ?><b>Create a new custom day or select from the list at top to edit/add new time frames.</b><?php } ?>
</td></tr>

<tr><td class='label250'><?php SM_check_text("Name this Custom Day:", $errorName);?></td>
<td class='pad7' style='width:550px; vertical-align:top;'><input name="name" type="text" class='form_textfield' id="name" size="49" style='width:490px;' value='<?php echo $new_name;?>'></td>
</tr>

<tr><td class='label250' style='text-align:center;'>
<?php if($name==""){ ?>
<div class='navMenuRound'><a href='<?php echo $smadmin;?>&amp;v=home&amp;a' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_home16_reg.png' class='btn'/>Admin Home</a></div>
<?php }else{ echo "&nbsp;";}?>
</td>
<td class='pad7'><input type="submit" name="button2" id="button" value="Save New Custom Day"></td></tr>
</table>
</td></tr></table>
</form>
<br>