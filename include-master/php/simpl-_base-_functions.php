<?php
// 日本語UTF-8, LF



// ===================================================================
// define operation
// -------------------------------------------------------------------

// subject  : build defines
// argument : array, defines
// argument : string, label
// argument : string, category
// argument : integer, offset
// argument : string, prefix
// return   : hash, defines
function SIMPL__BuildDefines_EnumString( $arDefines, $eString_Label = "", $eString_Category = "", $iOffset = 0, $eString_Prefix = SIMPL__STRING__DEFINE_PREFIX )
{
	$aaResults = array();
	$arDefines_Enum = array();
	$aaDefines_Pair = array();

	$iCount = 0;
	foreach ( $arDefines as $arTuple )
	{
		$eKey = $arTuple[0];
		$eString_Name = $arTuple[1];
		$eValue = NULL;
		if ( count( $arTuple ) > 2 )
		{
			$eValue = $arTuple[2];
		}
		if ( $eValue === NULL )
		{
			$eValue = $iCount;
		}
		else
		{
			$iCount = intval( $eValue );
		}

		$aaResults[$eString_Name] = $eValue + $iOffset;
		$arDefines_Enum[] = array( $eKey, $eValue );
		$aaDefines_Pair[$eKey] = $eString_Name;

		$iCount++;
	}

	SIMPL__BuildDefines_Enum( $arDefines_Enum, $eString_Label, $eString_Category, $iOffset, $eString_Prefix );
	SIMPL__BuildDefines( $aaDefines_Pair, $eString_Label, $eString_Category, $eString_Prefix );

	return $aaResults;
}


// subject  : build defines
// argument : array, defines
// argument : string, label
// argument : string, category
// argument : integer, offset
// argument : string, prefix
function SIMPL__BuildDefines_Enum( $arDefines, $eString_Label = "", $eString_Category = "", $iOffset = 0, $eString_Prefix = SIMPL__STRING__DEFINE_PREFIX )
{
	$aaDefines_Enum = array();

	$iCount = 0;
	foreach ( $arDefines as $arTuple )
	{
		$eKey = $arTuple[0];
		$eValue = NULL;
		if ( count( $arTuple ) > 1 )
		{
			$eValue = $arTuple[1];
		}
		if ( $eValue === NULL )
		{
			$eValue = $iCount;
		}
		else
		{
			$iCount = intval( $eValue );
		}

		$aaDefines_Enum[$eKey] = $eValue + $iOffset;

		$iCount++;
	}

	SIMPL__BuildDefines( $aaDefines_Enum, $eString_Label, $eString_Category, $eString_Prefix );
}


// subject  : build defines
// argument : array, defines
// argument : string, label
// argument : string, category
// argument : string, prefix
function SIMPL__BuildDefines( $aaDefines, $eString_Label = "", $eString_Category = "", $eString_Prefix = SIMPL__STRING__DEFINE_PREFIX )
{
	if ( $eString_Prefix != "" )
	{
		$eString_Prefix .= "__";
	}

	if ( $eString_Category != "" )
	{
		$eString_Category .= "__";
	}

	if ( $eString_Label != "" )
	{
		$eString_Label .= "__";
	}

	foreach ( $aaDefines as $eKey => $eValue )
	{
		$eString_DefineType = "";

		if ( is_string( $eValue ) == TRUE )
		{
			$eString_DefineType = "STRING__";
		}
		elseif ( is_integer( $eValue ) == TRUE )
		{
			$eString_DefineType = "INTEGER__";
		}
		elseif ( is_float( $eValue ) == TRUE )
		{
			$eString_DefineType = "REAL__";
		}
		elseif ( is_bool( $eValue ) == TRUE )
		{
			$eString_DefineType = "BOOL__";
		}

		define( ( $eString_Prefix . $eString_DefineType . $eString_Category . $eString_Label . $eKey ), $eValue );
	}
}



// ===================================================================
// file operation
// -------------------------------------------------------------------

// subject  : combine path
// argument : string, path
// argument : string, path
// return   : string, combined path
function SIMPL__CombinePath( $eString_Path_A, $eString_Path_B, $eString_Separator = NULL )
{
	$eString_Combined = "";

	if ( !isset( $eString_Path_A ) )
	{
		$eString_Path_A = "";
	}
	if ( !isset( $eString_Path_B ) )
	{
		$eString_Path_B = "";
	}
	if ( $eString_Separator === NULL )
	{
		$eString_Separator = SIMPL__STRING__PATH_SEPARATOR__DEFALUT;
	}

	if ( $eString_Path_A == "" )
	{
		$eString_Combined = $eString_Path_B;
	}
	else
	{
		if ( rtrim( $eString_Path_A, SIMPL__STRING__PATH_SEPARATOR__LIST ) == "" )
		{
			$eString_Combined = $eString_Path_A;
		}
		else
		{
			$eString_Combined = rtrim( $eString_Path_A, SIMPL__STRING__PATH_SEPARATOR__LIST );
		}

		if ( $eString_Path_B != "" )
		{
			$eString_Combined .= $eString_Separator;
			$eString_Combined .= $eString_Path_B;
		}
	}

	return $eString_Combined;
}



// ===================================================================
// hash operation
// -------------------------------------------------------------------

if ( function_exists( "is_assoc" ) === FALSE )
{
// subject  : check associative array
// argument : various, object
// return   : bool, hash or not
function is_assoc( $eObject )
{
	if ( is_array( $eObject ) )
	{
		if ( count( array_diff_key( $eObject, range( 0, count( $eObject ) - 1 ) ) ) )
		{
			return TRUE;
		}
	}

	return FALSE;
}
}


// subject  : get keys
// argument : array, hash rows in array
// argument : hash, options
// return   : array, keys
function SIMPL__GetKeys( $arRows, $aaOptions = NULL )
{
	$aaKeys = array();

	if ( $arRows === NULL )
	{
		$arRows = array();
	}

	foreach ( $arRows as $eRow )
	{
		foreach ( $eRow as $eKey => $eValue )
		{
			$aaKeys[$eKey] = 1;
		}

		if ( SIMPL__GetValue( $aaOptions, "CheckAllRows" ) !== TRUE )
		{
			break;
		}
	}

	return array_keys( $aaKeys );
}


// subject  : get value
// argument : hash, hash
// argument : string, key
// argument : various, default value
// return   : various, value
function SIMPL__GetValue( $aaValues, $eKey, $eValue_Default = FALSE )
{
	if ( $aaValues === NULL )
	{
		$aaValues = array();
	}

	if ( array_key_exists( $eKey, $aaValues ) )
	{
		if ( is_object( $aaValues ) == FALSE )
		{
			$eValue = $aaValues[$eKey];
		}
		else
		{
			$eValue = $aaValues->$eKey;
		}
	}
	else
	{
		$eValue = $eValue_Default;
	}

	return $eValue;
}


// subject  : get value ( integer )
// argument : hash, hash
// argument : string, key
// argument : integer, default value
// return   : integer, value
function SIMPL__GetValue_Integer( $aaValues, $eKey, $iValue_Default = NULL )
{
	return SIMPL__GetInteger_MinMax( $aaValues, $eKey, NULL, NULL, $iValue_Default );
}


// subject  : get value ( integer )
// argument : hash, hash
// argument : string, key
// argument : integer, min value
// argument : integer, max value
// argument : integer, default value
// return   : integer, value
function SIMPL__GetInteger_MinMax( $aaValues, $eKey, $iValue_Min = 0, $iValue_Max = NULL, $iValue_Default = NULL )
{
	if ( $iValue_Default === NULL )
	{
		if ( $iValue_Min === NULL )
		{
			if ( $iValue_Max === NULL )
			{
				$iValue_Default = 0;
			}
			else
			{
				$iValue_Default = $iValue_Max;
			}
		}
		else
		{
			$iValue_Default = $iValue_Min;
		}
	}

	$eValue = SIMPL__GetValue( $aaValues, $eKey, $iValue_Default );
	if ( !is_numeric( $eValue ) )
	{
		$iValue = $iValue_Default;
	}
	else
	{
		$iValue = intval( $eValue );
	}

	if ( $iValue_Min !== NULL )
	{
		if ( $iValue < $iValue_Min )
		{
			$iValue = $iValue_Min;
		}
	}

	if ( $iValue_Max !== NULL )
	{
		if ( $iValue > $iValue_Max )
		{
			$iValue = $iValue_Max;
		}
	}

	return $iValue;
}



// ===================================================================
// random data
// -------------------------------------------------------------------

// subject  : get random data
// return   : string, random data
function SIMPL__GetRandomData_Secure()
{
	return "test";
}



// ===================================================================
// string operation
// -------------------------------------------------------------------

// subject  : replace labels
// argument : string, template
// argument : hash, replace strings
// return   : string, result
function SIMPL__ReplaceLabels( $eString_Template, $aaStrings_Replace )
{
	if ( $aaStrings_Replace !== NULL )
	{
		foreach ( $aaStrings_Replace as $eKey => $eValue )
		{
			$eString_Template = str_replace( $eKey, $eValue, $eString_Template );
		}
	}

	return $eString_Template;
}


// subject  : check and replace NULL
// argument : string, value
// argument : string, default value
// return   : string, result
function SIMPL__CheckReplace_NULL( $eString_Value, $eString_Default = SIMPL__STRING__KEYWORD___DEFAULT )
{
	if ( $eString_Value === NULL )
	{
		$eString_Value = $eString_Default;
	}

	return $eString_Value;
}



// ===================================================================
// local
// -------------------------------------------------------------------



?>