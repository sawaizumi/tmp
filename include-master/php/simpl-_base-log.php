<?php
// 日本語UTF-8, LF



// include



// define
	// SIMPL__INTEGER__LOG__LOG_TYPE__
	// SIMPL__STRING__LOG__LOG_TYPE__
$g_SIMPL__tmp_arDefines = array();
$g_SIMPL__tmp_arDefines[] = array( "ERROR", "Error" );
$g_SIMPL__tmp_arDefines[] = array( "WARNING", "Warning" );
$g_SIMPL__tmp_arDefines[] = array( "NOTICE", "Notice" );
$g_SIMPL__tmp_aaLogTypes = SIMPL__BuildDefines_EnumString( $g_SIMPL__tmp_arDefines, "LOG_TYPE", "LOG", 1 );
	// SIMPL__INTEGER__LOG__LOG_LEVEL__
$g_SIMPL__tmp_arDefines = array();
$g_SIMPL__tmp_arDefines[] = array( "_DEFAULT", 0 );
$g_SIMPL__tmp_arDefines[] = array( "ALL", 0 );
SIMPL__BuildDefines_Enum( $g_SIMPL__tmp_arDefines, "LOG_LEVEL", "LOG" );



// global
global $g_SIMPL__aaLogLevels;
global $g_SIMPL__aaLogStates;
global $g_SIMPL__aaLogs;
global $g_SIMPL__aaLogTypes;
$g_SIMPL__aaLogLevels = array();
$g_SIMPL__aaLogLevels[] = 0;
$g_SIMPL__aaLogLevels[] = SIMPL__INTEGER__LOG_LEVEL__OUTPUT__ERROR;
$g_SIMPL__aaLogLevels[] = SIMPL__INTEGER__LOG_LEVEL__OUTPUT__WARNING;
$g_SIMPL__aaLogLevels[] = SIMPL__INTEGER__LOG_LEVEL__OUTPUT__NOTICE;
$g_SIMPL__aaLogStates = array();
$g_SIMPL__aaLogs = array();
$g_SIMPL__aaLogTypes = $g_SIMPL__tmp_aaLogTypes;



// ===================================================================
// public
// -------------------------------------------------------------------


// -------------------------------------------------------------------
// output

// subject  : echo
// argument : string, message
function SIMPL__LOG__Echo( $eString_Message )
{
	echo $eString_Message;
}


// -------------------------------------------------------------------
// stack

// subject  : error
// argument : string, message
// argument : integer, log level
function SIMPL__LOG__AddError( $eString_Message, $iLogLevel = 0 )
{
	local_SIMPL__LOG__AddLogMessage( $eString_Message, SIMPL__INTEGER__LOG__LOG_TYPE__ERROR, $iLogLevel );
}


function SIMPL__LOG__AddLogMessage_DateTime( $eString_Message, $iLogType, $iLogLevel )
{
	global $g_SIMPL__aaLogLevels;

	if ( $g_SIMPL__aaLogLevels[$iLogType] !== NULL )
	{
		if ( $g_SIMPL__aaLogLevels[$iLogType] <= $iLogLevel )
		{
			error_log( $eString_Message );
		}
	}
}



// ===================================================================
// local
// -------------------------------------------------------------------

function local_SIMPL__LOG__AddLogMessage( $eString_Message, $iLogType, $iLogLevel )
{
	$arLogs = local_SIMPL__LOG__GetLogs( $iLogType );

	$arLogs[] = array( $iLogLevel, $eString_Message );

	local_SIMPL__LOG__SetLogs( $iLogType, $arLogs );
}


function local_SIMPL__LOG__GetLogs( $iLogType )
{
	global $g_SIMPL__aaLogs;

	if ( array_key_exists( $iLogType, $g_SIMPL__aaLogs ) == FALSE )
	{
		$g_SIMPL__aaLogs[$iLogType] = array();
	}

	return $g_SIMPL__aaLogs[$iLogType];
}


function local_SIMPL__LOG__SetLogs( $iLogType, $arLogs )
{
	global $g_SIMPL__aaLogs;

	if ( $arLogs == NULL )
	{
		$arLogs = array();
	}

	$g_SIMPL__aaLogs[$iLogType] = $arLogs;
}



?>