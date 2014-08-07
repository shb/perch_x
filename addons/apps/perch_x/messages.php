<?php

if (!session_id())
	session_start();
if (empty( $_SESSION[PERCH_DB_PREFIX.'_messages'] ))
	$_SESSION[PERCH_DB_PREFIX.'_messages'] = array();

/**
 * Store a message into session
 */
function x_perch_message (
	$text, $fields = 'info'
) {
	if (!is_array( $fields ))
		$fields = array( 'messageLevel' => $fields );
	$fields['messageText'] = $text;

	if (empty( $fields['messageLevel'] ))
		$fields['messageLevel'] = 'info';

	$messages = $_SESSION[PERCH_DB_PREFIX.'messages'][] = $fields;
}

/**
 * Retrieve and possibly show messages stored in session
 */
function x_perch_messages (
	$opts = array(
		'filter' => null,  // Dont filter messages
		'count' => false,
		'template' => 'item.html'  // Default template (in messages)
	),
	$return = false
) {
	if (empty( $opts['count']))
		$opts['count'] = PHP_INT_MAX;
	if (empty( $opts['template']))
		$opts['template'] = 'item.html';

	$_messages = $_SESSION[PERCH_DB_PREFIX.'messages'];
	$_left = array();
	$messages = array();
	$out = array();
	foreach ($_messages as $i => $message)
	{
		$messages[] = $message;
		if (count( $messages ) >= $opts['count'])
			break;
	}
	$_SESSION[PERCH_DB_PREFIX.'messages'] = $_left;

	if (!empty( $opts['return-html'] ))
		$messages['html'] = perch_template ( "messages/{$opts['template']}", $messages, true );

	if (!empty( $opts['skip-template'] )) {
		return $messages;
	} else {
		return perch_template ( "messages/{$opts['template']}", $messages, $return );
	}
}
