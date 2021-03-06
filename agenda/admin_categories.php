<?php
/*
+---------------------------------------------------------------+
| Agenda by bugrain (www.bugrain.plus.com)
| see plugin.php for version information
|
| A plugin for the e107 Website System (http://e107.org)
|
| Released under the terms and conditions of the
| GNU General Public License (http://gnu.org).
|
| $Source: e:\_repository\e107_plugins/agenda/admin_categories.php,v $
| $Revision: 1.11 $
| $Date: 2006/11/29 01:17:00 $
| $Author: Neil $
+---------------------------------------------------------------+
*/
   require_once("../../class2.php");
   if (!getperms("P")) {
      header("location:".e_BASE."index.php");
   }
   require_once(e_ADMIN."auth.php");
   require(e_PLUGIN."agenda/agenda_variables.php");

   $configtitle      = AGENDA_LAN_ADMIN_02;
   $primaryid        = "cat_id";
   $pageid           = "categories";
   $show_preset      = false;

   $fieldcapt[] = AGENDA_LAN_ADMIN_CATEGORY_00_0;
   $fieldnote[] = AGENDA_LAN_ADMIN_CATEGORY_00_1;
   $fieldname[] = "cat_name";
   $fieldtype[] = "text";
   $fieldvalu[] = ",50,100";
   $fieldmand[] = "*";

   $fieldcapt[] = AGENDA_LAN_ADMIN_CATEGORY_01_0;
   $fieldnote[] = AGENDA_LAN_ADMIN_CATEGORY_01_1;
   $fieldname[] = "cat_description";
   $fieldtype[] = "textarea";
   $fieldvalu[] = ",90%,75px";
   $fieldmand[] = "";

   $fieldcapt[] = AGENDA_LAN_ADMIN_CATEGORY_02_0;
   $fieldnote[] = AGENDA_LAN_ADMIN_CATEGORY_02_1;
   $fieldname[] = "cat_icon";
   $fieldtype[] = "image";
   $fieldvalu[] = e_IMAGE.$pref["agenda_icon_dir"]."/";
   $fieldmand[] = "";

   $fieldcapt[] = AGENDA_LAN_ADMIN_CATEGORY_09_0;
   $fieldnote[] = AGENDA_LAN_ADMIN_CATEGORY_09_1;
   $fieldname[] = "cat_visibility";
   $fieldtype[] = "accesstable";
   $fieldvalu[] = "";

   $fieldcapt[] = AGENDA_LAN_ADMIN_CATEGORY_03_0;
   $fieldnote[] = AGENDA_LAN_ADMIN_CATEGORY_03_1;
   $fieldname[] = "cat_subs";
   $fieldtype[] = "dropdown2";
   $fieldvalu[] = "0:".AGENDA_LAN_ADMIN_CATEGORY_03_2.",1:".AGENDA_LAN_ADMIN_CATEGORY_03_3.",2:".AGENDA_LAN_ADMIN_CATEGORY_03_4.",3:".AGENDA_LAN_ADMIN_CATEGORY_03_5.",4:".AGENDA_LAN_ADMIN_CATEGORY_03_6;
   $fieldmand[] = "";

   $fieldcapt[] = AGENDA_LAN_ADMIN_CATEGORY_04_0;
   $fieldnote[] = AGENDA_LAN_ADMIN_CATEGORY_04_1;
   $fieldname[] = "cat_class";
   $fieldtype[] = "accesstable";
   $fieldvalu[] = "";

   $fieldcapt[] = AGENDA_LAN_ADMIN_CATEGORY_05_0;
   $fieldnote[] = AGENDA_LAN_ADMIN_CATEGORY_05_1;
   $fieldname[] = "cat_notify";
   $fieldtype[] = "dropdown2";
   $fieldvalu[] = "0:".AGENDA_LAN_ADMIN_CATEGORY_05_2.",1:".AGENDA_LAN_ADMIN_CATEGORY_05_3.",2:".AGENDA_LAN_ADMIN_CATEGORY_05_4.",3:".AGENDA_LAN_ADMIN_CATEGORY_05_5;
   $fieldmand[] = "";

   $fieldcapt[] = AGENDA_LAN_ADMIN_CATEGORY_08_0;
   $fieldnote[] = AGENDA_LAN_ADMIN_CATEGORY_08_1;
   $fieldname[] = "cat_msg2";
   $fieldtype[] = "textarea";
   $fieldvalu[] = ",90%,75px";
   $fieldmand[] = "";

   $fieldcapt[] = AGENDA_LAN_ADMIN_CATEGORY_07_0;
   $fieldnote[] = AGENDA_LAN_ADMIN_CATEGORY_07_1;
   $fieldname[] = "cat_msg1";
   $fieldtype[] = "textarea";
   $fieldvalu[] = ",90%,75px";
   $fieldmand[] = "";

   $fieldcapt[] = AGENDA_LAN_ADMIN_CATEGORY_06_0;
   $fieldnote[] = AGENDA_LAN_ADMIN_CATEGORY_06_1;
   $fieldname[] = "cat_ahead";
   $fieldtype[] = "text";
   $fieldvalu[] = "1,3,3";
   $fieldmand[] = "";

//---------------------------------------------------------------
//              END OF CONFIGURATION AREA
//---------------------------------------------------------------

   // -------- Presets. ------------  // always load before auth.php
   if ($show_preset) {
      require_once(e_HANDLER."preset_class.php");
      $pst = new e_preset;
      $pst->form = "adminform"; // form id of the form that will have it's values saved.
      $pst->page = e_SELF; // display preset options on which page(s).
      $pst->id = "admin_".$agenda->getCategoryTable();
   }

   $rs = new agenda_form;
   global $tp;

   // Validation checks
   if (isset($_POST['add']) || isset($_POST['update'])) {
      if (strlen($_POST['cat_name']) == 0) {
         $message .= AGENDA_LAN_ADMIN_CATEGORY_00_MAND;
      }
   }

   // Data is valid so try and add
   if (!isset($message) && isset($_POST['add'])) {
      $count = count($fieldname);

      unset($inputstr);
      for ($i=0; $i<$count; $i++) {
         $inputstr[] = " '".$tp->toDB($_POST[$fieldname[$i]])."'";
      }
      $inputstr = implode(",", $inputstr);

      // Include fields not on form
      $inputstr .= ", '0', '0'";
      if ($agn_sql1->db_Insert($agenda->getCategoryTable(), "0, $inputstr", $agenda->isDebug())) {
         $message = LAN_CREATED;
         unset($_POST['add']);
      } else {
         $message = LAN_CREATED_FAILED;
      }
   }

   // Data is valid so try and update
   if (!isset($message) && isset($_POST['update'])) {
      $count = count($fieldname);
      for ($i=0; $i<$count; $i++) {
         $inputstr .= " ".$fieldname[$i]." = '".$tp->toDB($_POST[$fieldname[$i]])."'";
         $inputstr .= ($i < ($count -1)) ? "," : "";
      }
      $inputstr .= ", cat_last='0', cat_today='0'";
      if ($agn_sql1->db_Update($agenda->getCategoryTable(), "$inputstr WHERE $primaryid='".$_POST[$primaryid]."'", $agenda->isDebug())) {
         $message = LAN_UPDATED;
         unset($_POST['update']);
      } else {
         $message = LAN_UPDATED_FAILED;
      }
   }

   // Get details from DB if Edit, otherwise set from POST data
   if (isset($_POST['edit'])) {
      $agn_sql1->select($agenda->getCategoryTable(), "*", " WHERE $primaryid='".$_POST['existing']."'", true, $agenda->isDebug());
      $row = $agn_sql1->db_Fetch();
   } else {
      if (isset($_POST['add']) || isset($_POST['update'])) {
         $row = $_POST;
      }
   }

   // Try the delete
   if (isset($_POST['delete'])) {
      $agn_sql1->select($agenda->getAgendaTable(), "*", " WHERE agn_category='".$_POST['existing']."'", true, $agenda->isDebug());
      if (!$agn_sql1->db_Fetch()) {
         $msg = ($agn_sql1->db_Delete($agenda->getCategoryTable(), "$primaryid='".$_POST['existing']."'", $agenda->isDebug())) ? LAN_DELETED : LAN_DELETED_FAILED;
      } else {
         $msg = AGENDA_LAN_ADMIN_MISC_1;
      }
      message_handler("MESSAGE", $msg);
   }

   /*// Draw the form
   if (file_exists(e_PLUGIN."updatecheckerx/updatechecker.php")) {
      require_once(e_PLUGIN."updatecheckerx/updatechecker.php");
      $text .= updateChecker(AGENDA_LAN_NAME, AGENDA_LAN_VER, "http://www.bugrain.plus.com/e107plugins/agenda.ver", "|");
   }  */

   if (!file_exists(e_PLUGIN."e107helpers/calendar/calendar_class.php")) {
      $text .= "<div style='text-align:center'>";
      $text .= AGENDA_LAN_104;
      $text .= AGENDA_LAN_105;
      $text .= "</div>";
   }

   $text .= "<div style='text-align:center'><form method='post' action='".e_SELF."' id='myexistingform'>
      <table style='width:100%;margin-left:auto;margin-right:auto;' class='fborder'>";

   if (isset($message)) {
      $text .= "<tr><td colspan='2' class='spacer' style='text-align:center'>$message</td></tr>";
   }

   $text .= "<tr><td colspan='2' class='forumheader' style='text-align:center'>";

   $table_total = $agn_sql1->select($agenda->getCategoryTable(), "*", "order by cat_name asc", "no-where", $agenda->isDebug());
   if (!$table_total) {
      $text .= LAN_EMPTY;
   } else {
      $text .= "<span class='defaulttext'>".LAN_EXISTING."&nbsp;</span><select name='existing' class='tbox'>";
      while ($agn_crow = $agn_sql1->db_Fetch()) {
         extract($agn_crow, EXTR_OVERWRITE);
         $text .= "<option value='$cat_id'>$cat_name</option>";
      }
      $text .= "</select>&nbsp;&nbsp;<input class='button' type='submit' name='edit' value='".LAN_EDIT."' />
                <input class='button' type='submit' name='delete' value='".LAN_DELETE."' /></td></tr>";
   }

   $text .= "</table></form></div>";

   $text .= "<div style='text-align:center'>";
   $text .= "<form method='post' action='".e_SELF."' id='adminform'><table class='fborder' style='margin-left:auto;margin-right:auto;width:100%'>";
   for ($i=0; $i<count($fieldcapt); $i++) {
      $form_send = $fieldcapt[$i] . "|" .$fieldtype[$i]."|".$fieldvalu[$i];
      $text .= "<tr>
         <td style='vertical-align:top' class='forumheader3'>".$fieldcapt[$i]." ".$fieldmand[$i]."<br><span class='smalltext'>".$fieldnote[$i]."</span></td>
         <td class='forumheader3'>";
      $text .= $rs->user_extended_element_edit($form_send, $row[$fieldname[$i]], $fieldname[$i]);
      $text .= "</td></tr>";
   };

   $text .= "<tr style='vertical-align:top'><td colspan='2' style='text-align:center' class='forumheader'>";

   if (isset($_POST['edit']) || isset($_POST['update'])){
      $text .= "<input class='button' type='submit' id='update' name='update' value='".LAN_UPDATE."' />
      <input type='hidden' name='$primaryid' value='".$row[$primaryid]."'>";
   } else {
      $text .= "<input class='button' type='submit' id='add' name='add' value='".LAN_CREATE."' />";
   }

   $text .= "</td></tr></table></form></div>";
   $ns->tablerender($configtitle, $text);

   require_once(e_ADMIN."footer.php");
?>