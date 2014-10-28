<?php
// -- removed login valid to load this page variable
$this_page=$smadmin."&amp;v=appointments&amp;";

if($_GET["list"]=="future"){$desc="";}else{$desc="DESC";}

$today=SM_ts();

if($_GET['list']=="future" || $_GET['list']=="past"){
	// its ok
}else{
	SM_redBox("Invalid Operation.", 800, 21);
	echo "<br>";
	echo "<table class='cc800'><tr><td class='b2-only' style='padding:0px;'>";
	if($loginValid=='admin'){SM_menu();}else{echo "<div class='navMenu'><a href='".$smadmin."&amp;op=sked&amp;ts=".$GET['ts']."&amp;' class='sked'><img src='".$sm_btns_dir."btn_settings16_reg.png' class='btn'>Back to Schedule</a></div>";}
	echo "<br>";
	echo "<span style='padding:21px; font-weight:bold;'>Sorry, the system has received an invalid operation and the page can not be loaded.</b>";
	echo "<br>";
	echo "<br>";
	echo "</td></tr></table>";
	SM_foot();
}

if($timezone!=""){
	$add_timezone=$timezone." hours";
	$today=strtotime($add_timezone, $today);
}
 
//======= FUTURE
if($_GET["list"]=="future" || $_GET["list"]==""){
	$countIt=mysql_query("SELECT * FROM skedmaker_sked WHERE startdate>'$today' AND usercode!='Admin Blocked' AND name!='Admin Blocked'");
	$switch_link="&amp;list=past&amp;ts=".$_GET['ts'];
	$switch_word="past";
	$title_text='future';
//======= PAST
}else if($_GET["list"]=="past"){ 
	$countIt=mysql_query("SELECT * FROM skedmaker_sked WHERE startdate<'$today' AND usercode!='Admin Blocked' AND name!='Admin Blocked'");
	$switch_link="&amp;list=future&amp;ts=".$_GET['ts'];
	$switch_word="future";
	$title_text='past';
}

$total=mysql_num_rows($countIt);
if($total==1){$appointment_word="Appointment";}else{$appointment_word="Appointments";}

SM_title("Appointments", "btn_".$_GET['list']."32_reg.png", $smadmin."&amp;v=appointments&amp;list=".$_GET['list']."&amp;");
?>
<table class='cc800'><tr><td class='blueBanner1'><?php echo $total." ".ucwords($_GET['list'])." ".$appointment_word;?></td></tr>
<tr><td class='blueBanner2' style='padding:0px;'>
<?php if($loginValid=='admin'){ SM_menu(); }else{echo "<div class='navMenu'><a href='".$smadmin."&amp;op=sked&amp;ts=".$_GET['ts']."&amp;' class='sked'><img src='".$sm_btns_dir."btn_settings16_reg.png' class='btn'>Back to Schedule</a></div>";}?>
<table class='cc100'><tr><td class='pad14'>
<?php if($total>0){ ?><b>Below is a list of <?php echo $title_text;?> appointments scheduled for <?php echo $sitename;?>.</b>
<?php }else{ echo "<b>No ".$title_text." appointments on record to list.</b>";}?>
<br /><br />
<div class='navMenuRound' style='width:300px;'><a href='<?php echo $this_page;?><?php echo $switch_link;?>&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_<?php echo $switch_word;?>16_reg.png' class='btn'/>Switch to <?php echo ucwords($switch_word);?> Appointments</a></div>
</td></tr></table>
</td></tr></table>
<br />
<?php 
if($_GET['list']=="future"){
	$result=mysql_query("SELECT * FROM skedmaker_sked WHERE startdate>'$today' AND usercode!='Admin Blocked' ORDER BY startdate $desc");
}else if($_GET['list']=="past"){
	$result=mysql_query("SELECT * FROM skedmaker_sked WHERE startdate<'$today'  AND usercode!='Admin Blocked' ORDER BY startdate $desc");
}
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

	if($name==""){$name="n/a";}
	if($email==""){$email="n/a";}
	if($phone==""){$phone="n/a";}

	if($thisDay!=$saveThisDay){
		?>

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