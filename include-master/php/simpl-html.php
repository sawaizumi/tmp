<?php
// 日本語UTF-8, LF



// include



// define



// global



// ===================================================================
// public
// -------------------------------------------------------------------

// -------------------------------------------------------------------
// build HTML

function SIMPL__HTML__BuildHTML_Scripts( $arResults = NULL, $aaOptions = NULL )
{
	$eString_HTML = "";

	if ( $arResults === NULL )
	{
		$arResults = array();
	}

	$eString_Indent = SIMPL__GetValue( $aaOptions, "Indent", "\t" );
	if ( SIMPL__GetValue( $aaOptions, "Add-SIMPL", TRUE ) )
	{
		if ( SIMPL__GetValue( $aaOptions, "Add-SIMPL-First", TRUE ) )
		{
			$arResults = array_merge( SIMPL__GetList_URL__SIMPLE_JS(), $arResults );
		}
		else
		{
			$arResults = array_merge( $arResults, SIMPL__GetList_URL__SIMPLE_JS() );
		}
	}

	foreach ( $arResults as $eRow )
	{
		$eString_URL = SIMPL__GetValue( $eRow, "URL" );
		if ( $eString_URL )
		{
			$eString_HTML .= sprintf( "%s<script type = \"text/javascript\" src = \"%s\" ></script>", $eString_Indent, $eString_URL );
		}

		$eString_HTML .= "\n";
	}

	return $eString_HTML;
}


function SIMPL__HTML__BuildHTML_StyleSheetLinks( $arResults = NULL, $aaOptions = NULL )
{
	$eString_HTML = "";

	if ( $arResults === NULL )
	{
		$arResults = array();
	}

	$eString_Indent = SIMPL__GetValue( $aaOptions, "Indent", "\t" );
	if ( SIMPL__GetValue( $aaOptions, "Add-SIMPL", TRUE ) )
	{
		if ( SIMPL__GetValue( $aaOptions, "Add-SIMPL-First", TRUE ) )
		{
			$arResults = array_merge( SIMPL__GetList_URL__SIMPLE_CSS(), $arResults );
		}
		else
		{
			$arResults = array_merge( $arResults, SIMPL__GetList_URL__SIMPLE_CSS() );
		}
	}

	foreach ( $arResults as $eRow )
	{
		$eString_URL = SIMPL__GetValue( $eRow, "URL" );
		if ( $eString_URL )
		{
			$eString_HTML .= sprintf( "%s<link rel = \"stylesheet\" href = \"%s\" type = \"text/css\" media = \"screen\" />", $eString_Indent, $eString_URL );
		}

		$eString_HTML .= "\n";
	}

	return $eString_HTML;
}


function SIMPL__HTML__BuildHTML_SimpleTable( $arResults = NULL, $aaOptions = NULL )
{
	if ( $arResults === NULL )
	{
		$eString_HTML = "no data";
		$eString_HTML .= "<br />\n";
	}
	else
	{
		$eString_HTML = "";

		$arKeys = SIMPL__GetKeys( $arResults, $aaOptions );

		if ( SIMPL__GetValue( $aaOptions, "AddTableHeader", TRUE ) === TRUE )
		{
			foreach ( $arKeys as $eKey )
			{
				$eString_HTML .= "\t\t";
				$eString_HTML .= "<th>";
				$eString_HTML .= $eKey;
				$eString_HTML .= "</th>\n";
			}
		}

		foreach ( $arResults as $eRow )
		{
			$eString_HTML .= "\t";
			$eString_HTML .= "<tr>\n";

			foreach ( $arKeys as $eKey )
			{
				$eString_HTML .= "\t\t";
				$eString_HTML .= "<td>";

				if ( array_key_exists( $eKey, $eRow ) )
				{
					$eString_Column = SIMPL__EscapeHTML( $eRow[$eKey] );
					if ( SIMPL__GetValue( $aaOptions, "Show-NULL", TRUE ) === TRUE )
					{
						if ( $eString_Column === NULL )
						{
							$eString_Column = SIMPL__GetValue( $aaOptions, "Show-NULL-Replace", "[NULL]" );
						}
					}

					if ( SIMPL__GetValue( $aaOptions, "AddLink" ) === TRUE )
					{
//						$eString_Pattern = "https?://.+/\S*";
						$eString_Pattern = "https?://.+/[0-9a-zA-Z.+?&/%#=;_\-]*";
						$eString_Replace = '<a href = "$0" >$0</a>';
						$eString_Column = preg_replace( SIMPL__AddDelimiter( $eString_Pattern ), $eString_Replace, $eString_Column );
					}

					if ( SIMPL__GetValue( $aaOptions, "ReplaceLineFeed", TRUE ) === TRUE )
					{
						$eString_Column = str_replace( "\r\n", "\n", $eString_Column );
						$eString_Column = str_replace( "\r", "\n", $eString_Column );
						$eString_Column = str_replace( "\n", "<br />", $eString_Column );
					}

					$eString_HTML .= $eString_Column;
				}

				$eString_HTML .= "</td>\n";
			}

			$eString_HTML .= "\t";
			$eString_HTML .= "</tr>\n";
		}

		if ( $eString_HTML == "" )
		{
			$eString_HTML = "no rows";
			$eString_HTML .= "<br />\n";
		}
		else
		{
			$eString_HTML = "<table>\n" . $eString_HTML . "</table>\n";
		}
	}

	return $eString_HTML;
}



// ===================================================================
// local
// -------------------------------------------------------------------



?>