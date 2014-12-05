<?php 
if(wp_is_mobile()){
	$button_text="Reserve Now";
	$go_back_text="Go Back";
	$b1_text="Reserve this appointment?";
	$main_title_text="Confirm";
}else{
	$button_text="Reserve This Appointment";
	$go_back_text="Pick a different appointment";
	$b1_text="Would you like to reserve this appointment?";
	$main_title_text="Confirm Appointment";
}

	$ts=$_GET['ts'];
	$datecode=$_GET['dc'];
	$timecode=$_GET['tc'];
	$view=$_GET['v'];
	$showApt=SM_apt($ts);
	$multipleWeekday=strtolower(date('l', $ts));

	if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['op']=="confirm"){
		$errorMessage="";
		$errorMessage=SM_uni_check();

		//-- get registerd client info
		if($loginValidClient=="y"){
			$result=mysql_query("SELECT * FROM skedmaker_clients WHERE code='$usercode' LIMIT 1");
			while($row = mysql_fetch_array($result)){
				$client_email=SM_d($row['email']);
				$client_name=SM_d($row['username']);
				$client_phone=SM_d($row['phone']);
			}
		}else{
			$client_name=$_POST["client_name"];
			$client_email=$_POST["client_email"];
			$confirm_email=$_POST["confirm_email"];
			$client_phone=$_POST["client_phone"];
		}

		$confirm_email=$_POST["confirm_email"];
		$num_in_party=$_POST["num_in_party"];
		$client_content=$_POST["client_content"];

		if($requirename=="y" && $client_name==""){$errorMessage="name"; $errorName="y";}
		if($loginValidClient!="y" && $requireemail=="y" && $client_email==""){$errorMessage="email"; $errorEmail="y";}
		if($loginValidClient!="y" && $requireemail=="y" && $requireconfirm=="y" && $client_email!=$confirm_email){$errorMessage="confemail"; $errorEmail="y"; $errorConfirmEmail="y";}
		if($loginValidClient!="y" && $requireemail=="y" && $requireconfirm=="y" && $confirm_email==""){$errorMessage="y"; $errorEmail="y"; $errorConfirmEmail="y";}
		if($loginValidClient!="y" && $requireemail=="y" && !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $client_email)){$errorMessage="emailvalid";  $errorEmail='y'; $errorValid="y";}
		if($loginValidClient!="y" && $requirephone=="y" && $client_phone==""){$errorMessage="y"; $errorPhone="y";}
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
				SM_redBox("Sorry, could not reserve the appointment... Please try again later.", "100%", 16);
				SM_foot();
			}else{
				//======= SUCCESSFULLY BOOKED!
				SM_greenBox("Your Appointment is Reserved!", "100%", 21); ?>
				<table class='cc100' style='border-collapse:separate; margin-top:14px;'>
				<tr><td class='blueBanner1'><?php if($username!=""){echo SM_d($username);}else{echo SM_d($client_name);}?>, your appointment details are below</td></tr>
				<tr><td class='blueBanner2' style='padding:7px;'>
				<?php if($loginValid=="admin"){SM_menu();} ?>
				<table class='cc100' style='border-collapse:separate;'>
				<tr><td class='pad14b2' style='padding-bottom:0px;'><img src='<?php echo $sm_btns_dir;?>btn_chair32_reg.png' style='border:0px; margin-right:14px; vertical-align:middle;' /><span style='font-size:21px; font-weight:bold;'><?php echo $showApt; ?></span></td></tr>
				<?php 
				if($loginValidClient=="y"){
					$result=mysql_query("SELECT * FROM skedmaker_clients WHERE code='$usercode' LIMIT 1");
					while($row = mysql_fetch_array($result)){$client_email=SM_d($row['email']);}
				}
				if($client_email!=""){?>
					<tr><td class='pad14b2'>
					<span style='font-weight:bold; font-size:18px;'>A confirmation e-mail was sent to: <br /><?php echo SM_d($client_email);?></span><br /><br />
					<b>This e-mail will also provide a cancellation link, should you need to reschedule.</b>
					</td></tr>
				<?php } ?>
				<?php if($loginValid!="admin"){ ?>
				<tr><td class='pad7b2'>
                
                <table class='cc100' style='border-collapse:separate;'><tr>
                <td class='nopadb2' style='width:50%; text-align:center;'>
				<div class='navMenuRound' <?php if(wp_is_mobile()){?>style='width:200px'<?php } ?>><a href='<?php echo SM_permalink();?>&amp;ts=<?php echo $_GET['ts'];?>&amp;#skedtop' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_settings16_reg.png' class='btn' />Back to Schedule</a></div>
                </td>
                <?php if(wp_is_mobile()){ // jump to next line+?>
                </tr><tr>
                <?php } ?>
                <td class='nopadb2' style='width:50%; text-align:center;'>
                <div class='navMenuRound'><a href='#' onClick='window.print();' title='Print' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_print16_reg.png' class='btn'>Print this Appointment</a></div>
                </td></tr></table>

				</td></tr>
				<?php } ?>
				<tr><td class='nopadb2'>&nbsp;</td></tr>
				<?php 
				//== no cancel if theres no email
				if($client_email!=""){?>
					<tr><td class='pad14b2'>You may cancel and reschedule your appointment by clicking below.</td></tr>
					<tr><td class='pad14b2' style='text-align:center;'>
					<div class='navCancel'  <?php if(wp_is_mobile()){?>style='width:225px'<?php } ?>><a href='<?php echo SM_permalink();?>&amp;op=cancel&amp;aptc=<?php echo $canCode; ?>&amp;#skedtop' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_cancel16_reg.png' class='btn'/>Cancel This Appointment</a></div>
					</td></tr>
					<?php if($cancelpolicy!=""){echo "<tr><td class='pad14'><span class='redText'>".$cancelpolicy."</span></td></tr>";} ?>
			   <?php } ?>
				</table>
				</td></tr></table>
				<?php
				$SM_permalink=SM_permalink();

				if($loginValidClient=="y"){
					$result=mysql_query("SELECT * FROM skedmaker_clients WHERE code='$usercode' LIMIT 1");
					while($row = mysql_fetch_array($result)){
						$client_email=SM_d($row['email']);
						$client_name=SM_d($row['username']);
					}
				}else{
					if($client_name==""){$client_name="n/a";}
				}
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
				<tr><td class='pad7' colspan='2'><a href='".$SM_permalink."&amp;op=cancel&amp;aptc=".$DBcode."&amp;#skedtop'>Click here if you need to cancel this appointment</a></td></tr>
				<tr><td class='pad7' colspan='2'><span class='redText'>".$cancelpolicy."</span></td></tr>
				</table>";
				$biz_info=SM_biz_info();
				$bodyData=$bodyData.$biz_info."</td></tr></table>";

				if(SM_emailIt(SM_d($client_email), $adminemail, "", "Appointment Scheduled- ".SM_d($client_name), $bodyData)===false){
					SM_redBox("Sorry, the e-mail could not be sent. Please try again later.", "100%", 18);
				}
				$success="y";
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
		$back=$smadmin."&amp;ts=".$_GET['ts'];
		$viewURL="&amp;v=".$_GET['v'];
	}else{
		$viewURL="";
		$back=SM_permalink()."&amp;op=sked&amp;ts=".$_GET['ts']."&amp;#skedtop";
	}

	if($success!="y"){ ?>
	<form id="form1" name="form1" method="post" action="<?php echo SM_permalink();?>&amp;op=confirm&amp;ts=<?php echo $_GET['ts'];?>&amp;#skedtop">
	<?php SM_uni_create();?>

   <table class='cc100'><tr><td class='pad7' style='vertical-align:middle; text-align:left;'><a href='' class='header'><img src='<?php echo $sm_btns_dir;?>btn_settings32_reg.png' class='btn'><?php echo $main_title_text;?></a></td></tr></table>

	<table class='cc100' style='border-collapse:separate;'>
    <?php if($errorMessage!=""){?><tr><td class='nopad' style='padding-bottom:14px;'><?php SM_redBox("The fields in red below are required...", "100%", 21); ?></td></tr><?php } ?>
	<tr><td class='nopad' style='padding-bottom:14px;'><?php SM_greenBox($showApt, "100%", 21); ?></td></tr>
	<tr><td class="blueBanner1"><?php echo $b1_text;?></td></tr>
	<tr><td class="blueBanner2">
	<table class='cc100'>
	<tr><td class='pad7b2' colspan='2'><b>Complete the form below to reserve this appointment.</b></td></tr>

<?php 
//////////////////////////////////////////////////////////////////////////////////////////////////
// -- Get the client info
//////////////////////////////////////////////////////////////////////////////////////////////////
	if($loginValidClient=="y"){
		$result=mysql_query("SELECT * FROM skedmaker_clients WHERE code='$usercode' LIMIT 1")or die(mysql_error());
		while($row = mysql_fetch_array($result)){
			$client_email=SM_d($row['email']);
			$client_name=SM_d($row['name']);
			$client_phone=SM_d($row['phone']);
		}
		if($client_phone==""){$client_phone="n/a";}
	}?>
	<tr><td class='label150'><?php SM_check_text("Name: ", $errorName);?></td>
	<?php if($loginValidClient=="y"){?>
		<td class='pad7b2' style='width:85%;'><?php echo SM_d($username);?></td></tr>
<?php }else{ ?>
		<td class='pad7b2' style='width:85%;'><input name="client_name" type="text" class='form_textfield' value="<?php echo SM_d($client_name);?>" maxlength="100"/></td></tr>
<?php }	?>

	<tr><td class='label150'><?php SM_check_text("E-mail: ", $errorEmail);?></td>
	<?php 
	if($loginValidClient=="y"){?>
		<td class='pad7b2' style='width:85%;'><?php echo $client_email;?></td></tr>
	<?php }else{ ?>
		<?php if($requireemail=="y"){?>
	        <td class='pad7b2' style='width:85%;'><input name="client_email" type="text" class='form_textfield' value="<?php echo SM_d($client_email);?>" maxlength="100" /></td></tr>
    <?php } 
	}
	?>
	<?php if($errorValid=="y"){echo "<tr><td class='label150'>&nbsp;</td><td class='pad7b2' style='padding-top:0px;'><span class='smallRed'>Enter a valid email address.</td></tr>";}?>

	<?php if($requireconfirm=="y" && $loginValidClient!="y"){?>
        <tr><td class='label150'><?php SM_check_text("Confirm E-mail: ", $errorConfirmEmail);?></td>
        <td class='pad7b2' style='width:85%;'><input name="confirm_email" type="text" class='form_textfield' value="<?php echo SM_d($confirm_email);?>" maxlength="100"/></td></tr>
	<?php } ?>

	<?php if($requirephone=='y' && $loginValidClient!="y"){ ?>
            <tr><td class='label150'><?php SM_check_text("Phone: ", $errorPhone);?></td>
            <td class='pad7b2' style='width:85%;'><input name="client_phone" type="text" class='form_textfield' value="<?php echo SM_d($client_phone);?>" maxlength="100" /></td></tr>
	<?php }else if($requirephone=="y" && $loginValidClient=="y"){ ?>
            <tr><td class='label150'><?php SM_check_text("Phone: ", $errorPhone);?></td>
            <td class='pad7b2' style='width:85%;'><?php echo $client_phone;?></td></tr>
	<?php } ?>	
	<?php if($requirenumberinparty=='y'){ ?>
	<tr><td class='label150'><?php SM_check_text("# in Party", $errorNumInParty);?>
	</td>
	<td class='pad7b2' style='width:85%;'>
	<select name='num_in_party' class='form_select'>
	<?php for($x=1; $x<=$partymax; $x++){ ?>
	<option value="<?php echo $x;?>" <?php if($x==$num_in_party){ ?> selected="selected" <?php } ?> ><?php echo $x;?></option>
	<?php } ?>
	</select>
	</td></tr>
	<?php } ?>

	<?php if($requiremessage=='y'){ ?>
	<tr><td class='label150'><?php SM_check_text("Message:", $errorContent);?></td><td class='pad7b2' style='width:85%;'>
	<textarea name="client_content" id="textarea" <?php if(!wp_is_mobile()){?> cols="45" rows="5" <?php } ?>class='form_area' ><?php echo SM_d($client_content);?></textarea></td></tr>
	<?php } ?>

	<tr><td class='label150'>&nbsp;</td><td class='pad7b2' style='width:85%;'><input type="submit" name="button" onclick='savingShow()' id="mainSave" style='text-transform:none;' value="<?php echo $button_text;?>"/>
	<div id='savingShow' style='display:none; padding:0px;'><img src='<?php echo $sm_btns_dir;?>_btns/saving.gif' alt='Saving' style='border:0px; padding:0px;'></div>
	</td></tr>
	<tr><td class='label150'>&nbsp;</td><td class='pad7b2'><div class='navMenuRound' <?php if(!wp_is_mobile()){?> style='width:275px;'<?php } ?>><a href="<?php echo $back; ?>" class='sked'><img src='<?php echo $sm_btns_dir;?>btn_settings16_reg.png' class='btn' alt='Pick a different appointment'/><?php echo $go_back_text;?></a></div></td></tr>
	<?php if($cancelpolicy!=""){echo "<tr><td class='pad7b2' style='text-align:center;' colspan='2'><span class='redText'>".$cancelpolicy."</td></tr></span>";}?>
	</table>
	</td></tr></table>
	</form>
<?php 
SM_foot();
}// end succes check