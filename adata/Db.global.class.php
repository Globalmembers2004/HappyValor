<?php
date_default_timezone_set('America/Lima');

class DbGlobal {
	private $link;
	private $stmt;
	private $array;

	var $host = '';
    /**
     * Username used to connect to database
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


	public function DbGlobal()
	{
		
	}

	private function conectar()
	{
		if (($_SERVER['SERVER_NAME'] == 'localhost') || ($_SERVER['SERVER_NAME'] == '127.0.0.1')){
			$host='127.0.0.1';
			$user='root';
			$password='123@abc';
			$db='globalmembers';
		}
		else {
			$host='localhost';
			// $user='globalme_global';
			// $password='Il17051995';
			// $db='globalme_ralpha';
			$user='tamboapp_global';
			$password='Il17051995';
			$db='tamboapp_ralpha';
		}
		
		$this->host     = $host;
        $this->username = $user;
        $this->passwd   = $password;
        $this->dbName   = $db;
		
		$this->link=mysqli_connect($host, $user, $password, $db);

		//mysqli_select_db($this->link, $db);

		@mysqli_query($this->link, "SET NAMES 'utf8'");
	}

	private function desconectar()
	{
		mysqli_close($this->link);
	}

	private function obtener_filas($stmt)
	{
		$fetchrow = array();

		while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC))
			$fetchrow[] = $row;

		$this->array = $fetchrow;
		return $this->array;
	}

	private function lastID()
	{
		return mysqli_insert_id($this->link);
	}

	public function ejecutar($sql)
	{
		$this->conectar();

		$this->stmt=mysqli_query($this->link, $sql);

		/*echo $sql;
		*/
		echo mysqli_error($this->link);
		return $this->stmt;
	}

	public function exec_sp_select($sp_name, $sp_params)
	{
		$strsql = 'CALL '.$sp_name.' (';

		if (is_array($sp_params))
			$strsql .= '\'' . implode($sp_params, '\', \'') . '\'';	
		
		$strsql .= ')';

		$this->conectar();
		
		$rs_output = mysqli_query($this->link, $strsql);
		echo mysqli_error($this->link);
		$result = $this->obtener_filas($rs_output);
		$this->stmt = $rs_output;
		mysqli_free_result($rs_output);

		//echo $strsql;
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
			echo mysqli_error($this->link);
			mysqli_next_result($this->link);
			$rs_output = mysqli_store_result($this->link);
			$result = $this->obtener_filas($rs_output);
			
			$this->stmt = $rs_output;
			mysqli_free_result($rs_output);
		}
		else {
			$this->stmt = mysqli_query($this->link, $strsql);
			echo mysqli_error($this->link);
			$result = array(array('rpta' => 1));
		}
		
		/*echo $strsql;
		*/
		$this->desconectar();

		return $result;
	}

	public function multiQuery($sql)
	{
		$this->conectar();

		$this->stmt=mysqli_multi_query($this->link, $sql);

		/*echo $sql;
		echo mysqli_error($this->link);*/
		$this->desconectar();
		return $this->stmt;
	}
	
	public function show_tables($param='')
	{
		$strsql = ' SHOW TABLES ';

		$this->conectar();

		$rs = $this->ejecutar($strsql);

		$resultado = $this->obtener_filas($rs);

		//echo $strsql;
		echo mysqli_error($this->link);
		$this->desconectar();
		return $resultado;
	}

	public function set_select($fields, $table, $where = false, $orderby = false, $groupby = false, $limit = false)
	{
		$this->conectar();

		if (is_array($fields))
			$fields = '' . implode($fields, ', ') . '';

		$groupby = ($groupby) ? ' GROUP BY ' . $groupby : '';
		$orderby = ($orderby) ? ' ORDER BY ' . $orderby : '';
		$limit = ($limit) ? ' LIMIT ' . $limit : '';
		$where = ($where) ? ' WHERE ' . $where : '';
		$strsql = 'SELECT ' . $fields . ' FROM ' . $table . '' . $where . $groupby . $orderby . $limit;
		
		$rs = $this->ejecutar($strsql);
		$resultado = $this->obtener_filas($rs);

		/*echo $strsql;
		*/
		echo mysqli_error($this->link);
		$this->desconectar();
		return $resultado;
	}

	public function set_insert(array $values, $table)
	{
		$result = 0;

		if (count($values) < 0)
			return false;

		foreach($values as $field => $val){
			$val = '\''.$val.'\'';
			$values[$field] = $val; 
		}

		$strsql = 'INSERT INTO '.$table.' ('.implode(array_keys($values), ', ').') VALUES ('.implode($values, ', ').')';
		$rs = $this->ejecutar($strsql);

		/*echo $strsql;
		*/
		echo mysqli_error($this->link);

		if ($rs)
			$result = $this->lastID();
		else
			$result = 0;

		$this->desconectar();
		return $result;
	}

	public function set_update($values, $table, $where = false)
	{
		$result = 0;

		if (is_array($values)) {
			if (count($values) < 0)
				return false;

			$fields = array();

			foreach($values as $field => $val){
				$val = '\''.$val.'\'';
				$fields[] = $field.' = '.$val;
			}
			$strsql = 'UPDATE '.$table.' SET '.implode($fields, ', ');
		}
		else
			$strsql = 'UPDATE '.$table.' SET '.$values;

		$where = ($where) ? ' WHERE '.$where : '';
		$strsql = $strsql.$where;
		
		$rs = $this->ejecutar($strsql);

		/*echo $strsql;
		*/
		echo mysqli_error($this->link);

		if ($rs)
			$result = $rs;
		else
			$result = 0;

		$this->desconectar();
		return $result;
	}

	public function set_delete($table, $where = false)
	{
		$result = 0;
		$where = ($where) ? ' WHERE ' . $where : '';
		$strsql = 'DELETE FROM '.$table.$where;

		$rs = $this->ejecutar($strsql);

		//echo $strsql;
		echo mysqli_error($this->link);

		if ($rs)
			$result = $rs;
		else
			$result = 0;

		$this->desconectar();
		return $result;
	}
}
?>