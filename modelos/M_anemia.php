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
    public function listar_pacientes_anemia($prog)
    {
    $sql="SELECT ID,NUMERO_DOCUMENTO,NOMBRES_PACIENTE,APELLIDOS,FICHA_FAMILIAR,DIST_PROCE,CODIGO,LAB_CODIGO,DIAGNOSTICO,TIPODX,TRATAMIENTO,NUM_TRATAMIENTO,HEMOGLOBINA,CODPSAL FROM p_diagnosticados INNER JOIN pacientes ON p_diagnosticados.ID_PACIENTE = pacientes.ID_PACIENTE WHERE TIPODX='$prog' ORDER BY ID ASC";
        //echo $sql;
        return ejecutarConsulta($sql);
    }

    public function listar_programas($n,$filtrar)
    {
        switch ($n) {
            case '1':
                if($filtrar==""){
                $sql="SELECT NUMERO_DOCUMENTO,NOMBRES_PACIENTE,APELLIDOS,FICHA_FAMILIAR,DIST_PROCE,CODIGO,LAB_CODIGO,DIAGNOSTICO,TIPODX1,TRATAMIENTO,NUM_TRATAMIENTO,HEMOGLOBINA,CODPSAL FROM p_diagnosticados INNER JOIN pacientes ON p_diagnosticados.ID_PACIENTE = pacientes.ID_PACIENTE ORDER BY ID ASC";
                }else{
                $sql="SELECT NUMERO_DOCUMENTO,NOMBRES_PACIENTE,APELLIDOS,FICHA_FAMILIAR,DIST_PROCE,CODIGO,LAB_CODIGO,DIAGNOSTICO,TIPODX1,TRATAMIENTO,NUM_TRATAMIENTO,HEMOGLOBINA,CODPSAL FROM p_diagnosticados INNER JOIN pacientes ON p_diagnosticados.ID_PACIENTE = pacientes.ID_PACIENTE WHERE TIPODX1 like '%".$filtrar."%' ORDER BY ID ASC";
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

