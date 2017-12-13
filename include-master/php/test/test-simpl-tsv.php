<?php
// 日本語UTF-8, LF



// pre include



// include



// define



// global



// ===================================================================
// test case
// -------------------------------------------------------------------

class Test__SIMPL__TSV extends SIMPL__TEST__UnitTestCase
{
	function Test__1()
	{
		$arResults = array();
		$aaOptions = array();
		$eString_Result = SIMPL__TSV__BuildLTSV( $arResults, $aaOptions );
		$this->CheckEqual_String( $eString_Result, "" );
	}
}



?>