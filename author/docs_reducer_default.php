<div style="width:959px; padding:20px 0px 20px 20px;"><h3><? if ($test_header){?>Заголовок<? }

	$point=($_REQUEST['point'])? $_REQUEST['point']:"purpose";
	
	switch ($point)  { 

    	case "purpose":
  	  		?>Предназначение программы<? 
	    		break;
		case "howitworks":
			?>Как это работает<?
				break;
		case "download":
			?>Скачать программу DoscReducer<?
				break;

	}?></h3><? include ("docs_reducer_".$point.".php");?></div>
