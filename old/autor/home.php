<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');
if(access($S_NUM_USER, 'main')){//начало разрешения работы со страницей

$us_r=mysql_query("SELECT * FROM ri_user WHERE number=$S_NUM_USER");
$login=mysql_result($us_r,0,'login');
$name=mysql_result($us_r,0,'family');
$howmach=mysql_result($us_r,0,'howmach');

$ms_r=mysql_query("SELECT * FROM ri_mess WHERE status=0 AND to_user=$S_NUM_USER AND direct=1");
$ms_new=mysql_num_rows($ms_r);//исходящие непрочитанные
$ms_r=mysql_query("SELECT * FROM ri_mess WHERE status=1 AND to_user=$S_NUM_USER AND direct=1");
$ms_not=mysql_num_rows($ms_r);

$zk_r=mysql_query("SELECT * FROM ri_zakaz,ri_works WHERE ri_works.manager=$S_NUM_USER AND ri_zakaz.work=ri_works.number AND ri_zakaz.status=1");
$zk_new=mysql_num_rows($zk_r);
$zk_r=mysql_query("SELECT * FROM ri_zakaz,ri_works WHERE ri_works.manager=$S_NUM_USER AND ri_zakaz.work=ri_works.number AND ri_zakaz.status=2");
$zk_opl=mysql_num_rows($zk_r);
$zk_r=mysql_query("SELECT * FROM ri_zakaz,ri_works WHERE ri_works.manager=$S_NUM_USER AND ri_zakaz.work=ri_works.number AND ri_zakaz.status=4");
$zk_post=mysql_num_rows($zk_r);
$zk_r=mysql_query("SELECT * FROM ri_zakaz,ri_works WHERE ri_works.manager=$S_NUM_USER AND ri_zakaz.work=ri_works.number AND ri_zakaz.status=5");
$zk_gets=mysql_num_rows($zk_r);
$zk_r=mysql_query("SELECT * FROM ri_zakaz,ri_works WHERE ri_works.manager=$S_NUM_USER AND ri_zakaz.work=ri_works.number AND ri_zakaz.status=6");
$zk_closed=mysql_num_rows($zk_r);
$ks_r=mysql_query("SELECT * FROM ri_kassa, ri_zakaz WHERE ri_kassa.zakaz=ri_zakaz.number AND ri_zakaz.status=6 AND ri_kassa.person=$S_NUM_USER");
$ks_n=mysql_num_rows($ks_r);
$summ_pay=0;
for($i=0;$i<$ks_n;$i++)
{
  $summ_pay=$summ_pay+mysql_result($ks_r,$i,'summ');
}

$wk_r=mysql_query("SELECT * FROM ri_works WHERE manager=$S_NUM_USER");
$wk_all=mysql_num_rows($wk_r);
$wk_r=mysql_query("SELECT * FROM ri_works WHERE manager=$S_NUM_USER AND enable='Y'");
$wk_utv=mysql_num_rows($wk_r);
$wk_not=$wk_all-$wk_utv;
?>
<html>
<head>
<TITLE>Home</TITLE>
<meta name="description" content="Дипломы, курсовые работы и рефераты на заказ">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="autor.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript" src="lime_div.js">
</script>
<script language="JavaScript" type="text/JavaScript">
worxType=0;
colorizePoint('home');
</script>
<style type="text/css">
<!--
.stat {
	padding: 4px;
	/*padding: 4px;*/
}
-->
</style>
</head>
<body><? require ("../../temp_transparency_author.php");?>
<a name="top"></a>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td nowrap><h3  class="dLime"><strong>Home</strong> (...sweet Home! :)))&nbsp;&nbsp;</h3></td>
    <td width="100%">...или, говоря по-русски &#8212; домашняя (т.е. &#8212; стартовая)
      страница.</td>
  </tr>
</table>
<hr size="1" noshade>
<table cellspacing="0" cellpadding="0">
  <tr>
    <td><table cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top" bgcolor="#00FF00"><img src="../../images/corners/green_left_top.gif" width="9" height="9" style="background-color:#FFFFFF"></td>
        <td rowspan="2" bgcolor="#00FF00"><nobr>
          <h3 class="stat"><span style="font-weight:200; color:#990000">&sect;</span> Работы </h3>
          </nobr>
            <table width="100%"  border="0" cellpadding="1" cellspacing="0" bgcolor="#CEFFC4">
              <tr>
                <td nowrap title="Общее количество готовых работ, которое вы указали при регистрации." style="cursor:default">&nbsp;Потенциальных</td>
                <td align="right"><?php echo($howmach);?></td>
              </tr>
              <tr>
                <td nowrap>&nbsp;<a href="worx.php?see_what=all" target="mainFrame" title="Работы, заявленные вами на размещение в нашем каталоге.">Выставленых</a></td>
                <td align="right"><?php echo($wk_all);?></td>
              </tr>
              <tr>
                <td valign="bottom" nowrap>&nbsp;в том числе:</td>
                <td nowrap>&nbsp;</td>
              </tr>
              <tr>
                <td nowrap>&nbsp;<a href="worx.php?see_what=not" target="mainFrame" title="Работы, находящиеся на рассмотрении администратора проекта.">Неутверждённые</a></td>
                <td align="right"><?php echo($wk_not);?></td>
              </tr>
              <tr>
                <td nowrap>&nbsp;<a href="worx.php?see_what=yes" target="mainFrame" title="Работы, утверждённые администратором и выставленные на продажу.">Утверждённых</a></td>
                <td align="right"><?php echo($wk_utv);?></td>
              </tr>
          </table></td>
        <td valign="top" bgcolor="#00FF00"><img src="../../images/corners/green_right_top.gif" width="9" height="9" style="background-color:#FFFFFF"></td>
        <td rowspan="7"><img src="../../images/spacer.gif" width="2" height="9"></td>
        <td valign="top" bgcolor="#99FFCC"><img src="../../images/corners/lblue_left_top.gif" width="9" height="9" style="background-color:#FFFFFF"></td>
        <td rowspan="2" bgcolor="#99FFCC"><nobr>
          <h3 class="stat"><span style="font-weight:900; color:#FF0000">&radic;</span> Заказы</h3>
          </nobr>
            <table width="100%"  border="0" cellpadding="1" cellspacing="0" bgcolor="#D5FFEA">
              <tr>
                <td nowrap>&nbsp;<a href="applications.php" target="mainFrame" title="Неоплаченные или оплаченные не полностью заявки клиентов на покупку ваших работ.">Заявки</a></td>
                <td align="right"><?php echo($zk_new);?></td>
              </tr>
              <tr>
                <td nowrap>&nbsp;<a href="applications.php" target="mainFrame" title="Полностью оплаченные заказчиками заявки на покупку ваших работ.">Заказы</a> </td>
                <td align="right"><?php echo($zk_opl);?></td>
              </tr>
              <tr>
                <td nowrap>&nbsp;<a href="applications_paid.php?where= AND ri_zakaz.status=4&title=Отправленые работы" target="mainFrame" title="Работы, отправленные вами заказчикам.">Отправленные</a></td>
                <td align="right"><?php echo($zk_post);?></td>
              </tr>
              <tr>
                <td nowrap>&nbsp;<a href="applications_paid.php?where= AND ri_zakaz.status=5&title=Задолженности" target="mainFrame" title="Работы, получение которых, подтверждено заказчиками">Полученные</a></td>
                <td align="right"><?php echo($zk_gets);?></td>
              </tr>
              <tr>
                <td nowrap>&nbsp;<a href="applications_paid.php?where= AND ri_zakaz.status=6&title=Закрытые заказы" target="mainFrame" title="Работы, за которые, выплачен гонорар">Закрытые</a></td>
                <td align="right"><?php echo($zk_closed);?></td>
              </tr>
          </table></td>
        <td valign="top" bgcolor="#99FFCC"><img src="../../images/corners/lblue_right_top.gif" width="9" height="9" style="background-color:#FFFFFF "></td>
      </tr>
      <tr>
        <td bgcolor="#00FF00">&nbsp;</td>
        <td bgcolor="#00FF00">&nbsp;</td>
        <td bgcolor="#99FFCC">&nbsp;</td>
        <td bgcolor="#99FFCC">&nbsp;</td>
      </tr>
      <tr>
        <td><img src="../../images/corners/green_left_bottom.gif" width="9" height="9"></td>
        <td bgcolor="#00FF00"><img src="../../images/spacer.gif" width="9" height="9"></td>
        <td><img src="../../images/corners/green_right_bottom.gif" width="9" height="9"></td>
        <td><img src="../../images/corners/lblue_left_bottom.gif" width="9" height="9"></td>
        <td bgcolor="#99FFCC"><img src="../../images/spacer.gif" width="9" height="9"></td>
        <td><img src="../../images/corners/lblue_right_bottom.gif" width="9" height="9"></td>
      </tr>
      <tr>
        <td colspan="3"><img src="../../images/spacer.gif" width="9" height="2"></td>
        <td colspan="3"><img src="../../images/spacer.gif" width="9" height="2"></td>
      </tr>
      <tr>
        <td valign="top" bgcolor="#33CCFF"><img src="../../images/corners/blue_left_top.gif" width="9" height="9" style="background-color:#FFFFFF "></td>
        <td rowspan="2" bgcolor="#33CCFF"><nobr>
          <h3 class="stat"><font color="#0000FF">@</font> Сообщения</h3>
          </nobr>
            <table width="100%"  border="0" cellpadding="1" cellspacing="0" bgcolor="#C6E7FF">
              <tr>
                <td nowrap>&nbsp;<a href="my_messages.php" target="mainFrame" title="Непросмотренные вами сообщения.">Новые</a></td>
                <td align="right"><?php echo($ms_new);?></td>
              </tr>
              <tr>
                <td nowrap>&nbsp;<a href="my_messages.php" target="mainFrame" title="Все сообщения, на которые вы пока не ответили.">Неотвеченные</a></td>
                <td align="right"><?php echo($ms_not);?></td>
              </tr>
              <tr>
                <td nowrap>&nbsp;</td>
                <td align="right">&nbsp;</td>
              </tr>
              <tr>
                <td nowrap>&nbsp;</td>
                <td align="right">&nbsp;</td>
              </tr>
              <tr>
                <td nowrap>&nbsp;</td>
                <td align="right">&nbsp;</td>
              </tr>
          </table></td>
        <td valign="top" bgcolor="#33CCFF"><img src="../../images/corners/blue_right_top.gif" width="9" height="9" style="background-color:#FFFFFF"></td>
        <td valign="top" bgcolor="#FFCC00"><img src="../../images/corners/orange_left_top.gif" width="9" height="9" style="background-color:#FFFFFF"></td>
        <td rowspan="2" bgcolor="#FFCC00"><nobr>
          <h3 class="stat"><font color="#00CC00">&#8240;</font> Статистика</h3>
          </nobr>
            <table width="100%"  border="0" cellpadding="1" cellspacing="0" bgcolor="#FFFAB7">
              <tr>
                <td nowrap>&nbsp;<a href="applications_paid.php?where= AND ri_zakaz.status=6&title=Закрытые заказы" title="Список всех проданных вами работ.">Продано
                    работ всего</a> </td>
                <td align="right"><?php echo($zk_closed);?></td>
              </tr>
              <tr>
                <td nowrap>&nbsp;На сумму </td>
                <td align="right"><?php echo($summ_pay);?></td>
              </tr>
              <tr>
                <td nowrap>&nbsp;<a href="applications_paid.php?where= AND ri_zakaz.status=5&title=Задолженности" target="mainFrame" title="Список работ, за которые мы с вами расчитались не полностью.">Задолженности</a> </td>
                <td align="right">&nbsp;</td>
              </tr>
              <tr>
                <td nowrap style="cursor:default" title="Количество дней до конца периода бесплатного обслуживания.">&nbsp;Б/П
                  обслуживание до </td>
                <td align="right"><strong>&nbsp;</strong></td>
              </tr>
              <tr>
                <td nowrap style="cursor:default" title="Количество дней до конца периода бесплатного обслуживания.">&nbsp;<a href="#">Претензии</a></td>
                <td align="right">&nbsp;</td>
              </tr>
          </table></td>
        <td valign="top" bgcolor="#FFCC00"><img src="../../images/corners/orange_right_top.gif" width="9" height="9" style="background-color:#FFFFFF"></td>
      </tr>
      <tr>
        <td bgcolor="#33CCFF">&nbsp;</td>
        <td bgcolor="#33CCFF">&nbsp;</td>
        <td bgcolor="#FFCC00">&nbsp;</td>
        <td bgcolor="#FFCC00">&nbsp;</td>
      </tr>
      <tr>
        <td><img src="../../images/corners/blue_left_bottom.gif" width="9" height="9"></td>
        <td bgcolor="#33CCFF"><img src="../../images/spacer.gif" width="9" height="9"></td>
        <td><img src="../../images/corners/blue_right_bottom.gif" width="9" height="9"></td>
        <td><img src="../../images/corners/orange_left_bottom.gif" width="9" height="9"></td>
        <td bgcolor="#FFCC00"><img src="../../images/spacer.gif" width="9" height="9"></td>
        <td><img src="../../images/corners/orange_right_bottom.gif" width="9" height="9"></td>
      </tr>
    </table></td>
    <td rowspan="2" valign="top" style="padding-left:20px"><table width="1%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="bottomPad6"><h4 style="padding:0px 0px 10px 0px; margin-bottom:0px"><strong>Таблица ваших выгод :))) </strong></h4>
          </td>
      </tr>
      <tr>
        <td><table width="1%" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC" class="solidGray">
          <tr>
            <td colspan="3" bgcolor="#FFFFFF"><p style="padding:6px 0px 6px 0px; margin:0px 0px 0px 0px"><span style="background-color:yellow">&nbsp;жёлтым фоном </span> &nbsp;выделены данные вашего текущего статуса</p></td>
            </tr>
          <tr>
		  <td width="78" bgcolor="#E4E4E4"><strong> Количество выставленных
                работ </strong></td>
            <td width="95" bgcolor="#E4E4E4"><strong style="cursor:default" title="Вычитается от заявленной вами стоимости работ.">Комиссия <nobr>от
                  продажи</nobr> (%%) </strong></td>
            <td width="164"><strong style="cursor:default" title="Период, в течение которого вся выручка от продажи ваших работ остаётся у вас.">Период
                бесплатного обслуживания</strong></td>
          </tr>
          <?php
		  $hl=HalyvaPercent($S_NUM_USER);
		  $komission=$hl[1];
		  //echo ('<script language="javascript">alert('.$komission.');</script>');
		  ?>
          <tr <?php if($komission==25){echo("bgcolor=#FFFF00");}else{echo("bgcolor=#FFFFFF");}?>>
            <td width="78" align="right"> до 50 </td>
            <td width="95" align="right"><?php //echo($komission);?> 25</td>
            <td width="164" align="right" <?php if($hl[0]==1){echo("bgcolor=#FFFFFF");}?>> нет </td>
          </tr>
          <tr <?php if($komission==18){echo("bgcolor=#FFFF00");}else{echo("bgcolor=#FFFFFF");}?>>
            <td width="78" align="right"> 51-200 </td>
            <td width="95" align="right"> 18 </td>
            <td width="164" align="right" <?php if($hl[0]==1){echo("bgcolor=#FFFFFF");}?>> 2 недели </td>
          </tr>
          <tr title="Ваш текущий статус" <?php if($komission==15){echo("bgcolor=#FFFF00");}else{echo("bgcolor=#FFFFFF");}?>>
            <td width="78" align="right"> 201-500 </td>
            <td width="95" align="right"> 15 </td>
            <td width="164" align="right" <?php if($hl[0]==1){echo("bgcolor=#FFFFFF");}?>> 1 месяц </td>
          </tr>
          <tr <?php if($komission==13){echo("bgcolor=#FFFF00");}else{echo("bgcolor=#FFFFFF");}?>>
            <td width="78" align="right"> 501-1000 </td>
            <td width="95" align="right"> 13</td>
            <td width="164" align="right" <?php if($hl[0]==1){echo("bgcolor=#FFFFFF");}?>> 2 месяца </td>
          </tr>
          <tr <?php if($komission==10){echo("bgcolor=#FFFF00");}else{echo("bgcolor=#FFFFFF");}?>>
            <td width="78" align="right">&gt;1000 </td>
            <td width="95" align="right"> 10 </td>
            <td width="164" align="right" <?php if($hl[0]==1){echo("bgcolor=#FFFFFF");}?>> 3 месяца </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><br>
          <table  cellspacing="0" cellpadding="0">
            <tr>
              <td valign="top" background="../../images/frames/left_orange.gif"><img src="../../images/frames/left_top_orange.gif" width="16" height="16"></td>
              <td rowspan="3"><table  cellspacing="0" cellpadding="0">
                  <tr>
                    <td style="height:1%" bgcolor="#FF9900"><img src="../../images/spacer.gif" width="2" height="2"></td>
                  </tr>
                  <tr>
                    <td style="padding:10px 0px 14px 0px"><h3 class="red" style="padding:0px; margin-bottom:4px">Внимание!</h3>
                      Вам выгодно разместить <strong>максимум ваших работ за минимально короткий срок</strong>. В этом случае вы сможете <a href="faq.php#short_time" target="_blank">продать больше</a> работ в течение своего <strong>периода бесплатного обслуживания</strong>! </td>
                  </tr>
                  <tr>
                    <td bgcolor="#FF9900"><img src="../../images/spacer.gif" width="2" height="2"></td>
                  </tr>
              </table></td>
              <td valign="top" background="../../images/frames/right_orange.gif"><img src="../../images/frames/right_top_orange.gif" width="16" height="16"></td>
            </tr>
            <tr>
              <td background="../../images/frames/left_orange.gif" style="height:98%">&nbsp;</td>
              <td background="../../images/frames/right_orange.gif">&nbsp;</td>
            </tr>
            <tr>
              <td valign="bottom" background="../../images/frames/left_orange.gif"><img src="../../images/frames/left_bottom_orange.gif" width="16" height="16"></td>
              <td valign="bottom" background="../../images/frames/right_orange.gif"><img src="../../images/frames/right_bottom_orange.gif" width="16" height="16"></td>
            </tr>
          </table></td>
      </tr>
    </table>      
      </td>
  </tr>
  <tr>
    <td valign="top"><!--<form name="defineHP" method="post">
  Переопределение домашней страницы:<br>
  <select name="selectHomePage">
    <option value="1" selected>Home</option>
    <option value="ed_works_ed.php?wnum=0&ret=worx.php">Добавить работу</option>
    <option value="worx.php">Выставленные работы</option>
    <option value="applications.php">Заявки заказчиков</option>
    <option value="applications_paid.php?where= AND ri_zakaz.status=4&title=Отправленные работы">Отправленные
    работы</option>
    <option value="applications_paid.php?where= AND ri_zakaz.status=5&title=Задолженности">Задолженности</option>
    <option value="applications_paid.php?where= AND ri_zakaz.status=6&title=Закрытые заказы">Закрытые
    заказы</option>
    <option value="my_messages.php">Сообщения</option>
    <option value="my_param.php">Регистрационные данные</option>
    <option value="help.php">Помощь</option>
    <option value="faq.php">FAQ</option>
    <option value="feedback.php">Контакты</option>
  </select>
  <input type="button" name="Button" value="     OK     " onClick="location.href=document.defineHP.selectHomePage.options[document.defineHP.selectHomePage.selectedIndex].value">
      </form>  --><form name="filter" action="worx.php" method="post" onSubmit="if (worxType==0) {alert ('Вы не указали, список каких работ вы хотите сформировать &#8212; всех, неутверждённых или утверждённых. Пожалуйста, отметьте нужный пункт!'); return false;}">
        <h4 class="bottomPad6" style="margin-top:10px; padding-top:10px">Показать мои работы:        </h4>
                  <div style="padding:4px; background-color:#B9FFB9"><input name="see_what" type="radio" value="all" onClick="worxType=1">
  Все
  <input name="see_what" type="radio" value="not" onClick="worxType=1">
  Неутверждённые
  <input name="see_what" type="radio" value="yes" onClick="worxType=1">
  Утверждённые
  </div><!--<nobr>
  <input type="checkbox" name="checkbox" value="checkbox" disabled>
  Запоминать настройки фильтра</nobr>  -->
  <table cellpadding="0" cellspacing="0">
    <tr valign="bottom">
      <td height="26" colspan="2" nowrap><h5 class="bottomPad6">Укажите предмет:</h5></td>
      </tr>
    <tr>
      <td colspan="2" valign="bottom" nowrap><select name="predmet">
        <option value="0">-Все-</option>
        <?php
$pr_r=mysql_query("SELECT * FROM diplom_predmet ORDER BY predmet");
$pr_n=mysql_num_rows($pr_r);
for($i=0;$i<$pr_n;$i++)
{
  $pnum=mysql_result($pr_r,$i,'number');
  $ppredmet=mysql_result($pr_r,$i,'predmet');
  echo("<option value='$pnum'");
  if($S_F_WL_PR==$pnum){echo(" selected");}
  echo(">$ppredmet</option>\n");
}
?>
      </select></td>
      </tr>
    <tr>
      <td valign="bottom" nowrap>Тип работы:
        <select name="tip">
          <option value="0">-Все-</option>
          <?php
$tw_r=mysql_query("SELECT * FROM ri_typework ORDER BY number");
$tw_n=mysql_num_rows($tw_r);
for($i=0;$i<$tw_n;$i++)
{
  $wnum=mysql_result($tw_r,$i,'number');
  $wtip=mysql_result($tw_r,$i,'tip');
  echo("<option value='$wnum'");
  if($S_F_WL_TIP==$wnum){echo(" selected");}
  echo(">$wtip</option>\n");
}
?>
        </select></td>
      <td><input type="submit" class="topPad6" value="Показать список!">
        <input name="fl" type="hidden" id="fl" value="filter"></td>
    </tr>
  </table>
        </form></td>
  </tr>
</table>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top"><hr size="1"><h3 style="padding-top:0px; margin-top:10px">
  Наши рекомендации по ценам.</h3>
                <p>
                Как мы уже говорили, цены на свои работы вы определяете сами. Однако мы позволим себе привести  ряд рекомендаций, которые являются следствием нашего собственного опыта продаж готовых работ.</p>
        <p>Основными ценообразующими факторами мы считаем:</p>
      <ul>
        <li>Готовность потенциального заказчика к вашему уровню цен </li>
        <li>Возможность продавать работы многократно</li>
        <li>Уникальность конкретной работы</li>
        <li>Качество работы</li>
        <li>Тип работы (диплом, курсовая, реферат, контролькная и т.д.) и предмет </li>
      </ul>
      <p>Итак:</p>
      <p><strong>1. Готовность потенциального заказчика к вашему уровню цен.</strong></p>
      <p>К сожалению, наш российский заказчик всё ещё не до конца осознаёт то, что интеллектуальный труд ст&oacute;ит хороших денег. До сих пор в интернете есть сайты, где творческие работы можно скачивать совершенно бесплатно. Конечно, их там ограниченное количество и, возможно, эти работы не очень актуальны и т.п. Но то, что такая вероятность существует, влияет на рассматриваемый фактор.</p>
      <p><strong>2. Возможность продавать работы многократно.</strong></p>
      <p>Согласитесь, что это должно влиять на стоимость &laquo;изделия&raquo;. Что лучше &#8212; продавать конкретную работу 1 раз в 3 месяца за 800 р. или 2 раза в неделю за 200 р.? Мы бы выбрали второе. </p>
      <p><strong>3. Уникальность конкретной работы.</strong></p>
      <p>Разумеется, с каждой продажей этот показатель снижается. На наш взгляд, плавное снижение цены на такую работу было бы логичным.</p>
      <p><strong>4. Качество работы.</strong></p>
      <p>Ну, здесь, в общем-то всё понятно: выше качество &#8212; больше цена. </p>
      <p><strong>5. Тип работы и предмет.</strong></p>
      <p>Разумеется, это &#8212; один из определяющих факторов. В подавляющем большинстве случаев курсовые ст&oacute;ят дороже рефератов, а дипломные работы ценятся выше курсовых. Также, работы по техническим дисциплинам, как правило, дороже гуманитарных. </p>
      <p>Исходя из вышесказанного, оптимальными ценами нам представляются следующие:</p>
      <table cellpadding="4" cellspacing="1" bgcolor="#E4E4E4" class="solidGray">
        <tr>
          <td rowspan="2" nowrap>Тип работы:</td>
          <td colspan="2" bgcolor="#F5F5F5">Тематика</td>
        </tr>
        <tr>
          <td bgcolor="#F5F5F5">Гуман.</td>
          <td bgcolor="#F5F5F5">Технич.</td>
        </tr>
        <tr>
          <td bgcolor="#F5F5F5">Реферат</td>
          <td align="right" bgcolor="#FFFFFF">100</td>
          <td align="right" bgcolor="#FFFFFF">300</td>
        </tr>
        <tr>
          <td bgcolor="#F5F5F5">Курсовая</td>
          <td align="right" bgcolor="#FFFFFF">250</td>
          <td align="right" bgcolor="#FFFFFF">500</td>
        </tr>
        <tr>
          <td bgcolor="#F5F5F5">Диплом</td>
          <td align="right" bgcolor="#FFFFFF">1500</td>
          <td align="right" bgcolor="#FFFFFF">3000</td>
        </tr>
      </table>
      <p>Ещё раз подчёркиваем, что вы не обязаны следовать нашим рекомендациям, это &#8212; всего лишь совет. Со своей стороны, мы прилагаем все усилия, чтобы продавать ваши работы по максимально высокой цене. Заказчики не знают, сколько ст&oacute;ит та или иная работа, если не предлагают цену, ниже той, что выставили вы. </p>
      <p>Например, если вы запросили за курсовую работу 400 р., а заказчик указал свою цену в 500 р., он платит 500! Однако, если он согласен заплатить, например, только 200, то мы предложим ему 3 варианта дальнейших действий на выбор:</p>
      <p><img src="illustrations/get3ways.gif" width="580" height="453" border="1"></p>
      <p>Разумеется, всегда найдутся так наз. &laquo;продвинутые&raquo; заказчики.
        И они очень быстро сообразят, что получат работу за минимальную стоимость,
        если будут указывать явно заниженные цены (например, в 1 руб.) :) Таким
        образом, фактически, вам нужно решить для себя, какую минимальную цену
        для каждой работы вы считаете морально допустимой :). </p>
      <p>Если же цена заказчика окажется выше вашей, мы с удовольствием продадим
        ему эту работу по этой (НЕ минимальной) цене. :). Так или иначе, некоторый
        % заказчиков всё равно будет честно указывать ту цену, которая, на его
        взгляд, представляется &laquo;справедливой&raquo;. </p>
      <h4>Надеемся (и даже &#8212; верим ), что вы подойдёте к вопросу ценообразования мудро :) </h4></td>
  </tr>
</table>
</body>
</html>
<?php
}//end work
?>