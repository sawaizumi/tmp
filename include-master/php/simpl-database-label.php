<?php
// 日本語UTF-8, LF



// include



// define



// global



// ===================================================================
// public
// -------------------------------------------------------------------


// -------------------------------------------------------------------
// get

function SIMPL__DATABASE__GetID_Label( $eDB, $eString_Name )
{
	$eString_SQL = "SELECT `c__simpl_id` FROM `t__simpl_label` WHERE `c__simpl_name` = ?;";
	$arArugments_SQL = array( $eString_Name );
	$eString_Result = SIMPL__ExecuteQuery_SelectOne( $eDB, $eString_SQL, $arArugments_SQL );
	if ( $eString_Result === NULL )
	{
		return NULL;
	}

	return intval( $eString_Result );
}


function SIMPL__DATABASE__GetList_Label( $eDB, $iOrder_Type = NULL )
{
	$arResults = array();

	switch ( $iOrder_Type )
	{
		case 0:
			$eString_SQL = "SELECT * FROM `t__simpl_label` ORDER BY `c__simpl_order`, `c__simpl_id`;";
			break;

		default:
			$eString_SQL = "SELECT * FROM `t__simpl_label` ORDER BY `c__simpl_id`;";
			break;
	}

	$arResults = SIMPL__ExecuteQuery( $eDB, $eString_SQL );

	return $arResults;
}


function SIMPL__DATABASE__GetList_Tags( $eDB, $iID_TagetTable, $arResults, $iOrder_Type = NULL )
{
	$aaResults = array();

	$arTags = array();
	$arIDs = array();

	foreach ( $arResults as $eRow )
	{
		$iID_Target = $eRow["c__simpl_id"];

		$aaResults = SIMPL__DATABASE__GetTags( $eDB, $iID_TagetTable, $iID_Target, $iOrder_Type );

		$arIDs[] = $iID_Target;
		$arTags[] = $aaResults["Select-Tags"];
	}

	$aaResults["Select-IDs"] = $arIDs;
	$aaResults["Select-Tags"] = $arTags;

	return $aaResults;
}


function SIMPL__DATABASE__GetTags( $eDB, $iID_TagetTable, $iID_Target, $iOrder_Type = NULL )
{
	$aaResults = array();

	switch ( $iOrder_Type )
	{
		case 0:
			$eString_SQL = "SELECT * FROM `t__simpl_tag` WHERE ( `c__simpl_id-t__simpl_target_table` = ? ) AND ( `c__simpl_id__target` = ? ) ORDER BY `c__simpl_id-t__simpl_label`;";
			break;

		default:
			$eString_SQL = "SELECT * FROM `t__simpl_tag` WHERE ( `c__simpl_id-t__simpl_target_table` = ? ) AND ( `c__simpl_id__target` = ? ) ORDER BY `c__simpl_order`;";
			break;
	}

	$arArugments_SQL = array( $iID_TagetTable, $iID_Target );
	$arResults = SIMPL__ExecuteQuery( $eDB, $eString_SQL, $arArugments_SQL );
	$aaResults["Select-Tags"] = $arResults;

	return $aaResults;
}


// -------------------------------------------------------------------
// add

// subject  : add label
// argument : object, database entity
// argument : integer, order
// argument : string, name
// argument : string, name ( shortening )
// argument : string, description
// return   : hash, results
function SIMPL__DATABASE__AddLabel( $eDB, $iOrder, $eString_Name, $eString_Name__Shortening, $eString_Description )
{
	$aaResults = array();

	$eString_SQL = "SELECT MAX( `c__simpl_id` ) AS `ac__max` FROM `t__simpl_label`;";
	$eString_Result = SIMPL__ExecuteQuery_SelectOne( $eDB, $eString_SQL );
	$aaResults["Select-Max-ID"] = $eString_Result;
	$iID_Next = intval( $eString_Result ) + 1;

	$eString_SQL = "INSERT INTO `t__simpl_label` SET `c__simpl_id` = ?, `c__simpl_order` = ?, `c__simpl_name` = ?, `c__simpl_name__shortening` = ?, `c__simpl_description` = ?;";
	$arArugments_SQL = array( $iID_Next, $iOrder, $eString_Name, $eString_Name__Shortening, $eString_Description );
	$bFlag_Result = SIMPL__ExecuteQuery_Only( $eDB, $eString_SQL, $arArugments_SQL );
	$aaResults["Insert-Label"] = $bFlag_Result;

	$eString_SQL = "SELECT * FROM `t__simpl_label` WHERE `c__simpl_id` = ?;";
	$arArugments_SQL = array( $iID_Next );
	$arResults = SIMPL__ExecuteQuery( $eDB, $eString_SQL, $arArugments_SQL );
	$aaResults["Select-Label"] = $arResults;

	return $aaResults;
}


// subject  : add tag
// argument : object, database entity
// argument : integer, label
// argument : integer, target table
// argument : integer, target
// return   : hash, results
function SIMPL__DATABASE__AddTag( $eDB, $iID_Label, $iID_TagetTable, $iID_Target )
{
	$aaResults = array();

	$eString_SQL = "SELECT MAX( `c__simpl_order` ) AS `ac__max` FROM `t__simpl_tag` WHERE ( `c__simpl_id-t__simpl_target_table` = ? ) AND ( `c__simpl_id__target` = ? );";
	$arArugments_SQL = array( $iID_TagetTable, $iID_Target );
	$eString_Result = SIMPL__ExecuteQuery_SelectOne( $eDB, $eString_SQL, $arArugments_SQL );
	$aaResults["Select-Max-Order"] = $eString_Result;
	if ( $eString_Result !== NULL )
	{
		$iOrder = intval( $eString_Result ) + 1;
	}
	else
	{
		$iOrder = 1;
	}

	$eString_SQL = "INSERT INTO `t__simpl_tag` SET `c__simpl_id-t__simpl_label` = ?, `c__simpl_id-t__simpl_target_table` = ?, `c__simpl_id__target` = ?, `c__simpl_order` = ?;";
	$arArugments_SQL = array( $iID_Label, $iID_TagetTable, $iID_Target, $iOrder );
	$bFlag_Result = SIMPL__ExecuteQuery_Only( $eDB, $eString_SQL, $arArugments_SQL );
	$aaResults["Insert-Tag"] = $bFlag_Result;

	return $aaResults;
}


// -------------------------------------------------------------------
// remove

// subject  : remove tag
// argument : object, database entity
// argument : integer, label
// argument : integer, target table
// argument : integer, target
// return   : hash, results
function SIMPL__DATABASE__RemoveTag( $eDB, $iID_Label, $iID_TagetTable = NULL, $iID_Target = NULL )
{
	$aaResults = array();

	if ( $iID_Label !== NULL )
	{
		if ( $iID_Taget !== NULL )
		{
			$eString_SQL = "SELECT * FROM `t__simpl_tag` WHERE ( `c__simpl_id-t__simpl_label` = ? ) AND ( `c__simpl_id-t__simpl_target_table` = ? ) AND ( `c__simpl_id__target` = ? );";
			$arArugments_SQL = array( $iID_Label, $iID_TagetTable, $iID_Target );
			$arResults = SIMPL__ExecuteQuery( $eDB, $eString_SQL, $arArugments_SQL );
			$aaResults["Select-Tag"] = $eString_Result;

			$eString_SQL = "DELETE FROM `t__simpl_tag` WHERE ( `c__simpl_id-t__simpl_label` = ? ) AND ( `c__simpl_id-t__simpl_target_table` = ? ) AND ( `c__simpl_id__target` = ? );";
			$arArugments_SQL = array( $iID_Label, $iID_TagetTable, $iID_Target );
			$bFlag_Result = SIMPL__ExecuteQuery_Only( $eDB, $eString_SQL, $arArugments_SQL );
			$aaResults["Delete-Tag"] = $bFlag_Result;
		}
		else
		{
			if ( $iID_TagetTable !== NULL )
			{
				$eString_SQL = "SELECT * FROM `t__simpl_tag` WHERE ( `c__simpl_id-t__simpl_label` = ? ) AND ( `c__simpl_id-t__simpl_target_table` = ? );";
				$arArugments_SQL = array( $iID_Label, $iID_TagetTable );
				$arResults = SIMPL__ExecuteQuery( $eDB, $eString_SQL, $arArugments_SQL );
				$aaResults["Select-Tag"] = $eString_Result;

				$eString_SQL = "DELETE FROM `t__simpl_tag` WHERE ( `c__simpl_id-t__simpl_label` = ? ) AND ( `c__simpl_id-t__simpl_target_table` = ? );";
				$arArugments_SQL = array( $iID_Label, $iID_TagetTable );
				$bFlag_Result = SIMPL__ExecuteQuery_Only( $eDB, $eString_SQL, $arArugments_SQL );
				$aaResults["Delete-Tag"] = $bFlag_Result;
			}
			else
			{
				$eString_SQL = "SELECT * FROM `t__simpl_tag` WHERE `c__simpl_id-t__simpl_label` = ?;";
				$arArugments_SQL = array( $iID_Label );
				$arResults = SIMPL__ExecuteQuery( $eDB, $eString_SQL, $arArugments_SQL );
				$aaResults["Select-Tag"] = $eString_Result;

				$eString_SQL = "DELETE FROM `t__simpl_tag` WHERE `c__simpl_id-t__simpl_label` = ?;";
				$arArugments_SQL = array( $iID_Label );
				$bFlag_Result = SIMPL__ExecuteQuery_Only( $eDB, $eString_SQL, $arArugments_SQL );
				$aaResults["Delete-Tag"] = $bFlag_Result;
			}
		}
	}
	else
	{
		$eString_SQL = "SELECT * FROM `t__simpl_tag` WHERE ( `c__simpl_id-t__simpl_target_table` = ? ) AND ( `c__simpl_id__target` = ? );";
		$arArugments_SQL = array( $iID_Label, $iID_TagetTable, $iID_Target );
		$arResults = SIMPL__ExecuteQuery( $eDB, $eString_SQL, $arArugments_SQL );
		$aaResults["Select-Tag"] = $eString_Result;

		$eString_SQL = "DELETE FROM `t__simpl_tag` WHERE ( `c__simpl_id-t__simpl_target_table` = ? ) AND ( `c__simpl_id__target` = ? );";
		$arArugments_SQL = array( $iID_Label, $iID_TagetTable, $iID_Target );
		$bFlag_Result = SIMPL__ExecuteQuery_Only( $eDB, $eString_SQL, $arArugments_SQL );
		$aaResults["Delete-Tag"] = $bFlag_Result;
	}

	return $aaResults;
}


// subject  : remove label
// argument : object, database entity
// argument : integer, id
// return   : hash, results
function SIMPL__DATABASE__RemoveLabel( $eDB, $iID_Label )
{
	$aaResults = array();

	$eString_SQL = "SELECT * FROM `t__simpl_label` WHERE `c__simpl_id` = ?;";
	$arArugments_SQL = array( $iID_Label );
	$arResults = SIMPL__ExecuteQuery( $eDB, $eString_SQL, $arArugments_SQL );
	$aaResults["Select-Label"] = $arResults;

	$eString_SQL = "DELETE FROM `t__simpl_label` WHERE `c__simpl_id` = ?;";
	$arArugments_SQL = array( $iID_Label );
	$bFlag_Result = SIMPL__ExecuteQuery_Only( $eDB, $eString_SQL, $arArugments_SQL );
	$aaResults["Delete-Label"] = $bFlag_Result;

	$aaResults["Remove-Tag"] = SIMPL__DATABASE__RemoveTag( $eDB, $iID_Label );

	return $aaResults;
}



// ===================================================================
// debug
// -------------------------------------------------------------------



// ===================================================================
// local
// -------------------------------------------------------------------



?>