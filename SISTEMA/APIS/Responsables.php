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

/* Consulta UN registro de una UBICACIÓN de la tabla ubicaciones teniendo como criterio de búsqueda 
   la variable 'CodigoAsignado' que viene en el $_GET["consultar"] 
   */

   if (isset($_GET["consultarCodigoAsignadoR"])) {
    $codigoAsignado= $_GET["consultarCodigoAsignadoR"];
    $sqlResponsables = mysqli_query($conexionBD, "SELECT * FROM responsables WHERE documento='$codigoAsignado'");

    if (mysqli_num_rows($sqlResponsables) > 0) {
        $paciente = mysqli_fetch_assoc($sqlResponsables);
        echo json_encode($codigoAsignado);
        exit();
    } else {
        echo json_encode(["success" => 0]);
    }
}

/* Borra un registro de una UBICACIÓN de la tabla ubicaciones, teniendo como criterio de búsqueda 
   la variable 'id' que viene en el $_GET["borrar"] 
   */
if (isset($_GET["borrar"])) {
    header('Content-Type: application/json; charset=utf-8'); // 👈 fuerza JSON
    $id = intval($_GET["borrar"]);
    $sqlResponsables = mysqli_query($conexionBD, "DELETE FROM responsables WHERE id=$id");
    if ($sqlResponsables) {
        echo json_encode(["success" => 1]);
    } else {
        echo json_encode(["success" => 0]);
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