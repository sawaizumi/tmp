<?php
// 日本語UTF-8, LF



// pre include



// include



// define



// global



// ===================================================================
// test case
// -------------------------------------------------------------------

class Test__SIMPL___Functions extends SIMPL__TEST__UnitTestCase
{
	function Test__1()
	{
		$eString_Template = "";
		$aaStrings_Replace = array();
		$eString_Result = SIMPL__ReplaceLabels( $eString_Template, $aaStrings_Replace );
		$this->CheckEqual_String( $eString_Result, "", "message" );
	}
	function Test__2()
	{
		$eString_Template = "";
		$aaStrings_Replace = array();
		$eString_Result = SIMPL__ReplaceLabels( $eString_Template, $aaStrings_Replace );
		$this->CheckEqual_String( $eString_Result, "" );
	}
	function CheckException__Test__3A()
	{
		$eString_Template = "";
		$aaStrings_Replace = array();
		$eString_Result = SIMPL__ReplaceLabels( $eString_Template, $aaStrings_Replace );
	}
	function CheckException__Test__3B()
	{
		throw new Exception("ThrowTest");
	}
	function CheckException__Test__3C()
	{
		throw new Exception__SIMPL("Exception__SIMPL - getMessage()");
	}
	function Test__3()
	{
		$this->CheckNotException( "CheckException__Test__3A", "" );
		$this->CheckException( "CheckException__Test__3B", "Exception" );
		$this->CheckException( "CheckException__Test__3C", "Exception__SIMPL" );
	}
}


class Exception__SIMPL extends Exception
{
}



?>