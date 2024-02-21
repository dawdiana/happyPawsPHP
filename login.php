<?php
 // Variables para coger los valores del form del html
 $correo_posteado = $_POST['correo_login'];
 $contrasena_posteada = $_POST['contrasena_login'];

 session_start(); // inicio sesión php
 $ch = curl_init(); //inicio petición cURL en php
 $url = "http://172.16.0.2:8085/usuarios/login/"; // dirección a la que se mandará la solocitud


//datos que se mandarán
 $data = array(
	'ingresar_correo' => $correo_posteado,
	'ingresar_contrasena' => $contrasena_posteada
 );

 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_POST, true); //indica que es una solicitud post
 curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); //convierte los datos en formato json y los envía
 curl_setopt($ch, CURLOPT_HEADER, true);

 // extraer token
 $response = curl_exec($ch); //separar cabecera del cuerpo de respuesta
 $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE); //hace que php espere una respuesta
 $header = substr ($response, 0, $header_size);

 preg_match("/Authorization: Bearer (.*)/", $header, $matches);
 $_SESSION["token"] = $matches[1] ?? null;

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
