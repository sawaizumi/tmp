// 日本語UTF-8, LF



// ===================================================================
// callback
// -------------------------------------------------------------------

function SIMPL__AddCallback( eElement, eString_Key, fCallback )
{
	if ( eElement.simpl__callback == null )
	{
		eElement.simpl__callback = [];
	}

	eElement.simpl__callback[eString_Key] = fCallback;
}


function SIMPL__ExecuteCallback( eElement, eString_Key, fCallback )
{
	if ( eElement.simpl__callback != null )
	{
		if ( eElement.simpl__callback[eString_Key] != null )
		{
			return eElement.simpl__callback[eString_Key];
		}
	}

	return function () { return null; };
}



// ===================================================================
// define operation
// -------------------------------------------------------------------



// ===================================================================
// file operation
// -------------------------------------------------------------------



// ===================================================================
// hash operation
// -------------------------------------------------------------------



// ===================================================================
// random data
// -------------------------------------------------------------------



// ===================================================================
// string operation
// -------------------------------------------------------------------

// subject  : replace labels
// argument : string, template
// argument : hash, replace strings
// return   : string, result
function SIMPL__ReplaceLabels( eString_Template, aaStrings_Replace )
{
	if ( aaStrings_Replace !== null )
	{
		aaStrings_Replace.forEach( function ( eValue, eKey ) { eString_Template = eString_Template.replace( new RegExp( eKey, "gm" ), eValue ); } );
	}

	return eString_Template;
}


// subject  : check and replace NULL
// argument : string, value
// argument : string, default value
// return   : string, result
function SIMPL__CheckReplace_NULL( eString_Value, eString_Default = SIMPL__STRING__KEYWORD___DEFAULT )
{
	if ( eString_Default == null )
	{
		eString_Default = SIMPL__STRING__KEYWORD___DEFAULT
	}

	if ( eString_Value == null )
	{
		eString_Value = eString_Default;
	}

	return eString_Value;
}



// ===================================================================
// local
// -------------------------------------------------------------------



