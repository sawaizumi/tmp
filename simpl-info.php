<?php
// 日本語UTF-8, LF



// pre include



// include



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
	if ( count( $arStrings_Argument ) > 1 )
	{
		include( $arStrings_Argument[1] );

		local_EchoTitle( "base informations" );
		echo sprintf( "simpl version : %s ( %s )\n", SIMPL__STRING__VERSION, SIMPL__STRING__RELEASE_DATE );
		echo sprintf( "simpl base path : %s\n", SIMPL__STRING__PATH__BASE__SIMPL );
		echo "\n";

		return SIMPL__INTEGER__EXIT_CODE__SUCCESS;
	}

	return 0;
}



// ===================================================================
// local
// -------------------------------------------------------------------

function local_EchoTitle( $eString_Title )
{
	echo sprintf( "%s\n", SIMPL__STRING__SEPARATOR__COMMENT__LEVEL_00 );
	echo sprintf( "// %s\n", $eString_Title );
	echo sprintf( "%s\n", SIMPL__STRING__SEPARATOR__COMMENT__LEVEL_01 );
	echo "\n";
}



?>