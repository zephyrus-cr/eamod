<?php
	class sql {
		var $link;
		var $lastdb;

		function sql($dbhost, $dbuser, $dbpassword)
		{
			$lastdb = '';
			$this->link = mysql_connect($dbhost, $dbuser, $dbpassword)
				OR die('MySQL Coneccion Error...');
		}

		function query($query, $database)
		{
			if ($this->lastdb != $database)
			{
				mysql_select_db($database, $this->link);
				$this->lastdb = $database;
			}

			if ($result = mysql_query($query,$this->link))
				return $result;
			die('MySQL Query Error at ' . $query);
		}

		function countrows($result)
		{
			return mysql_num_rows($result);
		}

		function fetchrow($result)
		{
			return mysql_fetch_row($result);
		}

		function fetcharray($result, $type = MYSQL_ASSOC)
		{
			return mysql_fetch_array($result,$type);
		}

		function escapestr($string)
		{
			return mysql_escape_string($string);
		}

		function freeresult($result)
		{
			mysql_free_result($result);
		}

	}
?>