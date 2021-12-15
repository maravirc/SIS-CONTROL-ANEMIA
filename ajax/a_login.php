<?php
//session_start(); 

require_once "../modelos/M_login.php";
$consulta=new Consultas();

//echo $mes;
switch ($_POST["op"]){	
	case '1':
		$resp = $consulta->loguear($_POST["usu"],$_POST["pas"]);
		$rows = mysqli_num_rows($resp);
		if ($rows>0){
			$data = mysqli_fetch_assoc($resp);
			session_start();
			$_SESSION['permiso']=$data["ROL"];//si
      		$_SESSION['nombre']=$data["NOMBRE"];//si
        	$_SESSION['dni_usu']=$data["CODPSAL"];//si
        	$_SESSION['renipress']=$data["COD_2000"];//si
        	$_SESSION['profesion']=$data["PROFESION"];//si
        	$_SESSION['cargo']=$data["CARGO"];//si
        	$_SESSION['fechanac']=$data["FECHANAC"];//si
        	$_SESSION['telefono']=$data["TELEFONO"];//si

        	echo 1;
			//echo json_encode($data,JSON_UNESCAPED_UNICODE);
		}else{
			echo 0;
		}
		
	break;
	case '5':
	if($_POST["usu"]=='A'){
	$sql="UPDATE usuarios  SET USUA=NULL, PASS=NULL WHERE DNI='".$_POST["iden"]."' AND NOMBRE='".$_POST["nom"]."'";
	$resp=ejecutarConsulta($sql);	
	}else{
	switch ($_POST["cod_prof"]) {
		case '00':
		case '01':
		case '05':
		case '06':
			$rol=1;
			break;
		default:
			$rol=0;
			break;
	}
	$sql="UPDATE usuarios  SET USUA='".$_POST["usua"]."', PASS='".$_POST["pass1"]."',ROL='".$rol."' WHERE DNI='".$_POST["iden"]."' AND NOMBRE='".$_POST["nom"]."'";
	//echo $sql;
	$resp=ejecutarConsulta($sql);	
	}
	echo $resp;
	break;
}


?>

