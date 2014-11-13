<?php
// -- removed login valid to load this page variable
$this_page=$smadmin."&amp;v=clients&amp;";

$result=mysql_query("SELECT * FROM skedmaker_clients");
while($row = mysql_fetch_array($result)){
	$client_code=SM_d($row['code']);
	
	$countIt=mysql_query("SELECT * FROM skedmaker_sked WHERE usercode='$client_code'");


}


function SM_list_apts($upcoming_or_past, $today, $client_code){
	global $b1_color;
	$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
	global $smadmin;
	global $username;
	if($upcoming_or_past=="upcoming"){
		$countIt=mysql_query("SELECT * FROM skedmaker_sked WHERE usercode='$client_code' AND startdate>'$today' ");
		$result=mysql_query("SELECT * FROM skedmaker_sked WHERE usercode='$client_code' AND startdate>'$today'");
	}else{
		$countIt=mysql_query("SELECT * FROM skedmaker_sked WHERE usercode='$client_code' AND startdate<'$today' ");		
		$result=mysql_query("SELECT * FROM skedmaker_sked WHERE usercode='$client_code' AND startdate<'$today'");
	}

	$total_upcoming=mysql_num_rows($countIt);
	?>
    <table class='cc100' style='margin:0px;'>
    <tr><td style='padding:7px; color:#fff; font-weight:bold; background-color:#<?php echo $b1_color;?>'><?php echo ucwords($upcoming_or_past);?> Appointments for <?php echo $username;?></td></tr>
	<?php 
	if($total_upcoming>0){
		while($row = mysql_fetch_array($result)) {
			$this_apt=SM_d($row['startdate']);
			$canCode=SM_d($row['code']);
			echo "<tr><td class='pad7'><div class='navCancel' style='width:375px;'><a href='".$smadmin."&op=cancel&amp;aptc=".$canCode."&amp;detail=".$client_code."&amp;' title='Cancel this Appointment'>";
			echo "<img src='".$sm_btns_dir."btn_cancel16_reg.png' class='btn'>".SM_apt($this_apt)."</a></div></td></tr>";
		}
	}else{
		echo "<tr><td class='pad14'><b>No upcoming appointments.</b></td></tr>";
	} ?>
	</table>
<?php 
}

//////////////////////////////////////////////////////////////////////////////////////////////////
//=======  delete_check
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('delete_check')){function SM_delete_check($DBtable, $back_to_page){
	if ($_GET['op']=='delete'){
		$code=$_GET['cc'];
		$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
		global $smadmin;
		global $today;
		$result=mysql_query("SELECT * FROM `$DBtable` WHERE code='$code' LIMIT 1");
		while($row = mysql_fetch_array($result)){$client_name=SM_d($row['username']);}
		
		$countIt=mysql_query("SELECT * FROM skedmaker_sked WHERE usercode='$code' AND startdate>'$today'");
		$total_upcoming=mysql_num_rows($countIt);

		$delete_msg="<img src='".$sm_btns_dir."btn_largeex_reg.png' style='float:left; margin-right:-28px;' border='0px'><span style='font-size:21px;'>Are you SURE you want this client deleted? </span><br><br>This action can NOT be undone.";
		?>
		<form id="form2" name="form2" method="post" action="<?php echo $smadmin;?>&amp;v=clients&amp;op=delete_confirm&cc=<?php echo $_GET['cc'];?>&">
		<?php SM_redBox($delete_msg, 800, 16);?>
		<bR />
		<table width='800px'><tr><td class='pad5' colspan='3'><span style='font-size:28px;'><?php echo $client_name; ?></span></td></tr>
        <table width='800px'><tr><td class='pad5' colspan='3'><span style='font-size:14px;'>This client has <?php echo $total_upcoming; ?> upcoming appointments that will also be deleted.</span></td></tr>
        <tr><td width='100px' align='center' class='pad7'><div class='navMenuRound'><a href='<?php echo $back_to_page;?>' class='sked'>Cancel - Don't Delete Client</a></div></td>
        <td width='150px' align='right' class='pad7'><input type="submit" name="button2" id="trash" value="Yes, Delete This Client"/></td>
        <tr><td></table>
        </form>
		<?php 
		SM_foot();
	}
}}

//////////////////////////////////////////////////////////////////////////////////////////////////
//=======  delete_confirm
//////////////////////////////////////////////////////////////////////////////////////////////////
if(!function_exists('delete_confirm')){function SM_delete_confirm($DBtable, $redirect_to_page){
	if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['op']=='delete_confirm'){
		$code=SM_e($_GET['cc']);

		$saveIt=mysql_query("DELETE FROM `$DBtable` WHERE code='$code' LIMIT 1")or die(mysql_error());
		if(!$saveIt){
			SM_redBox("Error! Could not delete.", 21, 10000);
		}else{
			mysql_query("DELETE FROM skedmaker_sked WHERE usercode='$code'")or die(mysql_error());
			SM_greenBox("Deleted!", 800, 21);
			SM_redirect($redirect_to_page, 500);
			SM_foot();
		}
	}
}}

SM_delete_check("skedmaker_clients", $this_page);
SM_delete_confirm("skedmaker_clients", $this_page);

$today=SM_ts();

$check_DST=date("I", time());
if($check_DST==1 && $daylight_savings=="y"){$today=$today+3600;}

if($timezone!=""){
	$add_timezone=$timezone." hours";
	$today=strtotime($add_timezone, $today);
}

$countIt=mysql_query("SELECT * FROM skedmaker_clients");
$total=mysql_num_rows($countIt);
if($total==1){$client_word="Client";}else{$client_word="Clients";}

if($_GET['detail']!=""){ 
	$client_code=SM_e($_GET['detail']);
	$result=mysql_query("SELECT * FROM skedmaker_clients WHERE code='$client_code'");
	while($row = mysql_fetch_array($result)) {
		$username=SM_d($row['username']);
		$email=SM_d($row['email']);
		$phone=SM_d($row['phone']);
		$signup_date=SM_d($row['signup_date']);
		$recent_date=SM_d($row['recent_date']);
		$signup_ip=SM_d($row['signup_ip']);
		$recent_ip=SM_d($row['recent_ip']);
		$signup_location=SM_d($row['signup_location']);
		$recent_location=SM_d($row['recent_location']);
	}

	if($username==""){$username="n/a";}
	if($email==""){$email="n/a";}
	if($phone==""){$phone="n/a";}
	if($signup_date==""){$signup_date="n/a";}
	if($recent_date==""){$recent_date="n/a";}
	if($signup_ip==""){$signup_ip="n/a";}
	if($recent_ip==""){$recent_ip="n/a";}
	if($signup_location==""){$signup_location="n/a";}
	if($recent_location==""){$recent_location="n/a";}

	SM_title("Client Details", "btn_clients32_reg.png", $smadmin."&amp;v=clients&amp;detail=".$_GET['detail']."&amp;"); ?>
    <table class='cc800'><tr><td class='blueBanner1'><?php echo $username;?></td></tr>
    <tr><td class='blueBanner2' style='padding:0px;'>
    <table class='cc100'><tr class='menu'>
    <td class='nopad'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=clients' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_clients16_reg.png' class='btn' />Back to Client List</a></div></td>
    <td class='nopad'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=clients&amp;op=delete&amp;cc=<?php echo $client_code;?>' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_delete16_reg.png' class='btn' />Delete Client</a></div></td>
    <td class='nopad'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=home' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_home16_reg.png' class='btn' />Admin Home</a></div></td>
    	<td class='menu' style='width:185px;'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=appointments&amp;list=future&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_future16_reg.png' class='btn' alt='List Appointments'>List Appointments</a></div></td>
	<td class='menu' style='width:100px;'><div class='navMenu'><a href='#' onClick='window.print();' title='Print' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_print16_reg.png' class='btn' alt='Print'>Print</a></div></td>

    </tr></table>

    <table class='cc100'>
    <tr><td class='label150'>Name: </td><td class='pad7'><?php echo $username;?></td></tr>
    <tr><td class='label150'>E-mail: </td><td class='pad7'><?php echo $email;?></td></tr>
    <tr><td class='label150'>Phone: </td><td class='pad7'><?php echo $phone;?></td></tr>
    <tr><td class='label150'>Signup Date: </td><td class='pad7'><?php echo SM_apt($signup_date);?></td></tr>
    <tr><td class='label150'>Recent Date: </td><td class='pad7'><?php echo SM_apt($recent_date);?></td></tr>
    <tr><td class='label150'>Signup IP: </td><td class='pad7'><?php echo $signup_ip;?></td></tr>
    <tr><td class='label150'>Recent IP: </td><td class='pad7'><?php echo $recent_ip;?></td></tr>
    <tr><td class='label150'>Signup Location: </td><td class='pad7'><?php echo $signup_location;?></td></tr>
    <tr><td class='label150'>Recent Location: </td><td class='pad7'><?php echo $recent_location;?></td></tr>
	</tr>
    </table>

	<?php SM_list_apts("upcoming", $today, $client_code)?>
   	<?php SM_list_apts("past", $today, $client_code)?>
    	</td></tr></table>

    </td></tr></table>
    	
<?php 	

}else{
	SM_title("Registered Clients", "btn_clients32_reg.png", $smadmin."&amp;v=clients&amp;"); ?>




<table class='cc800'><tr><td class='blueBanner1'><?php echo $total." ".ucwords($_GET['list'])." ".$client_word;?></td></tr>
<tr><td class='blueBanner2' style='padding:0px;'>
<?php SM_menu();?>
<table class='cc100'><tr><td class='pad14'>
<?php if($total>0){ ?><b>Below is a list of your registered clients. Click on a client's name to see more of their details.</b>
<?php }else{ echo "<b>No registered clients on record to list.</b>";}?>
</td></tr></table>
</td></tr></table>
<br />

<?php if($total>0){ ?>
<table class='cc800' style='margin-top:21px; border-collapse:separate; background-color:#<?php echo $b2_color;?>;'>
<tr>
<td class='tab-left' style='width:175px;' ><div class='navb1'><a href='#'>Name</a></div></td>
<td class='tab' style='width:200px;'><div class='navb1'><a href='#'>E-mail</a></div></td>
<td class='tab' style='width:100px;'><div class='navb1'><a href='#'>Phone</a></div></td>
<td class='tab' style='width:100px;'># Apts</td>
<td class='tab' style='width:125px;'>Next Apt</td>
<td class='tab-right' style='width:100px;'>Actions</td>
</tr>

<?php 

$order="ORDER BY username ";

$result=mysql_query("SELECT * FROM skedmaker_clients $order $DESC");
while($row = mysql_fetch_array($result)) {
	$next_apt="none";
	$uc=$row['code'];
	$name=SM_d($row['username']);
	$phone=SM_d($row['phone']);
	$email=SM_d($row['email']);

	if($name==""){$name="n/a";}
	if($email==""){$email="n/a";}
	if($phone==""){$phone="n/a";}

	$countIt=mysql_query("SELECT * FROM skedmaker_sked WHERE usercode='$uc' AND startdate>'$today'");
	$total_apts=mysql_num_rows($countIt);

	$saveThisDay=$thisDay;
	$loop_close='y';
	$second_record='y';
	
	$nextAPT=mysql_query("SELECT * FROM skedmaker_sked WHERE usercode='$uc' AND startdate>'$today' ORDER BY startdate LIMIT 1");
	while($rowAPT = mysql_fetch_array($nextAPT)) {$next_apt=SM_d(SM_dateNumTime($rowAPT['startdate']));}

	$stagger=SM_stagger($stagger); ?>
	<td class='nopad' style='width:175px; border-left:1px solid #<?php echo $b1_color;?>;'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=clients&amp;detail=<?php echo $uc;?>&amp;'><span class='smallText'><?php echo $name;?></span></a></div></td>
	<td class='nopad' style='width:200px;'><div class='navMenu'><a href='mailto:<?php echo $email;?>'><span class='smallText'><?php echo $email;?></span></a></div></td>
	<td class='pad7' style='width:100px;'><span class='smallText'><?php echo $phone;?></span></td>
	<td class='pad7' style='width:100px;'><span class='smallText'><?php echo $total_apts;?></span></td>
	<td class='pad7' style='width:125px;'><span class='smallText'><?php echo $next_apt;?></span></td>
	<td class='nopad' style='width:100px; text-align:center; border-right:1px solid #<?php echo $b1_color;?>;'>
<?php echo "<a href='".$smadmin."&amp;v=clients&op=delete&amp;cc=".$uc."&amp;' title='Delete Client' class='sked'><img src='".$sm_btns_dir."btn_cancel16_reg.png' style='border:0px;'/></a>"; ?>
	</td></tr>

<?php } ?>
        <tr><td colspan='5' class='tab-bottom-left'>&nbsp;</td><td class='tab-bottom-right'</td></tr> <!-- make a border at top of closing box-->
</table>
<?php } // end check for total clients  more than zero ?>
<?php } ?>