<?php
$admin_mail='info@referats.info';

//?·??A???AI A??A?? ?AµA A°±?A
function make_works_list()
{
  $ts='';
  $wk_r=mysql_query("SELECT  * FROM ri_works, ri_typework, diplom_predmet WHERE ri_works.tip=ri_typework.number AND ri_works.predmet=diplom_predmet.number ORDER BY ri_works.tip, ri_works.predmet");
  $wk_n=mysql_num_rows($wk_r);
  for($i=0;$i<$wk_n;$i++)
  {
    $tip=mysql_result($wk_r,$i,'ri_typework.tip');
    $predmet=mysql_result($wk_r,$i,'diplom_predmet.predmet');
    $name=mysql_result($wk_r,$i,'ri_works.name');
	$ts=$ts."$tip;$predmet;$name<br>".chr(13).chr(10);
  }
  return($ts);
}

function myconvert_text($tfl)
{
  //?A??µA?AI ?µ I?»IµAAI »? utf8
  $cnt=strlen($tfl);
  $u8fl=1;
  for($i=1;$i<$cnt;$i++)
  {
    $r=ord($tfl[$i]) & 192;
	if($r!=128){$u8fl=0;}
  }
  if($u8fl==1)
  {
    $tfl=utf8_decode($tfl);
  }
  else
  {
    $tfl=rawurldecode($tfl);
    //??Aµ?µ»?AI ????A???A
    $cnt=strlen($tfl);
    $big=0;
    $lit=0;
    for($i=0;$i<$cnt;$i++)
    {
      if(ord($tfl[$i])>127)
	  {
        if(ord($tfl[$i])>223){$big++;}else{$lit++;}
	  }
    }
    if($lit>$big)
	{$tfl=convert_cyr_string(rawurldecode($tfl), k, w);}
  }
  return($tfl);
}

function rustime($t)
{
  $r=$t[8].$t[9].'.'.$t[5].$t[6].'.'.$t[0].$t[1].$t[2].$t[3];
  return($r);
}

function engtime($t)
{
  $r=$t[6].$t[7].$t[8].$t[9].'-'.$t[3].$t[4].'-'.$t[0].$t[1];
  return($r);
}

function statistic($num_user, $page, $ref)
{
  if(!strstr($fromlocation,'referats.info'))
  {
    $num_user=$num_user+1-1;
    $page=$_SERVER['PHP_SELF'];
    //$ref =$HTTP_REFERER;
    //echo("ref=$ref<br>");
    mysql_query("INSERT INTO ri_hostin ( data, time, page, IP, user, fromhost ) VALUES ( '".date('Y-m-d')."', '".date('H:i:s')."', '".$page."', '".getenv("REMOTE_ADDR")."', $num_user, '$ref' )");
  }
}

function uppercase($ts)
{
  $ts=strtoupper($ts);
  $c=strlen($ts);
  for($i=0;$i<$c;$i++)
  {
    if(ord($ts[$i])>=224)
    {
	  $ts[$i]=chr(ord($ts[$i])-32);
	}
  }
  return($ts);
}

function f1t2($i)
{
  $ts=$i;
  if($i<10){$ts='0'.$ts;}
  return($ts);
}

function week_day($n)
{
  if($n==1){$d='Понедельник';}
  if($n==2){$d='Вторник';}
  if($n==3){$d='Среда';}
  if($n==4){$d='Четверг';}
  if($n==5){$d='Пятница';}
  if($n==6){$d='Суббота';}
  if($n==0){$d='Воскресенье';}
  return($d);
}

function rus_month($m)
{
  if($m==1){$t='Январь';}
  if($m==2){$t='Февраль';}
  if($m==3){$t='Март';}
  if($m==4){$t='Апрель';}
  if($m==5){$t='Май';}
  if($m==6){$t='Июнь';}
  if($m==7){$t='Июль';}
  if($m==8){$t='Август';}
  if($m==9){$t='Сентябрь';}
  if($m==10){$t='Октябрь';}
  if($m==11){$t='Ноябрь';}
  if($m==12){$t='Декабрь';}
  return($t);
}

function send_intro_mess($from, $to, $email, $subj, $mess, $zakaz)
{
  $dt=date('Y-m-d');
  $tt=date('H:i:s');
  $admin_mail='admin@referats.info';//?±EI??AI ?»?±°»I???
  mysql_query("INSERT INTO ri_mess ( data, timer, zakaz, from_user, to_user, email, subj, mess, status, direct ) VALUES ( '$dt', '$tt', $zakaz, $from, $to, '$email', '$subj', '".rawurlencode($mess)."', 0, '0' )");
  $mess_id=mysql_insert_id();
  mysql_query("INSERT INTO ri_mess ( data, timer, zakaz, from_user, to_user, email, subj, mess, status, direct ) VALUES ( '$dt', '$tt', $zakaz, $from, $to, '$email', '$subj', '".rawurlencode($mess)."', 0, '1' )");
  $private_mess="<hr><a href='http://referats.info/autorization.php?login=admin@referats.info&pass=historically&go_next=/admin/view_mess.php?mnum=$mess_id%26status=0' target=_blank>Перейти к сообщению на сервере</a>";
  if(mysql_error()!=''){echo("err=".mysql_error()."<br>");}
  if($to==1)
  {
    //?E»? °????A
	$ts='('.$zakaz.';'.$from.';'.$email.') '.$subj;
	inmail($admin_mail,$ts,$mess.$private_mess,"From: $admin_mail".chr(13).chr(10).'Reply-To: '.$email.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251','SIM00');
  }
  if($to==0)
  {
    //?E»? ·°?°·C??A
		mail($email,$subj,"Пожалуйста, <span style='color:red; font-weight:bolder'>не отвечайте на это письмо</span>, оно отправлено вам автоматической службой сайта referats.info. Если вы хотите отправить ответное сообщение - зайдите в ваш эккаунт на сайте по этой <a href='http://referats.info/autors.php?login=$email&pass=".($zakaz*12345)."'>ссылке</a> или по адреcу http://referats.info/autors.php<br>Ваш логин: $email<br>Пароль: ".($zakaz*12345)."<hr>$mess","From: $admin_mail".chr(13).chr(10)."Reply-To: no_reply".chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251');
  }
  if($to>1)
  {
    //?E»? °?A?AA
	$us_r=mysql_query("SELECT * FROM ri_user WHERE number=$to");
	$uemail=mysql_result($us_r,0,'login');
	$upass=mysql_result($us_r,0,'pass');
	mail($uemail,$subj,"Пожалуйста, <span style='color:red; font-weight:bolder'>не отвечайте на это письмо</span>, оно отправлено вам автоматической службой сайта referats.info. Если вы хотите отправить ответное сообщение - зайдите в ваш эккаунт на сайте по этой <a href='http://referats.info/autors.php?login=$uemail&pass=$upass' target='_blank'>ссылке</a> или по адреcу http://referats.info/autors.php<br>Ваш логин: $uemail<br>Пароль: $upass<hr>$mess","From: $admin_mail".chr(13).chr(10)."Reply-To: no_reply".chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251');

  }
}

//aSaaGOUOIOO aOUaOIOG ?G?OaOU aGNSa IG SaISOGIOO ?G?aSaG
//?G?aSa ?aOOOGaOaOUiIS USOOa aOUiaaSOGaiai
//aG? O aaaUO IGOS ScOeGai ri_rating
function make_find($quest, $where)
{
  $sid=session_id();
  mysql_query("DELETE FROM ri_rating WHERE sessionid='$sid'");
  
  $wkeywords = explode(' ', strtolower($quest));
  for($i=0;$i<count($wkeywords);$i++)
  {
    $where=$where." AND name LIKE '%$wkeywords[$i]%'";
  }
  
  $wk_r=mysql_query("SELECT * FROM ri_works $where");
  $wk_n=mysql_num_rows($wk_r);
  for($i=0;$i<$wk_n;$i++)
  {
    $wnum=mysql_result($wk_r,$i,'number');
    $wname=mysql_result($wk_r,$i,'name');
    $wannot=mysql_result($wk_r,$i,'annot');
    $wpredmet=mysql_result($wk_r,$i,'predmet');
    $wtip=mysql_result($wk_r,$i,'tip');
    $wkeywords=mysql_result($wk_r,$i,'name');
	//$wkeywords=$wkeywords.' '.rawurldecode(mysql_result($wk_r,$i,'annot'));
	//$wkeywords=chaos2stand($wkeywords);
	/*
	$wkeywords=strtolower($wkeywords);
	//$quest=chaos2stand($quest);
	$quest=strtolower($quest);
	$wordindex=calc_wi($quest,$wkeywords);
	//echo("$wordindex=calc_wi('$quest','$wkeywords');<hr>");
	if($wordindex>=0)
	{
	  mysql_query("INSERT INTO ri_rating ( sessionid, work, title, wordindex ) VALUES ( '$sid', $wnum, '$wname', $wordindex )");
	}
	*/
    mysql_query("INSERT INTO ri_rating ( sessionid, work, title, wordindex ) VALUES ( '$sid', $wnum, '$wname', 1 )");
  }
}

function make_find_by_id($id)
{
  $sid=session_id();
  mysql_query("DELETE FROM ri_rating WHERE sessionid='$sid'");
  $wk_r=mysql_query("SELECT * FROM ri_works WHERE Number=$id");
  $wk_n=mysql_num_rows($wk_r);
  for($i=0;$i<$wk_n;$i++)
  {
    $wnum=mysql_result($wk_r,$i,'number');
    $wname=mysql_result($wk_r,$i,'name');
    mysql_query("INSERT INTO ri_rating ( sessionid, work, title, wordindex ) VALUES ( '$sid', $wnum, '$wname', 1 )");
	if(mysql_error()!=''){echo("err=".mysql_error()."<br>");}
  }
}

//?EC?A»IµA AAµ?µ?I A???°????AA? ??AA AAA??
//(·°?A?A° $q ? ?»ICµ? $k)
//??·?A°E°µA ±°»» A???°????AA?, ?A? ?µA???°????AA? -1
function calc_wi($q,$k)
{
  //$q1=uppercase($q);
  //$kl=uppercase($k);
  $qw=explode(' ',$q);$nq=count($qw);
  //$kw=explode(' ',$k);$nk=count($kw);
  $w=0;
  for($i=0;$i<$nq;$i++)
  {
    $eq=0;$ins=0;
    /*
	for($j=0;$j<$nk;$j++)
	{
	  if($qw[$i]==$kw[$j]){$eq=1;}
	  if(strstr($qw[$i],$kw[$j]) && strlen($kw[$j])>3){$ins=1;}
	  //if(strstr($q,$k)){echo("'$q' ; '$k'<br>'$qw[$i]' -&gt; '$kw[$j]'<br>ins='$ins'<hr>");}
	}
	if($eq!=1){if($ins==1){$w=$w+1;}}
	else
	{$w=$w+100;}
	*/
	//if(trim($k)!='' && trim($qw[$i])!='')
	//{
	  if(strstr($k,$qw[$i])){$w++;}
	//}
  }
  if($w==0){$w=-1;}
  return($w);
}

//?°»µ?I??? A?A??A ?Aµ?±A°·AIE?? AAA??A »I±??? ???° ? AA°??°AAA "A»??? A»??? A»???"
function chaos2stand($s)
{$n=strlen($s);
for($i=0;$i<$n;$i++)
{
  if(ord($s[$i])<65)
  {$s[$i]=' ';}
  else
  {if(ord($s[$i])>=224){$s[$i]=chr(ord($s[$i])-32);}}
}
$s=trim(chop($s));
return($s);}

//?µAµ??? ·°?°·° ?· ?°Aµ??A?? ? ?°Aµ??A?I
//$user_num - ?A? ?µAµ????A
//$zakaz - ???µA ·°?°·°
//$new_status - ???E? AA°AAA
//??·?A°E°µA Aµ·A»IA?AAIE?? ???µA AA°AAA°
//µA»? $new_status=0, A? ?·?µ?IµA AA°AAA °?A??°A?CµA??...
function zakaz_status_transmit($user_num, $zakaz, $new_status)
{
  //?µ»I·I ?µAµ????AI ?· ±?»IEµ?? ? ?µ?IE??
  $zk_r=mysql_query("SELECT * FROM ri_zakaz WHERE number=$zakaz");
  $zstatus=mysql_result($zk_r,0,'status');
  $zwork=mysql_result($zk_r,0,'work');
  $zemail=mysql_result($zk_r,0,'email');
  $zname=mysql_result($zk_r,0,'user');
  $old_status=$zstatus;
  if($new_status==0)
  {
	switch ($zstatus) {
    case 5:
        $zstatus=6;
        break;
    case 4:
        $zstatus=5;
        break;
    case 2:
        $zstatus=4;
        break;
    case 1:
        $zstatus=2;
        break;
    }
    mysql_query("UPDATE ri_zakaz SET status=$zstatus WHERE number=$zakaz");     
  }
  else
  {
    mysql_query("UPDATE ri_zakaz SET status=$new_status WHERE number=$zakaz");
	$zstatus=$new_status;
  }
 //?°?? ??±°??AI ????µEµ??µ ?A? ?·?µ?µ??IA AA°AAA°

 //- ??»°A?»?
 //- ?A?A°?»µ??
 //- ??»ACµ??µ ???A?µA¶?µ??
 //- ·AI?»°A° ??»ACµ?°
 if($old_status!=$zstatus)
 {
   //CA? ·° A°±?A° ? ?A? °?A?A?
   $wk_r=mysql_query("SELECT * FROM ri_works WHERE number=$zwork");
   $wmanager=mysql_result($wk_r,0,'manager');
   $wtax=mysql_result($wk_r,0,'tax');
   $us_r=mysql_query("SELECT * FROM ri_user WHERE number=$wmanager");
   $uemail=mysql_result($us_r,0,'login');
   $uname=mysql_result($us_r,0,'family').' '.mysql_result($us_r,0,'name').' '.mysql_result($us_r,0,'otch');
   switch ($zstatus) {
    case 6:
	    $subj="Гонорар по заказу Id $zakaz";
        $ts="Заказ Id_$zakaz выполнен, гонорар в размере $wtax рублей выплачен.<hr>С уважением, Администратор";//автору?
		$email=$uemail;
		mysql_query("UPDATE ri_zakaz SET DataClose='".date('Y-m-d')."' WHERE number=$zakaz");
        break;
    case 5:
	    $subj="Подтверждение по заказу Id $zakaz";
        $ts="Заказ Id_$zakaz заказчиком получен.<hr>С уважением, Администратор";//админу и автору
		$email=$uemail.";$admin_mail";
        break;
    case 4:
	    $subj="Заказ Id $zakaz выслан";
        $ts="Заказ Id_$zakaz выслан автором заказчику. требуется подтверждение заказчиком. Для подтверждения <a href=http:\\referats.info\autorization.php?pass=".($zakaz*12345)."&login=$zemail>зайдите в свой эккаунт</a> и подтвердите получение.<hr>С уважением, Администратор";//админу и заказчику
		$email=$zemail.";$admin_mail";
		//включить шедулинговую задачу, чтобы через 3-е суток выдать автоподтверждение
		mysql_query("INSERT INTO ri_sheduler ( data, kratnost, period, script, remark, enable ) VALUES ( '".date('Y-m-d')."', 0, 72, 'autoremember_zakaz($zakaz)', 'Автоподтверждение получения заказчиком работы', 'O' )");
        break;
    case 2:
	    $subj="Заказ Id $zakaz оплачен заказчиком";
        $ts="Заказ Id $zakaz оплачен заказчиком, высылайте работу на адрес <a hreh='mailto: $zemail'>$zemail</a>.<hr>С уважением, Администратор";//автору
        $email=$uemail;
		//надо удалить автоудаление просроченного!!!
		//надо удалить автонапоминание об оплате!!!
		mysql_query("DELETE FROM ri_shedulle WHERE script LIKE '%autoreminder_zakaz_pay($zakaz%'");
		mysql_query("DELETE FROM ri_shedule WHERE script='autodelete_zakaz($zakaz)'");
		break;
    }
	inmail($email,$subj,$ts,"From: $admin_mail".chr(13).chr(10).'Reply-To: '.$email.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251','ZST00');
 }
 return($zstatus);
}

//·°?????AI ???A??AA°??I °?????AAA°A?A°
function write_conf($fnime)
{
global $S_NUM_USER, $S_MASTER_STEP, $S_SOURCE_ACC_TIP, $S_SOURCE_ACC, $S_DEST_ACC_TIP, $S_DEST_ACC, $S_TRANZACT_SUMM, $S_LAST_ZAKAZ, $S_F_KASSA, $S_F_MESS, $S_F_WL_TIP, $S_F_WL_PR, $S_F_WL_USER, $S_PAGE, $S_PAGE1, $S_PAGE2, $S_PAGE4, $S_PAGE5, $S_PAGE6, $S_F_US_TIP, $S_F_US_PR, $S_F_US_UCH, $S_SEL_ACC_TIP, $S_SEL_ACC;

if($S_NUM_USER==1)
{
$fp=fopen($fnime,'w');
fputs($fp,'<?php'.chr(13).chr(10));
fputs($fp,'$S_MASTER_STEP="'.$S_MASTER_STEP.'";'.chr(13).chr(10));
fputs($fp,'$S_SOURCE_ACC_TIP="'.$S_SOURCE_ACC_TIP.'";'.chr(13).chr(10));
fputs($fp,'$S_SOURCE_ACC="'.$S_SOURCE_ACC.'";'.chr(13).chr(10));
fputs($fp,'$S_DEST_ACC_TIP="'.$S_DEST_ACC_TIP.'";'.chr(13).chr(10));
fputs($fp,'$S_DEST_ACC="'.$S_DEST_ACC.'";'.chr(13).chr(10));
fputs($fp,'$S_TRANZACT_SUMM="'.$S_TRANZACT_SUMM.'";'.chr(13).chr(10));
fputs($fp,'$S_LAST_ZAKAZ="'.$S_LAST_ZAKAZ.'";'.chr(13).chr(10));
fputs($fp,'$S_F_KASSA="'.$S_F_KASSA.'";'.chr(13).chr(10));
fputs($fp,'$S_F_KASSA="'.$S_F_KASSA.'";'.chr(13).chr(10));
fputs($fp,'$S_F_MESS="'.$S_F_MESS.'";'.chr(13).chr(10));
fputs($fp,'$S_F_WL_TIP="'.$S_F_WL_TIP.'";'.chr(13).chr(10));
fputs($fp,'$S_F_WL_PR="'.$S_F_WL_PR.'";'.chr(13).chr(10));
fputs($fp,'$S_F_WL_USER="'.$S_F_WL_USER.'";'.chr(13).chr(10));
fputs($fp,'$S_NUM_USER="'.$S_NUM_USER.'";'.chr(13).chr(10));
fputs($fp,'$S_PAGE="'.$S_PAGE.'";'.chr(13).chr(10));
fputs($fp,'$S_PAGE1="'.$S_PAGE1.'";'.chr(13).chr(10));
fputs($fp,'$S_PAGE2="'.$S_PAGE2.'";'.chr(13).chr(10));
fputs($fp,'$S_PAGE4="'.$S_PAGE4.'";'.chr(13).chr(10));
fputs($fp,'$S_PAGE5="'.$S_PAGE5.'";'.chr(13).chr(10));
fputs($fp,'$S_PAGE6="'.$S_PAGE6.'";'.chr(13).chr(10));
fputs($fp,'$S_F_US_TIP="'.$S_F_US_TIP.'";'.chr(13).chr(10));
fputs($fp,'$S_F_US_PR="'.$S_F_US_PR.'";'.chr(13).chr(10));
fputs($fp,'$S_F_US_UCH="'.$S_F_US_UCH.'";'.chr(13).chr(10));
fputs($fp,'$S_SEL_ACC_TIP="'.$S_SEL_ACC_TIP.'";'.chr(13).chr(10));
fputs($fp,'$S_SEL_ACC="'.$S_SEL_ACC.'";'.chr(13).chr(10));
fputs($fp,'?>'.chr(13).chr(10));
//echo("fp='$fp'<br>".'$S_F_WL_TIP="'.$S_F_WL_TIP.'";<br>'.'$S_F_WL_PR="'.$S_F_WL_PR.'";<br>');
fclose($fp);
}
}

//?A????I ?A?A°??? ??CAE. ?°?A?CµA?? IA? mail A ?±?µA???. c?AI?? ·°??A?AAI ? ¶AA?°» - A°±»??° diplom_mail. aA??µ A???, ?A??»??Aµ»I ??¶µA ·°±»???A??°AI ??Aµ?µ»µ??Eµ A??E A??±Eµ???, IA° ????I AA°??AAI ? diplom_maker.property00.
function inmail($email,$subj,$letter,$from,$tip)
{
  $r=mail($email,$subj,$letter,$from);
  $datatime=date('d.m.Y H:i');
  $ll=strlen($letter);
  if($ll>5000){$letter=substr($letter,0,5000).'<!-- Обрезано, реальная длина=$ll-->';}
  $letter=rawurlencode($letter);
  if($r)
  {
    mysql_query("INSERT INTO ri_mail ( email, mail, tip ) VALUES ( '$email', '$datatime   mail($email,$subj,$letter,$from);', 'OUT' )");
    if(trim(mysql_error())!=''){echo("err=".mysql_error()."<br>");}
  }
  else
  {
    //·°???A?µ?A?A??°AI A°?A ?E?±??
    mysql_query("INSERT INTO ri_mail ( email, mail, tip ) VALUES ( '$email', '!ОШИБКА! ДАННОЕ ПИСЬМО НЕ БЫЛО ОТПРАВЛЕНО ;( !!<br>$datatime<br>mail($email,$subj,$letter,$from);', 'ERR' )");
  }
  return($r);
}

function min_tax($tax)//A°ACµA ?????°»I?? ???AAA???? ?µ?E A°±?AE
{
  //if($tax/4<50){$tax=$tax+50;}else{$tax=round($tax*1.25);}
  return($tax);
}

function HalyvaPercent($unum)
{
  $pp=0;
  $wk_r=mysql_query("SELECT * FROM ri_works WHERE ri_works.manager=$unum");
  $wk_n=mysql_num_rows($wk_r);
  if(mysql_error()!=''){echo("err=".mysql_error());}
  
  if($wk_n>1000){$n=45;$pp=10;}
  if($wk_n<=1000){$n=30;$pp=13;}
  if($wk_n<=500){$n=21;$pp=15;}
  if($wk_n<=200){$n=14;$pp=18;}
  if($wk_n<50){$n=0;$pp=25;}
  
  $hl[1]=$pp;
  $hl[0]=0;
  $wk_r=mysql_query("SELECT * FROM ri_works, ri_zakaz WHERE ri_works.manager=$unum AND ri_works.number=ri_zakaz.work AND ri_zakaz.status=6 ORDER BY ri_zakaz.DataClose");
  $wk_n=mysql_num_rows($wk_r);
  if($wk_n>0)
  {
    $znum=mysql_result($wk_r,0,'ri_zakaz.number');
    $dst=mysql_result($wk_r,0,'ri_zakaz.DataClose');
    $days=mktime(0,0,0, $dst[5].$dst[6], $dst[8].$dst[9], $dst[0].$dst[1].$dst[2].$dst[3]);
    $today=mktime(0,0,0, date("m"), date("d"), date("Y"));
    if(($today-$days)/86400>$n){$hl[0]=1;}
  }
  return($hl);
}
?>