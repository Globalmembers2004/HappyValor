<?php
date_default_timezone_set('America/Lima');

class Db {
	private $link;
	private $stmt;
	private $array;

	var $host = '';
    /**
     * Username used to connect to database
     */
    var $port = '';
    /**
     * Port used to connect to database
     */
    var $username = '';
    /**
     * Password used to connect to database
     */
    var $passwd = '';
    /**
     * Database to backup
     */
    var $dbName = '';


	public function Db()
	{
		
	}

	private function conectar()
	{
		if (($_SERVER['SERVER_NAME'] == 'localhost') || ($_SERVER['SERVER_NAME'] == '127.0.0.1')){
			$host = '127.0.0.1';
			$port = '5432';
			$user = 'postgres';
			$password = '123@abc';
			$db = 'globalme_condominio';
		}
		else {
			$host = 'localhost';
			$port = '5432';
			$user = 'globalmembers';
			$password = 'Il17051995';
			$db = 'globalme_condominio';
		}
		
		$this->host     = $host;
		$this->port     = $port;
        $this->username = $user;
        $this->passwd   = $password;
        $this->dbName   = $db;

		$conn = pg_connect('host='.$host.' port='.$port.' dbname='.$db.' user='.$user.' password='.$password);
		pg_set_client_encoding($conn, "UTF8");
		
		$this->link = $conn;
	}

	private function desconectar()
	{
		pg_close($this->link);
	}

	private function obtener_filas($stmt)
	{
		$fetchrow = array();

		while ($row = pg_fetch_array($stmt, NULL, PGSQL_ASSOC))
			$fetchrow[] = $row;

		$this->array = $fetchrow;
		return $this->array;
	}

	public function exec_sp_select($sp_name, $sp_params)
	{
		$strsql = 'SELECT * FROM '.$sp_name.' (';

		if (is_array($sp_params))
			$strsql .= '\'' . implode($sp_params, '\', \'') . '\'';	
		
		$strsql .= ')';

		$this->conectar();
		
		$rs_output = pg_query($this->link, $strsql);
		$result = $this->obtener_filas($rs_output);
		$this->stmt = $rs_output;
		pg_free_result($rs_output);

		/*echo $strsql;*/
		echo pg_last_error($this->link);

		$this->desconectar();

		return $result;
	}

	public function exec_sp_iud($sp_name, $sp_params, $sp_output = '')
	{
		$strsql = 'CALL '.$sp_name.' (';

		if (is_array($sp_params))
			$strsql .= '\'' . implode($sp_params, '\', \'') . '\'';
		else
			$strsql .= '\'' .$sp_params . '\'';

		if ($sp_output != '')
			$strsql .= ', '.$sp_output;

		$strsql .= ')';

		$this->conectar();
		
		if ($sp_output != ''){
			$rsproc = mysqli_multi_query($this->link, $strsql.'; SELECT '.$sp_output.';');
			mysqli_next_result($this->link);
			$rs_output = mysqli_store_result($this->link);
			$result = $this->obtener_filas($rs_output);
			
			$this->stmt = $rs_output;
			mysqli_free_result($rs_output);
		}
		else {
			$this->stmt = mysqli_query($this->link, $strsql);
			$result = array(array('rpta' => 1));
		}
		
		/*echo $strsql;
		echo mysqli_error($this->link);*/

		$this->desconectar();

		return $result;
	}
}
?>