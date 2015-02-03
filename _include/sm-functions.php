<?php
//////////////////////////////////////////////////////////////////////////////////////////////////
//=======  Coding and decoding
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_d')){function SM_d($DBvar){return stripslashes(urldecode($DBvar));}}
if(!function_exists('SM_e')){function SM_e($DBvar){return urlencode(nl2br(trim($DBvar)));}}
if(!function_exists('SM_dcontent')){function SM_dcontent($DBvar){return str_replace("<br />", "", stripslashes(urldecode($DBvar)));}}

if(!function_exists('SM_logout')){function SM_logout(){
	if($_GET['op']=='logout'){
		$oldRem=$_COOKIE['rem'];
		$loginValidClient='n';
		session_destroy();
		SM_redBox("Logging Out...", "100%", 21);
		SM_redirect(SM_permalink()."&#skedtop", 500);
		echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
		die();
	}
}}

function SM_now(){
	$result=mysql_query("SELECT * FROM skedmaker_users");
	while($row = mysql_fetch_array($result)){$timezone=SM_d($row['timezone']); $daylight_savings=SM_d($row['daylight_savings']);}

	//======= time passed calculations
	$d1=date('Y-m-d H:i.s');
	$d2=SM_timestamp($d1);

	$check_DST=date("I", time());
	if($check_DST==1 && $daylight_savings=="y"){$d2=$d2+3600;}

	$d3=strtotime("$timezone hours", $d2);
	return $d3;
}


//////////////////////////////////////////////////////////////////////////////////////////////////
//-- re-sends the validation email to a client based on the $bvalid_code passed from the login page
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_resend_validation')){function SM_resend_validation(){
	if($_GET['op']=="resend"){
		$valid_code=SM_e($_GET['vc']);
		$result=mysql_query("SELECT * FROM skedmaker_clients WHERE code='$valid_code' LIMIT 1");
		while($row=mysql_fetch_array($result)){
			$new_email=SM_d($row['email']);
			$new_username=SM_d($row['username']);
		}

		//-- if the email is not blank, then send the validation
		if($new_email!=""){
			$bodyData="<table class='cc800'>
				<tr><td class='pad7'><span class='header'>".$sitename."</span></td></tr>
				<tr><td class='blueBanner1'>Validate Your Account</td></tr>
				<tr><td class='blueBanner2' style='padding-left:0px; padding-right:0px;'>
				<table class='cc100'>
				<tr><td class='pad7'><b>Click the link below to validate your e-mail address and activate your account.</td></tr>
				<tr><td class='pad7'><a href='".SM_permalink()."&amp;op=validate&amp;vc=".$valid_code."&amp;#skedtop'>Click here to validate your account now.</a></td></tr>
				</table>
				</td></tr></table>";
			if(SM_emailIt(SM_d($new_email), $adminemail, "", "Account Validation - ".SM_d($new_username), $bodyData)===false){
				SM_redBox("Could not send validation email.", "100%", 21);
			}else{
				SM_greenBox("Sent validation e-mail to: ".$new_email, "100%", 18);	
				SM_redirect(SM_permalink(), 2000);
			}
		//-- if the email is blank, then there's an error - redirect
		}else{
			SM_redBox("Invalid Action!", "100%", 18);	
			SM_redirect(SM_permalink(), 2000);
		}
	}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Sends passsword when it has been forgotten
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_forgot_login')){function SM_forgot_login(){
if($_GET['op']=="forgot"){
	global $adminemail; global $BCC;
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
	if(wp_is_mobile()){
		$send_btn_text="Send It";
	}else{
		$send_btn_text="Send My Password";
	}
	//------- SUBMIT BUTTON
	if ($_SERVER['REQUEST_METHOD']=='POST'){
		$forgotemail=urlencode($_POST['forgotemail']);
		$errorMessage="";
		$notReg="";
		if($forgotemail==""){$errorMessage="email"; $errorEmail="y";}
		if($errorMessage==""){
			$forgot_email=SM_e($forgot_email);
			$result=mysql_query("SELECT * FROM skedmaker_clients WHERE email='$forgotemail' LIMIT 1");
			while($row = mysql_fetch_array($result)){$userPass=SM_d($row['password']);}

			if($userPass!="" && $forgotemail!=""){
				$userPass=SM_d($userPass);
				$forgotemail=SM_d($forgotemail);

				$bodyData="<table style='width:800px;'>
				<tr><td colspan='2'><b>You requested your password be e-mailed to you.</b></td></tr>
				<tr class=''><td width='20%'><b>Your Password is:</b></td><td>".$userPass."</td></tr>
				<tr class=''><td colspan='2'>Have a nice day!</td></tr>
				</table>";

				if(SM_emailIt($forgotemail, $adminemail, $BCC, "A reminder", $bodyData)!=true){
					SM_redBox("Sorry, the e-mail could not be sent. Please try again later.", "100%", 16);
				}else{
					echo "<br><br>";
					$success="y";
					SM_greenBox("Password E-mailed!", "100%", 21);
					SM_redirect(SM_permalink()."&#skedtop", 500);
				}
			}else{
				$notReg="<span class='redText'>Sorry, this e-mail is not registered.</span>";
			}
		}
	}
	$forgotemail=SM_d($forgotemail);
	if($errorMessage!=""){SM_redBox("Enter your e-mail address...", "100%", 21);echo "<br>";}
	if($success!="y"){	?>
        <form name="form1" method="post" action="<?php echo SM_permalink();?>&amp;op=forgot&amp;#skedtop" style="margin:0px; border:0px;">
        <table class='cc100' style='border-collapse:separate;'>
        <tr><td class='blueBanner1'><img src='<?php echo $sm_btns_dir;?>btn_send32_reg.png' class='btn'>Send My Password</td></tr>

        <tr><td class='blueBanner2' colspan='2'>
        <table class='cc100'>
        <tr><td class='pad7b2' colspan='2'><b>Enter your e-mail below to receive your password.</b></td></tr>
        <tr><td class='label150'><?php SM_check_text("E-mail:", $errorEmail);?></td>
        <td class='pad7b2'><input name="forgotemail" type="text" id="forgotemail" class='form_textfield' value="<?php echo $forgotemail; ?>"  maxlength="100"></td></tr>
        <?php if($notReg!=""){echo "<tr><td class='label150'>&nbsp;</td><td class='pad7b2'>".$notReg."</td></tr>"; }?>
        <tr><td class='nopadb2' style='text-align:center; width:30%;'><div class='navMenuRound'><a href='<?php echo SM_permalink();?>&amp;#skedtop'><img src='<?php echo $sm_btns_dir;?>btn_settings16_reg.png' class='btn'><b>Back</b></a></div></td>
        <td class='pad7b2'><input type="submit" name="button" id="contact" value="<?php echo $send_btn_text;?>"></td></tr>
        </table>
        </td></tr></table>
        </form>
        <?php SM_foot(); 
	} // end succes checks
}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Validates client's account after they click on the email link
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_validate_account')){function SM_validate_account(){
	if($_GET['op']=="validate"){
		$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
		//------- takes the valid_code variable passed from an email link and then validates the client's account.
		$valid_code=SM_e($_GET['vc']);
		$total=mysql_num_rows(mysql_query("SELECT * FROM skedmaker_clients WHERE code='$valid_code' LIMIT 1"));
		if($total>0){
			$saveIt=mysql_query("UPDATE skedmaker_clients SET valid='y' WHERE code='$valid_code' LIMIT 1");
			if(!$saveIt){
				SM_redBox("Could not validate, try again later.", "100%", 21);
			}else{

				$result=mysql_query("SELECT * FROM skedmaker_clients WHERE code='$valid_code' LIMIT 1");
				while($row = mysql_fetch_array($result)) {$sess_username=SM_d($row['username']);}

				$loginValidClient="y";
				$_SESSION['usercode']=$valid_code;
				$_SESSION['username']=$sess_username;
				$_SESSION['loginValidClient']=$loginValidClient;
				SM_greenBox("Account Validated!", "100%", 21);
				echo "<table class='cc100' style='margin-top:7px; border-collapse:separate;'>";
				echo "<tr><td class='blueBanner1'>Validate Account</td></tr>";
				echo "<tr><td class='blueBanner2' style='padding:21px'><b>You have successfully validated your account.</b>";
				echo "<br><br><b><img src='".$sm_btns_dir."btn_settings16_reg.png' class='btn'>Opening schedule...</b>";
				echo "</td></tr></table>";
				SM_redirect(SM_permalink(), 3000);
			}
		}else{
			SM_redBox("Sorry, this action is not permitted.", "100%", 21);
			SM_redirect(SM_permalink(), 3000);
		}
	}
}}

if(!function_exists('SM_permalink')){function SM_permalink(){
	$countIt=@mysql_query("SELECT * FROM wp_options WHERE option_name='permalink_structure' AND option_value='/%postname%/' LIMIT 1");
	$uses_perm=@mysql_num_rows($countIt);

	$countIt=@mysql_query("SELECT * FROM wp_options WHERE option_name='permalink_structure' AND option_value='' LIMIT 1");
	$uses_default=@mysql_num_rows($countIt);

	// check if using permalinks
	if($uses_perm>0){
		$result=mysql_query("SELECT post_name FROM wp_posts WHERE post_content LIKE '%wp-skedmaker%' AND post_status='publish' LIMIT 1");
		while($row = mysql_fetch_array($result)) {
			$SM_ID=SM_d($row['post_name']);		
			$SM_permalink=get_site_url()."/".$SM_ID."?";		
		}

	// check if using default
	}else if($uses_default>0){
		$result=mysql_query("SELECT ID FROM wp_posts WHERE post_content LIKE '%wp-skedmaker%' AND post_status='publish' LIMIT 1");
		while($row = mysql_fetch_array($result)) {
			$SM_ID=SM_d($row['ID']);
			$SM_permalink=get_site_url()."/?page_id=".$SM_ID;				
		}
	}else{
		function SM_thisURL(){
			$isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on");
			$port = (isset($_SERVER["SERVER_PORT"]) && ((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") || ($isHTTPS && $_SERVER["SERVER_PORT"] != "443")));
			$port = ($port) ? ':'.$_SERVER["SERVER_PORT"] : '';
			$url = ($isHTTPS ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$port.$_SERVER["REQUEST_URI"];
			return $url;
		}
		$full_url=SM_thisURL();
		$url_bits=explode("?",$full_url);
		$main_url=$url_bits[0];
		$SM_permalink=$main_url."?";
		//$SM_permalink=get_site_url()."?";
	}
	return $SM_permalink;
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Individual item for admin menu
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_vert_menu')){function SM_vert_menu($text, $img, $url){
	global $smadmin;
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
	echo "<tr><td class='dot300'><div class='navMenuRound'><a href='".$smadmin.$url."' class='sked'><img src='".$sm_btns_dir.$img."' style='border:0px; margin-right:14px; vertical-align:middle' />".$text."</a></div></td></tr>";
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- red item for reminders
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_vert_menu_red')){function SM_vert_menu_red($text, $img, $url){
		global $smadmin;
		$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";

echo "<tr><td class='pad14' style='padding-top:0px; padding-bottom:7px;'><div class='navRedReminders'><a href='".$smadmin.$url."' class='b2w'><img src='".$sm_btns_dir.$img."' style='border:0px; margin-right:14px; vertical-align:middle' /><b>".$text."</b></a></div></td></tr>";
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Prepares the business info to display or send to client in email 
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_biz_info')){function SM_biz_info(){
	global $site;
	$result=mysql_query("SELECT * FROM skedmaker_users");
	while($row=mysql_fetch_array($result)){
		$sitename=SM_d($row['sitename']);
		$phone=SM_d($row['phone']);
		$photo=SM_d($row['photo']);
		$cellphone=SM_d($row['cellphone']);
		$fax=SM_d($row['fax']);
		$address1=SM_d($row['address1']);
		$address2=SM_d($row['address2']);
		$region=SM_d($row['region']);
		$city=SM_d($row['city']);
		$country=SM_d($row['country']);
		$zipcode=SM_d($row['zipcode']);
		$website=SM_d($row['website']);
		$content=SM_d($row['content']);
		$directionsURL=SM_d($row['directionsURL']);
		$content_for_photo=SM_d($row['content']); // was not displaying properly on admin page, because of edit box
	}

	if($address1!="" || $address2!="" || $city!="" || $region!="" || $zipcode!="" || $country!="" ||$phone!="" || $cellphone!="" || $website!="" || $photo!=""){
		$FINAL="<table class='cc800'>";
		if($sitename!=""){$FINAL.="<tr><td class='blueBanner1'>You are scheduled at: ".$sitename."</td></tr>";}
		$FINAL.="<tr><td class='nopad'>";
		$FINAL.="<table class='cc100'><tr>";

		if($address1!="" || $address2!="" || $city!="" || $region!="" || $zipcode!="" || $country!=""){
			$FINAL.="<td valign='top' class='pad14' style='width:50%;'>";
			$FINAL.="<span style='font-size:16px; font-weight:bold; margin-top:14px;'>Address:</span><br>";
			if($address1!=""){$FINAL.="".$address1."</b><br>";}
			if($address2!=""){$FINAL.="".$address2."</b><br>";}
			if($city!=""){$FINAL.="".$city.", </b>";}
			if($region!=""){$FINAL.="".$region."</b><br>";}
			if($zipcode!=""){$FINAL.="".$zipcode."</b> ";}
			if($country!=""){$FINAL.="".$country."</b>";}
			if($directionsURL!=""){$FINAL.="<div class='navMenu' style='width:200px;'><a href='".$directionsURL."' target='_blank'>Get Directions</a></div>";}
			$FINAL.="</td>";
		}

		if($phone!="" || $cellphone!="" || $website!=""){
			$FINAL.="<td valign='top' class='pad14' style='width:50%;'>";
			$FINAL.="<span style='font-size:16px; font-weight:bold;'>Contact Info:</span><br>";
			if($phone!=""){$FINAL.="<b>Phone: </b>".$phone."<br>";}
			if($cellphone!=""){$FINAL.="<b>Cell: </b>".$cellphone."<br>";}
			if($fax!=""){$FINAL.="<b>Fax: </b>".$fax."<br>";}
			if($website!=""){$FINAL.="<div class='navMenu'><a href='".$website."' target='_blank'>Go to Website</a></div>";}
			$FINAL.="</td>";
		}
		$FINAL.="</tr>";

		if($content!=""){$FINAL.="<tr><td colspan='2' class='pad14'>".$content."</td></tr>";}
		
		$FINAL.="</table>";
		$FINAL.="</td></tr></table>";
	} 
	return $FINAL;
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- limit the number of characters in a string
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_char_lim')){function SM_char_lim($str, $n, $end_char = '&#8230;'){
	if (strlen($str) < $n){return $str;}
	$str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));
	if (strlen($str) <= $n){return $str;}
	$out = "";
	foreach (explode(' ', trim($str)) as $val){
		$out .= $val.' ';
		if (strlen($out) >= $n){
			$out = trim($out);
			return (strlen($out) == strlen($str)) ? $out : $out.$end_char;
		}       
	}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- date functions
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_ts')){function SM_ts(){$date=strtotime(date("Y-m-d H:i.s")); return $date;}}
if(!function_exists('SM_timestamp')){function SM_timestamp($timeDateVar){return strtotime($timeDateVar);}}
if(!function_exists('SM_timestring')){function SM_timestring($timeStringVar){return date("Y-m-d-H-i-s", $timeStringVar);}}
if(!function_exists('SM_apt')){function SM_apt($APTtimestamp){return date("l, F d, Y, g:i a", $APTtimestamp);}}
if(!function_exists('SM_aptShort')){function SM_aptShort($APTtimestamp){if($APTtimestamp!=""){return date("M d, Y, g:i a", $APTtimestamp);}}}
if(!function_exists('SM_dateText')){function SM_dateText($dateTimestamp){return date("l, F d, Y", $dateTimestamp);}}
if(!function_exists('SM_dateTextShort')){function SM_dateTextShort($dateTimestamp){if($dateTimestamp!=""){return date("M d, Y", $dateTimestamp);}}}
if(!function_exists('SM_timeText')){function SM_timeText($timeVar){return date("g:i a", $timeVar);}}
if(!function_exists('SM_timeText_noampm')){function SM_timeText_noampm($timeVar){return date("g:i", $timeVar);}}
if(!function_exists('SM_timeText')){function SM_timeHour($timeVar){return date("g", $timeVar);}}
if(!function_exists('SM_birthdayText')){function SM_birthdayText($dateTimestamp){if($dateTimestamp!=""){return date("F d, Y", $dateTimestamp);}}}
if(!function_exists('SM_dateNum')){function SM_dateNum($dateTimestamp){if($dateTimestamp!=""){return date("m/d/Y", $dateTimestamp);}}}
if(!function_exists('SM_dateNumTime')){function SM_dateNumTime($dateTimestamp){if($dateTimestamp!=""){return date("m/d/Y h:i a", $dateTimestamp);}}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- gets ip address
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_ip')){function SM_ip(){
	$ip=$_SERVER['REMOTE_ADDR']; 
	if($ip==""){$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];}
	if($ip==""){$ip="No IP";}
	return $ip;
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- gets the clients location to save for signup and logins
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_location')){function SM_location(){
	$ip=$_SERVER['REMOTE_ADDR'];
	if($ip==""){$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];}
	if($ip!=""){
		$tags=@get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress='.$ip);
		$country=$tags['country'];
		$region=$tags['region'];
		$city=$tags['city'];
		$location=SM_e($city.", ".$region.", ".$country);
	}else{
		$location="Could not get location from IP";	
	}
	return $location;
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Cost format, save this
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_cost_format')){function SM_cost_format($num){
	if($num!=""){
		$cost=number_format($num, 2, '.', ',');
	}else{
		$cost="0.00";
	}
	return $cost;
}}

//==================================================================================================
//======= Stagger the TR tag
//==================================================================================================
if(!function_exists('SM_stagger')){function SM_stagger($stagger){
	if($stagger==""){echo "<tr>"; $stagger=1;}else{echo "<tr class='stagger'>"; $stagger="";}
	return $stagger;
}}

//==================================================================================================
//======= Create quick horz admin menu
//==================================================================================================
if(!function_exists('SM_quick_menu')){function SM_quick_menu(){
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
	echo "<table class='cc100'><tr class='menu'>
	<td class='menu' style='width:25%;'><div class='navMenu'><a href='admin_home.php?v=appointments&amp;' class='sked'><img src='".$sm_btns_dir."btn_listapt16_reg.png' class='btn' />List Appointments</a></div></td>
	<td class='menu' style='width:18%;'><div class='navMenu'><a href='admin_home.php?v=clients&amp;' class='sked'><img src='".$sm_btns_dir."btn_clients16_reg.png' class='btn' />List Clients</a></div></td>
	<td class='menu' style='width:19%;'><div class='navMenu'><a href='admin_home.php?v=home&amp;' class='sked'><img src='".$sm_btns_dir."btn_home16_reg.png' class='btn'/>Admin Home</a></div></td>
	<td class='menu' style='width:38%;'>&nbsp;</td>
	</tr></table>";
}}


//////////////////////////////////////////////////////////////////////////////////////////////////
//-- creates a simple title to go at top of pages
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_title')){function SM_title($text, $img, $link){
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
	if($link!=""){
		echo "<table class='cc800'><tr><td class='pad7' style='vertical-align:middle; text-align:left;'><a href='".$link."' class='header'><img src='".$sm_btns_dir.$img."' class='btn'>".$text."</a></td></tr></table>";
	}else{
		echo "<table class='cc800'><tr><td class='pad7' style='vertical-align:middle; text-align:left;'><span class='header'><img src='".$sm_btns_dir.$img."'  class='btn'>".$text."</span></td></tr></table>";
	}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- get clients name
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_get_client_name')){function SM_get_client_name($usercode){
	$result=mysql_query("SELECT first, last FROM skedmaker_clients WHERE usercode='$usercode' LIMIT 1");
	while($row = mysql_fetch_array($result)) {
		$username=SM_d($row['username']);
	}
	return $username;
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- get clients email
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_get_client_email')){function SM_get_client_email($usercode){
	$result=mysql_query("SELECT email FROM skedmaker_clients WHERE usercode='$usercode' LIMIT 1");
	while($row = mysql_fetch_array($result)) {$email=SM_d($row['email']);}
	return $email;
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- check if its a valid email
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_check_client_email')){function SM_check_client_email($usercode){
	$result=mysql_query("SELECT email FROM skedmaker_clients WHERE usercode='$usercode' LIMIT 1");
	while($row = mysql_fetch_array($result)) {$email=SM_d($row['email']);}
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){$email="<span class='smallRed'>".$email."</span>";}
	return $email;

}}

//------- EMAIL already registered in users table
// ??????? database connection available for this??
if(!function_exists('SM_emailNewTaken')){function SM_emailNewTaken($newemail){
	if(!get_magic_quotes_gpc()){$newemail=addslashes($newemail);}
	$q = "SELECT adminemail FROM skedmaker_users WHERE adminemail='$newemail' AND deleted='' LIMIT 1";
	$result = mysql_query($q);
	return (mysql_numrows($result) > 0);
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Build the setting for an individual day -- DEFAULT DAYS
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_day_settings')){function SM_day_settings($weekday, $error_weekday_Open, $error_weekday_Break, $error_weekday_Return, $error_weekday_Close, $errorMessage, $error_length_open, $error_length_close){
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
	$posted_weekday=$_POST['this_weekday'];
	if ($_SERVER['REQUEST_METHOD']=='POST' && $posted_weekday==$weekday){
		$weekday_live=$_POST[$posted_weekday.'_live'];
		$weekday_increment=$_POST[$posted_weekday.'_increment'];
		$weekday_multiple=$_POST[$posted_weekday.'_multiple'];
		$weekday_openhour=$_POST[$posted_weekday.'_openhour'];
		$weekday_openminute=$_POST[$posted_weekday.'_openminute'];
		$weekday_breakhour=$_POST[$posted_weekday.'_breakhour'];
		$weekday_breakminute=$_POST[$posted_weekday.'_breakminute'];
		$weekday_returnhour=$_POST[$posted_weekday.'_returnhour'];
		$weekday_returnminute=$_POST[$posted_weekday.'_returnminute'];
		$weekday_closehour=$_POST[$posted_weekday.'_closehour'];
		$weekday_closeminute=$_POST[$posted_weekday.'_closeminute'];
	}else{
		$result=mysql_query("SELECT * FROM skedmaker_users");
		while($row=mysql_fetch_array($result)){
			$weekday_live=$row[$weekday.'live'];
			$weekday_increment=$row[$weekday.'increment'];
			$weekday_multiple=SM_d($row[$weekday.'multiple']);
			$weekday_openhour=$row[$weekday.'openhour'];
			$weekday_openminute=$row[$weekday.'openminute'];
			$weekday_breakhour=$row[$weekday.'breakhour'];
			$weekday_breakminute=$row[$weekday.'breakminute'];
			$weekday_returnhour=$row[$weekday.'returnhour'];
			$weekday_returnminute=$row[$weekday.'returnminute'];
			$weekday_closehour=$row[$weekday.'closehour'];
			$weekday_closeminute=$row[$weekday.'closeminute'];
		}
	}
	?>
<a name="<?php echo $weekday; ?>"></a>
<?php if($errorMessage!="" && $weekday==$posted_weekday){ echo "<br>"; SM_redBox("There was an error saving ".ucwords($posted_weekday).".<br><span style='font-size:16px'>Please correct the settings marked in red.</span>", "100%", 21);} echo "<br>";?>
<br />
<form enctype="multipart/form-data" id="form1" name="form1" method="post" action="?page=skedmaker-online-scheduling/admin_home.php&amp;v=default&amp;op=set<?php echo $weekday;?>&amp;#<?php echo $weekday;?>">
<table class='cc800'><tr><td class='blueBanner1' style='padding:0px;'>
<input type="hidden" name="this_weekday" value="<?php echo $weekday; ?>" />
<table class='cc100'>
<tr><td class='blueBanner1'>
<a href='#top' class='sked' style='float:right; color:#ccc;'><span class='smallG'>^ Top</span></a>
<?php echo ucwords($weekday);?>

</td></tr></table>
</td></tr></table>

<table class='cc800'><tr><td class='blueBanner2'>
<?php 
if($weekday_live=='y'){
	echo "<table style='float:left; border-collapse:collapse;'>";
	echo "<tr><td style='width:30px; padding:0px; vertical-align:middle'><img src='".$sm_btns_dir."check_green.png' alt='Active'></td>";
	echo "<td style='padding:0px; vertical-align:middle'><span class='greenText'>This day is currently activated</span></td>";
	echo "</tr></table>";
}else{
	echo "<table style='float:left;  border-collapse:collapse;'>";
	echo "<tr><td style='width:30px; padding:0px; vertical-align:middle'><img src='".$sm_btns_dir."btn_remove16_reg.png' alt='Not Active'></td>";
	echo "<td style='padding:0px; vertical-align:middle'><span class='redText'>This day is currently deactivated</span></td>";
	echo "</tr></table>";
}?>

<table class='cc100'>
<tr><td class='pad5' colspan='2'>Select from the options to customize the hours of operation for <?php echo ucwords($weekday);?>.</td></tr>
<tr><td class='label200'>Activate:</td>
<td class='pad7'><input name="<?php echo $weekday;?>_live" type="checkbox" id="<?php echo $weekday;?>_live" value="y" <?php if ($weekday_live=="y") {echo "checked='checked'"; }?>/>
<label for="<?php echo $weekday;?>_live">Check to allow appointments on <?php echo ucwords($weekday);?>.</label></td>
</tr>

<tr><td class='label200'>Length of Appointments:</b></td>
<td class='pad7'><select name="<?php echo $weekday;?>_increment" id="<?php echo $weekday;?>_increment" class='form_select'><?php SM_increment($weekday_increment);?></select></td>
</tr>
<?php if($error_length_open=="y" || $error_length_closed=="y"){?>
<tr><td class='label200'>&nbsp;</td>
<td class='pad7'><span class='redText'>Length and minutes are not valid.</td>
</tr>
<?php } ?>

<tr><td class='label200'>Multiple Appointments:</td>
<td class='pad7'><select name="<?php echo $weekday;?>_multiple" id="<?php echo $weekday;?>_multiple" class='form_select'><?php SM_multiple($weekday_multiple); ?></select> per timeframe</td>
</tr>

<tr><td class='label200'><?php SM_check_text("First Appointment:", $error_weekday_Open);?></td>
<td class='pad7'><select name="<?php echo $weekday;?>_openhour" id="<?php echo $weekday;?>_openhour" class='form_select'><?php SM_hours($weekday_openhour,0);?></select>
<select name="<?php echo $weekday;?>_openminute" id="<?php echo $weekday;?>_openminute" class='form_select'><?php SM_minutes($weekday_openminute,0);?></select></td>

<?php if($error_length_open=="y"){?>
<tr><td class='label200'>&nbsp;</td>
<td class='pad7'><span class='redText'>Length and minutes are not valid.</td>
</tr>
<?php } ?>
</tr>

<tr><td class='label200'><?php SM_check_text("Break Starts:", $error_weekday_Break);?></td>
<td class='pad7'><select name="<?php echo $weekday;?>_breakhour" id="<?php echo $weekday;?>_breakhour" class='form_select'><?php SM_hours($weekday_breakhour,1);?></select>
<select name="<?php echo $weekday;?>_breakminute" id="<?php echo $weekday;?>_breakminute" class='form_select'><?php SM_minutes($weekday_breakminute,1);?></select></td>
</tr>

<tr><td class='label200'><?php SM_check_text("Break Ends:", $error_weekday_Return);?></td>
<td class='pad7'><select name="<?php echo $weekday;?>_returnhour" id="<?php echo $weekday;?>_returnhour" class='form_select'><?php SM_hours($weekday_returnhour,1);?></select>
<select name="<?php echo $weekday;?>_returnminute" id="<?php echo $weekday;?>_returnminute" class='form_select'><?php SM_minutes($weekday_returnminute,1);?></select></td>
</tr>

<tr><td class='label200'><?php SM_check_text("Last Appointment:", $error_weekday_Close);?></td>
<td class='pad7'><select name="<?php echo $weekday;?>_closehour" id="<?php echo $weekday;?>_closehour" class='form_select'><?php SM_hours($weekday_closehour,0);?></select>
<select name="<?php echo $weekday;?>_closeminute" id="<?php echo $weekday;?>_closeminute" class='form_select'><?php SM_minutes($weekday_closeminute,0);?></select></td>
</tr>
<?php if($error_length_closed=="y"){?>
<tr><td class='label200'>&nbsp;</td>
<td class='pad7'><span class='redText'>Length and minutes are not valid.</td>
</tr>
<?php } ?>

<tr><td class='label200'><td class='pad7'><input type="submit" name="button" id="button" value="Save Changes to <?php echo ucwords($weekday);?>" /></td></tr>
</table>
</td></tr></table>
</form>
<?php }}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Check text
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_check_text')){function SM_check_text($text, $check){if($check=='y'){echo "<span class='redText'>".$text."</span>";}else{echo "<b>".$text."</b>";}}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- check text small
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_check_text_small')){function SM_check_text_small($text, $check){if($check=='y'){echo "<span class='smallRed'>".$text."</span>";}else{echo "<span class='smallText'>".$text."</span>";}}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- MESSAGE/NOTICE BOXES
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_redBox')){function SM_redBox($msg, $width,$redBoxFontSize){	
	if(wp_is_mobile() || $width=="100%"){$width="100%";}else{$width=$width."px";}
	echo "<table style='width:".$width."; margin:0px; border:0px; max-width:800px; border-collapse:separate;'><tr><td class='redBox' style='text-align:center; -moz-border-radius:7px !important; -webkit-border-radius:7px !important; border-radius:7px !important; overflow:hidden !important;'><span class='redText' style='font-size:".$redBoxFontSize."px;'>".$msg."</span></td></tr></table>";
}}

if(!function_exists('SM_greenBox')){function SM_greenBox($msg, $width, $font_size){
	if(wp_is_mobile() || $width=="100%"){$width="100%";}else{$width=$width."px";}
	echo "<table style='width:".$width."; margin:0px; border:0px; max-width:800px; border-collapse:separate;'><tr><td class='greenBox' style='text-align:center; -moz-border-radius:7px !important; -webkit-border-radius:7px !important; border-radius:7px !important; overflow:hidden !important;'><span class='greenText' style='font-size:".$font_size."px;'>".$msg."</span></td></tr></table>";
}}

if(!function_exists('SM_blueBox')){function SM_blueBox($msg, $width, $fontSize){
	if(wp_is_mobile() || $width=="100%"){$width="100%";}else{$width=$width."px";}
	echo "<table style='width:".$width."; margin:0px; border:0px; max-width:800px; padding:0px; border-collapse:separate;'><tr><td class='blueBox' style='padding:0px;'><span style='font-size:".$fontSize."px; font-weight:bold; color:#06F;'>".$msg."</span></td></tr></table>";
}}

if(!function_exists('SM_orangeBox')){function SM_orangeBox($msg, $width, $fontSize){	
	if(wp_is_mobile() || $width=="100%"){$width="100%";}else{$width=$width."px";}
	echo "<table style='width:".$width."; margin:0px; border:0px; max-width:800px; border-collapse:separate;'><tr><td class='orangeBox' align='center'><span style='font-size:".$fontSize."px'>".$msg."</span></td></tr></table>";
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- show the time
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_showTime')){function SM_showTime($hour, $minute){
	if($hour>12){$displayHour=$hour-12; $ampm="p.m.";}else{$displayHour=$hour; $ampm="a.m.";}
	if($hour==00){$displayHour=12; $ampm="am";}
	if($hour==12){$displayHour=12; $ampm="pm";}
	$finaltime=$displayHour.":".$minute." ".$ampm;
	return $finaltime;
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Select hours
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_hours')){function SM_hours($hourvar, $its_a_break){
	if($its_a_break==1){
		echo "<option value=''>No Break</option>";
	}else{
		echo "<option value=''>Hour...</option>";
	} ?>
	<option  value='00'<?php if($hourvar=='00'){?> selected="selected"<?php } ?>>12 midnight</option>
	<option  value='01'<?php if($hourvar=='01'){?> selected="selected"<?php } ?>>1 a.m.</option>
	<option  value='02'<?php if($hourvar=='02'){?> selected="selected"<?php } ?>>2 a.m.</option>
	<option  value='03'<?php if($hourvar=='03'){?> selected="selected"<?php } ?>>3 a.m.</option>
	<option  value='04'<?php if($hourvar=='04'){?> selected="selected"<?php } ?>>4 a.m.</option>
	<option  value='05'<?php if($hourvar=='05'){?> selected="selected"<?php } ?>>5 a.m.</option>
	<option  value='06'<?php if($hourvar=='06'){?> selected="selected"<?php } ?>>6 a.m.</option>
	<option  value='07'<?php if($hourvar=='07'){?> selected="selected"<?php } ?>>7 a.m.</option>
	<option  value='08'<?php if($hourvar=='08'){?> selected="selected"<?php } ?>>8 a.m.</option>
	<option  value='09'<?php if($hourvar=='09'){?> selected="selected"<?php } ?>>9 a.m.</option>
	<option  value='10'<?php if($hourvar=='10'){?> selected="selected"<?php } ?>>10 a.m.</option>
	<option  value='11'<?php if($hourvar=='11'){?> selected="selected"<?php } ?>>11 a.m.</option>
	<option  value='12'<?php if($hourvar=='12'){?> selected="selected"<?php } ?>>12 noon</option>
	<option  value='13'<?php if($hourvar=='13'){?> selected="selected"<?php } ?>>1 p.m.</option>
	<option  value='14'<?php if($hourvar=='14'){?> selected="selected"<?php } ?>>2 p.m.</option>
	<option  value='15'<?php if($hourvar=='15'){?> selected="selected"<?php } ?>>3 p.m.</option>
	<option  value='16'<?php if($hourvar=='16'){?> selected="selected"<?php } ?>>4 p.m.</option>
	<option  value='17'<?php if($hourvar=='17'){?> selected="selected"<?php } ?>>5 p.m.</option>
	<option  value='18'<?php if($hourvar=='18'){?> selected="selected"<?php } ?>>6 p.m.</option>
	<option  value='19'<?php if($hourvar=='19'){?> selected="selected"<?php } ?>>7 p.m.</option>
	<option  value='20'<?php if($hourvar=='20'){?> selected="selected"<?php } ?>>8 p.m.</option>
	<option  value='21'<?php if($hourvar=='21'){?> selected="selected"<?php } ?>>9 p.m.</option>
	<option  value='22'<?php if($hourvar=='22'){?> selected="selected"<?php } ?>>10 p.m.</option>
	<option  value='23'<?php if($hourvar=='23'){?> selected="selected"<?php } ?>>11 p.m.</option>
<?php }}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Select Minutes
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_minutes')){function SM_minutes($minutevar, $its_a_break){
	if($its_a_break==1){ ?>
		<option value=''>No Break</option>
	<?php }else{ ?>
		<option value=''>Minute...</option>
	<?php } ?>
	<option <?php if($minutevar=="00"){ ?>selected="selected" <?php } ?>>00</option>
	<option <?php if($minutevar=="15"){ ?>selected="selected" <?php } ?>>15</option>
	<option <?php if($minutevar=="30"){ ?>selected="selected" <?php } ?>>30</option>
	<option <?php if($minutevar=="45"){ ?>selected="selected" <?php } ?>>45</option>
<?php }}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Schedule increment
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_increment')){function SM_increment($incrementvar){
	echo "<option value=''>Select...</option>";
	echo "<option value='quarter'"; if($incrementvar=="quarter"){print "selected=\"selected\"";} echo">Quarter Hour</option>";
	echo "<option value='halfhour'"; if($incrementvar=="halfhour"){print "selected=\"selected\"";} echo">Half Hour</option>";
	echo "<option value='hour'"; if($incrementvar=="hour"){print "selected=\"selected\"";} echo">1 Hour</option>";
	for($inc=2; $inc<25; $inc++){ 
		echo "<option value='"; echo $inc."hours'"; if($incrementvar==$inc."hours"){print "selected=\"selected\"";} echo ">".$inc." Hours</option>";
	}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Schedule Multiple
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_multiple')){function SM_multiple($multiple){
	for($x=1; $x<100; $x++){ ?>
		<option value='<?php echo $x;?>' <?php if($multiple==$x){ ?>selected="selected" <?php } ?> ><?php echo $x; ?></option>
    <?php 
	}
}}

//======= GETS WEEKDAY AS Text RETURNS number
if(!function_exists('SM_weekdayNum')){function SM_weekdayNum($weekday){
	if($weekday=="Sunday"){$weekdayNum="1";}
	if($weekday=="Monday"){$weekdayNum="2";}
	if($weekday=="Tuesday"){$weekdayNum="3";}
	if($weekday=="Wednesday"){$weekdayNum="4";}
	if($weekday=="Thursday"){$weekdayNum="5";}
	if($weekday=="Friday"){$weekdayNum="6";}
	if($weekday=="Saturday"){$weekdayNum="7";}
	return $weekdayNum;
}}

//======= REDIRECT TO A PAGE FUNCTION
if(!function_exists('SM_redirect')){function SM_redirect($goto, $wait){
	echo "<script language='javascript'>
			function direct(){
			   window.location='".$goto."';
			   }
			   setTimeout( 'direct();', ".$wait.");
				</script>";
}}

//======= GETS MONTH AS NUMBER RETURNS TEXT
if(!function_exists('SM_displayMonth')){function SM_displayMonth($month){
	if($month=="1"){$displayMonth="January";}
	if($month=="2"){$displayMonth="February";}
	if($month=="3"){$displayMonth="March";}
	if($month=="4"){$displayMonth="April";}
	if($month=="5"){$displayMonth="May";}
	if($month=="6"){$displayMonth="June";}
	if($month=="7"){$displayMonth="July";}
	if($month=="8"){$displayMonth="August";}
	if($month=="9"){$displayMonth="September";}
	if($month=="10"){$displayMonth="October";}
	if($month=="11"){$displayMonth="November";}
	if($month=="12"){$displayMonth="December";}
	return $displayMonth;	
}}

//======= GETS WEEKDAY AS NUMBER RETURNS TEXT
if(!function_exists('SM_displayWeekday')){function SM_displayWeekday($weekday){
	if($weekday=="1"){$displayWeekday="Sunday"; $DBweekday='sunday';}
	if($weekday=="2"){$displayWeekday="Monday"; $DBweekday='monday';}
	if($weekday=="3"){$displayWeekday="Tuesday"; $DBweekday='tuesday';}
	if($weekday=="4"){$displayWeekday="Wednesday"; $DBweekday='wednesday';}
	if($weekday=="5"){$displayWeekday="Thursday"; $DBweekday='thursday';}
	if($weekday=="6"){$displayWeekday="Friday"; $DBweekday='friday';}
	if($weekday=="7"){$displayWeekday="Saturday"; $DBweekday='saturday';}
	return $displayWeekday;
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Create a generic code
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_code')){function SM_code(){
	$codedate=date('Ymd');
	$len=10;
	$base='BCDFGHJKLMNPRSTVWXYZ';
	$max=strlen($base)-1;
	$code='';
	mt_srand((double)microtime()*1000000);
	while (strlen($code)<$len+1)
		$code.=$base{mt_rand(0,$max)
	};
	$DBcode=$codedate.$code;
	return $DBcode;
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Print Button for top of calendar
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_printBtnR')){function SM_printBtnR(){
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
echo	"<a href='#' onClick='window.print();' title='Print' class='sked'><img src='".$sm_btns_dir."btn_print16_reg.png' style='border:0px; margin-right:7px;'></a>";
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Log out button for top of calendar
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_logoutBtnR')){function SM_logoutBtnR(){
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
	$loginValidClient=$_SESSION['loginValidClient'];
	if($loginValidClient=="y"){
		echo	"<a href='".SM_permalink()."&amp;op=logout&amp;#skedtop' title='Log Out' class='sked'><img src='".$sm_btns_dir."btn_logout16_reg.png' style='border:0px; margin-right:7px;'></a>";
	}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- My Account button for top of calendar
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_myaccountBtnR')){function SM_myaccountBtnR(){
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
	$loginValidClient=$_SESSION['loginValidClient'];
	$uname=$_SESSION['username'];	

	if($loginValidClient=="y"){
		$uname=$_SESSION['username'];
		echo "<a href='".SM_permalink()."&amp;op=myaccount&amp;#skedtop' title='My Account Info'  class='sked' style='vertical-align:textmiddle;'>";
//		echo "<span style='font-size:12px; font-weight:normal; color:#ccc; margin-right:14px;'>logged in as: ".$uname." </span>";
		echo "<img src='".$sm_btns_dir."btn_myaccount16_reg.png' style='border:0px; margin-right:7px;'></a>";
	}else{
		// echo "no";
	}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- When is my appointment button for top of calendar
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_whenBtnR')){function SM_whenBtnR(){
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
echo	"<a href='".SM_permalink()."&amp;op=when&amp;#skedtop' title='When is my appointment?'  class='sked' ><img src='".$sm_btns_dir."btn_chair16_reg.png' style='border:0px; margin-right:7px;'></a>";
}}


//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Create Calendar  
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_create_calendar')){function SM_create_calendar($isAdmin){
global $smadmin; global $b1_color; global $loginValid;
$ts=$_GET['ts']; // if there is a ts variable in the URL get it
if($_GET['uc']!=""){$ucURL="&amp;uc=".$_GET['uc'];}else{$ucURL="";}

if($_GET['v']!=""){$admin_view="&amp;v=home&amp;";}

if($ts){
	$month=date('m', $ts); // get the month
	$year=date('Y', $ts); // get the year
}

if($isAdmin=='y'){$this_CAL_page=$smadmin;}else{$this_CAL_page=SM_permalink();}

if($month=="" || $month=="00"){$month=date('m');}
if($year=="" || $year=="00"){$year=date('Y');}

//------- This puts the day, month, and year in seperate variables
$day = date('d');

$first_day = mktime(0,0,0,$month, 1, $year); //generate the first day of the month  

$title=date('F', $first_day); //get the month name

$dayLimit=date('d');
$monthLimit=date('m');
$yearLimit=date('Y');

$day_of_week = date('D', $first_day) ; // Get day of the week for first day of the month
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
$days_in_month = cal_days_in_month(0, $month, $year); // how many days are in the current month 

//////////////////////////////////////////////////////////////////////////////////////////////////
// ======= Start building the calendar
//////////////////////////////////////////////////////////////////////////////////////////////////
echo "<table class='cc100'><tr><td class='nopad'>";
echo "<table class='cc100'><tr><td class='blueBanner1'>";

echo "<table class='cc100'><tr>";
echo "<td class='nopadb1' style='width:80%'><span style='color:#fff; font-size:18px;'>".$title." ".$year."</span></td>";
if($isAdmin!="y"){

	echo "<td class='nopadb1' style='width:5%; text-align:left;'>"; SM_myaccountBtnR(); echo "</td>";
	echo "<td class='nopadb1' style='width:5%'>"; SM_whenBtnR(); echo "</td>";
	echo "<td class='nopadb1' style='width:5%'>"; SM_printBtnR(); echo "</td>";
	echo "<td class='nopadb1' style='width:5%'>"; SM_logoutBtnR(); echo "</td>";
	
}
echo "</tr></table>";

echo "</td></tr>"; 

//======= CREATE THE MONTHS MENU
echo "<tr><td colspan='7' class='blueBanner1Square'>";

$currentMonth=date('n');
$checkMonth=date('m');
$stopMonth=$currentMonth+11;
if($stopMonth>=12){$stopMonth=12;}
echo "<table class='cc100' style='border-spacing:1px; border-collapse:separate;'><tr>";

// -- THIS YEAR
$year_MenuMonths=date('Y');
for($num=$currentMonth;$num<=$stopMonth;$num++){
	if($num<10){
		$month_MenuMonths="0".$num;
	}else{
		$month_MenuMonths=$num;
	}
	$displayMonth=SM_displayMonth($month_MenuMonths);

	if(wp_is_mobile()){$showMonth=substr($displayMonth, 0, 1);}else{$showMonth=substr($displayMonth, 0, 3);}

	$toGetWeekday=$year_MenuMonths."/".$month_MenuMonths."/01";
	$getTheWeekday=date('l', strtotime($toGetWeekday));
	$finalWeekday=SM_weekdayNum($getTheWeekday);

	$ts=SM_timestamp($year_MenuMonths.$month_MenuMonths."01");
	$titleString="Go to ".$displayMonth." ".$year_MenuMonths;

	$result=mysql_query("SELECT * FROM skedmaker_custom_sked WHERE year='$year_MenuMonths' AND month='$month_MenuMonths' AND day='01'");
	while($row = mysql_fetch_array($result)) {$datecode_MenuMonths=SM_d($row['datecode']);}
	if($datecode_MenuMonths!=""){$datecode_to_Pass="&amp;dc=".$datecode_MenuMonths;}else{$datecode_to_Pass="&amp;";}

	echo "<td class='g666'><div class='nav666'><a href='".$this_CAL_page."&amp;ts=$ts".$datecode_to_Pass.$ucURL.$admin_view."&amp;#skedtop' class='calMonths' title='".$titleString."'>".$showMonth."</a></div></td>";
}

// -- NEXT YEAR 
$year_MenuMonths=$year_MenuMonths+1;
$stopMonth=date('m')-1;
for($num=1;$num<=$stopMonth;$num++){
	if($num<10){
	$month_MenuMonths="0".$num;
	}else{
		$month_MenuMonths=$num;
	}
	$displayMonth=SM_displayMonth($month_MenuMonths);
	
	if(wp_is_mobile()){$showMonth=substr($displayMonth, 0, 1);}else{$showMonth=substr($displayMonth, 0, 3);}
	
	$toGetWeekday=$year_MenuMonths."/".$month_MenuMonths."/01";
	$getTheWeekday=date('l', strtotime($toGetWeekday));
	$finalWeekday=SM_weekdayNum($getTheWeekday);

	$ts=SM_timestamp($year_MenuMonths.$month_MenuMonths."01");

	$result=mysql_query("SELECT * FROM skedmaker_custom_sked WHERE year='$year_MenuMonths' AND month='$month_MenuMonths' AND day='01'");
	while($row = mysql_fetch_array($result)) {$datecode_MenuMonths=SM_d($row['datecode']);}
	if($datecode_MenuMonths!=""){$datecode_to_Pass="&amp;dc=".$datecode_MenuMonths;}else{$datecode_to_Pass="";}

	$titleString="Go to ".$displayMonth." ".$year_MenuMonths;

	echo "<td class='g666'><div class='nav666'><a href='".$this_CAL_page."&amp;ts=$ts".$datecode_to_Pass.$ucURL.$admin_view."&amp;#skedtop' class='calMonths' title='".$titleString."'>".$showMonth."</a></div></td>";
}
echo "</td></tr></table>";  // months menu ends

echo "</td></tr>";
echo "</table>";

echo "<table class='cc100' style='border-collapse:collapse; margin:0px;>";
//------- show weekdays on column headers
echo "<tr style='background-color:#ccc;'>
<td class='weekday' style='border:none; border-left:1px solid #666;'>Sun</td>
<td class='weekday' style='border:none;'>Mon</td>
<td class='weekday' style='border:none;'>Tue</td>
<td class='weekday' style='border:none;'>Wed</td>
<td class='weekday' style='border:none;'>Thu</td>
<td class='weekday' style='border:none;'>Fri</td>
<td class='weekday' style='border:none; border-right:1px solid #666;'>Sat</td>
</tr>";

//echo "</table>";
//echo "<table class='cc100' style='border-collapse:collapse; margin:0px;'>";

//------- count the days in the week, up to 7 
$day_count = 1;  
echo "<tr>"; 
//------- take care of blank days
while ($blank>0){
	echo "<td class='calendarBlank' style='padding:0px;'>&nbsp;</td>";  
	$blank = $blank-1;
	$day_count++;
}

//------- set first day of the month to 1
$day_num = 1;
//------- count up the days, untill done them all in the month 
while($day_num <= $days_in_month){
	if($day_num<10){
		$day_num="0".$day_num;
	}

	//======= CHECK IF ITS A CUSTOM DAY	
	$check_custom=$year."-".$month."-".$day_num;
	$result=mysql_query("SELECT * FROM skedmaker_custom_sked WHERE date='$check_custom'");
	while($row=mysql_fetch_array($result)){$datecode_Calendar=SM_d($row['datecode']); $dc_name_for_cal_rollover=SM_d($row['name']);}
	if($datecode_Calendar!=""){$datecode_to_Pass="&amp;dc=".$datecode_Calendar; $found_custom="y";}else{$datecode_to_Pass=""; $found_custom="";}

	$countIt=mysql_query("SELECT * FROM skedmaker_custom_sked WHERE date='$check_custom'");
	$total_custom_found=mysql_num_rows($countIt);
	if($total_custom_found>0){$found_custom="y";}else{$found_custom="n";}

	//======= CHECK IF ITS A BLOCKED DAY
	$checkBlocked=SM_timestamp($year.$month.$day_num);
	$countIt=mysql_query("SELECT * FROM skedmaker_blockeddates WHERE timestamp='$checkBlocked'");
	$totalBlocked=mysql_num_rows($countIt);
	if($totalBlocked>0){$foundBlocked='y';}else{$foundBlocked='n';}

	$tsURL=SM_timestamp($year.$month.$day_num); // convert to timestamp to pass through URL

	$result=mysql_query("SELECT * FROM skedmaker_users");
	while($row=mysql_fetch_array($result)){
		$sundaylive=$row['sundaylive'];	
		$mondaylive=$row['mondaylive'];	
		$tuesdaylive=$row['tuesdaylive'];	
		$wednesdaylive=$row['wednesdaylive'];	
		$thursdaylive=$row['thursdaylive'];	
		$fridaylive=$row['fridaylive'];	
		$saturdaylive=$row['saturdaylive'];	
	}

	$countIt=mysql_query("SELECT * FROM skedmaker_blackouts WHERE start_date<='$tsURL' && end_date>='$tsURL' LIMIT 1");	
	$total_in_range=mysql_num_rows($countIt);
	
	if($total_in_range>0 && $loginValid=="admin"){
		$calClass="calendarBlocked"; $calDiv="<div class='navBlackouts'>"; 
		$calLink="<a href ='".$this_CAL_page."&amp;op=sked&amp;ts=".$tsURL."&amp;".$datecode_to_Pass."&amp;' title='Inside Blackout Range'>";
		$calDivClose="</div>";
	}else if($month==$monthLimit && $day_num<$dayLimit){
		$calClass="calendarPassed"; $calDiv=""; $calLink=""; $calDivClose="";
	
	}else if($total_custom_found>0 && $loginValid=='admin'){
		$test=2;
		$calClass="calendarDay";
		$calDiv="<div class='navCustom'>";
		$calLink="<a href ='".$this_CAL_page."&amp;op=sked&amp;ts=".$tsURL."&amp;".$datecode_to_Pass."&amp;#skedtop' title='Set to Custom: ".$dc_name_for_cal_rollover."'>";
		$calDivClose="</a></div>";

	}else if($total_custom_found>0 && $loginValid!='admin'){
		$test="2b";
		$calClass="calendarDay";
		$calDiv="<div class='navDay'>";
		$calLink="<a href ='".$this_CAL_page."&amp;op=sked&amp;ts=".$tsURL."&amp;".$datecode_to_Pass."&amp;#skedtop' class='calDayActive' title='".$titleDisplay."'>";
		$calDivClose="</a></div>";
	}else if($foundBlocked=='y' && $loginValid=='admin'){
		$test=4;
		$calClass="calendarBlocked";
		$calDiv="<div class='navBlocked'>";
		$calLink="<a href ='".$this_CAL_page."&amp;op=sked&amp;ts=".$tsURL."&amp;".$datecode_to_Pass."&amp;#skedtop' title='This Day is Blocked'>";
		$calDivClose="</a></div>";
	}else if(($foundBlocked=='y' || $total_in_range>0) && $loginValid!='admin'){
		$calClass="calendarBlank"; $calDiv=""; $calLink=""; $calDivClose="";
		$test=5;
	}else if($loginValid=='admin'){
		//======= deactivated days 
		$calLink="<a href ='".$this_CAL_page."&amp;op=sked&amp;ts=".$tsURL."&amp;".$datecode_to_Pass."&amp;#skedtop' title='".$titleDisplay."'>";
		$calDivClose="</a></div>";
		if(
			($day_count==1 && $sundaylive!="y") || 
			($day_count==2 && $mondaylive!="y") || 
			($day_count==3 && $tuesdaylive!="y") || 
			($day_count==4 && $wednesdaylive!="y") || 
			($day_count==5 && $thursdaylive!="y") || 
			($day_count==6 && $fridaylive!="y") ||
			($day_count==7 && $saturdaylive!="y")
			){
				$calClass="calendarAdminBlank";
				$calDiv="<div class='navCalBlank'>";

		}else{
			$calClass="calendarDay";
			$calDiv="<div class='navDay'>";
		}

	}else{
		$test=3;
		if($day_count==1 && $sundaylive!="y"){				$calClass="calendarBlank"; $calDiv=""; $calLink=""; $calDivClose="";
		}else if($day_count==2 && $mondaylive!="y"){		$calClass="calendarBlank"; $calDiv=""; $calLink=""; $calDivClose="";
		}else if($day_count==3 && $tuesdaylive!="y" ){		$calClass="calendarBlank"; $calDiv=""; $calLink=""; $calDivClose="";
		}else if($day_count==4 && $wednesdaylive!="y"){		$calClass="calendarBlank"; $calDiv=""; $calLink=""; $calDivClose="";
		}else if($day_count==5 && $thursdaylive!="y"){		$calClass="calendarBlank"; $calDiv=""; $calLink=""; $calDivClose="";
		}else if($day_count==6 && $fridaylive!="y"){		$calClass="calendarBlank"; $calDiv=""; $calLink=""; $calDivClose="";
		}else if($day_count==7 && $saturdaylive!="y"){		$calClass="calendarBlank"; $calDiv=""; $calLink=""; $calDivClose="";

		}else{
			$calClass="calendarDay";
			$calDiv="<div class='navDay'>";
			$calLink="<a href ='".$this_CAL_page."&amp;op=sked&amp;ts=".$tsURL."&amp;#skedtop".$datecode_to_Pass."' class='calDayActive' title='".$titleDisplay."'>";
			$calDivClose="</a></div>";
			$test=7;
		}
	}
	$data="<td class='".$calClass."' style='text-align:center; vertical-align:middle;'>".$calDiv.$calLink."<span class='date'>".$day_num."</span>".$calDivClose."</td>";
	echo $data;
	$day_num++;  $day_count++;
	//start a new row every week 
	if ($day_count > 7) {echo "</tr><tr>"; $day_count = 1;}
}
echo "</tr></table>";
echo "</td></tr></table>"; // -- end 500px wide

echo "<a name='acal' id='acal'></a>";
echo "<br>";
}}


//==================================================================================================
//======= Create Blackout Calendar
//==================================================================================================
if(!function_exists('SM_create_blackout_cal')){function SM_create_blackout_cal($start_or_end){
global $smadmin; global $b1_color; global $loginValid;
$ts=$_GET['ts']; // if there is a ts variable in the URL get it

if($ts){
	$month=date('m', $ts); // get the month
	$year=date('Y', $ts); // get the year
}

if($_GET['v']!=""){$admin_view="&amp;v=blackouts&amp;";}

$this_CAL_page=$smadmin.$admin_view;

if($month=="" || $month=="00"){$month=date('m');}
if($year=="" || $year=="00"){$year=date('Y');}

//------- This puts the day, month, and year in seperate variables
$day = date('d');

$first_day = mktime(0,0,0,$month, 1, $year); //generate the first day of the month  

$title=date('F', $first_day); //get the month name

$dayLimit=date('d');
$monthLimit=date('m');
$yearLimit=date('Y');

$day_of_week = date('D', $first_day) ; // Get day of the week for first day of the month
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
$days_in_month = cal_days_in_month(0, $month, $year); // how many days are in the current month 

//////////////////////////////////////////////////////////////////////////////////////////////////
// ======= Start building the calendar
//////////////////////////////////////////////////////////////////////////////////////////////////
echo "<table style='width:500px; border-spacing:0; border-collapse:collapse; border:0px; margin:0px;'><tr><td class='nopad'>"; // restrict the table to 500 pixels wide
echo "<table class='cc100' style='margin:0px;'><tr><td class='blueBanner1'>";
echo $title." ".$year;
echo "</td></tr>"; 

//======= CREATE THE MONTHS MENU
echo "<tr><td colspan='7' class='menumonths'>";

$currentMonth=date('n');
$checkMonth=date('m');
$stopMonth=$currentMonth+11;
if($stopMonth>=12){$stopMonth=12;}

echo "<table style='margin:0px; width:100%; border:none; border-spacing:1px; border-collapse:separate;'><tr>";

// -- THIS YEAR
$year_MenuMonths=date('Y');
for($num=$currentMonth;$num<=$stopMonth;$num++){
	if($num<10){
		$month_MenuMonths="0".$num;
	}else{
		$month_MenuMonths=$num;
	}
	$displayMonth=SM_displayMonth($month_MenuMonths);
	$showMonth=substr($displayMonth, 0, 3);

	$toGetWeekday=$year_MenuMonths."/".$month_MenuMonths."/01";
	$getTheWeekday=date('l', strtotime($toGetWeekday));
	$finalWeekday=SM_weekdayNum($getTheWeekday);

	$ts=SM_timestamp($year_MenuMonths.$month_MenuMonths."01");
	$titleString="Go to ".$displayMonth." ".$year_MenuMonths;

	echo "<td class='g666'><div class='nav666'><a href='".$this_CAL_page."&amp;ts=$ts&amp;start=".$_GET['start']."&amp;end=".$_GET['end']."&amp;' title='".$titleString."'><span class='small'>".$showMonth."</span></a></div></td>";
}

// -- NEXT YEAR 
$year_MenuMonths=$year_MenuMonths+1;
$stopMonth=date('m')-1;
for($num=1;$num<=$stopMonth;$num++){
	if($num<10){
	$month_MenuMonths="0".$num;
	}else{
		$month_MenuMonths=$num;
	}
	$displayMonth=SM_displayMonth($month_MenuMonths);
	$showMonth=substr($displayMonth, 0, 3);
	
	$toGetWeekday=$year_MenuMonths."/".$month_MenuMonths."/01";
	$getTheWeekday=date('l', strtotime($toGetWeekday));
	$finalWeekday=SM_weekdayNum($getTheWeekday);
	
	$ts=SM_timestamp($year_MenuMonths.$month_MenuMonths."01");

	$titleString="Go to ".$displayMonth." ".$year_MenuMonths;

	echo "<td class='g666'><div class='nav666'><a href='".$this_CAL_page."&amp;ts=$ts&amp;start=".$_GET['start']."&amp;end=".$_GET['end']."&amp;' title='".$titleString."'><span class='small'>".$showMonth."</span></a></div></td>";
}
echo "</td></tr></table>";  // months menu ends

echo "</td></tr>";
echo "</table>";

echo "<table class='cc100' style='border:none;'>";
//------- show weekdays on column headers
echo "<tr class='gBox' style='background-color:#ccc;'>
<td class='weekday' style='border:none; border-left:1px solid #666;'>Sun</td>
<td class='weekday' style='border:none;'>Mon</td>
<td class='weekday' style='border:none;'>Tue</td>
<td class='weekday' style='border:none;'>Wed</td>
<td class='weekday' style='border:none;'>Thu</td>
<td class='weekday' style='border:none;'>Fri</td>
<td class='weekday' style='border:none; border-right:1px solid #666;'>Sat</td>
</tr>";
echo "</table>";
echo "<table class='cc100' style='border-collapse:collapse; margin:0px;'>";
//------- count the days in the week, up to 7 
$day_count = 1;  
echo "<tr>"; 
//------- take care of blank days
while ($blank>0){
	echo "<td class='calendarBlank' style='padding:0px;'>&nbsp;</td>";  
	$blank = $blank-1;
	$day_count++;
}

//------- set first day of the month to 1
$day_num = 1;
//------- count up the days, untill done them all in the month 
while($day_num <= $days_in_month){
	if($day_num<10){
		$day_num="0".$day_num;
	}

	$tsURL=SM_timestamp($year.$month.$day_num); // convert to timestamp to pass through URL

	if($start_or_end=="start"){$SE="&amp;start=".$tsURL;}else{$SE="&amp;start=".$_GET['start']."&amp;end=".$tsURL;}

	$countIt=mysql_query("SELECT * FROM skedmaker_blackouts WHERE start_date<='$tsURL' && end_date>='$tsURL' LIMIT 1");	
	$total_in_range=mysql_num_rows($countIt);

	if($total_in_range>0){
		$calClass="calendarBlockedBlackouts"; $calDiv=""; $calLink=""; $calDivClose="";
	}else if($_GET['start']==$tsURL){
		$calClass="calendarBlockedBlackouts"; $calDiv=""; $calLink=""; $calDivClose="";		
	}else if($month==$monthLimit && $day_num<$dayLimit){
		$calClass="calendarPassed"; $calDiv=""; $calLink=""; $calDivClose="";
	}else if($loginValid=='admin'){
		//======= deactivated days 
		$calLink="<a href ='".$this_CAL_page."&amp;op=sked&amp;ts=".$tsURL."&amp;".$SE."&amp;' title='".$titleDisplay."'>";
		$calDivClose="</a></div>";
			$calClass="calendarDay";
			$calDiv="<div class='navDay'>";
	}
	$data="<td class='".$calClass."' style='text-align:center; vertical-align:middle;'>".$calDiv.$calLink."<span class='date'>".$day_num."</span>".$calDivClose."</td>";
	echo $data;
	$day_num++;  $day_count++;
	//start a new row every week 
	if ($day_count > 7) {echo "</tr><tr>"; $day_count = 1;}
}
echo "</tr></table>";
echo "</td></tr></table>"; // -- end 500px wide

echo "<br>";
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
// ======= create_day: Creates the day under the calendar and then starts to populate the list of times
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_create_day')){function SM_create_day(){
	global $smadmin;
	global $loginValid;
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
	include(plugin_dir_path( __FILE__ ) . "sm-settings.php");
	$ts=$_GET['ts']; //  timestamp

	if($_GET['ts']==""){
		$year=date("Y");
		$month=date("m");
		$day=date("d");
		$thisDay=date('d');
		$ts=SM_timestamp($year.$month.$day."00:00.00");
		$DBweekday=strtolower(date("l")); 
	}else{
		$year=date('Y', $ts);
		$month=date('m', $ts);
		$day=date('d', $ts);
		$weekday=date('l', $ts);
		$thisDay=date('d', $ts);
		$selected=date('d', $ts);
		$DBweekday=strtolower(date("l", $_GET['ts'])); 
	}

//======= CHECK IF ITS A BLOCKED DAY
$checkBlocked=SM_timestamp($year.$month.$day."00:00.00");
$countIt=mysql_query("SELECT * FROM skedmaker_blockeddates WHERE timestamp='$checkBlocked' LIMIT 1");
$totalBlocked=mysql_num_rows($countIt);
if($totalBlocked>0){$foundBlocked='y';}else{$foundBlocked='n';}

//======= BLACKOUTS?
$countIt=mysql_query("SELECT * FROM skedmaker_blackouts WHERE start_date<='$checkBlocked' AND end_date>='$checkBlocked' Limit 1") or die(mysql_error());
$total_blackouts=mysql_num_rows($countIt);
if($total_blackouts>0){$blackedout='y';}

$check_date=SM_timestamp(date("Y-m-d 00:00.00"));
if($checkBlocked==$check_date && $allowsameday!='y'){$sameDay='n';}else{$sameDay='y';}

//======= CHECK IF ITS A PASSED DAY
if($check_date>$checkBlocked){$date_passed='y';}else{$date_passed='n';}

$result=mysql_query("SELECT * FROM skedmaker_users LIMIT 1")or die(mysql_error());
while($row = mysql_fetch_array($result)){
	$islive=$row[$DBweekday.'live'];
	$increment=$row[$DBweekday.'increment'];
	$multiple=$row[$DBweekday.'multiple'];
	$openhour=$row[$DBweekday.'openhour'];
	$openminute=$row[$DBweekday.'openminute'];
	$breakhour=$row[$DBweekday.'breakhour'];
	$breakminute=$row[$DBweekday.'breakminute'];
	$returnhour=$row[$DBweekday.'returnhour'];
	$returnminute=$row[$DBweekday.'returnminute'];
	$closehour=$row[$DBweekday.'closehour'];
	$closeminute=$row[$DBweekday.'closeminute'];
}
$break=$breakhour.":".$breakminute.".00";
$return=$returnhour.":".$returnminute.".00";

//======= custom
$check_custom=$year."-".$month."-".$day;
$countIt=mysql_query("SELECT * FROM skedmaker_custom_sked WHERE date='$check_custom'");
$total_custom=mysql_num_rows($countIt);
if($total_custom>0){
	$result=mysql_query("SELECT datecode FROM skedmaker_custom_sked WHERE date='$check_custom' LIMIT 1");
	while($row = mysql_fetch_array($result)){$datecode=SM_d($row['datecode']);}
	$result=mysql_query("SELECT name FROM skedmaker_custom WHERE datecode='$datecode' AND name!='' LIMIT 1");
	while($row = mysql_fetch_array($result)) {$customName=SM_d($row['name']);}
	$islive='y';
}
$cal_width="100%";
?>
<table class='cc100' style='border-collapse:separate;'><tr><td class='blueBanner1'><?php echo date("l, F d, Y", $ts);?></td></tr>
<tr><td class='blueBanner2' style='padding:0px; margin:0px;'>
<?php 
$BS1=$year.$month.$day."000000";
$blockStamp=SM_timestamp($BS1);

$getExist=mysql_query("SELECT * FROM skedmaker_custom_sked WHERE date='$check_custom' AND name!=''");
while($rowExist = mysql_fetch_array($getExist)){$codeExist=SM_d($rowExist['code']);}

//======= CUSTOM FOUND
if($loginValid=='admin' && $total_custom>0){
	?>
	<table class='cc100'><tr><td class='nopad'>
	<div class='navBlue'><a href="<?php echo $smadmin;?>&amp;op=removecustom&amp;csc=<?php echo $codeExist;?>&amp;dc=<?php echo $datecode;?>&amp;#skedtop"  class='sked' title="Remove Custom"><img src="<?php echo $sm_btns_dir;?>btn_custom16_reg.png" style="vertical-align:middle; margin-right:7px; border:0px" />Custom: "<?php echo $customName; ?>"</a></div>
	</td></tr></table>
<?php } 

//======= BLACKOUT FOUND
if($loginValid=='admin' && $blackedout=='y'){ 
?>
<table class='cc100'><tr><td class='nopad'>
<div class='navRed'><a href='<?php echo $smadmin;?>&amp;v=blackouts&amp;#skedtop' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_blackout16_reg.png' class='btn'/>This day is inside a blackout range.</a></div>
</td></tr></table>
<?php } 

if($loginValid=='admin' && $foundBlocked=='y'){?>
<table class='cc100'><tr><td class='nopad'>
<div class='navRed'><a href='<?php echo $smadmin;?>&amp;ts=<?php echo $blockStamp;?>&amp;op=unblockdate&amp;#skedtop' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_remove16_reg.png' class='btn'/>This day is blocked ~ Click here to unblock.</a></div>
</td></tr></table>
<?php } 

if($loginValid=='admin' && $sameDay=='n'){ ?>
<table class='cc100'><tr><td class='nopad'>
<div class='navRed'><a href='<?php echo $smadmin;?>&amp;v=options&amp;&amp;#skedtop' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_remove16_reg.png' class='btn'/>Same-day appointments are blocked.</a></div>
</td></tr></table>
<?php } 
	 
if($loginValid=='admin' && $islive=='y' && $total_custom<=0 && $foundBlocked!='y' && $sameDay!='n' && $blackedout!='y'){ ?>
<table class='cc100'><tr><td class='nopad'>
<div class='navGreen'><a href='<?php echo $smadmin;?>&amp;ts=<?php echo $blockStamp;?>&amp;op=blockdate&amp;#skedtop' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_check_green16_reg.png' class='btn'/>This day is live ~ Click here to block.</a></div>
</td></tr></table>
<?php } 

// echo "il:".$islive." fb:".$foundBlocked." sd:".$sameDay." ob:".$onBreak." dp:".$date_passed." tc:".$total_custom;

if($islive=='y' && $foundBlocked!='y' && $date_passed!='y' && $sameDay!='n' && $blackedout!="y"){ ?>
	<table class='cc100'><tr><td class='bluebBanner2' style='padding:0px; margin:0px;'>
	<table class='cc100'>
<?php 
	//======= CUSTOM DAY
	if($total_custom>0){
		$result=mysql_query("SELECT datecode FROM skedmaker_custom_sked WHERE date='$check_custom' LIMIT 1");
		while($row = mysql_fetch_array($result)){$DBdatecode=SM_d($row['datecode']);}

		$stagger=0;
		$resultDC=mysql_query("SELECT * FROM skedmaker_custom_timeframes WHERE datecode='$DBdatecode' ORDER BY starthour"); // the named one is the storage for the  is the 
		while($rowDC = mysql_fetch_array($resultDC)){
			$hour=SM_d($rowDC['starthour']);
			$minute=SM_d($rowDC['startminute']);
			$end_hour=SM_d($rowDC['endhour']);
			$end_minute=SM_d($rowDC['endminute']);
			$DBtimecode=SM_d($rowDC['timecode']);
			$max_apts=SM_d($rowDC['multiple']);
			if($stagger==1){$stagger=0;}else{$stagger=1;}
			$dayTS=SM_timestamp($check_custom." ".$hour.":".$minute.".00");
			SM_create_timeframes($max_apts, $dayTS, $end_hour, $end_minute, $increment, $appointmentAvailable, $appointmentUnavailable, $timezone, $appointmentpadding, $publicschedule, $stagger);
		}
	//======= PLAIN DAY
	}else{
		SM_create_hours($year, $month, $day, $openhour, $openminute, $closehour, $closeminute,  $break, $return, $timezone, $appointmentpadding, $increment, $appointmentAvailable, $appointmentUnavailable);
	}
	?>
	</table>
	</td></tr></table>
<?php 

}else{ 
	if($loginValid=="admin" && $foundBlocked!='y' && $sameDay!='n' && $blackedout!='y' && $allowsameday!="y"){?>
		<table class='cc100'><tr><td class='nopad'>
		<div class='navRed'><a href='<?php echo $smadmin;?>&amp;v=default&amp;#<?php echo $DBweekday;?>' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_remove16_reg.png' class='btn'/>This day is deactivated, click here to activate it.</a></div>
		</td></tr></table>
<?php 
	}else{?>
		<table class='cc100'><tr><td class='pad14b2'>Sorry, no appointments are available</td></tr></table>
<?php 
}
} ?>
</td></tr></table>
<?php 
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Create list of hours
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_create_hours')){function SM_create_hours($year, $month, $day, $openhour, $openminute, $closehour, $closeminute, $break, $return, $timezone, $appointmentpadding, $increment, $appointmentAvailable, $appointmentUnavailable){
	
	//======= get multiple
	$thisday=SM_timestamp($year.$month.$day);
//	echo $year."-".$month."-".$day." ".$openhour.":".$openminute."00";
	
	$S=SM_timestamp($year."-".$month."-".$day." ".$openhour.":".$openminute.".00");
	$B=SM_timestamp($year."-".$month."-".$day." ".$break);
	$R=SM_timestamp($year."-".$month."-".$day." ".$return);
	$E=SM_timestamp($year."-".$month."-".$day." ".$closehour.":".$closeminute.".00");
	
	$weekday=strtolower(date("l", $thisday));
	$multiplerow=$weekday."multiple";
	$result=mysql_query("SELECT $multiplerow FROM skedmaker_users");
	while($row=mysql_fetch_array($result)){$max_apts=SM_d($row[$multiplerow]);}

	$stagger=0;

	$dayTS=SM_timestamp($year."-".$month."-".$day." ".$openhour.":".$openminute.".00");
	
//	echo "S:".SM_apt($S)."<bR>";
//	echo "E:".SM_apt($E)."<bR>";
//	echo "dayTS:".SM_apt($dayTS)."<bR>";

	//=================================================
	//------- HOUR -----------------
	//=================================================
	if($increment=="hour"){					$add_the_time="+1 hour";
	}else if($increment=="halfhour"){		$add_the_time="+30 minutes";
	}else if($increment=="quarter"){	$add_the_time="+15 minutes";
	}else{
		for($do=2; $do<25; $do++){
			if($increment==$do."hours"){
				$add_the_time="+".$do." hours";
			}
		}
	}

	while($dayTS<=$E){
	if($stagger==1){$stagger=0;}else{$stagger=1;}
	if(($dayTS>=$S && $dayTS<$B) || ($dayTS>=$R && $dayTS<$E)){
		SM_create_timeframes($max_apts, $dayTS, "", "", $increment, $appointmentAvailable, $appointmentUnavailable, $timezone, $appointmentpadding, $publicschedule, $stagger);
	}
		$dayTS=strtotime($add_the_time, $dayTS);
	}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- create timeframes
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_create_timeframes')){function SM_create_timeframes($max_apts, $dayTS, $end_hour, $end_minute, $increment, $appointmentAvailable, $appointmentUnavailable, $timezone, $appointmentpadding, $publicschedule, $stagger){
	global $loginValid; global $smadmin;
	//======= Blocked?
	$countIt=mysql_query("SELECT * FROM skedmaker_sked WHERE startdate='$dayTS' AND (usercode='Admin Blocked' OR name='Admin Blocked') Limit 1") or die(mysql_error());
	$total_blocked=mysql_num_rows($countIt);

	$result=mysql_query("SELECT * FROM skedmaker_users");
	while($row = mysql_fetch_array($result)){$timezone=SM_d($row['timezone']); $daylight_savings=SM_d($row['daylight_savings']);}

	//======= time passed calculations
	$d1=date('Y-m-d H:i.s');
	$d2=SM_timestamp($d1);

	$check_DST=date("I", time());
//	$check_DST=1;
	if($check_DST==1 && $daylight_savings=="y"){$d2=$d2+3600;}

	$d3=strtotime("$timezone hours", $d2);

	//------- if appointment padding exists, add it to time
	if($appointmentpadding!=""){$dayCheck=strtotime("+ ".$appointmentpadding." hours", $d3);}else{$dayCheck=$d3;}

	if($dayCheck>$dayTS){$time_passed='y';}else{$time_passed='n';}

	if($_GET['dc']!=""){$URLdc="&amp;dc=".$_GET['dc'];}else{$URLdc="";}
	if($_GET['tc']!=""){$URLtc="&amp;tc=".$_GET['tc'];}else{$URLtc="";}

	//======= admin or client 
	if($loginValid=="admin"){
		$this_page=$smadmin."&amp;v=adminsked&amp;ts=".$dayTS.$URLdc.$URLtc."&amp;";
	}else{
		$this_page=SM_permalink()."&amp;op=confirm&amp;ts=".$dayTS.$URLdc.$URLtc."&amp;#skedtop";
	}

	//======= get number taken
//	$countIt=mysql_query("SELECT * FROM skedmaker_sked WHERE startdate='$dayTS'") or die(mysql_error());
//	$total_taken=mysql_num_rows($countIt);

	$result=mysql_query("SELECT numberinparty FROM skedmaker_sked WHERE startdate='$dayTS'") or die(mysql_error());
	while($row=mysql_fetch_array($result)){
		$this_total_taken=SM_d($row['numberinparty']);
		if($this_total_taken==""){$this_total_taken=1;}
		$total_taken+=$this_total_taken;
	}

	//======= REMAINING
	$remaining=$max_apts-$total_taken;

	//======= TIMES
	$time_start=SM_timeText_noampm($dayTS);
	if($end_hour!=""){
		$time_end=SM_timeText(SM_timestamp($year.$month.$day.$end_hour.$end_minute."00"));
	}else{
		if($increment=="hour"){$add_time="+1 hour";}
		else if($increment=="halfhour"){$add_time="+30 minutes";}
		else if($increment=="quarter"){$add_time="+15 minutes";}
		else{$add_time="+".$increment;}
		$time_end=SM_timeText(strtotime($add_time, $dayTS));
	}
	SM_apt_output($this_page, $dayTS, $time_start, $time_end, $dayCheck, $remaining, $total_blocked, $time_passed, $appointmentAvailable, $appointmentUnavailable, $publicschedule, $stagger);
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- appointment output
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_apt_output')){
function SM_apt_output($this_page, $dayTS, $time_start, $time_end, $dayCheck, $remaining, $total_blocked, $time_passed, $appointmentAvailable, $appointmentUnavailable, $publicschedule, $stagger){
	global $loginValid;
	global $sitepublic;
	global $publicschedule;
	global $timezone;
	// -- blocked
	if($total_blocked>0){
		$div="";
		$div_close="";
		$admin_operation="block";
		$text="<i>".$appointmentUnavailable."</i>";
		if($stagger==1){$td_class="pad7b2";}else{$td_class="pad7g";}

	// -- time passed
	}else if($time_passed=="y"){
		$div="";
		$div_close="";
		$admin_operation="noshow";
		$text="<i>".$appointmentUnavailable."</i>";
		if($stagger==1){$td_class="pad7b2";}else{$td_class="pad7g";}

	// -- none remaining
	}else if($remaining<=0){
		$div="";
		$div_close="";
		$admin_operation="cancel";
		$text="<i>".$appointmentUnavailable."</i>";
		if($stagger==1){$td_class="pad7b2";}else{$td_class="pad7g";}

	// -- availble but cant click
	}else if($dayCheck<$dayTS && $remaining>=1 && $sitepublic!="y"){
		$div="<div class='navMenuSM' style='margin:0px;'><a href='".$this_page."' class='sked'>";
		$div_close="</a></div>";
		$admin_operation="cancel";
		$text=$appointmentAvailable."<span class='smallG'> ".$remaining."</span>";
		if($stagger==1){$td_class="nopadb2";}else{$td_class="nopadg";}

	// -- available to click
	}else if($dayCheck<$dayTS && $remaining>=1){
		$div="<div class='navMenuSM'><a href='".$this_page."' class='sked'>";
		$div_close="</a></div>";
		$admin_operation="cancel";
		$text=$appointmentAvailable." <span class='smallG'> ".$remaining."</span>";
		if($stagger==1){$td_class="nopadb2";}else{$td_class="nopadg";}
	}

	$result=mysql_query("SELECT * FROM skedmaker_users");
	while($row = mysql_fetch_array($result)){$publicschedule=SM_d($row['publicschedule']);}	

	//======= stagger tr
	if($stagger==0){$tr_data="<tr style='background-color:#ccc;'>";}else{$tr_data="<tr>";}
	// ======= output 
	echo $tr_data;
	echo "<td class='".$td_class."'>";
	echo $div;
	echo "<span style='font-weight:bold; float:left;'>".$time_start."-".$time_end."</span>";
	echo "<span style='float:right; padding-right:14px;'>".$text."</span>";
	echo "<br style='clear:both'>";
	echo $div_close;
	echo "</td></tr>";
	if($loginValid=="admin"){SM_client_apt($dayTS, $time_start, $time_end, $admin_operation);} // -- shows the admin what is there plus ctions 
	if($publicschedule=="y" && $loginValid!="admin"){SM_public_apt($dayTS, $time_start, $time_end, $admin_operation);} // show to all public
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- displays the client info of an apt to the admin only and gives options to cancel, mark as no show, etc.
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_client_apt')){function SM_client_apt($dayTS, $time_start, $time_end, $op){
		global $smadmin;
		$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
	if($op=="cancel"){
		$opURL=$smadmin."&amp;op=cancel&amp;";
		$btn_img="btn_cancel16_reg.png";
		$book_word="Cancel";
	}else if($op=="noshow"){
		$countIt=mysql_query("SELECT * FROM skedmaker_sked WHERE startdate='$dayTS' AND noshowsent!=''");
		$total=mysql_num_rows($countIt);
		if($total>0){
			$opURL="#";
			$btn_img="btn_noshow16_reg.png";
			$book_word="No-show";
		}else{
			$opURL=$smadmin."&amp;op=noshow&amp;";
			$btn_img="btn_send16_reg.png";
			$book_word="Mark as No-show";
		}
	}else if($op=="block"){
		$opURL=$smadmin."&amp;op=cancel&amp;";
		$btn_img="btn_block16_reg.png";
		$book_word="Un-Block";
	}
	$result=mysql_query("SELECT * FROM skedmaker_sked WHERE startdate='$dayTS'");
	while($row = mysql_fetch_array($result)){
		$datecode=SM_d($row['datecode']);
		$stagger=SM_stagger($stagger);
		$name=SM_d($row['name']);
		$DBcode=SM_d($row['code']);
		echo "<td class='nopad'><div class='navYellow'><a href='".$opURL."&amp;aptc=".$DBcode."&amp;ts=".$dayTS."&amp;#skedtop' span style='font-size:11px;'><img src='".$sm_btns_dir.$btn_img."' class='btn' style='margin-left:14px;'> ".$book_word.": ".$name."</a></div></td><tr>";
	}	
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- If calendar is set to publicm this will display who has the apt
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_public_apt')){function SM_public_apt($dayTS, $time_start, $time_end, $op){
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
	$result=mysql_query("SELECT * FROM skedmaker_sked WHERE startdate='$dayTS'");
	while($row = mysql_fetch_array($result)){
		$datecode=SM_d($row['datecode']);
		$stagger=SM_stagger($stagger);
		$name=SM_d($row['name']);
		$DBcode=SM_d($row['code']);
		echo "<td class='pad7' style='border-top:1px dotted #666;'><span style='font-size:11px;'><img src='".$sm_btns_dir."btn_myaccount16_reg.png' class='btn'>".$name."</td><tr>";
	}
}}


/////// anchor link to get to the top of the page
if(!function_exists('SM_top')){function SM_top(){
	echo "<table style='width:50px; float:right; border-collapse:collapse;'>";
	echo "<td valign='middle'><a href='#top' class='sked'><span class='smallG'>^ Top</span></a></td>";
	echo "</tr></table>";
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Removes a custom day that has been applied 
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_remove_custom_from_day')){function SM_remove_custom_from_day($customskedcode, $bulkReturn, $year, $month, $day, $weekday){
	global $smadmin;
	if($_GET['op']=='removecustom'){
		if ($_SERVER['REQUEST_METHOD']=='POST'){
			$result=mysql_query("SELECT date FROM skedmaker_custom_sked WHERE code='$customskedcode'");
			while($row = mysql_fetch_array($result)){$this_date=SM_d($row['date']);}
			if($this_date!=""){$tsURL=SM_timestamp($this_date);}
			$saveIt=mysql_query("DELETE from skedmaker_custom_sked WHERE code='$customskedcode'");
			if(!$saveIt){
				SM_redBox("Could not remove the custom setting for this day, try again later.", "100%", 16);
			}else{
				echo"<br>";
				SM_greenBox("Removed custom setting!", "100%", 21);
				if($_GET['blkrtn']==""){
					SM_redirect($smadmin."&v=home&ts=".$tsURL."&", 500);
				}else{
					SM_redirect($smadmin."&v=customapply&dc=".$_GET['dc']."&#".$_GET['blkrtn']."&", 500);
				}
				die();
			}
		}

		$countIt=mysql_query("SELECT * FROM skedmaker_custom_sked WHERE code='$customskedcode' LIMIT 1");
		$total=mysql_num_rows($countIt);

		$result=mysql_query("SELECT datecode FROM skedmaker_custom_sked WHERE code='$customskedcode' LIMIT 1");
		while($row = mysql_fetch_array($result)){$datecode=SM_d($row['datecode']);}
		
		$result=mysql_query("SELECT name FROM skedmaker_custom WHERE datecode='$datecode' AND name!='' LIMIT 1");
		while($row = mysql_fetch_array($result)){$custom_name=SM_d($row['name']);}

		if($total>0){ 
			echo "<br><br>";
			SM_title("Remove Custom Setting", "btn_cancel32_reg.png", "");
			?>
			<form name='formdc' method='post' action='<?php echo $smadmin;?>&amp;op=removecustom&amp;dc=<?php echo $_GET['dc']; if($_GET['blkrtn']!=""){echo "&amp;blkrtn=".$_GET['blkrtn'];}?>&amp;csc=<?php echo $_GET['csc'];?>&amp;' style='margin:0px; border:0px'>
			<table class='cc800'>
            <tr><td class='blueBanner1'>This date is set to: <?php echo $custom_name; ?></td></tr>
            <tr><td class='blueBanner2' style='padding:0px'>
			<?php SM_menu();?>
			<table class='cc100'><tr><td class='pad14' style='text-align:center;'>
			<?php SM_redBox("Are you SURE you want to remove the custom setting from this date?", "100%", 16); ?>
			</td></tr></table>
			<table class='cc100'>
			<tr><td class='pad14' colspan='2'><b>Removing the custom setting will revert this day back to its default weekday setting.</b></td></tr>
			<tr><td class='label100'><a href='<?php echo $smadmin;?>&amp;v=home&amp;ts=<?php echo $_GET['ts'];?>&amp;' class='smallG'>Back to Admin</a></td><td class='pad14' style='width:600px;'><input type='submit' name='button' id='trash' value='Yes, remove custom setting'/></td></tr>
			</table></td></tr></table>
			</form>
	<?php 
		}else{
			SM_redBox("No custom template set to this date.", "100%", 21);
			die();
		}
		echo "</td></tr></table>";
		SM_upcoming_warning($_GET['dc']);
		die();
	}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- warns of upcoming appointments before deleting a custom day 
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_upcoming_warning')){function SM_upcoming_warning($datecode){
	global $smadmin;
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
	$countIt=mysql_query("SELECT * FROM skedmaker_sked WHERE datecode='$datecode'");
	$total_currently_sked_with_datecode=mysql_num_rows($countIt);

	if($total_currently_sked_with_datecode>0){ 
		if($total_currently_sked_with_datecode==1){$apt_word="appointment";}else{$apt_word="appointments";}?>
			<br />
			<table class='cc800'><tr><td class='blueBanner1'>You Have Upcoming Appointments With This Setting</td></tr>
            <tr><td class='blueBanner2'>

			<table class='cc100'>
            <tr><td class='pad14' colspan='3'><img src='<?php echo $sm_btns_dir; ?>btn_warn22_reg.png' class='btn'/><span class='redText'>WARNING! You have <?php echo $total_currently_sked_with_datecode; ?> upcoming <?php echo $apt_word; ?> scheduled with this setting.</span></td></tr>

			<?php 
			$result=mysql_query("SELECT * FROM skedmaker_sked WHERE datecode='$datecode'");
			while($row=mysql_fetch_array($result)){
				$apt_date=SM_apt(SM_d($row['startdate']));
				$cancel_code=SM_d($row['code']);
				$client_code=SM_d($row['usercode']);
				$client_name=SM_get_client_name($client_code);
				$stagger=SM_stagger($stagger);
				echo "<td class='nopad' style='width:200px;'><div class='navMenu'><a href='".$smadmin."&amp;v=clientdetail&amp;uc=".$client_code."&amp;'><span class='smallText'>".$client_name."</a></div></td>";
				echo "<td class='pad7'>
				<a href='".$smadmin."&amp;v=appointments&amp;op=cancel&amp;ac=".$cancel_code."&amp;csc=".$_GET['csc']."&amp;dc=".$_GET['dc']."&amp;removingcust=1&amp;' title='Cancel Appointment'><img src='".$sm_btns_dir."btn_cancel16_reg.png' class='btn'>
				<span class='smallText'>".$apt_date."</span></a></td>";
				echo "</tr>";
			}
            ?>
            </table>
			</td></tr></table>
			<?php 
		}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Take the passed variables and use to send all emails
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_emailIt')){function SM_emailIt($to, $from, $BCC, $subject, $bodyData){
	include(plugin_dir_path( __FILE__ ) . "sm-settings.php");
$startData="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
	<HTML xmlns=\"http://www.w3.org/1999/xhtml\">
	<head>
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
	<style type='text/css'>
	.bBox{ background-color: #D0F1FB; text-align:left; padding:7;}
	.blkBox{ background-color: #000; text-align:left; padding:5;}
	.dgBox{ background-color: #333; text-align:left; padding:5;}
	.header{font-family:Verdana; font-size:28px; color:#000; font-weight:normal;}
	.gBox{ background-color: #EFEFEF; text-align:left; padding:7;}
	.greenText {font-family:Verdana; font-size:14px; color:#009900; font-weight:bold;}
	.redText {font-family:Verdana; font-size:14px; color:#F00; font-weight:bold;}	
	.smallG{font-family:Verdana; font-size:10px; color:#666;}
	.smallText{font-family:Verdana; font-size:10px; color:#000;}
	.subhead{font-family:Verdana; font-size:18px; color:#000; font-style:italic;}
	.whiteBold{font-family:Verdana; font-size:14px; color:#FFF; font-weight:bold; }
	img.btn {border:none; margin-right:7px; vertical-align:middle;}
	td.blueBanner1{-moz-border-radius-topleft:7px; -webkit-border-top-left-radius:7px; border-top-left-radius:7px; -moz-border-radius-topright:7px; -webkit-border-top-right-radius:7px;
       border-top-right-radius:7px;	overflow:hidden; background-color:#".$b1_color."; padding:7px 7px 7px 14px; color:#fff; font-weight:bold; font-size:18px; text-align:left; border:none; }
	td.blueBanner2{background-color:#".$b2_color."; padding:10px; border:1px solid #".$b1_color."; text-align:left; -moz-border-radius-bottomleft:7px; -webkit-border-bottom-left-radius:7px;
       border-bottom-left-radius:7px; -moz-border-radius-bottomright:7px; -webkit-border-bottom-right-radius:7px; border-bottom-right-radius:7px; overflow:hidden;}
	td.label150{padding:7px; text-align:right; font-weight:bold; vertical-align:middle; width:150px;}
	td.label200{padding:7px; text-align:right; font-weight:bold; vertical-align:middle; width:200px; font-size:14px;}
	td.nopad{padding-top:0px; padding-right:0px; padding-bottom:0px; padding-left:0px;}
	td.pad7{padding:7px;}
	td.pad14{padding:14px;}
	td.greenBanner{background-color:#090; text-align:left; padding:7px; }
	td.redBanner{background-color:#C00; text-align:left; padding:7px;}
	table.cc100{border-collapse:separate; border:none; padding:0px; border-spacing:0px; width:100%;}
	table.cc800{border-collapse:separate; border:none; padding:0px; border-spacing:0px; width:800px;}
	body,td,th {font-family:Verdana; font-size:14px; color:#000;}
	body {background-color:#FFF margin-top:0px; margin-right:0px; margin-bottom:0px; margin-left:0px;}
	a:link {color: #000;text-decoration: none; font-weight: bold;}
	a:visited {text-decoration: none;color: #366; font-weight: bold;}
	a:hover {text-decoration: none;color: #0CC; font-weight: bold;}
	a:active {text-decoration: none;color: #366; font-weight: bold;}
	.navGreen a:link	{display: block;	background-color: #090; text-decoration: none; padding:7px; color:#fff;}
	.navGreen a:visited	{display: block;	background-color: #090; text-decoration: none; padding:7px; color:#fff;}
	.navGreen a:hover	{display: block;	background-color: #0C0;	text-decoration: none; padding:7px; color:#fff;}
	.navGreen a:active	{display: block;	background-color: #0C0;	text-decoration: none; padding:7px; color:#fff;}
	.navRed a:link		{height: 100%; display: block;	background-color: #900;	text-decoration: none; padding:7px; color:#fff;}
	.navRed a:visited	{height: 100%; display: block;	background-color: #900; text-decoration: none; padding:7px; color:#fff;}
	.navRed a:hover		{height: 100%; display: block;	background-color: #F03;	text-decoration: none; padding:7px; color:#fff;}
	.navRed a:active	{height: 100%; display: block;	background-color: #F03;	text-decoration: none; padding:7px; color:#fff;}
	.navBlue a:link		{height: 100%; display: block;	background-color: #09F;	text-decoration: none; padding:7px; color:#fff;}
	.navBlue a:visited	{height: 100%; display: block;	background-color: #09F; text-decoration: none; padding:7px; color:#fff;}
	.navBlue a:hover	{height: 100%; display: block;	background-color: #0CF;	text-decoration: none; padding:7px; color:#fff;}
	.navBlue a:active	{height: 100%; display: block;	background-color: #0CF;	text-decoration: none; padding:7px; color:#fff;}
	</style>
	</head>
	<BODY>
	<LEFT>";

$endData="
	<table class='cc800'>
	<tr><td class='pad7'><span class='smallText'>Do not reply to this e-mail. This e-mail address does not receive incoming mail.</span></td></tr>
	</table>
	</LEFT></BODY></HTML>";

	$finalData=$startData.$bodyData.$endData;

	//================================================= 
	//======= PREPARE THE HTML EMAIL =======
	//================================================= 
	if($send_notices_to_client=="y" && $to!=""){
		$sendto="$to";
		$headers = "From: Appointments <$adminemail> \r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\n";
		$headers .= "MIME-Version: 1.0\n";
		$mail_subject="$subject";
		$success=mail($sendto, $mail_subject, $finalData, $headers, "-f$adminemail");
		if(!$success){$errorMessage='sending_client';}
	}

	if($send_notices_to_admin=="y"){			
		$sendto="$adminemail";
		$headers = "From: Appointments <$adminemail> \r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\n";
		$headers .= "MIME-Version: 1.0\n";
		$mail_subject="$subject";
		$success=mail($sendto, $mail_subject, $finalData, $headers, "-f$adminemail");
		if(!$success){$errorMessage='sending_admin';}
	}

	if($send_notices_to_BCC=="y"){
		if($send_notices_to_BCC=="y"){		
			$sendtoBCC="$BCC1, $BCC2, $BCC3";
		}else{
			$sendtoBCC="";
		}
		$sendto="$sendtoBCC";
		$headers = "From: Appointments <$adminemail> \r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\n";
		$headers .= "MIME-Version: 1.0\n";
		$mail_subject="$subject";
		$success=mail($sendto, $mail_subject, $finalData, $headers, "-f$adminemail");
		if(!$success){$errorMessage='sending_admin';}
	}
	if($errorMessage==""){return true;}else{return false;}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Creates the box of text and hidden variable to check posts
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_capture_create')){function SM_capture_create($errorCapture){ 
	//------- RANDOMIZE LETTERS
	$capture_word="";
	$wordlen=rand(5,6);

	for($x=1; $x<$wordlen; $x++){
		$len = 1;
		$base="bcdfghjklmnpqrstvwxz";// -- no vowels
		$max=strlen($base)-1;
		$letter="";
		mt_srand((double)microtime()*1000000);
		while (strlen($letter)<$len)
			$letter.=$base{mt_rand(0,$max)
		};
		$capture_word=$capture_word.$letter;
		$capture_image=$capture_image."<img src='".plugin_dir_url(dirname( __FILE__) )."_cap_lets/".$letter.".png' style='margin:0px;'>";
	}?>
    <table class='cc100' style='margin:0px; padding:0px;'>
    <tr><td class='b2-only' style=' <?php if(!wp_is_mobile()){ ?>width:200px;  <?php }else{ ?> width:30%; <?php } ?> padding:0px; margin:0px; background: url(<?php echo plugin_dir_url(dirname( __FILE__) );?>_cap_lets/cap_back.png) center; text-align:center;'>
    <?php echo $capture_image;?></td>
    <td class='pad7b2'><?php SM_check_text_small("< Enter the letters", $errorCapture);?>
	<input name='capture_word' type='hidden' value="<?php echo $capture_word;?>"/>
<br />
	<input name='capture_check' type='text' maxlength='10' class='form_textfield_cap' style='margin-top:3px;'/>
	</td></tr></table>
<?php }}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Check if the posted text matches the hidden variable
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_capture_check')){function SM_capture_check(){
	$capture_check=$_POST['capture_check'];
	$capture_word=$_POST['capture_word'];
	if($capture_check!=$capture_word){$errorCapture="y";}else{$errorCapture="";}
	return $errorCapture;
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Cancels appointmetns -- used for both clients and admins
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_cancel_apt')){function SM_cancel_apt($isAdmin){
	global $sitename; global $smadmin; global $site; global $adminemail; global $b1_color;
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";

	if($_GET['op']=="cancel"){
		if($isAdmin=="admin" && $_GET['deletingcust']==1){
			$this_page=$smadmin;
			$redirect=$smadmin."&v=customdays&op=delete&dc=".$_GET['dc']."&";
		}else if($isAdmin=="admin" && $_GET['removingcust']==1){
			$this_page=$smadmin;
			$redirect=$smadmin."&op=removecustom&csc=".$_GET['csc']."&dc=".$_GET['dc']."&";
		}else if($isAdmin=="admin"){
			$this_page=$smadmin;
			$redirect=$smadmin."&ts=".$_GET['ts'];
		}else{
			$this_page=SM_permalink();
			$redirect=SM_permalink()."&ts=".$_GET['ts']."&amp;#skedtop";
		}

		if($isAdmin=="admin"){
			$table_class="cc600";
			$redBox_w="100%";
		}else{
			$table_class="cc100";
			$redBox_w="100%";
		}

		$ac=$_GET["ac"];
		$ts=$_GET["ts"];
		if($ac==""){$ac=$_GET["aptc"];}

		//======= DIRECTED FROM A LINK
		$result=mysql_query("SELECT * FROM skedmaker_sked WHERE code='$ac' LIMIT 1");
		while($row = mysql_fetch_array($result)){

			if(wp_is_mobile()){
				$canDate=SM_aptShort($row['startdate']);
			}else{
				$canDate=SM_apt($row['startdate']);
			}

			$canName=SM_d($row['name']);
			$canPhone=SM_d($row['phone']);
			$canEmail=SM_d($row['email']);
			$datecode=SM_d($row['datecode']);
		}

		if($usercode=="Admin Blocked"){$canName=$usercode;}

		//======= get admin email address
		$result=mysql_query("SELECT adminemail FROM skedmaker_users");
		while($row=mysql_fetch_array($result)){$adminemail=SM_d($row['adminemail']);}

		if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['op']=="cancel"){
			$errorMessage="";
			$cancelIt=mysql_query("DELETE FROM skedmaker_sked WHERE code='$ac' LIMIT 1");
			if(!$cancelIt){
				SM_redBox("Unable to cancel appointment, try again later.", "100%", 21);
			}else{
				echo"<br>";
				SM_greenBox("Appointment Cancelled!", "100%", 21);

				if($canName==""){$canName="n/a";}
				if($canPhone==""){$canPhone="n/a";}
				if($canEmail==""){$canEmail="1";}
				$SM_permalink=SM_permalink();

				//================================================= 
				//======= PREPARE THE HTML EMAIL =======
				//================================================= 
				$bodyData="<table class='cc800'><tr><td class='pad7'><span class='header'>".$sitename."</td></tr>
				<tr><td class='blueBanner1'>Appointment Notice</td></tr>
				<tr><td class='blueBanner2'>
				<table class='cc100'>
				<tr><td colspan='2'><span class='redText'>The appointment for ".$canDate." has been cancelled.</span></td></tr>
				<tr><td class='label150'>Name: </td><td class='pad7' style='width:650px;'>".$canName."</td></tr>
				<tr><td class='label150'>Phone: </td><td class='pad7' style='width:650px;'>".$canPhone."</td></tr>
				<tr><td class='label150'>E-mail: </td><td class='pad7' style='width:650px;'>".$canEmail."</td></tr>
				<tr><td class='pad7' colspan='2'><a href='".$SM_permalink."&amp;'>Please click here to schedule a new appointment.</td></tr>
				</table>
				</td></tr></table>";
				if(SM_emailIt($canEmail, $adminemail, $adminemail, "Appointment Cancelled: ".$canName, $bodyData)!=true){
					SM_redBox("Cancellation e-mail could not be sent.", "100%", 21);
				}
				SM_redirect($redirect, 1000);
				$success='y';
				SM_foot();
			}
		}

		if($success!="y"){
			if($isAdmin=="admin"){echo "<bR><bR>";}
			if($isAdmin=="admin"){
				$menu_link=$smadmin."&amp;v=clientdetail&amp;uc=".$usercode."&amp;";
			}else{
				$menu_link=$smpadeid."&amp;op=home&amp;";
			}
			if($_GET['csc']!=""){$cscURL="&amp;csc=".$_GET['csc']."&amp;";}
			if($_GET['dc']!=""){$dcURL="&amp;dc=".$_GET['dc']."&amp;";}
			if($_GET['removingcust']==1){$removingcustURL="&amp;removingcust=1&amp;";}
			if($_GET['deleteingcust']==1){$deletecustURL="&amp;deletingcust=1&amp;";}

			SM_redBox("Are you SURE you want to cancel?", $redBox_w, 21);
			?> 
			<form name="form1" method="post" action="<?php echo $this_page;?>&amp;op=cancel&amp;ac=<?php echo $ac;?>&amp;ts=<?php echo $_GET['ts']; echo $cscURL; echo $dcURL; echo $removingcustURL; echo $deletingcustURL; ?>&amp;#skedtop" style='margin-top:7px; padding: 0px;'>
			<table class='<?php echo $table_class;?>' style='margin:0px; border-collapse:separate;'>
			<tr><td class='blueBanner1'><span style='font-size:15px;'><img src='<?php echo $sm_btns_dir;?>btn_settings16_reg.png' class='btn' alt='Appointment Date'/><?php if(!wp_is_mobile()){?>Appointment for: <?php } echo $canDate; ?></span></td></tr>
			<tr><td class='blueBanner2' style='padding:0px;'>

			<table class='cc100' style='border-collapse:separate; margin:7px;'>
			<tr><td <?php if(!wp_is_mobile()){?>class='nopadb2'<?php }else{ ?>class='pad7b2' <?php } ?> colspan='2'><input type="submit" name="block" id="cancel" value="Cancel This Appointment"></td></tr>
   			<tr><td class='pad7b2' colspan='2'><img src='<?php echo $sm_btns_dir;?>btn_warn22_reg.png' class='btn' alt='Warning'><span class='redText'>This can NOT be undone.</span></td></tr>
			<tr><td class='pad7b2' colspan='2'>
			<?php if($isAdmin=='admin'){ ?>
				<div class='navMenuRound' style='width:150px;'><a href='<?php echo $smadmin;?>&amp;v=appointments&amp;ts=<?php echo $_GET['ts'];?>&amp;list=future&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_future16_reg.png' class='btn'>Back to List</a></div>  
				<div class='navMenuRound' style='width:150px;'><a href='<?php echo $smadmin;?>&amp;ts=<?php echo $_GET['ts'];?>&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_home16_reg.png' class='btn'>Admin Home</a></div>
                <?php if($_GET['detail']!=""){?>
                <div class='navMenuRound' style='width:150px;'><a href='<?php echo $smadmin;?>&amp;v=clients&amp;detail=<?php echo $_GET['detail'];?>&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_clients16_reg.png' class='btn'>Back to Client</a></div>
                <?php } ?>

			<?php }else{?>
				<div class='navMenuRound' style='width:190px;'><a href='<?php echo SM_permalink();?>&amp;#skedtop' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_settings16_reg.png' class='btn'>Back to Schedule</a></div>
			<?php  } ?>
			</td></tr></table>

   			<table class='cc100' style='border-collapse:separate; margin:0px; background-color:#e9e9e9;'>
            <tr><td style='background-color:#666'><span class='whiteBold'>Client Details</span></td></tr>

			<tr><td class='pad7b2'>
			<img src='<?php echo $sm_btns_dir;?>btn_clients16_reg.png' class='btn' alt='Client name'/><?php echo $canName; ?>
			</td></tr>

			<tr><td class='pad7b2'>
			<img src='<?php echo $sm_btns_dir;?>btn_phone16_reg.png' class='btn' alt='Phone'/><?php 
			if($canPhone!=""){echo $canPhone; }else{echo "<span style='font-weight:normal; color:#666;'>n/a";}?>
			</td></tr>

			<?php if($canEmail!=""){ ?>
			<tr><td class='nopadb2'>
			<div class='navMenuRound'><a href='mailto:<?php echo $canEmail;?>' title='E-mail'>
			<img src='<?php echo  $sm_btns_dir;?>btn_contact16b_reg.png' class='btn' alt='Email'/><span style='font-weight:normal; color:#000;'><?php echo $canEmail; ?></span></a></div>
			</td></tr>
			<?php }else{ ?>
			<tr><td class='pad7b2'>
			<img src='<?php echo $sm_btns_dir;?>btn_contact16b_reg.png' class='btn' alt='Email'/><span style='font-weight:normal; color:#666;'>n/a</span></a></div>
			</td></tr>
			<?php } ?>
			</table>

            </td></tr></table>

			</td></tr></table>
			</table>
            
			</form>
			<?php 
			SM_foot();
		}
	}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- BLOCK -- function to block entire individual days
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_block_unblock')){function SM_block_unblock(){
	global $smadmin;
	$ts=$_GET['ts'];
	$SAVE_BLOCK='n';
	if($_GET['op']=='unblockdate'){
		$saveIt=mysql_query("DELETE FROM skedmaker_blockeddates WHERE timestamp='$ts' LIMIT 1");
		$save_message="Date Unblocked!";
		$SAVE_BLOCK='y';
	}else if($_GET['op']=="blockdate"){
		$saveIt=mysql_query("INSERT INTO skedmaker_blockeddates (timestamp)VALUES('$ts')");
		$save_message="Date Blocked!";
		$SAVE_BLOCK='y';
	}
	if($SAVE_BLOCK=='y'){
		if(!$saveIt){
			SM_redBox("Error. Please try again later.", "100%", 16);
		}else{
			echo "<br>";
			SM_greenBox($save_message, "100%", 21);
			SM_redirect($smadmin."&v=home&ts=".$ts."&", 500);
			die();
		}
	}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Creates the basic horizontal menu that is used on most Admin pages
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_menu')){function SM_menu(){ 
	global $smadmin;
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
	?>
    <table class='cc100'><tr class='menu'>
	<td class='menu' style='width:145px;'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=home&amp;ts=<?php echo $_GET['ts'];?>' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_home16_reg.png' class='btn'alt='Admin Home'>Admin Home</a></div></td>
	<td class='menu' style='width:185px;'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=appointments&amp;list=future&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_future16_reg.png' class='btn' alt='List Appointments'>List Appointments</a></div></td>
	<td class='menu' style='width:145px;'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=customdays&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_custom16_reg.png' class='btn' alt='Custom Days'>Custom Days</a></div></td>
	<td class='menu' style='width:150px;'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=default&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_settings16_reg.png' class='btn' alt='Default Days'>Default Days</a></div></td>
	<td class='menu' style='width:100px;'><div class='navMenu'><a href='#' onClick='window.print();' title='Print' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_print16_reg.png' class='btn' alt='Print'>Print</a></div></td></tr>
    </tr></table>
<?php 
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Create the admin menu on the home page
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_menu_admin_vertical')){function SM_menu_admin_vertical(){
	global $timezone;
	global $reminder_interval;
	$op=$_GET['op'];
	$todaysdate=date('Y-m-d 00:00.01');
	$todayTSformenu=SM_timestamp($todaysdate);
	
	$startRange=$todayTSformenu+$reminder_interval;
	$endRange=$startRange+86400;

	echo "<table style='width:100%;'>";

	SM_vert_menu("List Appointments", "btn_future32_reg.png ", "&amp;v=appointments&amp;list=future&amp;");
	SM_vert_menu("Default Schedule Settings", "btn_settings32_reg.png", "&amp;v=default&amp;");
	SM_vert_menu("Custom Day Settings", "btn_custom32_reg.png", "&amp;v=customdays&amp;op=new&amp;");
	SM_vert_menu("Apply Custom Settings", "btn_stamp32_reg.png", "&amp;v=customapply&amp;");
	SM_vert_menu("Booking Options", "btn_options32_reg.png", "&amp;v=options&amp;");
	SM_vert_menu("Booking Requirements", "btn_requirements32_reg.png", "&amp;v=requirements&amp;");
	SM_vert_menu("Business & Contact Info", "btn_documents32_reg.png", "&amp;v=profile&amp;");
	SM_vert_menu("Set Local Timezone", "btn_world32_reg.png", "&amp;v=timezone&amp;");
	SM_vert_menu("Blackout Dates", "btn_blackout32_reg.png", "&amp;v=blackouts&amp;");
	SM_vert_menu("E-mail Notices", "btn_contact32b_reg.png", "&amp;v=email_notices&amp;");
	SM_vert_menu("Color Scheme", "btn_colors32_reg.png", "&amp;v=colors&amp;");
	echo "</table>";
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Create a uni code to check for double posts and refreshes
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_uni_create')){function SM_uni_create(){
//------- create uni code to stop double posts if F5 is pressed etc.
$len = 20;
$base='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456789';
$max=strlen($base)-1;
$unicode='';
mt_srand((double)microtime()*1000000);
while (strlen($unicode)<$len+1)
	$unicode.=$base{mt_rand(0,$max)
};
$unidate=date('Y-m-d');
$uni=$unidate."_".$unicode;
?>
<input name="uni" type="hidden" id="uni" value="<?php echo $uni; ?>"/>
<?php }} 

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Checks to see if page was posted twice and stops page if it has been refreshed etc.
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_uni_check')){function SM_uni_check(){
	global $smadmin; global $loginValid;
	$uni=$_POST['uni'];
	if(mysql_num_rows(mysql_query("SELECT uni FROM skedmaker_uni WHERE uni='$uni'"))){
		if($loginValid=="admin"){$uniback=$smadmin;}else{$uniback=SM_permalink()."&amp;ts=".$_GET['ts']."&amp;#skedtop";}
		echo "<span class='redText'>Operation halted, the form was posted twice. </span>";
		echo "<br><br>";
		echo "<a href='".$uniback."' class='sked'><< Go back</a>";
		echo "<br><br>";
		die();
		return "y";
	}else{
		mysql_query("INSERT INTO skedmaker_uni (uni)VALUES('$uni')");
		return "";
	}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- Purge button to delete all past appointments shown on _appointmetns.php
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_purge_btn')){function SM_purge_btn(){
	global $smadmin;
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
	echo "<table width='300px' style='margin-top:14px; margin-bottom:14px;'><tr><td style='text-align:center;'><div class='navPurge'><a href='".$smadmin."&op=purge&' class='b2w' style=font-weight:bold;'><img src='".$sm_btns_dir."btn_purge16_reg.png' class='btn'>Purge All Past Appointments</a></div></td></tr></table>";
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- purge_check
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_purge_past_check')){function SM_purge_past_check(){
	if ($_GET['op']=='purge'){
		global $timezone; global $smadmin;
		$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
		global $daylight_savings;
		$today=SM_ts();

		$check_DST=date("I", time());
//		$check_DST=1;
		if($check_DST==1 && $daylight_savings=="y"){$today=$today+3600;}

		if($timezone!=""){
			$add_timezone=$timezone." hours";
			$today=strtotime($add_timezone, $today);
		}
		$countPast=mysql_query("SELECT * FROM skedmaker_sked WHERE startdate<'$today'  AND usercode!='Admin Blocked' ORDER BY startdate $desc");
		$totalPast=mysql_num_rows($countPast);
		if($totalPast==1){$apt_word="appointment";}else{$apt_word="appointments";}
		
		echo "<br><br>";
		SM_title("Purge Past Appointments", "btn_purge32_reg.png", "");
		?>
		<form id="form2" name="form2" method="post" action="<?php echo $smadmin;?>&amp;v=<?php echo $_GET['p'];?>&amp;op=purge_confirm&amp;">
		<?php SM_redBox("<img src='".$sm_btns_dir."btn_largeex_reg.png' style='float:left; margin-right:-28px;' border='0px'><span style='font-size:21px;'>You are about to purge ".$totalPast." past ".$apt_word.".</span><br><br>This action can NOT be undone.", "100%", 16);?>
		<br />
		<table style='width:800px;'><tr><td class='pad5' colspan='3'><span style='font-size:28px;'><?php echo $name; ?></span></td></tr>
        <tr><td class='pad7' style='width:100px; text-align:center;'><div class='navMenuRound'><a href='<?php echo $smadmin;?>&amp;v=appointments&amp;list=past&amp;'><img src='<?php echo $sm_btns_dir;?>btn_cancel16_reg.png' class='btn' />Cancel - Don't Purge</a></div></td>
        <td width='150px' align='right' class='pad7'><input type="submit" name="purge" id="purge" value="Purge All Past Appointments" /></td>
        <tr><td></table>
        </form>
      
        <?php 
//======= LIST OUT THE PAST APTS
$result=mysql_query("SELECT * FROM skedmaker_sked WHERE startdate<'$today'  AND usercode!='Admin Blocked' ORDER BY startdate $desc");
while($row = mysql_fetch_array($result)) {
	$uc=$row['usercode'];
	$name=SM_d($row['name']);
	$phone=SM_d($row['phone']);
	$email=SM_d($row['email']);
	$this_apt=SM_d($row['startdate']);
	$showApt=SM_apt($this_apt);
	$noshowsent=SM_d($row['noshowsent']);
	$apt_time=date("g:i a",$this_apt);
	$ac=SM_d($row['code']);
	$thisDay=SM_dateText(SM_d($row['startdate']));
	if($thisDay!=$saveThisDay){?>

        <?php if($second_record=='y'){ ?>
        <tr><td colspan='4' class='tab-bottom-left'>&nbsp;</td><td class='tab-bottom-right'</td></tr> <!-- make a border at top of closing box-->
		<?php } ?>   

        <?php if($_GET['list']=="past"){SM_purge_btn();}?>
	    <table class='cc800' style='margin-top:21px;'><tr><td class='blueBanner1'><?php SM_top(); echo $thisDay;?> </td></tr>
        <tr><td class='nopad'>

		<table class='cc100'>
        <tr style='background-color:#666'>
		<td class='pad7' style='width:200px; border-left:1px solid #<?php echo $b1_color;?>;'><span class='whiteBold'>Name</span></td>
		<td class='pad7' style='width:100px;'><span class='whiteBold'>Time</span></td>
		<td class='pad7' style='width:300px;'><span class='whiteBold'>E-mail</span></td>
		<td class='pad7' style='width:100px;'><span class='whiteBold'>Phone</span></td>
		<td class='banner' style='width:100px; border-right:1px solid #<?php echo $b1_color;?>;'><span class='whiteBold'><?php if($loginValid=='admin'){echo "Actions";}else{ echo "&nbsp;";}?></span></td>
		</tr></table>
        </td></tr></table>

        <table class='cc800' style='background-color:#<?php echo $b2_color;?>'>
        <?php 
		$saveThisDay=$thisDay;
		$loop_close='y';
		$second_record='y';
	}

	$stagger=SM_stagger($stagger); ?>
	<td class='pad7' style='width:200px; border-left:1px solid #<?php echo $b1_color;?>;'><span class='smallText'><?php echo $name;?></span></td>
	<td class='pad7' style='width:100px;'><span class='smallText'><?php echo $apt_time;?></span></td>
	<td class='pad7' style='width:300px;'><span class='smallText'><?php echo $email;?></span></td>
	<td class='pad7' style='width:100px;'><span class='smallText'><?php echo $phone;?></span></td>
	<td class='nopad' style='width:100px; text-align:center; border-right:1px solid #<?php echo $b1_color;?>;'>
<?php 
	if($loginValid=='admin'){
		if($_GET['list']=="past"){
			if($noshowsent!=''){ 
				echo "<a href='#' title='No-show notice sent: ".SM_dateText($noshowsent)."' class='sked'><img src='".$sm_btns_dir."btn_noshow16_reg.png' style='border:0px;' alt='No-show Notice Sent'/></a>";
			}else{ 
				echo "<a href='".$smadmin."&amp;op=noshow&amp;aptc=".$ac."&amp;' title='Mark as No Show' class='sked'><img src='".$sm_btns_dir."btn_send16_reg.png' style='border:0px;'></a>";
			}
		}else{ 
			echo "<a href='".$smadmin."&amp;op=cancel&amp;ac=".$ac."&amp;' title='Cancel Appointment' class='sked'><img src='".$sm_btns_dir."btn_cancel16_reg.png' style='border:0px;'/></a>";
		} 
	}else{
		echo "&nbsp;";
	}
?>
</td></tr>

<?php } ?>
        <tr><td colspan='4' class='tab-bottom-left'>&nbsp;</td><td class='tab-bottom-right'</td></tr> <!-- make a border at top of closing box-->
</table>

		<?php 
		die();
	}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//======= purge_confirm
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_purge_past_confirm')){function SM_purge_past_confirm(){
	if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['op']=='purge_confirm'){
		global $timezone; global $smadmin;
		$today=SM_ts();

		$check_DST=date("I", time());
	//	$check_DST=1;
		if($check_DST==1 && $daylight_savings=="y"){$today=$today+3600;}
		
		if($timezone!=""){
			$add_timezone=$timezone." hours";
			$today=strtotime($add_timezone, $today);
		}
		$saveIt=mysql_query("DELETE FROM skedmaker_sked WHERE startdate<'$today'")or die(mysql_error());
		if(!$saveIt){
			SM_redBox("Could not purge. Try again later.", "100%", 21);
		}else{
			SM_greenBox("Purged All Past Appointments!", "100%", 21);
			SM_redirect($smadmin."&v=appointments&list=past&", 500);
			die();
		}
	}
}}

//-- Purge button to delete all past appointments shown on _appointmetns.php
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_purge_reminders_btn')){function SM_purge_reminders_btn(){
	global $smadmin;
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
	echo "<table width='300px' style='margin-top:14px; margin-bottom:14px;'><tr><td style='text-align:center;'><div class='navPurge'><a href='".$smadmin."&amp;v=reminders&amp;op=purgereminders&' class='b2w' style=font-weight:bold;'><img src='".$sm_btns_dir."btn_purge16_reg.png' class='btn'>Purge Reminder History</a></div></td></tr></table>";
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- purge_check
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_purge_reminders_check')){function SM_purge_reminders_check(){
	if ($_GET['op']=='purgereminders'){
		global $timezone; global $smadmin;
		$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
		global $daylight_savings;
		$today=SM_ts();

		$check_DST=date("I", time());
//		$check_DST=1;
		if($check_DST==1 && $daylight_savings=="y"){$today=$today+3600;}

		if($timezone!=""){
			$add_timezone=$timezone." hours";
			$today=strtotime($add_timezone, $today);
		}
		$countPast=mysql_query("SELECT * FROM skedmaker_sendreminders");
		$total=mysql_num_rows($countPast);
		if($total==1){$apt_word="reminder";}else{$apt_word="reminders";}

		echo "<br><br>";
		SM_title("Purge Reminder History", "btn_purge32_reg.png", "");
		?>
		<form id="form2" name="form2" method="post" action="<?php echo $smadmin;?>&amp;v=<?php echo $_GET['v'];?>&amp;op=purge_reminders_confirm&amp;">
		<?php SM_redBox("<img src='".$sm_btns_dir."btn_largeex_reg.png' style='float:left; margin-right:-28px;' border='0px'><span style='font-size:21px;'>You are about to purge your reminder history.</span><br><bR>This action can NOT be undone.", "100%", 16);?>
		<br />
		<table class='cc800'>
        <tr><td class='pad7' style='width:100px; text-align:center;'>
        <div class='navMenuRound'><a href='<?php echo $smadmin;?>&amp;v=reminders&amp;list=past&amp;'>
        <img src='<?php echo $sm_btns_dir;?>btn_cancel16_reg.png' class='btn' />Cancel - Don't Purge</a></div></td>
        <td width='150px' align='right' class='pad7'><input type="submit" name="purge" id="purge" value="Purge Reminder History" /></td>
        <tr><td></table>
        </form>
<?php die();
	}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//======= purge_confirm
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_purge_reminders_confirm')){function SM_purge_reminders_confirm(){
	global $smadmin;
	if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['op']=='purge_reminders_confirm'){

		$saveIt=mysql_query("DELETE FROM skedmaker_sendreminders")or die(mysql_error());
		if(!$saveIt){
			SM_redBox("Could not purge. Try again later.", "100%", 21);
		}else{
			SM_greenBox("Purged Reminder History!", "100%", 21);
			SM_redirect($smadmin."&v=reminders&", 500);
			die();
		}
	}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//-- plugin footer
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('SM_foot')){function SM_foot(){
	global $loginValid;
	 ?>
     </div>
     <table style='width:100%; border:0px; margin-top:14px;'><tr><td class='pad7' style='text-align:center;'><span class='smallG' style='font-weight:normal;'>Skedmaker WordPress Plugin version .96 © Copyright Skedmaker Online Scheduling</span></td></tr></table>
	<?php 
	if($loginValid=="admin"){die();}
}}