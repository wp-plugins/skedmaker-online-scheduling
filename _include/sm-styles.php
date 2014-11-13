<?php 
/// color defaults are saved in sm-settings.php 
$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
$css_img_dir=$sm_btns_dir;
$round=" -moz-border-radius:7px !important; -webkit-border-radius:7px !important; border-radius:7px !important; overflow:hidden !important;";
?>
<style type="text/css">
/* *********************************************************************************************************START STYLES **********************************************************************/

body,td,th {font-family:Verdana, Geneva, sans-serif;font-size:14px; color:#000; margin:0px}
h3 {margin:0px;padding:0px;}

/*=================================================
======= IMAGES =======
=================================================*/
img.btn {border:none; margin-right:7px; vertical-align:middle;}

/*=================================================
======= FORMS=======
=================================================*/
.form_textfield{
	border:1px solid #999 !important;
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	color:#333333;
	<?php if(!wp_is_mobile()){ ?>width:450px; <?php }else{ ?>width:100%; <?php } ?>
	padding:7px;
	height:35px;
	vertical-align:middle;
	<?php echo $round;?>
}

.form_textfield_cap{
	border:1px solid #999 !important;
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	color:#333333;
	<?php if(!wp_is_mobile()){ ?>width:100px; <?php }else{ ?>width:100%; <?php } ?>
	padding:7px;
	height:35px;
	vertical-align:middle;
	<?php echo $round;?>
}

.form_area{
	border:1px solid #999999 !important;
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
	color:#333333;
	padding:14px;
	<?php if(!wp_is_mobile()){ ?>width:450px; <?php }else{ ?>width:100%; <?php } ?>
	<?php echo $round;?>
}

.form_select{
	border:1px solid #999999 !important;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	color:#333333;
	padding:5px;
	height:28px;
	-moz-border-radius:7px 0px 0px 7px;
    -webkit-border-radius:7px 0px 0px 7px;
    border-radius:7px 0px 0px 7px;
	padding-left:7px;
}

/*=================================================
======= LINKS =======
=================================================*/
a.sked:link 	{color:#000; text-decoration:none; font-weight:bold;}
a.sked:visited 	{color:#000; text-decoration:none; font-weight:bold;}
a.sked:hover 	{color:#<?php echo $b1_color;?>; text-decoration:none; font-weight:bold;}
a.sked:active 	{color:#366; text-decoration:none; font-weight:bold;}

a.skedblue:link 	{color:#06F; text-decoration:none; font-weight:bold;}
a.skedblue:visited 	{color:#06F; text-decoration:none; font-weight:bold;}
a.skedblue:hover 	{color:#06F; text-decoration:none; font-weight:bold;}
a.skedblue:active 	{color:#06F; text-decoration:none; font-weight:bold;}

a.b2w :link 	{color:#000; text-decoration:none; font-weight:regular;}
a.b2w :visited	{color:#000; text-decoration:none; font-weight:regular;}
a.b2w :hover	{color:#fff; text-decoration:none; font-weight:regular;}
a.b2w :active	{color:#fff; text-decoration:none; font-weight:regular;}

a.cancel:link {color:#F00;text-decoration:none; font-weight:normal;}
a.cancel:visited {text-decoration:none;color:#F00; font-weight:normal;}
a.cancel:hover {text-decoration:none;color:#F00; font-weight:normal;}
a.cancel:active {text-decoration:none;color:#F00; font-weight:normal;}

a.white:link {color:#FFF;text-decoration:none; font-weight:bold;}
a.white:visited {color:#FFF;text-decoration:none; font-weight:bold;}
a.white:hover {color:#FFF;text-decoration:none; font-weight:bold;}
a.white:active {color:#FFF;text-decoration:none; font-weight:bold;}

a.smallG:link {color:#666;text-decoration:none; font-weight:normal; font-size:10px}
a.smallG:visited {color:#666;text-decoration:none; font-weight:normal; font-size:10px}
a.smallG:hover {color:#233C49;text-decoration:none; font-weight:normal; font-size:10px}
a.smallG:active {color:#233C49;text-decoration:none; font-weight:normal; font-size:10px}

<!-- used only for the months menu on calendar -->
a.small:link {color:#000;text-decoration:none; font-weight:normal; font-size:10px}
a.small:visited {color:#000;text-decoration:none; font-weight:normal; font-size:10px}
a.small:hover {color:#000;text-decoration:none; font-weight:normal; font-size:10px}
a.small:active {color:#000;text-decoration:none; font-weight:normal; font-size:10px}

a.smallRed:link {color:#F33;text-decoration:none; font-weight:bold; font-size:10px}
a.smallRed:visited {color:#F33;text-decoration:none; font-weight:bold; font-size:10px}
a.smallRed:hover {color:#F00;text-decoration:none; font-weight:bold; font-size:10px}
a.smallRed:active {color:#F00;text-decoration:none; font-weight:bold; font-size:10px}

a.header:link {font-size:28px; font-weight:normal; color:#000; text-decoration:none;}
a.header:visited {font-size:28px; font-weight:normal; color:#000; text-decoration:none;}
a.header:hover {font-size:28px; font-weight:normal; color:#000; text-decoration:none;}
a.header:active {font-size:28px; font-weight:normal; color:#000; text-decoration:none;}

input[type=submit]{padding:7px;}

/*=================================================
======= HR =======
=================================================*/
hr {background-color:#366; color:#366; height:2px; border:0;}

/*=================================================
======= TABLES =======
=================================================*/
<?php 
if ( wp_is_mobile() ){ ?>
table.cc100{border:none; padding:0px; border-spacing:0px; width:100%; *border-collapse:expression('separate', cellSpacing = '0px') !important;  margin:0px !important;}
table.cc600{border:none; padding:0px; border-spacing:0px; width:100%; *border-collapse:expression('separate', cellSpacing = '0px') !important; margin:0px !important;}
table.cc800{border:none; padding:0px; border-spacing:0px; width:100%; *border-collapse:expression('separate', cellSpacing = '0px') !important; margin:0px !important;}

<?php }else{ ?>
table.cc100{border:none; padding:0px; border-spacing:0px; width:100%; *border-collapse:expression('separate', cellSpacing = '0px') !important; margin:0px;}
table.cc600{border:none; padding:0px; border-spacing:0px; width:600px; *border-collapse:expression('separate', cellSpacing = '0px') !important; margin:0px !important;}
table.cc800{border:none; padding:0px; border-spacing:0px; width:800px; *border-collapse:expression('separate', cellSpacing = '0px') !important; margin:0px;}

<?php } ?>

/*=================================================
======= TR =======
=================================================*/
tr.g666{background-color:#e9e9e9; <?php echo $round;?>}
tr.menu{background-color:#ccc; border-bottom:1px dotted #666;}

/*=================================================
======= TD =======
=================================================*/
td.menu{border-bottom:1px dotted #666; padding:0px;}
.gBox{ background-color:#E6E6E6; text-align:left; padding:5;}
td.redBox{background-color:#FCC;padding:14px;border:3px solid #F00; -moz-border-radius:7px !important; -webkit-border-radius:7px !important; border-radius:7px !important; overflow:hidden !important;}
td.greenBox{background-color:#CFC; padding:14px; border:3px solid #093; <?php echo $round;?>}
td.blueBox{padding:14px; text-align:center; background-color:#E2F8FE; border:3px solid #06F;<?php echo $round;?>}
td.btn{background-color:#88B3CA; border:1px solid #233C49; padding:0px; vertical-align:middle;}
td.orangeBox{background-color:#FFC; padding:14px; border:2px solid #F63; color:#F63; font-weight:bold; <?php echo $round;?>}

td.blueBanner1{
    -moz-border-radius-topleft:7px;
    -webkit-border-top-left-radius:7px;
    border-top-left-radius:7px;
    -moz-border-radius-topright:7px;
    -webkit-border-top-right-radius:7px;
    border-top-right-radius:7px;	
	overflow:hidden;
	background-color:#<?php echo $b1_color;?>;padding:7px 7px 7px 14px;color:#fff; font-weight:bold;
	<?php if(wp_is_mobile()){?>font-size:16px;<?php }else{?> font-size:18px; <?php } ?>text-align:left;
	border:none !important;
}

td.blueBanner2{
	 border:none !important;
	background-color:#<?php echo $b2_color;?> ;padding:10px; border:1px solid #<?php echo $b1_color; ?> !important; text-align:left;
    -moz-border-radius-bottomleft:7px !important;
    -webkit-border-bottom-left-radius:7px !important;
    border-bottom-left-radius:7px !important;
    -moz-border-radius-bottomright:7px !important;
    -webkit-border-bottom-right-radius:7px !important;
    border-bottom-right-radius:7px; !important;
	overflow:hidden !important;
}

td.b2-only{background-color:#<?php echo $b2_color;?>;padding:10px;border:1px solid #<?php echo $b1_color; ?>; text-align:left;<?php echo $round; ?>}

/*=================================================
======= PADDING TD
=================================================*/
td.nopad{padding:0px; text-align:left;border:none; }
td.pad5{padding:5px; text-align:left;border:none; }
td.pad7{padding:7px; text-align:left;border:none; }
td.pad10{padding:10px; text-align:left;border:none; }
td.pad14{padding:14px; text-align:left;border:none; }
td.pad21{padding:21px; text-align:left;border:none; }


/*=================================================
======= FORM LABEL TDs
=================================================*/

<?php if(wp_is_mobile()){
	$label150="15%";
}else{
	$label150="150px";	
}
?>

td.label50{padding:7px; text-align:right; font-weight:bold; vertical-align:middle; width:50px; font-size:10px;border:none; }
td.label100{padding:7px; text-align:right; font-weight:bold; vertical-align:middle; width:100px; font-size:14px;border:none; }
td.label100top{padding:7px; text-align:right; font-weight:bold; vertical-align:top; width:100px;border:none; }
td.label150{padding:7px; text-align:right; font-weight:bold; vertical-align:middle; width:15%;border:none; }
td.label150top{padding:7px; text-align:right; font-weight:bold; vertical-align:top; width:150px;border:none; }
td.label150s{padding:5px; text-align:right; font-weight:bold; vertical-align:middle; width:150px; font-size:10px;border:none; }
td.label200{padding:7px; text-align:right; font-weight:bold; vertical-align:middle; width:200px; font-size:14px;border:none; }
td.label200s{padding:7px; text-align:right; font-weight:bold; vertical-align:middle; width:200px; font-size:10px;border:none; }
td.label200top{padding:7px; text-align:right; font-weight:bold; vertical-align:top; width:200px; font-size:14px;border:none; }
td.label250{padding:7px; text-align:right; font-weight:bold; vertical-align:middle; width:250px;border:none; }
td.label250top{padding:7px; text-align:right; font-weight:bold; vertical-align:top; width:250px;border:none; }
td.label300{padding:7px; text-align:right; font-weight:bold; vertical-align:middle; width:300px;border:none; }
td.login_label{padding:7px; text-align:right; font-weight:bold; vertical-align:middle;border:none; }

/*=================================================
======= DOTTED TDs
=================================================*/
td.dot{padding:7px; border-bottom:1px dotted #666;}
td.dot50{padding:7px; border-bottom:1px dotted #666;width:50px}
td.dot100{padding:7px; border-bottom:1px dotted #666;width:100px}
td.dot150{padding:7px; border-bottom:1px dotted #666;width:150px}
td.dot200{padding:7px; border-bottom:1px dotted #666;width:200px}
td.dot250{padding:7px; border-bottom:1px dotted #666;width:250px}
td.dot300{padding:7px; border-bottom:1px dotted #666;width:300px}
td.dot350{padding:7px; border-bottom:1px dotted #666;width:350px}
td.dot400{padding:7px; border-bottom:1px dotted #666;width:400px}
td.dot450{padding:7px; border-bottom:1px dotted #666;width:450px}
td.dot500{padding:7px; border-bottom:1px dotted #666;width:500px}
td.dot550{padding:7px; border-bottom:1px dotted #666;width:550px}
td.dot600{padding:7px; border-bottom:1px dotted #666;width:600px}
td.dot650{padding:7px; border-bottom:1px dotted #666;width:650px}
td.dot700{padding:7px; border-bottom:1px dotted #666;width:700px}
td.dot750{padding:7px; border-bottom:1px dotted #666;width:750px}
td.dot800{padding:7px; border-bottom:1px dotted #666;width:800px}

/*=================================================
======= CALENDAR STYLES
=================================================*/
<?php 
if(wp_is_mobile()){
	$smCALbasics="width:10% !important; text-align:center; font-weight:bold; margin:0px;";
	$day_pad="7px";
}else{
	$day_pad="14px";
	$smCALbasics="width:72px !important; text-align:center; font-weight:bold; margin:0px;";
}?>
td.weekday					{padding:5px; width:10%; text-align:center;}
td.calendarDay				{<?php echo $smCALbasics;?> background-color:#<?php echo $b3_color;?>; border:1px solid #<?php echo $b1_color;?>; padding:0px; }
td.calendarBlank			{<?php echo $smCALbasics;?> background-color:#e9e9e9; border:1px solid #666; color:#666; padding:<?php echo $day_pad;?>;}
td.calendarAdminBlank		{<?php echo $smCALbasics;?> background-color:#e9e9e9; border:1px solid #666; color:#666; padding:0px;}
td.calendarPassed			{<?php echo $smCALbasics;?> background-color:#e9e9e9; border:1px solid #666; color:#666; padding:<?php echo $day_pad;?>;}
td.calendarBlocked			{<?php echo $smCALbasics;?> background-color:#FCC;    border:1px solid #F00; color:#F00; padding:0px; }
td.calendarBlockedBlackouts	{text-align:center; font-weight:bold; margin:0px; background-color:#FCC;    border:1px solid #F00; color:#F00; padding:<?php echo $day_pad;?>; }


td.menumonths{
	background-color:#<?php echo $b1_color;?>;
	padding:0px !important;
	padding-bottom:3px !important;
	border:none;
	margin:0px !important;
}

.navDay a:link				{display:block;	color:#000; text-decoration:none; border:1px solid #<?php echo $b3_color;?>; padding:<?php echo $day_pad;?>; background-color:#<?php echo $b3_color;?>; margin:0px;}
.navDay a:visited			{display:block;	color:#000; text-decoration:none; border:1px solid #<?php echo $b3_color;?>; padding:<?php echo $day_pad;?>; background-color:#<?php echo $b3_color;?>; margin:0px;}
.navDay a:hover				{display:block;	color:#000; text-decoration:none; border:1px solid #<?php echo $b1_highlight;?>; padding:<?php echo $day_pad;?>; background-color:#<?php echo $b1_highlight;?>; color:#fff; margin:0px !important;}
.navDay a:active			{display:block;	color:#000; text-decoration:none; border:1px solid #<?php echo $b1_highlight;?>; padding:<?php echo $day_pad;?>; background-color:#<?php echo $b1_highlight;?>; color:#fff; margin:0px;}

.navDayUnavail a:link		{display:block;	color:#000; text-decoration:none; padding:none; background-color:#ccc}
.navDayUnavail a:visited	{display:block;	color:#000; text-decoration:none; padding:none; background-color:#ccc}
.navDayUnavail a:hover		{display:block;	color:#000; text-decoration:none; padding:none; background-color:#ccc;}
.navDayUnavail a:active		{display:block;	color:#000; text-decoration:none; padding:none; background-color:#ccc;}

.navCalBlank a:link		{display:block;	color:#000; text-decoration:none; padding:<?php echo $day_pad;?>; background-color:#ccc; border:1px solid #ccc; margin:0px;}
.navCalBlank a:visited	{display:block;	color:#000; text-decoration:none; padding:<?php echo $day_pad;?>; background-color:#ccc; border:1px solid #ccc; margin:0px;}
.navCalBlank a:hover	{display:block;	color:#fff; text-decoration:none; padding:<?php echo $day_pad;?>; background-color:#666; border:1px solid #666; margin:0px;}
.navCalBlank a:active	{display:block;	color:#fff; text-decoration:none; padding:<?php echo $day_pad;?>; background-color:#666; border:1px solid #666; margin:0px;}

.navBlocked a:link		{display:block;	color:#F00; text-decoration:none; border:1px solid #FCC; padding:<?php echo $day_pad;?>; background-color:#FCC; background-image:url("<?php echo $css_img_dir;?>btn_block16_reg.png"); background-repeat:no-repeat; background-position:right;}
.navBlocked a:visited	{display:block;	color:#F00; text-decoration:none; border:1px solid #FCC; padding:<?php echo $day_pad;?>; background-color:#FCC; }
.navBlocked a:hover		{display:block;	color:#FFF; text-decoration:none; border:1px solid #F00; padding:<?php echo $day_pad;?>; background-color:#F00; }
.navBlocked a:active	{display:block;	color:#FFF; text-decoration:none; border:1px solid #00; padding:<?php echo $day_pad;?>; background-color:#F00; }

.navBlackouts a:link		{display:block;	color:#F00; text-decoration:none; border:1px solid #FCC; padding:<?php echo $day_pad;?>; background-color:#FCC; background-image:url("<?php echo $css_img_dir;?>btn_blackout16_reg.png"); background-repeat:no-repeat; background-position:right;}
.navBlackouts a:visited	{display:block;	color:#F00; text-decoration:none; border:1px solid #FCC; padding:<?php echo $day_pad;?>; background-color:#FCC; }
.navBlackouts a:hover		{display:block;	color:#FFF; text-decoration:none; border:1px solid #F00; padding:<?php echo $day_pad;?>; background-color:#F00; }
.navBlackouts a:active	{display:block;	color:#FFF; text-decoration:none; border:1px solid #00; padding:<?php echo $day_pad;?>; background-color:#F00; }

.navCustom a:link		{display:block;	color:#000; text-decoration:none; border:1px solid #090; padding:<?php echo $day_pad;?>; background-color:#6C6; background-image:url("<?php echo $css_img_dir;?>btn_custom16_reg.png"); background-repeat:no-repeat; background-position:right;}
.navCustom a:visited	{display:block;	color:#000; text-decoration:none; border:1px solid #090; padding:<?php echo $day_pad;?>; background-color:#6C6;}
.navCustom a:hover		{display:block;	color:#FFF; text-decoration:none; border:1px solid #090; padding:<?php echo $day_pad;?>; background-color:#096;}
.navCustom a:active		{display:block;	color:#FFF; text-decoration:none; border:1px solid #090; padding:<?php echo $day_pad;?>; background-color:#096;}


/*=================================================
======= COLUMN HEADERS ON LISTS
=================================================*/
.tab{
	background-color:#<?php echo $b1_color;?>;
	text-align:left;
	font-weight:bold;
	color:#fff;
	font-size:14px;
	padding:0px; 
}

.tab-left{
	background-color:#<?php echo $b1_color;?>;
	text-align:left;
	font-weight:bold;
	color:#fff;
	font-size:14px;
	padding:0px; 
	border-left:1px solid #<?php echo $b1_color;?>;
    -moz-border-radius-topleft:7px;
    -webkit-border-top-left-radius:7px;
    border-top-left-radius:7px;
}

.tab-right{
	background-color:#<?php echo $b1_color;?>;
	text-align:left;
	font-weight:bold;
	color:#fff;
	font-size:14px;
	padding:0px; 
    -moz-border-top-right-radius:7px;
    -webkit-border-top-right-radius:7px;
    border-top-right-radius:7px;
}

.tab-bottom-right{
	background-color:#<?php echo $b1_color;?>;
	text-align:left;
	font-weight:bold;
	color:#fff;
	font-size:14px;
	padding:0px; 
	
    -moz-border-bottom-right-radius:7px;
    -webkit-border-bottom-right-radius:7px;
    border-bottom-right-radius:7px;
}

.tab-bottom-left{
	background-color:#<?php echo $b1_color;?>;
	text-align:left;
	font-weight:bold;
	color:#fff;
	font-size:14px;
	padding:0px; 
	
    -moz-border-bottom-left-radius:7px;
    -webkit-border-bottom-left-radius:7px;
    border-bottom-left-radius:7px;
}

/*=================================================
======= LIST ITEM TDs 
=================================================*/
td.list_left{border-left:1px solid #<?php echo $b1_color;?>; padding:0px; border-right:1px dotted #666; text-align:left;}
td.list_center{border-right:1px dotted #666;  padding-left:14px; text-align:left;}
td.list_right{border-right:1px solid #<?php echo $b1_color;?>; padding:7px;}
td.list_bottom{border-top:1px solid #<?php echo $b1_color;?>; padding:0px;}

/*=================================================
======= SMALL MENU BUTTONS
=================================================*/
td.g666{background-color:#<?php echo $b3_color;?>; padding:0px; border:1px solid #000; text-align:center; vertical-align:middle; margin:0px; <?php echo $round;?>}

/*=================================================
======= TEXT =======
=================================================*/
.header {font-size:28px; font-weight:normal; color:#000;}
.redText {font-family:Verdana; font-size:14px; color:#F00; font-weight:bold;}
.greenText {font-family:Verdana; font-size:14px; color:#009900;font-weight:bold;}
.blueText {font-family:Verdana; font-size:14px; color:#06F;font-weight:bold;}
.smallRed{font-family:Verdana; font-size:10px; color:#F00; font-weight:bold;}
.smallGreen{font-family:Verdana; font-size:10px;  color:#009900; font-weight:bold;}
.smallBlue{font-family:Verdana; font-size:10px; color:#06F; font-weight:bold;}
.smallText {font-family:Verdana; font-size:10px; color:#000;}
.smallBold {font-family:Verdana; font-size:10px; color:#000; font-weight:bold;}
.smallG{font-family:Verdana; font-size:10px; color:#666;}
.smallG12{font-family:Verdana; font-size:12px; color:#666;}
.whiteText {font-family:Verdana; font-size:14px; color:#FFF; font-weight:bold;}
.smallWhite{font-family:Verdana; font-size:10px; color:#FFF;}
.whiteBold{font-family:Verdana; font-size:14px;color:#FFF; font-weight:bold;}
.headerBold{font-family:Verdana, Geneva, sans-serif; font-size:18px;font-weight:bold;color:#000;}

/*=================================================
======= NAVS =======
=================================================*/
.navb1 a:link			{display:block;	background-color:#<?php echo $b1_color;?>; 			color:#fff; text-decoration:none; padding:7px; padding-left:14px;text-align:left;<?php echo $round; ?>}
.navb1 a:visited		{display:block;	background-color:#<?php echo $b1_color;?>; 			color:#fff; text-decoration:none; padding:7px; padding-left:14px; text-align:left;<?php echo $round; ?>}
.navb1 a:hover			{display:block;	background-color:#<?php echo $b1_highlight;?>;		color:#fff; text-decoration:none; padding:7px; padding-left:14px; text-align:left;<?php echo $round; ?>}
.navb1 a:active			{display:block;	background-color:#<?php echo $b1_highlight;?>;		color:#fff; text-decoration:none; padding:7px; padding-left:14px; text-align:left;<?php echo $round; ?>}

.navNotes a:link	{display:block;	background-color:none; text-decoration:none; color:#fff; padding:7px; padding-left:14px;}
.navNotes a:visited	{display:block;	background-color:none; text-decoration:none; color:#fff; padding:7px; padding-left:14px;}
.navNotes a:hover	{display:block;	background-color:#<?php echo $b1_highlight;?>;	text-decoration:none; color:#fff; padding:7px; padding-left:14px;}
.navNotes a:active	{display:block;	background-color:#<?php echo $b1_highlight;?>;	text-decoration:none; color:#fff; padding:7px; padding-left:14px;}

.navMenu a:link		{display:block;	background-color:none; text-decoration:none; color:#000; padding:7px; cursor:pointer;margin:0px;}
.navMenu a:visited	{display:block;	background-color:none; text-decoration:none; color:#000; padding:7px; cursor:pointer;}
.navMenu a:hover	{display:block;	background-color:#<?php echo $b1_highlight;?>;	text-decoration:none; color:#fff; padding:7px; cursor:pointer;}
.navMenu a:active	{display:block;	background-color:#<?php echo $b1_highlight;?>;	text-decoration:none; color:#fff; padding:7px; cursor:pointer;}

.navMenuSM a:link		{display:block;	background-color:none; text-decoration:none; color:#000; padding:7px; cursor:pointer; margin:0px;}
.navMenuSM a:visited	{display:block;	background-color:none; text-decoration:none; color:#000; padding:7px; cursor:pointer;}
.navMenuSM a:hover	{display:block;	background-color:#<?php echo $b1_highlight;?>;	text-decoration:none; color:#fff; padding:7px; cursor:pointer;}
.navMenuSM a:active	{display:block;	background-color:#<?php echo $b1_highlight;?>;	text-decoration:none; color:#fff; padding:7px; cursor:pointer;}

.navMenuRound a:link	{display:block;	background-color:none; text-decoration:none; color:#000; padding:7px; cursor:pointer; <?php echo $round; ?>}
.navMenuRound a:visited	{display:block;	background-color:none; text-decoration:none; color:#000; padding:7px; cursor:pointer; <?php echo $round; ?>}
.navMenuRound a:hover	{display:block;	background-color:#<?php echo $b1_highlight;?>;	text-decoration:none; color:#fff; padding:7px; cursor:pointer; <?php echo $round; ?>}
.navMenuRound a:active	{display:block;	background-color:#<?php echo $b1_highlight;?>;	text-decoration:none; color:#fff; padding:7px; cursor:pointer; <?php echo $round; ?>}

.nav666 a:link		{display:block;	background-color:none; 		text-decoration:none; padding:4px; color:#e9e9e9; font-size:10px; <?php echo $round;?>}
.nav666 a:visited	{display:block;	background-color:none; 		text-decoration:none; padding:4px;color:#e9e9e9; font-size:10px; <?php echo $round;?>}
.nav666 a:hover		{display:block;	background-color:#<?php echo $b1_highlight;?>;	text-decoration:none; padding:4px;color:#fff; font-size:10px; <?php echo $round;?>}
.nav666 a:active	{display:block;	background-color:#<?php echo $b1_highlight;?>;	text-decoration:none; padding:4px;color:#fff; font-size:10px; <?php echo $round;?>}

.navGreen a:link	{display:block;	background-color:#090; text-decoration:none; padding:7px; color:#fff;}
.navGreen a:visited	{display:block;	background-color:#090; text-decoration:none; padding:7px; color:#fff;}
.navGreen a:hover	{display:block;	background-color:#0C0;	text-decoration:none; padding:7px; color:#fff;}
.navGreen a:active	{display:block;	background-color:#0C0;	text-decoration:none; padding:7px; color:#fff;}

.navRed a:link		{height:100%; display:block;	background-color:#900;	text-decoration:none; padding:7px; color:#fff;}
.navRed a:visited	{height:100%; display:block;	background-color:#900; text-decoration:none; padding:7px; color:#fff;}
.navRed a:hover		{height:100%; display:block;	background-color:#F03;	text-decoration:none; padding:7px; color:#fff;}
.navRed a:active	{height:100%; display:block;	background-color:#F03;	text-decoration:none; padding:7px; color:#fff;}

.navRedRound a:link		{height:100%; display:block;	background-color:#900;	text-decoration:none; padding:7px; color:#fff; <?php echo $round;?>}
.navRedRound a:visited	{height:100%; display:block;	background-color:#900; text-decoration:none; padding:7px; color:#fff; <?php echo $round;?>}
.navRedRound a:hover		{height:100%; display:block;	background-color:#F03;	text-decoration:none; padding:7px; color:#fff; <?php echo $round;?>}
.navRedRound a:active	{height:100%; display:block;	background-color:#F03;	text-decoration:none; padding:7px; color:#fff; <?php echo $round;?>}

.navCancel a:link		{height:100%; display:block;	background-color:none;	text-decoration:none; padding:7px; color:#000; <?php echo $round;?>}
.navCancel a:visited	{height:100%; display:block;	background-color:none; text-decoration:none; padding:7px; color:#000; <?php echo $round;?>}
.navCancel a:hover		{height:100%; display:block;	background-color:#F03;	text-decoration:none; padding:7px; color:#fff; <?php echo $round;?>}
.navCancel a:active		{height:100%; display:block;	background-color:#F03;	text-decoration:none; padding:7px; color:#fff; <?php echo $round;?>}

.navPurge a:link	{height:100%; display:block; text-decoration:none; background-color:#none; padding:7px; color:#000;<?php echo $round;?>} 
.navPurge a:visited	{height:100%; display:block; text-decoration:none; background-color:#none; padding:7px; color:#000;<?php echo $round;?>} 
.navPurge a:hover	{height:100%; display:block; text-decoration:none; background-color:#F00; color:#fff; padding:7px;<?php echo $round;?>} 
.navPurge a:active	{height:100%; display:block; text-decoration:none; background-color:#<?php echo $b1_highlight;?>; color:#FFF; padding:7px <?php echo $round;?>}

.navBlue a:link		{height:100%; display:block;	background-color:#09F;	text-decoration:none; padding:7px; color:#fff;}
.navBlue a:visited	{height:100%; display:block;	background-color:#09F; text-decoration:none; padding:7px; color:#fff;}
.navBlue a:hover	{height:100%; display:block;	background-color:#0CF;	text-decoration:none; padding:7px; color:#fff;}
.navBlue a:active	{height:100%; display:block;	background-color:#0CF;	text-decoration:none; padding:7px; color:#fff;}

.navPurple a:link		{display:block;	background-color:#636; 	text-decoration:none; padding:7px; color:#fff; }
.navPurple a:visited	{display:block;	background-color:#636; 	text-decoration:none; padding:7px color:#fff; }
.navPurple a:hover		{display:block;	background-color:#bd0df0;	text-decoration:none; padding:7px color:#fff; }
.navPurple a:active		{display:block;	background-color:#bd0df0;	text-decoration:none; padding:7px color:#fff; }

.navYellow a:link		{display:block;	background-color:#FC6;	text-decoration:none; padding:7px; color:#000;}
.navYellow a:visited	{display:block;	background-color:#FC6;	text-decoration:none; padding:7px; color:#000;}
.navYellow a:hover		{display:block;	background-color:#FFC;	text-decoration:none; padding:7px; color:#000;}
.navYellow a:active		{display:block;	background-color:#FFC;	text-decoration:none; padding:7px; color:#000;}

#button{
    background-color:#<?php echo $b1_color;?>;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border-radius:6px;
    color:#fff;
    font-size:14px;
    text-decoration:none;
    cursor:pointer;
    border:none;
	padding:7px;
	padding-left:28px;
	padding-right:14px;
	background:#<?php echo $b1_color;?> url("<?php echo $css_img_dir;?>btn_save16_g.png") no-repeat scroll 5px center;
}
#button:hover {
    border:none;
	background:#<?php echo $b1_highlight;?> url("<?php echo $css_img_dir;?>btn_save16_reg.png") no-repeat scroll 5px center;
    box-shadow:0px 0px 1px #777;
}


#purge {
	border:2px solid #F00;
	padding:7px;
	color:#fff;
	font-weight:bold; cursor:pointer;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border-radius:6px;
    color:#fff;
    font-size:14px;
    text-decoration:none;
    cursor:pointer;
    border:none;
	padding:7px;
	padding-left:28px;
	padding-right:14px;
	background:#C30 url("<?php echo $css_img_dir;?>btn_purge16_g.png") no-repeat scroll 5px center;
}
#purge:hover {
    border:none;
    box-shadow:0px 0px 1px #777;
	background:#F60 url("<?php echo $css_img_dir;?>btn_purge16_reg.png") no-repeat scroll 5px center;
}

#mainSave {
    background-color:#<?php echo $b1_color;?>;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border-radius:6px;
    color:#fff;
    font-size:14px;
    text-decoration:none;
    cursor:pointer;
    border:none;
	padding:7px;
	padding-left:28px;
	padding-right:14px;
	background:#<?php echo $b1_color;?> url("<?php echo $css_img_dir;?>btn_confirm16_g.png") no-repeat scroll 5px center;
}
#mainSave:hover {
    border:none;
    box-shadow:0px 0px 1px #777;
	background:#<?php echo $b1_highlight;?> url("<?php echo $css_img_dir;?>btn_confirm16_reg.png") no-repeat scroll 5px center;

}

#block {
    background-color:#<?php echo $b1_color;?>;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border-radius:6px;
    color:#fff;
    font-size:14px;
    text-decoration:none;
    cursor:pointer;
    border:none;
	padding:7px;
	padding-left:28px;
	padding-right:14px;
	background:#<?php echo $b1_color;?> url("<?php echo $css_img_dir;?>btn_block16_g.png") no-repeat scroll 5px center;
}

#block:hover {
    border:none;
    box-shadow:0px 0px 1px #777;
	background:#<?php echo $b1_highlight;?> url("<?php echo $css_img_dir;?>btn_block16_reg.png") no-repeat scroll 5px center;
}

#cancel {
    background-color:#<?php echo $b1_color;?>;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border-radius:6px;
    color:#fff;
    font-size:14px;
    text-decoration:none;
    cursor:pointer;
    border:none;
	padding:7px;
	padding-left:28px;
	padding-right:14px;
	background:#<?php echo $b1_color;?> url("<?php echo $css_img_dir;?>btn_cancel16_g.png") no-repeat scroll 5px center;
}

#cancel:hover {
    border:none;
    box-shadow:0px 0px 1px #777;
	background:#<?php echo $b1_highlight;?> url("<?php echo $css_img_dir;?>btn_cancel16_reg.png") no-repeat scroll 5px center;
}

#login {
    background-color:#<?php echo $b1_color;?>;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border-radius:6px;
    color:#fff;
    font-size:14px;
    text-decoration:none;
    cursor:pointer;
    border:none;
	padding:7px;
	padding-left:28px;
	padding-right:14px;
	background:#<?php echo $b1_color;?> url("<?php echo $css_img_dir;?>btn_key16_reg.png") no-repeat scroll 5px center;
}

#login:hover {
    border:none;
	background-color:#<?php echo $b1_highlight;?>;
    box-shadow:0px 0px 1px #777;
}

#contact {
    background-color:#<?php echo $b1_color;?>;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border-radius:6px;
    color:#fff;
    font-size:14px;
    text-decoration:none;
    cursor:pointer;
    border:none;
	padding-left:28px;
	padding-right:14px;
	background:#<?php echo $b1_color;?> url("<?php echo $css_img_dir;?>btn_sendmail16_reg.png") no-repeat scroll 5px center;
}

#contact:hover {
    border:none;
	background-color:#<?php echo $b1_highlight;?>;
    box-shadow:0px 0px 1px #777;
}

#trash {
    background-color:#<?php echo $b1_color;?>;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border-radius:6px;
    color:#fff;
    font-size:14px;
    text-decoration:none;
    cursor:pointer;
    border:none;
	padding-left:28px;
	padding-right:14px;
	background:#900 url("<?php echo $css_img_dir;?>btn_delete16_reg.png") no-repeat scroll 5px center;
}

#trash:hover {
    border:none;
    box-shadow:0px 0px 1px #777;
	background:#F00 url("<?php echo $css_img_dir;?>btn_delete16_reg.png") no-repeat scroll 5px center;
}

#embed{
    background-color:#<?php echo $b1_color;?>;
    -moz-border-radius:5px;
    -webkit-border-radius:5px;
    border-radius:6px;
    color:#fff;
    font-size:14px;
    text-decoration:none;
    cursor:pointer;
    border:none;
	padding:7px;
	padding-left:28px;
	padding-right:14px;
	background:#<?php echo $b1_color;?> url("<?php echo $css_img_dir;?>btn_copy16_reg.png") no-repeat scroll 5px center;
}

#embed:hover {
    border:none;
    box-shadow:0px 0px 1px #777;
	background:#<?php echo $b1_highlight;?> url("<?php echo $css_img_dir;?>btn_copy16_reg.png") no-repeat scroll 5px center;
}
/* *********************************************************************************************************END STYLES **********************************************************************/
</style>