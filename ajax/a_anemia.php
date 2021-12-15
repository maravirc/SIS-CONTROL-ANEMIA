<?php
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=reporte_poi2020.xls');
session_start(); 

require_once "../modelos/M_anemia.php";
//require "../config/Conexion.php";
$consulta=new Consultas();


switch ($_GET['op']){	
	case '1':
	$rspta=$consulta->listar_pacientes_anemia($_GET['prog']);
		//Vamos a declarar un array
		$data= Array();
		
		while ($reg=$rspta->fetch_object()){

			//echo "<input type='text' maxlength='5' id=j".$reg->ID."j name=j".$reg->ID."j class='form-control solo-numero' style='width: 60px;' value=".$reg->mc_jerillo."  onchange=grabar('j".$reg->ID."j','".$reg->orden."','mc_jerillo') onFocus=limpiarCaja(j".$reg->ID."j) onBlur=mostrarcero(j".$reg->ID."j)>";
			$tipo="";
			if($reg->TIPODX=="D"){
				$tipo="DEFINITIVO";
			}
			if($reg->TIPODX=="P"){
				$tipo="PRESUNTIVO";
			}
			if($reg->TIPODX=="R"){
				$tipo="REPETITIVO";
			}
			$data[]=array(
			"0"=>$reg->ID,
			"1"=>$reg->NUMERO_DOCUMENTO,
			"2"=>$reg->NOMBRES_PACIENTE." ".$reg->APELLIDOS,
			"3"=>$reg->FICHA_FAMILIAR,
			"4"=>$reg->DIST_PROCE,
			"5"=>$reg->CODIGO,
			"6"=>$reg->LAB_CODIGO,
			"7"=>$reg->DIAGNOSTICO,
			"8"=>$tipo,
			"9"=>$reg->TRATAMIENTO,
			"10"=>$reg->NUM_TRATAMIENTO,
			"11"=>$reg->HEMOGLOBINA,
			"12"=>$reg->CODPSAL,
			"13"=>($reg->CODPSAL==$_SESSION['dni_usu'])?'<button class="btn btn-primary btn-md" onclick="editar_registro('.$reg->ID.')"><i class="fa fa-pencil" aria-hidden="true"></i></button><button class="btn btn-primary btn-md" onclick="reporte_pdf('.$reg->ID.')"><i class="fa fa-print" aria-hidden="true"></i></button>':'<button class="btn btn-success btn-md" disabled><i class="fa fa-pencil" aria-hidden="true"></i></button><button class="btn btn-primary btn-md" onclick="reporte_pdf('.$reg->ID.')"><i><i class="fa fa-print" aria-hidden="true"></i></button>',
				);
		}

		$results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
		echo json_encode($results);
	break;
	case '2':
		$vcaja=$_GET['vcaja'];
		$orden=$_GET['orden'];
		$establec=$_GET['establec'];

		if($_GET['vcaja']==""){
			$vcaja=0;
		}
		$sql="UPDATE  mrjerillo SET $establec=$vcaja, meta_total=mc_jerillo+mc_lahuarpia+mp_ramirez where orden=$orden";
		//echo $sql;
		try {
			$consulta = $conexion->prepare($sql);
	  		$consulta->execute();
	  		//consultar total meta;
	  		$sql="select meta_total from mrjerillo where orden=$orden";
	  		$consulta = $conexion->prepare($sql);
	  		$consulta->execute();
			$data = $consulta->fetch();

	  		echo "1|".$data['meta_total'];
			}
			catch (PDOException $ex) {
			echo "0|No se grabo!!!";
			}
		break;
	case '3':
		$orden=$_GET['orden'];
		$chk=$_GET['chk'];
		$sql="UPDATE i_indicadores set estado='$chk' where ID=$orden";
		//echo $sql;
		try {
			$consulta = $conexion->prepare($sql);
	  		$consulta->execute();
	  		//consultar total meta;
	  		//$sql="select meta_total from mrjerillo where orden=$orden";
	  		//$consulta = $conexion->prepare($sql);
	  		//$consulta->execute();
			//$data = $consulta->fetch();

	  		echo "1|0";
			}
			catch (PDOException $ex) {
			echo "0|No se grabo!!!";
			}
		break;
		case '4':
		if(!isset($_GET['searchTerm'])){
			$search ="";
		}else{
			$search = $_GET['searchTerm'];	
		}
		$rspta = $consulta->listar_programas('1',$search);	
		echo json_encode($rspta);
		break;
}


?>

