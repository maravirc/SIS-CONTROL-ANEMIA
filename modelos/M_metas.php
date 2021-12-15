<?php
//session_start(); 
//if(!isset($_SESSION['nombre'])){
  // header("Location:/nuevo/vistas/dashboard.php"); 

//}
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultas
{

	//Implementamos nuestro constructor
	public function __construct()
	{

	}	
    public function listar_indicadores($prog)
    {
    $sql="SELECT ID, fila,PROGRAMA,ACTIVIDADES,estado,cod_prog,orden,poblacion,meta_total,mc_jerillo,mp_ramirez,mc_lahuarpia FROM i_indicadores INNER JOIN mrjerillo ON ID = orden WHERE PROGRAMA='$prog'";
        //echo $sql;
        return ejecutarConsulta($sql);
    }

    public function listar_programas($n,$filtrar)
    {
        switch ($n) {
            case '1':
                if($filtrar==""){
                $sql="SELECT ID,PROGRAMA FROM i_indicadores GROUP BY PROGRAMA ORDER BY ID ASC";
                }else{
                $sql="SELECT ID,PROGRAMA FROM i_indicadores WHERE PROGRAMA like '%".$filtrar."%' GROUP BY PROGRAMA ORDER BY ID ASC";
                }
                break;
        }
        //echo $sql;
        $rspta=ejecutarConsulta($sql);
        $a=0;
        $data[]=array(
         "id"=>"0",
        "text"=>"- -");
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
            "id"=>$reg->ID,
            "text"=>$reg->PROGRAMA);
        }
        return $data;
        
    }
        
    
}



?>

