<?php
// 日本語UTF-8, LF



// include



// define



// global



// ===================================================================
// public
// -------------------------------------------------------------------

// -------------------------------------------------------------------
// build Tags

function SIMPL__HTML__CreateTag_INPUT__Edit( $eString_Name, $eString_Value, $aaAttributes = NULL )
{
	if ( $aaAttributes === NULL )
	{
		$aaAttributes = SIMPL__HTML__BuildAttributes();
	}

	$aaOptions = SIMPL__HTML__BuildOptions( FALSE );

	$aaAttributes["name"] = $eString_Name;
	$aaAttributes["type"] = "edit";
	$aaAttributes["value"] = $eString_Value;

	return SIMPL__HTML__CreateTag( "input", NULL, $aaAttributes, $aaOptions );
}

function SIMPL__HTML__CreateTag( $eString_TagName, $eString_InnerText = NULL, $aaAttributes = NULL, $aaOptions = NULL, $arChildren = NULL )
{
	$eTag = array();

	$eTags["TagName"] = $eString_TagName;
	if ( $eString_InnerText != NULL )
	{
		$arChildren = array( $eString_InnerText );
	}
	if ( $aaAttributes != NULL )
	{
		$eTags["Attributes"] = $aaAttributes;
	}
	if ( $aaOptions != NULL )
	{
		$eTags["Options"] = $aaOptions;
	}
	if ( $arChildren != NULL )
	{
		$eTags["Children"] = $arChildren;
	}

	return $eTag;
}


function SIMPL__HTML__BuildAttributes( $eString_ID = NULL, $eString_ClassName = NULL, $eString_Name = NULL, $eString_Value = NULL, $bFlag_Enable = TRUE )
{
	$aaAttributes = array();

	if ( $eString_ID != NULL )
	{
		$aaAttributes["id"] = $eString_ID;
	}

	if ( $eString_ClassName != NULL )
	{
		$aaAttributes["class"] = $eString_ClassName;
	}

	if ( $eString_Name != NULL )
	{
		$aaAttributes["name"] = $eString_Name;
	}

	if ( $eString_ClassName != NULL )
	{
		$aaAttributes["value"] = $eString_Value;
	}

	if ( $bFlag_Enable === FALSE )
	{
		$aaAttributes["disable"] = "disable";
	}

	return $aaAttributes;
}


// MultiLine
// NoEndTag
// NoIndent
function SIMPL__HTML__BuildOptions( $bFlag_MultiLine = TRUE, $bFlag_NoEndTag = FALSE )
{
	$aaOptions = array();

	if ( $bFlag_MultiLine != FALSE )
	{
		$aaOptions["MultiLine"] = TRUE;
	}

	if ( $bFlag_NoEndTag != FALSE )
	{
		$aaOptions["NoEndTag"] = TRUE;
	}

	return $aaOptions;
}


// -------------------------------------------------------------------
// build HTML

function SIMPL__HTML__BuildHTML_Tags( $eTags, $eString_Indent = "" )
{
	$aaFlags = array();
	$eString_HTML = "";

	if ( is_assoc( $eTags ) )
	{
		$eString_TagName = $eTags["TagName"];

		$aaAttributes = SIMPL__GetValue( $eTags, "Attributes", array() );
		$aaOptions = SIMPL__GetValue( $eTags, "Options", array() );
		$arChildren = SIMPL__GetValue( $eTags, "Children", array() );

		if ( SIMPL__GetValue( $eTags, "Disable" ) === TRUE )
		{
			$aaAttributes["disable"] = "disable";
		}


		if ( SIMPL__GetValue( $aaOptions, "NoEndTag" ) === TRUE )
		{
			$eString_Attributes = local_SIMPL__HTML__BuildString_Attributes( $aaAttributes, $aaOptions );

			if ( SIMPL__GetValue( $aaOptions, "MultiLine" ) === TRUE )
			{
				$eString_HTML .= sprintf( "%s<%s%s />\n", $eString_Indent, $eString_TagName, $eString_Attributes );
			}
			else
			{
				$eString_HTML .= sprintf( "<%s%s />", $eString_TagName, $eString_Attributes );
			}
		}
		else
		{
			foreach ( $arChildren as $eChild )
			{
				if ( SIMPL__GetValue( $aaOptions, "NoIndent" ) === TRUE )
				{
					list( $eString_InnerText, $aaResults ) = SIMPL__HTML__BuildHTML_Tags( $eChild );
					if ( $eString_InnerText != "" )
					{
						if ( substr( $eString_InnerText, -1 ) != "\n" )
						{
							$eString_InnerText .= "\n";
						}
					}

					$eString_InnerHTML .= $eString_InnerText;
				}
				else
				{
					list( $eString_InnerText, $aaResults ) = SIMPL__HTML__BuildHTML_Tags( $eChild, ( $eString_Indent . "\t" ) );
					if ( SIMPL__GetValue( $aaResults, "TextOnly" ) === TRUE )
					{
						list( $eString_InnerText, $aaResults ) = local_SIMPL__HTML__RebuildInnerHTML( $eString_InnerText, ( $eString_Indent . "\t" ) );
					}

					if ( SIMPL__GetValue( $aaResults, "MultiLine" ) === TRUE )
					{
						$aaOptions["MultiLine"] = TRUE;
						$aaFlags["MultiLine"] = TRUE;
					}

					if ( $eString_InnerText != "" )
					{
						if ( SIMPL__GetValue( $aaOptions, "MultiLine" ) === TRUE )
						{
							if ( SIMPL__GetValue( $aaResults, "MultiLine" ) === TRUE )
							{
								$eString_InnerHTML .= $eString_Indent . "\t" . $eString_InnerText . "\n";
							}
							else
							{
								$eString_InnerHTML .= $eString_InnerText;
							}
						}
						else
						{
							$eString_InnerHTML .= $eString_InnerText;
						}
					}
				}
			}

			if ( SIMPL__GetValue( $aaOptions, "MultiLine" ) === TRUE )
			{
				if ( $eString_InnerHTML != "" )
				{
					if ( substr( $eString_InnerHTML, -1 ) != "\n" )
					{
						$eString_InnerHTML .= "\n";
					}
				}
			}

			$eString_Attributes = local_SIMPL__HTML__BuildString_Attributes( $aaAttributes, $aaOptions );

			if ( SIMPL__GetValue( $aaOptions, "MultiLine" ) === TRUE )
			{
				$aaFlags["MultiLine"] = TRUE;

				if ( $eString_InnerHTML != "" )
				{
					$eString_HTML .= sprintf( "%s<%s%s>\n", $eString_Indent, $eString_TagName, $eString_Attributes );
					$eString_HTML .= $eString_InnerHTML;
					$eString_HTML .= sprintf( "%s</%s/>\n", $eString_Indent, $eString_TagNames );
				}
				else
				{
					$eString_HTML .= sprintf( "%s<%s%s></%s>\n", $eString_Indent, $eString_TagName, $eString_Attributes, $eString_TagNames );
				}
			}
			else
			{
				if ( SIMPL__GetValue( $aaFlags, "MultiLine" ) === TRUE )
				{
					$eString_HTML .= sprintf( "%s<%s%s>\n", $eString_Indent, $eString_TagName, $eString_Attributes );
					$eString_HTML .= $eString_InnerHTML;
					$eString_HTML .= sprintf( "%s</%s/>\n", $eString_Indent, $eString_TagNames );
				}
				else
				{
					$eString_HTML .= sprintf( "<%s%s>%s<%s>", $eString_TagName, $eString_Attributes, $eString_InnerHTML, $eString_TagName );
				}
			}
		}
	}
	else
	{
		$eString_HTML .= eTags;

		$aaFlags["TextOnly"] = TRUE;
	}

	return array( $eString_HTML, $aaFlags );
}



// ===================================================================
// local
// -------------------------------------------------------------------

function local_SIMPL__HTML__BuildString_Attributes( $aaAttributes, $aaOptions )
{
	$eString_Attributes = "";

	if ( $eString_Attributes != "" )
	{
		if ( SIMPL__GetValue( $aaOptions, "NoEndTag" ) === TRUE )
		{
			$eString_Attributes = sprintf( " %s", $eString_Attributes );
		}
		else
		{
			$eString_Attributes = sprintf( " %s ", $eString_Attributes );
		}
	}

	return $eString_Attributes;
}


function local_SIMPL__HTML__RebuildInnerHTML( $eString_InnerHTML, $eString_Indent )
{
	$aaFlags = array();
	$eString_HTML = "";

	if ( $eString_InnerHTML != "" )
	{
		$arStrings = explode( "\n", $eString_InnerHTML );
		if ( count( $arStrings ) > 1 )
		{
			$aaFlags["MultiLine"] = TRUE;

			$eString_InnerHTML = "";
			foreach ( $arStrings as $eString )
			{
				if ( $eString != "" )
				{
					$eString_InnerHTML .= $eString_Indent . $eString . "\n";
				}
				else
				{
					$eString_InnerHTML .= "\n";
				}
			}
		}
		else
		{
			$eString_InnerHTML = $eString_Indent . $eString_InnerHTML;
		}
	}

	return array( $eString_HTML, $aaFlags );
}



?>