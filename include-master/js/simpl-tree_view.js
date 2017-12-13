// 日本語UTF-8, LF



// include



// define
const SIMPL__STRING__ELEMENT_CLASS_NAME__TREE_VIEW__BLOCK = "simpl__tree_view__block";
const SIMPL__STRING__ELEMENT_CLASS_NAME__TREE_VIEW__SWITCH = "simpl__tree_view__switch";



// global



// ===================================================================
// public
// -------------------------------------------------------------------

// subject  : tree view initialize
function SIMPL__TREE_VIEW__Initialize()
{
	var arElements;

	arElements = SIMPL__DOM__SelectElementList_ClassName( SIMPL__STRING__ELEMENT_CLASS_NAME__TREE_VIEW__BLOCK );
	SIMPL__TREE_VIEW__AddEventListeners_Block( arElements );

	arElements = SIMPL__DOM__SelectElementList_ClassName( SIMPL__STRING__ELEMENT_CLASS_NAME__TREE_VIEW__SWITCH );
	SIMPL__TREE_VIEW__AddEventListeners_Switch( arElements );
}


function SIMPL__TREE_VIEW__Tree_OpenClose( iID, bFlag_Open )
{
	var arElements;

	arElements = SIMPL__DOM__SelectElementList_ClassName( SIMPL__STRING__ELEMENT_CLASS_NAME__TREE_VIEW__BLOCK );
	[].forEach.call
		(
			arElements,
			function ( eElement )
			{
				if ( eElement.getAttribute( "simpl__id" ) == iID )
				{
					SIMPL__DEBUG__Echo( eElement );
					SIMPL__DEBUG__Echo( iID );
					if ( bFlag_Open == null )
					{
						if ( eElement.style.display == "none" )
						{
							eElement.style.display = "block";
						}
						else
						{
							eElement.style.display = "none";
						}
					}
					else
					{
						if ( bFlag_Open )
						{
							eElement.style.display = "block";
						}
						else
						{
							eElement.style.display = "none";
						}
					}
				}
			}
		);
}


/*
function SIMPL__TREE_VIEW__MoveFocus( eElement, iOffset )
{
	var iID = eElement.getAttribute( "simpl__id" );

	arElements = document.querySelectorAll( SIMPL__STRING__ELEMENT_CLASS_NAME__TREE_VIEW__BLOCK );
	for ( var i = 0; i < arElements.length; i++ )
	{
		if ( eElement.getAttribute( "simpl__id" ) == iID )
		{
			return SIMPL__DOM__SetFocus( arElements, ( i + iOffset ) );
		}
	}

	return -1;
}
*/

// -------------------------------------------------------------------
// event handler


// subject  : click
// argument : object, event
function SIMPL__TREE_VIEW__Span_Switch__Click( e )
{
	e.stopPropagation();

	SIMPL__DEBUG__Echo( e.target );
	if ( e.target == this )
	{
		var iID = this.getAttribute( "simpl__id" );
		SIMPL__TREE_VIEW__Tree_OpenClose( iID );
	}
}


function SIMPL__TREE_VIEW__Span_Switch__KeyDown( e )
{
	SIMPL__DEBUG__Echo( e.code );
	if ( e.code == "ArrowRight" )
	{
		e.preventDefault();
		e.stopPropagation();

		var iID = this.getAttribute( "simpl__id" );
		SIMPL__TREE_VIEW__Tree_OpenClose( iID, true );
	}
	if ( e.code == "ArrowLeft" )
	{
		e.preventDefault();
		e.stopPropagation();

		var iID = this.getAttribute( "simpl__id" );
		SIMPL__TREE_VIEW__Tree_OpenClose( iID, false );
	}
	if ( e.code == "ArrowDown" )
	{
		e.preventDefault();

		SIMPL__DEBUG__Echo( e.target );
		SIMPL__DEBUG__Echo( e.target.parentNode );
		SIMPL__DEBUG__Echo( e.target.parentNode.querySelector( ".simpl__tree_view__block" ) );
//		e.stopPropagation();
//		SIMPL__TREE_VIEW__MoveFocus( e.target, 1 );
	}
	if ( e.code == "ArrowUp" )
	{
		e.preventDefault();

//		e.stopPropagation();
//		SIMPL__TREE_VIEW__MoveFocus( e.target, -1 );
	}
}


// -------------------------------------------------------------------
// 

function SIMPL__TREE_VIEW__AddEventListeners_Block( arElements )
{
	[].forEach.call
		(
			arElements,
			function ( eElement )
			{
			}
		);
}


function SIMPL__TREE_VIEW__AddEventListeners_Switch( arElements )
{
	[].forEach.call
		(
			arElements,
			function ( eElement )
			{
//				eElement.addEventListener( "dragover", SIMPL__DND__DragOver, false );
				eElement.addEventListener( "keydown", SIMPL__TREE_VIEW__Span_Switch__KeyDown, false );
				eElement.addEventListener( "click", SIMPL__TREE_VIEW__Span_Switch__Click, false );
			}
		);
}



// -------------------------------------------------------------------
// 



// ===================================================================
// local
// -------------------------------------------------------------------

function local_SIMPL__TREE_VIEW__()
{
}



