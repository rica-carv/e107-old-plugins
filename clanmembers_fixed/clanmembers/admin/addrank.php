<?php
/*
+ -----------------------------------------------------------------+
| e107: Clan Members 1.0                                           |
| ===========================                                      |
|                                                                  |
| Copyright (c) 2011 Untergang                                     |
| http://www.udesigns.be/                                          |
|                                                                  |
| This file may not be redistributed in whole or significant part. |
+------------------------------------------------------------------+
*/

if (!defined('CM_ADMIN')) {
	die ("Access Denied");
}

$tp = e107::getParser();
$sql = e107::getDb();

$rank = $tp->toDB($_POST['rank']);
$text = "";
if(isset($_FILES['rankimage'])) {         
	//select filename and filesize
	$filename = $_FILES['rankimage']['name'];       print_a($filename);
	if($filename !=""){	
		$filename = explode(".", $filename);
		$ext = strtolower($filename[count($filename) -1]);
		$rankimage = str_replace(" ","_",preg_replace("/[^a-zA-Z0-9\s]/", "", $rank)."-".rand(100, 999).".".$ext);
	
		if($ext != "jpg" && $ext != "jpeg" && $ext != "gif" && $ext != "png"){
			$text = "<center><br />"._ONLYIMGSALLOWED."<br /><br /></center>";
		}else{	
			//upload the file 
			move_uploaded_file($_FILES['rankimage']['tmp_name'], "images/Ranks/$rankimage"); 
			//chmod the file so everyine can see it 
			chmod("images/Ranks/$rankimage", 0777);
		}
	}
	else $rankimage = '';
}
else $rankimage = '';

$sql->select("clan_members_ranks", "*", "ORDER BY rankorder DESC LIMIT 1","");
$row = $sql->fetch();
	$order = $row['rankorder'] + 1;

$result = $sql->db_Insert("clan_members_ranks", array("rank" => $rank, "rimage" => $rankimage, "rankorder" => $order));
	var_dump($rankimage);
	if($result){
		$text .= "<center><meta http-equiv='refresh' content='1;URL=admin_old.php?Ranks' />
		<br />"._RANKADDED."<br /><br />";
	}else{
		$text .= "<center><br />".ERRORUPDATINGDB."<br /><br />";
	}

$ns->tablerender(_CLANMEMBERS, $text);		
?>