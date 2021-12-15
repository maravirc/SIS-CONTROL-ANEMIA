<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}


	
	public function buscar_dni_u($n,$dni)
	{

		$sql="SELECT CODPSAL,DNI,NOMBRE,COD_2000,COD_PROF,COD_COND,USUA,PASS,ROL,BAJA,Nombre_Establecimiento FROM usuarios INNER JOIN establecimientos ON substring(usuarios.COD_2000,2,9) = establecimientos.Codigo_Unico WHERE DNI=".$dni;
		return ejecutarbucle($sql);
	}

	public function loguear($usu,$pas)
	{

		$sql="SELECT CODPSAL,DNI,NOMBRE,COD_2000,COD_PROF,COD_COND,USUA,PASS,ROL,BAJA,PROFESION,CARGO,TELEFONO,FECHANAC,Nombre_Establecimiento FROM usuarios INNER JOIN establecimientos ON substring(usuarios.COD_2000,2,9) = establecimientos.Codigo_Unico WHERE USUA='".$usu."' AND PASS='".$pas."'";
		return ejecutarConsulta($sql);
	}

}

?>