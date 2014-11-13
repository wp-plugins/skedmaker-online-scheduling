<?php 
//=================================================
//-- When is my appointment?
//=================================================
if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['op']=="when"){
	$errorMessage="";
	$errorMessage=SM_uni_check();
	$errorCapture=SM_capture_check();
	$errorMessage=SM_capture_check();
	$today=SM_ts();
	$findemail=SM_e($_POST['findemail']);
	if($findemail==""){	$errorMessage='y'; $errorEmail='y';}
	if($errorMessage==""){
		$total=mysql_num_rows(mysql_query("SELECT * FROM skedmaker_sked WHERE email='$findemail' AND startdate>'$today' LIMIT 1"));
		if($total>0){
			$result=mysql_query("SELECT * FROM skedmaker_sked WHERE email='$findemail' AND startdate>'$today'");
			while($row = mysql_fetch_array($result)) {
				$aptCode=SM_d($row['code']);
				$aptDate=SM_apt(SM_d($row['startdate']));
				$apt_cancel="<a href='".get_site_url()."/?page_id=".$_GET['page_id']."&amp;op=cancel&amp;aptc=".$aptCode."&amp;' class='sked'>".$aptDate."</a>";
				$apt_data.=$apt_cancel."<br>";
			}

			$bodyData="<table class='cc800' style='border-collapse:separate;'>
			<tr><td class='pad7'><span class='header'>".$sitename."</td></tr>
			<tr><td class='blueBanner2'><b>Below is the list you requested of your upcoming appointments.</b>
			<br><br>
			Click on an appointment to be directed to a page where you may cancel it.
			<br><br>".
			$apt_data.
			"<br>
			<span class='redText'>".$cancelpolicy."</td></tr></table>";

			/////// EMAIL IT
			if(SM_emailIt(SM_d($findemail), "$adminemail", "", "Appointment Reminder", $bodyData)==false){}
			$success="y";
		}
	?>
		<table class='cc100' style='border-collapse:separate;'>
        <tr><td class='blueBanner1'>Reminder Sent</td></tr>
        <tr><td class='blueBanner2' style='padding:21px;'>
		<b>If you have upcoming appointments, a list has been sent to: <?php echo SM_d($findemail);?></b>
		<br /><br />
		<div class='navMenuRound' <?php if(!wp_is_mobile()){?>style='width:200px;'<?php }?>><a href='<?php echo SM_permalink();?>&amp;op=sked&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_settings16_reg.png' class='btn' />Back to Schedule</a></div>
		</td></tr></table>
		<?php 
		SM_foot();
	}
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// ======= Search Form
//////////////////////////////////////////////////////////////////////////////////////////////////
if($op=="when" && $success!="y" && $loginValidClient!="y"){ 
	SM_title("My Appointments", "btn_chair32_reg.png", "#");
	$findemail=SM_d($findemail);
	if(wp_is_mobile()){
		$send_btn_text="Send";
	}else{
		$send_btn_text="Send E-mail Reminder";
	}
	?>
	<form name="form1" method="post" action="" style="margin:0px; border:0px;">
	<?php SM_uni_create();?>
	<?php if($errorMessage!=""){SM_redBox("Error! Correct the fields in red below...", "100%", 21);} echo "<br>";?>
	<table class='cc100' style='margin:0px; border-collapse:separate;'>
	<tr><td class='blueBanner1'><?php echo $sitename;?></td></tr>
	<tr><td class='blueBanner2' style="padding:14px">
	<table class='cc100' style='border-collapse:separate;'>
	<tr><td class='pad7' colspan='2'><b>Enter the e-mail address you used to reserve your appointment.</b></td></tr>
	<tr><td class='pad7' colspan='2'>A reminder will be sent to that address with your appointment details.</td></tr>

	<tr><td class='label150' style='width:25%'><?php SM_check_text("E-mail:", $errorEmail);?></td>
	<td class='pad7'  style='width:75%'><input name="findemail" type="text" class='form_textfield' style='width:75%' id="" value="<?php echo $findemail; ?>" maxlength="100"/></td>
	</tr>
	<tr><td class='nopad' colspan='2'><?php SM_capture_create($errorCapture);?></td></tr>
	<tr><td class='label200' style='text-align:center;'><div class='navMenuRound'><a href='<?php echo SM_permalink();?>&amp;op=sked' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_settings16_reg.png' class='btn' />Back</a></div></td>
	<td class='pad7'><input type="submit" name="button" id="contact" value="<?php echo $send_btn_text;?>"/></td>
	</tr></table>
	</td></tr></table>
	</form>
	<?php 
	SM_foot();
}

//////////////////////////////////////////////////////////////////////////////////////////////////
// ======= REGISTERED Client
//////////////////////////////////////////////////////////////////////////////////////////////////
if($op=="when" && $loginValidClient=="y"){ 
	SM_title("My Appointments", "btn_chair32_reg.png", "#");
	$result=mysql_query("SELECT * FROM skedmaker_clients WHERE code='$usercode' LIMIT 1");
	while($row = mysql_fetch_array($result)) {
		$username=SM_d($row['username']);
	}?>
	<table class='cc100' style='margin:0px; border-collapse:separate;'>
	<tr><td class='blueBanner1'><?php echo $username;?></td></tr>
	<tr><td class='blueBanner2' style="padding:14px">
	<table class='cc100' style=' border-collapse:separate;'>
    <?php 
	$today=SM_ts();
	$countIt=mysql_query("SELECT * FROM skedmaker_sked WHERE usercode='$usercode' AND startdate>'$today' LIMIT 1");
	$total_upcoming=mysql_num_rows($countIt);
	if($total_upcoming>0){
		echo "<tr><td class='pad7' colspan='2'><b>Below is a list of your upcoming appointments.</b></td></tr>";
		$result=mysql_query("SELECT * FROM skedmaker_sked WHERE usercode='$usercode' AND startdate>'$today'");
		while($row = mysql_fetch_array($result)) {
			$this_apt=SM_d($row['startdate']);
			$canCode=SM_d($row['code']);
			echo "<tr><td class='nopad'>";
			echo "<div class='navCancel'><a href='".SM_permalink()."&op=cancel&amp;aptc=".$canCode."&amp;' title='Cancel this Appointment'><img src='".$sm_btns_dir."btn_cancel16_reg.png' class='btn'>";
			if(wp_is_mobile()){
				echo SM_aptShort($this_apt);	
			}else{
				echo SM_apt($this_apt);
			}
			echo "</td></tr>";
		}
	}else{
		echo "<tr><td class='pad7'><b>You have no upcoming appointments.</b></td></tr>";
	}
	?>
	<tr><td class='pad7'><div class='navMenuRound' style='width:200px;'><a href='<?php echo SM_permalink();?>&amp;op=sked' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_settings16_reg.png' class='btn' />Back to Schedule</a></div></td>
	</tr></table>
	</td></tr></table>
	<?php 
	SM_foot();
}
?>