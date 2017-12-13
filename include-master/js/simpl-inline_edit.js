// 日本語UTF-8, LF



// include



// define
const SIMPL__STRING__ELEMENT_CLASS_NAME__INLINE_EDIT__EDITABLE = "simpl__inline_edit__editable";
const SIMPL__STRING__ELEMENT_CLASS_NAME__INLINE_EDIT__TABABLE = "simpl__inline_edit__tabable";
const SIMPL__STRING__ELEMENT_CLASS_NAME__INLINE_EDIT__LINE = "simpl__inline_edit__line";
const SIMPL__STRING__ELEMENT_CLASS_NAME__INLINE_EDIT__SEPARATOR = "simpl__inline_edit__separator";

const SIMPL__STRING__ELEMENT_ID__INLINE_EDIT__FORM = "simpl__inline_edit-form";
const SIMPL__STRING__ELEMENT_ID__INLINE_EDIT__LIST = "simpl__inline_edit-list";
const SIMPL__STRING__ELEMENT_ID__INLINE_EDIT__CURRENT_EDIT = "simpl__inline_edit-current";

const SIMPL__STRING__EVENT_NAME__INLINE_EDIT__ON_REPLACE_CURRENT_EDIT = "OnReplaceCurrentEdit";



// global
var g_SIMPL__INLINE_EDIT__eString_Edit = "";
var g_SIMPL__INLINE_EDIT__bFlag_Building = false;



// ===================================================================
// public
// -------------------------------------------------------------------

// subject  : add inline edit list
// argument : string, element id
function SIMPL__INLINE_EDIT__AddInlineEditList( eString_ElementID )
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

		eElement = document.createElement( "form" );
		eElement.id = SIMPL__STRING__ELEMENT_ID__INLINE_EDIT__FORM;
		eElement = local_SIMPL__INLINE_EDIT__BuildInlineEditList( eElement );

		eElement_Base.appendChild( eElement );
	}
}


// subject  : inline edit initialize
function SIMPL__INLINE_EDIT__Initialize( fCallback_OnReplaceCurrentEdit )
{
	var arElements;
	var eElement;

	arElements = SIMPL__DOM__SelectElementList_ClassName( SIMPL__STRING__ELEMENT_CLASS_NAME__INLINE_EDIT__EDITABLE );
	SIMPL__INLINE_EDIT__AddEventListeners_Editable( arElements, fCallback_OnReplaceCurrentEdit );

	arElements = SIMPL__DOM__SelectElementList_ClassName( SIMPL__STRING__ELEMENT_CLASS_NAME__INLINE_EDIT__LINE );
	SIMPL__INLINE_EDIT__AddEventListeners_Line( arElements );

	arElements = SIMPL__DOM__SelectElementList_ClassName( SIMPL__STRING__ELEMENT_CLASS_NAME__INLINE_EDIT__SEPARATOR );
	SIMPL__INLINE_EDIT__AddEventListeners_Separator( arElements );

	eElement = document.getElementById( SIMPL__STRING__ELEMENT_ID__INLINE_EDIT__FORM );
	if ( eElement != null )
	{
		eElement.addEventListener( "blur", SIMPL__INLINE_EDIT__Form__FocusOut, true );
	}
}


function SIMPL__INLINE_EDIT__CheckEdited( eString_Edit )
{
	if ( g_SIMPL__INLINE_EDIT__eString_Edit != eString_Edit )
	{
		return true;
	}

	return false;
}


function SIMPL__INLINE_EDIT__BuildInlineEdit( eElement_Span )
{
	var eString_HTML;
	var eElement;

	if ( eElement_Span )
	{
		local_SIMPL__INLINE_EDIT__ReplaceCurrentEdit();

		g_SIMPL__INLINE_EDIT__eString_Edit = eElement_Span.innerHTML;
		eString_HTML = eElement_Span.innerHTML;
		eElement_Span.innerHTML = "";

		eElement = document.createElement("input");
		eElement.id = SIMPL__STRING__ELEMENT_ID__INLINE_EDIT__CURRENT_EDIT;
		eElement.type = "edit";
		eElement.name = "simpl__inline_edit__edit";
		eElement.value = eString_HTML;
		eElement.onkeydown = SIMPL__INLINE_EDIT__Edit__KeyDown;
		eElement.onkeyup = SIMPL__INLINE_EDIT__Edit__KeyUp;
		eElement.onkeypress = SIMPL__INLINE_EDIT__Edit__KeyPress;
		eElement_Span.appendChild( eElement );

		eElement = document.getElementById( SIMPL__STRING__ELEMENT_ID__INLINE_EDIT__CURRENT_EDIT );
		g_SIMPL__INLINE_EDIT__bFlag_Building = true;
		eElement.focus();
		g_SIMPL__INLINE_EDIT__bFlag_Building = false;
	}
}


function SIMPL__INLINE_EDIT__MoveFocus( eElement, iOffset )
{
	arElements = SIMPL__DOM__SelectElementList_ClassName( SIMPL__STRING__ELEMENT_CLASS_NAME__INLINE_EDIT__TABABLE );
	for ( var i = 0; i < arElements.length; i++ )
	{
		if ( arElements[i] === eElement )
		{
			return SIMPL__DOM__SetFocus( arElements, ( i + iOffset ) );
		}
	}

	return -1;
}


// -------------------------------------------------------------------
// event handler


function SIMPL__INLINE_EDIT__Span_Editable__Click( e )
{
	e.stopPropagation();

	SIMPL__INLINE_EDIT__BuildInlineEdit( e.target )
}


function SIMPL__INLINE_EDIT__Span_Editable__KeyDown( e )
{
//	SIMPL__DEBUG__Echo( e );
}


function SIMPL__INLINE_EDIT__Span_Editable__KeyUp( e )
{
	if ( e.code == "Enter" )
	{
		e.stopPropagation();
		e.preventDefault();

		SIMPL__DEBUG__Echo( e );
		SIMPL__INLINE_EDIT__BuildInlineEdit( e.target );

		return false;
	}
}


function SIMPL__INLINE_EDIT__Div_Line__Click( e )
{
	if ( e.target === this )
	{
		SIMPL__INLINE_EDIT__BuildInlineEdit( SIMPL__DOM__SelectElement_ClassName( SIMPL__STRING__ELEMENT_CLASS_NAME__INLINE_EDIT__EDITABLE, e.target ) );

		return false;
	}
}


function SIMPL__INLINE_EDIT__Div_Line__KeyDown( e )
{
	if ( e.code == "ArrowDown" )
	{
		e.preventDefault();
	}
	if ( e.code == "ArrowUp" )
	{
		e.preventDefault();
	}
}


function SIMPL__INLINE_EDIT__Div_Line__KeyUp( e )
{
	var arElements;

	if ( e.code == "Enter" )
	{
		e.stopPropagation();

//		SIMPL__INLINE_EDIT__BuildInlineEdit( SIMPL__DOM__SelectElement_ClassName( SIMPL__STRING__ELEMENT_CLASS_NAME__INLINE_EDIT__EDITABLE, e.target ) );
	}
	if ( e.code == "ArrowDown" )
	{
		SIMPL__INLINE_EDIT__MoveFocus( e.target, 1 );
	}
	if ( e.code == "ArrowUp" )
	{
		SIMPL__INLINE_EDIT__MoveFocus( e.target, -1 );
	}

	return false;
}


function SIMPL__INLINE_EDIT__Form__FocusOut( e )
{
	if ( !g_SIMPL__INLINE_EDIT__bFlag_Building )
	{
		local_SIMPL__INLINE_EDIT__ReplaceCurrentEdit();
	}
}


function SIMPL__INLINE_EDIT__Edit__KeyDown( e )
{
	if ( e.code == "ArrowDown" )
	{
		e.stopPropagation();
	}
	if ( e.code == "ArrowUp" )
	{
		e.stopPropagation();
	}
	if ( e.code == "Enter" )
	{
		e.stopPropagation();
	}
}
function SIMPL__INLINE_EDIT__Edit__KeyUp( e )
{
	if ( e.code == "Escape" )
	{
		document.activeElement.value = g_SIMPL__INLINE_EDIT__eString_Edit;
		document.activeElement.parentNode.parentNode.focus();
	}
	if ( e.code == "Enter" )
	{
		e.stopPropagation();
		document.activeElement.parentNode.parentNode.focus();
	}
}


function SIMPL__INLINE_EDIT__Edit__KeyPress( e )
{
	if ( e.code == "Enter" )
	{
		return false;
	}
}


// -------------------------------------------------------------------
// 

function SIMPL__INLINE_EDIT__AddEventListeners_Editable( arElements, fCallback_OnReplaceCurrentEdit )
{
	[].forEach.call
		(
			arElements,
			function ( eElement )
			{
				eElement.addEventListener( "keyup", SIMPL__INLINE_EDIT__Span_Editable__KeyUp, true );
				eElement.addEventListener( "keydown", SIMPL__INLINE_EDIT__Span_Editable__KeyDown, true );
				eElement.addEventListener( "click", SIMPL__INLINE_EDIT__Span_Editable__Click, true );
				SIMPL__AddCallback( eElement, SIMPL__STRING__EVENT_NAME__INLINE_EDIT__ON_REPLACE_CURRENT_EDIT, fCallback_OnReplaceCurrentEdit );
			}
		);
}


function SIMPL__INLINE_EDIT__AddEventListeners_Line( arElements )
{
	[].forEach.call
		(
			arElements,
			function ( eElement )
			{
				eElement.addEventListener( "keyup", SIMPL__INLINE_EDIT__Div_Line__KeyUp, false );
				eElement.addEventListener( "keydown", SIMPL__INLINE_EDIT__Div_Line__KeyDown, false );
				eElement.addEventListener( "click", SIMPL__INLINE_EDIT__Div_Line__Click, false );
			}
		);
}


function SIMPL__INLINE_EDIT__AddEventListeners_Separator( arElements )
{
	[].forEach.call
		(
			arElements,
			function ( eElement )
			{
			}
		);
}



// ===================================================================
// local
// -------------------------------------------------------------------

function local_SIMPL__INLINE_EDIT__ReplaceCurrentEdit()
{
	var eString_HTML;
	var eElement;

	eElement = document.getElementById( SIMPL__STRING__ELEMENT_ID__INLINE_EDIT__CURRENT_EDIT );
	if ( eElement != null )
	{
		if ( SIMPL__ExecuteCallback( eElement.parentNode, SIMPL__STRING__EVENT_NAME__INLINE_EDIT__ON_REPLACE_CURRENT_EDIT )( eElement.parentNode, eElement.value ) )
		{
			eString_HTML = eElement.value;
			eElement.parentNode.innerHTML = eString_HTML;
		}
		else
		{
			eElement.parentNode.innerHTML = g_SIMPL__INLINE_EDIT__eString_Edit;
		}
	}

	return false;
}


function local_SIMPL__INLINE_EDIT__BuildInlineEditList( eElement_Base )
{
	var eElement;

	eElement = document.createElement( "div" );
	eElement.id = SIMPL__STRING__ELEMENT_ID__INLINE_EDIT__LIST;

	eElement_Base.appendChild( eElement );

	return eElement_Base;
}



