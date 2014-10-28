<?php 
SM_title("Color Scheme", "btn_colors32_reg.png", $smadmin."&v=colors&");
if ($_SERVER['REQUEST_METHOD']=='POST'){
	//=================================================
	//======= SKIN
	//=================================================
	$errorMessage="";
	if($_GET['op']=="color"){
		$skin=$_POST['skin'];
		$saveIt=mysql_query("UPDATE skedmaker_users SET skin='$skin'");
		$save_word="Color Scheme";
	}

	//=================================================
	//======= SKIN
	//=================================================
	$errorMessage="";
	if($_GET['op']=="customcolor"){
		$color1=$_POST['color1'];
		$color2=$_POST['color2'];
		$color3=$_POST['color2'];
		$highlight=$_POST['highlight'];

		$delete_codes=$_POST['delete_codes'];
		if($delete_codes==""){
			if($color1==""){$errorMessage="y"; $errorColor1="y";}
			if($color2==""){$errorMessage="y"; $errorColor2="y";}
			if($highlight==""){$errorMessage="y"; $errorHighlight="y";}
			if($errorMessage==""){
				$color1=SM_e($color1);
				$color2=SM_e($color2);
				$color3=SM_e($color2);
				$highlight=SM_e($highlight);
				$saveIt=mysql_query("UPDATE skedmaker_users SET color1='$color1', color2='$color2', color3='$color3', highlight='$highlight'");
				$save_word="Custom Colors";
			}
		}else{
			$saveIt=mysql_query("UPDATE skedmaker_users SET color1='', color2='', color3='', highlight=''");
			$save_word="Custom Colors";			
		}
	}

	if(!$saveIt){
		SM_redBox("Error, try again later.", 800, 21);	
		echo $saveIt;
	}else{
		SM_greenBox("Saved ".$save_word.".", 800, 21);
		SM_redirect($smadmin."&v=colors&", 500);
		die();
	}
}

$result=mysql_query("SELECT * FROM skedmaker_users");
while($row = mysql_fetch_array($result)) {
	$skin=SM_d($row['skin']);
	$color1=SM_d($row['color1']);
	$color2=SM_d($row['color2']);
	$color3=SM_d($row['color3']);
	$highlight=SM_d($row['highlight']);
}
?>
<form enctype="multipart/form-data" name="skins" method="post" action="<?php echo $smadmin;?>&amp;v=colors&amp;op=color&" style='margin-top:7px'>
<table class='cc800'>
<tr><td class='blueBanner1'>Color Scheme</td></tr>
<tr><td class='blueBanner2' style='padding:0px;'>
<?php SM_menu();?>
<table width='100%'>
<tr>
<td class='pad14'><b>Select the color scheme for your account:</b>
<select name="skin" id="skin" class='form_select'>
<option <?php if($skin=="Navy Blue"){?> selected="selected" <?php }?> >Navy Blue</option>
<option <?php if($skin=="Black"){?> selected="selected" <?php }?> >Black</option>
<option <?php if($skin=="Olive"){?> selected="selected" <?php }?> >Olive</option>
<option <?php if($skin=="Lovey"){?> selected="selected" <?php }?> >Lovey</option>
<option <?php if($skin=="Light Blue"){?> selected="selected" <?php }?> >Light Blue</option>
<option <?php if($skin=="Plum"){?> selected="selected" <?php }?> >Plum</option>
<option <?php if($skin=="Umber"){?> selected="selected" <?php }?> >Umber</option>
<option <?php if($skin=="Dusk"){?> selected="selected" <?php }?> >Dusk</option>
<option <?php if($skin=="Tibet"){?> selected="selected" <?php }?> >Tibet</option>
<option <?php if($skin=="Adirondacks"){?> selected="selected" <?php }?> >Adirondacks</option>
<option <?php if($skin=="Sahara"){?> selected="selected" <?php }?> >Sahara</option>
<option <?php if($skin=="Acapulco"){?> selected="selected" <?php }?> >Acapulco</option>
<option <?php if($skin=="Beijing"){?> selected="selected" <?php }?> >Beijing</option>
</select>
<input type="submit" name="button" id="button" value="Save Color Scheme"></td></tr></table>
</td></tr></table>
</form>
<br />