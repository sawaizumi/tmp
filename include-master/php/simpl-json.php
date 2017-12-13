<?php
// 日本語UTF-8, LF



// include



// define
define( "SIMPL__STRING__JSON__API_NAME__DEFAULT", "SIMPL" );
define( "SIMPL__STRING__JSON__API_VERSION", "1.0000.0000" );
define( "SIMPL__STRING__JSON__API_COMMAND_PATH__DEFAULT", "./api" );
define( "SIMPL__BOOL__JSON__API__ALL_REQUEST_ALLOW", FALSE );

	// SIMPL__INTEGER__JSON__API_ERROR_CODE__
$g_SIMPL__tmp_arDefines = array();
$g_SIMPL__tmp_arDefines[] = array( "_DEFAULT", 1 );
//$g_SIMPL__tmp_arDefines[] = array( "", 0 );
SIMPL__BuildDefines_Enum( $g_SIMPL__tmp_arDefines, "API_ERROR_CODE", "JSON" );



// global
global $g_SIMPL__JSON__aaErrors;
$g_SIMPL__JSON__aaErrors = array();
$g_SIMPL__JSON__aaErrors["Result"] = TRUE;
$g_SIMPL__JSON__aaErrors["Details"] = array();



// ===================================================================
// class
// -------------------------------------------------------------------

// create new command, inherit this class and use class name prefix "SIMPL__JSON__API__"
class SIMPL__JSON__API
{
	// ---------------------------------------------------------------
	// member

	function ExecuteCommand( $eSIMPL, $eString_Account, $eString_Command, $eArguments_Command )
	{
		$aaResponse = array();

		SIMPL__JSON__AddError( "commands need override this function" );

		return $aaResponse;
	}

	function CheckPermission( $eSIMPL, $eString_Account, $eString_Command, $eArguments_Command )
	{
		// all request allow
		if ( !SIMPL__BOOL__JSON__API__ALL_REQUEST_ALLOW )
		{
			return $this->CheckLogin( $eSIMPL, $eString_Account, $eString_Command, $eArguments_Command );
		}
		else
		{
			return TRUE;
		}
	}

	function CheckLogin( $eSIMPL, $eString_Account, $eString_Command, $eArguments_Command )
	{
		// only login account check
		if ( SIMPL__IsLogin( $eSIMPL ) === TRUE )
		{
			if ( $eString_Account != $eSIMPL["Login-Account"] )
			{
				SIMPL__JSON__AddError( "invalid account" );

				return FALSE;
			}

			return TRUE;
		}

		// must login or not
		if ( $this->CheckLogin_Must() )
		{
			SIMPL__JSON__AddError( "no login" );

			return FALSE;
		}

		return TRUE;
	}

	function CheckLogin_Must()
	{
		// not must
		return FALSE;
	}
}



// ===================================================================
// public
// -------------------------------------------------------------------

// subject  : add error to json response
// argument : string, error message
// argument : integer, error code
function SIMPL__JSON__AddError( $eString_Message, $iCode = SIMPL__INTEGER__JSON__API_ERROR_CODE___DEFAULT )
{
	global $g_SIMPL__JSON__aaErrors;

	$aaError = array();
	$aaError["ErrorCode"] = $iCode;
	$aaError["ErrorMessage"] = $eString_Message;

	$g_SIMPL__JSON__aaErrors["Result"] = FALSE;
	$g_SIMPL__JSON__aaErrors["Details"][] = $aaError;
}


// subject  : execute command
// argument : hash, simpl
// argument : object, json request
// return   : hash, configurations
function SIMPL__JSON__ExecuteCommand( $eSIMPL, $eRequest )
{
	$aaResponse = array();

	$eString_Command = SIMPL__GetValue( $eRequest, "Command" );
	$aaConfigurations = SIMPL__CONFIGURATION__GetConfigurations();
	$aaStrings_Command = SIMPL__GetValue( $aaConfigurations, SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__JSON__COMMAND_LIST );
	$eString_CommandFile = SIMPL__GetValue( $aaStrings_Command, $eString_Command );
	if ( $eString_CommandFile !== FALSE )
	{
		$eString_ClassName = "SIMPL__JSON__API__" . $eString_Command;
		$eString_Path = SIMPL__CONFIGURATION__GetPath( "json-api", SIMPL__STRING__JSON__API_COMMAND_PATH__DEFAULT );
		$eString_FullName = SIMPL__CombinePath( $eString_Path, $eString_CommandFile );
		include( $eString_FullName );

		if ( class_exists( $eString_ClassName ) )
		{
			$eCommand = new $eString_ClassName();
			
			$eString_Account = SIMPL__GetValue( $eRequest, "Account" );
			$eArguments_Command = SIMPL__GetValue( $eRequest, "Command-Arguments", NULL );

			if ( $eCommand->CheckPermission( $eSIMPL, $eString_Account, $eString_Command, $eArguments_Command ) )
			{
				$aaResponse = $eCommand->ExecuteCommand( $eSIMPL, $eString_Account, $eString_Command, $eArguments_Command );
			}
			else
			{
				SIMPL__JSON__AddError( "no permission" );
			}
		}
		else
		{
			SIMPL__JSON__AddError( "class not found" );
		}
	}
	else
	{
		SIMPL__JSON__AddError( "invalid command" );
	}

	return $aaResponse;
}



// -------------------------------------------------------------------
// json

function SIMPL__JSON__ShowJSON( $eJSON = NULL, $aaOptions = NULL )
{
	if ( $eJSON === NULL )
	{
		$aaJSON = SIMPL__JSON__BuildResponse();
		$eString_JSON = json_encode( $aaJSON );
	}
	else
	{
		$eString_JSON = json_encode( $eJSON );
	}

	$eString_Description = SIMPL__GetValue( $aaOptions, "Description", "JSON Data" );
	$eString_TransferEncoding = SIMPL__GetValue( $aaOptions, "TransferEncoding", "binary" );
	header( "Expires: 0" );
	header( "Content-Description: " . $eString_Description );
	header( "Content-Type: application/json" );
	header( "Content-Transfer-Encoding: " . $eString_TransferEncoding );
	header( "Cache-Control: no-cache; no-transform" );
	header( "Access-Control-Allow-Origin: *" );

	echo $eString_JSON;
}


function SIMPL__JSON__BuildResponse( $aaRequest = NULL, $aaResponse = NULL, $aaErrors = NULL, $aaDebugLogs = NULL )
{
	$aaJSON = SIMPL__JSON__BuildBaseObject( $aaErrors );

	if ( $aaDebugLogs !== NULL )
	{
		$aaJSON["Debug"] = $aaDebugLogs;
	}

	if ( $aaRequest !== NULL )
	{
		$aaJSON["Request"] = $aaRequest;
	}

	if ( $aaResponse === NULL )
	{
		$aaResponse = array();
		$aaResponse["Message"] = "no data";
	}

	$aaJSON["Response"] = $aaResponse;

	return $aaJSON;
}


function SIMPL__JSON__BuildBaseObject( $aaErrors = NULL, $eString_Name = SIMPL__STRING__JSON__API_NAME__DEFAULT )
{
	global $g_SIMPL__JSON__aaErrors;

	$aaJSON = array();
	$aaAPI = array();

	if ( $aaErrors === NULL )
	{
		$aaErrors = $g_SIMPL__JSON__aaErrors;
	}

	$aaAPI["Name"] = $eString_Name;
	$aaAPI["Version"] = SIMPL__STRING__JSON__API_VERSION;
	$aaJSON["API"] = $aaAPI;
	$aaJSON["Errors"] = $aaErrors;

	return $aaJSON;
}



// ===================================================================
// local
// -------------------------------------------------------------------



?>