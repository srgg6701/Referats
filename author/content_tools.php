<? //echo $_REQUEST['menu'];?>
<h4 class="txtWhite" style="background-color: #009; padding:22px; padding-left:10px;"><img src="<?=$_SESSION['SITE_ROOT']?>images/document_edit_invert.png" width="32" height="32" hspace="4" border="0" align="absmiddle" />Программа подготовки аннотаций текстов творческих работ DocsReducer&#8482;.</h4>
<div class="padding10 paddingTop0 bgYellowFadeTop txt120 borderBottom2 borderColorGray">
	<a href="?menu=tools&amp;point=purpose"><strong>Предназначение</strong></a> &nbsp;|&nbsp; 
    <a href="?menu=tools&amp;point=howitworks"><strong>Как это работает</strong></a> &nbsp;|&nbsp; <!-- ../downloads/DocsReducer.zip -->
    <a href="?menu=tools&amp;point=download"><strong>Скачать</strong></a><img src="<?=$_SESSION['SITE_ROOT']?>images/exclaime_middle_yellow.gif" width="15" height="15" hspace="4" border="0" align="absmiddle" />Внимание! Исходный файл в формате .exe</div>
<?  include("docs_reducer_default.php");
	if ($test_content) {?>
<p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed 
  
  diam nonumy eirmod tempor invidunt ut labore et dolore magna 
  
  aliquyam erat, sed diam voluptua. At vero eos et accusam et 
  
  justo duo dolores et ea rebum. Stet clita kasd gubergren, no 
  
  sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
<? }?>