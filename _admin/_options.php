<?php 
if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['v']=='options'){
	$errorMessage="";
	$keep_profile_open=$_POST['keep_profile_open'];
	$publicscheduleinput=$_POST['publicscheduleinput'];
	$allowsameday=$_POST['allowsameday'];
	$sitepublic=$_POST['sitepublic'];
	$setappointmentpadding=$_POST['appointmentpadding'];
	$protectInput=SM_e($_POST['protectInput']);
	$availableInput=SM_e($_POST['availableInput']);
	$unavailableInput=SM_e($_POST['unavailableInput']);
	$cancelpolicy=SM_e($_POST['cancelpolicy']);
	$calendarcaption=SM_e($_POST['calendarcaption']);

	//======= SAVE IT
	if($errorMessage==""){
		$saveIt=mysql_query("UPDATE skedmaker_users SET keep_profile_open='$keep_profile_open', sitepublic='$sitepublic', allowsameday='$allowsameday', appointmentpadding='$setappointmentpadding', publicschedule='$publicscheduleinput', protect='$protectInput', appointmentAvailable='$availableInput', appointmentUnavailable='$unavailableInput', cancelpolicy='$cancelpolicy', calendarcaption='$calendarcaption'");	
		if(!$saveIt){
			SM_redBox("Error saving, try again later.", 800, 21);
		}else{
			SM_greenBox("Saved Options!", 800, 21);
			SM_redirect($smadmin."&v=options&", 500);
			die();
		}
	}
}
SM_title("Booking Options", "btn_options32_reg.png", $smadmin."&amp;v=options&amp;");?>

<form enctype="multipart/form-data" id="form1" name="form1" method="post" action="<?php echo $smadmin;?>&amp;v=options&amp;op=options&amp;" style="margin-top:0px">
<table class='cc800'><tr><td class='blueBanner1'>Extra Options to Personalize Your Schedule</td></tr>
<tr><td class='blueBanner2' style='padding:0px;'>
<?php SM_menu();?>
<br />
<table class='cc100' style='margin-left:14px;'>

<!--
<tr><td class='pad7'><input name="keep_profile_open" type="checkbox" id="keep_profile_open" value="y" <?php if ($keep_profile_open=="y") { ?> checked='checked' <?php }?>/></td>
<td class='pad7'><label for='keep_profile_open'><b>Keep Business Profile Open/Displayed</b></label></td></tr>
<tr><td class='pad7'>&nbsp;</td><td style='padding:0px 14px 14px 7px;'>
<span class='smallG'>Checking this box allows visitors to make appointments. Some users may prefer to enter the scheduling information themselves. If this is not checked, clients will be able to see when you have appointmetns available, but not be able to reserve them online.</span>
</td></tr>
-->

<tr><td class='pad7'><input name="sitepublic" type="checkbox" id="sitepublic" value="y" <?php if ($sitepublic=="y") {echo "checked='checked'"; }?>/></td>
<td class='pad7'><label for="sitepublic"><b>Make Appointments Public</b></label></td></tr>
<tr><td class='pad7'><a name='sameday'></a></td><td style='padding:0px 14px 14px 7px;'>
<span class='smallG'>Checking this box allows visitors to make appointments. Some people may prefer to enter the scheduling information themselves. If this is not checked, clients will be able to see when you have appointmetns available, but not be able to reserve them online.</span>
</td></tr>

<tr><td class='pad7'><input name="allowsameday" type="checkbox" id="allowsameday" value="y" <?php if($allowsameday=="y") {?> checked='checked'<?php }?>/></td>
<td class='pad7'><label for="allowsameday"><b>Allow Same-Day Appointments</b></label></td></tr>
<tr><td class='pad7'>&nbsp;</td><td style='padding:0px 14px 14px 7px;'>
<span class='smallG'>If this is unchecked, clients will only be able to make appointments for upcoming days, not the present day.</span>
</td></tr>


<tr><td class='pad7'><input name="publicscheduleinput" type="checkbox" id="publicscheduleinput" value="y" <?php if($publicschedule=="y") {?> checked='checked'<?php }?>/></td>
<td class='pad7'><label for="publicscheduleinput"><b>Public Content</b></label></td></tr>
<tr><td class='pad7'>&nbsp;</td><td style='padding:0px 14px 14px 7px;'>
<span class='smallG'>Check this box to show what has been entered into your schedule. This will make public all names and messages submitted. This option is useful if you want to use your schedule as a public events calendar.</span>
</td></tr>
</table>


<table class='cc100' style='margin-left:14px;'>
<tr><td class='pad14'>
<select name="appointmentpadding" id="appointmentpadding" class='form_select'>
<option value='0'<?php if($appointmentpadding=="0" || $appointmentpadding==""){ ?> print selected="selected" <?php }?>>0</option>
<option value='1'<?php if($appointmentpadding=="1"){ ?>print selected="selected" <?php }?>>1</option>
<option value='2'<?php if($appointmentpadding=="2"){ ?>print selected="selected" <?php }?>>2</option>
<option value='3'<?php if($appointmentpadding=="3"){ ?>print selected="selected" <?php }?>>3</option>
<option value='4'<?php if($appointmentpadding=="4"){ ?>print selected="selected" <?php }?>>4</option>
<option value='5'<?php if($appointmentpadding=="5"){ ?>print selected="selected" <?php }?>>5</option>
<option value='6'<?php if($appointmentpadding=="6"){ ?>print selected="selected" <?php }?>>6</option>
<option value='7'<?php if($appointmentpadding=="7"){ ?>print selected="selected" <?php }?>>7</option>
<option value='8'<?php if($appointmentpadding=="8"){ ?>print selected="selected" <?php }?>>8</option>
<option value='9'<?php if($appointmentpadding=="9"){ ?>print selected="selected" <?php }?>>9</option>
<option value='10'<?php if($appointmentpadding=="10"){ ?>print selected="selected" <?php }?>>10</option>
<option value='11'<?php if($appointmentpadding=="11"){ ?>print selected="selected" <?php }?>>11</option>
<option value='12'<?php if($appointmentpadding=="12"){ ?>print selected="selected" <?php }?>>12</option>
</select>
<b> Hours of Appointment Padding</b><br />
<span class='smallG'>Use this setting to stop cleints from setting an appointment too close to the present time. See also Same-Day Appointments above.</span>
</td></tr>

<tr><td class='pad14'>
<b>Password Protect</b><br />
<input name="protectInput" type="password" class="form_textfield" id="protectInput" value="<?php echo $protect; ?>" size="35" maxlength="50" /><br />
<span class='smallG'>If you would like to protect your schedule, so only those who know the password can see it, enter a password here. This is a different field than your account password and is used commonly for protecting employee work schedules or other non-public schedules.</span>
</td></tr>
            
<tr><td class='pad14'>
<b>Appointment Available</b><br />
<input name="availableInput" type="text" class="form_textfield" id="availableInput" value="<?php echo $appointmentAvailable; ?>" size="35" maxlength="100" /><br />
<span class='smallG'>Displayed when there is an appointment available.</span>
</td></tr>

<tr><td class='pad14'>
<b>Appointment Not Available</b><br />
<input name="unavailableInput" type="text" class="form_textfield" id="unavailableInput" value="<?php echo $appointmentUnavailable; ?>" size="35" maxlength="100" /><br />
<span class='smallG'>Displayed when an appointment time is taken and not available.</span>
</td></tr>

<tr><td class='pad14'>
<b>Cancellation Policy</b><br />
<span class='smallG'>If your business has a cancellation policy, enter it here and the message will be displayed when your client makes an appointment.</span>
<br />
<textarea name="cancelpolicy" id="cancelpolicy" cols="49" rows="7" class='form_area' style='width:725px;'><?php echo $cancelpolicy; ?></textarea>
</td></tr>

<tr><td class='pad14'>
<b>Calendar Caption</b><br />
<span class='smallG'>Add a caption of text to display under your schedule.</span>
<br />
<textarea name="calendarcaption" id="calendarcaption" cols="49" rows="7" class='form_area' style='width:725px;'><?php echo SM_dcontent($calendarcaption); ?></textarea>
</td></tr>

<tr><td class='pad14'><input type="submit" name="button" id="button" value="Save Changes to Booking Options" /></td></tr>
</table>

</td></tr></table>
</form>
<br />