<table class='cc800' style='margin:0px; padding:0px;'>
<tr><td class='nopad'><?php SM_title("Skedmaker Administration", "btn_sked32_reg.png", $smadmin."&amp;v=home&amp;"); ?></td></tr>
<?php 
//------- If the schedule is not set up, display prompt
if($sundaylive=="" && $mondaylive=="" && $tuesdaylive=="" && $wednesdaylive=="" && $thursdaylive=="" && $fridaylive=="" && $saturdaylive==""){ ?>
	<tr><td class='pad7'><span style='font-size:18px;'>Welcome to Skedmaker Online Scheduling!</span></td></tr>
	<tr><td class='nopad' style='padding-bottom:7px;'>
<?php 	SM_blueBox("<div class='navMenuRound' style='border:none; margin:0px;'><a href='".$smadmin."&amp;v=default&amp;' class='skedblue'><img src='".$sm_btns_dir."btn_settings32_reg.png' class='btn'>Click here to start setting up your appointment schedule.</a></div>", 775, 16); ?>
</td></tr>
<?php
	} else{ 
		if($sitename!=""){
			echo "<tr><td class='nopad' style='padding-bottom:7px;'><a href='".$smadmin."&amp;v=default&amp;' class='sked'><span style='font-size:18px; margin-left:7px; font-weight:normal;'>".$sitename."</span></a></td></tr>";
		} 
}

//------- If the timezone is not set up, display prompt
if($timezone==""){
	echo "<tr><td class='nopad'  style='padding-bottom:7px;' colspan='2'>";
	SM_blueBox("<div class='navMenuRound' style='border:none;'><a href='".$smadmin."&amp;v=timezone&amp;' class='sked'><img src='".$sm_btns_dir."btn_world32_reg.png' class='btn'>You need to set up your timezone to display your schedule properly!</a></div>", 775, 16);
	echo "</td></tr>";
}

//------- If the admin email is not set up, display prompt
if($adminemail==""){
	echo "<tr><td class='nopad' style='padding-bottom:7px;' colspan='2'>";
	SM_blueBox("<div class='navMenuRound' style='border:none;'><a href='".$smadmin."&amp;v=email_notices&amp;' class='sked'><img src='".$sm_btns_dir."btn_contact32b_reg.png' class='btn'>You need to add your e-mail to send appointment confirmations!</a></div>", 775, 16);
	echo "</td></tr>";
}
?>
</table>

<table class='cc800' style='margin:0px; padding:0px;'>

<!-- ==================================================================================================
======= CALENDAR ================================================================
================================================================================================== -->

<tr><td class='nopad' style='width:500px; vertical-align:top;'>
<?php SM_create_calendar($isAdmin, $sundaylive, $mondaylive, $tuesdaylive, $wednesdaylive, $thursdaylive, $fridaylive, $saturdaylive); 
echo "<br>";
SM_create_day();
?>
</td>
<td class='nopad' style='width:300px; vertical-align:top; padding-left:14px;'>
<?php SM_menu_admin_vertical(); ?>
</td></tr></table>