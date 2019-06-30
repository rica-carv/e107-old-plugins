<?php // ***************************************************************// *// *		Title		:	Corporate Phone Directory// *// *		Author		:	Barry Keal// *// *		Date		:	6 May 2004// *// *		Version		:	1.01// *// *		Description	: 	Corporate phone directory// *// *		Revisions	:	06 May 2004 Initial design// *// ***************************************************************require_once("../../class2.php");if (e_LANGUAGE != "English" && file_exists(e_PLUGIN . "phonedir/languages/admin/" . e_LANGUAGE . ".php")){    include_once(e_PLUGIN . "phonedir/languages/admin/" . e_LANGUAGE . ".php");} else{    include_once(e_PLUGIN . "phonedir/languages/admin/English.php");} require_once(e_HANDLER . "userclass_class.php");require_once(HEADERF);$pd_db = new DB;$pd_db = new DB;// Are we saving the record?$pd_save = $_POST['pd_save'];if (!empty($pd_save)){    $pd_id = $_POST['pd_id'];    require_once("pdsave.inc");} else{    $pd_text .= "<table width = '97%' class = 'fborder'><tr><td class = 'forumheader3'>&nbsp;</td></tr></table>";} // If $_POST['pdcat_selection'] is not set then get first recordif (!isset($_POST['pdcat_selection'])){    if ($pd_db->db_Select("pd_categories", "pdcat_id", " order by pdcat_desc", "nowhere"))    {        if ($pd_row = $pd_db->db_Fetch())        {            extract($pd_row);            $pd_dircat = $pdcat_id;        }     } } else{    $pd_dircat = $_POST['pdcat_selection'];    $pd_selection = $_POST['pd_actionsel'];    switch ($pd_selection)    {        case "1": // Edit category            $pd_id = $_POST['pdcat_selection'];            require_once("editcat.inc");            break;        case "2": // New category            $pd_id = 0;            require_once("editcat.inc");            break;        case "3": // Delete category            break;        case "4": // Edit user            $pd_id = $_POST['pdcat_uid'];            require_once("edituser.inc");            break;        case "5": // New user            $pd_id = 0;            require_once("edituser.inc");            break;        case "6": // Delete user            if ($_POST['pd_dodelu'] == '1')            {                $args = "id='" . $_POST['pdcat_uid'] . "'";                $pd_db->db_Delete("pd_directory", $args);                $pd_text .= $pd_head . phonedir_ADLAN_28 . $pd_tail;            }             else            {                $pd_text .= $pd_head . phonedir_ADLAN_27 . $pd_tail;            }             break;        case "7": // Edit site            $pd_id = $_POST['pdcat_sid'];            require_once("editsite.inc");            break;        case "8": // New site            $pd_id = 0;            require_once("editsite.inc");            break;        case "9": // Edit site            if ($_POST['pd_dodels'] == '1')            {                $args = "site_id='" . $_POST['pdcat_sid'] . "'";                $count = $pd_db->db_Count("pd_directory", "(*)", "where site='" . $_POST['$pd_locsel'] . "'");                if ($count > 0)                {                    $pd_text = $pd_head . phonedir_ADLAN_29 . $pd_tail;                }                 else                {                    $pd_db->db_Delete("pd_sites", $args);                    $pd_text = $pd_head . phonedir_ADLAN_30 . $pd_tail;                }             }             else            {                $pd_text .= $pd_head . phonedir_ADLAN_27 . $pd_tail;            }             break;        case "10": // Edit department            $pd_id = $_POST['pdcat_did'];            require_once("editdept.inc");            break;        case "11": // New Department            $pd_id = 0;            require_once("editdept.inc");            break;        case "12": // Delete Department            if ($_POST['pd_dodeld'] == '1')            {                $args = "Dept_id='" . $_POST['pdcat_did'] . "'";                $count = $pd_db->db_Count("pd_directory", "(*)", "where department='" . $_POST['$pd_depsel'] . "'");                if ($count > 0)                {                    $pd_text .= $pd_head . phonedir_ADLAN_31 . $pd_tail;                }                 else                {                    $pd_db->db_Delete("pd_department", $args);                    $pd_text .= $pd_head . phonedir_ADLAN_32 . $pd_tail;                }             }             else            {                $pd_text .= $pd_head . phonedir_ADLAN_27 . $pd_tail;            }             break;        case "13": // Edit job            $pd_id = $_POST['pdcat_jid'];            require_once("editjobs.inc");            break;        case "14": // New job            $pd_id = 0;            require_once("editjobs.inc");            break;        case "15": // Delete job            if ($_POST['pd_dodelj'] == '1')            {                $args = "job_id='" . $_POST['$pd_jobsel'] . "'";                $count = $pd_db->db_Count("pd_directory", "(*)", "where job_title='" . $_POST['$pd_jobsel'] . "'");                if ($count > 0)                {                    $pd_text .= $pd_head . phonedir_ADLAN_33 . $pd_tail;                }                 else                {                    $pd_db->db_Delete("pd_jobtitle", $args);                    $pd_text .= $pd_head . phonedir_ADLAN_34 . $pd_tail;                }             }             else            {                $pd_text .= $pd_head . phonedir_ADLAN_27 . $pd_tail;            }             break;        default :             // # Get categories user can edit into an option box            $pd_db = new DB;            $pd_text .= "<form method = 'post' action='' name='pdadmin'>	<script language='javascript'>	function changecat()	{		window.document.pdadmin.pd_actionsel.value = '0';		window.document.pdadmin.submit();	}	</script>	<input type = 'hidden' name = 'pd_action' value = '$pd_action'>	<input type = 'hidden' name = 'pd_cat' value = '$pd_cat'>";             // Get the list of classes the user is in            $pd_db->db_Select("user", "user_class", "user_id = '" . USERID . "'");            $pd_row = $pd_db->db_Fetch();            extract($pd_row);             // replace . with , for use in MYSQL find_in_set            $pd_lookfor = str_replace(".", ",", $user_class);             // If the user is logged in then also get members and guest            if (USERID > 0)            {                $pd_lookfor .= ",252,253";            }             $pd_arg2 = "find_in_set(pdcat_adminclass,'$pd_lookfor')> 0";             // if admin get them all (also check if in admin class $pref['phonedir_adminclass'])            if (ADMIN || check_class($pref['phonedir_adminclass'])) $pd_arg2 = "pdcat_adminclass >= 0";             // Now get the categories that can be seen by this user            if ($pd_db->db_Select("pd_categories", "pdcat_id,pdcat_desc", " $pd_arg2 order by pdcat_desc"))            {                while ($pd_row = $pd_db->db_Fetch())                {                    extract($pd_row);                    $pd_catsel .= "<option value='$pdcat_id'" .                    ($pdcat_id == $_POST['pdcat_selection']?" selected ":"") . ">$pdcat_desc</option>'";                }             }             else            {                $pd_catsel .= "<option value='0'>" . phonedir_ADLAN_37 . "</option>'";            }             $pd_text .= "<table class = 'fborder' width = '97%'>	<tr><td class = 'forumheader' width = '30%'>" . phonedir_ADLAN_16 . "</td>	<td class = 'forumheader'><select name='pdcat_selection' class = 'tbox'  onChange='changecat()'>$pd_catsel</select></td></tr>	</table>	<div style='text-align:center'><div class='caption' title='" . phonedir_ADLAN_22 . "' style='cursor:pointer;cursor:hand;text-align:left;border:1px solid black;width:97%' onClick=\"expandit(this)\">" . phonedir_ADLAN_36 . "</div>	<div id='theme' style='display:none'>	<table class = 'fborder' width = '97%'>	<tr><td class = 'forumheader3'>" . phonedir_ADLAN_42 . "</td><td class = 'forumheader3'>	<input type='radio' class = 'tbox' name='pd_actionsel' value = '1'  > " . phonedir_ADLAN_10 . "	<input type='radio' class = 'tbox' name='pd_actionsel' value = '2'> " . phonedir_ADLAN_11 . "	<input type='radio' class = 'tbox' name='pd_actionsel' value = '3'> " . phonedir_ADLAN_12 . "	<input type = 'checkbox' value = '1' name = 'pd_dodelc' class = 'tbox'> " . phonedir_ADLAN_13 . "	</td></tr>	</table></div>";            if ($pd_db->db_Select("pd_directory", "id,last_name,first_name", " dir_cat = '$pd_dircat' order by last_name,first_name"))            {                while ($pd_row = $pd_db->db_Fetch())                {                    extract($pd_row);                    $pd_usrsel .= "<option value='$id'>$last_name, $first_name</option>'";                }             }             else            {                $pd_usrsel .= "<option value='0'>" . phonedir_ADLAN_37 . "</option>'";            }             $pd_text .= "	<div style='text-align:center'><div class='caption' title='" . phonedir_ADLAN_22 . "' style='cursor:pointer;cursor:hand;text-align:left;border:1px solid black;width:97%' onClick=\"expandit(this)\">" . phonedir_ADLAN_23 . "</div><div id='theme' style='display:none'><table class = 'fborder' width = '97%'>	<tr><td class = 'forumheader' colspan = '2'>" . phonedir_ADLAN_23 . "</td></tr>	<tr><td class = 'forumheader3' width = '30%'>" . phonedir_ADLAN_38 . "</td>	<td class = 'forumheader3'><select name='pdcat_uid' class = 'tbox'>$pd_usrsel</select></td></tr>	<tr><td class = 'forumheader3'>" . phonedir_ADLAN_42 . "</td><td class = 'forumheader3'>	<input type='radio' class = 'tbox' name='pd_actionsel' value = '4'> " . phonedir_ADLAN_10 . "	<input type='radio' class = 'tbox' name='pd_actionsel' value = '5'> " . phonedir_ADLAN_11 . "	<input type='radio' class = 'tbox' name='pd_actionsel' value = '6'> " . phonedir_ADLAN_12 . "	<input type = 'checkbox' value = '1' name = 'pd_dodelu' class = 'tbox'> " . phonedir_ADLAN_13 . "	</td></tr>	</table></div>";            if ($pd_db->db_Select("pd_sites", "site_id,site_name", " site_category = '$pd_dircat' order by site_name"))            {                while ($pd_row = $pd_db->db_Fetch())                {                    extract($pd_row);                    $pd_locsel .= "<option value='$site_id'>$site_name</option>'";                }             }             else            {                $pd_locsel .= "<option value='0'>" . phonedir_ADLAN_37 . "</option>'";            }             $pd_text .= "<div style='text-align:center'><div class='caption' title='" . phonedir_ADLAN_22 . "' style='cursor:pointer;cursor:hand;text-align:left;border:1px solid black;width:97%' onClick=\"expandit(this)\">" . phonedir_ADLAN_24 . "</div><div id='theme' style='display:none'><table class = 'fborder' width = '97%'>	<tr><td class = 'forumheader' colspan = '2'>" . phonedir_ADLAN_24 . "</td></tr>	<tr><td class = 'forumheader3' width = '30%'>" . phonedir_ADLAN_7 . "</td>	<td class = 'forumheader3'><select name='pdcat_sid' class = 'tbox'>$pd_locsel</select></td></tr>	<tr><td class = 'forumheader3'>" . phonedir_ADLAN_42 . "</td><td class = 'forumheader3'>	<input type='radio' class = 'tbox' name='pd_actionsel' value = '7'> " . phonedir_ADLAN_10 . "	<input type='radio' class = 'tbox' name='pd_actionsel' value = '8'> " . phonedir_ADLAN_11 . "	<input type='radio' class = 'tbox' name='pd_actionsel' value = '9'> " . phonedir_ADLAN_12 . "	<input type = 'checkbox' value = '1' name = 'pd_dodels' class = 'tbox'> " . phonedir_ADLAN_13 . "	</td></tr>	</table></div>";            if ($pd_db->db_Select("pd_department", "dept_id,Dept_name", " Dept_category = '$pd_dircat' order by Dept_name"))            {                while ($pd_row = $pd_db->db_Fetch())                {                    extract($pd_row);                    $pd_depsel .= "<option value='$dept_id'>$Dept_name</option>'";                }             }             else            {                $pd_depsel .= "<option value='0'>" . phonedir_ADLAN_37 . "</option>'";            }             $pd_text .= "<div style='text-align:center'><div class='caption' title='" . phonedir_ADLAN_22 . "' style='cursor:pointer;cursor:hand;text-align:left;border:1px solid black;width:97%' onClick=\"expandit(this)\">" . phonedir_ADLAN_25 . "</div><div id='theme' style='display:none'><table class = 'fborder' width = '97%'>	<tr><td class = 'forumheader' colspan = '2'>" . phonedir_ADLAN_25 . "</td></tr>	<tr><td class = 'forumheader3' width = '30%'>" . phonedir_ADLAN_8 . "</td>	<td class = 'forumheader3'><select name='pdcat_did' class = 'tbox'>$pd_depsel</select></td></tr>	<tr><td class = 'forumheader3'>" . phonedir_ADLAN_42 . "</td><td class = 'forumheader3'>	<input type='radio' class = 'tbox' name='pd_actionsel' value = '10'> " . phonedir_ADLAN_10 . "	<input type='radio' class = 'tbox' name='pd_actionsel' value = '11'> " . phonedir_ADLAN_11 . "	<input type='radio' class = 'tbox' name='pd_actionsel' value = '12'> " . phonedir_ADLAN_12 . "	<input type = 'checkbox' value = '1' name = 'pd_dodeld' class = 'tbox'> " . phonedir_ADLAN_13 . "	</td></tr>	</table></div>";            if ($pd_db->db_Select("pd_jobtitle", "job_id,job_title", " job_category = '$pd_dircat' order by job_title"))            {                while ($pd_row = $pd_db->db_Fetch())                {                    extract($pd_row);                    $pd_jobsel .= "<option value='$job_id'>$job_title</option>'";                }             }             else            {                $pd_jobsel .= "<option value='0'>" . phonedir_ADLAN_37 . "</option>'";            }             $pd_text .= "<div style='text-align:center'><div class='caption' title='" . phonedir_ADLAN_22 . "' style='cursor:pointer;cursor:hand;text-align:left;border:1px solid black;width:97%' onClick=\"expandit(this)\">" . phonedir_ADLAN_26 . "</div><div id='theme' style='display:none'><table class = 'fborder' width = '97%'>	<tr><td class = 'forumheader' colspan = '2'>" . phonedir_ADLAN_26 . "</td></tr>	<tr><td class = 'forumheader3' width = '30%'>" . phonedir_ADLAN_39 . "</td>	<td class = 'forumheader3'><select name='pdcat_jid' class = 'tbox'>$pd_jobsel</select></td></tr>	<tr><td class = 'forumheader3'>" . phonedir_ADLAN_42 . "</td><td class = 'forumheader3'>	<input type='radio' class = 'tbox' name='pd_actionsel' value = '13'> " . phonedir_ADLAN_10 . "	<input type='radio' class = 'tbox' name='pd_actionsel' value = '14'> " . phonedir_ADLAN_11 . "	<input type='radio' class = 'tbox' name='pd_actionsel' value = '15'> " . phonedir_ADLAN_12 . "	<input type = 'checkbox' value = '1' name = 'pd_dodelj' class = 'tbox'> " . phonedir_ADLAN_13 . "	</td></tr>	</table></div>";            $pd_text .= "<table class = 'fborder' width = '97%'>	<tr><td class = 'forumheader' colspan = '2'><input type = 'submit' name = 'subit' value = '" . phonedir_ADLAN_41 . "' class = 'tbox'></td></tr>	</table>	</form>";            break;    }     $ns->tablerender(phonedir_ADLAN_1, $pd_text);    require_once(FOOTERF);    ?>