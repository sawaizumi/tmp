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

		// テスト用クラスのオートローダを指定
		spl_autoload_register( "local_AutoLoader" );

		// テスト用クラスを生成して実行
		SIMPL__TEST__UnitTest( new Test___Sample() );

		return SIMPL__INTEGER__EXIT_CODE__SUCCESS;
	}

	return 0;
}



// ===================================================================
// test sample
// -------------------------------------------------------------------

function SampleFunction( $eString = "Test" )
{
	return $eString;
}



// ===================================================================
// local
// -------------------------------------------------------------------

function local_AutoLoader( $eString_ClassName )
{
	// Test__*クラスを同ディレクトリ内のtest-xxx.phpからロードする
	$eString_FullName = sprintf( "%s/%s.php", dirname( __FILE__ ), strtolower( str_replace( "Test__", "test-", $eString_ClassName ) ) );
	echo sprintf( "autoload : %s ( %s )\n", $eString_FullName, $eString_ClassName );

	include $eString_FullName;
}



?>