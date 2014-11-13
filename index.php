<?php
include(plugin_dir_path( __FILE__ ) . "_include/sm-status.php");
$success="";
if($protect!="" && $loginClient=="y"){$activate_sked="y";}else if($protect!="" && $loginClient!="y"){$activate_sked="no";}else if($protect==""){$activate_sked="y";}
if($activate_sked=="y"){
	$op=$_GET['op'];
	$site=plugins_url( __FILE__ );

	SM_cancel_apt("not_admin");
	SM_logout();
	SM_resend_validation();
	SM_validate_account();
	SM_forgot_login();
	if($requireregistration=="y" && $loginValidClient!="y" && $_GET['op']!='signup' && $_GET['op']!="forgot" && $_GET['op']!="validate" && $_GET['op']!="resend"){include(plugin_dir_path( __FILE__ )."_include/_form_login.php");} // -- require login
	if($_GET['op']=='confirm'){include(plugin_dir_path( __FILE__ )."_include/_form_confirm.php");} // -- confirm the appointment
	if($_GET['op']=="signup"){include(plugin_dir_path( __FILE__ ) . "_include/_form_signup.php");} // -- signup for an account
	if($_GET['op']=="myaccount"){include(plugin_dir_path( __FILE__ ) . "_include/_my_account.php");} // -- client account information
	if($_GET['op']=="when"){include(plugin_dir_path( __FILE__ ) . "_include/_form_when.php");} // -- when is my appointment?

	//=================================================
	//======= Build Calendar and Schedule
	//=================================================
	if($op=="sked" || $op=="" && ($requireregistration=="" || $loginValidClient=="y")){
		//-- load prefix text
		if($prefix_content!=""){echo "<table class='cc100' style='margin:0px; width:500px;'><tr><td class='pad7' style='margin:0px;'>".$prefix_content."</td></tr></table>";}
		SM_create_calendar("clientView");
		SM_create_day();
		SM_foot();
	}
}// end activate sked check
?>