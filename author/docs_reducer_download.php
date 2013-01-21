<div class="paddingBottom10">
  <h4 class="padding0 paddingBottom8 txtDarkBlue">Укажите свою версию Windows:</h4>
<div class="txt110 paddingLeft10">
        <div class="paddingTop6">&bull; <a href="#" id='7'
        onclick="manageTextBlocks ( 'txtWinBlocks', 'win_', this.id ); return false;">Windows 7 или Vista</a></div>
        <div class="paddingTop6">&bull; <a href="#" id='xp'
        onclick="manageTextBlocks ( 'txtWinBlocks', 'win_', this.id ); return false;">Windows XP</a></div>
        <div class="paddingTop6">&bull; <a href="#" id='unknown'
        onclick="manageTextBlocks ( 'txtWinBlocks', 'win_', this.id ); return false;">Я не знаю, какая версия установлена на моём компьютере</a></div>
  </div>
</div>
<div id="txtWinBlocks" style="background-image: url(../images/bg_panel_profile_bottom.jpg); background-position:top; background-repeat:repeat-x;" class="padding10 paddingTop0 bgGrayLightFBFBFB iborder borderColorGray"><!--<img src="../images/exclaime_middle_yellow.gif" width="15" height="15" hspace="4" vspace="6" border="0" align="absmiddle" /><strong class="txt110">Внимание!</strong>-->
  <div id="win_7" style="display:<?="none"?>;">
  <h5>Windows 7 или Vista</h5>
  <p>Программа  DocsReducer&#8482; использует компонент Microsoft .NET Framework, который уже предустановлен на вашей Windows. Однако существует несколько вариантов этого компонента, для каждого из которых подходит соответствующая версия программы:</p>
  <? softVersions();
  	 //downloadSoftLink('DocsReducer');?>
  </div> 
  <div id="win_xp" style="display:<?="none"?>;"><!--Если на вашем компьютере установлена Windows XP, то, п-->
  <h5>Windows XP</h5>
  <p>Для запуска  программы DocsReducer&#8482; у вас должен быть установлен пакет  
    Microsoft .NET Framework (ок. 40 Мб.). Самый простой способ выяснить, нужно ли вам скачивать и устанавливать его &#8212; просто попытаться запустить <strong>DocsReducer</strong>&#8482; на вашем компьютере. </p>
  <p>Обратите внимание на то, что существуют несколько версий вышеуказанного пакета, и для каждого из них подходит своя версия <strong>DocsReducer</strong>&#8482;:</p>
<? function softVersions() {?>  
  <ul>
    <li><a href="../downloads/DocsReducer2.zip">DocsReducer&#8482; для NET Framework 2.0</a> (<? echo (round(filesize($_SESSION['DOC_ROOT']."/downloads/DocsReducer2.zip")/1024,2)); ?> Кб.)</li>
    <li><a href="../downloads/DocsReducer35.zip">DocsReducer&#8482; для NET Framework 3.5</a> (<? echo (round(filesize($_SESSION['DOC_ROOT']."/downloads/DocsReducer35.zip")/1024,2)); ?> Кб.)</li>
    <li><a href="../downloads/DocsReducer4.zip">DocsReducer&#8482; для NET Framework 4.0</a> (<? echo (round(filesize($_SESSION['DOC_ROOT']."/downloads/DocsReducer4.zip")/1024,2)); ?> Кб.)</li>
  </ul>
  Учитывая небольшой вес программы, вы можете скачать все версии сразу и попытаться последовательно запустить каждую из них.<?
} softVersions();?> Если NET Framework не установлен, Windows выдаст вам соответствующее уведомление с предложением скачать пакет. Обратите внимание, что также вам потребуется скачать и установить ещё один пакет &#8212; Microsoft Windows Imaging Component (небольшой по размеру). <br />
  <br />
<div class="padding4"><img src="../images/down.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" /><a href="http://www.microsoft.com/downloads/ru-ru/details.aspx?familyid=8e011506-6307-445b-b950-215def45ddd8&amp;displaylang=ru">Скачать Windows Imaging Component</a> (WIC, около 1 Мб.)</div> 
<div class="padding4"><a href="http://download.microsoft.com/download/1/B/E/1BE39E79-7E39-46A3-96FF-047F95396215/dotNetFx40_Full_setup.exe"><img src="../images/down.gif" width="16" height="16" hspace="4" border="0" align="absmiddle" />Скачать Microsoft .NetFramework</a> (последняя версия). Если указанная ссылка ведёт на несуществующую страницу, пожалуйста, перейдите на уровень выше:   <a href="http://www.microsoft.com/net/download.aspx">http://www.microsoft.com/net/download.aspx</a> или используйте поиск по фразе <a href="http://search.microsoft.com/results.aspx?q=Microsoft+.Net+Framework+downloads">Microsoft .Net Framework downloads</a> на сайте <a href="http://www.microsoft.com">Microsoft</a>.</div>
<p>После установки вышеуказанных компонентов программа должна работаь нормально.</p>
  <!--<hr size="1">-->  
  <? //downloadSoftLink();?>
  </div>
  <div id="win_unknown" style="display:<?="none"?>;">
  <h5>Я не знаю, какая версия Windows установлена на моём компьютере</h5>
  Найдите на рабочем столе значок &laquo;Мой компьютер&raquo;  и щёлкните по нему правой кнопкой мыши. В раскрывшемся окне найдите секцию &laquo;Просмотр основных сведений о компьютере&raquo; (или с похожим названием) и выясните, какой версией вы пользуетесь. Если по каким-то причинам что-то не получается, <a href="http://windows.microsoft.com/ru-RU/windows7/help/which-version-of-the-windows-operating-system-am-i-running">используйте другой (универсальный) способ</a>.</div> 
</div>
<div class="paddingTop10 txt120">
Если на каком-либо этапе установки и/или использования программы <strong>DocsReducer</strong>&#8482; вы сталкиваетесь с трудностями, пожалуйста, <a href="?menu=messages&amp;action=compose">свяжитесь с нами</a> и мы окажем вам необходимую помощь. </div>
<script type="text/javascript">
function checkAgr(box) {
var bb=document.getElementById('agrm');	
	
	if(document.getElementById('agr').checked==false&&!box) {

		alert('Вы не согласились с условиями использования программы!');
		bb.style.backgroundColor='yellow';
		return false;
	
	}else{
	
		bb.style.backgroundColor='';
		return true;
	} 
}
</script>
<? function downloadSoftLink($file_name=false) {?>
<h2 style="padding-bottom:0; margin-bottom:4px;"><a<? if ($file_name){?> href="../downloads/<?=$file_name?>.zip" onClick="return checkAgr();"<? }?>><img src="../images/download.gif" width="32" height="33" hspace="4" border="0" align="absmiddle" /><span class="noBold">Скачать программу</span> Referats.info DocsReduser&#8482;.</a>
</h2>
<hr size="1">
<div id="agrm"><input type="checkbox" name="agr" id="agr" onClick="return checkAgr(this);" /> 
Я обязуюсь не распространять данную программу и не использовать в целях, иных, нежели предусмотренные <a href="?menu=author_agreement">соглашением о сотрудничестве</a>.</div>
<? }?>