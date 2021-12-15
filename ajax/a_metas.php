<?php
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename=reporte_poi2020.xls');
///session_start(); 
//if(!isset($_SESSION['nombre'])){
//   header("Location:/nuevo/vistas/dashboard.php"); 
//}

require_once "../modelos/M_metas.php";
//require "../config/Conexion.php";
$consulta=new Consultas();


switch ($_GET['op']){	
	case '1':
	$rspta=$consulta->listar_indicadores($_GET['prog']);
		//Vamos a declarar un array
		$data= Array();
		
		while ($reg=$rspta->fetch_object()){

			//echo "<input type='text' maxlength='5' id=j".$reg->ID."j name=j".$reg->ID."j class='form-control solo-numero' style='width: 60px;' value=".$reg->mc_jerillo."  onchange=grabar('j".$reg->ID."j','".$reg->orden."','mc_jerillo') onFocus=limpiarCaja(j".$reg->ID."j) onBlur=mostrarcero(j".$reg->ID."j)>";
			$chk="";
			if($reg->estado=="1"){
				$chk="checked";
			}
			$data[]=array(
			"0"=>$reg->ID,
			"1"=>"<input type='checkbox' id='ck".$reg->ID."ck' name='ck".$reg->ID."ck' class='form-check-input'".$chk." onclick=mostrarcero(".$reg->ID.")>",
			"2"=>$reg->PROGRAMA,
			"3"=>$reg->ACTIVIDADES,
			"4"=>$reg->poblacion,
			"5"=>$reg->meta_total,
			"6"=>"<input type='text' maxlength='5' id='j".$reg->ID."j' name='j".$reg->ID."j' class='form-control solo-numero' style='width: 60px;' value=".$reg->mc_jerillo."  onchange=grabar('j".$reg->ID."j','".$reg->orden."','mc_jerillo') onFocus=limpiarCaja('j".$reg->ID."j') onBlur=mostrarcero('j".$reg->ID."j')>",
			"7"=>"<input type='text' maxlength='5' id='h".$reg->ID."h' name='h".$reg->ID."h' class='form-control solo-numero' style='width: 60px;' value=".$reg->mc_lahuarpia."  onchange=grabar('h".$reg->ID."h','".$reg->orden."','mc_lahuarpia') onFocus=limpiarCaja('h".$reg->ID."h') onBlur=mostrarcero('h".$reg->ID."h')>",
			"8"=>"<input type='text' maxlength='5' id='r".$reg->ID."r' name='r".$reg->ID."r' class='form-control solo-numero' style='width: 60px;' value=".$reg->mp_ramirez."  onchange=grabar('r".$reg->ID."r','".$reg->orden."','mp_ramirez') onFocus=limpiarCaja('r".$reg->ID."r') onBlur=mostrarcero('r".$reg->ID."r')>",
			"9"=>"<div id='mensaje".$reg->orden."' >&nbsp;&nbsp;&nbsp;</div>",
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

