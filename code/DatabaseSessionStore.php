<?php

/**
 * A table for storing session session information in the database
 */
class DatabaseSessionStore extends DataObject {
	static $db = array(
		"SessionID" => "Varchar",
		"Data" => "Text",
		"IP" => "Varchar(15)",
		"LastUsedTimestamp" => "Int",
		
	);
	static $indexes = array(
		"SessionID" => true,
		"LastUsedTimestamp" => true,
	);
}