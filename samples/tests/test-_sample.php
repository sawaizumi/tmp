<?php
// 日本語UTF-8, LF



// pre include



// include



// define



// global



// ===================================================================
// test case
// -------------------------------------------------------------------

// SIMPL__TEST__UnitTestCaseを継承してテストケースを作成
// テストケースはTest__*というメソッド名にする事によって認識される
class Test___Sample extends SIMPL__TEST__UnitTestCase
{
	function Test__1()
	{
		// 特定条件でのSampleFunctionの実行結果を取得
		$eString_Result = SampleFunction();

		// 結果を文字列として比較して一致をテスト
		// Success
		$this->CheckEqual_String( $eString_Result, "Test", "message" );
	}
	function Test__2()
	{
		// 特定条件でのSampleFunctionの実行結果を取得
		$eString_Test = "";
		$eString_Result = SampleFunction( $eString_Test );

		// 結果を文字列として比較して一致をテスト
		// Error
		$this->CheckEqual_String( $eString_Result, "Test" );
	}
}



?>