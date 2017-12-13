// 日本語UTF-8, LF



// include



// define



// global
var g_SIMPL__aaSIMPL;
g_SIMPL__aaSIMPL = [];



// ===================================================================
// public
// -------------------------------------------------------------------

function SIMPL__Initialize( eString_Key )
{
	var eSIMPL = [];

	SIMPL__SetEntity( $eString_Key, $eSIMPL );

	return eSIMPL;
}


function SIMPL__Finalize( eString_Key )
{
	SIMPL__SetEntity( eString_Key );
}



// ===================================================================
// public ( aliases )
// -------------------------------------------------------------------

// -------------------------------------------------------------------
// simpl entity

function SIMPL__GetEntity( eString_Key )
{
	eString_Key = SIMPL__CheckReplace_NULL( eString_Key );

	return g_SIMPL__aaSIMPL[eString_Key];
}


function SIMPL__SetEntity( eString_Key, eSIMPL )
{
	eString_Key = SIMPL__CheckReplace_NULL( eString_Key );

	g_SIMPL__aaSIMPL[eString_Key] = eSIMPL;
}



