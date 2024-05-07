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
| $Source: e:\_repository\e107_plugins/agenda/agenda_next_weeks_menu.php,v $
| $Revision: 1.5 $
| $Date: 2006/11/29 01:17:02 $
| $Author: Neil $
+---------------------------------------------------------------+
*/
   require(e_PLUGIN."agenda/agenda_variables.php");

   $text = "<div style='width:100%;text-align:center'>";

   // Count entries as we go through then replace the placeholder token with the real value
   ///$text .= AGENDA_LAN_20."@@@@@<br /><br />";

   // Display day column headers
   $text .= "<table cellpadding='0' cellspacing='1' style='width:100%' class='fborder'><tr>";
   foreach ($agenda->getDays() as $agn_day) {
      $text .= "<td class='".$agenda->getPrefHeaderCSS()." smalltext' style='text-align:center'><span class='smalltext'>". substr($agn_day, 0, $pref["agenda_dayname_length"])."</span></td>";
   }
   $text .= "</tr><tr >";

   $dayInWeek = 1;

   // Display month days
   $firstrow = true;
   $agn_entry_count = 0;
   for ($count=0; $count<($pref['agenda_next_weeks']*7); $count++) {
      $agn_day = mktime(0,0,0, date("m", $agenda->getTodayWeekStartDS()), date("d", $agenda->getTodayWeekStartDS()) + $count, date("Y", $agenda->getTodayWeekStartDS()));
      $agn_nextday = $agn_day + $agenda->getOneDay();
      $agn_dayarray = getdate($agn_day);

      if ($pref['agenda_week_start'] == $agn_dayarray['wday'] && !$firstrow) {
         $text .= "</tr><tr>";
         $dayInWeek = 1;
      } else {
         $firstrow = false;
         $dayInWeek++;
      }

      $entries = $agenda->countEvents($agn_day);
      $agn_entry_count += $entries;

      if ($agenda->getTodayDS() == $agn_day) {
         $class = $agenda->getPrefTodayCSS();
      } else if ($entries) {
         $class = $agenda->getPrefDayWithEntriesCSS();
      } else {
         $class = $agenda->getPrefDayCSS();
      }

      if ($entries == 0) {
         $linktitle = "";
      } else if ($entries == 1) {
         $linktitle = "title='$entries".AGENDA_LAN_120."'";
      } else {
         $linktitle = "title='$entries".AGENDA_LAN_21."'";
      }
      $text .= "<td class='smalltext $class' style='text-align:center;width:14%;cursor:pointer;vertical-align:top;' $linktitle ";
      $text .= "onclick='javascript:document.location=\"".$agenda->getPathToAgenda()."?view.".$agenda->getP2().".".$agenda->getP3().".$agn_day\"'>";
      if ($entries) {
         $text .= "<span style='font-weight:bold'>".date("d", $agn_day)."</span>";
         if ($pref["agenda_icons_in_menu"] == "Y") {
            // Just get icon for 1st entry
            if ($event = $agenda->getEvent($agn_day)) {
               $text .= "<br /><img src='".$event->getCatIcon(true)."' alt='*'/>";
            }
         }
      } else {
         $text .= "<span>".date("d", $agn_day)."</span>";
      }
      $text .= "</td>";
   }

   $text .= "</tr></table></div>";

   ///$text = str_replace("@@@@@", $agn_entry_count, $text);

   $ns->tablerender(str_replace("@@@@@", $pref['agenda_next_weeks'], AGENDA_LAN_VIEW_07), $text);
?>