<?php
session_start();
require('../connect_db.php');
require('lib.php');

statistic($S_NUM_USER, $_SERVER['PHP_SELF'], $HTTP_REFERER);
if($fl=='filter')
{
  $S_F_DIP=$dip;
  $S_F_KUR=$kur;
  $S_F_REF=$ref;
  $S_F_ALL=$all;
  $S_RAD_ORDER=$rad_order;
}
else
{
  $S_RAD_ORDER="name";
  //����� ��������
  if($pnum+1-1>0){$S_PREDMET_NUM=$pnum;}else{if($pnum!=-1){$S_PREDMET_NUM=0;}}
  $dp_r=mysql_query("SELECT * FROM diplom_predmet WHERE number=$S_PREDMET_NUM");
  $dp_n=mysql_num_rows($dp_r);
  if($dp_n>0){$predmet_name=mysql_result($dp_r,0,'predmet');}
}
$order="ORDER BY ri_works.".$S_RAD_ORDER;

$where="WHERE ";
if($S_PREDMET_NUM!=0){$where=$where."ri_works.predmet=$S_PREDMET_NUM AND ";}
$where=$where."enable='Y' AND ( ri_works.Number=0 ";
if($S_F_DIP=='on'){$where=$where."OR ri_works.tip=3 ";}
if($S_F_KUR=='on'){$where=$where."OR ri_works.tip=2 ";}
if($S_F_REF=='on'){$where=$where."OR ri_works.tip=1 ";}
if($S_F_ALL=='on'){$where=$where."OR ri_works.tip>3 ";}
if(!isset($S_F_ALL)){$where=$where."OR ri_works.Number<>0 ";}
$where=$where.")";
if(($author+1-1)>0){$where=$where." AND ri_works.manager=$author";}
$wk_r=mysql_query("SELECT * FROM ri_works $where");
//echo("SELECT * FROM ri_works $where<br>");

$kolvo=mysql_num_rows($wk_r);
//��������������
$S_LIST_PAGE=$S_LIST_PAGE+1-1;
if($command=='next'){$S_LIST_PAGE=$S_LIST_PAGE+20;}
if($command=='prev'){$S_LIST_PAGE=$S_LIST_PAGE-20;}
if($S_LIST_PAGE>=$kolvo){$S_LIST_PAGE=$kolvo-20;}
if($S_LIST_PAGE<0){$S_LIST_PAGE=0;}
?>
<html>
<head>
<TITLE>�������� ��������� ������ ������ ������ �� ����� ��������</TITLE>
<meta name="description" content="�������, �������� ������ � �������� �� �����">
<!-- ��������� ������ ������ ������ -->
<meta name="keywords" content="��������� ������ ������ ������ �� �����; ���������; ���������� ���������; ����������; ��������� �������; ��������; ����� �������� ������; �����������; ��������� ������� �� �����; ��������������� �������������; ������ � ����� ������; ������� ��������; �������� � �������� ������; �������������� � ������������; ��������� ���������; ����������; �������� ������ �� �����; ��������� ������; ���� ���������; ��������� ���������; ������� ���������; ��������� �����������; ���; ���������; ������������� ���������; ����������������; ���������������� � �����; ����������� �����; ����������; ����������; ������; �����; ����������������; ���������; ��������� � �������; ������ �������; ��������">
<link href="referats.css" rel="stylesheet" type="text/css"><meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<script language="JavaScript" type="text/JavaScript" src="../go_url.js"></script>
<script language="JavaScript" type="text/JavaScript" src="../rollovers.js"></script>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
</style>
</head>

<body onLoad="MM_preloadImages('../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif','../images/pyctos/account2_over.gif','../images/pyctos/cooperation_over.gif','../images/pyctos/faq_over.gif','../images/pyctos/agreement_over.gif','../images/pyctos/useful_over.gif','../images/pyctos/feedback_over.gif')"><? require ("../temp_transparency.php");?><!-- #BeginLibraryItem "/Library/block_nav_top.lbi" --><a href="../index.php"><img src="../images/referatsinfo2.gif" 
alt="���� ���������, ��������, ��������� �����." title="�������� �������� Referats.info" 
width="261"  height="38" 
hspace="12" vspace="0" border="0"></a><h1 
class="graphixHeader2"><a href="../index.php" 
class="nodecorate" style="background-color:">���� ���������, �������� � �������</a><img 
alt="���� ���������, ��������, ��������� �����. ������� ������, ������� �� ����� ��������" title="" src="../images/referat_bank.gif" 
width="55" height="16" 
border="0" align="absmiddle"></h1>
<div style="position:absolute; top:0px; left:390" id="navMenus">
  <table width="100%" height="54" align="right" cellpadding="0"  cellspacing="0">
    <tr>
      <td width="65%" valign="top"><table height="42" border="0" align="center" cellspacing="0">
          <tr>
            <td nowrap class="red">������� �����<img src="../images/arrows/simple_black.gif" width="14" height="12" hspace="6" border="1" align="absmiddle">&nbsp;&nbsp;</td>
            <td height="38" align="center" nowrap><a href="autors.php" onMouseOver="MM_swapImage('pyctAccount','','../images/pyctos/account2_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/account2.gif" alt="���� ���������, ��������, ��������� �����. ������� ������, ������� �� ����� ��������" name="pyctAccount" width="40" height="40" hspace="1" border="0" id="pyctAccount" title="��� ������������ ������ [�������]
			                       ���� / �����������"></a></td>
            <td height="38" align="center" nowrap><a href="cooperation.htm" onMouseOver="MM_swapImage('pyctCooperation','','../images/pyctos/cooperation_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/cooperation.gif" alt="��������������" name="pyctCooperation" width="40" height="40" hspace="1" border="0" id="pyctCooperation"></a></td>
            <td height="38" align="center" nowrap><a href="faq.htm" onMouseOver="MM_swapImage('pyctFaq','','../images/pyctos/faq_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/faq.gif" alt="FAQ [����� ���������� �������]" name="pyctFaq" width="40" height="40" hspace="1" border="0" id="pyctFaq"></a></td>
            <td height="38" align="center" nowrap><a href="agreement.htm" onMouseOver="MM_swapImage('pyctAgreement','','../images/pyctos/agreement_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/agreement.gif" alt="���������������� ����������" name="pyctAgreement" width="40" height="40" hspace="1" border="0" id="pyctAgreement"></a></td>
            <td height="38" align="center" nowrap><a href="useful.htm" onMouseOver="MM_swapImage('pyctUseful','','../images/pyctos/useful_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/useful.gif" alt="��������" name="pyctUseful" width="40" height="40" hspace="1" border="0" id="pyctUseful"></a></td>
            <td align="center" nowrap><a href="feedback.php" onMouseOver="MM_swapImage('pyctFeedback','','../images/pyctos/feedback_over.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="../images/pyctos/feedback.gif" alt="�������� �����" name="pyctFeedback" width="40" height="40" hspace="1" border="0" id="pyctFeedback"></a></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<script language="JavaScript" type="text/JavaScript">
(screen.width<=800)? document.getElementById('navMenus').style.left=380:document.getElementById('navMenus').style.left=485;
//���������� ������ ����� ���� � ������������� ����
</script><!-- #EndLibraryItem --><!-- #EndLibraryItem --><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="border-bottom:dotted 1px #ff0000"><img src="../images/spacer.gif" width="6" height="6"></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td width="70%" valign="top"><h5 class="header10bottom">������ ����� �� �������� <span class="style1"><?php echo($predmet_name);?></span>.</h5>
              <table width="100%" cellspacing="0" cellpadding="0">
                <form name="form_filter" action="worx.php" method="post">
                  <tr>
                    <td width="100%" nowrap><span class="arial">����������:</span>
                        <input name="dip" type="checkbox" id="dip" value="on" <?php if($S_F_DIP=='on'){echo("checked");}?>>
        �������
        <input name="kur" type="checkbox" id="kur" value="on" <?php if($S_F_KUR=='on'){echo("checked");}?>>
        ��������
        <input name="ref" type="checkbox" id="ref" value="on" <?php if($S_F_REF=='on'){echo("checked");}?>>
        ��������
        <input name="all" type="checkbox" id="all" value="on" <?php if($S_F_ALL=='on'){echo("checked");}?>>
        ������</td>
                    <td rowspan="2" align="center"><input name="fl" type="hidden" id="fl" value="filter">
                        <input type="submit" name="Submit" value="�������������"></td>
                  </tr>
                  <tr>
                    <td width="100%" height="25" valign="top" nowrap><span class="arial">����������� ��:</span>
                        <input name="rad_order" type="radio" value="name" <?php if($S_RAD_ORDER=='name'){echo("checked");}?>>
        ����������� �������
        <input name="rad_order" type="radio" value="tip" <?php if($S_RAD_ORDER=='tip'){echo("checked");}?>>
        ���� ������</td>
                  </tr>
                </form>
              </table>
              <table width="100%" border=0 cellpadding=3 cellspacing=1 bgcolor="#CC0000">
                <tr  >
                  <td height="26" background="../images/pyctos-bg-1.gif"><b class="arial">�������� ������ </b></td>
                  <td align="center" nowrap background="../images/pyctos-bg-1.gif" class="arial"><b>��� ������ </b></td>
                </tr>
                <?php
$wk_r=mysql_query("SELECT * FROM ri_works $where $order LIMIT $S_LIST_PAGE, 20");
$wk_n=mysql_num_rows($wk_r);
for($i=0;$i<$wk_n;$i++)
{
  $wnum=mysql_result($wk_r,$i,'ri_works.number');
  $wname=mysql_result($wk_r,$i,'ri_works.name');
  $wtip=mysql_result($wk_r,$i,'ri_works.tip');
  
  $tw_r=mysql_query("SELECT * FROM ri_typework WHERE number=$wtip");
  $wtype=mysql_result($tw_r,0,'tip');
  echo("<tr bgcolor='#FFFFFF'><td><a href='content.php?wnum=$wnum'><span>$wname</span></a></td><td align='center'>$wtype</td></tr>");
}
?>
                <tr align="center" bgcolor="#F5F5F5">
                  <td colspan="2"><?php
if($S_LIST_PAGE>0){?>
                      <a href="worx.php?command=prev&pnum=-1">&lt; ���������� 20</a>
                      <?php }?>
                &nbsp;<b>������� <?php echo("$S_LIST_PAGE-");
if($S_LIST_PAGE+20<$kolvo){echo($S_LIST_PAGE+20);}else{echo($kolvo);}
echo(" �� $kolvo");?></b>
                      <?php
if($S_LIST_PAGE+20<$kolvo){
?>
                      <a href="worx.php?command=next&pnum=-1">&nbsp;��������� 20 &gt;</a>
                      <?php }?></td>
                </tr>
      </table>
              <br>
���� �� �� ����� ������ ��� ����, ������� �:<br>
<input name="referat_subj2" type="text" class="cells" id="referat_subj2" style="width:100%">
<input type="button" name="Button" value="��������!" onClick="sendOrder2('referat_subj');"></td>
    <td width="30%" valign="top" style="border-left:dotted 1px #ffcc00"><!-- #BeginLibraryItem "/Library/block_topic_chapters.lbi" --><form action="/old/search_list.php" method="post" name="search_form" style=" padding-bottom:0px; margin-bottom:0px"><table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#E4E4E4">
      <tr>
        <td colspan="2">������� �����:
          <b><nobr>������� ���� ������</nobr></b>          <input name="referat_subj" type="text" class="cells" id="referat_subj" style="width:100%">          </td>
  </tr>
      <tr>
        <td rowspan="2"><a name="wtypes"></a>
          <input name="diplom" type="checkbox" id="diplom" value="on" checked>
  ������<br>
  <input name="curs" type="checkbox" id="curs" value="on" checked>
  ��������<br>
  <input name="referat" type="checkbox" id="referat" value="on" checked>
  �������<br>
  <input name="other" type="checkbox" id="other" value="on" checked> 
  ������ </td><td align="center"><!-- <input type="button" name="Submit" value="�����!" onClick="sendOrder('�������','referat_subj');">   --><input type="submit" name="Submit" value="�����!">          </td>
      </tr>
      <tr>
        <td align="center"><span title="����������/�������� ������� ���������" style="color:#0000FF; text-decoration:underline; font-size: 120%; cursor:hand" onClick="(document.getElementById('accHelp').innerHTML=='')? document.getElementById('accHelp').innerHTML='<table  bgColor=#FFFF00 width=100% cellPadding=4 cellSpacing=0><tr><td><ol><li>���� �� ������ ����� ������ ������-�� ����������� ���� (������/��������/�������/������), �������� �������� ��������������� ����� (��. <a href=#wtypes>������</a>).</li> <li>���� �� ������ ������ ������� ������ �� ������ ����� ������, �� � ��������� (����������), �������� �������� ��������������� ������ (������) � <a href=#wchapters>������ (��������) ��������� ����;</a> ������ �� �������� �������� ������ �������� ��� � ��������������� ������. </li> </ol> <p>��������: ���� �� �������� �������� ��� ������ &laquo;<b>������</b>&raquo; � �������� &laquo;<b>���������, ������������� ���������</b>&raquo; � &laquo;<b>��������, ��������</b>&raquo;, �� ���� �������, ��������������, ����� ������ ��� ��� ������ ������� �� ���� ���������. �� ���������, ��� ���� ����� ���� ��������� � ���� ����� ����� (�� �������� ���������).</p> <p>���� �� ������ �������� �� �������� &laquo;���������, ������������� ���������&raquo;, ������� � ������ ��� �� ������� (��� � ������ �������) ��������. </p></td></tr></table>':document.getElementById('accHelp').innerHTML='';">[?]</span></td>
      </tr>
    </table><span id="accHelp"></span></form>
      <span class="arial"><img src="/images/arrows/inbox.gif" width="31" height="26" vspace="6" align="absmiddle" style="border:solid 1px #00ae00; padding-right: 4px; margin-right:4px">�������� �������� ������ ��� ������: </span>
      <div class="arial" style="padding-left:2px"><a name="wchapters"></a>

  <?php
/*$pr_r=mysql_query("SELECT * FROM diplom_predmet ORDER BY sort, predmet");
$pr_n=mysql_num_rows($pr_r);
for($i=0;$i<$pr_n;$i++)
{
  $pnum=mysql_result($pr_r,$i,'number');
  $ppredmet=mysql_result($pr_r,$i,'predmet');
  echo("<input name='checkbox$pnum' type='checkbox' value='on' checked><a href='../worx.php?pnum=$pnum'>$ppredmet</a><br>\n");
}*/
?><script language="JavaScript" type="text/JavaScript" src="/create_topix.js">
</script>
</div>
<!-- #EndLibraryItem --></td>
  </tr>
</table>
<!-- #BeginLibraryItem "/Library/menu_nav_bottom.lbi" -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="arial">
    <tr>
      <td height="24" align="center" nowrap class="topDotted" style="padding-top:2px"><a href="/index.php">�������</a></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><b><a href="/old/autors.php" class="myAccount">��� ������ </a></b></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><a href="/old/cooperation.htm">��������������</a></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><a href="/old/faq.htm">FAQ</a></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><a href="/old/agreement.htm">����������</a></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><a href="/old/useful.htm">��������</a></td>
      <td align="center" class="topDotted" nowrapclass="topDotted" style="padding-top:2px"><a href="/old/feedback.php">�������� �����</a> </td>
  </tr>
    <tr valign="bottom">
      <td height="20" colspan="7" align="center" nowrap background="/images/bankreferatov_bg.gif"><b style="font-weight:100">����
          ���������, ��������, ��������� �����. ������� ������, ������� �� �����,
      ��������</b></td>
  </tr>
</table><div style="height:4px"><img src="/images/spacer.gif"></div>
<!-- SpyLOG f:0211 -->
<script language="javascript"><!--
Md=document;Mnv=navigator;Mp=1;
Mn=(Mnv.appName.substring(0,2)=="Mi")?0:1;Mrn=Math.random();
Mt=(new Date()).getTimezoneOffset();
Mz="p="+Mp+"&rn="+Mrn+"&t="+Mt;
Md.cookie="b=b";Mc=0;if(Md.cookie)Mc=1;Mz+='&c='+Mc;
Msl="1.0";
//--></script><script language="javascript1.1"><!--
Mpl="";Msl="1.1";Mj = (Mnv.javaEnabled()?"Y":"N");Mz+='&j='+Mj;
//--></script>
<script language="javascript1.2"><!-- 
Msl="1.2";
//--></script><script language="javascript1.3"><!--
Msl="1.3";//--></script><script language="javascript"><!--
Mu="u6940.51.spylog.com";My="";
My+="<a href='http://"+Mu+"/cnt?cid=694051&f=3&p="+Mp+"&rn="+Mrn+"' target='_blank'>";
My+="<img src='http://"+Mu+"/cnt?cid=694051&"+Mz+"&sl="+Msl+"&r="+escape(Md.referrer)+"&pg="+escape(window.location.href)+"' border=0 width=88 height=31 alt='SpyLOG'>";
My+="</a>";Md.write(My);//--></script><noscript>
<a href="http://u6940.51.spylog.com/cnt?cid=694051&f=3&p=1" target="_blank">
<img src="http://u6940.51.spylog.com/cnt?cid=694051&p=1" alt='SpyLOG' border='0' width=88 height=31 >
</a></noscript>
<!-- SpyLOG --><!-- #EndLibraryItem --></body>
</html>
