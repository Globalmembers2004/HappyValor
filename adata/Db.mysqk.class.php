<?php
class Db {
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
			$user='restora';
			$password='Hs@.alObp%Vqd~xxbH';
			$db='restoraBD';
		}
		
		$this->host     = $host;
        $this->username = $user;
        $this->passwd   = $password;
        $this->dbName   = $db;

		try {
		    $conn = new PDO('mysql:host='.$host.';dbname='.$db, $user, $password);
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e) {
		    echo "ERROR: " . $e->getMessage();
		}

		return $conn;
	}

	private function desconectar()
	{
		
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

	private function lastID($stmt)
	{
		return $stmt->lastInsertId();
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
		/*echo $sql;
		echo mysqli_error($this->link);*/
		return $stmt;
	}

	public function ejecutar($sql)
	{
		$stmt = false;
		$conn = $this->conectar();
		
		try {
			$stmt = $conn->exec($strsql);
		}
		catch (PDOException $e) {
    		echo "ERROR: " . $e->getMessage();
		}
		/*echo $sql;
		echo mysqli_error($this->link);*/
		return $stmt;
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

		/*echo $strsql;
		echo mysqli_error($this->link);*/
		
		//$this->desconectar();
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
		echo mysqli_error($this->link);*/

		if ($rs)
			$result = $this->lastID($rs);
		else
			$result = 0;

		//$this->desconectar();
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

		echo mysqli_error($this->link);*/

		if ($rs)
			$result = $rs;
		else
			$result = 0;

		//$this->desconectar();
		return $result;
	}

	public function set_delete($table, $where = false)
	{
		$result = 0;
		$where = ($where) ? ' WHERE ' . $where : '';
		$strsql = 'DELETE FROM '.$table.$where;

		$rs = $this->ejecutar($strsql);

		//echo $strsql;

		//echo mysqli_error($this->link);

		if ($rs)
			$result = $rs;
		else
			$result = 0;

		//$this->desconectar();
		return $result;
	}
}
?>