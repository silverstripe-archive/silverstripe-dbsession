<?php

class DatabaseSessionHandler {
	function activate() {
		session_set_save_handler(
			array($this,"session_open"), 
			array($this, "session_close"), 
			array($this,"session_read"), 
			array($this,"session_write"), 
			array($this,"session_destroy"),
			array($this, "session_gc")
		);
	}
	
    function session_open($session_path, $session_name) {
        return true;
    }

    function session_close() {
        return true;
    }

    function session_read($session_id) {
        $session_id = Convert::raw2sql($session_id);
        $result = DB::query("SELECT \"Data\" FROM \"DatabaseSessionStore\" WHERE \"SessionID\" = '$session_id'");
        if ($result->numRecords() == 0) {
        	return '';
        } else {
            $result = $result->nextRecord();
            $session_data = $result['Data'];
            return $session_data;
        }
    }

    function session_write($sessionID, $data) {
    	$SQL_sessionID = Convert::raw2sql($sessionID);
        $SQL_data = Convert::raw2sql($data);
        $SQL_ip = Convert::raw2sql($_SERVER['REMOTE_ADDR']);

        DB::query("DELETE FROM \"DatabaseSessionStore\" WHERE \"SessionID\" = '$SQL_sessionID'");
        DB::query("INSERT INTO \"DatabaseSessionStore\" (\"SessionID\", \"Data\", \"IP\", 
			\"LastUsedTimestamp\") VALUES ('$SQL_sessionID', '$SQL_data', '$SQL_ip',".time().")");
        return true;
    }

    function session_destroy($session_id) {
        $session_id = mysql_real_escape_string($session_id);
        DB::query("DELETE FROM \"DatabaseSessionStore\" WHERE \"SessionID\" = '$session_id'");
        return true;
    }

    function session_gc($session_max_life) {
        $current_time = time();
        $session_max_life = (int)$session_max_life;
        DB::query("DELETE FROM \"DatabaseSessionStore\" WHERE \"LastUsedTimestamp\" + $session_max_life < $current_time");
        //DB::query("OPTIMIZE TABLE `DBSessions`");                   
        return true;
    }
}

