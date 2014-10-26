<?php
$appointment_code=$_GET['aptc'];

//======= DIRECTED FROM APPOINTMENTS
$result=mysql_query("SELECT * FROM skedmaker_sked WHERE code='$appointment_code' AND noshowsent='' LIMIT 1");
$total=mysql_num_rows($result);

if($total>0){
	while($row=mysql_fetch_array($result)) {
		$cancelName=SM_d($row['name']);
		$cancelPhone=SM_d($row['phone']);
		$cancelEmail=SM_d($row['email']);
		$cancelDate=SM_apt($row['startdate']);
		$cancelCode=$row['code'];
	}
}

//======= SUBMIT 
if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['op']=="noshow"){
	$errorMessage="";
	$noshows++;
	$noshowsent=SM_ts();
	$noShowSked=mysql_query("UPDATE skedmaker_sked SET noshowsent='$noshowsent' WHERE code='$appointment_code' LIMIT 1");

	if(!$noShowSked){
		SM_redBox("Unable to mark as a noshow, try again later.", 800, 21);
	}else{
		$success='y';
		SM_greenBox("Marked as No-show!", 800, 21);
		//======= CHECK EMAIL
		$emailchunk=explode("@", $cancelEmail);
		$checkemail=$emailchunk['1'];
		if($checkemail==""){$emailValid='n';}else{$emailValid='y';}
		if($emailValid=='y'){
			//======= EMAIL BODY
			$bodyData="<table class='cc800'><tr><td class='pad14'><span class='header'>".$sitename."</span></td></tr>
			<tr><td class='blueBanner1'>Appointment Reminder</td></tr>
			<tr><td class='blueBanner2'>
			<table class='cc100'>
			<tr><td class='pad7'><span style='font-size:16px;'>".$cancelName.", </span></td></tr>
			<tr><td class='pad7'><span class='redText'>Records show you missed your appointment with us scheduled for:<br>".$cancelDate."</span></td></tr>
			<tr><td class='pad7'><a href='".get_site_url()."'>To reschedule your appointment now, please click here. </td></tr>
			</table>
			</td></tr></table>";
			$emailIt=SM_emailIt($cancelEmail, "$adminemail", "", "Reschedule Your Appointment - ".$sitename, $bodyData);

			if($emailIt!=true){
				SM_redBox("Could not e-mail notice to client.", 800, 21);
				$success='n';
			}
		}
	}
	if($success=='y'){
		SM_redirect($smadmin."&v=home&ts=".$_GET['ts']."&", 500);
		die();
	}
}
//==================================================================================================
//======= CONTENT BEGINS
//==================================================================================================
SM_title("Send No-show Notices", "btn_noshow32_reg.png", $smadmin."&amp;v=appointments&amp;ns=".$_GET['ns']);?>
<form name="form1" method="post" action="<?php echo $smadmin;?>&amp;op=noshow&amp;aptc=<?php echo $_GET['aptc'];?>&amp;" style='margin: 0px; padding: 0px;'>
<table class='cc800'>
<tr><td class='blueBanner1'><?php echo $cancelDate; ?></td></tr>
<tr><td class='blueBanner2' style='padding:0px;'>
<?php SM_menu();?>

<table class='cc100'>
<tr><td class='pad7'><?php SM_redBox("Are you SURE you want to mark this appointment as a no show?", 800, 16); ?></td></tr>
<tr><td class='pad14'><b>An e-mail will be sent to the client originally scheduled for <?php echo $cancelDate; ?>.</b></td></tr>
<tr><td class='pad14'>The e-mail will provide a link asking them to reschedule.</td></tr>
<tr><td class='pad14'><?php echo "<b>Name: </b>".$cancelName; ?></td></tr>
<tr><td class='pad14'><?php echo "<b>Phone: </b>".$cancelPhone; ?></td></tr>
<tr><td class='pad14'><?php echo "<b>E-mail: </b>".$cancelEmail; ?></td></tr>
<?php if($cancelEmail==""){ ?>
<tr><td class='pad14'><span class='redText'>This client does not have a valid email. A reschedule request notice can not me sent.</span></td></tr>
<?php } ?>
<tr><td class='pad14'><input type="submit" name="button" id="button" value="Yes, Mark as No Show"></td></tr>
</table>

</td></tr></table>
</form>
<?php  SM_foot(); ?>