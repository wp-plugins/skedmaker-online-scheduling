<?php 
if ($_SERVER['REQUEST_METHOD']=='POST' && $_GET['op']=="timezone"){
	$errorMessage="";
	$new_timezone=$_POST['timezone'];
	$daylight_savings=$_POST['daylight_savings'];
	if($new_timezone==""){$errorMessage="y"; $errorTimezone='y';}

	if($errorMessage==""){
		$saveIt=mysql_query("UPDATE skedmaker_users SET timezone='$new_timezone', daylight_savings='$daylight_savings'");
		if(!$saveIt){
			SM_redBox("Error! Could not save timezone, try again later.", 800, 21);
		}else{
			SM_greenBox("Saved Timezone!", 800, 21);
			SM_redirect ($smadmin."&v=timezone&", 500);
			die();
		}
	}
}
SM_title("Set Local Timezone", "btn_world32_reg.png", $smadmin."&amp;v=timezone&amp;");
?>
<form name="form_signup" method="post" action="<?php echo $smadmin;?>&amp;v=timezone&amp;op=timezone&amp;" style='margin: 0px; padding: 0px;'>
<table class='cc800'><tR><td class='blueBanner1'>Select yout timezone below</td></tr>
<tr><td class='blueBanner2' style='padding:0px;'>
<?php SM_menu();?>
<table class='cc100'>
<tr>
<td class='pad14' colspan='2'><strong>Your server is reporting a present date and time of: </strong><?php echo SM_apt(SM_ts());?></td></tr>
<td class='pad14' colspan='2' style='padding-top:0px;'><strong>Your Skedmaker local date and time are: </strong>
<?php 
$d2=SM_ts();
if($timezone!=""){
	$d3=strtotime("$timezone hours", $d2);
}else{
	$d3=$d2;
}
echo SM_apt($d3);?></td></tr>

<tr><td class='label200'>
<?php if($errorTimezone!=""){echo "<span class='redText'>Modify Time by:</span>";}else{echo "<b>Modify Time by:</b>";}?>
</td>
<td colspan="2" class='pad7'>
<select name='timezone' id='timezone' style='width:100px' class='form_select'>
    <?php for($x=-24; $x<25; $x++){
		if($x>=0){$tzval="+".$x;}else{$tzval=$x;}
		?>
      <option <?php if($timezone==$tzval){?> selected="selected" <?php }?> ><?php echo $tzval; ?></option>
<?php } ?>
    </select> Hours
</td></tr>


<tr><td class='label200'><?php SM_check_text("Use Daylight Savings:", $errorDaylightSavings);?></td>
<td colspan="2" class='pad7'><input type="checkbox" name="daylight_savings" id="daylight_savings" value='y' <?php if($daylight_savings=="y"){?> checked='checked' <?php } ?>/> <label for="daylight_savings">Check here to automatically apply Daylight Savings Time.</label></td></tr>

<tr>
<td class='label200'>PLEASE NOTE: <?php $is_in_DST=date("I", time());?></td>
<td colspan="2" class='pad7'><?php if($is_in_DST==0){echo "You are in currently in Standard Time. Check the box above to automatically make changes when you get into Daylight Savings Time.";}else{echo "You are currently in Daylight Savings Time.";}?></td></tr>

    
<tr><td>&nbsp;</td><td class='pad7'><input type="submit" name="button" id="button" value="Save Changes" /></td></tr></table>
</td></tr></table>
	</form>