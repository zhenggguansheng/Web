<?php
    //!function_exists('readover') && exit('Forbidden');
    class DbDriver
    {
        var $sql = 0;
        var $db_host;
	    var $db_port;
        var $db_user;
        var $db_pwd;
        var $db_name;
        var $db_charset;
	    var $db_pconnect = 0;

        function DbDriver($db_host, $db_port, $db_user, $db_pwd, $db_name, $db_charset)
	    {
		    $this->db_host = $db_host.':';
		    $this->db_port = $db_port;
		    $this->db_user = $db_user;
		    $this->db_name = $db_name;
		    $this->db_pwd = $db_pwd;
		    $this->db_charset = $db_charset;
		    $this->lp = & $GLOBALS['db_lp'];
		    $this->Connect();
	    }

        function Connect()
        {
            list($db_host, $db_port) = explode(':', $this->db_host);
            !$db_port && $db_port = 3306;
	    	$this->sql = mysqli_init();
	    	mysqli_real_connect($this->sql, $db_host, $this->db_user, $this->db_pwd, false, $db_port);
	    	mysqli_errno($this->sql) != 0 && $this->Halt('Connect(' . $this->db_pconnect . ') to MySQL failed');
	    	$serverinfo = mysqli_get_server_info($this->sql);
            if($serverinfo > '4.1' && $this->db_charset)
            {
                mysqli_query($this->sql, "SET character_set_connection=" . $this->db_charset . ",character_set_results=" . $this->db_charset . ",character_set_client=binary");
            }
            if($serverinfo > '5.0')
	    	{
                mysqli_query($this->sql, "SET sql_mode=''");
	    	}
            if($this->db_name && !@mysqli_select_db($this->sql, $this->db_name))
            {
	    	    $this->Halt('Cannot use database');
	    	}
	    }
		
		function SelectDb($dbname)
		{
		    if (!@mysqli_select_db($this->sql, $dbname))
			{
			    $this->Halt('Cannot use database');
			}
		}
		
        function ServerInfo()
		{
		    return mysqli_get_server_info($this->sql);
		}

        function InsertId()
	    {
		    return mysqli_insert_id($this->sql);
	    }
		
        function GetValue($SQL, $result_type = MYSQLI_NUM, $field = 1)
        {
            $query = $this->Query($SQL);
            $rt = $this->FetchArray($query, $result_type);
            return isset($rt[$field]) ? $rt[$field] : false;//如果$rt[index] 没有被设置  则返回false
        }
		
		function GetOne($SQL, $result_type = MYSQLI_ASSOC)
		{
		    $Query = $this->Query($SQL, 'Q');
			$rt = $this->FetchArray($query, $result_type);
			return $rt;
		}
		
		function Update($SQL, $lp = 1)
		{
		    if ($this->lp == 1 && $lp)
			{
			    $tmpsql6 = substr($SQL, 0, 6);
				$SQL = strtoupper($tmpsql6 . 'E') == 'REPLACE' ? 'REPLACE LOW_PRIORITY' . substr($SQL, 7) : $tmpsql6 . ' LOW_PRIORITY' . substr($SQL, 6);
			}
			return $this->Query($SQL, 'U');
		}
		
		
		function Query($SQL, $method = null, $error = true)
		{
		    $originalSQL = $SQL;
			$query = @mysqli_query($this->sql, $SQL, ($method ? MYSQLI_USE_RESULT : MYSQLI_STORE_RESULT));
			if (in_array(mysqli_errno($this->sql), array(2006, 2013)) && empty($query) && !defined('QUERY'))
			{
			    define('QUERY', true);
				@mysqli_close($this->sql);
				sleep(2);
				$this->connect();
				$query = $this->query($SQL);
			}
		    //$method != ('U') && ($this->query_num++);
			!$query && $error && $this->Halt('Query Error: ' . $SQL);
			return $query;
		}

/**
*将查询的数据库语句结果，以数组的形式返回 
*例如 ： $result['username']
*索引类型 ： MYSQLI_ASSOC
*/
        function FetchArray($query, $result_type = MYSQLI_ASSOC)
		{
            return mysqli_fetch_array($query, $result_type);
		}

/**
*返回前一次 MySQL 操作所影响的记录行数
*/
        function AffectedRows()
		{
		    return mysqli_affected_rows($this->sql);
		}

/**
*返回查询结果的行数
*/
        function NumOfRows($query)
		{
		    return !is_bool($query) ? @mysqli_num_rows($query) : 0;
		}

/**
*返回查询结果的列数
*/
        function NumOfFields($query)
        {
            return mysqli_num_fields($query);
        }

/**
*转义 SQL 语句中使用的字符串中的特殊字符
*例如：将 $SQL 中的“'”转定义为“\'”
*有效防止SQL注入
*/
        function EscapeString($str)
        {
            return mysqli_real_escape_string($this->sql, $str);
        }

/**
*释放字符串空间
*/
        function FreeResult()
        {
            $void = func_get_args();
            foreach ($void as $query)
            {
                if ($query instanceof mysqli_result)
                {
                    mysqli_free_result($query);
                }
            }
        }

/**
*关闭mysqli的链接
*/
        function Close($linkid)
        {
            return @mysqli_close($linkid);
        }

/**
*错误信息
*/
        function Halt($msg = null)
        {
            new DbError($msg);
			require_once("include/db_mysqli.inc");
        }
    }
?>