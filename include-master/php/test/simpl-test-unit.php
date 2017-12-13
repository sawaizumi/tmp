<?php
// 日本語UTF-8, LF



// include



// define



// global
global $g_SIMPL__aaTestResults;
$g_SIMPL__aaTestResults = array();
$g_SIMPL__aaTestResults["Total"] = 0;
$g_SIMPL__aaTestResults["Error"] = 0;
$g_SIMPL__aaTestResults["Warning"] = 0;



// ===================================================================
// class
// -------------------------------------------------------------------

class SIMPL__TEST__UnitTestCase
{
	// properties
	protected $m_iCount_Total = 0;
	protected $m_iCount_Error = 0;
	protected $m_iCount_Warning = 0;
	protected $m_eString_Message = "";
	protected $m_eString_MethodName = "";
	protected $m_eString_Check = "";
	protected $m_eString_Result = "";


	// methods
	// ===============================================================
	// results
	// ---------------------------------------------------------------
	// add result

	function AddError( $eString_Message = NULL )
	{
		$this->m_iCount_Total++;
		$this->m_iCount_Error++;
		$this->m_eString_Result = "Error";
		$this->AddMessage( $eString_Message );
	}

	function AddSuccess()
	{
		$this->m_iCount_Total++;
		$this->m_eString_Result = "Success";
	}

	function AddWarning()
	{
		$this->m_iCount_Total++;
		$this->m_iCount_Warning++;
		$this->m_eString_Result = "Warning";
	}

	function AddMessages( $arStrings_Message )
	{
		if ( is_array( $arStrings_Message ) )
		{
			foreach ( $arStrings_Message as $eString_Message )
			{
				$this->m_eString_Message .= sprintf( "%s\n", $eString_Message );
			}
		}
		else
		{
			$this->m_eString_Message .= sprintf( "%s\n", $arStrings_Message );
		}
	}

	function AddMessage( $eString_Message )
	{
		if ( $eString_Message !== NULL )
		{
			$this->m_eString_Message .= $eString_Message;
		}
	}

	function SetCheck( $eString_Check )
	{
		$this->m_eString_Check = $eString_Check;
	}

	function AddResult()
	{
		$this->m_eString_Message .= sprintf( "%s [ %s ] - %s\n", $this->m_eString_MethodName, $this->m_eString_Check, $this->m_eString_Result );
	}

	function AddResults()
	{
		global $g_SIMPL__aaTestResults;

		$g_SIMPL__aaTestResults["Total"] += $this->m_iCount_Total;
		$g_SIMPL__aaTestResults["Error"] += $this->m_iCount_Error;
		$g_SIMPL__aaTestResults["Warning"] += $this->m_iCount_Warning;
	}


	// ---------------------------------------------------------------
	// show result

	function ShowResults()
	{
		echo $this->m_eString_Message;
		echo sprintf( "%s\n", SIMPL__STRING__SEPARATOR__COMMENT__LEVEL_01 );
		echo sprintf( "Total : %d\n", $this->m_iCount_Total );
		echo sprintf( "Error : %d\n", $this->m_iCount_Error );
		echo sprintf( "Warning : %d\n", $this->m_iCount_Warning );
		echo "\n";
	}

	// ===============================================================
	// setup/teardown
	// ---------------------------------------------------------------
	// setup

	function Setup()
	{
	}


	// ---------------------------------------------------------------
	// teardown

	function Teardown()
	{
	}


	// ---------------------------------------------------------------
	// etc.

	function GetMethodName()
	{
		return $this->m_eString_MethodName;
	}


	function SetMethodName( $eString_MethodName )
	{
		$this->m_eString_MethodName = $eString_MethodName;
	}


	function StartTest( $eString_ClassName )
	{
		$this->m_eString_Message .= sprintf( "%s\n", SIMPL__STRING__SEPARATOR__COMMENT__LEVEL_00 );
		$this->m_eString_Message .= sprintf( "// %s\n", $eString_ClassName );
		$this->m_eString_Message .= sprintf( "%s\n", SIMPL__STRING__SEPARATOR__COMMENT__LEVEL_01 );
	}


	// ===============================================================
	// check
	// ---------------------------------------------------------------
	// check equal

	function CheckEqual_String( $eString_Result, $eString_Test, $eString_Message = NULL )
	{
		$this->SetCheck( sprintf( "CheckEqual:String( '%s', '%s' )", $eString_Result, $eString_Test ) );

		if ( (string)$eString_Result == (string)$eString_Test )
		{
			$this->AddSuccess();
		}
		else
		{
			$this->AddError();
		}

		$this->AddResult();
	}


	function CheckEqual_Integer( $iResult, $iTest, $eString_Message = NULL )
	{
		$this->SetCheck( sprintf( "CheckEqual:Integer( %s, %s )", $iResult, $iTest ) );

		if ( intval( $iResult ) == intval( $iTest ) )
		{
			$this->AddSuccess();
		}
		else
		{
			$this->AddError();
		}

		$this->AddResult();
	}


	function CheckEqual_NULL( $eResult, $eString_Message = NULL )
	{
		$this->SetCheck( sprintf( "CheckEqual:NULL( %s )", SIMPL__CheckReplace_NULL( $eResult ) ) );

		if ( $eResult === NULL )
		{
			$this->AddSuccess();
		}
		else
		{
			$this->AddError();
		}

		$this->AddResult();
	}


	// ---------------------------------------------------------------
	// check exception

	function CheckException( $eString_MethodName, $eString_ClassName )
	{
		$this->SetCheck( sprintf( "CheckException:%s( %s )", $eString_MethodName, $eString_ClassName ) );

		try
		{
			$this->$eString_MethodName();
			$this->AddError( "No Throwing...\n" );
		}
		catch ( Exception $e )
		{
			if ( get_class( $e ) == $eString_ClassName )
			{
				$this->AddSuccess();
			}
			else
			{
				$this->AddError( sprintf( "%s : %s\n", get_class( $e ), $e->getMessage() ) );
			}
		}
		finally
		{
		}

		$this->AddResult();
	}


	function CheckNotException( $eString_MethodName )
	{
		$this->SetCheck( sprintf( "CheckNotException:%s", $eString_MethodName ) );

		try
		{
			$this->$eString_MethodName();
			$this->AddSuccess();
		}
		catch ( Exception $e )
		{
			$this->AddError( sprintf( "%s : %s\n", get_class( $e ), $e->getMessage() ) );
		}
		finally
		{
		}

		$this->AddResult();
	}
}



// ===================================================================
// public
// -------------------------------------------------------------------
// unit test

function SIMPL__TEST__UnitTest( $eInstance )
{
	$eInstance->StartTest( get_class( $eInstance ) );

	$arStrings_MethodName = get_class_methods( $eInstance );
	foreach ( $arStrings_MethodName as $eString_MethodName )
	{
		if ( mb_substr( $eString_MethodName, 0, 6 ) == "Test__" )
		{
			$eInstance->SetMethodName( $eString_MethodName );
			$eInstance->Setup();
			$eInstance->$eString_MethodName();
			$eInstance->Teardown();
		}
	}

	$eInstance->AddResults();
	$eInstance->ShowResults();
}


function SIMPL__TEST__UnitTest_ForSIMPL()
{
	SIMPL__TEST__UnitTest( new Test__SIMPL___Functions() );
	SIMPL__TEST__UnitTest( new Test__SIMPL__HTML__Tag() );
	SIMPL__TEST__UnitTest( new Test__SIMPL__TSV() );
	SIMPL__TEST__UnitTest_ShowResults();
}


// -------------------------------------------------------------------
// show result

function SIMPL__TEST__UnitTest_ShowResults()
{
	global $g_SIMPL__aaTestResults;

	echo "\n";
	echo sprintf( "%s\n", SIMPL__STRING__SEPARATOR__COMMENT__LEVEL_00 );
	echo "// All\n";
	echo sprintf( "%s\n", SIMPL__STRING__SEPARATOR__COMMENT__LEVEL_01 );
	echo sprintf( "Total : %d\n", $g_SIMPL__aaTestResults["Total"] );
	echo sprintf( "Error : %d\n", $g_SIMPL__aaTestResults["Error"] );
	echo sprintf( "Warning : %d\n", $g_SIMPL__aaTestResults["Warning"] );
	echo "\n";
}


// -------------------------------------------------------------------
// auto load

function SIMPL__TEST__UnitTest_AutoLoader_ForSIMPL( $eString_ClassName, $eString_BasePath = NULL )
{
	if ( $eString_BasePath === NULL )
	{
		$eString_BasePath = dirname( __FILE__ );
	}

	$eString_Replaced = str_replace( "__SIMPL__", "-SIMPL-", $eString_ClassName );
	$eString_Replaced = str_replace( "__", "-", $eString_Replaced );
	$eString_Replaced = strtolower( $eString_Replaced );
	$eString_FullName = sprintf( "%s/%s.php", $eString_BasePath, $eString_Replaced );
	echo sprintf( "autoload : %s ( %s )\n", $eString_FullName, $eString_ClassName );

	include $eString_FullName;
}



function SIMPL__TEST__UnitTest_AutoLoader( $eString_ClassName, $eString_BasePath = NULL )
{
	if ( $eString_BasePath === NULL )
	{
		$eString_BasePath = dirname( __FILE__ );
	}

	$eString_FullName = sprintf( "%s/%s.php", $eString_BasePath, str_replace( "TEST__", "test-", $eString_ClassName ) );
	echo sprintf( "autoload : %s ( %s )\n", $eString_FullName, $eString_ClassName );

	include $eString_FullName;
}



?>