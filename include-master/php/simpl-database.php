<?php
// 日本語UTF-8, LF



// include



// define
define( "SIMPL__INTEGER__DATABASE__LOG_LEVEL__EXECUTE_RESULTS", 1001 );



// global



// ===================================================================
// public
// -------------------------------------------------------------------


// -------------------------------------------------------------------
// get

// subject  : get database entity
// argument : hash, database connection settings
// return   : object, database entity
function SIMPL__DATABASE__GetDB( $aaStrings_DBC )
{
	try
	{
		//PDO classの生成
		$aaOptions = array();
//		$aaOptions[PDO::MYSQL_ATTR_READ_DEFAULT_FILE] = "/etc/mysql/my.cnf";
//		$aaOptions[PDO::MYSQL_ATTR_READ_DEFAULT_GROUP] = "php";
//		$aaOptions[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET CHARACTER SET 'utf8';";
		$ePDO = new PDO( $aaStrings_DBC["DSN"], $aaStrings_DBC["User"], $aaStrings_DBC["Password"], $aaOptions );
		$ePDO->setAttribute( PDO::ATTR_EMULATE_PREPARES, FALSE );
		$ePDO->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	}
	catch ( PDOException $e )
	{
		$eString_Message = $e->getMessage() . "\n" . sprintf( "%s, %s, %s", $aaStrings_DBC["DSN"], $aaStrings_DBC["User"], $aaStrings_DBC["Password"] );
		SIMPL__LOG__AddError( $eString_Message );

		return NULL;
	}

	return $ePDO;
}

// subject  : get data
// argument : object, database entity
// argument : string, sql
// argument : array, arguments
// return   : array, values
function SIMPL__DATABASE__GetValues_All( $eDB, $eString_SQL, $arArguments_SQL = NULL )
{
	$arResults = array();

	try
	{
		$eStatement = $eDB->prepare( $eString_SQL );
		$eStatement->execute( $arArguments_SQL );
		while ( $eRow = $eStatement->fetch( PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT ) )
		{
			$arResults[] = $eRow;
		}

		{
			$eString_Message = $eString_SQL;
			if ( $arArguments_SQL != NULL )
			{
				$eString_Message .= "\n------ Arguments ------";
				$eString_Message .= "\n" . print_r( $arArguments_SQL, TRUE );
				$eString_Message .= "------ Resullts ------";
			}

			$eString_Message .= "\n" . print_r( $arResults, TRUE );
			SIMPL__LOG__AddLogMessage_DateTime( $eString_Message, SIMPL__INTEGER__LOG__LOG_TYPE__NOTICE, SIMPL__INTEGER__DATABASE__LOG_LEVEL__EXECUTE_RESULTS );
		}
	}
	catch ( PDOException $e )
	{
//		SIMPL__DATABASE__SetError( $e );

		$eString_Message = $e->getMessage();
		$eString_Message .= "\n" . $eString_SQL;
		$eString_Message .= "\n" . print_r( $arArguments_SQL, TRUE );
		SIMPL__LOG__AddError( $eString_Message );
	}

	return $arResults;
}


// subject  : get data
// argument : object, database entity
// argument : string, sql
// argument : array, arguments
// return   : hash, values
function SIMPL__DATABASE__GetValues_Line( $eDB, $eString_SQL, $arArguments_SQL = NULL )
{
	$aaResults = array();

	try
	{
		$eStatement = $eDB->prepare( $eString_SQL );
		$eStatement->execute( $arArguments_SQL );
		if ( $eRow = $eStatement->fetch( PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT ) )
		{
			$aaResults = $eRow;
		}

		{
			$eString_Message = $eString_SQL;
			if ( $arArguments_SQL != NULL )
			{
				$eString_Message .= "\n------ Arguments ------";
				$eString_Message .= "\n" . print_r( $arArguments_SQL, TRUE );
				$eString_Message .= "------ Resullts ------";
			}

			$eString_Message .= "\n" . print_r( $aaResults, TRUE );
			SIMPL__LOG__AddLogMessage_DateTime( $eString_Message, SIMPL__INTEGER__LOG__LOG_TYPE__NOTICE, SIMPL__INTEGER__DATABASE__LOG_LEVEL__EXECUTE_RESULTS );
		}
	}
	catch ( PDOException $e )
	{
//		SIMPL__DATABASE__SetError( $e );

		$eString_Message = $e->getMessage();
		$eString_Message .= "\n" . $eString_SQL;
		$eString_Message .= "\n" . print_r( $arArguments_SQL, TRUE );
		SIMPL__LOG__AddError( $eString_Message );
	}

	return $aaResults;
}


// subject  : get data
// argument : object, database entity
// argument : string, sql
// argument : array, arguments
// return   : string, value
function SIMPL__DATABASE__GetValues_One( $eDB, $eString_SQL, $arArguments_SQL = NULL )
{
	$eString_Result = NULL;

	try
	{
		$eStatement = $eDB->prepare( $eString_SQL );
		$eStatement->execute( $arArguments_SQL );
		if ( $eRow = $eStatement->fetch( PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT ) )
		{
			$arStrings = array_values( $eRow );
			if ( count( $arStrings ) > 0 )
			{
				$eString_Result = $arStrings[0];
			}
		}

		{
			$eString_Message = $eString_SQL;
			if ( $arArguments_SQL != NULL )
			{
				$eString_Message .= "\n------ Arguments ------";
				$eString_Message .= "\n" . print_r( $arArguments_SQL, TRUE );
				$eString_Message .= "------ Resullts ------";
			}

			$eString_Message .= "\n" . $eString_Result;
			SIMPL__LOG__AddLogMessage_DateTime( $eString_Message, SIMPL__INTEGER__LOG__LOG_TYPE__NOTICE, SIMPL__INTEGER__DATABASE__LOG_LEVEL__EXECUTE_RESULTS );
		}
	}
	catch ( PDOException $e )
	{
//		SIMPL__DATABASE__SetError( $e );

		$eString_Message = $e->getMessage();
		$eString_Message .= "\n" . $eString_SQL;
		$eString_Message .= "\n" . print_r( $arArguments_SQL, TRUE );
		SIMPL__LOG__AddError( $eString_Message );
	}

	return $eString_Result;
}


// subject  : set data
// argument : object, database entity
// argument : string, sql
// argument : array, arguments
// return   : bool, TRUE or FALSE
function SIMPL__DATABASE__SetValues( $eDB, $eString_SQL, $arArguments_SQL = NULL )
{
	$bResult = FALSE;

	try
	{
		$eStatement = $eDB->prepare( $eString_SQL );
		$bResult = $eStatement->execute( $arArguments_SQL );

		{
			$eString_Message = $eString_SQL;
			if ( $arArguments_SQL != NULL )
			{
				$eString_Message .= "\n------ Arguments ------";
				$eString_Message .= "\n" . print_r( $arArguments_SQL, TRUE );
				$eString_Message .= "------ Resullts ------";
			}

			$eString_Message .= "\n" . $bResult;
			SIMPL__LOG__AddLogMessage_DateTime( $eString_Message, SIMPL__INTEGER__LOG__LOG_TYPE__NOTICE, SIMPL__INTEGER__DATABASE__LOG_LEVEL__EXECUTE_RESULTS );
		}
	}
	catch ( PDOException $e )
	{
//		SIMPL__DATABASE__SetError( $e );

		$eString_Message = $e->getMessage();
		$eString_Message .= "\n" . $eString_SQL;
		$eString_Message .= "\n" . print_r( $arArguments_SQL, TRUE );
		SIMPL__LOG__AddError( $eString_Message );
	}

	return $bResult;
}



// ===================================================================
// local
// -------------------------------------------------------------------



?>