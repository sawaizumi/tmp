// 日本語UTF-8, LF



// include



// define
/*
	// SIMPL__INTEGER__LOG__LOG_TYPE__
	// SIMPL__STRING__LOG__LOG_TYPE__
g_SIMPL__tmp_arDefines = array();
g_SIMPL__tmp_arDefines[] = array( "ERROR", "Error" );
g_SIMPL__tmp_arDefines[] = array( "WARNING", "Warning" );
g_SIMPL__tmp_arDefines[] = array( "NOTICE", "Notice" );
g_SIMPL__tmp_aaLogTypes = SIMPL__BuildDefines_EnumString( g_SIMPL__tmp_arDefines, "LOG_TYPE", "LOG", 1 );
	// SIMPL__INTEGER__LOG__LOG_LEVEL__
g_SIMPL__tmp_arDefines = array();
g_SIMPL__tmp_arDefines[] = array( "_DEFAULT", 0 );
g_SIMPL__tmp_arDefines[] = array( "ALL", 0 );
SIMPL__BuildDefines_Enum( g_SIMPL__tmp_arDefines, "LOG_LEVEL", "LOG" );



// global
var g_SIMPL__aaLogStates;
var g_SIMPL__aaLogs;
var g_SIMPL__aaLogTypes;
g_SIMPL__aaLogStates = [];
g_SIMPL__aaLogs = [];
g_SIMPL__aaLogTypes = g_SIMPL__tmp_aaLogTypes;
*/


// ===================================================================
// public
// -------------------------------------------------------------------


// subject  : add log view
// argument : string, element id
function SIMPL__LOG__AddLogView( eString_ElementID )
{
	var eElement_Base = null;

	if ( eString_ElementID == null )
	{
		var arElements = document.getElementsByTagName( "body" );

		if ( arElements != null )
		{
			eElement_Base = arElements[0];
		}
	}
	else
	{
		eElement_Base = document.getElementById( eString_ElementID );
	}

	if ( eElement_Base != null )
	{
		var eElement;

		eElement = document.createElement( "div" );
		eElement.id = SIMPL__STRING__ELEMENT_ID__LOG_VIEW__DIV;
		eElement.classList.add( SIMPL__STRING__ELEMENT_CLASS_NAME__LOG_VIEW );

		eElement_Base.appendChild( eElement );
	}
}


// -------------------------------------------------------------------
// output

// subject  : echo
// argument : string, message
function SIMPL__LOG__Echo( eString_Message )
{
	var eElement;

	eElement = document.getElementById( SIMPL__STRING__ELEMENT_ID__LOG_VIEW__DIV );
	if ( eElement != null && !SIMPL__BOOLEAN__LOG__ECHO__CONSOLE )
	{
		eElement.innerHTML += "<div>\n";

		eElement.innerHTML += eString_Message;
		eElement.innerHTML += "\n";

		eElement.innerHTML += "</div>\n";
	}
	else
	{
		console.log( eString_Message );
	}
}


// -------------------------------------------------------------------
// stack

// subject  : add error
// argument : string, message
// argument : integer, log level
function SIMPL__LOG__AddError( eString_Message, iLogLevel = 0 )
{
	console.error( eString_Message );
	local_SIMPL__LOG__AddLogMessage( eString_Message, SIMPL__INTEGER__LOG__LOG_TYPE__ERROR, iLogLevel );
}



// ===================================================================
// debug
// -------------------------------------------------------------------



// ===================================================================
// local
// -------------------------------------------------------------------

function local_SIMPL__LOG__AddLogMessage( eString_Message, iLogType, iLogLevel )
{
	arLogs = local_SIMPL__LOG__GetLogs( iLogType );

	arLogs.add( [ iLogLevel, eString_Message ] );

	local_SIMPL__LOG__SetLogs( iLogType, arLogs );
}


function local_SIMPL__LOG__GetLogs( iLogType )
{
	if ( array_key_exists( iLogType, g_SIMPL__aaLogs ) == FALSE )
	{
		g_SIMPL__aaLogs[iLogType] = [];
	}

	return g_SIMPL__aaLogs[iLogType];
}


function local_SIMPL__LOG__SetLogs( iLogType, arLogs )
{
	if ( arLogs == NULL )
	{
		arLogs = [];
	}

	g_SIMPL__aaLogs[iLogType] = arLogs;
}



