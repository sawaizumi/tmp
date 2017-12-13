// 日本語UTF-8, LF



// include



// define
const SIMPL__STRING__ELEMENT_CLASS_NAME__DND__DRAGGABLE = "simpl__dnd__draggable";
const SIMPL__STRING__ELEMENT_CLASS_NAME__DND__DROPABLE = "simpl__dnd__dropable";
const SIMPL__STRING__ELEMENT_CLASS_NAME__DND__DRAG = "simpl__dnd__drag";
const SIMPL__STRING__ELEMENT_CLASS_NAME__DND__OVER = "simpl__dnd__over";



// global
var g_SIMPL__DND__eElement_Drag = null;
var g_SIMPL__DND__arElements_Over = [];



// ===================================================================
// public
// -------------------------------------------------------------------

// subject  : drag and drop initialize
function SIMPL__DND__Initialize( fCallback_Drop )
{
	var arElements;

	arElements = SIMPL__DOM__SelectElementList_ClassName( SIMPL__STRING__ELEMENT_CLASS_NAME__DND__DRAGGABLE );
	SIMPL__DND__AddEventListeners_Draggable( arElements );

	arElements = SIMPL__DOM__SelectElementList_ClassName( SIMPL__STRING__ELEMENT_CLASS_NAME__DND__DROPABLE );
	SIMPL__DND__AddEventListeners_Dropable( arElements, fCallback_Drop );
}


// -------------------------------------------------------------------
// event handler


// subject  : drag start
// argument : object, event
function SIMPL__DND__DragStart( e )
{
	this.classList.add( SIMPL__STRING__ELEMENT_CLASS_NAME__DND__DRAG );

	e.dataTransfer.effectAllowd = "move";
	e.dataTransfer.setData( "text/html", this.innerHTML );
	e.dataTransfer.setData( "e", this.innerHTML );

	g_SIMPL__DND__eElement_Drag = this;
}


function SIMPL__DND__DragEnd( e )
{
	this.classList.remove( SIMPL__STRING__ELEMENT_CLASS_NAME__DND__DRAG );
	[].forEach.call
	(
		g_SIMPL__DND__arElements_Over,
		function ( eElement )
		{
			eElement.classList.remove( SIMPL__STRING__ELEMENT_CLASS_NAME__DND__OVER );
		}
	);

	g_SIMPL__DND__eElement_Drag = null;
	g_SIMPL__DND__arElements_Over = [];
}


function SIMPL__DND__DragEnter( e )
{
	this.classList.add( SIMPL__STRING__ELEMENT_CLASS_NAME__DND__OVER );
	g_SIMPL__DND__arElements_Over.push( this );
}


function SIMPL__DND__DragLeave( e )
{
	this.classList.remove( SIMPL__STRING__ELEMENT_CLASS_NAME__DND__OVER );
}


function SIMPL__DND__DragOver( e )
{
	if ( e.preventDefault )
	{
		e.preventDefault();
	}

	e.dataTransfer.dropEffect = "move";

	return false;
}


function SIMPL__DND__Drop( e )
{
	if ( e.stopPropagation )
	{
		e.stopPropagation();
	}

	if ( g_SIMPL__DND__eElement_Drag != null )
	{
		if ( g_SIMPL__DND__eElement_Drag != this )
		{
			g_SIMPL__DND__eElement_Drag.innerHTML = this.innerHTML;
			this.innerHTML = e.dataTransfer.getData( "text/html" );
		}
	}

	return false;
}


// -------------------------------------------------------------------
// 

function SIMPL__DND__AddEventListeners_Draggable( arElements )
{
	[].forEach.call
		(
			arElements,
			function ( eElement )
			{
				eElement.addEventListener( "dragstart", SIMPL__DND__DragStart, false );
				eElement.addEventListener( "dragend", SIMPL__DND__DragEnd, false );
//				eElement.addEventListener( "dragenter", SIMPL__DND__DragEnter, false );
//				eElement.addEventListener( "dragleave", SIMPL__DND__DragLeave, false );
//				eElement.addEventListener( "dragover", SIMPL__DND__DragOver, false );
//				eElement.addEventListener( "drop", SIMPL__DND__Drop, false );
			}
		);
}


function SIMPL__DND__AddEventListeners_Dropable( arElements, fCallback_Drop )
{
	[].forEach.call
		(
			arElements,
			function ( eElement )
			{
//				eElement.addEventListener( "dragstart", SIMPL__DND__DragStart, false );
//				eElement.addEventListener( "dragend", SIMPL__DND__DragEnd, false );
				eElement.addEventListener( "dragenter", SIMPL__DND__DragEnter, false );
				eElement.addEventListener( "dragleave", SIMPL__DND__DragLeave, false );
				eElement.addEventListener( "dragover", SIMPL__DND__DragOver, false );
				eElement.addEventListener( "drop", fCallback_Drop, false );
			}
		);
}



// -------------------------------------------------------------------
// 



// ===================================================================
// local
// -------------------------------------------------------------------

function local_SIMPL__DND__()
{
}



