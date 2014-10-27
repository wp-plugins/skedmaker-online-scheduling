<?php
if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['v']=='profile'){
	$errorMessage="";
	//======= CONTACT INFO
	if($_GET['op']=="contactinfo"){
		$sitename=SM_e($_POST['sitename']);
		$phone=SM_e($_POST['phone']);
		$cellphone=SM_e($_POST['cellphone']);
		$fax=SM_e($_POST['fax']);
		$website=SM_e($_POST['website']);

		if($errorMessage==""){
			$saveIt=mysql_query("UPDATE skedmaker_users SET sitename='$sitename', phone='$phone', cellphone='$cellphone', fax='$fax', website='$website'")or die(mysql_error());
			$redirect_to=$smadmin."&v=profile&#contactinfo";
			$save_message="Saved Contact Info!";
		}
	}
	
		//======= CONTACT INFO
	if($_GET['op']=="locationinfo"){
		$address1=SM_e($_POST['address1']);
		$address2=SM_e($_POST['address2']);
		$city=SM_e($_POST['city']);
		$region=SM_e($_POST['region']);
		$zipcode=SM_e($_POST['zipcode']);
		$country=SM_e($_POST['country']);
		$settimezone=$_POST['timezone'];
		$directionsURL=SM_e($_POST['directionsURL']);

		if($errorMessage==""){
			$saveIt=mysql_query("UPDATE skedmaker_users SET address1='$address1', address2='$address2', city='$city', region='$region', zipcode='$zipcode', country='$country', directionsURL='$directionsURL'")or die(mysql_error());
			$redirect_to=$smadmin."&v=profile&#location";
			$save_message="Saved Location Info!";
		}
	}

	//======= BUSINESS DESCRIPTION
	if($_GET['op']=="description"){
		$content=SM_e($_POST['content']);
		$saveIt=mysql_query("UPDATE skedmaker_users SET content='$content'");
		$redirect_to=$smadmin."&v=profile&#description";
		$save_message="Saved Business Description!";
	}

	//======= SAVE IT
	if($errorMessage==""){
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
SM_title("Business & Contact Info", "btn_documents32_reg.png", $smadmin."&amp;v=profile&amp;");
?>
<table class='cc800'><tr>
<td class='nopad' style='width:60%;' valign='top'>
<table style='width:100%;'>
<tr><td class='b2-only' style='padding:14px;'>
<b>Here is where you manage the contact information and location details of your account.</b>
<br><br>
This information is shown to your clients when they confirm an appointment with you. It will also be e-mailed to your client along with their confirmation.
<br><br>
Add your company name, location, contact information and a description of the business you do.<br></td></tr></table>
</td>
<td class='pad7' style='padding-top:0px; width:40%;' valign='top'>
<table class='cc100'>
<tr><td class='dot200'><div class='navMenuRound'><a href='#contactinfo' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_contact16_reg.png' class='btn' />Contact Info</a></div></td></tr>
<tr><td class='dot200'><div class='navMenuRound'><a href='#location' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_location16_reg.png' class='btn' />Location</a></div></td></tr>
<tr><td class='dot200'><div class='navMenuRound'><a href='#description' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_bisdesc16_reg.png' class='btn' />Business Description</a></div></td></tr>
<tr><td class='pad7'><div class='navMenuRound'><a href='<?php echo $smadmin;?>&amp;v=home&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_home16_reg.png' class='btn' />Admin Home</a></div></td></tr>
</table>
</td></tr></table>
<br />
<!-- ==================================================================================================
======= CONTACT INFO ========================================================
================================================================================================== -->
<a name='contactinfo'></a>
<form enctype="multipart/form-data" id="form1" name="form1" method="post" action="<?php echo $smadmin;?>&amp;v=profile&amp;op=contactinfo&amp;" style="margin-top:0px">
<table class='cc800'><tr>
<td class='blueBanner1'><?php SM_top();?><img src='<?php echo $sm_btns_dir;?>btn_contact16_reg.png' style='vertical-align:middle; margin-right:7px;' />Contact Information</td></tr>
<tr><td class='blueBanner2'>

<table class='cc100'>
<!-- <tr><td class='pad10'  colspan='2'>You may leave any of these fields blank, and they will not be included in your profile.</td></tr> -->

<tr><td class='label150'>Company Name:</td>
<td class='pad7'><input name="sitename" type="text" id="sitename" value="<?php echo $sitename; ?>" maxlength="450" class="smform_textfield" style='width:500px;'/></td></tr>

<tr><td class='label150'>Phone Number:</td>
<td class='pad7'><input name="phone" type="text" id="phone" value="<?php echo $phone; ?>" size="50" maxlength="100" class="form_textfield" style='width:500px;'/></td></tr>

<tr><td class='label150'>Cell Phone:</td>
<td class='pad7'><input name="cellphone" type="text" id="cellphone" value="<?php echo $cellphone; ?>" size="50" maxlength="100" class="form_textfield" style='width:500px;'/></td></tr>

<tr><td class='label150'>Fax:</td>
<td class='pad7'><input name="fax" type="text" id="fax" value="<?php echo $fax; ?>" size="50" maxlength="100" class="form_textfield" style='width:500px;'/></td></tr>

<tr><td class='label150'>Web Site Address:</td>
<td class='pad7'><input name="website" type="text" id="website" value="<?php echo $website; ?>" size="50" maxlength="450" class="form_textfield" style='width:500px;'/></td></tr>

<tr><td class='label150'>&nbsp;</td>
<td class='pad7' style='padding-top:0px;'><span class='smallG'>Enter full url, example: http://www.skedmaker.com </span>
</td></tr>
<tr><td class='pad7'></td><td class='pad10'><input type="submit" name="button" id="button" value="Save Changes to Contact Info" /></td></tr>

</table></td></tr></table>
</form>
<br />


<!-- ==================================================================================================
======= LOCATION INFO ========================================================
================================================================================================== -->
<a name='location'></a>
<form enctype="multipart/form-data" id="form1" name="form1" method="post" action="<?php echo $smadmin;?>&amp;v=profile&amp;op=locationinfo&amp;" style="margin-top:0px">
<table class='cc800'><tr>
<td class='blueBanner1'><?php SM_top();?><img src='<?php echo $sm_btns_dir;?>btn_location16_reg.png' style='vertical-align:middle; margin-right:7px;' />Location Information</td></tr>
<tr><td class='blueBanner2'>
<table class='cc100'>
<tr><td class='label150'>Address Line 1:</td>
<td class='pad7'><input name="address1" type="text" id="address1" value="<?php echo $address1; ?>" size="50" maxlength="450" class="form_textfield" style='width:500px;'/></td></tr>

<tr><td class='label150'>Address Line 2:</td>
<td class='pad7'><input name="address2" type="text" id="address2" value="<?php echo $address2; ?>" size="50" maxlength="450" class="form_textfield" style='width:500px;'/></td></tr>

<tr><td class='label150'>City:</td>
<td class='pad7'><input name="city" type="text" id="city" value="<?php echo $city; ?>" size="50" maxlength="450" class="form_textfield" style='width:500px;'/></td></tr>

<tr><td class='label150'>State/Region:</td>
<td class='pad7'><input name="region" type="text" id="region" value="<?php echo $region; ?>" size="50" maxlength="450" class="form_textfield" style='width:500px;'/></td></tr>

<tr><td class='label150'>Zip/Postal Code:</td>
<td class='pad7'><input name="zipcode" type="text" id="zipcode" value="<?php echo $zipcode; ?>" size="50" maxlength="450" class="form_textfield" style='width:500px;'/></td></tr>

<tr><td class='label150'>Country:</td>
<td class='pad7' align='left'><input name="country" type="text" id="country" value="<?php echo $country; ?>" maxlength="450" class='form_textfield' style='width:500px;'/></td></tr>

<tr><td class='label150'>Directions:</td>
<td class='pad7' style='padding-bottom:0px'><input name="directionsURL" type="text" id="directionsURL" value="<?php echo $directionsURL; ?>" size="50" maxlength="100" class="form_textfield" style='width:500px;'/></td></tr>

<tr><td class='label150'>&nbsp;</td>
<td class='pad14' style='padding-top:0px'><span class='smallG'>Add a link to a directions website, like Google Maps or Mapquest.</td></tr>

<tr><td class='pad7'></td><td class='pad10'><input type="submit" name="button" id="button" value="Save Changes to Location Info" /></td></tr>
</table>

</td></tr></table>
</form><br />

<!-- ==================================================================================================
======= BUSINESS DESCRIPTION ========================================================
================================================================================================== -->
<a name='description'></a>
<form enctype="multipart/form-data" id="form1" name="form1" method="post" action="<?php echo $smadmin;?>&amp;v=profile&amp;op=description&amp;" style="margin-top:0px">
<table class='cc800'><tr><td class='blueBanner1'><?php SM_top();?><img src='<?php echo $sm_btns_dir;?>btn_bisdesc16_reg.png' style='vertical-align:middle; margin-right:7px;' />Business Description</td></tr>
<tr><td class='blueBanner2'>

<table class='cc100'>
<tr><td class='pad10' colspan='2'><b>Enter text below to describe your business.</b>
</td></tr>
<tr><td class='pad7'><textarea name="content" id="content" style='width:725px;'rows="14" class='form_area'><?php echo SM_dcontent($content);?></textarea></td></tr>
<tr><td class='pad7'><input type="submit" name="button" id="button" value="Save Changes to Business Description" /></td></tr>
</table>

</td></tr></table>
</form><br />