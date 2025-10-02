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
/* Consulta UN registro de una CONTRASEÑA de la tabla Contraseñas teniendo como criterio de búsqueda 
   la variable 'id' que viene en el $_GET["consultar"] 
   */
if (isset($_GET["consultar"])){
        $sqlContraseñas = mysqli_query($conexionBD,"SELECT * FROM usuarios WHERE id=".$_GET["consultar"]);
        if(mysqli_num_rows($sqlContraseñas) > 0){
            $contraseña = mysqli_fetch_all($sqlContraseñas,MYSQLI_ASSOC);
            echo json_encode($sqlContraseñas); 
            exit();
        } else{  echo json_encode(["success"=>0]); }
}

/* Consulta UN registro de una Contraseña de la tabla Contraseñas teniendo como criterio de búsqueda 
   la variable 'CodigoAsignado' que viene en el $_GET["consultar"] 
   */

   if (isset($_GET["consultarContraseña"])) {
    $contraseña= $_GET["consultarContraseña"];
    $sqlContraseñas = mysqli_query($conexionBD, "SELECT * FROM usuarios WHERE documento='$contraseña'");

    if (mysqli_num_rows($sqlContraseñas) > 0) {
        $contraseña = mysqli_fetch_assoc($sqlContraseñas);
        echo json_encode($contraseña);
        exit();
    } else {
        echo json_encode(["success" => 0]);
    }
}

/* Borra un registro de una CONTRASEÑA de la tabla Contraseña, teniendo como criterio de búsqueda 
   la variable 'id' que viene en el $_GET["borrar"] 
   */
if (isset($_GET["borrar"])) {
    header('Content-Type: application/json; charset=utf-8'); // 👈 fuerza JSON
    $contraseña = intval($_GET["borrar"]);
    $sqlContraseñas = mysqli_query($conexionBD, "DELETE FROM usuarios WHERE contraseña=$contraseña");
    if ($sqlContraseñas) {
        echo json_encode(["success" => 1]);
    } else {
        echo json_encode(["success" => 0]);
    }
    exit();
}
/* Inserta un registro de una ubicación de la tabla Ubicaciones. La información es recibida en método POST */
if(isset($_GET["insertar"])){
    $data = json_decode(file_get_contents("php://input"));
    $contraseña = $data->contraseña ?? "";
    $usuario = $data->usuario ?? "";

    if(($contraseña!="")&&($usuario!="")){        
        $sql = mysqli_query($conexionBD,
            "INSERT INTO contraseña (contraseña,usuario) 
             VALUES('$contraseña','$usuario')");

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
    $id=(isset($data->contraseña))?$data->contraseña:$_GET["actualizar"];
    $contraseña=$data->contraseña;
    $usuario=$data->usuario;
	$sqlContraseñas = mysqli_query($conexionBD,"UPDATE usuarios SET  contraseña='$contraseña',usuario='$contraseña', WHERE id='$id'");
	echo json_encode(["success"=>1 ]);
	exit();
    
}

/*
	Muestra todos los registros almacenados en la tabla contraseñas, usando la URL raíz.
*/
$sqlContraseñas = mysqli_query($conexionBD,"SELECT * FROM usuarios ");
if(mysqli_num_rows($sqlContraseñas_) > 0){
    $Contraseñas_ = mysqli_fetch_all($sqlContraseñas_,MYSQLI_ASSOC);
    echo json_encode($Contraseñas_);
}
else{ echo json_encode([["success"=>0]]); }
?>