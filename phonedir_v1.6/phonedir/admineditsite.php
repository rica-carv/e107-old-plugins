<?php // **************************************************************************// * Get requires// **************************************************************************require_once("../../class2.php");require_once(e_ADMIN . "auth.php");require_once(e_HANDLER . "userclass_class.php");if (e_LANGUAGE !="English" && file_exists(e_PLUGIN . "phonedir/languages/admin/" . e_LANGUAGE . ".php")){    include_once(e_PLUGIN . "phonedir/languages/admin/" . e_LANGUAGE . ".php");} else{    include_once(e_PLUGIN . "phonedir/languages/admin/English.php");} if (e_LANGUAGE !="English" && file_exists(e_PLUGIN . "phonedir/languages/" . e_LANGUAGE . ".php")){    include_once(e_PLUGIN . "phonedir/languages/" . e_LANGUAGE . ".php");} else{    include_once(e_PLUGIN . "phonedir/languages/English.php");} // **************************************************************************// Create objects// **************************************************************************$pdir_db=new DB;$pdir_action=$_POST['pdir_action'];$pdir_convert=new convert;// **************************************************************************// * If we are updating then update or insert the record// **************************************************************************if ($pdir_action=='update'){    if (empty($_POST['pd_site_name']))    {        $pdir_text .="<table style='width:97%' class='fborder'><tr><td  class='fcaption' style='text-align: left;' colspan='2'><strong>" . phonedir_ADLAN_99 . "</strong></td></tr></table>";    }     else    {        $pd_site_id=$_POST['pd_site_id'];        if ($pd_site_id==0)        {             // New record so add it            $pdir_args="			'0',			'" . $_POST['pd_site_name'] . "',			'" . $_POST['pd_site_address1'] . "',			'" . $_POST['pd_site_address2'] . "',			'" . $_POST['pd_site_town'] . "',			'" . $_POST['pd_site_postcode'] . "',			'" . $_POST['pd_site_phone'] . "',			'" . $_POST['pd_site_fax'] . "',			'" . $_POST['pd_site_comment'] . "',			'" . $_POST['pd_site_faxcentrex'] . "',			'" . $_POST['pd_site_phonecentrex'] . "',			'" . $_POST['pd_site_county'] . "',			'" . $_POST['pd_site_mapurl'] . "',			'" . time() . "',			'" . USERID . "." . USERNAME . "'";             // New location created            if ($pdir_db->db_Insert("pd_sites", $pdir_args))            {                $pdir_msg .="<tr><td  class='forumheader3' style='text-align: left;' colspan='2'><b>" . phonedir_ADLAN_46 . "</b></td></tr>";            }             else // New location could not be created                {                    $pdir_msg .="<tr><td  class='forumheader3' style='text-align: left;' colspan='2'><b>" . phonedir_ADLAN_84 . "</b></td></tr>";            }         }         else        {             // Update existing            $pdir_args .="		    pd_site_name='" . $_POST['pd_site_name'] . "',			pd_site_address1='" . $_POST['pd_site_address1'] . "',			pd_site_address2='" . $_POST['pd_site_address2'] . "',			pd_site_town='" . $_POST['pd_site_town'] . "',			pd_site_postcode='" . $_POST['pd_site_postcode'] . "',			pd_site_phone='" . $_POST['pd_site_phone'] . "',			pd_site_fax='" . $_POST['pd_site_fax'] . "',			pd_site_comment='" . $_POST['pd_site_comment'] . "',			pd_site_faxcentrex='" . $_POST['pd_site_faxcentrex'] . "',			pd_site_phonecentrex='" . $_POST['pd_site_phonecentrex'] . "',			pd_site_county='" . $_POST['pd_site_county'] . "',			pd_site_mapurl='" . $_POST['pd_site_mapurl'] . "',			pd_site_updated='" . time() . "',			pd_site_updatedby='" . USERID . "." . USERNAME . "'		    where pd_site_id='$pd_site_id'";            if ($pdir_db->db_Update("pd_sites", $pdir_args))            {                 // Changes saved                $pdir_msg .="<tr><td  class='forumheader3' style='text-align: left;' colspan='2'><b>" . phonedir_ADLAN_45 . "</b></td></tr>";            }             else            {                 // changes not saved                $pdir_msg .="<tr><td  class='forumheader3' style='text-align: left;' colspan='2'><b>" . phonedir_ADLAN_85 . "</b></td></tr>";            }         }     } } // We are creating, editing or deleting a recordif ($pdir_action=='dothings'){    $pd_site_id=$_POST['pdir_selsite'];    $pdir_do=$_POST['pdir_recdel'];    $pdir_dodel=false;    switch ($pdir_do)    {        case '1': // Edit existing record            {                // We edit the record                $pdir_db->db_Select("pd_sites", "*", "pd_site_id='$pd_site_id'");                $pdir_row=$pdir_db->db_Fetch() ;                extract($pdir_row);                $pdir_cap1=phonedir_ADLAN_10 . " " . phonedir_ADLAN_83;                break;            }         case '2': // New department            {                // Create new record                $pd_site_id=0;                 // set all fields to zero/blank                $pdir_cap1=phonedir_ADLAN_11 . " " . phonedir_ADLAN_83;                break;            }         case '3':            {                 // delete the record                if ($_REQUEST['pdir_okdel']=='1')                {                     // Check if category not used in any other table                    $pdir_countd=$pdir_db->db_Count("pd_directory", "(*)", " where pd_site='$pd_site_id'");                    if ($pdir_countd==0)                    {                        $pdir_msg .=phonedir_ADLAN_54 . "<br />";                        if ($pdir_db->db_Delete("pd_sites", " pd_site_id='$pd_site_id'"))                        {                            $pdir_text .="<table style='width:97%' class='fborder'><tr>						<td  class='fcaption' style='text-align: left;' colspan='2'>" . phonedir_ADLAN_12. "</td></tr>						<tr><td  class='forumheader3' style='text-align: left;' colspan='2'><strong>" . phonedir_ADLAN_86 . "</strong></td></tr>						<tr><td  class='fcaption' style='text-align: left;' colspan='2'><a href=''>" . phonedir_ADLAN_69 . "</a></td>						</tr></table>";                        }                         else                        {                            $pdir_text .="<table style='width:97%' class='fborder'><tr>						<td  class='fcaption' style='text-align: left;' colspan='2'>" . phonedir_ADLAN_12. "</td></tr>						<tr><td  class='forumheader3' style='text-align: left;' colspan='2'><strong>" . phonedir_ADLAN_87 . "</strong></td></tr>						<tr><td  class='fcaption' style='text-align: left;' colspan='2'><a href=''>" . phonedir_ADLAN_69 . "</a></td>						</tr></table>";                        }                     }                     else                    {                        $pdir_text .="<table style='width:97%' class='fborder'><tr>						<td  class='fcaption' style='text-align: left;' colspan='2'>" . phonedir_ADLAN_12. "</td></tr>						<tr><td  class='forumheader3' style='text-align: left;' colspan='2'><strong>" . phonedir_ADLAN_88 . "</strong></td></tr>						<tr><td  class='fcaption' style='text-align: left;' colspan='2'><a href=''>" . phonedir_ADLAN_69 . "</a></td>						</tr></table>";                    }                 }                 else                {                    $pdir_text .="<table style='width:97%' class='fborder'><tr>					<td  class='fcaption' style='text-align: left;' colspan='2'>" . phonedir_ADLAN_12. "</td></tr>						<tr><td  class='forumheader3' style='text-align: left;' colspan='2'><strong>" . phonedir_ADLAN_27 . "</strong></td></tr>					<tr><td  class='fcaption' style='text-align: left;' colspan='2'><a href=''>" . phonedir_ADLAN_69 . "</a></td>					</tr></table>";                }                 $pdir_dodel=true;            }     }     if (!$pdir_dodel)    {        if ($pd_site_id > 0)        {            $pdir_db->db_Select("pd_sites", "*", "pd_site_id='$pd_site_id'");            $sqlrow=$pdir_db->db_Fetch();            extract($sqlrow);        }         $pdir_text .="<form id='edcat' name='edcat' method='post' action='" . e_SELF . "'>	<input type='hidden' name='pd_site_id' value='$pd_site_id' />	<input type='hidden' name='pdir_action' value='update' />	<table width='97%' class='fborder'>		<tr><td colspan='2' class='fcaption'>" . $pdir_cap1 . "</td></tr>  <tr>    <td width='25%' class='forumheader3'>" . LAN_phonedir_25 . "</td>    <td width='75%' class='forumheader3'><input size='40' type='text' class='tbox' name='pd_site_name' value='$pd_site_name' /></td>  </tr>  <tr>    <td width='25%' class='forumheader3'>" . LAN_phonedir_26 . "</td>    <td width='75%' class='forumheader3'><input  size='40' type='text' class='tbox' name='pd_site_address1' value='$pd_site_address1' /></td>  </tr>  <tr>    <td width='25%' class='forumheader3'>" . LAN_phonedir_27 . "</td>    <td width='75%' class='forumheader3'><input  size='40' type='text' class='tbox' name='pd_site_address2' value='$pd_site_address2' /></td>  </tr>  <tr>    <td width='25%' class='forumheader3'>" . LAN_phonedir_28 . "</td>    <td width='75%' class='forumheader3'><input  size='35' type='text' class='tbox' name='pd_site_town' value='$pd_site_town' /></td>  </tr>  <tr>    <td width='25%' class='forumheader3'>" . LAN_phonedir_35 . "</td>    <td width='75%' class='forumheader3'><input  size='30' type='text' class='tbox' name='pd_site_county' value='$pd_site_county' /></td>  </tr>  <tr>    <td width='25%' class='forumheader3'>" . LAN_phonedir_29 . "</td>    <td width='75%' class='forumheader3'><input  size='30' type='text' class='tbox' name='pd_site_postcode' value='$pd_site_postcode' /></td>  </tr>  <tr>    <td width='25%' class='forumheader3'>" . LAN_phonedir_30 . "</td>    <td width='75%' class='forumheader3'><input size='20' type='text' class='tbox' name='pd_site_phone' value='$pd_site_phone' /></td>  </tr>  <tr>    <td width='25%' class='forumheader3'>" . LAN_phonedir_49 . "</td>    <td width='75%' class='forumheader3'><input size='70' type='text' class='tbox' name='pd_site_mapurl' value='$pd_site_mapurl' /></td>  </tr>  <tr>    <td width='25%' class='forumheader3'>" . LAN_phonedir_31 . "</td>    <td width='75%' class='forumheader3'><input size='20' type='text' class='tbox' name='pd_site_fax' value='$pd_site_fax' /></td>  </tr>  <tr>    <td width='25%' class='forumheader3'>" . LAN_phonedir_32 . "</td>    <td width='75%' class='forumheader3'><input size='20' type='text' class='tbox' name='pd_site_phonecentrex' value='$pd_site_phonecentrex' /></td>  </tr>  <tr>    <td width='25%' class='forumheader3'>" . LAN_phonedir_33 . "</td>    <td width='75%' class='forumheader3'><input size='20' type='text' class='tbox' name='pd_site_faxcentrex' value='$pd_site_faxcentrex' /></td>  </tr>    <tr>    <td width='40%' class='forumheader3'>" . phonedir_ADLAN_55 . "</td>    <td width='60%' class='forumheader3'>" . ($pd_site_updated <> 0?$pdir_convert->convert_date($pd_site_updated, "long"):"&nbsp;") . "</td>  </tr>";        $pdir_posterarray=explode(".", $pd_site_updatedby);        $pdir_userid=$pdir_posterarray[0];        $pdir_username=$pdir_posterarray[1];        $pdir_text .="<tr>    <td width='40%' class='forumheader3'>" . phonedir_ADLAN_56 . "</td>    <td width='60%' class='forumheader3'><a href='../../user.php?id.$pdir_userid'>" . $pdir_username . "</a></td>  </tr>  <tr>    <td colspan='2' class='fcaption'><input type='submit' name='pdir_catsave' class='button' value=" . phonedir_ADLAN_66 . " /></td>  </tr>  </table></form>";    } } else{     // Get the department names to display in combo box    // then display actions available    if ($pdir_db->db_Select("pd_sites", "pd_site_id,pd_site_name", " order by pd_site_name", "nowhere"))    {        while ($pdir_row=$pdir_db->db_Fetch())        {            extract($pdir_row);            $pdir_catopt .="<option value='$pd_site_id'>$pd_site_name</option>";        }     }     else    {        $pdir_catopt .="<option value='0'>" . phonedir_ADLAN_98 . "</option>";    }     $pdir_text .="<form id='edcat' method='post' action='" . e_SELF . "'>	<table style='width:97%' class='fborder'>		<tr><td colspan='2' class='fcaption'>" . phonedir_ADLAN_7 . "</td></tr>$pdir_msg	<tr><td style='width:20%' class='forumheader3'><input type='hidden' value='dothings' name='pdir_action' />" . phonedir_ADLAN_7 . "</td><td  class='forumheader3'><select name='pdir_selsite' class='tbox'>$pdir_catopt</select></td></tr>	<tr><td style='width:20%' class='forumheader3'>" . phonedir_ADLAN_65 . "</td><td  class='forumheader3'>	<input type='radio' name='pdir_recdel' value='1' checked='checked' /> " . phonedir_ADLAN_10 . "<br />	<input type='radio' name='pdir_recdel' value='2' /> " . phonedir_ADLAN_11 . "<br />	<input type='radio' name='pdir_recdel' value='3' /> " . phonedir_ADLAN_12 . "	<input type='checkbox' name='pdir_okdel' value='1' />" . phonedir_ADLAN_13 . "</td></tr>	<tr><td colspan='2' class='fcaption'  style='text-align: left;'><input type='submit' name='submits' value='" . phonedir_ADLAN_14 . "' class='button' /></td></tr>		</table></form>";} $ns->tablerender(phonedir_ADLAN_7, $pdir_text);require_once(e_ADMIN . "footer.php");?>