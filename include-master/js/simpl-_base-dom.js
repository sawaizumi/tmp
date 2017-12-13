// 日本語UTF-8, LF



// ===================================================================
// public
// -------------------------------------------------------------------

// subject  : add main view
// argument : string, element id
function SIMPL__DOM__AddMainView( eString_ElementID )
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
		eElement.id = SIMPL__STRING__ELEMENT_ID__MAIN_VIEW__DIV;
		eElement.classList.add( SIMPL__STRING__ELEMENT_CLASS_NAME__MAIN_VIEW );

		eElement_Base.appendChild( eElement );
	}
}


// subject  : create element
// argument : string, element id
// argument : array, class name list
// argument : hash, options
function SIMPL__DOM__CreateElement( eString_TagName, eString_ElementID, arStrings_ClassName, aaOptions )
{
	var eElement;

	eElement = document.createElement( eString_TagName );
	eElement.id = eString_ElementID;

	if ( arStrings_ClassName != null )
	{
		if ( Array.isArray( arStrings_ClassName ) )
		{
			for ( var i = 0; i < arStrings_ClassName.length; i++ )
			{
				eElement.classList.add( arStrings_ClassName[i] );
			}
		}
		else
		{
			eElement.classList.add( arStrings_ClassName );
		}
	}

	if ( aaOptions != null )
	{
		if ( aaOptions["Name"] != null )
		{
			eElement.name = aaOptions["Name"];
		}

		if ( aaOptions["Type"] != null )
		{
			eElement.type = aaOptions["Type"];
		}

		if ( aaOptions["Value"] != null )
		{
			eElement.value = aaOptions["Value"];
		}

		if ( aaOptions["InnerHTML"] != null )
		{
			eElement.innerHTML = aaOptions["InnerHTML"];
		}

		if ( aaOptions["EventListeners"] != null )
		{
			var arEventListeners = aaOptions["EventListeners"];

			for ( var i = 0; i < arEventListeners.length; i++ )
			{
				var aaEventListener = arEventListeners[i];
				eElement.addEventListener( aaEventListener["Event"], aaEventListener["Callback"], aaEventListener["Options"] );
			}
		}
	}

	return eElement;
}


// subject  : select elements
// argument : string, class name
// return   : array, elements
function SIMPL__DOM__SelectElementList_ClassName( eString_ClassName, eElement_Base )
{
	var arElements;

	if ( eElement_Base == null )
	{
		eElement_Base = document;
	}

	arElements = eElement_Base.querySelectorAll( "." + eString_ClassName );

	return arElements;
}


// subject  : select element
// argument : string, class name
// argument : object, base element ( null : document )
// return   : object, element
function SIMPL__DOM__SelectElement_ClassName( eString_ClassName, eElement_Base )
{
	var eElement;

	if ( eElement_Base == null )
	{
		eElement_Base = document;
	}

	eElement = eElement_Base.querySelector( "." + eString_ClassName );

	return eElement;
}


// subject  : set focus
// argument : array, elements
// argument : integer, order
function SIMPL__DOM__SetFocus( arElements, iOrder )
{
	while ( iOrder < 0 )
	{
		iOrder += arElements.length;
	}
	while ( iOrder >= arElements.length )
	{
		iOrder -= arElements.length;
	}

	arElements[iOrder].focus();

	return iOrder;
}



// ===================================================================
// debug
// -------------------------------------------------------------------



// ===================================================================
// local
// -------------------------------------------------------------------

function local_SIMPL__DOM__()
{
}




