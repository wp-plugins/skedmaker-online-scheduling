<?php
$sm_settings_result=mysql_query("SELECT * FROM skedmaker_users");
while($row=mysql_fetch_array($sm_settings_result)){
	$live=SM_d($row['live']);
	$sitename=SM_d($row['sitename']);
	$adminemail=SM_d($row['adminemail']);
	$website=SM_d($row['website']);
	$photo=SM_d($row['photo']);
	$phone=SM_d($row['phone']);
	$cellphone=SM_d($row['cellphone']);
	$address1=SM_d($row['address1']);
	$address2=SM_d($row['address2']);
	$region=SM_d($row['region']);
	$city=SM_d($row['city']);
	$country=SM_d($row['country']);
	$zipcode=SM_d($row['zipcode']);
	$fax=SM_d($row['fax']);
	$skin=SM_d($row['skin']);
	
	$b1_color=SM_d($row['color1']);
	$b2_color=SM_d($row['color2']);
	$b3_color=SM_d($row['color3']);
	$b1_highlight=SM_d($row['highlight']);
	$directionsURL=SM_d($row['directionsURL']);

	$content=SM_d($row['content']);
	$content_for_photo=SM_d($row['content']); // was not displaying properly on admin page, because of edit box
	$calendarcaption=SM_d($row['calendarcaption']);
	$premium=SM_d($row['premium']);
	$timezone=SM_d($row['timezone']);
	$cancel=SM_d($row['cancel']);
	$cancelpolicy=SM_d($row['cancelpolicy']);
	$confirmation=SM_d($row['confirmation']);
	$appointmentpadding=SM_d($row['appointmentpadding']);
	$appointmentAvailable=SM_d($row['appointmentAvailable']);
	$appointmentUnavailable=SM_d($row['appointmentUnavailable']);
	$protect=SM_d($row['protect']); //-- client password
	$publicschedule=SM_d($row['publicschedule']); //-- allows public to see who is booked
	$allowsameday=SM_d($row['allowsameday']);

	$keep_profile_open=SM_d($row['keep_profile_open']);
	
	$requirename=SM_d($row['requirename']);
	$requireemail=SM_d($row['requireemail']);
	$requireconfirm=SM_d($row['requireconfirm']);
	$requirephone=SM_d($row['requirephone']);
	$requiremessage=SM_d($row['requiremessage']);
	$requireregistration=SM_d($row['requireregistration']);
	
	$requirenumberinparty=SM_d($row['requirenumberinparty']);
	$partymax=SM_d($row['partymax']);
	
	$sitepublic=SM_d($row['sitepublic']); //--allows people to book appointments
	
	$BCC1=SM_d($row['BCC1']);
	$BCC2=SM_d($row['BCC2']);
	$BCC3=SM_d($row['BCC3']);
	$send_notices_to_admin=SM_d($row['send_notices_to_admin']);
	$send_notices_to_client=SM_d($row['send_notices_to_client']);
	$send_notices_to_BCC=SM_d($row['send_notices_to_BCC']);

/////////////////////////////////////////////////
//======= WEEKDAY INFO
/////////////////////////////////////////////////
//------- MONDAY
	$mondaylive=$row['mondaylive'];
	$mondayincrement=$row['mondayincrement'];
	$mondaymultiple=SM_d($row['mondaymultiple']);
	$mondayopenhour=$row['mondayopenhour'];
	$mondayopenminute=$row['mondayopenminute'];
	$mondaybreakhour=$row['mondaybreakhour'];
	$mondaybreakminute=$row['mondaybreakminute'];
	$mondayreturnhour=$row['mondayreturnhour'];
	$mondayreturnminute=$row['mondayreturnminute'];
	$mondayclosehour=$row['mondayclosehour'];
	$mondaycloseminute=$row['mondaycloseminute'];
//------- TUESDAY
	$tuesdaylive=$row['tuesdaylive'];
	$tuesdayincrement=$row['tuesdayincrement'];
	$tuesdaymultiple=SM_d($row['tuesdaymultiple']);
	$tuesdayopenhour=$row['tuesdayopenhour'];
	$tuesdayopenminute=$row['tuesdayopenminute'];
	$tuesdaybreakhour=$row['tuesdaybreakhour'];
	$tuesdaybreakminute=$row['tuesdaybreakminute'];
	$tuesdayreturnhour=$row['tuesdayreturnhour'];
	$tuesdayreturnminute=$row['tuesdayreturnminute'];
	$tuesdayclosehour=$row['tuesdayclosehour'];
	$tuesdaycloseminute=$row['tuesdaycloseminute'];
//------- WEDNESDAY	
	$wednesdaylive=$row['wednesdaylive'];
	$wednesdayincrement=$row['wednesdayincrement'];
	$wednesdaymultiple=SM_d($row['wednesdaymultiple']);
	$wednesdayopenhour=$row['wednesdayopenhour'];
	$wednesdayopenminute=$row['wednesdayopenminute'];
	$wednesdaybreakhour=$row['wednesdaybreakhour'];
	$wednesdaybreakminute=$row['wednesdaybreakminute'];
	$wednesdayreturnhour=$row['wednesdayreturnhour'];
	$wednesdayreturnminute=$row['wednesdayreturnminute'];
	$wednesdayclosehour=$row['wednesdayclosehour'];
	$wednesdaycloseminute=$row['wednesdaycloseminute'];
//------- THURSDAY
	$thursdaylive=$row['thursdaylive'];
	$thursdayincrement=$row['thursdayincrement'];
	$thursdaymultiple=SM_d($row['thursdaymultiple']);
	$thursdayopenhour=$row['thursdayopenhour'];
	$thursdayopenminute=$row['thursdayopenminute'];
	$thursdaybreakhour=$row['thursdaybreakhour'];
	$thursdaybreakminute=$row['thursdaybreakminute'];
	$thursdayreturnhour=$row['thursdayreturnhour'];
	$thursdayreturnminute=$row['thursdayreturnminute'];
	$thursdayclosehour=$row['thursdayclosehour'];
	$thursdaycloseminute=$row['thursdaycloseminute'];
//------- FRIDAY
	$fridaylive=$row['fridaylive'];
	$fridayincrement=$row['fridayincrement'];
	$fridaymultiple=SM_d($row['fridaymultiple']);
	$fridayopenhour=$row['fridayopenhour'];
	$fridayopenminute=$row['fridayopenminute'];
	$fridaybreakhour=$row['fridaybreakhour'];
	$fridaybreakminute=$row['fridaybreakminute'];
	$fridayreturnhour=$row['fridayreturnhour'];
	$fridayreturnminute=$row['fridayreturnminute'];
	$fridayclosehour=$row['fridayclosehour'];
	$fridaycloseminute=$row['fridaycloseminute'];
//------- SATURDAY
	$saturdaylive=$row['saturdaylive'];
	$saturdayincrement=$row['saturdayincrement'];
	$saturdaymultiple=SM_d($row['saturdaymultiple']);
	$saturdayopenhour=$row['saturdayopenhour'];
	$saturdayopenminute=$row['saturdayopenminute'];
	$saturdaybreakhour=$row['saturdaybreakhour'];
	$saturdaybreakminute=$row['saturdaybreakminute'];
	$saturdayreturnhour=$row['saturdayreturnhour'];
	$saturdayreturnminute=$row['saturdayreturnminute'];
	$saturdayclosehour=$row['saturdayclosehour'];
	$saturdaycloseminute=$row['saturdaycloseminute'];
//------- SUNDAY
	$sundaylive=$row['sundaylive'];
	$sundayincrement=$row['sundayincrement'];
	$sundaymultiple=SM_d($row['sundaymultiple']);
	$sundayopenhour=$row['sundayopenhour'];
	$sundayopenminute=$row['sundayopenminute'];
	$sundaybreakhour=$row['sundaybreakhour'];
	$sundaybreakminute=$row['sundaybreakminute'];
	$sundayreturnhour=$row['sundayreturnhour'];
	$sundayreturnminute=$row['sundayreturnminute'];
	$sundayclosehour=$row['sundayclosehour'];
	$sundaycloseminute=$row['sundaycloseminute'];
}

if($b1_color!="" && $b2_color!="" && $b3_color!="" && $b1_highlight!=""){
// -- nothing	
}else{
	$user_style=$skin;
	//======= COLOR defaults
	if($user_style=='Black'){
		$b1_color="000";
		$b1_highlight="666";
		$b2_color="e9e9e9";
		$b3_color="999";
	}else if($user_style=='Olive'){
		$b1_color="660";
		$b1_highlight="693";
		$b2_color="EAF5C2";
		$b3_color="94a654";
	}else if($user_style=="Plum"){
		$b1_color="303";
		$b1_highlight="66C";
		$b2_color="D0C9DE";
		$b3_color="b682c7";
	}else if($user_style=="Lovey"){
		$b1_color="603";
		$b1_highlight="C03";
		$b2_color="F8DEF3";
		$b3_color="ca5252";
	}else if($user_style=="Light Blue"){
		$b1_color="36F";
		$b1_highlight="0CF";
		$b2_color="CAF5FB";
		$b3_color="419ade";
	}else if($user_style=="Umber"){
		$b1_color="960";
		$b1_highlight="CC6";
		$b2_color="F3F2E4";
		$b3_color="b78e74";
	}else if($user_style=="Dusk"){
		$b1_color="033";
		$b1_highlight="066";
		$b2_color="e9e9e9";
		$b3_color="6797ce";
	}else if($user_style=="Tibet"){
		$b1_color="b64621";
		$b1_highlight="f7644e";
		$b2_color="fbeedb";
		$b3_color="ef9c35";
	}else if($user_style=="Adirondacks"){
		$b1_color="074521";
		$b1_highlight="5a8890";
		$b2_color="e0e9ee";
		$b3_color="98c6bb";
	}else if($user_style=="Sahara"){
		$b1_color="7c7467";
		$b1_highlight="d0a45e";
		$b2_color="e9e9e9";
		$b3_color="ccb59e";	
	}else if($user_style=="Acapulco"){
		$b1_color="ccae67";
		$b1_highlight="f2b62a";
		$b2_color="fff9ec";
		$b3_color="cac574";
	}else if($user_style=="Beijing"){
		$b1_color="252d32";
		$b1_highlight="6c544b";
		$b2_color="e1e2de";
		$b3_color="65393f";
	}else if($user_style=="Navy Blue" || $user_style==""){
		$b1_color="233C49";	
		$b1_highlight="09F";
		$b2_color="E0E9E9";
		$b3_color="69C";
	}
}
?>