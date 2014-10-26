<?php
if(!function_exists('SM_d')){function SM_d($DBvar){return stripslashes(urldecode($DBvar));}}
$smadmin=admin_url()."?page=skedmaker/admin_home.php";
$smpageid="?page_id=".$_GET['page_id'];
$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
$site=plugins_url( __FILE__ );

include(plugin_dir_path( __FILE__ ) . "sm-build-db.php");
include(plugin_dir_path( __FILE__ ) . "sm-settings.php"); //  load user defined settings
include(plugin_dir_path( __FILE__ ) . "sm-functions.php"); // load functions
include(plugin_dir_path( __FILE__ ) . "sm-styles.php");
// include(plugin_dir_path( __FILE__ ) . "sm-javascript.php"); // load javascript
?>
<div id='body' align='center'>
<?php
//////////////////////////////////////////////////////////////////////////////////////////////////
//-- If password protected, display the client login 
//////////////////////////////////////////////////////////////////////////////////////////////////
$loginClient=$_SESSION['loginClient']; // if client is logged in, $loginClient will = 'y'
if($protect!="" && $loginValid!="admin"){
	if($loginClient!="y"){
		if($_SERVER['REQUEST_METHOD'] == 'POST' && $_GET['op']=="login"){
			$errorMessage="";
			$client_password=SM_e($_POST['client_password']);
			if($client_password==""){$errorMessage='y'; $not_valid="y";}
			if($errorMessage==""){
				$result=mysql_query("SELECT protect FROM skedmaker_users");
				while($row = mysql_fetch_array($result)){$DB_client_password_check=$row['protect'];}
				if($client_password==$DB_client_password_check){
					$_SESSION['loginClient']="y";
					echo "<br><br>";
					SM_greenBox("Logging In...", 400, 21);
					SM_redirect($smpageid, 500);
					$success="y";
					SM_foot();
				}else{
					$not_valid='y';				
				}
			}
		}
		if($success!="y"){
			if($not_valid=='y'){echo"<br><br>";SM_redBox("Not Valid!", 400, 21);}?>
			<form id="form1" name="form1" method="post" action="<?php echo $smpageid;?>&amp;op=login&amp;">
			<table class='cc800' style='width:400px; margin-top:21px;'>
			<tr><td class='pad7'><span class='header'><img src='<?php echo $sm_btns_dir;?>btn_login32_reg.png' class='btn' alt='Private Schedule'>Private Schedule</span></td></tr>
			<tr><td class='blueBanner1'>This Schedule is Locked</td></tr>
			<tr><td class='blueBanner2' style='padding:14px'>
			<table class='cc100'>
			<tr><td class="pad14" colspan='2'><b>Enter the password to continue.</b></td></tr>
			<tr><td class="label150">Password:</td>
			<td class='pad7'><input name='client_password' type='password'  class='form_textfield' size="14" style='width:200px;'/></td>
			</tr>
			<tr><td class="login_label">&nbsp;</td><td class='pad7'><input type="submit" name="login" id="login" value="Continue" /></td></tr>
			</table>
			</td></tr></table>
			</form>
			<?php 
			SM_foot();
		}//-- end check for success
	}//-- end check for loginClient valid
} //-- end check for protect password.
?>