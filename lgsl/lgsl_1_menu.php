<?php

  global $lgsl_config;

  $lgsl_zone_number = 1;

  $output = "";

  require e_PLUGIN."lgsl/lgsl_files/lgsl_zone.php";

  $ns -> tablerender($lgsl_config['title'][$lgsl_zone_number], $output);

  $output = "";

?>
