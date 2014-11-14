<?php 
//==================================================================================================
// -- This pages directs the admin to either block an appointment timeframe or schedule a client
//==================================================================================================
?>
<table class='cc800'>
<tr><td class='pad7'><span class='header'>Admin Operations</span></td></tr>
<tr><td class='blueBanner1'>What would you like to do with this time frame?</td></tr>
<tr><td class='blueBanner2' style='padding:0px;'>
<?php SM_menu();?>
<table class='cc100'>
<tr><td class='pad7'><div class='navMenuRound' style='width:550px;'><a href="<?php echo $smadmin;?>&amp;v=blocktime&amp;ts=<?php echo $_GET['ts'];?>&amp;" class='sked'><img src='<?php echo $sm_btns_dir;?>btn_block32_reg.png' class='btn'>Block Time Frame: <?php echo SM_apt($_GET['ts']);?></a></div></td></tr>
<tr><td class='pad7'><div class='navMenuRound' style='width:575px;'><a href="<?php echo $smadmin;?>&amp;v=skedclient&amp;ts=<?php echo $_GET['ts'];?>&amp;" class='sked'><img src='<?php echo $sm_btns_dir;?>btn_clients32_reg.png' class='btn'>Schedule Someone for: <?php echo SM_apt($_GET['ts']);?></a></div></td></tr>
</table>
</td></tr></table>