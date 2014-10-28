<?php 
if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['v']=='email_notices'){

	//======= EMAIL NOTICES
	if($_GET['op']=="notices"){
		$cancel=SM_e($_POST['cancel']);
		$notice_email=$_POST['notice_email']; // need not coded so can check if valid -- encoded after error checks
		$confirmation=SM_e($_POST['confirmation']);
		$notice_BCC1=$_POST['notice_BCC1'];
		$notice_BCC2=$_POST['notice_BCC2'];
		$notice_BCC3=$_POST['notice_BCC3'];

		$send_notices_to_admin=SM_e($_POST['send_notices_to_admin']);
		$send_notices_to_client=SM_e($_POST['send_notices_to_client']);
		$send_notices_to_BCC=SM_e($_POST['send_notices_to_BCC']);

		if($notice_email==""){$errorMessage="y"; $errorEmail="y";}

		if($notice_BCC1!="" && !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $notice_BCC1)){$errorMessage="emailvalidBCC1";  $errorBCC1='y'; $errorBCC1Valid="y";}
		if($notice_BCC2!="" && !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $notice_BCC2)){$errorMessage="emailvalidBCC1";  $errorBCC2='y'; $errorBCC2Valid="y";}
		if($notice_BCC3!="" && !eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $notice_BCC3)){$errorMessage="emailvalidBCC1";  $errorBCC3='y'; $errorBCC3Valid="y";}
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $notice_email)){$errorMessage="emailvalid";  $errorEmail='y'; $errorValid="y";}
		
	}

	//======= SAVE IT
	if($errorMessage==""){
		$redirect_to=$smadmin."&v=email_notices&";
		$save_message="Saved Changes to E-mail Notices!";
		$notice_email=SM_e($notice_email);
		$notice_BCC1=SM_e($notice_BCC1);
		$notice_BCC2=SM_e($notice_BCC2);
		$notice_BCC3=SM_e($notice_BCC3);
		$saveIt=mysql_query("UPDATE skedmaker_users SET cancel='$cancel', confirmation='$confirmation', adminemail='$notice_email', BCC1='$notice_BCC1', BCC2='$notice_BCC2', BCC3='$notice_BCC3', send_notices_to_admin='$send_notices_to_admin', send_notices_to_client='$send_notices_to_client', send_notices_to_BCC='$send_notices_to_BCC'")or die(mysql_error());

		if(!$saveIt){
			SM_redBox("Error saving, try again later.", 800, 21);
		}else{
			SM_greenBox($save_message, 800, 21);
			if(($newName!="" && $photo!="") || ($deletephoto=="y" && $photo!="")){
				@unlink("_files/".$photo);
				@unlink("_thumbs/".$photo);
				@unlink("_small/".$photo);
			}
			SM_redirect($redirect_to, 500);
			die();
		}
	}
}

$back_to_admin="<div class='navMenuRound'><a href='".$smadmin."&amp;v=home&amp;' title='Admin Home' class='sked'><img src='".$sm_btns_dir."btn_home16_reg.png' class='btn'/>Admin Home</a></div>";

?>
<table class='cc800' style='margin:0px;'><tr><td class='pad7' style='width:600px;'><a href='<?php echo $smadmin;?>&amp;v=email_notices&amp;' class='header'><img src='<?php echo $sm_btns_dir;?>btn_contact32b_reg.png' class='btn' alt='Email Notices'/>E-mail Notices</a></td>
</tr></table>

<?php if($errorMessage!=""){SM_redBox("Error! The fields in red below are required...", 800, 21);} echo "<bR>"?>

<!-- ==================================================================================================
======= EMAIL NOTICES========================================================
================================================================================================== -->
<a name='emailnotices'></a>
<form enctype="multipart/form-data" id="form1" name="form1" method="post" action="<?php echo $smadmin;?>&amp;v=email_notices&amp;op=notices&amp;" style="margin-top:0px">
<table class='cc800' style='margin-top:0px;'><tr><td class='blueBanner1'>Send and Receive E-mail Addresses and Options</td></tr>
<tr><td class='blueBanner2' style='padding:0px;'>

<table class='cc100' style='margin:0px;'>
<tr><td class='nopad' colspan='2'><?php SM_menu();?></td></tr>
<tr>
  <td class='pad14' colspan='2'>
<b>Enter the e-mail address below that you would like to send and receive notices.</b>
<br><br>
Admin E-mail will be used to send appointment confirmations and cancellations to your clients. If this field is left blank, your clients will not be able to receive confirmations when they book with you. You may also include up to three additional e-mail addresses to receive copies of all notices.
</td></tr>
<tr><td class='label200'><?php SM_check_text("Admin E-mail:", $errorEmail);?></td><td class='pad7' style='width:600px;'><input name="notice_email" type="text" class='smform_textfield' id="notice_email" style='width:400px;' value="<?php if($notice_email!=""){echo $notice_email;}else{echo $adminemail;}?>" maxlength="99"/></td></tr>
<?php if($errorValid=="y"){?><tr><td class='label150'>&nbsp;</td><td class='pad7' style='width:650px; padding-top:0px;'><span class='smallRed'>This is not a valid e-mail address</span></td></tr><?php } ?>

<tr><td class='label50'><input name="send_notices_to_admin" type="checkbox" id="send_notices_to_admin" value="y" <?php if ($send_notices_to_admin=="y") {?> checked='checked' <?php }?>/></td>
<td class='pad7'><label for="send_notices_to_admin"><b>E-mail Notices to Admin</b></label></td></tr>
<tr><td class='pad7'>&nbsp;</td>
<td style='padding:0px 14px 14px 7px;'><span class='smallG12'>Check if you want to have the admin e-mail copied on all in-coming and out-going notices.</span></td>
</tr>

<tr><td class='label50'><input name="send_notices_to_client" type="checkbox" id="send_notices_to_client" value="y" <?php if ($send_notices_to_client=="y") {?> checked='checked' <?php }?>/></td>
<td class='pad7'><label for="send_notices_to_client"><b>E-mail Notices to Clients</b></label></td></tr>
<tr><td class='pad7'>&nbsp;</td>
<td style='padding:0px 14px 14px 7px;'><span class='smallG12'>Check if you want to send appointment confirmations and cancellations to your clients.</span></td>
</tr>

<tr><td class='label150'><?php echo $back_to_admin;?></td><td class='pad7'><input type="submit" name="button" id="button" value="Save Changes to Admin E-mail Address" /></td>
</tr></table>
</td></tr></table>
<br />

<table class='cc800'><tr><td class='blueBanner1'>Appointment Confirmation E-mail Notice</td></tr>
<tr><td class='blueBanner2' style='padding:7px;'>

<table class='cc100'>
<tr><td class='pad7' colspan='2'>
<b>Customize this e-mail message to confirm your client's appointment.</b>
<br><br>
This message will be sent to your client, along with the appointment details.
</td></tr>
<tr><td class='pad5' colspan='2'><textarea name="confirmation" id="confirmation" cols="45" rows="7" class='form_area' style='width:725px;'><?php echo SM_dcontent($confirmation); ?></textarea></td></tr>
<tr><td class='label150'><?php echo $back_to_admin;?></td>
<td class='pad5'><input type="submit" name="button" id="button" value="Save Changes to Confirmation E-mail" /></td>
</tr></table>
</td></tr></table>

<br>

<table class='cc800'><tr><td class='blueBanner1'>Appointment Cancellation E-mail Notice</td></tr>
<tr><td class='blueBanner2' style='padding:7px;'>

<table class='cc100'>
<tr><td class='pad7' colspan='2'>
<b>Customize this e-mail message to cancel your client's appointment.</b>
<br><br>
This message will be sent to your client if YOU are the person who cancels the appointment.</span>
</td></tr>
<tr><td class='pad5' colspan='2'><textarea name="cancel" id="cancel" cols="45" rows="7" class='form_area' style='width:725px;'><?php echo SM_dcontent($cancel); ?></textarea>
</td></tr>

<tr><td class='label150'><?php echo $back_to_admin;?></td>
<td class='pad5'><input type="submit" name="button" id="button" value="Save Changes to Cancellation E-mail" /></td></tr>
</table>

</td></tr></table>
</form><br />
