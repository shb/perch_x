<?php

function x_perch_setting (
	$id,
	$return = false
) {
	$PerchSettings = PerchSettings::fetch();
	$setting = $PerchSettings->get( $id );
	
	if ($return)
		return $setting->val();
	else
		echo $setting->val();
}

// Session messages
include 'messages.php';

/**
 * Requires the user to log in
 */
function x_perch_members_log_in (
	$force = false // true?
) {
	// Force member login if not logged in and not viewing login page already
	$perch_members_login_page = x_perch_setting( "perch_members_login_page", true );
	$_parts = explode( "?", $perch_members_login_page );
	$perch_members_login_path = $_parts[0];
	$path = PerchSystem::get_page();
	if (
		$path != $perch_members_login_path &&
		! perch_member_logged_in()
	) {
		$perch_members_login_page = str_replace( "{returnURL}", $_SERVER["REQUEST_URI"], $perch_members_login_page );
		return PerchUtil::redirect( x_perch_setting("siteURL",true).$perch_members_login_page );
		exit;
	}
}
