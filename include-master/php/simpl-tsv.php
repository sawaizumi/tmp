<?php
// 日本語UTF-8, LF



// include



// define



// global



// ===================================================================
// public
// -------------------------------------------------------------------



// -------------------------------------------------------------------
// ltsv

// subject  : build ltsv
// argument : array, query results
// argument : hash, options
// return   : string, result
function SIMPL__TSV__BuildLTSV( $arResults = NULL, $aaOptions = NULL )
{
	if ( $arResults === NULL )
	{
		$eString_LTSV = "[no data]";
		$eString_LTSV .= "\n";
	}
	else
	{
		$eString_LTSV = "";

		$arKeys = SIMPL__GetKeys( $arResults, $aaOptions );
		foreach ( $arResults as $eRow )
		{
			$eString_Row = "";

			$iCount_Column = 0;
			foreach ( $arKeys as $eKey )
			{
				if ( $iCount_Column > 0 )
				{
					$eString_Row .= "\t";
				}

				if ( array_key_exists( $eKey, $eRow ) )
				{
					$eString_Column = $eRow[$eKey];

					if ( SIMPL__GetValue( $aaOptions, "ReplaceTab", TRUE ) === TRUE )
					{
						$eString_Column = str_replace( "\t", "\\t", $eString_Column );
					}

					if ( SIMPL__GetValue( $aaOptions, "ReplaceLineFeed", TRUE ) === TRUE )
					{
						$eString_Column = str_replace( "\r", "\\r", $eString_Column );
						$eString_Column = str_replace( "\n", "\\n", $eString_Column );
					}

					$eString_Row .= $eKey . ":" . $eString_Column;
				}

				$iCount_Column++;
			}

			$eString_LTSV .= $eString_Row . "\n";
		}
	}

	return $eString_LTSV;
}


// -------------------------------------------------------------------
// tsv

function SIMPL__TSV__BuildTSV( $arResults = NULL, $aaOptions = NULL )
{
	if ( $arResults === NULL )
	{
		$eString_TSV = "[no data]";
		$eString_TSV .= "\n";
	}
	else
	{
		$eString_TSV = "";

		$arKeys = SIMPL__GetKeys( $arResults, $aaOptions );

		if ( SIMPL__GetValue( $aaOptions, "AddColumnNames", TRUE ) === TRUE )
		{
			$eString_ColumnNames = "";

			foreach ( $arKeys as $eKey )
			{
				$eString_ColumnNames = local_SIMPL__WRAP__AddString( $eKey, $eString_ColumnNames );
			}

			$eString_TSV .= $eString_ColumnNames . "\n";
		}

		foreach ( $arResults as $eRow )
		{
			$eString_Row = "";

			$iCount_Column = 0;
			foreach ( $arKeys as $eKey )
			{
				if ( $iCount_Column > 0 )
				{
					$eString_Row .= "\t";
				}

				if ( array_key_exists( $eKey, $eRow ) )
				{
					$eString_Column = $eRow[$eKey];

					if ( SIMPL__GetValue( $aaOptions, "ReplaceTab", TRUE ) === TRUE )
					{
						$eString_Column = str_replace( "\t", "\\t", $eString_Column );
					}

					if ( SIMPL__GetValue( $aaOptions, "ReplaceLineFeed", TRUE ) === TRUE )
					{
						$eString_Column = str_replace( "\r", "\\r", $eString_Column );
						$eString_Column = str_replace( "\n", "\\n", $eString_Column );
					}

					$eString_Row .= $eString_Column;
				}

				$iCount_Column++;
			}

			$eString_TSV .= $eString_Row . "\n";
		}
	}

	return $eString_TSV;
}



// ===================================================================
// local
// -------------------------------------------------------------------



?>