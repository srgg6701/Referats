<?

//
//
//
//
//

switch ($_REQUEST['article'])
  { //3 ��� �� ����� �������
	case "3days_remaining":
  	  $header="�� ����� ������� �������� 3 ���... � ���� ������� ������?!";
  	  $img_src="writers/srgg-1.jpg";
  	  $subheader="������
      ��������� 
      ����������� ������ � ������� ���������.";
  	  //$annotation="";
	    break;
	//��� ����� ������� ������
  	case "affair":
  	  $header='��� ����� �������
        ������ ��� ������ �������, �������� ��� ��������...<br>
<span class="txtRed" style="font-size:85%;font-weight:200;">...��� &#8212; �� �����, ������� �� ���!</span>';
  	  //$img_src="";
  	  //$subheader="";
  	  //$annotation="";
	    break;
  	//���� ������ ������� �����
	case "bad_teacher":
  	  $header="��� ������, ���� ������������� � ��� �������������?";
  	  $img_src="writers/bad_teacher.jpg";
  	  $subheader="�����
      �� ���������� ��������� ���� ������� ��������.";
  	  //$annotation="";
	    break;
	//�������� �� �������
	case "cursovik":
  	  $header="�������� �� ������� � ��� �����!";
  	  $img_src="writers/course2.jpg";
  	  $subheader="����
      ���������� �������� �����
      ����������";
  	  //$annotation="";
	    break;
	//�������� �������� ������
	case "diplom":
  	  $header="��� �������� ��������� ������ �� 5 ������.";
  	  //$img_src="";
  	  $subheader="��, ��� ����� ���������� ������...";
  	  //$annotation="";
	    break;
	//�������
  	case "plagiat":
  	  $header="������ �� ��&oacute;�� ���������� ���������.";
  	  $img_src="writers/p2.jpg";
  	  $subheader="����������� ����� ������ ��������. ������ �� ��������� �����������! :)";
  	  $annotation="���� - ��� ����� ������ ���������������� �������������.<br>
  ���������� ���� ������� ������������ ������ �� ��������.";
	    break;	
	//�������	
	case "referat":
  	  $header="����� ����������� ��������� ���������";
  	  $img_src="writers/joanne.jpg";
  	  $subheader="���������� �� ������ &#8212; ����� ���������� :)";
  	  //$annotation="";
	    break;
	//
	case "recruits":
  	  $header="��� ���������� ������ ����� ������ ������� ��� �������� ������.";
  	  //$img_src="";
  	  //$subheader="";
  	  //$annotation="";
	    break;
	//��� �������� ������� ������ �� �������
	case "services":
  	  $header="����������� �������� web-�������.";
  	  $img_src="writers/srgg-rose_dusk.gif";
  	  $subheader="��������
      ���� �� ������ ������
      � ������� ���������.";
  	  //$annotation="";
	    break;
	//�������� ������ � ���.����
	case "set_distributor_link":
  	  $header="<img src=\"$_SESSION[SITE_ROOT]images/illustrations/money_guy.png\" width=\"170\" height=\"113\" align=\"left\" hspace=\"10\" />��� �������<br> <span class='txtGreen'>�����</span> ���������� ������<br> ���������� <b class='txtOrange'>������</b> ������";
  	  //$img_src='illustrations/money_guy.png" width="170" height="113" ';
  	  $subheader="";
  	  $annotation="";
  	  $text='';
	    break;
	default: $header="��� ������";
  } ?>
<h2 class="sectionHeader"><? 
  if ($test_header){?>��������� ������<? }
  if ($header) echo $header;?></h2>
<?  
  if ($img_src){?>
	<b class="txt100"><img src="<?=$_SESSION['SITE_ROOT']?>images/<?=$img_src?>" hspace="22" vspace="2" align="left"><i><? 
	  if ($test_subheader){?>������������ ������<? }
	  if ($subheader) echo $subheader;?></i></b><?	 
  }
  if ($subheader||$annotation) {?>      
      <hr size="1" noshade color="#003399"><?
  }
  if ($annotation){?>
      <div align="right"><strong><?
      	if ($test_annotation){?>����� ���������.<? }
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
    <p><strong class="txt120">��������! </strong> </p>
      <p>��� �����������/����������� ������ ������, ������ �� ��������
<script language="JavaScript" type="text/JavaScript">
document.write('(<a href="'+location.href+'">'+location.href+'</a>)');
</script> �����������! </p>
  </div><? 
}
if ($_REQUEST['article']!="all"){?>
<br />
<hr noshade>
<br />  
  <strong>��� ������:</strong><? 
}	
if (isset($_REQUEST['go_community_lab'])) $go_community_link="go_community_lab=1&";?>
  	          <ul class="allarticles">
  	            <li><a href="?<?=$go_community_link?>article=referat">����� ����������� ��������� ���������.</a></li>
  	            <li><a href="?<?=$go_community_link?>article=cursovik">�������� �� ������� � ��� �����!</a></li>
  	            <li class="allarticles"><a href="?<?=$go_community_link?>article=diplom">��� �������� ��������� ������ �� 5 ������.</a></li>
  	            <li><a href="?<?=$go_community_link?>article=services">����������� �������� web-�������.</a></li>
  	            <li><a href="?<?=$go_community_link?>article=plagiat">������ �� ��o�� ���������� ���������.</a></li>
  	            <li><a href="?<?=$go_community_link?>article=3days_remaining">�� ����� ������� ��������
  	              3 ���... � ���� ������� ������?!</a></li>
  	            <li><a href="?<?=$go_community_link?>article=affair">��� ����� ������� ������ ��� ������
  	              �������, �������� ��� ��������...</a></li>
  	            <li><a href="?<?=$go_community_link?>article=bad_teacher">��� ������, ���� �������������
  	              � ��� &laquo;������������&raquo;?</a></li>
  	            <li><a href="?<?=$go_community_link?>article=recruits">��� ���������� ������ ����� ������
  	              ������� ��� �������� ������.</a></li>
  	            <li><a href="?<?=$go_community_link?>article=set_distributor_link">��� ������� ����� ���������� ������ ���������� ������ ������</a></li>
  </ul>
  <br />