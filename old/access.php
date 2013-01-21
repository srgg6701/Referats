<?php
function access($num_user,$name_resource)
{
  $rg_r=mysql_query("SELECT * FROM ri_rights WHERE user=$num_user AND page='$name_resource'");
  if($rg_r)
  {
    $rg_n=mysql_num_rows($rg_r);
    $acs=false;
    if($rg_n>0)
    {
      $flag=mysql_result($rg_r,0,'right');
	  if($flag=='Y'){$acs=true;}
    }
  }
  else
  {header("location: enter.php");}
  return($acs);
}
?>