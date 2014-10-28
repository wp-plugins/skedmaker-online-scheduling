<?php
$loginValid='admin';

include(plugin_dir_path( __FILE__ ) . "_include/sm-status.php");
$isAdmin='y';

// If ts a no show notice, display the form.
if($_GET['ns']!="" || $_GET['op']=="noshow"){echo "<br><br>"; include(plugin_dir_path( __FILE__ ) . '_include/_form_no_show.php');}

// The operation to perform
$op=$_GET['op'];

// The admin page to show
$view=$_GET['v'];

// Custom Days
$customskedcode=$_GET['csc'];

// settings edited
$settingedit=$_GET['settingedit'];

SM_block_unblock();
SM_cancel_apt("admin");
SM_remove_custom_from_day($_GET['csc'], $bulkReturn, $year, $month, $day, $weekday);
SM_purge_past_check();
SM_purge_past_confirm();

// Get the page to show. If it's blank, make it home page
if($_GET['v']==""){$view='home';}else{$view=$_GET['v'];}
if($view==""){$view="home";}
echo "<br><br>";
include(plugin_dir_path( __FILE__ ) . "_admin/_".$view.".php");

SM_foot(); ?>