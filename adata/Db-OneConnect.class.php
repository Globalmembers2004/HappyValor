<?php
class DbOneConnect {
	// private $link;
	// private $stmt;
	// private $array;

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


	public function DbOneConnect()
	{
		
	}

	public function conectar()
	{
		if (($_SERVER['SERVER_NAME'] == 'localhost') || ($_SERVER['SERVER_NAME'] == '127.0.0.1')){
			$host = '127.0.0.1';
			$user = 'root';
			$password = '123@abc';
			$db = 'amafit';
		}
		else {
				$host = 'localhost';
				$user = 'adescorp_valoriz';
				$password = 're3fq.x(p8=}';
				$db = 'adescorp_valorizacion';
		}
		
		$this->host     = $host;
        $this->username = $user;
        $this->passwd   = $password;
        $this->dbName   = $db;
		
		$connect = mysqli_connect($host, $user, $password, $db);

		@mysqli_query($connect, "SET NAMES 'utf8'");

		return $connect;
	}

	public function desconectar($connect)
	{
		mysqli_close($connect);
	}

	public function obtener_filas($stmt)
	{
		$fetchrow = array();

		while ($row = mysqli_fetch_array($stmt, MYSQLI_ASSOC))
			$fetchrow[] = $row;

		// $this->array = $fetchrow;
		return $fetchrow;
	}

	public function lastID($connect)
	{
		return mysqli_insert_id($connect);
	}

	public function ejecutar($connect, $sql)
	{
		$stmt = mysqli_query($connect, $sql);
		echo mysqli_error($connect);
		
		return $stmt;
	}

	public function exec_sp_select($connect, $sp_name, $sp_params)
	{
		$strsql = 'CALL '.$sp_name.' (';

		if (is_array($sp_params))
			$strsql .= '\'' . implode($sp_params, '\', \'') . '\'';	
		
		$strsql .= ')';
		
		$rs_output = mysqli_query($connect, $strsql);
		$result = $this->obtener_filas($rs_output);
		// $this->stmt = $rs_output;
		mysqli_free_result($rs_output);

		//echo $strsql;
		
		echo mysqli_error($connect);
		return $result;
	}

	public function exec_sp_iud($connect, $sp_name, $sp_params, $sp_output = '')
	{
		$strsql = 'CALL '.$sp_name.' (';

		if (is_array($sp_params))
			$strsql .= '\'' . implode($sp_params, '\', \'') . '\'';
		else
			$strsql .= '\'' .$sp_params . '\'';

		if ($sp_output != '')
			$strsql .= ', '.$sp_output;

		$strsql .= ')';
		
		if ($sp_output != ''){
			$rsproc = mysqli_multi_query($connect, $strsql.'; SELECT '.$sp_output.';');
			echo mysqli_error($connect);
			mysqli_next_result($connect);
			$rs_output = mysqli_store_result($connect);
			$result = $this->obtener_filas($rs_output);
			
			// $this->stmt = $rs_output;
			mysqli_free_result($rs_output);
		}
		else {
			mysqli_query($connect, $strsql);
			echo mysqli_error($connect);
			$result = array(array('rpta' => 1));
		}
		
		/*echo $strsql;
		*/

		return $result;
	}

	public function set_select($connect, $fields, $table, $where = false, $orderby = false, $groupby = false, $limit = false)
	{

		if (is_array($fields))
			$fields = '' . implode($fields, ', ') . '';

		$groupby = ($groupby) ? ' GROUP BY ' . $groupby : '';
		$orderby = ($orderby) ? ' ORDER BY ' . $orderby : '';
		$limit = ($limit) ? ' LIMIT ' . $limit : '';
		$where = ($where) ? ' WHERE ' . $where : '';
		$strsql = 'SELECT ' . $fields . ' FROM ' . $table . '' . $where . $groupby . $orderby . $limit;
		
		$rs = $this->ejecutar($connect, $strsql);
		$resultado = $this->obtener_filas($rs);

		/*echo $strsql;
		*/
		echo mysqli_error($connect);
		return $resultado;
	}

	public function set_insert($connect, array $values, $table)
	{
		$result = 0;

		if (count($values) < 0)
			return false;

		foreach($values as $field => $val){
			$val = '\''.$val.'\'';
			$values[$field] = $val; 
		}

		$strsql = 'INSERT INTO '.$table.' ('.implode(array_keys($values), ', ').') VALUES ('.implode($values, ', ').')';
		$rs = $this->ejecutar($connect, $strsql);

		/*echo $strsql;
		*/
		echo mysqli_error($connect);

		if ($rs)
			$result = $this->lastID($connect);
		else
			$result = 0;

		return $result;
	}

	public function set_update($connect, $values, $table, $where = false)
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
		
		$rs = $this->ejecutar($connect, $strsql);

		/*echo $strsql;
		*/
		echo mysqli_error($connect);

		if ($rs)
			$result = $rs;
		else
			$result = 0;

		return $result;
	}

	public function set_delete($connect, $table, $where = false)
	{
		$result = 0;
		$where = ($where) ? ' WHERE ' . $where : '';
		$strsql = 'DELETE FROM '.$table.$where;

		$rs = $this->ejecutar($connect, $strsql);

		//echo $strsql;
		echo mysqli_error($connect);

		if ($rs)
			$result = $rs;
		else
			$result = 0;

		return $result;
	}
}
?>