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
	if ( count( $arStrings_Argument ) > 2 )
	{
		include( $arStrings_Argument[1] );
		include( $arStrings_Argument[2] );

		spl_autoload_register( "SIMPL__TEST__UnitTest_AutoLoader_ForSIMPL" );
		spl_autoload_register( "SIMPL__TEST__UnitTest_AutoLoader" );
		SIMPL__TEST__UnitTest_ForSIMPL();

		return SIMPL__INTEGER__EXIT_CODE__SUCCESS;
	}

	return 0;
}



// ===================================================================
// local
// -------------------------------------------------------------------



?>