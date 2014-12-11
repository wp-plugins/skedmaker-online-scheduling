<?php
/// color defaults are loaded in _include/sm-settings.php
$sm_btns_dir=plugin_dir_url(dirname( __FILE__) )."/_btns/";
$round=" -moz-border-radius:7px !important; -webkit-border-radius:7px !important; border-radius:7px !important; overflow:hidden !important;";
?>
<style type="text/css">
/* ================================================= START SKEDMAKER STYLES =================================================*/

/*=================================================
======= BTN IMAGES =======
=================================================*/
img.btn{
	border:none !important;
	margin-right:7px !important;
	vertical-align:middle !important;
}

.SM-anchor{
   position:relative;
   top:-150px;
   visibility:hidden;
}

/*=================================================
======= FORMS=======
=================================================*/
.form_textfield{
	border:1px solid #999 !important;
	color:#333333 !important;
	font-family:Arial, Helvetica, sans-serif !important;
	font-size:14px !important;
	height:35px !important;
	padding:7px !important;
	<?php if(!wp_is_mobile()){ ?>width:450px !important; <?php }else{ ?>width:100% !important; <?php } ?>
	vertical-align:middle !important;
	<?php echo $round;?>
}

/*specific for the textfield in the text-check capture */
.form_textfield_cap{
	border:1px solid #999 !important;
	color:#333333 !important;
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px !important;
	height:35px !important;
	padding:7px !important;
	vertical-align:middle !important;
	<?php if(!wp_is_mobile()){ ?>width:100px !important; <?php }else{ ?>width:100% !important; <?php } ?>
	<?php echo $round;?>
}

.form_area{
	border:1px solid #999999 !important;
	color:#333333 !important;
	font-family:Arial, Helvetica, sans-serif !important;
	font-size:14px !important;
	padding:14px !important;
	<?php if(!wp_is_mobile()){ ?>width:450px; <?php }else{ ?>width:100%; <?php } ?>
	<?php echo $round;?>
}

.form_select{
	border:1px solid #999999 !important;
	color:#333333 !important;
	font-family:Arial, Helvetica, sans-serif !important;
	font-size:12px !important;
	height:28px !important;
	padding:7px !important;
    border-radius:7px 0px 0px 7px !important;
	-moz-border-radius:7px 0px 0px 7px !important;
    -webkit-border-radius:7px 0px 0px 7px !important;
}

/*=================================================
======= LINKS =======
=================================================*/
a.sked:link{
	background-color:transparent !important;
	color:#000 !important;
	font-size:14px !important;
	font-weight:bold !important;
	margin:0px !important;
	text-decoration:none !important;
}
a.sked:visited{
	background-color:transparent !important;
	color:#000 !important;
	font-size:14px !important;
	font-weight:bold !important;
	margin:0px !important;
	text-decoration:none !important;
}
a.sked:hover{
	background-color:transparent !important;
	color:#<?php echo $b1_color;?> !important;
	font-size:14px !important;
	font-weight:bold !important;
	margin:0px !important;
	text-decoration:none !important;
}
a.sked:active{
	background-color:transparent !important;
	color:#366 !important;
	font-weight:bold !important;
	font-size:14px !important;
	margin:0px !important;
	text-decoration:none !important;
}

a.calDayActive:link{
	background-color:transparent !important;
	color:#000 !important;
	font-weight:bold !important;
	text-decoration:none !important;
}
a.calDayActive:visited{
	background-color:transparent !important;
	color:#000 !important;
	text-decoration:none !important;
	font-weight:bold !important;
}
a.calDayActive:hover{
	background-color:transparent !important;
	color:#FFF !important;
	text-decoration:none !important;
	font-weight:bold !important;
}
a.calDayActive:active{
	background-color:transparent !important;
	color:#FFF !important;
	text-decoration:none !important;
	font-weight:bold !important;
}

/* ======= used only on calendar months menu */
a.calMonths:link{
	color:#000 !important;
	font-weight:bold !important;
	text-decoration:none !important;
}
a.calMonths:visited{
	color:#000 !important;
	font-weight:bold !important;
	text-decoration:none !important;
}
a.calMonths:hover{
	color:#FFF !important;
	font-weight:bold !important;
	text-decoration:none !important;
}
a.calMonths:active{
	color:#FFF !important;
	font-weight:bold !important;
	text-decoration:none !important;
}

/* ======= used only on the blueBox for links*/
a.skedblue:link{
	color:#06F !important;
	font-weight:bold !important;
	text-decoration:none !important;
}
a.skedblue:visited{
	color:#06F !important;
	font-weight:bold !important;
	text-decoration:none !important;
}
a.skedblue:hover{
	color:#06F !important;
	font-weight:bold !important;
	text-decoration:none !important;
}
a.skedblue:active{
	color:#06F !important;
	font-weight:bold !important;
	text-decoration:none !important;
}

a.b2w:link{
	color:#000 !important;
	text-decoration:none !important;
	font-weight:regular !important;
}
a.b2w:visited{
	color:#000 !important;
	font-weight:regular !important;
	text-decoration:none !important;
}
a.b2w:hover{
	color:#fff !important;
	font-weight:regular !important;
	text-decoration:none !important;
}
a.b2w:active{
	color:#fff !important;
	font-weight:regular !important;
	text-decoration:none !important;
}

a.cancel:link{
	color:#F00 !important;
	font-weight:normal !important;
	text-decoration:none !important;
}
a.cancel:visited{
	color:#F00 !important;
	font-weight:normal !important;
	text-decoration:none !important;
}
a.cancel:hover{
	color:#F00 !important;
	font-weight:normal !important;
	text-decoration:none !important;
}
a.cancel:active{
	color:#F00 !important;
	font-weight:normal !important;
	text-decoration:none !important;
}

a.white:link{
	color:#FFF !important;
	font-weight:bold !important;
	text-decoration:none !important;
}
a.white:visited{
	color:#FFF !important;
	font-weight:bold !important;
	text-decoration:none !important;
}
a.white:hover{
	color:#FFF !important;
	font-weight:bold !important;
	text-decoration:none !important;
}
a.white:active{
	color:#FFF !important;
	font-weight:bold !important;
	text-decoration:none !important;
}

a.smallG:link{
	color:#666 !important;
	font-size:10px !important;
	font-weight:normal !important;
	text-decoration:none !important;
}
a.smallG:visited{
	color:#666 !important;
	font-size:10px !important;
	font-weight:normal !important;
	text-decoration:none !important;
}
a.smallG:hover{
	color:#233C49 !important;
	font-size:10px !important;
	font-weight:normal !important;
	text-decoration:none !important;
}
a.smallG:active{
	color:#233C49 !important;
	font-size:10px !important;
	font-weight:normal !important;
	text-decoration:none !important;
}

<!-- used only for the months menu on calendar -->
a.small:link{
	color:#000 !important;
	font-size:10px !important;
	font-weight:normal !important;
	text-decoration:none !important;
}
a.small:visited{
	color:#000 !important;
	font-size:10px !important;
	font-weight:normal !important;
	text-decoration:none !important;
}
a.small:hover{
	color:#000 !important;
	font-size:10px !important;
	font-weight:normal !important;
	text-decoration:none !important;
}
a.small:active{
	color:#000 !important;
	font-size:10px !important;
	font-weight:normal !important;
	text-decoration:none !important;
}

a.smallRed:link{
	color:#F33 !important;
	font-size:10px !important;
	font-weight:bold !important;
	text-decoration:none !important;
}
a.smallRed:visited{
	color:#F33 !important;
	font-size:10px !important;
	font-weight:bold !important;
	text-decoration:none !important;
}
a.smallRed:hover{
	color:#F00 !important;
	font-size:10px !important;
	font-weight:bold !important;
	text-decoration:none !important;
}
a.smallRed:active{
	color:#F00 !important;
	font-size:10px !important;
	font-weight:bold !important;
	text-decoration:none !important;
}

a.header:link{
/*	color:#000 !important; */
	font-size:28px !important;
	font-weight:normal !important;
	text-decoration:none !important;
}
a.header:visited{
	color:#000 !important;
	font-size:28px !important;
	font-weight:normal !important;
	text-decoration:none !important;
}
a.header:hover{
	color:#000 !important;
	font-size:28px !important;
	font-weight:normal !important;
	text-decoration:none !important;
}
a.header:active{
	color:#000 !important;
	font-size:28px !important;
	font-weight:normal !important;
	text-decoration:none !important;
}

input[type=submit]{padding:7px;}

/*=================================================
======= HR =======
=================================================*/
hr {background-color:#366; border:0px; color:#366; height:2px;}

/*=================================================
======= TABLES =======
=================================================*/
<?php 
if ( wp_is_mobile() ){ ?>
table.cc100{
	background-color:transparent !important;
	border:none !important;
	*border-collapse:expression('separate', cellSpacing = '0px') !important;
	border-spacing:0px !important;
	box-shadow:none !important;
	margin:0px !important;
	padding:0px !important;
	width:100% !important;
}

table.cc600{
	background-color:transparent !important;
	border:none !important;
	*border-collapse:expression('separate', cellSpacing = '0px') !important;
	border-spacing:0px !important;
	box-shadow:none !important;
	margin:0px !important;
	padding:0px !important;
	width:100% !important;
}

table.cc800{
	background-color:transparent !important;
	border:none !important; 
	*border-collapse:expression('separate', cellSpacing = '0px') !important;
	border-spacing:0px !important;
	box-shadow:none !important;
	margin:0px !important;
	padding:0px !important;
	width:100% !important;
}

<?php }else{ ?>
table.cc100{
	background-color:transparent !important;
	border:none !important;
	*border-collapse:expression('separate', cellSpacing = '0px') !important;
	border-spacing:0px !important;
	box-shadow:none !important;
	margin:0px;
	padding:0px !important;
	width:100% !important;
}

table.cc600{
	background-color:transparent !important;
	border:none !important;
	border-spacing:0px !important;
	*border-collapse:expression('separate', cellSpacing = '0px') !important;
	box-shadow:none !important;
	margin:0px !important;
	padding:0px !important;
	width:600px !important;
}

table.cc800{
	background-color:transparent !important;
	border:none !important;
	border-spacing:0px !important;
	*border-collapse:expression('separate', cellSpacing = '0px') !important;margin:0px;
	box-shadow:none !important;
	padding:0px !important;
	width:800px !important;
}
<?php } ?>

/*=================================================
======= TR =======
=================================================*/
tr.g666{
	background-color:#<?php echo $b1_color;?> !important;
	box-shadow:none !important;
	<?php echo $round;?>
}

tr.menubox{
	background-color:#ccc !important;
	border-bottom:1px dotted #666 !important;
	box-shadow:none !important;
}

tr.stagger{
	background-color:#ccc !important;
	box-shadow:none !important;
}

/*=================================================
======= TD =======
=================================================*/
td.menu{
	border-bottom:1px dotted #666 !important;
	box-shadow:none !important;
	padding:0px !important;
}

.gBox{
	background-color:#E6E6E6 !important;
	box-shadow:none !important;
	padding:5px !important;
	text-align:left !important;
}

td.redBox{
	border-collapse:separate;
	background-color:#FCC !important;
	border:3px solid #F00 !important;
	box-shadow:none !important;
	overflow:hidden !important;
	padding:14px !important;
	<?php echo $round;?>
}

td.greenBox{
	border-collapse:separate;
	background-color:#CFC !important;
	border:3px solid #093 !important;
	box-shadow:none !important;
	padding:14px !important;
	text-align:center !important;
	<?php echo $round;?>
}

td.blueBox{
	background-color:#E2F8FE;
	border:3px solid #06F;
	box-shadow:none !important;
	padding:14px;
	text-align:center;
	<?php echo $round;?>
}

td.btn{
	background-color:#88B3CA;
	border:1px solid #233C49;
	box-shadow:none !important;
	padding:0px;
	vertical-align:middle;
}

td.orangeBox{
	background-color:#FFC;
	border:2px solid #F63;
	box-shadow:none !important;
	color:#F63;
	font-weight:bold;
	padding:14px;
	<?php echo $round;?>
}

td.blueBanner1{
	background-color:#<?php echo $b1_color;?> !important;
	border:none !important;
	box-shadow:none !important;
	color:#fff !important;
	font-weight:bold !important;	
	<?php if(wp_is_mobile()){?>font-size:16px !important; <?php }else{?> font-size:18px !important; <?php } ?>
	overflow:hidden !important;
	padding:7px 7px 7px 14px !important;
	text-align:left !important;
    border-top-left-radius:7px !important;
    -moz-border-radius-topleft:7px !important;
    -webkit-border-top-left-radius:7px !important;
    border-top-right-radius:7px !important;
    -moz-border-radius-topright:7px !important;
    -webkit-border-top-right-radius:7px !important;

}

td.blueBanner2{
	background-color:#<?php echo $b2_color;?>;
	border:none !important;
	box-shadow:none !important;
	overflow:hidden !important;
	padding:10px; border:1px solid #<?php echo $b1_color; ?> !important;
	text-align:left;
	border-bottom-left-radius:7px !important;
	-moz-border-radius-bottomleft:7px !important;
	-webkit-border-bottom-left-radius:7px !important;
	border-bottom-right-radius:7px; !important;
	-moz-border-radius-bottomright:7px !important;
	-webkit-border-bottom-right-radius:7px !important;
}

td.b2-only{
	background-color:#<?php echo $b2_color;?> !important;
	border:1px solid #<?php echo $b1_color; ?>;
	padding:14px !important;
	text-align:left;<?php echo $round; ?>
}

/*=================================================
======= PADDING TD
=================================================*/
td.nopad{
	background-color:transparent !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important; 
	font-size:14px !important;
	padding:0px !important;
	text-align:left !important;
}

td.pad5{
	background-color:transparent !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-size:14px !important;
	padding:5px !important;
	text-align:left !important;
}

td.pad7{
	background-color:transparent !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-size:14px !important;
	padding:7px !important;
	text-align:left !important;
}

td.pad7center{
	background-color:transparent !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-size:14px !important;
	padding:7px !important;
	text-align:center !important;
}

td.pad10{
	background-color:transparent !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-size:14px !important;
	padding:10px !important;
	text-align:left !important;
}

td.pad14{
	background-color:transparent !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important; 
	font-size:14px !important;
	padding:14px !important;
	text-align:left !important;
}

td.pad21{
	background-color:transparent !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-size:14px !important;
	padding:21px !important;
	text-align:left !important;
}

td.nopadb1{
	background-color:#<?php echo $b1_color;?> !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-size:14px !important;
	padding:0px !important;
	text-align:left !important;
}

td.pad7b1{
	background-color:#<?php echo $b1_color;?> !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-size:14px !important;
	padding:7px !important;
	text-align:left !important;
}

td.pad14b1{
	box-shadow:none !important;
	padding:14px !important;
	text-align:left !important;
	border:none !important;
	color:#000 !important;
	background-color:#<?php echo $b1_color;?> !important;
	font-size:14px !important;
}

td.pad21b1{
	background-color:#<?php echo $b1_color;?> !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-size:14px !important;
	padding:21px !important;
	text-align:left !important;
}

td.nopadb2{
	background-color:#<?php echo $b2_color;?> !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-size:14px !important;
	padding:0px !important;
	text-align:left !important;
}

td.pad7b2{
	background-color:#<?php echo $b2_color;?> !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-size:14px !important;
	padding:7px !important;
	text-align:left !important;
}

td.pad14b2{
	background-color:#<?php echo $b2_color;?> !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-size:14px !important;
	padding:14px !important;
	text-align:left !important;
}

td.pad21b2{
	background-color:#<?php echo $b2_color;?> !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-size:14px !important;
	padding:21px !important;
	text-align:left !important;
}

td.nopadg{
	background-color:#ccc !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-size:14px !important;
	padding:0px !important;
	text-align:left !important;
}

td.pad7g{
	background-color:#ccc !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-size:14px !important;
	padding:7px !important;
	text-align:left !important;
}

/*=================================================
======= FORM LABEL TDs
=================================================*/
<?php if(wp_is_mobile()){$label150="15%";}else{$label150="150px";}?>

td.label50{
	background-color:#<?php echo $b2_color;?> !important;
	border:none !important;
	box-shadow:none !important;
	padding:7px !important;
	text-align:right !important;
	font-weight:bold !important;
	vertical-align:middle !important;
	width:50px !important;
	font-size:10px !important;

	color:#000 !important;
}

td.label100{
	background-color:#<?php echo $b2_color;?> !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-size:14px !important;
	font-weight:bold !important;
	padding:7px !important;
	text-align:right !important;
	vertical-align:middle !important;
	width:100px !important;
}

td.label100top{
	background-color:#<?php echo $b2_color;?> !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-weight:bold !important;
	padding:7px !important;
	text-align:right !important;
	vertical-align:top !important;
	width:100px !important;
}

td.label150{
	background-color:#<?php echo $b2_color;?> !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-weight:bold !important;
	padding:7px !important;
	text-align:right !important;
	vertical-align:middle !important;
	width:15% !important;
}

td.label150top{
	background-color:#<?php echo $b2_color;?> !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-weight:bold !important;
	padding:7px !important;
	text-align:right !important;
	vertical-align:top !important;
	width:150px !important;
}

td.label200{
	background-color:#<?php echo $b2_color;?> !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-size:14px !important;
	font-weight:bold !important;
	padding:7px !important;
	text-align:right !important;
	vertical-align:middle !important;
	width:200px !important;
}

td.label250{
	background-color:#<?php echo $b2_color;?> !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-weight:bold !important;
	padding:7px !important;
	text-align:right !important;
	vertical-align:middle !important;
	width:250px !important;
}

td.login_label{
	background-color:#<?php echo $b2_color;?> !important;
	border:none !important;
	box-shadow:none !important;
	color:#000 !important;
	font-weight:bold !important;
	padding:7px !important;
	text-align:right !important;
	vertical-align:middle !important;
}

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
	$smCALbasics="box-shadow:none !important; width:14.285% !important; text-align:center; font-weight:bold; margin:0px;";
	$day_pad="7px";
	$weekday_width="10%";
}else{
	$day_pad="14px";
	$weekday_width="14.285%";
	$smCALbasics="box-shadow:none !important; width:14.285% !important; text-align:center; font-weight:bold; margin:0px;";
}?>
td.weekday{
	background-color:#666 !important;
	color:#FFF !important;
	padding:5px !important;
	text-align:center !important;
	width:<?php echo $weekday_width;?> !important;
}

td.calendarDay{
	background-color:#<?php echo $b3_color;?> !important;
	border:1px solid #<?php echo $b1_color;?> !important;
	padding:0px !important;
	<?php echo $smCALbasics;?>
}

td.calendarBlank{
	background-color:#e9e9e9 !important;
	border:1px solid #666 !important;
	color:#666 !important;
	padding:<?php echo $day_pad;?> !important;
	<?php echo $smCALbasics;?>
}

td.calendarAdminBlank{
	background-color:#e9e9e9 !important;
	border:1px solid #666 !important;
	color:#666 !important;
	padding:0px !important;
	<?php echo $smCALbasics;?>
}

td.calendarPassed{
	background-color:#e9e9e9 !important;
	border:1px solid #666 !important;
	color:#666 !important;
	padding:<?php echo $day_pad;?> !important;
	<?php echo $smCALbasics;?>
}

td.calendarBlocked{
	background-color:#FCC !important;
	border:1px solid #F00 !important;
	color:#F00 !important;
	padding:0px !important;
	<?php echo $smCALbasics;?>
}

td.calendarBlockedBlackouts{
	background-color:#FCC !important;
	border:1px solid #F00 !important;
	color:#F00 !important;
	font-weight:bold !important;
	margin:0px !important;
	padding:<?php echo $day_pad;?> !important;
	text-align:center !important;
}

td.menumonths{
	background-color:#<?php echo $b1_color;?> !important;
	border:none !important;
	box-shadow:none !important; 
	margin:0px !important;
	padding:0px !important;
	padding-bottom:3px !important;
}

td.blueBanner1Square{
	background-color:#<?php echo $b1_color;?> !important;
	border:none !important;
	box-shadow:none !important; 
	margin:0px !important;
	padding:0px !important;
	padding-bottom:3px !important;
}

<?php $smNavDayConst=""; ?>

.navDay a:link{
	background-color:#<?php echo $b3_color;?> !important;
	display:block !important;
	color:#000 !important;
	text-decoration:none !important;
	border:1px solid #<?php echo $b3_color;?> !important;
	padding:<?php echo $day_pad;?> !important;
	margin:0px !important;
}
.navDay a:visited{
	background-color:#<?php echo $b3_color;?> !important;
	border:1px solid #<?php echo $b3_color;?> !important;
	color:#000 !important;
	display:block !important;
	margin:0px !important;
	padding:<?php echo $day_pad;?> !important;
	text-decoration:none !important;
}

.navDay a:hover{
	background-color:#<?php echo $b1_highlight;?> !important;
	border:1px solid #<?php echo $b1_highlight;?> !important;
	color:#fff !important;
	display:block !important;
	margin:0px !important;
	padding:<?php echo $day_pad;?> !important;
	text-decoration:none !important;
}

.navDay a:active{
	background-color:#<?php echo $b1_highlight;?> !important;
	border:1px solid #<?php echo $b1_highlight;?> !important;
	color:#fff !important;
	display:block !important;
	margin:0px !important;
	padding:<?php echo $day_pad;?> !important;
	text-decoration:none !important;
}

.navCalBlank a:link{
	background-color:#ccc;
	border:1px solid #ccc;
	color:#000;
	display:block;
	margin:0px;
	padding:<?php echo $day_pad;?>;
	text-decoration:none;
}
.navCalBlank a:visited{
	background-color:#ccc;
	border:1px solid #ccc;
	color:#000;
	display:block;
	margin:0px;
	padding:<?php echo $day_pad;?>;
	text-decoration:none;
}
.navCalBlank a:hover{
	background-color:#666;
	border:1px solid #666;
	color:#fff;
	display:block;
	margin:0px;
	padding:<?php echo $day_pad;?>;
	text-decoration:none;
}
.navCalBlank a:active{
	background-color:#666;
	border:1px solid #666;
	color:#fff;
	display:block;
	margin:0px;
	padding:<?php echo $day_pad;?>;
	text-decoration:none;
}

.navBlocked a:link{
	background-color:#FCC;
	background-image:url("<?php echo $sm_btns_dir;?>btn_block16_reg.png");
	background-position:right;
	background-repeat:no-repeat;
	border:1px solid #FCC;
	color:#F00;
	display:block;
	text-decoration:none;
}
.navBlocked a:visited{
	background-color:#FCC;
	border:1px solid #FCC;
	color:#F00;
	display:block;
	padding:<?php echo $day_pad;?>;
	text-decoration:none;
}

.navBlocked a:hover{
	background-color:#F00;
	border:1px solid #F00;
	color:#FFF;
	display:block;
	padding:<?php echo $day_pad;?>;
	text-decoration:none;
}

.navBlocked a:active{
	background-color:#F00;
	border:1px solid #000;
	color:#FFF;
	display:block;
	padding:<?php echo $day_pad;?>;
	text-decoration:none;
}

.navBlackouts a:link{
	background-color:#FCC;
	background-image:url("<?php echo $sm_btns_dir;?>btn_blackout16_reg.png");
	background-position:right;
	background-repeat:no-repeat;
	border:1px solid #FCC;
	color:#F00;
	display:block;
	padding:<?php echo $day_pad;?>;
	text-decoration:none;
}
.navBlackouts a:visited{
	background-color:#FCC;
	border:1px solid #FCC;
	color:#F00;
	display:block;
	padding:<?php echo $day_pad;?>;
	text-decoration:none;
}
.navBlackouts a:hover{
	background-color:#F00;
	border:1px solid #F00;
	color:#FFF;
	display:block;
	padding:<?php echo $day_pad;?>;
	text-decoration:none;
}
.navBlackouts a:active{
	background-color:#F00;
	border:1px solid #F00;
	color:#FFF;
	display:block;
	padding:<?php echo $day_pad;?>;
	text-decoration:none;
}

.navCustom a:link{
	background-color:#6C6;
	background-image:url("<?php echo $sm_btns_dir;?>btn_custom16_reg.png");
	background-position:right;
	background-repeat:no-repeat;
	border:1px solid #090;
	color:#000;
	display:block;
	padding:<?php echo $day_pad;?>;
	text-decoration:none;
}
.navCustom a:visited{
	background-color:#6C6;
	border:1px solid #090;
	color:#000;
	display:block;
	padding:<?php echo $day_pad;?>;
	text-decoration:none;
}
.navCustom a:hover{
	background-color:#096;
	border:1px solid #090;
	color:#FFF;
	display:block;
	padding:<?php echo $day_pad;?>;
	text-decoration:none;
}
.navCustom a:active{
	background-color:#096;
	border:1px solid #090;
	color:#FFF;
	display:block;
	padding:<?php echo $day_pad;?>;
	text-decoration:none;
}

/*=================================================
======= COLUMN HEADERS ON LISTS
=================================================*/
.tab{
	background-color:#<?php echo $b1_color;?>;
	color:#fff;
	font-size:14px;
	font-weight:bold;
	padding:0px;
	text-align:left;
}

.tab-left{
	background-color:#<?php echo $b1_color;?>;
	border-left:1px solid #<?php echo $b1_color;?>;
	color:#fff;
	font-size:14px;
	font-weight:bold;
	padding:0px; 
	text-align:left;
	border-top-left-radius:7px;
	-moz-border-radius-topleft:7px;
	-webkit-border-top-left-radius:7px;
}

.tab-right{
	background-color:#<?php echo $b1_color;?>;
	color:#fff;
	font-size:14px;
	font-weight:bold;
	padding:0px; 
	text-align:left;
    border-top-right-radius:7px;
    -moz-border-top-right-radius:7px;
    -webkit-border-top-right-radius:7px;
}

.tab-bottom-right{
	background-color:#<?php echo $b1_color;?>;
	color:#fff;
	font-size:14px;
	font-weight:bold;
	padding:0px;
	text-align:left;
	border-bottom-right-radius:7px;
	-moz-border-bottom-right-radius:7px;
	-webkit-border-bottom-right-radius:7px;
}

.tab-bottom-left{
	background-color:#<?php echo $b1_color;?>;
	color:#fff;
	font-weight:bold;
	font-size:14px;
	padding:0px; 
	text-align:left;
    border-bottom-left-radius:7px;
    -moz-border-bottom-left-radius:7px;
    -webkit-border-bottom-left-radius:7px;
}

/*=================================================
======= LIST ITEM TDs 
=================================================*/
td.list_left{
	border-left:1px solid #<?php echo $b1_color;?>;
	border-right:1px dotted #666;
	padding:0px;
	text-align:left;
}

td.list_center{
	border-right:1px dotted #666;
	text-align:left;
	padding-left:14px;
}

td.list_right{
	border-right:1px solid #<?php echo $b1_color;?>;
	padding:7px;
}
td.list_bottom{
	border-top:1px solid #<?php echo $b1_color;?>;
	padding:0px;
}

/*=================================================
======= SMALL MENU BUTTONS
=================================================*/
td.g666{
	background-color:#<?php echo $b1_color;?> !important;
	border:1px solid #<?php echo $b1_color;?>!important;
	margin:0px!important;
	padding:0px !important;
	text-align:center !important;
	vertical-align:middle !important;
}

/*=================================================
======= TEXT =======
=================================================*/
.header {
	background-color:none !important;
	box-shadow:none !important;
	color:#000;
	font-size:28px;
	font-weight:normal;
}

.redText{
	color:#F00;
	font-size:14px;
	font-weight:bold;
}

.greenText{
	color:#009900;
	font-size:14px;
	font-weight:bold;
}

.blueText{
	color:#06F;
	font-size:14px;
	font-weight:bold;
}

.smallRed{
	color:#F00;
	font-size:10px;
	font-weight:bold;
}

.smallText{
	color:#000;
	font-size:10px;
}

.smallG{
	color:#666;
	font-size:10px;
}

.smallG12{
	color:#666;
	font-size:12px;
}

.whiteText{
	color:#FFF;
	font-size:14px;
	font-weight:bold;
}

.whiteBold{
	color:#FFF;
	font-size:14px;
	font-weight:bold;
}

/*=================================================
======= NAVS =======
=================================================*/
.navb1 a:link{
	background-color:#<?php echo $b1_color;?>;
	color:#fff;
	display:block;
	padding:7px;
	padding-left:14px;
	text-align:left;
	text-decoration:none;
	<?php echo $round; ?>
}
.navb1 a:visited{
	background-color:#<?php echo $b1_color;?>;
	color:#fff;
	display:block;
	padding:7px;
	padding-left:14px;
	text-align:left;
	text-decoration:none;
	<?php echo $round; ?>
}

.navb1 a:hover{
	background-color:#<?php echo $b1_highlight;?>;
	color:#fff;
	display:block;
	padding:7px;
	padding-left:14px;
	text-align:left;<?php echo $round; ?>
	text-decoration:none;
}

.navb1 a:active{
	background-color:#<?php echo $b1_highlight;?>;
	color:#fff;
	display:block;
	padding:7px;
	padding-left:14px;
	text-align:left;
	text-decoration:none;
	<?php echo $round; ?>
}

.navNotes a:link{
	background-color:none;
	color:#fff;
	display:block;
	padding:7px;
	padding-left:14px;
	text-decoration:none;
}
.navNotes a:visited{
	background-color:none;
	color:#fff;
	display:block;
	padding:7px;
	padding-left:14px;
	text-decoration:none;
}
.navNotes a:hover{
	background-color:#<?php echo $b1_highlight;?>;
	color:#fff;
	display:block;
	padding:7px;
	padding-left:14px;
	text-decoration:none;
}
.navNotes a:active{
	background-color:#<?php echo $b1_highlight;?>;
	color:#fff;
	display:block;
	padding:7px;
	padding-left:14px;
	text-decoration:none;
}

.navMenu a:link{
	background-color:none !important;
	color:#000 !important;
	display:block;
	margin:0px;
	padding:7px;
	text-decoration:none;
}
.navMenu a:visited{
	background-color:none !important;
	color:#000 !important;
	display:block;
	padding:7px;
	text-decoration:none;
}
.navMenu a:hover{
	background-color:#<?php echo $b1_highlight;?> !important;
	color:#fff !important;
	display:block;
	padding:7px;
	text-decoration:none;
}
.navMenu a:active{
	background-color:#<?php echo $b1_highlight;?> !important;
	color:#fff !important;
	display:block;
	padding:7px;
	text-decoration:none;
}

.navMenuSM a:link{
	background-color:transparent !important;
	color:#000 !important;
	display:block;
	margin:0px;
	padding:7px;
	text-decoration:none;
}
.navMenuSM a:visited{
	display:block;
	background-color:transparent !important;
	text-decoration:none;
	color:#000 !important;
	padding:7px;
	cursor:pointer;
}
.navMenuSM a:hover{
	background-color:#<?php echo $b1_highlight;?> !important;
	color:#fff !important;
	display:block;
	padding:7px;
	text-decoration:none;
}
.navMenuSM a:active{
	background-color:#<?php echo $b1_highlight;?> !important;
	color:#fff !important;
	display:block;
	padding:7px;
	text-decoration:none;
}

.navMenuRound a:link{
	background-color:transparent !important;
	color:#000 !important;
	display:block !important;
	padding:7px !important;
	text-decoration:none !important;
	<?php echo $round; ?>
}

.navMenuRound a:visited{
	background-color:transparent !important;
	color:#000 !important;
	display:block !important;
	padding:7px !important;
	text-decoration:none !important;
}

.navMenuRound a:hover{
	background-color:#<?php echo $b1_highlight;?> !important;
	color:#fff !important;
	display:block;
	padding:7px !important;
	text-decoration:none;
	<?php echo $round; ?>
}
.navMenuRound a:active{
	background-color:#<?php echo $b1_highlight;?> !important;
	color:#fff !important;
	display:block;
	padding:7px !important;
	text-decoration:none;
	<?php echo $round; ?>
}

.nav666 a:link{
	background-color:#<?php echo $b3_color;?>;
	color:#e9e9e9 !important;
	display:block;
	font-size:10px;
	padding:4px;
	text-decoration:none !important;
	<?php echo $round;?>
}
.nav666 a:visited{
	background-color:#<?php echo $b3_color;?>;
	color:#e9e9e9 !important;
	display:block;
	font-size:10px;
	padding:4px;
	text-decoration:none;
	<?php echo $round;?>
}
.nav666 a:hover{
	background-color:#<?php echo $b1_highlight;?>;
	color:#fff !important;
	display:block !important;
	font-size:10px !important;
	padding:4px !important;
	text-decoration:none !important;
	<?php echo $round;?>
}
.nav666 a:active{
	background-color:#<?php echo $b1_highlight;?>;
	color:#fff !important;
	display:block;
	font-size:10px;
	padding:4px;
	text-decoration:none;
	<?php echo $round;?>
}

/* ======= Used on the Admin Default Days page, for the menu to jump to different days. =======*/
.navDefaultDays a:link{
	background-color:#<?php echo $b1_color;?> !important;
	color:#e9e9e9;
	display:block;
	font-size:14px;
	padding:4px;
	text-decoration:none;
	<?php echo $round;?>
}
.navDefaultDays a:visited{
	background-color:#<?php echo $b1_color;?> !important;
	color:#e9e9e9;
	display:block;
	font-size:14px;
	padding:4px;
	text-decoration:none;
	<?php echo $round;?>
}
.navDefaultDays a:hover{
	background-color:#<?php echo $b1_highlight;?> !important;
	color:#fff;
	display:block;
	font-size:14px;
	padding:4px;
	text-decoration:none;
	<?php echo $round;?>
}
.navDefaultDays a:active{
	background-color:#<?php echo $b1_highlight;?> !important;
	color:#fff;
	display:block;
	font-size:14px;
	padding:4px;
	text-decoration:none;
	<?php echo $round;?>
}

.navGreen a:link{
	background-color:#090 !important;
	color:#fff !important;
	display:block;
	padding:7px;
	text-decoration:none;
}
.navGreen a:visited{
	background-color:#090 !important;
	color:#fff !important;
	display:block;
	padding:7px;
	text-decoration:none;
}
.navGreen a:hover{
	background-color:#0C0 !important;
	color:#fff !important;
	display:block;
	padding:7px;
	text-decoration:none;
}
.navGreen a:active{
	background-color:#0C0 !important;
	color:#fff !important;
	display:block;
	padding:7px;
	text-decoration:none;
}

.navRed a:link{
	background-color:#900 !important;
	color:#fff !important;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
}
.navRed a:visited{
	background-color:#900 !important;
	color:#fff !important;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
}
.navRed a:hover{
	background-color:#F03 !important;
	color:#fff !important;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
}
.navRed a:active{
	background-color:#F03 !important;
	color:#fff !important;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
}

.navRedRound a:link{
	background-color:#900;
	color:#fff;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
	<?php echo $round;?>
}
.navRedRound a:visited{
	background-color:#900;
	color:#fff; <?php echo $round;?>
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
}
.navRedRound a:hover{
	background-color:#F03;
	color:#fff;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
	<?php echo $round;?>
}
.navRedRound a:active{
	background-color:#F03;
	color:#fff;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
	<?php echo $round;?>
}

.navRedReminders a:link{
	background-color:#FC9 !important;
	border:1px solid #F30;
	color:#C00;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
	<?php echo $round;?>
}
.navRedReminders a:visited{
	background-color:#FC9 !important;
	border:1px solid #F30;
	color:#C00;
	display:block;
	height:100%;
	padding:7px;<?php echo $round;?>
	text-decoration:none;
}
.navRedReminders a:hover{
	background-color:#F36 !important;
	border:1px solid #930;
	color:#FFF;	
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
	<?php echo $round;?>
}
.navRedReminders a:active{
	background-color:#F36 !important;
	border:1px solid #930;
	color:#FFF;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
	<?php echo $round;?>
}

.navCancel a:link{
	background-color:transparent !important;
	color:#000 !important;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
	<?php echo $round;?>
}
.navCancel a:visited{
	height:100%;
	display:block;
	background-color:transparent !important;
	text-decoration:none;
	padding:7px;
	color:#000 !important;
	<?php echo $round;?>
}
.navCancel a:hover{
	background-color:#F03 !important;
	color:#fff !important;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
	<?php echo $round;?>
}
.navCancel a:active{
	background-color:#F03 !important;
	color:#fff !important;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
	<?php echo $round;?>
}

.navPurge a:link{
	background-color:#none !important;
	color:#000;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
	<?php echo $round;?>
}
 
.navPurge a:visited{
	background-color:#none !important;
	color:#000;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
	<?php echo $round;?>
}
.navPurge a:hover{
	background-color:#F00 !important;
	color:#fff;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
	<?php echo $round;?>
}
.navPurge a:active{
	background-color:#F00 !important;
	color:#FFF;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
	<?php echo $round;?>
}

.navBlue a:link{
	background-color:#09F !important;
	color:#fff !important;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
}
.navBlue a:visited{
	background-color:#09F !important;
	color:#fff !important;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
}
.navBlue a:hover{
	background-color:#0CF !important;
	color:#fff !important;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
}
.navBlue a:active{
	background-color:#0CF !important;
	color:#fff !important;
	display:block;
	height:100%;
	padding:7px;
	text-decoration:none;
}

.navPurple a:link{
	background-color:#636 !important;
	color:#fff;
	display:block;
	padding:7px;
	text-decoration:none;
}
.navPurple a:visited{
	background-color:#636 !important;
	color:#fff;
	display:block;
	padding:7px;
	text-decoration:none;
}
.navPurple a:hover{
	background-color:#bd0df0 !important;
	color:#fff;
	display:block;
	padding:7px;
	text-decoration:none;
}
.navPurple a:active{
	background-color:#bd0df0 !important;
	color:#fff;
	display:block;
	padding:7px;
	text-decoration:none;
}

.navYellow a:link{
	background-color:#FC6 !important;
	color:#000;
	display:block;
	padding:7px;
	text-decoration:none;
}
.navYellow a:visited{
	background-color:#FC6 !important;
	color:#000;
	display:block;
	padding:7px;
	text-decoration:none;
}
.navYellow a:hover{
	background-color:#FFC !important;
	color:#000;
	display:block;
	padding:7px;
	text-decoration:none;
}
.navYellow a:active{
	background-color:#FFC !important;
	color:#000;
	display:block;
	padding:7px;
	text-decoration:none;
}

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
	background:#<?php echo $b1_color;?> url("<?php echo $sm_btns_dir;?>btn_save16_g.png") no-repeat scroll 5px center;
}
#button:hover {
    border:none;
	background:#<?php echo $b1_highlight;?> url("<?php echo $sm_btns_dir;?>btn_save16_reg.png") no-repeat scroll 5px center;
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
	background:#C30 url("<?php echo $sm_btns_dir;?>btn_purge16_g.png") no-repeat scroll 5px center;
}
#purge:hover {
    border:none;
    box-shadow:0px 0px 1px #777;
	background:#F60 url("<?php echo $sm_btns_dir;?>btn_purge16_reg.png") no-repeat scroll 5px center;
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
	background:#<?php echo $b1_color;?> url("<?php echo $sm_btns_dir;?>btn_confirm16_g.png") no-repeat scroll 5px center;
}
#mainSave:hover {
    border:none;
    box-shadow:0px 0px 1px #777;
	background:#<?php echo $b1_highlight;?> url("<?php echo $sm_btns_dir;?>btn_confirm16_reg.png") no-repeat scroll 5px center;

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
	background:#<?php echo $b1_color;?> url("<?php echo $sm_btns_dir;?>btn_block16_g.png") no-repeat scroll 5px center;
}

#block:hover {
    border:none;
    box-shadow:0px 0px 1px #777;
	background:#<?php echo $b1_highlight;?> url("<?php echo $sm_btns_dir;?>btn_block16_reg.png") no-repeat scroll 5px center;
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
	background:#<?php echo $b1_color;?> url("<?php echo $sm_btns_dir;?>btn_cancel16_g.png") no-repeat scroll 5px center;
}

#cancel:hover {
    border:none;
    box-shadow:0px 0px 1px #777;
	background:#<?php echo $b1_highlight;?> url("<?php echo $sm_btns_dir;?>btn_cancel16_reg.png") no-repeat scroll 5px center;
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
	background:#<?php echo $b1_color;?> url("<?php echo $sm_btns_dir;?>btn_key16_reg.png") no-repeat scroll 5px center;
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
	background:#<?php echo $b1_color;?> url("<?php echo $sm_btns_dir;?>btn_sendmail16_reg.png") no-repeat scroll 5px center;
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
	background:#900 url("<?php echo $sm_btns_dir;?>btn_delete16_reg.png") no-repeat scroll 5px center;
}

#trash:hover {
    border:none;
    box-shadow:0px 0px 1px #777;
	background:#F00 url("<?php echo $sm_btns_dir;?>btn_delete16_reg.png") no-repeat scroll 5px center;
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
	background:#<?php echo $b1_color;?> url("<?php echo $sm_btns_dir;?>btn_copy16_reg.png") no-repeat scroll 5px center;
}

#embed:hover {
    border:none;
    box-shadow:0px 0px 1px #777;
	background:#<?php echo $b1_highlight;?> url("<?php echo $sm_btns_dir;?>btn_copy16_reg.png") no-repeat scroll 5px center;
}
/* *********************************************************************************************************END SKEDMAKER STYLES **********************************************************************/
</style>