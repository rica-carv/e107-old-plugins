<?php
/*
+---------------------------------------------------------------+
| Auction by bugrain (www.bugrain.plus.com)
|
| A plugin for the e107 Website System (http://e107.org)
|
| Released under the terms and conditions of the
| GNU General Public License (http://gnu.org).
|
| $Source: e:\_repository\e107_plugins/auction/handlers/auction_status_info.php,v $
| $Revision: 1.2 $
| $Date: 2008/06/28 05:52:49 $
| $Author: Neil $
+---------------------------------------------------------------+
*/

// Status Info levels
define("STATUS_DEBUG",  "DEBUG");
define("STATUS_INFO",   "INFO");
define("STATUS_WARN",   "WARN");
define("STATUS_ERROR",  "ERROR");
define("STATUS_FATAL",  "FATAL");

/**
 * Model Object for an Auction error
 * Holds information relating to errors and warnings
 */
class auctionStatusInfo {
   var $level;       // Status level
   var $messages;    // array of messages

   /**
    * Constructor
    * @param $level status level, defaults to STATUS_ERROR - refer to STATUS_* constants
    */
   function auctionStatusInfo($level=STATUS_ERROR) {
      $this->level = $level;
      $this->messages = array();
   }

   function getLevel() {
      return $this->level;
   }
   function getLevelDescription() {
      switch ($this->level) {
         case STATUS_DEBUG : {
            return AUC_LAN_MSG_DEBUG;
         }
         case STATUS_INFO : {
            return AUC_LAN_MSG_INFORMATION;
         }
         case STATUS_WARN : {
            return AUC_LAN_MSG_WARNING;
         }
         case STATUS_ERROR : {
            return AUC_LAN_MSG_ERROR;
         }
         case STATUS_FATAL : {
            return AUC_LAN_MSG_FATAL;
         }
         default : {
            return "";
         }
      }
   }
   function getMessageCount() {
      return count($this->messages);
   }
   function getMessage($ix) {
      return $this->messages[$ix]["message"];
   }
   function getAdditionalDetails($ix) {
      return $this->messages[$ix]["additional"];
   }
   function hasAdditionalDetails($ix) {
      return (isset($this->messages[$ix]["additional"]));
   }

   function addMessage($message, $additionalDetails=false) {
      $this->messages[]["message"] = $message;
      if (false !== $additionalDetails) {
         return $this->messages[count($this->messages)-1]["additional"] = $additionalDetails;
      }
   }
   function addMissingMandatory($fieldName) {
      return $this->messages[]["message"] = $fieldName.AUC_LAN_MSG_MANDATORY;
   }
}
?>