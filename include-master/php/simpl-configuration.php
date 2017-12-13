<?php
// 日本語UTF-8, LF



// include



// define
define( "SIMPL__STRING__CONFIGURATION__CONFIGURATION_NAME__DEFALUT", "[Default]" );
define( "SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__DEFALUT_DATABASE_CONNECTION__READ", "DefaultDBC-Read" );
define( "SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__DEFALUT_DATABASE_CONNECTION__WRITE", "DefaultDBC-Write" );
define( "SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__XML", "XML" );
define( "SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__PATH", "Path" );
define( "SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__JSON__COMMAND_LIST", "JSON-CommandList" );



// global
global $g_SIMPL__aaConfigurations;
$g_SIMPL__aaConfigurations = array();



// ===================================================================
// public
// -------------------------------------------------------------------

// -------------------------------------------------------------------
// get

// subject  : get configurations
// argument : string, configuration name
// return   : hash, configurations
function SIMPL__CONFIGURATION__GetConfigurations( $eString_ConfigurationName = NULL )
{
	global $g_SIMPL__aaConfigurations;

	if ( $eString_ConfigurationName === NULL )
	{
		$eString_ConfigurationName = SIMPL__STRING__CONFIGURATION__CONFIGURATION_NAME__DEFALUT;
	}

	$aaConfigurations = SIMPL__GetValue( $g_SIMPL__aaConfigurations, $eString_ConfigurationName, array() );

	return $aaConfigurations;
}


// -------------------------------------------------------------------
// path

// subject  : get path
// argument : string, group name
// argument : string, configuration name
// return   : string, path
function SIMPL__CONFIGURATION__GetPath( $eString_Group, $eString_DefaultPath, $eString_ConfigurationName = NULL )
{
	$aaConfigurations = SIMPL__CONFIGURATION__GetConfigurations( $eString_ConfigurationName );
	$aaStrings_Path = SIMPL__GetValue( $aaConfigurations, SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__PATH );
	$eStrings_Path = SIMPL__GetValue( $aaStrings_Path, $eString_Group, $eString_DefaultPath );

	return $eStrings_Path;
}


// -------------------------------------------------------------------
// setup

// subject  : get configurations
function SIMPL__CONFIGURATION__SetupConfigurations()
{
	global $g_SIMPL__aaConfigurations;

	if ( defined( "SIMPL__STRING__FULL_NAME__CONFIG_PATH_XML" ) )
	{
		$g_SIMPL__aaConfigurations[SIMPL__STRING__CONFIGURATION__CONFIGURATION_NAME__DEFALUT] = local_SIMPL__CONFIGURATION__SetupConfigurations();
	}
	else
	{
		$g_SIMPL__aaConfigurations[SIMPL__STRING__CONFIGURATION__CONFIGURATION_NAME__DEFALUT] = local_SIMPL__CONFIGURATION__SetupConfigurations_Default();
	}
}


// -------------------------------------------------------------------
// xml

// subject  : get state
// argument : object, SimpleXMLElement
// return   : bool, enable or not
function SIMPL__CONFIGURATION__CheckState_XML( $eSimpleXMLElement )
{
	if ( $eSimpleXMLElement === FALSE )
	{
		return FALSE;
	}

	$eString_State = SIMPL__CONFIGURATION__GetString_XML( $eSimpleXMLElement, "disable", TRUE );
	if ( $eString_State !== TRUE )
	{
		if ( $eString_State == "disable" )
		{
			return FALSE;
		}
	}

	return TRUE;
}


// subject  : get configurations
// argument : string, configuration name
// argument : string, configuration group
// argument : string, configuration file
// return   : object, configurations ( SimpleXMLElement )
function SIMPL__CONFIGURATION__GetConfigurations_XML( $eString_ConfigurationName = NULL, $eString_Group = NULL, $eString_Name = NULL )
{
	global $g_SIMPL__aaConfigurations;

	if ( $eString_Group === NULL )
	{
		$eString_Group = "application";
	}
	if ( $eString_Name === NULL )
	{
		$eString_Key = $eString_Group;
	}
	else
	{
		$eString_Key = $eString_Group . "." . $eString_Name;
	}

	$aaConfigurations = SIMPL__CONFIGURATION__GetConfigurations( $eString_ConfigurationName );
	$aaXMLs = SIMPL__GetValue( $aaConfigurations, SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__XML );
	$eXML_Config = SIMPL__GetValue( $aaXMLs, $eString_Key );

	return $eXML_Config;
}


// subject  : get node
// argument : object, SimpleXMLElement
// argument : string, xpath
// return   : object, SimpleXMLElement
function SIMPL__CONFIGURATION__GetNode_XML( $eSimpleXMLElement, $eString_XPath )
{
	if ( $eSimpleXMLElement === FALSE )
	{
		return FALSE;
	}

	$arSimpleXMLElements = $eSimpleXMLElement->xpath( $eString_XPath );
	if ( $arSimpleXMLElements === FALSE )
	{
		return FALSE;
	}
	if ( count( $arSimpleXMLElements ) == 0 )
	{
		return FALSE;
	}

	return $arSimpleXMLElements[0];
}


// subject  : get string
// argument : object, SimpleXMLElement
// argument : string, attribute
// argument : string, default
// return   : hash, configurations
function SIMPL__CONFIGURATION__GetString_XML( $eSimpleXMLElement, $eString_Attribute = NULL, $eString_Default = "" )
{
	if ( $eSimpleXMLElement !== FALSE )
	{
		if ( $eString_Attribute !== NULL )
		{
			foreach ( $eSimpleXMLElement->attributes() as $eKey => $eValue )
			{
				if ( $eKey == $eString_Attribute )
				{
					return (string)$eValue;
				}
			}
		}
		else
		{
			return (string)$eSimpleXMLElement;
		}
	}

	return $eString_Default;
}



// ===================================================================
// local
// -------------------------------------------------------------------

function local_SIMPL__CONFIGURATION__SetupConfigurations()
{
	$aaConfigurations = array();

	$eXML_ConfigPath = simplexml_load_file( SIMPL__STRING__FULL_NAME__CONFIG_PATH_XML );
	if ( $eXML_ConfigPath === FALSE )
	{
		$eString_Error = sprintf( "config-path.xml ( %s ) 読み込みエラー", SIMPL__STRING__FULL_NAME__CONFIG_PATH_XML );
		SIMPL__LOG__AddError( $eString_Error );
		exit;
	}

	$aaStrings_Path = array();
	$arSimpleXMLElements_Path = $eXML_ConfigPath->xpath( "//Path" );
	foreach ( $arSimpleXMLElements_Path as $eXML_File )
	{
		if ( SIMPL__CONFIGURATION__CheckState_XML( $eXML_File ) )
		{
			$eString_Group = (string)$eXML_File["Group"];
			$eString_Value = (string)$eXML_File["Value"];

			$aaStrings_Path[$eString_Group] = $eString_Value;
		}
	}

	$aaConfigurations[SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__PATH] = $aaStrings_Path;

	$aaXMLs = array();
	$arSimpleXMLElements_Path = $eXML_ConfigPath->xpath( "//File" );
	foreach ( $arSimpleXMLElements_Path as $eXML_File )
	{
		if ( SIMPL__CONFIGURATION__CheckState_XML( $eXML_File ) )
		{
			$eString_Group = (string)$eXML_File["Group"];
			$eString_Name = (string)$eXML_File["Name"];
			$arSimpleXMLElements = $eXML_ConfigPath->xpath( sprintf( "//Path[@Group = \"%s\"]", $eString_Group ) );
			$eXML_Path = $arSimpleXMLElements[0];
			$eString_FullName = SIMPL__CombinePath( (string)$eXML_Path["Value"], (string)$eXML_File["Value"] );
			$eXML_Config = simplexml_load_file( $eString_FullName );
			if ( $eXML_Config === FALSE )
			{
				$eString_Error = sprintf( "config.xml ( %s ) 読み込みエラー", $eString_FullName );
				SIMPL__LOG__AddError( $eString_Error );
				exit;
			}

			if ( $eString_Name == "default" )
			{
				$aaXMLs[$eString_Group] = $eXML_Config;
			}

			$aaXMLs[( $eString_Group . "." . $eString_Name )] = $eXML_Config;
		}
	}

	$aaConfigurations[SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__XML] = $aaXMLs;

	if ( SIMPL__GetValue( $aaXMLs, "database" ) )
	{
		$eXML_ConfigDatabase = $aaXMLs["database"];
		$arSimpleXMLElements_Database = $eXML_ConfigDatabase->xpath( "//Databases/Default/Default/Database" );
		if ( $arSimpleXMLElements_Database !== FALSE )
		{
			foreach ( $arSimpleXMLElements_Database as $eXML_Database )
			{
				if ( SIMPL__CONFIGURATION__CheckState_XML( $eXML_Database ) )
				{
					$eString_ServerType = SIMPL__CONFIGURATION__GetString_XML( $eXML_Database, "ServerType", "MySQL" );
					$eString_ConnectionType = SIMPL__CONFIGURATION__GetString_XML( $eXML_Database, "ConnectionType", "PDO" );
					$eString_Usage = SIMPL__CONFIGURATION__GetString_XML( $eXML_Database, "Usage", "Default" );
					switch ( $eString_ServerType )
					{
						case "MySQL":
							switch ( $eString_ConnectionType )
							{
								case "PDO":
									$eString_Connection = SIMPL__CONFIGURATION__GetString_XML( $eXML_Database );
									$eString_User = SIMPL__CONFIGURATION__GetString_XML( $eXML_Database, "DatabaseUser" );
									$eString_Password = SIMPL__CONFIGURATION__GetString_XML( $eXML_Database, "DatabasePassword" );
									$aaStrings_DBC = array();
									$aaStrings_DBC["DSN"] = $eString_Connection;
									$aaStrings_DBC["User"] = $eString_User;
									$aaStrings_DBC["Password"] = $eString_Password;
									break;
							}
							break;

						case "MSSQL":
							switch ( $eString_ConnectionType )
							{
								case "PDO":
									break;
							}
							break;
					}

					switch ( $eString_Usage )
					{
						case "Write":
							$aaConfigurations[SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__DEFALUT_DATABASE_CONNECTION__WRITE] = $aaStrings_DBC;
							break;

						case "Read":
						default:
							$aaConfigurations[SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__DEFALUT_DATABASE_CONNECTION__READ] = $aaStrings_DBC;
							break;
					}
				}
			}
		}

		if ( !SIMPL__GetValue( $aaConfigurations, SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__DEFALUT_DATABASE_CONNECTION__READ ) )
		{
			$aaConfigurations[SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__DEFALUT_DATABASE_CONNECTION__READ] = local_SIMPL__CONFIGURATION__GetConfigurations_DefaultDatabase( "Read" );
		}
		if ( !SIMPL__GetValue( $aaConfigurations, SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__DEFALUT_DATABASE_CONNECTION__WRITE ) )
		{
			$aaConfigurations[SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__DEFALUT_DATABASE_CONNECTION__WRITE] = local_SIMPL__CONFIGURATION__GetConfigurations_DefaultDatabase( "Write" );
		}
	}

	if ( SIMPL__GetValue( $aaXMLs, "json-api" ) )
	{
		$eXML_ConfigJSONAPI = $aaXMLs["json-api"];
		$arSimpleXMLElements_Command = $eXML_ConfigJSONAPI->xpath( "//Commands/Command" );
		if ( $arSimpleXMLElements_Command !== FALSE )
		{
			$aaStrings_Command = array();
			foreach ( $arSimpleXMLElements_Command as $eXML_Command )
			{
				if ( SIMPL__CONFIGURATION__CheckState_XML( $eXML_Command ) )
				{
					$eString_Name = SIMPL__CONFIGURATION__GetString_XML( $eXML_Command, "Name" );
					$eString_File = SIMPL__CONFIGURATION__GetString_XML( $eXML_Command, "File" );
					$aaStrings_Command[$eString_Name] = $eString_File;
				}
			}

			$aaConfigurations[SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__JSON__COMMAND_LIST] = $aaStrings_Command;
		}
	}

	return $aaConfigurations;
}


function local_SIMPL__CONFIGURATION__GetConfigurations_DefaultDatabase( $eString_Usage = NULL )
{
	switch ( $eString_Usage )
	{
		case "Write":
			$eString_Connection = "mysql:host=localhost;dbname=SIMPL-d__test;charset=utf8";
			$eString_User = "SIMPL-u__test__write";
			$eString_Password = "SIMPL-p__test__write";
			break;

		default:
			$eString_Connection = "mysql:host=localhost;dbname=SIMPL-d__test;charset=utf8";
			$eString_User = "SIMPL-u__test";
			$eString_Password = "SIMPL-p__test";
			break;
	}

	$aaStrings_DBC = array();
	$aaStrings_DBC["DSN"] = $eString_Connection;
	$aaStrings_DBC["User"] = $eString_User;
	$aaStrings_DBC["Password"] = $eString_Password;

	return $aaStrings_DBC;
}

function local_SIMPL__CONFIGURATION__SetupConfigurations_Default()
{
	$aaConfigurations = array();

	$aaConfigurations[SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__DEFALUT_DATABASE_CONNECTION__READ] = local_SIMPL__CONFIGURATION__GetConfigurations_DefaultDatabase( "Read" );
	$aaConfigurations[SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__DEFALUT_DATABASE_CONNECTION__WRITE] = local_SIMPL__CONFIGURATION__GetConfigurations_DefaultDatabase( "Write" );

	$aaConfigurations[SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__XML] = array();

	return $aaConfigurations;
}



?>