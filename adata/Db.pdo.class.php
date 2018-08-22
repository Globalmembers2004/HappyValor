<?php
class Db  {
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


	private function conectar()
	{
		$conn = false;

		if (($_SERVER['SERVER_NAME'] == 'localhost') || ($_SERVER['SERVER_NAME'] == '127.0.0.1')){
			$host='127.0.0.1';
			$user='root';
			$password='';
			$db='restoapp';
		}
		else {
			$host='localhost';
			$user='globalme_global';
			$password='Il17051995';
			$db='globalme_restoapp';
		}
		
		$this->host     = $host;
        $this->username = $user;
        $this->passwd   = $password;
        $this->dbName   = $db;

		try {
		    $conn = new PDO('mysql:host='.$host.';dbname='.$db.';charset=utf8', $user, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e) {
		    echo "ERROR: " . $e->getMessage();
		}

		$this->link = $conn;
		return $conn;
	}

	private function desconectar()
	{
		$this->link = null;
		return 0;
	}

	private function obtener_filas($stmt)
	{
		$fetchrow = array();

		try {
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
				$fetchrow[] = $row;
		}
		catch(PDOException $e) {
		    echo "ERROR: " . $e->getMessage();
		}

		return $fetchrow;
	}

	private function lastID()
	{
		$conn = $this->link;
		return $conn->lastInsertId();
	}

	public function consultar($sql)
	{
		$stmt = false;
		$conn = $this->conectar();
		
		try {
			$stmt = $conn->prepare($sql);
			$stmt->execute();
		}
		catch (PDOException $e) {
    		echo "ERROR: " . $e->getMessage();
		}
		return $stmt;
	}

	public function ejecutar($sql)
	{
		$stmt = false;
		$conn = $this->conectar();
		
		try {
			$stmt = $conn->exec($sql);
		}
		catch (PDOException $e) {
    		echo "ERROR: " . $e->getMessage();
		}
		return $stmt;
	}

	public function exec_sp_select($sp_name, $sp_params)
	{
		$strsql = 'CALL '.$sp_name.' (';
		
		if (is_array($sp_params))
			$strsql .= '\'' . implode($sp_params, '\', \'') . '\'';

		$strsql .= ')';
	
		$conn = $this->conectar();

		try {
			$stmt = $conn->prepare($strsql);
		    $stmt->execute();

		    $result = $this->obtener_filas($stmt);
		    $stmt->closeCursor();
		}
		catch (PDOException $pe) {
		    die("Error occurred:" . $pe->getMessage());
		}
 		
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

		$conn = $this->conectar();
		
		try {
			$stmt = $conn->prepare($strsql);
		    $stmt->execute();
		    $stmt->closeCursor();

		    if ($sp_output != ''){
		    	$rs_output = $conn->query('SELECT '.$sp_output.';');
		    	$result = $this->obtener_filas($rs_output);
		    }
		    else {
		    	$stmt = $conn->prepare($strsql);
			    $stmt->execute();
				$result = array(array('rpta' => 1));
		    }
		}
		catch (PDOException $pe) {
		    die("Error occurred:" . $pe->getMessage());
		}

		$this->desconectar();
		return $result;
	}

	public function multiQuery($sql)
	{
		$result = $this->ejecutar($sql);
		return $result;
	}

	public function set_select($fields, $table, $where = false, $orderby = false, $groupby = false, $limit = false)
	{
		$resultado = false;

		if (is_array($fields))
			$fields = '' . implode($fields, ', ') . '';

		$groupby = ($groupby) ? ' GROUP BY ' . $groupby : '';
		$orderby = ($orderby) ? ' ORDER BY ' . $orderby : '';
		$limit = ($limit) ? ' LIMIT ' . $limit : '';
		$where = ($where) ? ' WHERE ' . $where : '';
		$strsql = 'SELECT ' . $fields . ' FROM ' . $table . '' . $where . $groupby . $orderby . $limit;

		$rs = $this->consultar($strsql);
		$resultado = $this->obtener_filas($rs);

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

		if ($rs)
			$result = $rs;
		else
			$result = 0;

		$this->desconectar();
		return $result;
	}
}
?>