<?php
// 日本語UTF-8, LF



// pre include



// include



// define



// global



// ===================================================================
// test case
// -------------------------------------------------------------------

class Test__SIMPL__HTML__Tag extends SIMPL__TEST__UnitTestCase
{
	function Test__1()
	{
		$aaAttributes = SIMPL__HTML__BuildAttributes();
		$aaOptions = SIMPL__HTML__BuildOptions();
		$eString_Result = local_SIMPL__HTML__BuildString_Attributes( $aaAttributes, $aaOptions );
		$this->CheckEqual_String( $eString_Result, "" );
	}
	function Test__2()
	{
		$eString_InnerHTML = "";
		$eString_Indent  = "\t";
		list( $eString_Result, $aaResults ) = local_SIMPL__HTML__RebuildInnerHTML( $eString_InnerHTML, $eString_Indent );
		$this->CheckEqual_String( $eString_Result, "" );
		$this->CheckEqual_NULL( SIMPL__GetValue( $aaResults, "MultiLine" ) );
	}
}



?>