<style type="text/css">
tr#authors_menu td {
	padding-right: 14px;
	padding-left: 14px;
	border:solid 1px #003399;
}
tr#authors_menu td a {
	color:#FFF;
}
td#active_section {
	background-color: F4F4FF;
	border-bottom:none !important;
	border-top:solid 1px #003399;
}
td#active_section a { 
	color:#000 !important;
	font-weight:bold;
}
</style><?   

if ($test_header){?><h2>��������� ������</h2><? }

$active_section=$_REQUEST['section'];
if ( $active_section=="authors" ||
	 $active_section=="author_agreement" ||
	 $active_section=="faq_authors"
   ){ $active_style=' id="active_section"';?>
<table cellpadding="0" cellspacing="0">
      <tr>
        <td><img src="<?=$_SESSION['SITE_ROOT']?>images/author_woman.jpg" width="160" height="113" hspace="10" vspace="19" align="absmiddle"></td>
        <td width="100%" valign="bottom" class="paddingTop4" style="padding-bottom:19px;"><h2 class="sectionHeader" style="margin-left:8px; margin-bottom:12px;">�������</h2>
		  <table width="100%" cellpadding="7" cellspacing="0">
		    <tr id="authors_menu" bgcolor="#003399" class="borderBottom1 borderTop1 borderLeft">
		      <td<? if ($active_section=="authors") echo $active_style;?>><a href="?section=authors">��������������</a></td>
		      <td<? if ($active_section=="author_agreement") echo $active_style;?>><a href="?section=author_agreement">����������</a></td>
		      <td<? if ($active_section=="faq_authors") echo $active_style;?>><a href="?section=faq_authors">FAQ</a></td>
		      <td><a href="?section=register">�����������</a></td>
		      <td nowrap="nowrap"><a href="author/"><img src="<?=$_SESSION['SITE_ROOT']?>images/home.gif" width="14" height="14" hspace="4" border="0" align="absmiddle" />���� � �������</a></td>
		      <td width="100%" bgcolor="#FFFFFF" style="border-top:none; border-right:none;">&nbsp;</td>
	        </tr>
		    <tr class="borderLeft">
		      <td colspan="6" background="" bgcolor="#F4F4FF" style="border:solid 1px #003399; border-top:none;">&nbsp;</td>
	        </tr>
	      </table>
</td>
      </tr>
    </table>
<?
}else{
	
	if($active_section=="faq"){?>
<table cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="<?=$_SESSION['SITE_ROOT']?>images/customer_thinking.jpg" width="98" height="113" hspace="10" vspace="20" align="absmiddle"></td>
        <td nowrap><h2 class="sectionHeader">FAQ</h2><b>��������!</b><BR />
		������ ������ �������� ������ �������� � ������� ��� ����������. 
		<BR />���� �� &#8212; �����, FAQ ��� ��� <a href="?section=authors">�����</a>.</td>
      </tr>
</table>
<?  }else{
	
		if ($active_section=="customer") {
			
			?><span class="txt130 bold arial" style="color:#006;"><img src="<?=$_SESSION['SITE_ROOT']?>images/cabinet_open.png" vspace="20" align="absmiddle">������ ������� ���������</span><?	
			$xtra_class=" padding0 paddingLeft20";
			$go_customer_dir="customer/default";
			
		
		}else{?><h2 class="sectionHeader<?=$xtra_class?>"><?

			switch ($active_section) { //

				case "useful":
				  ?>��������<?
					break;
				case "agreement":
				  ?>���������� �� �������<?
					break;
				case "sale":
				  ?>������� ����������� �����<?
					break;
				case "payment":
				  ?>������� ������<?
				  $active_section="sections/$active_section";
					break;
				case "partnership":
				  ?>��������������<?
					break;
		    } ?></h2><?  
		}
	}
}
if ($go_customer_dir) $active_section=$go_customer_dir; //echo "<h5>active_section= $active_section</h5>";
include($active_section.".php"); ?>