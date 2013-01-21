<div class="paddingBottom10">
  <h4 class="padding0 paddingBottom8 txtDarkBlue">������� ���� ������ Windows:</h4>
<div class="txt110 paddingLeft10">
        <div class="paddingTop6">&bull; <a href="#" id='7'
        onclick="manageTextBlocks ( 'txtWinBlocks', 'win_', this.id ); return false;">Windows 7 ��� Vista</a></div>
        <div class="paddingTop6">&bull; <a href="#" id='xp'
        onclick="manageTextBlocks ( 'txtWinBlocks', 'win_', this.id ); return false;">Windows XP</a></div>
        <div class="paddingTop6">&bull; <a href="#" id='unknown'
        onclick="manageTextBlocks ( 'txtWinBlocks', 'win_', this.id ); return false;">� �� ����, ����� ������ ����������� �� ��� ����������</a></div>
  </div>
</div>
<div id="txtWinBlocks" style="background-image: url(../images/bg_panel_profile_bottom.jpg); background-position:top; background-repeat:repeat-x;" class="padding10 paddingTop0 bgGrayLightFBFBFB iborder borderColorGray"><!--<img src="../images/exclaime_middle_yellow.gif" width="15" height="15" hspace="4" vspace="6" border="0" align="absmiddle" /><strong class="txt110">��������!</strong>-->
  <div id="win_7" style="display:<?="none"?>;">
  <h5>Windows 7 ��� Vista</h5>
  <p>���������  DocsReducer&#8482; ���������� ��������� Microsoft .NET Framework, ������� ��� �������������� �� ����� Windows. ������ ���������� ��������� ��������� ����� ����������, ��� ������� �� ������� �������� ��������������� ������ ���������:</p>
  <? softVersions();
  	 //downloadSoftLink('DocsReducer');?>
  </div> 
  <div id="win_xp" style="display:<?="none"?>;"><!--���� �� ����� ���������� ����������� Windows XP, ��, �-->
  <h5>Windows XP</h5>
  <p>��� �������  ��������� DocsReducer&#8482; � ��� ������ ���� ���������� �����  
    Microsoft .NET Framework (��. 40 ��.). ����� ������� ������ ��������, ����� �� ��� ��������� � ������������� ��� &#8212; ������ ���������� ��������� <strong>DocsReducer</strong>&#8482; �� ����� ����������. </p>
  <p>�������� �������� �� ��, ��� ���������� ��������� ������ �������������� ������, � ��� ������� �� ��� �������� ���� ������ <strong>DocsReducer</strong>&#8482;:</p>
<? function softVersions() {?>  
  <ul>
    <li><a href="../downloads/DocsReducer2.zip">DocsReducer&#8482; ��� NET Framework 2.0</a> (<? echo (round(filesize($_SESSION['DOC_ROOT']."/downloads/DocsReducer2.zip")/1024,2)); ?> ��.)</li>
    <li><a href="../downloads/DocsReducer35.zip">DocsReducer&#8482; ��� NET Framework 3.5</a> (<? echo (round(filesize($_SESSION['DOC_ROOT']."/downloads/DocsReducer35.zip")/1024,2)); ?> ��.)</li>
    <li><a href="../downloads/DocsReducer4.zip">DocsReducer&#8482; ��� NET Framework 4.0</a> (<? echo (round(filesize($_SESSION['DOC_ROOT']."/downloads/DocsReducer4.zip")/1024,2)); ?> ��.)</li>
  </ul>
  �������� ��������� ��� ���������, �� ������ ������� ��� ������ ����� � ���������� ��������������� ��������� ������ �� ���.<?
} softVersions();?> ���� NET Framework �� ����������, Windows ������ ��� ��������������� ����������� � ������������ ������� �����. �������� ��������, ��� ����� ��� ����������� ������� � ���������� ��� ���� ����� &#8212; Microsoft Windows Imaging Component (��������� �� �������). <br />
  <br />
<div class="padding4"><img src="../images/down.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" /><a href="http://www.microsoft.com/downloads/ru-ru/details.aspx?familyid=8e011506-6307-445b-b950-215def45ddd8&amp;displaylang=ru">������� Windows Imaging Component</a> (WIC, ����� 1 ��.)</div> 
<div class="padding4"><a href="http://download.microsoft.com/download/1/B/E/1BE39E79-7E39-46A3-96FF-047F95396215/dotNetFx40_Full_setup.exe"><img src="../images/down.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />������� Microsoft .NetFramework</a> (��������� ������). ���� ��������� ������ ���� �� �������������� ��������, ����������, ��������� �� ������� ����:   <a href="http://www.microsoft.com/net/download.aspx">http://www.microsoft.com/net/download.aspx</a> ��� ����������� ����� �� ����� <a href="http://search.microsoft.com/results.aspx?q=Microsoft+.Net+Framework+downloads">Microsoft .Net Framework downloads</a> �� ����� <a href="http://www.microsoft.com">Microsoft</a>.</div>
<p>����� ��������� ������������� ����������� ��������� ������ ������� ���������.</p>
  <!--<hr size="1">-->  
  <? //downloadSoftLink();?>
  </div>
  <div id="win_unknown" style="display:<?="none"?>;">
  <h5>� �� ����, ����� ������ Windows ����������� �� ��� ����������</h5>
  ������� �� ������� ����� ������ &laquo;��� ���������&raquo;  � �������� �� ���� ������ ������� ����. � ������������ ���� ������� ������ &laquo;�������� �������� �������� � ����������&raquo; (��� � ������� ���������) � ��������, ����� ������� �� �����������. ���� �� �����-�� �������� ���-�� �� ����������, <a href="http://windows.microsoft.com/ru-RU/windows7/help/which-version-of-the-windows-operating-system-am-i-running">����������� ������ (�������������) ������</a>.</div> 
</div>
<div class="paddingTop10 txt120">
���� �� �����-���� ����� ��������� �/��� ������������� ��������� <strong>DocsReducer</strong>&#8482; �� ������������� � �����������, ����������, <a href="?menu=messages&amp;action=compose">��������� � ����</a> � �� ������ ��� ����������� ������. </div>
<script type="text/javascript">
function checkAgr(box) {
var bb=document.getElementById('agrm');	
	
	if(document.getElementById('agr').checked==false&&!box) {

		alert('�� �� ����������� � ��������� ������������� ���������!');
		bb.style.backgroundColor='yellow';
		return false;
	
	}else{
	
		bb.style.backgroundColor='';
		return true;
	} 
}
</script>
<? function downloadSoftLink($file_name=false) {?>
<h2 style="padding-bottom:0; margin-bottom:4px;"><a<? if ($file_name){?> href="../downloads/<?=$file_name?>.zip" onClick="return checkAgr();"<? }?>><img src="../images/download.gif" width="32" height="33" hspace="4" border="0" align="absmiddle" /><span class="noBold">������� ���������</span> Referats.info DocsReduser&#8482;.</a>
</h2>
<hr size="1">
<div id="agrm"><input type="checkbox" name="agr" id="agr" onClick="return checkAgr(this);" /> 
� �������� �� �������������� ������ ��������� � �� ������������ � �����, ����, ������ ��������������� <a href="?menu=author_agreement">����������� � ��������������</a>.</div>
<? }?>