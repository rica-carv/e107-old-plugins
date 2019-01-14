<script type="text/javascript">
function CheckForm(){
	var gamesorteams = "<?php echo strtolower($conf['gamesorteams']);?>";
	var gameorteam = "<?php echo substr(strtolower($conf['gamesorteams']),0,4);?>";
	var chkmem = false;
	var chkgroup = false;
	var members = document.getElementsByName('members[]');
	for(var i=0; i < members.length; i++){
		if(members[i].checked) chkmem = true;
	}
	var groups = document.getElementsByName(gamesorteams+'[]');
	for(var i=0; i < groups.length; i++){
		if(groups[i].checked) chkgroup = true;
	}
	
	if(!chkmem){
		alert("Please select at least 1 member");
		return false;
	}
	
	if(chkgroup){
		return true;
	}else{
		sure = confirm("You haven't selected a "+gameorteam+". Members won't be shown on the clan members page unless they have a "+gameorteam+" assigned.");
		if(sure){
			return true;
		}else{
			return false;
		}
	}
}
</script>
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

$query = $tp->toDB($_POST['query']);
$games = $tp->toDB($_POST['games']);
if($games !="") $glist = explode(",", $games);


$text = "<form method='post'><input type='text' size='15' name='query' value='$query'> <input type='submit' class='button' value='"._SEARCH."'><input type='hidden' name='e-token' value='".e_TOKEN."' /></form><br />";
$text .= "<form method='post' action='admin_old.php?AddUsers' onsubmit='return CheckForm();'>";
$where = "";
if($query !=""){
	$where = "WHERE user_name LIKE '%$query%'";
}
$sql1 = e107::getDB();
$sql -> select("user", "user_id, user_name", "$where ORDER BY user_name ASC", "");
	while($row = $sql-> fetch()){
		$userid = $row['user_id'];
		$member = $row['user_name'];
		if($sql1->db_Count("clan_members_info", "(*)", "WHERE userid='$userid'") == 0){
			$text .= "<label><input name='members[]' value='$userid' type='checkbox' ".($games !="" && $member==$query?"checked":"").">$member</label><br />";
			$nousers++;
		}		
	}


if($nousers > 0){	
	$ns->tablerender(_USERS, $text);
	//Games
	if($sql->db_Count("clan_games", "(*)", "WHERE inmembers='1'") > 0){
		$text = "";
		$sql -> select("clan_games", "gid, gname", "ORDER BY position ASC", "");
		while($row = $sql-> fetch()){
			$gid = $row['gid'];
			$gname = $row['gname'];
			$text .= "<label><input name='games[]' value='$gid' type='checkbox' ".($games !="" && in_array($gid,$glist)?"checked":"").">$gname</label><br />";
		}
		$ns->tablerender(_INFOGames, $text);
	}
	
	//Teams
	if($sql->db_Count("clan_teams", "(*)", "WHERE inmembers='1'") > 0){
	$text = "";
	$sql -> select("clan_teams", "tid, team_name", "ORDER BY position ASC", "");
		while($row = $sql-> fetch()){
			$tid = $row['tid'];
			$team_name = $row['team_name'];
			$text .= "<label><input name='teams[]' value='$tid' type='checkbox'>$team_name</label><br />";
		}
		$ns->tablerender(_INFOTeams, $text);
	}
	
	//Ranks
	if($sql->db_Count("clan_members_ranks") > 0){
	$text = "<select name='rank'>
		<option value='0'>"._NORANK."</option>";
	$sql -> select("clan_members_ranks", "rid, rank", "ORDER BY rankorder ASC", "");
		while($row = $sql-> fetch()){
			$rid = $row['rid'];
			$rank = $row['rank'];
			$text .= "<option value='$rid'>$rank</option>";
		}
		$text .= "</select><br />";
		$ns->tablerender(_INFORanks, $text);
	}
	$text = "<input type='submit' class='button' value='"._ADDUSERS."'>";
	$ns->tablerender($text, "");
}elseif($query == ""){
	$ns->tablerender(_USERS, _ALLUSERSINCMLIST);
}else{
$text = "<form method='post'><input type='text' size='15' name='query' value='$query'> <input type='submit' class='button' value='"._SEARCH."'><input type='hidden' name='e-token' value='".e_TOKEN."' /></form><br />";
	$ns->tablerender(_USERS, $text."<br />"._NOUSERSFOUND);
}

echo "<input type='hidden' name='e-token' value='".e_TOKEN."' />
</form>";

?>