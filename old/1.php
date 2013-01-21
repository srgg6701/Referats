<?php
require('../connect_db.php');
require('lib.php');
//ежесуточная генерация и отсылка CSV-отчета
$letter=make_works_list();
echo($letter);
mail($admin_mail, "work.csv", $letter, "From: $admin_mail".chr(13).chr(10).'Reply-To: '.$admin_mail.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251');
/*
$rt_r=mysql_query("SELECT * FROM ri_rights");
$rt_n=mysql_num_rows($rt_r);
for($i=0;$i<$rt_n;$i++)
{
  $user=mysql_result($rt_r,$i,'user');
  $page=mysql_result($rt_r,$i,'page');
  $right=mysql_result($rt_r,$i,'right');
  mysql_query("DELETE FROM ri_rights WHERE user=$user AND page='$page' AND `right`='$right'");
  mysql_query("INSERT INTO ri_rights ( user, page, `right` ) VALUES ( $user, '$page', '$right' )");
}

echo("<table border=1>");
$ddm_r=mysql_query("SELECT * FROM diplom_del_maker");
$ddm_n=mysql_num_rows($ddm_r);
for($i=0;$i<$ddm_n;$i++)
{
  $email=mysql_result($ddm_r,$i,'email');
  $login=mysql_result($ddm_r,$i,'login');
  $fio=mysql_result($ddm_r,$i,'family').' '.mysql_result($ddm_r,$i,'name').' '.mysql_result($ddm_r,$i,'otch');
  echo("<tr><td>$login</td><td>$email</td><td>$fio</td></tr>");
}
echo("</table>");
*/

?>