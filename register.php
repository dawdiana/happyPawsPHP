<?php
 // Variables para coger los valores del form del html
 $nombre_posteado = $_POST["nombre_registro"];
 $ap1_posteado = $_POST['ap1_registro'];
 $ap2_posteado = $_POST['ap2_registro'];
 $correo_posteado = $_POST['correo_registro'];
 $nombreUsuario_posteado = $_POST['nombreUsuario_registro'];
 $contrasena_posteada = $_POST['contrasena_registro'];
 $contrasenaRepetida_posteada = $_POST['repetirContrasena_registro'];

 session_start(); // inicio sesión php
 $ch = curl_init(); //inicio petición cURL en php
 $url = "http://172.16.0.2:8085/usuarios/register/"; // dirección a la que se mandará la solocitud


//datos que se mandarán
 $data = array( /*Las conexiones se tienen llamar igual que en django*/
        'nuevo_nombre' => $nombre_posteado,
	'nuevo_ap1' => $ap1_posteado,
	'nuevo_ap2' => $ap2_posteado,
	'nuevo_correo' => $correo_posteado,
	'nuevo_nombreUsuario' => $nombreUsuario_posteado,
	'nueva_contrasena' => $contrasena_posteada,
	'confirmar_contrasena' => $contrasenaRepetida_posteada
);

 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_POST, true); //indica que es una solicitud post
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); //convierte los datos en formato json y los envía
 curl_setopt($ch, CURLOPT_HEADER, true);

 // extraer token
 $response = curl_exec($ch); //separar cabecera del cuerpo de respuesta
 $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE); //hace que php espere una respuesta
 $header = substr ($response, 0, $header_size);

// preg_match("/Authorization: Bearer (.*)/", $header, $matches);
// $_SESSION["token"] = $matches[1] ?? null

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
