<?php// **************************************************************************// *// *  Phone Directory configuration for e107 v7xx// *// **************************************************************************require_once("../../class2.php");if (e_LANGUAGE != "English" && file_exists(e_PLUGIN . "phonedir/languages/admin/" . e_LANGUAGE . ".php")){    include_once(e_PLUGIN . "phonedir/languages/admin/" . e_LANGUAGE . ".php");}else{    include_once(e_PLUGIN . "phonedir/languages/admin/English.php");}if (!getperms("P")){    header("location:" . e_HTTP . "index.php");    exit;}require_once(e_ADMIN . "auth.php");require_once(e_HANDLER . "userclass_class.php");if (e_QUERY == "update"){    // Update rest    $pref['phonedir_userclass'] = $tp->toDB($_POST['phonediruserclass']);    $pref['phonedir_perpage'] = $tp->toDB($_POST['phonedirperpage']);    $pref['phonedir_usesite'] = $tp->toDB($_POST['phonedir_usesite']);    $pref['phonedir_usedept'] = $tp->toDB($_POST['phonedir_usedept']);    $pref['phonedir_usejob'] = $tp->toDB($_POST['phonedir_usejob']);    $pref['phonedir_useoffice'] = $tp->toDB($_POST['phonedir_useoffice']);    $pref['phonedir_defcat'] = $tp->toDB($_POST['phonedir_defcat']);    $pref['phonedir_metakey'] = $tp->toDB($_POST['phonedir_metakey']);    $pref['phonedir_metadesc'] = $tp->toDB($_POST['phonedir_metadesc']);    $pref['phonedir_usephoto'] = $tp->toDB($_POST['phonedir_usephoto']);    $pref['phonedir_photoh'] = $tp->toDB($_POST['phonedir_photoh']);    $pref['phonedir_photow'] = $tp->toDB($_POST['phonedir_photow']);    save_prefs();    $pdir_msg .= "<tr><td class='forumheader3' colspan='2'><strong>" . phonedir_ADLAN_64 . "</strong></td></tr>";}$pdir_text .= "<form method='post' action='" . e_SELF . "?update' id='phonedir'><table style='width: 97%; border: 0;' class='fborder' ><tr><td class='fcaption' colspan='2'>" . phonedir_ADLAN_51 . "</td></tr>";$pdir_text .= "";if (isset($pdir_msg)){    $pdir_text .= $pdir_msg;}// userclass$pdir_text .= "<tr><td style='width:30%' class='forumheader3'>" . phonedir_ADLAN_2 . ":<br /><span class='smalltext'>(" . phonedir_ADLAN_2 . ")</span></td><td class='forumheader3'>" . r_userclass("phonediruserclass", $pref['phonedir_userclass']) . "</td></tr>";// User delete time$pdir_text .= "<tr><td style='width:30%' class='forumheader3'>" . phonedir_ADLAN_4 . " :</td><td  class='forumheader3'><input type='text' size='4' name='phonedirperpage' value='" . $tp->toFORM($pref['phonedir_perpage']) . "' class='tbox' /></td></tr>";// use site$pdir_text .= "<tr><td style='width:30%' class='forumheader3'>" . phonedir_ADLAN_60 . " :</td><td class='forumheader3'><input type='checkbox' name='phonedir_usesite' value='1'" .($pref['phonedir_usesite'] == 1?" checked='checked'":"") . " class='tbox' /></td></tr>";// use department$pdir_text .= "<tr><td style='width:30%' class='forumheader3'>" . phonedir_ADLAN_61 . " :</td><td class='forumheader3'><input type='checkbox' name='phonedir_usedept' value='1'" .($pref['phonedir_usedept'] == 1?" checked='checked'":"") . " class='tbox' /></td></tr>";// use job$pdir_text .= "<tr><td style='width:30%' class='forumheader3'>" . phonedir_ADLAN_62 . " :</td><td class='forumheader3'><input type='checkbox' name='phonedir_usejob' value='1'" .($pref['phonedir_usejob'] == 1?" checked='checked'":"") . " class='tbox' /></td></tr>";// use officed$pdir_text .= "<tr><td style='width:30%' class='forumheader3'>" . phonedir_ADLAN_63 . " :</td><td class='forumheader3'><input type='checkbox' name='phonedir_useoffice' value='1'" .($pref['phonedir_useoffice'] == 1?" checked='checked'":"") . " class='tbox' /></td></tr>";// use photo$pdir_text .= "<tr><td style='width:30%' class='forumheader3'>" . phonedir_ADLAN_111 . " :</td><td class='forumheader3'><input type='checkbox' name='phonedir_usephoto' value='1'" .($pref['phonedir_usephoto'] == 1?" checked='checked'":"") . " class='tbox' /></td></tr>";$pdir_text .= "<tr><td style='width:30%' class='forumheader3'>" . phonedir_ADLAN_127 . " :</td><td  class='forumheader3'><input type='text' size='10' name='phonedir_photoh' value='" . $tp->toFORM($pref['phonedir_photoh']) . "' class='tbox' /></td></tr>";$pdir_text .= "<tr><td style='width:30%' class='forumheader3'>" . phonedir_ADLAN_128 . " :</td><td  class='forumheader3'><input type='text' size='10' name='phonedir_photow' value='" . $tp->toFORM($pref['phonedir_photow']) . "' class='tbox' /></td></tr>";$pdir_text .= "<tr><td style='width:30%' class='forumheader3'>" . phonedir_ADLAN_105 . " :</td><td class='forumheader3'><select  class='tbox' name='phonedir_defcat'  >";$pdir_text .= "<option  value='0'>" . phonedir_ADLAN_107 . "</option>";if ($sql->db_Select("pd_categories", "pd_cat_id,pd_cat_desc", " order by pd_cat_desc", "nowhere")){    while ($catrow = $sql->db_Fetch())    {        extract($catrow);        $pdir_text .= "<option  value='$pd_cat_id'";        $pdir_text .= ($pd_cat_id == $pref['phonedir_defcat']?" selected='selected'":"");        $pdir_text .= ">$pd_cat_desc</option>";    }}else{    $pdir_text .= "<option  value='0'>" . phonedir_ADLAN_106 . "</option>";}$pdir_text .= "	</select></td></tr>";$pdir_text .= "<tr><td style='width:30%' class='forumheader3'>" . phonedir_ADLAN_109 . " :</td><td class='forumheader3'><textarea class='tbox' rows='6' cols='80%' name='phonedir_metadesc'>" . $tp->toFORM($pref['phonedir_metadesc']) . "</textarea></td></tr>";$pdir_text .= "<tr><td style='width:30%' class='forumheader3'>" . phonedir_ADLAN_110 . " :</td><td class='forumheader3'><textarea class='tbox' rows='6' cols='80%' name='phonedir_metakey'>" . $tp->toFORM($pref['phonedir_metakey']) . "</textarea></td></tr>";// Submit button$pdir_text .= "<tr><td colspan='2'class='fcaption' style='text-align: left;'><input type='submit' name='update' value='" . phonedir_ADLAN_5 . "' class='button' />\n</td></tr>";$pdir_text .= "</table></form>";$ns->tablerender(phonedir_ADLAN_1, $pdir_text);require_once(e_ADMIN . "footer.php");?>