<?php
$totalNoApts=0;
$totalClients=0;
$badEmails=0;
$badEmailNoApt=0;

//------- SEND THE EMAIL -------
if($_SERVER['REQUEST_METHOD']=='POST' && $_GET['v']=="noshows" && $_GET['op']=="send"){
	$errorMessage="";

	$result=mysql_query("SELECT * FROM skedmaker_clients WHERE noshow>0 AND noshowsent=''");
	while($row = mysql_fetch_array($result)){
		$last=SM_d($row['last']);
		$first=SM_d($row['first']);
		$clientCode=SM_d($row['usercode']);
		$clientEmail=SM_d($row['email']);
		$clientPhone=SM_d($row['phone']);
	
		$resultB=mysql_query("SELECT * FROM skedmaker_sked WHERE usercode='$clientCode' LIMIT 1");
		while($rowB = mysql_fetch_array($resultB)){$aptDate=SM_apt(SM_d($rowB['startdate']));}

		//======= check email
		$emailchunk=explode("@", $clientEmail);
		$checkemail=$emailchunk['1'];
		if($checkemail==""){$emailValid='n';}else{$emailValid='y';}

		//======= EMAIL BODY
		$bodyData="<table class='cc800'><tr><td class='pad14'><span class='header'>".$sitename."</span></td></tr>
		<tr><td class='blueBanner1'>Appointment Reminder</td></tr>
		<tr><td class='blueBanner2'>
		<table class='cc100'>
		<tr><td class='pad7'><span style='font-size:16px;'>".$first." ".$last.", </span></td></tr>
		<tr><td class='pad7'><b>Records show you missed your appointment with us scheduled for: <br>".$aptDate."</td></tr>
		<tr><td class='pad7'><a href='".$site."'>To reschedule your appointment now, please click here. </td></tr>
		</table>
		</td></tr></table>";

		$emailIt=SM_emailIt($clientEmail, "$adminemail", "", "Please Reschedule Your Appointment", $bodyData);
//		$emailIt=emailIt("check@thisemail.com", "$adminemail", "", "Please Reschedule Your Appointment", $bodyData);

		if($emailIt==true){
			$report_class="greenText";
			$today=SM_ts();
			mysql_query("UPDATE skedmaker_clients SET noshowsent='$today' WHERE usercode='$clientCode'")or die(mysql_error());
			$emails_were_sent='y';
			$not_sent="";
		}else{
			$report_class="redText";
			$not_sent="Not ";
		}
		$final_report=$final_report."<span class='".$report_class."'>".$not_sent."Sent to: <a href='".$smadmin."&amp;v=cleintdetail&amp;uc=".$clientCode."&amp;' class='sked'>".$first." ".$last."</a> ".$clientEmail." ".$clientPhone."</span><br>";
	}

	if($final_report!=""){
		echo "<table class='cc800'><tr><td class='pad7' style='width:35px;'><img src='".$sm_btns_dir."btn_noshow32_reg.png'></td><td class='pad7' style='width:765px;'><span class='header'>No-show Notices Sent</td></tr>";
		echo "<tr><td class='blueBanner2' style='padding:14px;' colspan='2'>";
		echo "<table class='cc100'>";
		echo "<tr><td class='pad7' colspan='4'><b>Below is a report of the notices that were sent to your clients.</b></td></tr>";
		echo "<tr><td class='pad7' colspan='4'>";
		echo $final_report;
		echo "</td></tr>";
		echo "<tr>";
		echo "<td class='pad7' style='width:30%;'><div class='navMenu'><a href='".$smadmin."&amp;v=appointments&amp;' class='sked'><img src='".$sm_btns_dir."btn_listapt16_reg.png' style='border:0px; vertical-align:middle; margin-right:14px;' />List Appointments</a></div></td>";
		echo "<td class='pad7' style='width:20%;'><div class='navMenu'><a href='".$smadmin."&amp;v=clients&amp;' class='sked'><img src='".$sm_btns_dir."btn_clients16_reg.png' style='border:0px; vertical-align:middle; margin-right:14px;' />List Clients</a></div></td>";
		echo "<td class='pad7' style='width:20%;'><div class='navMenu'><a href='".$smadmin."&amp;v=home&amp;' class='sked'><img src='".$sm_btns_dir."btn_home16_reg.png' class='btn'/>Admin Home</a></div></td>";
		echo "<td class='pad7' style='width:30%;'>&nbsp</td>";
		echo "</tr>";
		echo "</table>";
		echo "</td></tr></table>";
	}
SM_foot();
}


$countIt=mysql_query("SELECT * FROM skedmaker_clients WHERE noshow>0 AND noshowsent=''");
$total=mysql_num_rows($countIt);

if($total==1){$client_word="client";}else{$client_word="clients";}

SM_title("Send No-show Notices", "btn_noshow32_reg.png", "?v=noshows");
?>
<table class='cc800'>
<tr><td class='blueBanner1'><?php echo $total." ".$client_word;?> marked as a no-show for their appointment</td></tr>
<tr><td class='blueBanner2' style='padding:0px;'>
<table class='cc100'>
<tr class='menu'>
<td class='menu' style='width:30%;'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=appointments&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_listapt16_reg.png' class='btn' alt='List Appointments'/>List Appointments</a></div></td>
<td class='menu' style='width:20%;'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=clients&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_clients16_reg.png' class='btn' alt='List Clients'/>List Clients</a></div></td>
<td class='menu' style='width:20%;'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=home&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_home16_reg.png' class='btn' alt='Admin Home'/>Admin Home</a></div></td>
<td class='menu' style='width:30%;'>&nbsp;</td>
</tr>
</table>

<?php if($total>0){ ?>
	<form id='form1' name='form1' method='post' action='admin_home.php?v=noshows&amp;op=send&amp;'>
    <table class='cc100'><tr><td class='pad14' style='padding-bottom:0px;'><b>Click the button below to sent reschedule notices.</b></td></tr>
    <tr><td class='pad14'><input type='submit' name='button' id='button' value='Send Reschedule Notices' /></td></tr>
    </table>
    </form>
<?php } ?>
</td></tr></table>
<br />
<?php 
//////////////////////////////////////////////////////////////////////////////////////////////////
//======= LIST IT
//////////////////////////////////////////////////////////////////////////////////////////////////
if($total>0){ ?>
	<table class='cc800'><tr>
	<td class='nopad' style='width:150px;'><div class='navb1'><a href='#' class='sked'>NAME</a></div></td>
	<td class='nopad' style='width:300px;'><div class='navb1'><a href='#' class='sked'>APPOINTMENT</a></div></td>
	<td class='nopad' style='width:200px;'><div class='navb1'><a href='#' class='sked'>E-MAIL</a></div></td>
	<td class='nopad' style='width:150px;'><div class='navb1'><a href='#' class='sked'>PHONE</a></div></td>
	</tr></table>

	<table class='cc800'><tr><td class='blueBanner2' style='padding:0px;'>
	<table class='cc100'>
<?php 
$result=mysql_query("SELECT * FROM skedmaker_clients WHERE noshow>0 AND noshowsent=''");
while($row = mysql_fetch_array($result)){
	$last=SM_d($row['last']);
	$first=SM_d($row['first']);
	$clientCode=SM_d($row['usercode']);
	$clientEmail=SM_d($row['email']);
	$clientPhone=SM_d($row['phone']);

	$resultB=mysql_query("SELECT * FROM skedmaker_sked WHERE usercode='$clientCode' LIMIT 1");
	while($rowB = mysql_fetch_array($resultB)){$aptDate=SM_apt(SM_d($rowB['startdate']));}

	$stagger=SM_stagger($stagger);?>
	<td class='nopad' style='width:150px;'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=clientdetail&amp;uc=<?php echo $clientCode;?>&amp;'><span class='smallText'><?php echo $first." ".$last;?></span></a></div></td>
	<td class='pad7' style='width:300px; padding-left:21px;'><span class='smallText'><?php echo $aptDate;?></span></td>
	<td class='pad7' style='width:200px; padding-left:21px;'><span class='smallText'><?php echo $clientEmail;?></span></td>
	<td class='pad7' style='width:150px; padding-left:21px;'><span class='smallText'><?php echo $clientPhone;?></span></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<?php }else{
	SM_blueBox("You Don't Have Any Noshow Reminders to Send.", 800, 21);
}
?>