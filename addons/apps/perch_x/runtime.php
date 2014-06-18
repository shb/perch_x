<?php

function perch_x_setting( $id, $return )
{
	$PerchSettings = PerchSettings::fetch();
	$setting = $PerchSettings->get( $id );
	
	if ($return)
		return $setting->val();
	else
		echo $setting->val();
}
