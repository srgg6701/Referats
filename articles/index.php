<?

//
//
//
//
//

switch ($_REQUEST['article'])
  { //3 дня до сдачи диплома
	case "3days_remaining":
  	  $header="До сдачи диплома осталось 3 дня... У кого просить помощи?!";
  	  $img_src="writers/srgg-1.jpg";
  	  $subheader="Делаем
      возможным 
      невозможное вместе с Сергеем Клевцовым.";
  	  //$annotation="";
	    break;
	//как стать жертвой обмана
  	case "affair":
  	  $header='Как стать жертвой
        обмана при заказе диплома, курсовой или реферата...<br>
<span class="txtRed" style="font-size:85%;font-weight:200;">...или &#8212; не стать, зависит от вас!</span>';
  	  //$img_src="";
  	  //$subheader="";
  	  //$annotation="";
	    break;
  	//если препод неровно дышит
	case "bad_teacher":
  	  $header="Что делать, если преподаватель к вам «неравнодушен»?";
  	  $img_src="writers/bad_teacher.jpg";
  	  $subheader="Выход
      из щекотливго положения ищет Наталья Бирюкова.";
  	  //$annotation="";
	    break;
	//курсовая на отлично
	case "cursovik":
  	  $header="Курсовая на отлично – это легко!";
  	  $img_src="writers/course2.jpg";
  	  $subheader="штат
      отличников набирает Жанна
      Стрельцова";
  	  //$annotation="";
	    break;
	//написать отличный диплом
	case "diplom":
  	  $header="Как написать дипломную работу на 5 баллов.";
  	  //$img_src="";
  	  $subheader="То, что будет актуальным всегда...";
  	  //$annotation="";
	    break;
	//плагиат
  	case "plagiat":
  	  $header="Почему не ст&oacute;ит заниматься плагиатом.";
  	  $img_src="writers/p2.jpg";
  	  $subheader="Разбираться будет Наташа Бирюкова. Ссылки на источники прилагаются! :)";
  	  $annotation="Идея - это самая ценная интеллектуальная собственность.<br>
  Интересная идея требует качественной защиты от плагиата.";
	    break;	
	//реферат	
	case "referat":
  	  $header="Этапы правильного написания рефератов";
  	  $img_src="writers/joanne.jpg";
  	  $subheader="Инструктор по ходьбе &#8212; Жанна Стрельцова :)";
  	  //$annotation="";
	    break;
	//
	case "recruits":
  	  $header="Как заработать деньги после защиты диплома или курсовой работы.";
  	  //$img_src="";
  	  //$subheader="";
  	  //$annotation="";
	    break;
	//как отличить хороший сервис от плохого
	case "services":
  	  $header="Анализируем качество web-ресурса.";
  	  $img_src="writers/srgg-rose_dusk.gif";
  	  $subheader="Отделяем
      зёрна от плевел вместе
      с Сергеем Клевцовым.";
  	  //$annotation="";
	    break;
	//добавить ссылку в соц.сети
	case "set_distributor_link":
  	  $header="<img src=\"$_SESSION[SITE_ROOT]images/illustrations/money_guy.png\" width=\"170\" height=\"113\" align=\"left\" hspace=\"10\" />Как сделать<br> <span class='txtGreen'>ЧУЖИЕ</span> творческие работы<br> источником <b class='txtOrange'>СВОЕГО</b> дохода";
  	  //$img_src='illustrations/money_guy.png" width="170" height="113" ';
  	  $subheader="";
  	  $annotation="";
  	  $text='';
	    break;
	default: $header="Все статьи";
  } ?>
<h2 class="sectionHeader"><? 
  if ($test_header){?>Заголовок статьи<? }
  if ($header) echo $header;?></h2>
<?  
  if ($img_src){?>
	<b class="txt100"><img src="<?=$_SESSION['SITE_ROOT']?>images/<?=$img_src?>" hspace="22" vspace="2" align="left"><i><? 
	  if ($test_subheader){?>Подзаголовок статьи<? }
	  if ($subheader) echo $subheader;?></i></b><?	 
  }
  if ($subheader||$annotation) {?>      
      <hr size="1" noshade color="#003399"><?
  }
  if ($annotation){?>
      <div align="right"><strong><?
      	if ($test_annotation){?>Текст аннотации.<? }
	  	if ($annotation) echo $annotation;?></strong></div><?
  }
  if ($test_text) {?><p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed 

		diam nonumy eirmod tempor invidunt ut labore et dolore magna 

		aliquyam erat, sed diam voluptua. At vero eos et accusam et 

		justo duo dolores et ea rebum. Stet clita kasd gubergren, no 

		sea takimata sanctus est Lorem ipsum dolor sit amet.</p><?
  }
  if ($_REQUEST['article']!="all") include ("text_".$_REQUEST['article'].".php");
  if ($article=="plagiat"){?>
  <div>
    <p><strong class="txt120">Внимание! </strong> </p>
      <p>При перепечатке/цитировании данной статьи, ссылка на источник
<script language="JavaScript" type="text/JavaScript">
document.write('(<a href="'+location.href+'">'+location.href+'</a>)');
</script> обязательна! </p>
  </div><? 
}
if ($_REQUEST['article']!="all"){?>
<br />
<hr noshade>
<br />  
  <strong>Все статьи:</strong><? 
}	
if (isset($_REQUEST['go_community_lab'])) $go_community_link="go_community_lab=1&";?>
  	          <ul class="allarticles">
  	            <li><a href="?<?=$go_community_link?>article=referat">Этапы правильного написания рефератов.</a></li>
  	            <li><a href="?<?=$go_community_link?>article=cursovik">Курсовая на отлично – это легко!</a></li>
  	            <li class="allarticles"><a href="?<?=$go_community_link?>article=diplom">Как написать дипломную работу на 5 баллов.</a></li>
  	            <li><a href="?<?=$go_community_link?>article=services">Анализируем качество web-ресурса.</a></li>
  	            <li><a href="?<?=$go_community_link?>article=plagiat">Почему не стoит заниматься плагиатом.</a></li>
  	            <li><a href="?<?=$go_community_link?>article=3days_remaining">До сдачи диплома осталось
  	              3 дня... У кого просить помощи?!</a></li>
  	            <li><a href="?<?=$go_community_link?>article=affair">Как стать жертвой обмана при заказе
  	              диплома, курсовой или реферата...</a></li>
  	            <li><a href="?<?=$go_community_link?>article=bad_teacher">Что делать, если преподаватель
  	              к вам &laquo;неравнодушен&raquo;?</a></li>
  	            <li><a href="?<?=$go_community_link?>article=recruits">Как заработать деньги после защиты
  	              диплома или курсовой работы.</a></li>
  	            <li><a href="?<?=$go_community_link?>article=set_distributor_link">Как сделать ЧУЖИЕ творческие работы источником СВОЕГО дохода</a></li>
  </ul>
  <br />