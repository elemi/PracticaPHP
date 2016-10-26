<?php
/**
 * Autor: Emilio López Araujo
 * Módulo: Desarrollo en entorno-servidor
 */

/**
 * Capa de abstracción BBDD
 * @author El_Emi
 *
 */
Class Db_connection {

	private $servidor;
	private $usuario;
	private $password;
	private $base_datos;
	private $link;
	private $stmt;
	private $array;


	static $_instance;


	/**
	 * Crea una conexion a la base de datos
	 */
	private function __construct(){
		//La funcion construct es privada para evitar que el objeto pueda ser creado mediante new

		$this->servidor="localhost";
		$this->usuario="root";
		$this->password="";
		$this->base_datos="";

		$this->conectar();
	}


	/**
	 * evitar clonaje del objeto. patrón singleton
	 */
	private function __clone(){ }


	/**
	 * Crea si es necesaria la instancia del objeto
	 */
	public static function getInstance(){
		//este es el metodo que debemos llamar desde fuera de la clase para instanciar el objeto, y asi, poder utilizar sus metodos
		if (!(self::$_instance instanceof self)){
			self::$_instance=new self();
		}
		return self::$_instance;
	}


	/**
	 * establece una conexión con la base de datos
	 */
	private function conectar()
	{
		$this->link=mysqli_connect($this->servidor, $this->usuario, $this->password);
		mysqli_select_db($this->link,$this->base_datos);
		mysqli_query($this->link, "SET NAMES 'utf8'");
	}


	/**
	 * Método para ejecutar una sentencia sql.
	 * @param string $sql sentencia a ejecutar en la base de datos.
	 * @return stmt atributo de la clase.
	 */
	public function ejecutar($sql){
		$this->stmt=mysqli_query($this->link,$sql);

		if (!$this->stmt) {
			echo '<p>'.$sql.'</p>';
			echo '<span style="color:red">ERROR - Query SQL.</span>', die();
		}

		return $this->stmt;//retorna un objeto con datos del $sql
	}


	/**
	 * Método para ejecutar una sentencia sql.
	 * @param string $script (script.sql  a ejecutar en la base de datos).
	 */
	public function ejecutarScript($script){

		//esta función elimina los elementos vacios dentro del array.    ---->array_filter($script, callback);
		// continue (dentro de un bucle, salta el codigo que este por debajo y continua con la siguiente interación en el bucle).
		// break (dentro de un bucle, termina el bucle).

		$sql = explode(";", $script);

		foreach ($sql as $query):

		if ($query==''):
		continue;
		endif;

		$this->stmt=mysqli_query($this->link,$query);

		if (!$this->stmt) {
			echo '<p>'.$query.'</p>';
			echo '<span style="color:red">ERROR - SCRIPT SQL.</span>';
		}
		else{
			echo nl2br($query);
			echo '<span style="color:red">SCRIPT EJECUTADO EXITOSAMENTE !!!.</span>';
		}

		endforeach;

	}



	/**
	 * Método para actualizar registros.
	 * @param string $sql sentencia a ejecutar en la base de datos.
	 */
	public function actualizar($sql){
		mysqli_query($this->link,$sql);
	}


	/**
	 * Método para obtener filas de resultados de la sentencia sql
	 * @param object $stmt información de la sentencia ejecutada.
	 */
	public function obtener_filas($stmt){
		$this->array=mysqli_fetch_array($stmt);//retorna cada registro, si no existe false
		return $this->array;
	}

	/**
	 * Devuelve el valor del �ltimo campo autonumérico insertado
	 * @return int
	 */
	public function LastID()
	{
		return $this->link->insert_id;
	}
	
	/**
	 * Devuelve el primer registro que cumple la condición indicada
	 * @param string $tabla
	 * @param string $condicion
	 * @param string $campos
	 * @return array|NULL
	 */
	public function LeeUnRegistro($tabla, $condicion, $campos='*')
	{
		$sql="select $campos from $tabla where $condicion limit 1";
		$rs=$this->link->query($sql);
		if($rs)
		{
			return $rs->fetch_array();
		}
		else
		{
			return NULL;
		}
	}
}
?>
