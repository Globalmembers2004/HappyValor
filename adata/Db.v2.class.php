<?php
$mysqli = new mysqli("localhost", "my_user", "my_password", "world");

/* comprobar la conexión */
if ($mysqli->connect_errno) {
    printf("Falló la conexión: %s\n", $mysqli->connect_error);
    exit();
}

/* Crear una tabla que no devuelve un conjunto de resultados */
if ($mysqli->query("CREATE TEMPORARY TABLE myCity LIKE City") === TRUE) {
    printf("Se creó con éxtio la tabla myCity.\n");
}

/* Consultas de selección que devuelven un conjunto de resultados */
if ($resultado = $mysqli->query("SELECT Name FROM City LIMIT 10")) {
    printf("La selección devolvió %d filas.\n", $resultado->num_rows);

    /* liberar el conjunto de resultados */
    $resultado->close();
}

/* Si se ha de recuperar una gran cantidad de datos se emplea MYSQLI_USE_RESULT */
if ($resultado = $mysqli->query("SELECT * FROM City", MYSQLI_USE_RESULT)) {

    /* Observar que no se puede ejecutar ninguna función que interactue con el
       servidor hasta que el conjunto de resultados se haya cerrado. Todas las llamadas devolverán un
       error 'out of sync' */
    if (!$mysqli->query("SET @a:='esto no funcionará'")) {
        printf("Error: %s\n", $mysqli->error);
    }
    $resultado->close();
}

$mysqli->close();


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

    public function Db()
	{
		
	}
}
?>