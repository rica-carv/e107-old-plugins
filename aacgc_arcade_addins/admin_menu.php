<?php

//-----------------------------------------------------------------------------------------------------------+
/*
#######################################
#     AACGC Arcade Addins V1.0        #
#     by M@CH!N3                      #
#     http://www.aacgc.com            #
#######################################
*/
//-----------------------------------------------------------------------------------------------------------+


$title .= "AACGC Arcade Addins Menu";



$text .= "<table class='fborder' style='width:100%'>";


if (e_PAGE == "admin_readme.php") 
{$text .= "<tr><td style='width:30%' class='button'><b><a style='cursor:hand; text-decoration:none' href='admin_readme.php'>>> Main <<</a></b></td></tr>";}
else
{$text .= "<tr><td style='width:30%' class='button'><a style='cursor:hand; text-decoration:none' href='admin_readme.php'>Main</a></td></tr>";}


$text .= "<tr><td style='width:30%' class='header'>-</b></td></tr>";


if (e_PAGE == "admin_config.php") 
{$text .= "<tr><td style='width:30%' class='button'><b><a style='cursor:hand; text-decoration:none' href='admin_config.php'>>> Settings <<</a></b></td></tr>";}
else
{$text .= "<tr><td style='width:30%' class='button'><a style='cursor:hand; text-decoration:none' href='admin_config.php'>Settings</a></td></tr>";}


$text .= "<tr><td style='width:30%' class='header'>-</b></td></tr>";


if (e_PAGE == "admin_vupdate.php") 
{$text .= "<tr><td style='width:30%' class='button'><b><a style='cursor:hand; text-decoration:none' href='admin_vupdate.php'>>> Check For Updates  <<</a></b></td></tr>";}
else
{$text .= "<tr><td style='width:30%' class='button'><a style='cursor:hand; text-decoration:none' href='admin_vupdate.php'>Check For Updates</a></td></tr>";}


//--------------------------------------------------------------------------------------------


$text .= "<tr><td><br><br><br><br><br><br>
<center>
Donate To AACGC.
<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>
<input type='hidden' name='cmd' value='_s-xclick'>
<input type='hidden' name='hosted_button_id' value='6506985'>
<input type='image' src='https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif' border='0' name='submit' alt='PayPal - The safer, easier way to pay online!'>
<img alt='' border='0' src='https://www.paypal.com/en_US/i/scr/pixel.gif' width='1' height='1'>
</form>
<br><br>
</td></tr>";

$text .= "<tr>
           <td style='width:30%' class='button'>
           <b><a style='cursor:hand; text-decoration:none' href='http://www.aacgc.com/SSGC/e107_plugins/faq/faq.php' target='_blank'>AACGC FAQs</a></b>
           </td>
           </tr>";


$text .= "<tr><td style='width:30%' class='header'>-</b></td></tr>";


$text .= "<tr>
           <td style='width:30%' class='button'>
           <b><a style='cursor:hand; text-decoration:none' href='http://www.aacgc.com/SSGC/e107_plugins/helpdesk3_menu/helpdesk.php' target='_blank'>AACGC HelpDesk</a></b>
           </td>
           </tr>";

//-----------------------------------------------------------------------------------------------------


$text .= "</table>";

$ns -> tablerender($title, $text);


//-----------------------------------------------------------------------------------------------------------+

         



?>
