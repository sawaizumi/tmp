<?php
// 日本語UTF-8, LF



// pre include



// include
include( dirname( __FILE__ ) . "/../include-master/php/include-simpl.phps" );



// define



// global



// ===================================================================
// main
// -------------------------------------------------------------------

{
	exit( Main( $argv ) );
}
function Main( $arStrings_Argument )
{
	SIMPL__LOG__Echo( local_ShowMessages() );

	return SIMPL__INTEGER__EXIT_CODE__SUCCESS;
}



// ===================================================================
// local
// -------------------------------------------------------------------

function local_ShowMessages()
{
	$eString_Message = "";

	$eString_Message .= "Hello, Welcome SIMPL.\n";
	$eString_Message .= "\n";

	return $eString_Message;
}



?>