<?php 
//////////////////////////////////////////////////////////////////////////////////////////////////
//=======  delete_confirm
//////////////////////////////////////////////////////////////////////////////////////////////////
if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['op']=='delete_confirm'){
	$code=$_GET['c'];
	$saveIt=mysql_query("DELETE FROM skedmaker_blackouts WHERE code='$code'")or die(mysql_error());
	if(!$saveIt){
		SM_redBox("Error", 800, 21);
	}else{
		SM_greenBox("Deleted!", 800, 21);
		SM_redirect($smadmin."&v=blackouts&",500);
		die();
	}
}

if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['op']=="blackout"){
	$errorMessage="";
	$start_date=$_POST['created_date'];
	$end_date=$_POST['follow_up_by'];

	if($start_date==""){$errorMessage='y'; $errorStart='y';}
	if($end_date==""){$errorMessage='y'; $errorEnd='y';}
	if($start_date!=""){$BO_start=$start_date;}
	if($end_date!=""){$BO_end=$end_date;}

	if($end_date!="" && $start_date!="" && $BO_end<$BO_start){$errorMessage='y'; $errorStart='y'; $errorEnd='y'; $errorValid='y';}

	if($errorMessage==""){

		$start_date=SM_e($start_date);
		$end_date=SM_e($end_date);

		if($_GET['c']==""){
			$code=SM_code();
			$saveIt=mysql_query("INSERT INTO skedmaker_blackouts (code, start_date, end_date)VALUES('$code', '$BO_start', '$BO_end')") or die(mysql_error());
		}else{
			$code=SM_e($_GET['c']);
			$saveIt=mysql_query("UPDATE skedmaker_blackouts SET start_date='$BO_start', end_date='$BO_end' WHERE code='$code' LIMIT 1") or die(mysql_error());
		}

		if(!$saveIt){
			SM_redBox("Error. Try again later.", 800, 21);	
		}else{
			SM_greenBox("Saved	Successfully", 800, 21);
			SM_redirect($smadmin."&v=blackouts&ts=".$_GET['ts'], 500);
			die();
		}
	}
}

SM_title("Blackout Dates", "btn_blackout32_reg.png", "");

if ($_GET['op']=='delete'){
	$code=$_GET['c'];
	$result=mysql_query("SELECT * FROM skedmaker_blackouts WHERE code='$code'");
	while($row = mysql_fetch_array($result)) {
		$start=SM_dateText(SM_d($row['start_date']));
		$end=SM_dateText(SM_d($row['end_date']));
	}
	$range="Starts: ".$start." <br><br>Ends: ".$end;
	?>
	<form id="form2" name="form2" method="post" action="<?php echo $smadmin;?>&amp;v=blackouts&amp;c=<?php echo $_GET['c'];?>&amp;op=delete_confirm&amp;">
	<?php SM_redBox("<center>Are you SURE you want to delete this blackout range? <br><bR><span style='font-size:21px; color:#000;'>".$range."</span><br><br>This action can NOT be undone.</center>", 800, 18);?>
	<bR /><br />
	<table class='cc800'><tr>
	<td class='b2-only'>
    <table class='cc100' style='width:450px;'>
	<tr>    
	<td style='width:250px; text-align:center;'><div class='navMenuRound'><a href='<?php echo $smadmin; ?>&amp;v=blackouts&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_blackout16_reg.png' class='btn' />No, Don't Delete</a></div></td>
	<td style='width:200px; text-align:right;'><input type="submit" name="trash" id="trash" value="Yes, Delete Blackout Range"/></td>
	</tr></table>
	</td></tr></table>
    </form>
	<?php 
	SM_foot();
}
?>
<form enctype="multipart/form-data" id="form1" name="form1" method="post" action="<?php echo $smadmin;?>&amp;v=blackouts&amp;op=blackout&amp;ts=<?php echo $_GET['ts'];?>&amp;" style="margin-top:0px">
<table class='cc800'>
<tr><td class='blueBanner1'>Set Date Range to Disable Schedule</td></tr>
<tr><td class='blueBanner2' style='padding:0px;'>
<?php SM_menu();?>

<table class='cc100'>
<?php 
if($errorValid=='y'){ echo "<tr><td class='pad14' colspan='2'>"; SM_redBox("There was an Error. Enter a valid date range.", 760, 21); echo "</td></tr>";}
else if($errorMessage!=""){echo "<tr><td class='pad14' colspan='2'>"; SM_redBox("Error. Correct the fields in red below...", 760, 21); echo "</td></tr>";}
?>
<tr><td class='pad14' >Select a date range below to disable your schedule. This function is useful if you need to block out a large range of dates on your schecule. Clients will not be able to book appointments during this range. If you wish to enable these dates again, delete from the list at the bottom of this page.
</td></tr>
<tr><td class='pad7' style='text-align:left; padding-left:21px;'>
<?php 
if($_GET['start']=="" && $_GET['end']==""){
	echo "<b>Pick a start date...</b><br><br>";
	SM_create_blackout_cal("start");
}else if($_GET['start']!="" && $_GET['end']==""){
	echo "<b>Start Date: </b>".SM_dateText($_GET['start'])."<bR><bR>";
	echo "<b>Pick an end date...</b><br><br>";
	SM_create_blackout_cal("end");
}else if($_GET['start']!="" && $_GET['end']!=""){
	echo "<b>Start Date: </b>".SM_dateText($_GET['start'])."<br><br>";
	echo "<b>End Date: </b>".SM_dateText($_GET['end']); 
}
?>
</td></tr>
<?php if($_GET['start']!="" && $_GET['end']!=""){?>
<tr><td class='pad7'><input type="submit" name="button" id="button" value="Save Blackout Dates"> <?php if($_GET['start']!=""){ ?><a href='<?php echo $smadmin;?>&amp;v=blackouts&amp;' class='sked'>Pick Different Dates</a><?php } ?></td></tr>
<?php } ?>
</table>
<br>
</td></tr></table>

<input type="hidden" name="created_date" value="<?php echo $_GET['start'];?>"/>
<input type="hidden" name="follow_up_by" value="<?php echo $_GET['end'];?>"/>

</form>
<?php 
$countIt=mysql_query("SELECT * FROM skedmaker_blackouts");
$total=mysql_num_rows($countIt);

if($total>0){
	?>
    <bR>
    <table class='cc800'>
    <tr><td class='tab-left' style='padding:14px;'>STARTS</td><td class='tab'>ENDS</td><td class='tab-right'>&nbsp;</td></tr>
<?php     
	$result=mysql_query("SELECT * FROM skedmaker_blackouts ORDER by start_date");
	while($row=mysql_fetch_array($result)){
		$start=SM_dateText(SM_d($row['start_date']));
		$end=SM_dateText(SM_d($row['end_date']));
		$BOcode=SM_d($row['code']);
		$stagger=SM_stagger($stagger);
		echo "<td class='list_left' style='padding-left:14px;'>".$start."</td>";
		echo" <td class='list_center'>".$end."</td>";
		echo "<td class='list_right'><a href='".$smadmin."&amp;v=blackouts&amp;op=delete&amp;c=".$BOcode."' title='Delete Blackout' class='sked'><img src='".$sm_btns_dir."btn_delete16_reg.png' style='border:0px'></td>";
		echo "</tr>";
	}?>
    <tr><td class='tab-bottom-left' colspan='2'>&nbsp;</td><td class='tab-bottom-right'>&nbsp;</td></tr>
</table>
<?php 	
}else{
	echo "<br>";
	SM_blueBox("<br>You don't have any blackout ranges set.<br><br>", 800, 21);
}
?>