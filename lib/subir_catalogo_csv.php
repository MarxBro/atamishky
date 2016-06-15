<?php

$target_dir = ".";
//$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$target_file = basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$iFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$ctlg_name = '../catalogo.xml';

// Check if image file is a actual image or fake image
//if(isset($_POST["submit"])) {
    //if (mime_content_type($target_file == 'text/plain')){
        //$uploadOk = 1;
    //} else {
        //$uploadOk = 0;
        //morir(); // EXIT
    //}
//}

// Check if file already exists
if (file_exists($target_file)) {
    // renombrar el archivo viejo preexistente.
    $uploadOk = 0;
        morir(); // EXIT
}
 // Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "El archivo es demasiado grande!";
    $uploadOk = 0;
        morir(); // EXIT
 }
// Allow certain file formats
if($iFileType != "csv" ) {
    echo "Solamente subir archivos  de formato CSV; Intente nuevamente, Gracias.";
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
    if (respaldame_el_catalogo_putin($ctlg_name)){
        // Ejecutar el script de lib con el catalogo
        $pathy   = './';
        $comando = $pathy . 'atamishky_CSV2XML.pl -f ' . $target_file . 
            ' -t -d -o ' . $ctlg_name; 
        echo "Regenerando el catálogo...";
        $salida = shell_exec($comando);
        echo '<pre>' . $salida . '</pre>';
    }
}

// Respaldar el catalogo anterior!
function respaldame_el_catalogo_putin ($nombre_posta){
    $fecha_ahora_strng = time();
    $nombre_backup = $nombre_posta . '_' . $fecha_ahora_strng . '.bk';
    copy($nombre_posta,$nombre_backup);
    if ($nombre_backup){
        return true;
    }
}

function morir(){
    echo "ERRORORORORORO";
    //die "Error en el archivo, Final no feliz!";
}

?>
