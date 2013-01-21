<?php
session_start();
require('../../connect_db.php');
require('../access.php');
require('../lib.php');
if(access($S_NUM_USER, 'main')){//начало разрешения работы со страницей

$us_r=mysql_query("SELECT * FROM ri_user WHERE number=$S_NUM_USER");
$login=mysql_result($us_r,0,'login');
$name=mysql_result($us_r,0,'family');

if($fl=='send')
{
  send_intro_mess($S_NUM_USER, 1, $login, "FAQ: $tip_mess", $letter, 0);
  //mail($admin_mail,"FAQ: $tip_mess","От $name<hr>$letter","From: $login".chr(13).chr(10).'Reply-To: '.$login.chr(13).chr(10).'X-Mailer: PHP/'. phpversion().chr(13).chr(10).'Content-Type: text/html; charset= windows-1251');
  echo("<script>alert('Вы отправили сообщение на тему $tip_mess');</script>");
}
?>
<html>
<head>
<TITLE>FAQ</TITLE>
<meta name="description" content="Дипломы, курсовые работы и рефераты на заказ">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link href="autor.css" rel="stylesheet" type="text/css">
<style type="text/css">
.LR_pad {padding-left:10px; padding-right:10px}
LI {padding-right:10px;}
h4 { font-size:120% }
</style>
<script language="JavaScript" type="text/JavaScript" src="lime_div.js">
</script>
<script language="JavaScript" type="text/JavaScript">
colorizePoint('faq');
visitorStat=0;
var payment='"Вопросы оплаты",';
var technicalProblem=' "Технические проблемы",';
var other=' "Другое".';
</script>
</head>
<body><? require ("../../temp_transparency_author.php");?>
<form name="send_mess" action="faq.php" method="post" onSubmit='if (visitorStat==0) {alert ("Вы не указали тему вопроса &#8212; "+payment+technicalProblem+other); document.all.radios.style.backgroundColor="yellow"; return false}'>
  <a name="top"></a> 
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td><h3 class="dLime">FAQ&nbsp;&nbsp;</h3></td>
      <td width="100%"> (ответы на наиболее часто задаваемые вопросы). </td>
    </tr>
  </table>
  
  <hr size="1" noshade>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">
	<ol style="font-weight:800; padding-top:10px">
      <li><a href="#sale_beg">Как начать продавать свои работы?</a></li>
      <li><a href="#potential">В моём аккаунте указаны какие-то &laquo;Потенциальные&raquo; работы.
        Что это такое?</a> </li>
      <li><a href="#your_profit">Какова ваша выгода от продажи моих работ?</a></li>
      <li><a href="#all_money">Правда ли, что я могу продавать свои работы без вычета ваших комиссионных в течение 3 месяцев?</a></li>
      <li><a href="#short_time">Вы утверждаете, что  мне выгодно размещать как можно больше работ
          за наименьший промежуток времени. Поясните, почему?</a></li>
      <li><a href="#time_to_add">У меня около 300 готовых работ. Скажите, сколько времени нужно для размещения их в вашем каталоге?</a></li>
      <li><a href="#yourself">Мне очень нравится ваш сайт и ваша идея, но у меня совершенно нет времени на размещение своих работ... Нельзя ли прислать вам свой список, чтобы вы сделали это сами?</a></li>
      <li><a href="#noreccomend">Обязан ли я следовать вашим рекомендациям по ценам на готовые работы?</a></li>
      <li><a href="#checking">Почему выставляемые мною на продажу работы не размещаются
          в вашем каталоге автоматически? Можете ли вы не утвердить их?</a> </li>
      <li><a href="#unical_worx">Могу ли я получать  на вашем сайте заказы на выполнение уникальных творческих работ?</a></li>
      <li><a href="#money_back">Что вы сделаете, если заказчик потребует вернуть ему деньги за мою работу?</a></li>
      <li><a href="#plagiat">Станете ли вы продавать мои работы от собственного лица?</a></li>
      <li><a href="#fee_order">Как вы расплачиваетесь с авторами?</a></li>
      <li><a href="#communication">У вас на сайте не указан ни один контактный email! Почему? И как с вами связаться?</a></li>
      <li><a href="#noanswer">Я посылаю вам сообщения из своего аккаунта, но не получаю ни одного
            ответа! Почему?</a></li>
      <li><a href="#add_profit">Есть ли у вас какие-нибудь дополнительные выгоды для исполнителей Diplom.com.ru?</a></li>
    </ol>      
        <table width="100%"  cellspacing="0" cellpadding="0">
      <tr>
        <td rowspan="2" valign="top"><img src="../../images/customer1.jpg" width="64" height="64" hspace="4" vspace="0" border="1"></td>
        <td width="100%" height="25" align="center" bgcolor="#DEFFCE"> <a href="#add_question"><strong>Добавьте свой вопрос.</strong></a> Мы постараемся ответить на него в течение 24 часов.</td>
      </tr>
      <tr>
        <td valign="top" style="padding:4px"><strong>Внимание!</strong> Пожалуйста, не задавайте в этом разделе вопросы по какому-либо <strong>конкретному</strong> заказу. Делайте это <a href="#new_message">на страницах, где данные заказы фигурируют</a>. Текущий раздел предназначен для ответов на общие вопросы. </td>
      </tr>
      <tr>
        <td height="30" colspan="2"><hr size="1" noshade></td>
        </tr>
    </table>
      <ol start="1" style="padding-top:0px; margin-top:0px">
          <h4>
            <li><a name="sale_beg"></a>Как начать продавать свои работы?
        </li>
          </h4>
          <p>Это не просто, а <b>очень просто</b>! :)</p>
          Для этого вам нужно:
        <ul style="padding:10px; margin:10px">
          <li>Щёлкнуть по ссылке &laquo;+Добавить работу &raquo;</li>
          <li>На загрузившейся странице указать требуемые данные и подтвердить
            их, нажав кнопку &laquo;Подтвердить!&raquo;</li>
        </ul>
        После утверждения заявленной вами работы администратором, на её покупку
        смогут подавать заявки потенциальные заказчики, о чём вы будете <b>автоматически</b> проинформированы. 
        <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">вверх</a></p>
        
          <h4><li><a name="potential">В моём аккаунте указаны какие-то &laquo;Потенциальные&raquo; работы.
        Что это такое?</a></li></h4>
            <p>Все имеющиеся у вас работы. Эти данные вы
              указывали при регистрации. Они позволяют вам видеть
              свой, пока ещё не используемый, потенциал :) </p>
            <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">вверх</a></p>
            <h4><li><a name="your_profit"></a>Какова ваша выгода от продажи моих
                работ?</li>
          </h4>
        
            <p>Что ж, всё просто — нам это выгодно, иначе мы, разумеется, не
              стали бы вкладывать огромные усилия и деньги в наш web-сайт. </p>
            <P>С каждой продажи (за исключением периода бесплатного обслуживания),
              мы получаем свои комиссионные в размере от 10% до 20%. Однако своей
              главной миссией мы считаем стремление сделать рынок образовательных
              услуг более цивилизованным, и способствовать тому, чтобы на нём
              работали честные и ответственные профессионалы. </P>
            <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">вверх</a></p>
        
          <h4><li><a name="all_money"></a>Правда ли, что я могу продавать свои
              работы без вычета ваших комиссионных в течение 3 месяцев?</li></h4>
        
          <p>Ессли разместите не менее 1000 работ, то период бесплатного обслуживания
            для вас будет именно таким. Все варианты вы можете увидеть в этой
            таблице:</p>
          <a name="tblProfit"></a>          <!-- #BeginLibraryItem "/Library/block_tbl_author_ctat.lbi" -->
          <table width="1%" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC" class="solidGray">
            <tr bgcolor="#FFFFFF">
              <td colspan="3"><h4 class="header6bottom"><strong>Таблица ваших
                    выгод :))) </strong></h4>
              </td>
            </tr>
            <tr>
              <td width="78" bgcolor="#E4E4E4"><strong> Количество выставленных
                  работ </strong></td>
              <td width="95" bgcolor="#E4E4E4"><strong style="cursor:default" title="Вычитается от заявленной вами стоимости работ.">Комиссия <nobr>от
                    продажи</nobr> (%%) </strong></td>
              <td width="164"><strong style="cursor:default" title="Период, в течение которого вся выручка от продажи ваших работ остаётся у вас.">Период
                  бесплатного обслуживания</strong></td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td width="78" align="right"> до 50 </td>
              <td width="95" align="right"> 25</td>
              <td width="164" align="right"> нет </td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td width="78" align="right"> 51-200 </td>
              <td width="95" align="right"> 18 </td>
              <td width="164" align="right"> 2 недели </td>
            </tr>
            <tr bgcolor="#FFFFFF" title="Ваш текущий статус">
              <td width="78" align="right"> 201-500 </td>
              <td width="95" align="right"> 15 </td>
              <td width="164" align="right"> 1 месяц </td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td width="78" align="right"> 501-1000 </td>
              <td width="95" align="right"> 13</td>
              <td width="164" align="right"> 2 месяца </td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td width="78" align="right">&gt;1000 </td>
              <td width="95" align="right"> 10 </td>
              <td width="164" align="right"> 3 месяца </td>
            </tr>
          </table>
          <!-- #EndLibraryItem -->
          <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">вверх</a></p>
          <h4><li><a name="short_time"></a>Вы утверждаете, что мне выгодно размещать
            как можно больше работ за наименьший промежуток времени. Поясните,
            почему?</li></h4>
        
          <p>Всё очень просто. Давайте поясним это на конкретном примере. </p>
          <p>Итак, представьте, что у вас есть 503 готовые работы. Предположим
            теперь, что за месяц вы разместили в нашем каталоге только 100 из
            них, после чего прошла первая продажа. Таким образом, вы получаете
            только 2 недели бесплатного обслуживания (<a href="#tblProfit">см.
            таблицу</a>). Кроме того, заказчики смогут выбирать только из <strong>уже
            размещённых</strong> вами 100 работ. А вот если бы вы разместили
            все 503 работы (или, хотя бы, 501 :), то, во-первых, получили бы
            2 месяца бесплатного обслуживания (т.е. &#8212; в 4 раза больше!)
            и во-вторых, в течение всего этого срока (как и в дальнейшем, разумеется),
            ваши работы покупали бы гораздо чаще (500 работ против 100!). Простой
            арифметический подсчёт показывает огромную выгоду для вас во втором
            случае &#8212; объём бесплатных продаж увеличился бы для примерно <strong>в
            20 раз!!! </strong></p>
          <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">вверх</a></p>
		<h4>
          <li><a name="time_to_add"></a>У меня около 300 готовых работ. Скажите,
            сколько времени нужно для размещения их в вашем каталоге?</li>
		</h4>
		<p>Это зависит от двух основных факторов &#8212; вашей пользовательской подготовки
		  и скорости вашего подключения к интернет. За час можно разместить от
		  15 до 70 работ. Таким образом, лично вам может потребоваться от 4 до
		  20 часов. </p>
		<p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">вверх</a></p>
		<h4>
		    <li><a name="yourself"></a>Мне очень нравится ваш сайт и ваша идея, но
		      у меня совершенно нет времени на размещение своих работ... Нельзя
		      ли прислать вам свой список, чтобы вы сделали это сами?</li>
		  </h4>
		<p>В качестве исключения это возможно, но в этом случае наши комиссионные увеличатся
		  до 50%. Кроме того, вы теряете право на период бесплатного обслуживания. </p>
		<p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">вверх</a></p>
		<h4><li></li>
		  <a name="checking">Почему выставляемые мною на продажу работы
              не размещаются в вашем каталоге автоматически? Можете ли вы не
          утвердить их?</a></li></h4>
		<p>Потому что мы сначала должны проверить заявленные вами данные на наличие
		  ошибок. Если мы их не обнаружим, утвердим вашу работу. В противном
		  случае мы либо исправим их, либо свяжемся с вами для прояснения спорных
		  моментов.</p>
		<p>Если мы ничего не делаем с вашей работой, то через 3 суток она утверждается
		  автоматически (интервал может быть изменён вручную). Мы можем не утвердить
		  вашу работу, если вы вводите в параметры работы свои контактные данные,
		  либо другую информацию, не имеющую непосредственного отношения к данной
		  работе. </p>
		<p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">вверх</a></p>
        <h4><li><a name="noreccomend"></a>Обязан ли я следовать вашим рекомендациям
            по ценам на готовые работы?</li></h4>
        <p>Нет, не обязаны. Вы вправе устанавливать собственные цены. </p>
        <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">вверх</a></p>
        <h4><li><a name="unical_worx"></a>Могу ли я получать на вашем сайте заказы
            на выполнение уникальных творческих работ?</li></h4>
        <p>Вы можете доработать свой ранее проданный диплом, реферат или курсовую
          до уровня уникального по желанию своего заказчика. Кроме того, вы можете
          участвовать в качестве исполнителя уникальных творческих работ в нашем
          втором проекте &#8212; <a href="http://www.diplom.com.ru" target="_blank">Diplom.com.ru</a>.</p>
        <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">вверх</a></p>
        <h4><li><a name="money_back"></a>Что вы сделаете, если заказчик потребует
            вернуть ему деньги за мою работу?</li></h4>
        <p>Подобные случаи регламентируются нашим <a href="../agreement.htm" target="_blank">пользовательским
            соглашением</a>.
          Если контекстуально текст работы соответствует указанному вами содержанию,
          деньги заказчику не возвращаются. Соответственно, мы не будем требовать
          возврата денег у вас. </p>
        <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">вверх</a></p>
        <h4><li><a name="plagiat"></a>Станете ли вы продавать мои работы от собственного
            лица?</li></h4>
        <p>Ни в коем случае! Ключевой принцип нашего с вами сотрудничества заключается
            в том, что мы признаём ваше исключительное право собственности на свои
            работы и предоставляем вам эксклюзивное право их продажи. Себе мы оставляем
            только <a href="#tblProfit">комиссию от продажи</a>.        </p>
        <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">вверх</a></p>
        <h4><li><a name="fee_order"></a>Как вы расплачиваетесь с авторами?</li></h4>
        <p>Наиболее предпочтительные способы &#8212; через платёжную систему <a href="http://www.money.yandex.ru">Яндекс.деньги</a> или
            банковским переводом. По отдельной договорённости и в исключительных
          случаях возможны другие формы расчётов. </p>
        <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">вверх</a></p>
        <h4><li><a name="communication"></a>У вас на сайте не указан ни один
            контактный email! Почему? И как с вами связаться?</li></h4>
        <p>Это сделано для защиты нашей системы от спама. К сожалению, в настоящее
          время любой опубликованный email быстро становится добычей спамеров. </p>
        <p>Однако связаться с нами не составит для вас никакого труда. Вы можете
            сделать это из раздела <a href="feedback.php">контакты</a>, либо <a href="#add_question">с
            этой страницы</a>, если вам требуется получить информацию, не связанную
            с какой-либо конкретной работой. В остальных случаях вам следует
            зайти в раздел с нужной работой (эти разделы формируются в зависимости
            от <a href="#">статуса
            работ</a>) и щёлкнуть по ссылке &laquo;новое&raquo; в столбце &laquo;сообщения&raquo; в
          строке с этой работой:<a name="new_message"></a></p>
        <p><img src="../../images/illustrations/new_message.gif" width="484" height="156" border="1"></p>
        <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">вверх</a></p>
        <h4><li><a name="noanswer"></a>Я посылаю вам сообщения из своего аккаунта,
            но не получаю ни одного ответа! Почему?</li></h4>
		<p>Скорее всего, статус вашего сообщения не соответствует его содержанию. Напоминаем,
		  что ваши сообщения могут быть либо связаны с какой-нибудь конкретной
		  работой, либо нет (например, вопросы общего характера, помощь по работе
		  с системой и т.п.).</p>
		<p>В первом случае вы должны посылать сообщения из разделов, где фигурирует
		  данная работа (<a href="#new_message">см. выше</a>). Во втором &#8212; через
		  <a href="#add_question">форму отправки</a> в конце этого раздела. </p>
		<p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">вверх</a></p>
          <h4><li><a name="add_profit"></a>Есть ли у вас какие-нибудь дополнительные
              выгоды для исполнителей <a href="http://diplom.com.ru/job.htm">Diplom.com.ru</a>?</li>
        </h4>
        <p>Да. Все написанные исполнителями работы в рамках проекта <a href="http://diplom.com.ru/">Diplom.com.ru</a> так
            же остаются в их собственности (помимо прямых выплат за их создание).
            Исполнители получают эксклюзивное право их продажи на нашей торговой
          площадке, если решат разместить их там. </p>
        <p><a href="#top"><img src="../../images/arrows/arrow_sm_up_blue.gif" width="14" height="12" hspace="2" border="1" align="absmiddle">вверх</a></p>
      </ol>
      <a name="add_question"></a>
      <table width="100%" cellpadding="6"  cellspacing="1" bgcolor="#CCCCCC">
        <tr bgcolor="#F5F5F5">
          <td width="100%" bgcolor="#FFFFFF"><h3><b> Добавьте свой вопрос. </b></h3>
            Мы постараемся ответить на него в течение 24 часов            </td>
        </tr>
        <tr bgcolor="#F5F5F5">
          <td bgcolor="#DEFFCE"><p>.<span class="red"><strong>Внимание!</strong></span><br>
            Пожалуйста, не
              задавайте в этом разделе вопросы по какому-либо <strong>конкретному</strong> заказу.
              Делайте это <a href="#new_message">на страницах, где данные заказы
              фигурируют</a>. Данный раздел предназначен для ответов на общие
            вопросы. </p></td>
        </tr>
        <tr valign="top" bgcolor="#F5F5F5">
          <td nowrap bgcolor="#F5F5F5" id="radios" class="arial"><strong>Тема вопроса: </strong>
		  <input name="tip_mess" type="radio" value="Вопрос оплаты"
		   onClick="visitorStat=1; this.parentNode.style.backgroundColor='';">Вопросы оплаты 
          <input name="tip_mess" type="radio" value="Технические проблемы" 
		   onClick="visitorStat=1; this.parentNode.style.backgroundColor='';">Технические проблемы 
          <input name="tip_mess" type="radio" value="Другое" 
		  onClick="visitorStat=1; this.parentNode.style.backgroundColor='';">Другое             
		  </td>
        </tr>
        <tr valign="top" bgcolor="#F5F5F5">
          <td nowrap bgcolor="#E4E4E4"><span class="arial">Ваш вопрос:</span> <br>
            <textarea name="letter" rows="10" id="letter" style="width:100%"></textarea>
            <br>
            <input type="submit" name="Submit" value="Отправить вопрос!">
            <input name="fl" type="hidden" id="fl" value="send"></td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
}//end work
?>