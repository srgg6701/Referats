<?php
//i?iaanoe i?iaiaeo
function tranzaction_money($source_acc, $dest_acc, $summ, $rem)
{
  //nieiaai noiio n e?aaeoiiai n?aoa
  $ac_r=mysql_query("SELECT * FROM ri_acc_acc WHERE number=$source_acc");
  $kred=mysql_result($ac_r,0,'kred')+$summ;
  mysql_query("UPDATE ri_acc_acc SET kred='$kred' WHERE number=$source_acc");
  //eeaaai noiio ia aaaaoiaue n?ao
  $ac_r=mysql_query("SELECT * FROM ri_acc_acc WHERE number=$dest_acc");
  $deb=mysql_result($ac_r,0,'deb')+$summ;
  mysql_query("UPDATE ri_acc_acc SET deb='$deb' WHERE number=$dest_acc");
  
  //iioeeneou iia?aoe? a ?o?iaea i?iaiaie
  mysql_query("INSERT INTO ri_acc_jornal ( a_fr, a_to, summ, remark, autoremark ) VALUES ( $source_acc, $dest_acc, '$summ', '$rem', 'I?inoay i?iaiaea' )");
}

//nicaaou eeoaaie n?ao aey ?ca?a, aica?auaao iiia? nicaaiiiai n?aoa
function create_user_account($unum)
{
  $us_r=mysql_query("SELECT * FROM ri_user WHERE number=$unum");
  $name=mysql_result($us_r,0,'login').' ('.mysql_result($us_r,0,'family').' '.mysql_result($us_r,0,'name').' '.mysql_result($us_r,0,'otch').')';
  mysql_query("INSERT INTO ri_acc_acc ( name, tip, deb, kred, remark ) VALUES ( 'user=$unum', 1, '0', '0', '$name' )");
  $acnum=mysql_insert_id();
  return($acnum);
}

//iieo?eou ia?aiao?u eeoaaiai n?aoa ?ca?a
function get_user_account($unum)
{
  $ac_r=mysql_query("SELECT * FROM ri_acc_acc WHERE name='user=$unum' AND tip=1");
  $ac_n=mysql_num_rows($ac_r);
  if($ac_n>0)
  {
    $ret[1]=mysql_result($ac_r,0,'number');
    $ret[2]=mysql_result($ac_r,0,'deb');
    $ret[3]=mysql_result($ac_r,0,'kred');
    $ret[4]=mysql_result($ac_r,0,'remark');
  }
  else
  {
    //nicaaou n?ao e aa?ioou ioeaaua ia?aiao?u
	$ret[1]=create_user_account($unum);
	$ret[2]='0';
	$ret[3]='0';
	$ret[4]='';
  }
  return($ret);
}

//eciaieou ia?aiao?u eeoaaiai n?aoa ?ca?a, aica?auaao ioeaeo
function set_user_account($unum, $deb, $kred, $rem)
{
  $sql_com="UPDATE ri_acc_acc SET ";
  if(isset($deb)){$sql_com=$sql_com."deb='$deb', ";}
  if(isset($kred)){$sql_com=$sql_com."kred='$kred', ";}
  if(isset($rem)){$sql_com=$sql_com."remark='$rem',";}
  $n=strlen($sql_com);
  $sql_com[$n-1]=' ';
  $sql_com=$sql_com." WHERE name='user=$unum'";
  mysql_query($sql_com);
  $err=mysql_error();
  return($err);
}

//oaaeeou eeoaaie n?ao ?ca?a, aica?auaao ioeaeo
function del_user_account($unum)
{
  mysql_query("DELETE FROM ri_acc_acc WHERE name='user=$unum'");
  $err=mysql_error();
  return($err);
}
?>