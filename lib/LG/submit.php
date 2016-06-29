<?php

include ('verif.inc');

//Incluir la hora
date_default_timezone_set('America/Argentina/Buenos_Aires');

if(isset($_POST["formSubmit"])){
    if(strcmp( $_POST["formSubmit"] , $_SESSION['secreto'] ) ){
    $submitter_info_brute = array(
        $_POST['nombreapellido'],
        $_POST['pass'],
    );
    $submitter_info = array_map("sano",$submitter_info_brute);
    $submitter_info_csv = $submitter_info[0] . ',' .  $submitter_info[1];

    // Si hay algun elemento vacio, es que hubo un error validando la entrada.
    if ( in_array("",$submitter_info)){
        error_caca("Algun elemento del formulario es erroneo. Final no feliz.");
    }
    
    $tiempo_pa_formatear = time();
    $fecha_submitted = date("d-m-Y (H:i:s)", $tiempo_pa_formatear);

    $contenido_ugly_csv_arr = array(
            $fecha_submitted,
            $submitter_info[0],
            $submitter_info[1],
            );
    $contenido_ugly_csv = join(',' , $contenido_ugly_csv_arr);
    escribir_todo_en_el_LOG( $contenido_ugly_csv);
    do_moodle_stuff($submitter_info[0],$submitter_info[1]);
    } else {
        //ERROR de SESSION ID
        error_caca ('Hubo un error.');
    }
}



/* -------------------------
         FUNCIONES
------------------------- */
function escribir_todo_en_el_LOG( $c_u_csv ){
    $mail_logs = $c_u_csv . "\n";
    $fs_append = fopen("data/feedback.csv",'a');
    fwrite($fs_append, "$mail_logs");
    fclose($fs_append);
}

function error_caca($causa) {
    header("Location: error.php");
    die ("$causa");
}

function sano ($input){
    $output_sano = trim($input);
    $output_sano = stripslashes($output_sano);
    $output_sano = filter_var($output_sano,FILTER_SANITIZE_STRING);
    //$output_sano = htmlspecialchars($output_sano);
    if(filter_var($output_sano,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>'/([\w\d\s-_()@,;."!?:]+)/')))){
        return $output_sano;
    } else {
        return '';
    }
}


function getRealIpAddr(){
    $ip = "null";
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){   //to check ip is pass from proxy
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])){   //check ip from share internet
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    } else {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function do_moodle_stuff($user,$pass){
    $url_moodle = 'http://www.atamvirtual.com.ar/login/token.php?username=' . $user . '&password='. $pass . '&service=FATAMUNA';
    //curlear
    $curl = curl_init();
    curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url_moodle,
                ));
    $resp = curl_exec($curl);
    curl_close($curl);
    $obj_moodle_token = json_decode($resp);

    if ($obj_moodle_token->{'token'}){
        //Hacer algo lindo
        $token_putos = $obj_moodle_token->{'token'};
        give_me_info($token_putos);
    } else {
        error_caca("no token no love");
    }
}

//OJO que NO es JSON, es puto XML
function give_me_info ($tok){
    global $header_bit;
    $url_moodle_rest = 'http://www.atamvirtual.com.ar/webservice/rest/server.php?wstoken=';
    $token_bit = $tok . '&wsfunction=core_webservice_get_site_info';
    $url_moodle_rest .= $token_bit;
    //-------
    $curlio = curl_init();
    curl_setopt_array($curlio, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $url_moodle_rest,
                ));
    $rest_stuff = curl_exec($curlio);
    curl_close($curlio);
    $xml = simplexml_load_string($rest_stuff);
    //echo $tok;

    $nombre_pag          = "<h1>" . $xml->SINGLE->KEY[0]->VALUE . "</h1>";
    $url_pag             = "<h2>" . $xml->SINGLE->KEY[7]->VALUE . "</h2>";
    $nombre_visitante    = "<strong>" . $xml->SINGLE->KEY[4]->VALUE . "</strong>";
    $user_id             = $xml->SINGLE->KEY[6]->VALUE;
    $user_pic            = '<div><img src="' . $xml->SINGLE->KEY[8]->VALUE . '" alt="profile_pic"></div>';
    $user_quota          = $xml->SINGLE->KEY[17]->VALUE / 1024 / 1024;

    $link_super_privado = '<br><div><strong><a target="_blank" href="' . 
        'http://cloud.iuna-atam.com.ar/index.php/s/N4b1bjxvfKqCMp2' . 
        '">Enlace a la Bibliografía de la Carrera.</a></strong></div>';
    
    $choclito = '<html>'. $header_bit . '<body>' . $nombre_pag . $url_pag . $nombre_visitante . $user_pic . $link_super_privado . '</body></html>';
    echo $choclito;
}

?>
