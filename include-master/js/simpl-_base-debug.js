// 日本語UTF-8, LF



// include



// define
const SIMPL__STRING__ELEMENT_CLASS_NAME__DEBUG__DEBUG_VIEW = "simpl__debug_view";
const SIMPL__STRING__ELEMENT_CLASS_NAME__DEBUG__QUERY_SELECTOR = "simpl__debug__query_selector";


const SIMPL__STRING__ELEMENT_ID__DEBUG__DEBUG_VIEW__DIV = "simpl__debug_view";
const SIMPL__STRING__ELEMENT_ID__DEBUG__QUERY_SELECTOR__DIV = "simpl__debug__query_selector";
const SIMPL__STRING__ELEMENT_ID__DEBUG__QUERY_SELECTOR__EDIT__QUERY = "simpl__debug__query_selector__edit_query";
const SIMPL__STRING__ELEMENT_ID__DEBUG__QUERY_SELECTOR__EDIT__TARGET = "simpl__debug__query_selector__edit_target";
const SIMPL__STRING__ELEMENT_ID__DEBUG__QUERY_SELECTOR__SELECT__MODE = "simpl__debug__query_selector__mode_select";



// global
var g_SIMPL__DEBUG__arAttributes_QuerySelector__Saved = [];
var g_SIMPL__DEBUG__arElements_QuerySelector__Saved = [];



// ===================================================================
// public
// -------------------------------------------------------------------

// -------------------------------------------------------------------
// show

function SIMPL__DEBUG__AddDebugView( eString_ElementID )
{
	if ( SIMPL__BOOLEAN__DEBUG )
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
			eElement.id = SIMPL__STRING__ELEMENT_ID__DEBUG__DEBUG_VIEW__DIV;
			eElement.classList.add( SIMPL__STRING__ELEMENT_CLASS_NAME__DEBUG__DEBUG_VIEW );
			if ( SIMPL__BOOLEAN__DEBUG__DEBUG_VIEW__SHOW_STATE )
			{
				eElement.setAttribute( "style", "display: block" );
			}
			else
			{
				eElement.setAttribute( "style", "display: none" );
			}

			eElement_Base.appendChild( eElement );
		}
	}
}


function SIMPL__DEBUG__AddQuerySelector( eString_ElementID, bFlag_NoDiv )
{
	if ( SIMPL__BOOLEAN__DEBUG )
	{
		if ( eString_ElementID == null )
		{
			eString_ElementID = SIMPL__STRING__ELEMENT_ID__DEBUG__DEBUG_VIEW__DIV;
		}

		var eElement_Base = document.getElementById( eString_ElementID );
		if ( eElement_Base != null )
		{
			var eElement;

			if ( !bFlag_NoDiv )
			{
				var eElement_Div = document.createElement( "div" );

				eElement_Div.id = SIMPL__STRING__ELEMENT_ID__DEBUG__QUERY_SELECTOR__DIV;
				eElement_Div.classList.add( SIMPL__STRING__ELEMENT_CLASS_NAME__DEBUG__QUERY_SELECTOR );
				eElement_Base.appendChild( eElement_Div );
				eElement_Base = eElement_Div;
			}

			eElement = document.createElement( "input" );
			eElement.id = SIMPL__STRING__ELEMENT_ID__DEBUG__QUERY_SELECTOR__EDIT__QUERY;
			eElement.classList.add( SIMPL__STRING__ELEMENT_CLASS_NAME__DEBUG__QUERY_SELECTOR );
			eElement.type = "edit";
			eElement.name = "simpl__debug__query_selector__edit_query";
			eElement.value = "";
			eElement.onkeyup = local_SIMPL__DEBUG__QuerySelector_Input_EditQuery__KeyUp;
			eElement_Base.appendChild( eElement );

			eElement = document.createElement( "select" );
			eElement.id = SIMPL__STRING__ELEMENT_ID__DEBUG__QUERY_SELECTOR__SELECT__MODE;
			eElement.classList.add( SIMPL__STRING__ELEMENT_CLASS_NAME__DEBUG__QUERY_SELECTOR );
			eElement.innerHTML = "";
			eElement.innerHTML += "<option value = \"1\" >Count</option>\n";
			eElement.innerHTML += "<option value = \"2\" >Show</option>\n";
			eElement_Base.appendChild( eElement );

			eElement = document.createElement( "input" );
			eElement.id = SIMPL__STRING__ELEMENT_ID__DEBUG__QUERY_SELECTOR__EDIT__TARGET;
			eElement.classList.add( SIMPL__STRING__ELEMENT_CLASS_NAME__DEBUG__QUERY_SELECTOR );
			eElement.type = "edit";
			eElement.name = "simpl__debug__query_selector__edit_target";
			eElement.value = "";
			eElement.onkeyup = local_SIMPL__DEBUG__QuerySelector_Input_EditTarget__KeyUp;
			eElement_Base.appendChild( eElement );
		}
	}
}


// -------------------------------------------------------------------
// output

// subject  : echo
// argument : string, message
function SIMPL__DEBUG__Echo( eString_Message )
{
	if ( SIMPL__BOOLEAN__DEBUG )
	{
		var eElement;

		eElement = document.getElementById( SIMPL__STRING__ELEMENT_ID__DEBUG__DEBUG_VIEW__DIV );
		if ( eElement != null && !SIMPL__BOOLEAN__DEBUG__ECHO__CONSOLE )
		{
			var eElement_Div = document.createElement( "div" );

			eElement_Div.textContent += local_SIMPL__DEBUG__GetString_CallerName( SIMPL__DEBUG__Echo.caller );
			eElement_Div.textContent += eString_Message;
			eElement_Div.textContent += "\n";

			eElement.appendChild( eElement_Div );
		}
		else
		{
			eString_Message = local_SIMPL__DEBUG__GetString_CallerName( SIMPL__DEBUG__Echo.caller ) + eString_Message;

			console.log( eString_Message );
		}
	}
}


// -------------------------------------------------------------------
// stack

// subject  : add message
// argument : string, message
// argument : integer, debug level
function SIMPL__DEBUG__AddMessage( eString_Message, iDebugLevel )
{
	if ( SIMPL__BOOLEAN__DEBUG )
	{
		if ( iDebugLevel == null )
		{
			iDebugLevel = 0;
		}

		console.log( eString_Message );
		local_SIMPL__DEBUG__AddMessage( eString_Message, iDebugLevel );
	}
}



// ===================================================================
// event handler
// -------------------------------------------------------------------

// -------------------------------------------------------------------
// public


// -------------------------------------------------------------------
// private

function local_SIMPL__DEBUG__QuerySelector_Input_EditQuery__KeyUp( e )
{
	if ( e.code == "Enter" )
	{
		var eElement = document.getElementById( SIMPL__STRING__ELEMENT_ID__DEBUG__QUERY_SELECTOR__EDIT__TARGET );
		if ( eElement )
		{
			local_SIMPL__DEBUG__QuerySelector_Execute( e.target.value, eElement.value );
		}

		return false;
	}
}


function local_SIMPL__DEBUG__QuerySelector_Input_EditTarget__KeyUp( e )
{
	if ( e.code == "Enter" )
	{
		var eElement = document.getElementById( SIMPL__STRING__ELEMENT_ID__DEBUG__QUERY_SELECTOR__EDIT__QUERY );
		if ( eElement )
		{
			local_SIMPL__DEBUG__QuerySelector_Execute( eElement.value, e.target.value );
		}

		return false;
	}
}



// ===================================================================
// local
// -------------------------------------------------------------------

function local_SIMPL__DEBUG__AddMessage( eString_Message, iDebugLevel )
{
	// under construction...
}


// subject  : get caller name ( recursive )
// argument : object, caller
// return   : string, caller name
function local_SIMPL__DEBUG__GetString_CallStack( eCaller )
{
	var eString_CallStack = "";

	if ( eCaller.caller != null )
	{
		eString_CallStack = local_SIMPL__DEBUG__GetString_CallStack( eCaller.caller );
		eString_CallStack += " -> ";
	}

	eString_CallStack += eCaller.name;

	return eString_CallStack;
}


// subject  : get caller name
// argument : object, caller
// return   : string, caller name
function local_SIMPL__DEBUG__GetString_CallerName( eCaller )
{
	var eString_CallerName = "";

	if ( SIMPL__BOOLEAN__DEBUG__ECHO__ADD_CALLER_NAME )
	{
		if ( SIMPL__BOOLEAN__DEBUG__ECHO__ADD_CALLER_NAME__CALL_STACK )
		{
			eString_CallerName += local_SIMPL__DEBUG__GetString_CallStack( eCaller );
		}
		else
		{
			eString_CallerName += eCaller.name;
		}

		eString_CallerName += " : ";
	}

	return eString_CallerName;
}


// subject  : execute query selector
// argument : string, query
// argument : string, query
function local_SIMPL__DEBUG__QuerySelector_Execute( eString_Query, eString_Target )
{
	if ( g_SIMPL__DEBUG__arAttributes_QuerySelector__Saved.length > 0 )
	{
		var arElements = g_SIMPL__DEBUG__arElements_QuerySelector__Saved;

		for ( var i = 0; i < g_SIMPL__DEBUG__arAttributes_QuerySelector__Saved.length; i++ )
		{
			arElements[i].setAttribute( "style", g_SIMPL__DEBUG__arAttributes_QuerySelector__Saved[i] );
		}
	}

	if ( !eString_Query )
	{
		return;
	}

	var eElement = document.getElementById( SIMPL__STRING__ELEMENT_ID__DEBUG__QUERY_SELECTOR__SELECT__MODE );
	if ( eElement )
	{
		var eElement_Target = null;

		if ( eString_Target )
		{
			eElement_Target = document.querySelector( eString_Target );
		}

		if ( eElement_Target == null )
		{
			eElement_Target = document;
		}

		var arElements = [];
		try
		{
			arElements = eElement_Target.querySelectorAll( eString_Query );
		}
		catch ( e )
		{
			SIMPL__DEBUG__Echo( e );
		}

		if ( arElements.length > 0 )
		{
			var iMode = 0;

			iMode = parseInt( eElement.value );
			switch ( iMode )
			{
				case 1:
					SIMPL__DEBUG__Echo( arElements.length );
					break;

				case 2:
					g_SIMPL__DEBUG__arElements_QuerySelector__Saved = arElements;
					for ( var i = 0; i < arElements.length; i++ )
					{
						g_SIMPL__DEBUG__arAttributes_QuerySelector__Saved.push( arElements[i].getAttribute( "style" ) );
						arElements[i].setAttribute( "style", "border: 2px dashed #000000" );
					}

					break;
			}
		}
		else
		{
			SIMPL__DEBUG__Echo( "selected element - nothing" );
		}
	}
}



