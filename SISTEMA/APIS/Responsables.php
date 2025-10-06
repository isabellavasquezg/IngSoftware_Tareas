<?php
/* 
TAKEN FORM: https://github.com/oscaruhp/empleados
AUTHOR: Oscar Uh

MODIFIED AND ADAPTED BY: Angelower Santana-Velásquez

*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

/*  Conecta con la base de datos en el servidor local 
	usando las credenciales de usuario y contraseña */
$servidor = "localhost"; 
$usuario = "root"; 
$passwd = ""; 
$nombreBaseDatos = "sgt";
$conexionBD = new mysqli($servidor, $usuario, $passwd, $nombreBaseDatos);

// Get : obtener información, post: insertar datos , put:actualizaciones , delete:borrar.
/* Consulta UN registro de una UBICACIÓN de la tabla ubicaciones teniendo como criterio de búsqueda 
   la variable 'id' que viene en el $_GET["consultar"] 
   */
if (isset($_GET["consultar"])){
        $sqlResponsables = mysqli_query($conexionBD,"SELECT * FROM responsables WHERE id=".$_GET["consultar"]);
        if(mysqli_num_rows($sqlResponsables) > 0){
            $responsable = mysqli_fetch_all($sqlResponsables,MYSQLI_ASSOC);
            echo json_encode($responsable); 
            exit();
        } else{  echo json_encode(["success"=>0]); }
}

/* Borra un registro de una UBICACIÓN de la tabla ubicaciones, teniendo como criterio de búsqueda 
   la variable 'id' que viene en el $_GET["borrar"] 
   */
if (isset($_GET['borrar'])) {
    $id = mysqli_real_escape_string($conexionBD, $_GET['borrar']);

    // 🎯 PASO 1: Contar cuántos equipos usan esta ubicación
    $sql_count = "SELECT COUNT(*) AS total_equipos FROM equipos_medicos WHERE codigoResponsable = '$id'";
    $resultado_count = mysqli_query($conexionBD, $sql_count);
    $fila_count = mysqli_fetch_assoc($resultado_count);
    $total_equipos = $fila_count['total_equipos'];
    
    // Si no hay equipos asociados, procedemos con el DELETE
    if ($total_equipos == 0) {
        $resultado = mysqli_query($conexionBD, "DELETE FROM responsables WHERE codigoAsignado = '$id'");
        
        if ($resultado) {
            echo json_encode(["success" => 1, "message" => "Ubicación eliminada correctamente."]);
        } else {
            // Este caso debería ser raro si el conteo fue 0
            echo json_encode(["success" => 0, "error" => "Error desconocido al intentar eliminar la ubicación."]);
        }

    } else {
        // 🎯 PASO 2: Error de restricción con la cuenta exacta
        echo json_encode([
            "success" => 0, 
            "error" => "No se puede eliminar esta ubicación. Hay **{$total_equipos}** equipo(s) asociado(s) que deben reasignarse o eliminarse primero."
        ]);
    }
    exit();
}
/* Inserta un registro de una ubicación de la tabla Ubicaciones. La información es recibida en método POST */
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $codigoAsignado = $data->codigoAsignado ?? "";
    $documentoIdentidad = $data->documentoIdentidad ?? "";
    $nombre = $data->nombre ?? "";
    $apellido = $data->apellido ?? "";
    $cargo = $data->cargo ?? "";
    $telefono = $data->telefono ?? "";

    if(($codigoAsignado!="")&&($nombre!="")&&($telefono!="")&&($documentoIdentidad!="")&&($apellido!="")&&($cargo!="")){        
        $sql = mysqli_query($conexionBD,
            "INSERT INTO responsables(codigoAsignado,documentoIdentidad,nombre,apellido,cargo,telefono) 
             VALUES('$codigoAsignado','$documentoIdentidad','$nombre','$apellido','$cargo','$telefono')");

        if($sql){
            echo json_encode(["success"=>1]);
        } else {
            echo json_encode(["success"=>0, "error"=>mysqli_error($conexionBD)]);
        }
    } else {
        echo json_encode(["success"=>0, "error"=>"Datos incompletos"]);
    }
    exit();
}


/* Actualiza todos los campos de la tabla ubiaciones, teniendo como criterio de búsqueda 
   la variable 'id' que viene en el $_GET["actualizar"]
   */
if(isset($_GET["actualizar"])){ 
    $data = json_decode(file_get_contents("php://input"));
    $id=(isset($data->id))?$data->id:$_GET["actualizar"];
    $codigoAsignado=$data->codigoAsignado;
    $documentoIdentidad=$data->documentoIdentidad;
    $nombre=$data->nombre;
    $apellido=$data->apellido; 
    $cargo=$data->cargo;
    $telefono=$data->telefono; 
	$sqlResponsables = mysqli_query($conexionBD,"UPDATE responsables SET  codigoAsignado='$codigoAsignado',documentoIdentidad='$documentoIdentidad',nombre='$nombre',apellido='$apellido',cargo='$cargo' ,telefono='$telefono' WHERE id='$id'");
	echo json_encode(["success"=>1 ]);
	exit();
    
}

/*
	Muestra todos los registros almacenados en la tabla ubucaciones, usando la URL raíz.
*/
$sqlResponsables_ = mysqli_query($conexionBD,"SELECT * FROM responsables ");
if(mysqli_num_rows($sqlResponsables_) > 0){
    $Responsables_ = mysqli_fetch_all($sqlResponsables_,MYSQLI_ASSOC);
    echo json_encode($Responsables_);
}
else{ echo json_encode([["success"=>0]]); }
?>