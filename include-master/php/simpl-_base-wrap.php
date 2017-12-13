<?php
// 日本語UTF-8, LF



// include



// define



// global
global $g_SIMPL__aaSIMPL;
$g_SIMPL__aaSIMPL = array();



// ===================================================================
// public
// -------------------------------------------------------------------

function SIMPL__Initialize( $eString_Key = NULL )
{
	$eSIMPL = array();

	SIMPL__SetupConfigurations();

	$eSIMPL["Action"] = SIMPL__GetValue( $_REQUEST, "action", "view" );
	$eSIMPL["Action-Account"] = SIMPL__GetValue( $_REQUEST, "account", "nosawa" );
	$eSIMPL["Path"] = local_SIMPL__RebuildPath();

	$eSIMPL["Login"] = TRUE;
	$eSIMPL["Login-Account"] = "nosawa";

	$eSIMPL["Mode"] = SIMPL__GetValue( $_REQUEST, "Mode", "View" );
	$eSIMPL["View"] = SIMPL__GetValue( $_REQUEST, "View", "Character" );
	$eSIMPL["View-ID"] = intval( SIMPL__GetValue( $_REQUEST, "View-ID", 1 ) );

	$eSIMPL["JSON"] = json_decode( SIMPL__GetValue( $_REQUEST, "JSON" ) );

	SIMPL__SetEntity( $eString_Key, $eSIMPL );

	return $eSIMPL;
}


function SIMPL__Finalize( $eString_Key = NULL )
{
	SIMPL__SetEntity( $eString_Key );
}


function SIMPL__IsLogin( $eSIMPL, $bFlag_Force = NULL )
{
	if ( $bFlag_Force === NULL )
	{
		return SIMPL__GetValue( $eSIMPL, "Login" );
	}

	return $bFlag_Force;
}



// ===================================================================
// public ( aliases )
// -------------------------------------------------------------------

// -------------------------------------------------------------------
// simpl entity

function SIMPL__GetEntity( $eString_Key = NULL )
{
	global $g_SIMPL__aaSIMPL;

	$eString_Key = SIMPL__CheckReplace_NULL( $eString_Key );

	return $g_SIMPL__aaSIMPL[$eString_Key];
}


function SIMPL__SetEntity( $eString_Key = NULL, $eSIMPL = NULL )
{
	global $g_SIMPL__aaSIMPL;

	$eString_Key = SIMPL__CheckReplace_NULL( $eString_Key );

	$g_SIMPL__aaSIMPL[$eString_Key] = $eSIMPL;
}


// -------------------------------------------------------------------
// wrap


function SIMPL__SetupConfigurations()
{
	if ( function_exists( "SIMPL__CONFIGURATION__SetupConfigurations" ) )
	{
		SIMPL__CONFIGURATION__SetupConfigurations();
	}
}


function SIMPL__GetList_URL__SIMPLE_CSS()
{
	global $g_SIMPL__arStrings_URL__SIMPL_CSS;

	$arStrings_URL = array();

	foreach ( $g_SIMPL__arStrings_URL__SIMPL_CSS as $eString_URL )
	{
		$arStrings_URL[] = array( "URL" => SIMPL__CombinePath( SIMPL__STRING__PATH__SIMPL_CSS, $eString_URL ) );
	}

	return $arStrings_URL;
}


function SIMPL__GetList_URL__SIMPLE_JS()
{
	global $g_SIMPL__arStrings_URL__SIMPL_JS;

	$arStrings_URL = array();

	foreach ( $g_SIMPL__arStrings_URL__SIMPL_JS as $eString_URL )
	{
		$arStrings_URL[] = array( "URL" => SIMPL__CombinePath( SIMPL__STRING__PATH__SIMPL_JS, $eString_URL ) );
	}

	return $arStrings_URL;
}



// ===================================================================
// local
// -------------------------------------------------------------------


function local_SIMPL__RebuildPath()
{
	if ( function_exists( "local_SIMPL__WRAP__RebuildPath" ) )
	{
		return local_SIMPL__WRAP__RebuildPath();
	}

	return "/";
}


// -------------------------------------------------------------------
// 



?>