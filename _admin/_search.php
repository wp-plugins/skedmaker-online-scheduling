<?php 
if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['v']=='search'){
	$errorMessage="";
	$search=SM_e($_POST['search']);
	if($search==""){$errorMessage='y'; $errorSearch='y';}
}

//==================================================================================================
//======= SEARCH CLIENTS
//==================================================================================================
if($search!="" && $_GET['op']=='clients'){ 
	$countIt=mysql_query("SELECT * FROM skedmaker_clients WHERE last LIKE'%$search%' AND live='y' ORDER BY last, first")or die(mysql_error());
	$total=mysql_num_rows($countIt);
	if($total>0){
		if($total==1){$result_word="Result";}else{$result_word="Results";} ?>
		<table class='cc800'><tr><td class='pad7'><span class='header'><?php echo $total." ".$result_word." Found for: ".SM_d($search);?></span></td></tr></table>
        <table class='cc800'>
        <tr>
        <td style='width:100px;' class='blueBanner1'><span style='font-size:14px;'>LAST</span></td>
        <td style='width:100px;' class='blueBanner1'><span style='font-size:14px;'>FIRST</span></td>
        <td style='width:200px;' class='blueBanner1'><span style='font-size:14px;'>APPOINTMENT</span></td>
        <td style='width:100px;' class='blueBanner1'><span style='font-size:14px;'>PHONE</span></td>
        <td style='width:200px;' class='blueBanner1'><span style='font-size:14px;'>E-MAIL</span></td>
        <td style='width:150px;' class='blueBanner1'><span style='font-size:14px;'>ACTIONS</span></td>
        </tr>
        </table>
        <table class='cc800'><tr><td class='blueBanner2' style='padding:0px;'>
        <table class='cc100'>
    <?php 
        $result=mysql_query("SELECT * FROM skedmaker_clients WHERE last LIKE'%$search%' AND live='y' ORDER BY last, first")or die(mysql_error());	
        while($row = mysql_fetch_array($result)){
            $first=SM_d($row['first']);
            $last=SM_d($row['last']);
            $phone=SM_d($row['phone']);
            $DBusercode=SM_d($row['usercode']);
            $email=SM_d($row['email']);
    
            if($email!=""){$email="<a href='mailto:".$email."' class='sked'><span class='smallText'>".$email."</span></a>";}
    
            $countIt=mysql_query("SELECT * FROM skedmaker_sked WHERE usercode='$DBusercode'");
            $total=mysql_num_rows($countIt);
    
            if($total>0){ 
                $apt=mysql_query("SELECT * FROM skedmaker_sked WHERE usercode='$DBusercode'");
                while($R2 = mysql_fetch_array($apt)) {
                    $aptDB=SM_d($R2['startdate']);
                    if($aptDB!=""){$aptShow=SM_aptShort($aptDB);}
                    $aptCode=SM_d($R2['code']);
                    $noshow=$R2['noshow'];
                }
            }else{
                $aptShow="<a href='#sked' class='sked'><span class='smallRed'><b>None</b></span></a>";
            }
    
			$stagger=SM_stagger($stagger);
			?>
			<td class='nopad' style='width:100px;'><a name='<?php echo $DBusercode;?>'></a>
			<div class='navNotes'><a href='<?php echo $smadmin;?>&amp;v=clientdetail&amp;uc=<?php echo $DBusercode;?>' title='Open Details'><span class='smallText'><?php echo $last;?></span></a></div></td>
			<td class='nopad' style='padding-left:14px; width:100px;'><span class='smallText'><?php echo $first;?></span></td>
			<td class='nopad' style='padding-left:14px; width:200px;'><span class='smallText'><?php echo $aptShow;?></span></td>
			<td class='nopad' style='padding-left:14px; width:100px;'><span class='smallText'><?php echo $phone;?></span></td>
			<td class='nopad' style='padding-left:14px; width:200px;'><span class='smallText'><?php echo $email;?></span></td>
			<td class='nopad' style='padding-left:14px; width:33px;'><?php if($aptShow!=""){echo "<a href='page_cancel.php?&amp;ac=".$aptCode."&amp;'>";}else{ echo "&nbsp;";} ?></td>
			<td class='nopad' style='padding-left:14px; width:33px;'><a href='<?php echo $smadmin;?>&amp;v=clientedit&amp;uc=<?php echo $DBusercode;?>&amp;'  class='sked' title='Edit Client Info'><img src='<?php echo $sm_btns_dir;?>btn_edit16_reg.png' style='border:0px' /></a></td>
			<?php $aptCode=SM_d($R2['code']); ?>
			</tr>
			<?php
			$prevcode=$DBusercode;
			$saveLetter=$letter;
			$aptCode="";
		} ?>
    </table>
    </td></tr></table>
    <br /><br />
<?php
}else{
	SM_blueBox("Sorry! No Results Found for: ".SM_d($search), 800, 21);
	echo "<br>";
}
$again=" Again";
}
?>
<?php SM_title("Search".$again, "btn_search32_reg.png", "?v=search"); ?>
<table class='cc800'><tr><td class='blueBanner1'>Search Clients by Last Name</td></tr>
<tr><td class='blueBanner2'><?php $search_what='clients'; include(plugin_dir_path( __FILE__ ) . "_form_search.php");?>

<table class='cc100'><tr>
<td class='nopad' style='width:25%;'><div class='navMenu'><a href='<?php echo $smadminl;?>&amp;v=appointments&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_listapt16_reg.png' class='btn' />List Appointments</a></div></td>
<td class='nopad' style='width:18%;'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=clients&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_clients16_reg.png' class='btn' />List Clients</a></div></td>
<td class='nopad' style='width:19%;'><div class='navMenu'><a href='<?php echo $smadmin;?>&amp;v=home&amp;' class='sked'><img src='<?php echo $sm_btns_dir;?>btn_home16_reg.png' class='btn'/>Admin Home</a></div></td>
<td class='nopad' style='width:38%;'>&nbsp;</td>
</tr></table>

</td></tr>
</table>