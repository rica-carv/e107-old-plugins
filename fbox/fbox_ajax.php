<?php/* $Id: fbox_ajax.php 667 2007-11-15 12:49:31Z secretr $ */require_once("../../class2.php");$lan_file = e_PLUGIN."fbox/languages/".e_LANGUAGE.".php";include_lan($lan_file);if(strpos(e_QUERY, 'item.') !== FALSE) {    $tmp = explode('.', e_QUERY);    $id = intval($tmp[1]);     $parm = str_replace('+', '&', urldecode($tmp[2]));//        require_once(e_PLUGIN.'fbox/includes/fbox_utils.php');        if($ret = fbox_sc($parm, $id)) {        echo $ret;        exit;    }    //debug    echo '[FAILED] '.FBOX_LANSYSMSG_4;    exit;}//debugecho '[FAILED] '.FBOX_LANSYSMSG_3;exit;?>