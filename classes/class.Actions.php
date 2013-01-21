<?

class Actions {

	function addStatRecord( $table,
							$record_id,
                            $query_type, 
                            $mode, 
                            $initiator, //
                            $initiator_id //
						  ) {	
		
		global $catchErrors;
		
		if (!$initiator) $initiator=$_SESSION['S_USER_TYPE'];
		if (!$initiator_id) $initiator_id=$_SESSION['S_USER_ID'];
		if (!$record_id&&mysql_insert_id()) $record_id=mysql_insert_id();
		
		//stat:
		$catchErrors->insert("INSERT INTO ri_statistics ( `datatime`, 
                            `table`, 
                            `record_id`, 
                            `query_type`, 
                            `mode`, 
                            `initiator`, 
                            `initiator_id` 
                          ) VALUES (  
                            '".date("Y-m-d H:i:s")."', 
                            '$table', 
                            '$record_id', 
                            '$query_type', 
                            '$mode', 
                            '$initiator', 
                            '$initiator_id'
                          )");
	}
}?>