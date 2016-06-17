<?php

$target_dir = ".";
//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$target_file = basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$iFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$ctlg_name = 'catalogo.xml';

// Check if file already exists
if (file_exists($target_file)) {
    // renombrar el archivo viejo preexistente.
    if (!(respaldame_esto($target_file))){
        morir();    
    }
}
 // Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "El archivo es demasiado grande!";
    $uploadOk = 0;
        morir(); // EXIT
 }
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "El archivo no puede ser subido.";
        morir(); // EXIT
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "El archivo ". basename( $_FILES["fileToUpload"]["name"]) . " fué subido.";
        cataloguear();
    } else {
        echo "Hubo un error al subir el archivo.";
    }
}

// ------------------------------
// Función
// ------------------------------

function cataloguear (){
    global $ctlg_name;
    global $target_file;
    $ctlg_name_x = $ctlg_name;
    $target_file_x =  $target_file;
    if (respaldame_esto($ctlg_name_x)){
        // Ejecutar el script de lib con el catalogo
        $pathy   = './';
        $comando = $pathy . 'atamishky_CSV2XML.pl -f ' . $target_file_x . 
            ' -t -d -o ' . '../'. $ctlg_name_x; 
        echo "Regenerando el catálogo...";
        $salida = shell_exec($comando);
        echo '<pre>' . $salida . '</pre>';
    }
}

// Respaldar el catalogo anterior!
function respaldame_esto($nombre_posta){
    $fecha_ahora_strng = time();
    $nombre_backup = $nombre_posta . '_' . $fecha_ahora_strng . '.bk';
    copy($nombre_posta,$nombre_backup);
    if ($nombre_backup){
        return true;
    }
}

function morir(){
    echo "ERROR!";
}

?>
