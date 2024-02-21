<?php
 // Variables para coger los valores del form del html
 $nombreNuevo_posteado = $_POST['nombre_nuevo'];
 $ap1Nuevo_posteado = $_POST['ap1_nuevo'];
 $ap2Nuevo_posteado = $_POST['ap2_nuevo'];
 $correoNuevo_posteado = $_POST['correo_nuevo'];
 $nombreUsuarioNuevo_posteado = $_POST['nombreUsuario_nuevo'];
 $contrasenaNueva_posteada = $_POST['contrasena_nueva'];

 session_start(); // inicio sesión php
 $ch = curl_init(); //inicio petición cURL en php
 $url = "http://172.16.0.2:8085/usuarios/20/editar_perfil/"; // dirección a la que se mandará la solocitud

//datos que se mandarán
 $data = array(
        'nuevo_nombre' => $nombreNuevo_posteado,
	'nuevo_ap1' => $ap1Nuevo_posteado,
	'nuevo_ap2' => $ap2Nuevo_posteado,
	'nuevo_correo' => $correoNuevo_posteado,
	'nuevo_nombreUsuario' => $nombreUsuarioNuevo_posteado,
	'nueva_contrasena' => $contrasenaNueva_posteada
 );

// Configurar la solicitud cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Para recibir la respuesta como una cadena
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH"); // Método HTTP PATCH
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Datos a enviar en el cuerpo de la solicitud

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Para recibir la respuesta como una cadena
curl_setopt($ch, CURLOPT_HEADER, true); // Captura las cabeceras
$response = curl_exec($ch);

//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
//curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Separar la cabecera del cuerpo de la respuesta
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);

// Extraer el token de la cabecera de la respuesta
preg_match("/Authorization: Bearer (.*)/", $header, $matches);
$_SESSION["token"] = $matches[1] ?? null;

// Cerrar la sesión de cURL
curl_close($ch);

// Verificar si se ha extraído correctamente el token
if ($_SESSION["token"] === null) {
    echo 'Error: No se ha encontrado el token de autorización en la respuesta.';
    // Puedes redirigir a una página de error o realizar alguna otra acción exit;
}

 // manejar errores
 if(curl_errno($ch)) {
     echo 'Error de cURL: ' . curl_error($ch);
 } elseif ($response === false) {
     echo 'Error en la respuesta: La respuesta está vacía';
 } else {
     $responseData = json_decode($response, true); //decodificar la respuesta
     $var_dump($responseData); //procesar la respuesta
 }

 //cerrar sesión
 curl_close($ch);
?>
