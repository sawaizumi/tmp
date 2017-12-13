<?php
// 日本語UTF-8, LF



// include



// define
define( "SIMPL__STRING__DATABASE__USAGE___DEFAULT", "[Default]" );
define( "SIMPL__STRING__DATABASE__USAGE__WRITE", "Write" );



// global



// ===================================================================
// public
// -------------------------------------------------------------------

// ===================================================================
// public ( aliases )
// -------------------------------------------------------------------


// -------------------------------------------------------------------
// configuration

function SIMPL__GetConfigurations( $eString_ConfigurationName = NULL )
{
	return SIMPL__CONFIGURATION__GetConfigurations( $eString_ConfigurationName );
}


// -------------------------------------------------------------------
// database

function SIMPL__BeginTransaction( $eDB )
{
	return $eDB->beginTransaction();
}


function SIMPL__CommitTransaction( $eDB )
{
	return $eDB->commit();
}


function SIMPL__GetDatabase_Direct( $eString_Connection, $eString_User, $eString_Password )
{
	$aaStrings_DBC = array();
	$aaStrings_DBC["DSN"] = $eString_Connection;
	$aaStrings_DBC["User"] = $eString_User;
	$aaStrings_DBC["Password"] = $eString_Password;
	$eDB = SIMPL__DATABASE__GetDB( $aaStrings_DBC );

	return $eDB;
}


function SIMPL__GetDatabase( $eString_Category = NULL, $eString_Group = NULL, $iID = NULL, $eString_Usage = NULL )
{
	$aaConfigurations = SIMPL__GetConfigurations();

	if ( $eString_Usage == SIMPL__STRING__DATABASE__USAGE__WRITE )
	{
		$aaStrings_DBC = $aaConfigurations[SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__DEFALUT_DATABASE_CONNECTION__WRITE];
	}
	else
	{
		$aaStrings_DBC = $aaConfigurations[SIMPL__STRING__CONFIGURATION__CONFIGURATION_KEY__DEFALUT_DATABASE_CONNECTION__READ];
	}

	$eDB = SIMPL__DATABASE__GetDB( $aaStrings_DBC );

	return $eDB;
}


function SIMPL__ExecuteQuery( $eDB, $eString_Query, $arArguments = NULL )
{
	return SIMPL__DATABASE__GetValues_All( $eDB, $eString_Query, $arArguments );
}


function SIMPL__ExecuteQuery_Only( $eDB, $eString_Query, $arArguments = NULL )
{
	return SIMPL__DATABASE__SetValues( $eDB, $eString_Query, $arArguments );
}


function SIMPL__ExecuteQuery_SelectLine( $eDB, $eString_Query, $arArguments = NULL )
{
	return SIMPL__DATABASE__GetValues_Line( $eDB, $eString_Query, $arArguments );
}
/*
{
	$aaResults = array();

	if ( $arArguments === NULL )
	{
		$arArguments = array();
	}

	$eStatement = $eDB->prepare( $eString_Query );
	$eStatement->execute( $arArguments );
	if ( $eRow = $eStatement->fetch( PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT ) )
	{
		$aaResults = $eRow;
	}

	return $aaResults;
}
*/


function SIMPL__ExecuteQuery_SelectOne( $eDB, $eString_Query, $arArguments = NULL )
{
	return SIMPL__DATABASE__GetValues_One( $eDB, $eString_Query, $arArguments );
}


// -------------------------------------------------------------------
// html


function SIMPL__BuildHTML( $aaBlocks = NULL )
{
	if ( $aaBlocks === NULL )
	{
		$eString_HTML = "no data";
		$eString_HTML .= "<br />\n";
	}
	else
	{
		$eString_HTML = "show data";
		$eString_HTML .= "<br />\n";
		$eString_HTML .= SDVB__BLOCK__BuildHTML( $aaBlocks );
	}

	return $eString_HTML;
}


function SIMPL__BuildHTML_Table( $arResults = NULL, $aaOptions = NULL )
{
	return SIMPL__HTML__BuildHTML_SimpleTable( $arResults, $aaOptions );
}


function SIMPL__EscapeHTML( $eString )
{
	return htmlspecialchars( $eString, ENT_QUOTES, "UTF-8" );
}


function SIMPL__Redirect( $eString_URL, $bFlag_Exit = TRUE )
{
	header( "Location: " . $eString_URL );

	if ( $bFlag_Exit )
	{
		exit;
	}
}


function SIMPL__ShowHTML( $eString_HTML = NULL, $eString_Template = NULL, $aaStrings_Replace = NULL )
{
	if ( $eString_HTML === NULL )
	{
		$eString_HTML = "default page";
	}

	if ( $eString_Template !== NULL )
	{
		if ( $aaStrings_Replace === NULL )
		{
			$aaStrings_Replace = array();
		}

		$aaStrings_Replace["__BODY__"] = $eString_HTML;
		$eString_HTML = SIMPL__ReplaceLabels( $eString_Template, $aaStrings_Replace );
	}

	echo $eString_HTML;
}


// -------------------------------------------------------------------
// json

function SIMPL__BuildResponse_JSON( $aaRequest = NULL, $aaResponse = NULL, $aaErrors = NULL, $aaDebugLogs = NULL )
{
	return SIMPL__JSON__BuildResponse( $aaRequest, $aaResponse, $aaErrors, $aaDebugLogs );
}


function SIMPL__ShowJSON( $eJSON = NULL, $aaOptions = NULL )
{
	return SIMPL__JSON__ShowJSON( $eJSON, $aaOptions );
}


// -------------------------------------------------------------------
// ltsv

function SIMPL__BuildLTSV( $arResults = NULL, $aaOptions = NULL )
{
	return SIMPL__TSV__BuildLTSV( $arResults, $aaOptions );
}


// -------------------------------------------------------------------
// preg

function SIMPL__AddDelimiter( $eString_Pattern, $eString_Delimiter_Begin = NULL, $eString_Delimiter_End = NULL )
{
	if ( $eString_Delimiter_Begin === NULL )
	{
		$eString_Delimiter_Begin = "{";
		$eString_Delimiter_End = "}";
	}
	else
	{
		if ( $eString_Delimiter_End === NULL )
		{
			$eString_Delimiter_End = $eString_Delimiter_Begin;
		}
	}

	return ( $eString_Delimiter_Begin . $eString_Pattern . $eString_Delimiter_End );
}


// -------------------------------------------------------------------
// tsv

function SIMPL__BuildTSV( $arResults = NULL, $aaOptions = NULL )
{
	return SIMPL__TSV__BuildTSV( $arResults, $aaOptions );
}


// -------------------------------------------------------------------
// wrap

function SIMPL__WRAP__BuildHTML_AnalyzeObject( $eObject, $eString_Indent = "" )
{
	$eString_HTML = "";

	if ( is_array( $eObject ) )
	{
		if ( is_assoc( $eObject ) )
		{
			$eString_HTML .= $eString_Indent;
			$eString_HTML .= "Assoc(<br />\n";

			foreach ( $eObject as $eKey => $eValue )
			{
				
				$eString_HTML .= $eString_Indent . "\t";
				$eString_HTML .= "Key : [";
				$eString_HTML .= print_r( $eKey, TRUE );
				$eString_HTML .= "]<br />\n";
				$eString_HTML .= $eString_Indent . "\t";
				$eString_HTML .= "Value : [<br />\n";
				$eString_HTML .= SIMPL__WRAP__BuildHTML_AnalyzeObject( $eValue, ( $eString_Indent . "\t\t" ) );
				$eString_HTML .= $eString_Indent . "\t";
				$eString_HTML .= "]<br />\n";
			}

			$eString_HTML .= $eString_Indent;
			$eString_HTML .= ")<br />\n";
		}
		else
		{
			$eString_HTML .= $eString_Indent;
			$eString_HTML .= "Array(<br />\n";

			foreach ( $eObject as $eRow )
			{
				$eString_HTML .= $eString_Indent . "\t";
				$eString_HTML .= print_r( $eRow, TRUE );
				$eString_HTML .= "<br />\n";
			}

			$eString_HTML .= $eString_Indent;
			$eString_HTML .= ")<br />\n";
		}
	}
	else
	{
		$eString_HTML .= $eString_Indent;
		$eString_HTML .= print_r( $eObject, TRUE );
		$eString_HTML .= "<br />\n";
	}

	return $eString_HTML;
}


function SIMPL__WRAP__ShowVariables( $eDB, $eString_Like = "" )
{
	if ( $eString_Like == "" )
	{
		$eString_Query = "SHOW VARIABLES;";
	}
	else
	{
		$eString_Query = "SHOW VARIABLES LIKE '" . $eString_Like . "';";
	}

	return SIMPL__ExecuteQuery( $eDB, $eString_Query );
}


function SIMPL__WRAP__ShowTables( $eDB )
{
	$eString_Query = "SHOW TABLES;";

	return SIMPL__ExecuteQuery( $eDB, $eString_Query );
}


function SIMPL__WRAP__GetList_Tables( $eDB )
{
	$arStrings_TableName = array();

	$arResults = SIMPL__WRAP__ShowTables( $eDB );
	foreach ( $arResults as $eRow )
	{
		$arKeys = array_keys( $eRow );
		foreach ( $arKeys as $eKey )
		{
			if ( mb_substr( $eKey, 0, 10 ) == "Tables_in_" )
			{
				$arStrings_TableName[] = $eRow[$eKey];
			}
		}
	}

	return $arStrings_TableName;
}



// ===================================================================
// local
// -------------------------------------------------------------------

function local_SIMPL__WRAP__AddString( $eValue, $eString_Text = "", $eString_Separator = "\t" )
{
	if ( $eString_Text != "" )
	{
		$eString_Text .= $eString_Separator;
	}

	$eString_Text .= $eValue;

	return $eString_Text;
}



// -------------------------------------------------------------------
// build html



// -------------------------------------------------------------------
// simpl entity

function local_SIMPL__WRAP__RebuildPath()
{
	$eString_Path = "/";

	if ( SIMPL__GetValue( $_REQUEST, "account" ) !== FALSE )
	{
		$eString_Path .= sprintf( "account/%s/", $_REQUEST["account"] );
	}
	if ( SIMPL__GetValue( $_REQUEST, "action" ) )
	{
		$eString_Path .= sprintf( "%s/", $_REQUEST["action"] );
	}

	return $eString_Path;
}



?>