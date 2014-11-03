<?php
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//------- NOTE!!! Removed this for from client side, this ONLY is called from the admin page
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$ts=$_GET['ts'];
$datecode=$_GET['dc'];
$showApt=SM_apt($ts);
$multipleWeekday=strtolower(date('l', $ts));

$view=$_GET['v'];

//==================================================================================================
//======= DOUBLE CHECK TO BE SURE APPOINT HASNT BEEN TAKEN WHILE CLIENT IS LOOKING AT PAGE
//==================================================================================================

//======= get max available
$weekday=strtolower(date("l", $ts));
$multiplerow=$weekday."multiple";
$result=mysql_query("SELECT $multiplerow FROM skedmaker_users");
while($row = mysql_fetch_array($result)){$max_apts=SM_d($row[$multiplerow]);}

//======= get number taken
$countIt=mysql_query("SELECT * FROM skedmaker_sked WHERE startdate='$dayTS'") or die(mysql_error());
$total_taken=mysql_num_rows($countIt);

/*
//======= remaining
$remaining=$max_apts-$total_taken;
	
if($remaining<1){
	echo $total_taken."<br>".$remaining;
	echo "<br><bR>";
	SM_redBox("Sorry, this appointment has been taken.", 800, 21);
	echo "<br><bR>";
	echo "<a href='".$smpageid."&amp;op=sked&amp;ts=".$_GET['ts']."'><img src='<?php echo $sm_btns_dir;?>btn_calpick16_reg.png' style='border:0px; margin-right:7px'>Back to Schedule</a>";
	SM_foot();
}
*/

if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['op']=="confirm"){
	$errorMessage="";
	$errorMessage=SM_uni_check();
	$client_name=$_POST["client_name"];
	$client_email=$_POST["client_email"];
	$confirm_email=$_POST["confirm_email"];
	$client_phone=$_POST["client_phone"];
	$num_in_party=$_POST["num_in_party"];
	$client_content=$_POST["client_content"];

	if($requirename=="y" && $client_name==""){$errorMessage="y"; $errorName="y";}
	if($requireemail=="y" && $client_email==""){$errorMessage="y"; $errorEmail="y";}
	if($requireemail=="y" && $requireconfirm=="y" && $client_email!=$confirm_email){$errorMessage="y"; $errorEmail="y"; $errorConfrimEmail="y";}
	if($requireemail=="y" && $requireconfirm=="y" && $confirm_email==""){$errorMessage="y"; $errorEmail="y"; $errorConfrimEmail="y";}
	if($requireemail=="y" && !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $client_email)){$errorMessage="emailvalid";  $errorEmail='y'; $errorValid="y";}
	if($requirephone=="y" && $client_phone==""){$errorMessage="y"; $errorPhone="y";}
	if($requiremessage=='y' && $client_content==""){$errorMessage="y"; $errorContent="y";}

	if($errorMessage==""){
		$client_name=SM_e($client_name);
		$client_email=SM_e($client_email);
		$confirm_email=SM_e($confirm_email);
		$client_phone=SM_e($client_phone);
		$num_in_party=SM_e($num_in_party);
		$client_content=SM_e($client_content);

		if($numberinparty=="" || $numberinparty<1){$numberinparty=1;}
		
		$DBcode=SM_code();
		$canCode=$DBcode;
		$saveIt=mysql_query("INSERT INTO skedmaker_sked (ip, name, email, phone, numberinparty, usercode, startdate, code, datecode, content)VALUES('$ip', '$client_name', '$client_email', '$client_phone', '$num_in_party', '$usercode', '$ts', '$DBcode', '$datecode', '$client_content');") or die(mysql_error());
	
		if(!$saveIt){
			SM_redBox("Sorry, could not reserve the appointment... Please try again later.", 800, 16);
			SM_foot();
		}else{
			//======= SUCCESSFULLY BOOKED!
			echo "<br>";
			SM_greenBox("Your Appointment is Reserved!", 800, 21);
			?>
			<table class='cc800'>
            <tr><td class='pad7'><span class='header'><img src='<?php echo $sm_btns_dir;?>btn_chair32_reg.png' style='border:0px; margin-right:14px; vertical-align:middle;' />My Appointment</span></td></tr>
			<tr><td class='blueBanner1'><?php echo SM_d($client_name); ?>, You are currently scheduled for:</td></tr>
            <tr><td class='blueBanner2' style='padding:0px;'>
			<?php if($loginValid=="admin"){SM_menu();} ?>
            <table class='cc100'>
            <tr><td class='pad14' style='padding-bottom:0px;'><span style='font-size:21px; font-weight:bold;'><?php echo $showApt; ?></span></td></tr>
			<?php if($client_email!=""){?>
                <tr><td class='pad14'>
                <span style='font-weight:bold; font-size:18px;'>A confirmation e-mail was sent to: <?php echo SM_d($client_email);?></span><br /><br />
                <b>This e-mail will also provide a cancellation link, should you need to reschedule.</b>
                </td></tr>
            <?php } ?>
			<?php if($loginValid!="admin"){ ?>
            <tr><td class='pad7'>
			<div class='navMenu' style='width:200px'><a href='<?php echo $smadmin;?>&amp;op=sked&amp;ts=<?php echo $_GET['ts'];?>&amp;'><img src='<?php echo $sm_btns_dir;?>btn_settings16_reg.png' class='btn' />Back to Schedule</a></div>
            </td></tr>
            <?php } ?>
            <tr><td class='nopad'></td></tr>
<!--             <tr><td class='nopad' style='border-bottom:1px dotted #666;'><?php echo "confirmation_notice_here"; ?></td></tr> -->
            <?php 
			//== no cancel if theres no email
			if($client_email!=""){?>
	            <tr><td class='pad14'>You may cancel and reschedule your appointment by clicking the link below.</td></tr>
	            <tr><td class='pad14'>
	            <a href='<?php echo $smadmin;?>&amp;op=cancel&amp;aptc=<?php echo $canCode; ?>&amp;' class='cancel'><img src='<?php echo $sm_btns_dir;?>btn_cancel16_reg.png' class='btn'/>Cancel This Appointment</a>
	            </td></tr>
				<?php if($cancelpolicy!=""){echo "<tr><td class='pad14'><span class='redText'>".$cancelpolicy."</span></td></tr>";} ?>
           <?php } ?>
        	</table>
            </td></tr></table>

<?php

			$result=mysql_query("SELECT ID FROM wp_posts WHERE post_content LIKE '%[skedmaker]%' AND post_status='publish' LIMIT 1");
			while($row = mysql_fetch_array($result)) {
				$sked_page_id=SM_d($row['ID']);				
			}

			if($client_name==""){$client_name="n/a";}
			if($client_phone==""){$client_phone="n/a";}
			if($num_in_party==""){$num_in_party="1";}
			if($client_content==""){$client_content="n/a";}
			$bodyData="<table class='cc800'>
			<tr><td class='pad7'><span class='header'>".$sitename."</span></td></tr>
			<tr><td class='blueBanner1'>An appointment was made with the following details</td></tr>
			<tr><td class='blueBanner2' style='padding-left:0px; padding-right:0px;'>
			<table class='cc100'>
			<tr><td class='label150'>Name:</td><td class='pad7' style='width:650px;'>".SM_d($client_name)."</td></tr>
			<tr><td class='label150'>Appointment:</td><td class='pad7' style='width:650px;'>".$showApt."</td></tr>
			<tr><td class='label150'>E-mail:</td><td class='pad7' style='width:650px;'><span style='font-weight:normal'>".SM_d($client_email)."</span></td></tr>
			<tr><td class='label150'>Phone:</td><td class='pad7' style='width:650px;'><span style='font-weight:normal'>".SM_d($client_phone)."</span></td></tr>
			<tr><td class='label150'># in Party:</td><td class='pad7' style='width:650px;'><span style='font-weight:normal'>".SM_d($num_in_party)."</span></td></tr>
			<tr><td class='label150'>Message:</td><td class='pad7' style='width:650px;'><span style='font-weight:normal'>".SM_d($client_content)."</span></td></tr>
			<tr><td class='pad7' colspan='2'><a href='".get_site_url()."/?page_id=".$sked_page_id."&amp;op=cancel&amp;aptc=".$DBcode."&amp;'>Click here if you need to cancel this appointment</a></td></tr>
			<tr><td class='pad7' colspan='2'><span class='redText'>".$cancelpolicy."</span></td></tr>
			</table>";
			$biz_info=SM_biz_info();
			$bodyData.=$biz_info."</td></tr></table>";

			if(SM_emailIt(SM_d($client_email), "$adminemail", "", "Appointment Scheduled: ".SM_d($client_name), $bodyData)==false){}
			SM_foot();
		}
	}
}

$skedname=SM_d($skedname);
$skedemail=SM_d($skedemail);
$skedconfirmemail=SM_d($skedconfirmemail);
$skedphone=SM_d($skedphone);
$skedmsg=SM_d($skedmsg);

//==================================================================================================
//======= CLIENT SCHEDULING
//==================================================================================================
if($_GET['v']!=""){
	$back=$smadmin."&amp;v=home&amp;ts=".$_GET['ts'];
	$viewURL="&amp;v=".$_GET['v'];
}else{
	$viewURL="";
	$back=$smpageid."&amp;op=sked&amp;ts=".$_GET['ts'];
}
?>
<form id="form1" name="form1" method="post" style='margin:0px;' action="<?php if($loginValid=="admin"){echo $smadmin;}else{die("error not admin");}?>&amp;op=confirm&amp;ts=<?php echo $_GET['ts']; echo $viewURL; ?>&amp;">
<?php SM_uni_create();?>
<?php SM_title("Confirm Appointment", "btn_settings32_reg.png", "");?>
<table class='cc800'>
<tr><td class='nopad'><?php SM_greenBox($showApt, 800, 21); ?></td></tr>
<?php if($errorMessage!=""){?><tr><td class='nopad'><?php SM_redBox("There was an error. Please correct the fields in red below...", 800, 21); ?></td></tr><?php } ?>
<tr><td class="blueBanner1">Would you like to reserve this appointment?</td></tr>
<tr><td class="blueBanner2" style='padding:21px; text-align:center;'>
<table class='cc100'>
<tr><td class='label150'>&nbsp;</td><td class='pad7' style='width:600px;'><b>Complete the form below to reserve this appointment.</b></td></tr>

<tr><td class='label150'><?php SM_check_text("Name: ", $errorName);?></td>
<td class='pad7' style='width:600px;'><input name="client_name" type="text" class='form_textfield' value="<?php echo SM_d($client_name);?>" maxlength="100" style='width:500px;'/></td></tr>

<?php if($requireemail=="y"){?>
<tr><td class='label150'><?php SM_check_text("E-mail: ", $errorEmail);?></td>
<td class='pad7' style='width:600px;'><input name="client_email" type="text" class='form_textfield' value="<?php echo SM_d($client_email);?>" maxlength="100" style='width:500px;'/></td></tr>
<?php } ?>

<?php if($errorValid=="y"){echo "<tr><td class='label150'>&nbsp;</td><td class='pad7' style='padding-top:0px;'><span class='smallRed'>Enter a valid email address.</td></tr>";}?>

<?php if($requireconfirm=="y"){?>
<tr><td class='label150'><?php SM_check_text("Confirm E-mail: ", $errorConfirmEmail);?></td>
<td class='pad7' style='width:600px;'><input name="confirm_email" type="text" class='form_textfield' value="<?php echo SM_d($confirm_email);?>" maxlength="100" style='width:500px;'/></td></tr>
<?php } ?>
<?php if($requirephone=='y'){ ?>
<tr><td class='label150'><?php SM_check_text("Phone: ", $errorPhone);?></td>
<td class='pad7' style='width:600px;'><input name="client_phone" type="text" class='form_textfield' value="<?php echo SM_d($client_phone);?>" maxlength="100" style='width:500px;'/></td></tr>
<?php } ?>

<?php if($requirenumberinparty=='y'){ ?>
<tr><td class='label150'><?php SM_check_text("# in Party", $errorNumInParty);?>
</td>
<td class='pad7' style='width:600px;'>
<select name='num_in_party' class='form_select'>
<?php for($x=1; $x<=$partymax; $x++){ ?>
<option value="<?php echo $x;?>" <?php if($x==$num_in_party){ ?> selected="selected" <?php } ?> ><?php echo $x;?></option>
<?php } ?>
</select>
</td></tr>
<?php } ?>

<?php if($requiremessage=='y'){ ?>
<tr><td class='label150'><?php SM_check_text("Message:", $errorContent);?></td><td class='pad7' style='width:600px;'>
<textarea name="client_content" id="textarea" cols="45" rows="5" class='form_area' style='width:500px;'><?php echo SM_d($client_content);?></textarea></td></tr>
<?php } ?>

<tr><td class='label150'>&nbsp;</td><td class='pad7' style='width:600px;'><input type="submit" name="button" onclick='savingShow()' id="mainSave" value="Reserve This Appointment"/>
<div id='savingShow' style='display:none; padding:0px;'>Saving...</div>
</td></tr>
<tr><td class='label150'>&nbsp;</td><td class='pad7' style='width:600px;'><div class='navMenuRound' style='width:350px;'><a href="<?php echo $back; ?>" class='sked'><img src='<?php echo $sm_btns_dir;?>btn_settings16_reg.png' class='btn' />I want to pick a different appointment</a></div></td></tr>
<tr><td class='label150'>&nbsp;</td><td class='pad7' style='width:600px;'><?php if($cancelpolicy!=""){echo "<p><span class='redText'>".$cancelpolicy."</span></p>";}?></td></tr>
</table>
</td></tr></table>
</form>