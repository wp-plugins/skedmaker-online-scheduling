<?php 
if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['v']=='requirements'){
	$errorMessage="";
	$requireregistration=$_POST['requireregistration'];
	$requirename=$_POST['requirename'];
	$requireemail=$_POST['requireemail'];
	$requireconfirm=$_POST['requireconfirm'];
	$requirephone=$_POST['requirephone'];
	$requiremessage=$_POST['requiremessage'];
	$requirenumberinparty=$_POST['requirenumberinparty'];
	$partymax=SM_e($_POST['partymax']);
	if($requirenumberinparty=='y'){if(!is_numeric($partymax)){$errorMessage='partymax';}}

	if($errorMessage==""){
		$saveIt=mysql_query("UPDATE skedmaker_users SET requireregistration='$requireregistration', requirename='$requirename', requireemail='$requireemail', requireconfirm='$requireconfirm', requirephone='$requirephone', requiremessage='$requiremessage', requirenumberinparty='$requirenumberinparty', partymax='$partymax'");	
		//======= SAVE IT
		if($errorMessage==""){
			if(!$saveIt){
				SM_redBox("Error saving, try again later.", 800, 21);
			}else{
				SM_greenBox("Saved Requirements!", 800, 21);
				SM_redirect($smadmin."&v=requirements&", 500);
				die();
			}
		}
	}
}
SM_title("Booking Requirements", "btn_requirements32_reg.png", $smadmin."v=requirements&amp;");
?>
<form enctype="multipart/form-data" id="form1" name="form1" method="post" action="<?php echo $smadmin;?>&amp;v=requirements&amp;" style="margin-top:0px">
<table class='cc800'>
<tr><td class='blueBanner1'>Add Mandatory Fields to Your Schedule</td></tr>
<tr><td class='blueBanner2' style='padding:0px;'>
<?php SM_menu();?>
<table class='cc100'>
<tr><td class='pad14' colspan='2'>
<b>These are the fields that require completion/input when clients make an appointment.</b>
<bR><br>
Adding a check to these items will make sure they have been filled in before the appointment is reserved.
<br><br>
</td></tr>

<tr><td class='label50'><input name="requireregistration" type="checkbox" id="requireregistration" value="y" <?php if ($requireregistration=="y") {?> checked='checked' <?php }?>/></td>
<td class='pad7'><label for="requireregistration"><b>Require Registration</b></label></td></tr>
<tr><td class='pad7'>&nbsp;</td>
<td style='padding:0px 14px 14px 7px;'><span class='smallG12'>Your clients must create a user account and log in before the calendar can be accessed..</span><br />
<span class='greenText'>Soon to be available in Skedmaker PRO version</span>
</td>
</tr>


<tr><td class='label50'><input name="requirename" type="checkbox" id="requirename" value="y" <?php if ($requirename=="y") {?> checked='checked' <?php }?>/></td>
<td class='pad7'><label for="requirename"><b>Require Name</b></label></td></tr>
<tr><td class='pad7'>&nbsp;</td>
<td style='padding:0px 14px 14px 7px;'><span class='smallG12'>Your clients must provide their name before an appointment is scheduled.</span></td>
</tr>

<tr><td class='label50'><input name="requireemail" type="checkbox" id="requireemail" value="y" <?php if ($requireemail=="y") {?> checked='checked' <?php }?>/></td>
<td class='pad7'><label for="requireemail"><b>Require E-mail</b></label></td></tr>
<tr><td class='pad7'>&nbsp;</td>
<td style='padding:0px 14px 14px 7px;'><span class='smallG12'>Your clients must provide their e-mail address before an appointment is scheduled.</span></td>
</tr>

<tr><td class='label50'><input name="requireconfirm" type="checkbox" id="requireconfirm" value="y" <?php if ($requireconfirm=="y") {?> checked='checked' <?php }?>/></td>
<td class='pad7'><label for="requireconfirm"><b>Require E-mail Confirmation</b></label></td></tr>
<tr><td class='pad7'>&nbsp;</td>
<td style='padding:0px 14px 14px 7px;'><span class='smallG12'>Your clients must re-enter their e-mail to confirm it is entered correctly before an appointment is scheduled.</span></td>
</tr>

<tr><td class='label50'><input name="requirephone" type="checkbox" id="requirephone" value="y" <?php if ($requirephone=="y") {?> checked='checked' <?php }?>/></td>
<td class='pad7'><label for="requirephone"><b>Require Phone Number</b></label></td></tr>
<tr><td class='pad7'>&nbsp;</td>
<td style='padding:0px 14px 14px 7px;'><span class='smallG12'>Your clients must provide their phone number before an appointment is scheduled.</span></td>
</tr>

<tr><td class='label50'><input name="requiremessage" type="checkbox" id="requiremessage" value="y" <?php if ($requiremessage=="y") {?> checked='checked' <?php }?>/></td>
<td class='pad7'><label for="requiremessage"><b>Require Message</b></label></td></tr>
<tr><td class='pad7'>&nbsp;</td>
<td style='padding:0px 14px 14px 7px;'><span class='smallG12'>Your clients must provide a message or instruction to you before an appointment is scheduled.</span></td>
</tr>

<tr><td class='label50'><input name="requirenumberinparty" type="checkbox" id="requirenumberinparty" value="y" <?php if ($requirenumberinparty=="y") {?> checked='checked' <?php }?>/></td>
<td class='pad7'><label for="requirenumberinparty"><b>Require Number in Party</b></label></td></tr>
<tr><td class='pad7'>&nbsp;</td>
<td style='padding:0px 14px 14px 7px;'><span class='smallG12'>Your clients must select the number of people who will be at the appointment.</span></td>
</tr>
</table>

<table class='cc100'>
<tr><td class='label100' style='width:50px;'><input name="partymax" type="text" id="partymax" value='<?php echo $partymax?>' size="10" maxlength="7" class='form_textfield' style='width:50px;'/></td>
<td class='pad7' style='width:700px;'><?php if($errorMessage=='partymax'){echo "<span class='redText'>Maximum Number Allowed in Party</span>";}else{echo "<b>Maximum Number Allowed in Party</b>";}?></td></tr>
<tr><td class='pad7'>&nbsp;</td>
<td style='padding:0px 14px 14px 7px;'><span class='smallG12'>Set the number of clients you will allow in a single party.</span></td>
</tr>

<tr><td class='pad7'>&nbsp;</td><td class='pad7'><input type="submit" name="button" id="button" value="Save Changes to Booking Requirements" /></td></tr>
</table>
<br />
</td></tr></table>
</form>