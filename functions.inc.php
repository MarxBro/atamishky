<?php

$longname['year'] = 'Año';
$longname['researcharea'] = 'research area';
$longname['entrytype'] = 'tipo';
$longname['ID'] = 'ID';
$longname['author'] = 'autor';
$longname['keyword'] = 'tag';
$longname['address'] = 'ciudad - país';
$longname['bibliografia'] = 'bibliografía';
$longname['publisher'] = 'editorial';
$longname['searchtitle'] = 'titulo';
$longname['searchdescripcion'] = 'descripcion';
$longname['searchautor'] = 'autor';
$longname['searchTODO'] = 'todos';

//$longnameEntrytype['paper'] = 'Journal article';
//$longnameEntrytype['inproceedings'] = 'Inproceedings/Talk';
//$longnameEntrytype['inbookincollection'] = 'Book chapter';
$longnameEntrytype['book'] = 'Libro';
//$longnameEntrytype['mastersthesis'] = 'MS thesis';
//$longnameEntrytype['mastersproject'] = 'MAS project';
//$longnameEntrytype['phdthesis'] = 'PhD thesis';
//$longnameEntrytype['techreport'] = 'Technical report';
//$longnameEntrytype['patent'] = 'Patent';
$longnameEntrytype['misc'] = 'Varios';
$longnameEntrytype['musica'] = 'Musica';
$longnameEntrytype['video'] = 'Video';
$longnameEntrytype['all'] = 'Todos';

function transform($xmlfile, $xslfile, $params){
    $xp = new XsltProcessor();
    
    // create a DOM document and load the XSL stylesheet
    $xsl = new DomDocument;
    $xsl->load($xslfile);

    // import the XSL styelsheet into the XSLT process
    $xp->importStylesheet($xsl);

    // create a DOM document and load the XML datat
    $xml_doc = new DomDocument;
    $xml_doc->load($xmlfile);

    $namespace = null;
    $xp->setParameter($namespace, $params);

    // transform the XML into HTML using the XSL file
    if ($html = $xp->transformToXML($xml_doc)) {
      return $html;
     } else {
      trigger_error('XSL transformation failed.', E_USER_ERROR);
     } 

}

function sano ($input){
    $output_sano = trim($input);
    $output_sano = stripslashes($output_sano);
    $output_sano = filter_var($output_sano,FILTER_SANITIZE_STRING);
    //$output_sano = htmlspecialchars($output_sano);
    if(filter_var($output_sano,FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>'/([\w\d\s-_()@,;."!?:]+)/')))){
        return $output_sano;
    } 
}
//******************************************************************
//Funciones de seguridad... o algo asi.
//******************************************************************

//Esta funcion valida el xsl desde el hash md5 del archivo.
//Se asegura que ese valor sea igual al valor dado por php, al vuelo.
function validar_xsl($nombre) {
    $MD5s = do_hash_seguridad_vendehumo();
    foreach ($MD5s as $nombre => $md5){
        $md5_php = md5_file($nombre);
        if ($md5_php == $md5){
            return $nombre;
        } 
    }
}

//Esta funcion se asegura que los xsl esten intactos, para prevenir XSS.
function do_hash_seguridad_vendehumo() {
    $handle_md5txt = fopen("lib/md5s.sec", "r");
    $MD5s = array();
    if ($handle_md5txt) {
        while(!feof($handle_md5txt)){
            $line           = fgets($handle_md5txt);
            $line           = str_replace("\n", $line);
            $matches_rgx    = explode(' ',$line);
            $md5_rgx        = $matches_rgx[0];
            $nn_rgx         = $matches_rgx[1];
            $MD5s[$nn_rgx]  = $md5_rgx;
        }
    } else {
        die("El archivo de verificacion no existe o no se puydo abrir. 
            ERROR GRAVE Y FINAL NO FELIZ.");
    } 
    fclose($handle_md5txt);
    return $MD5s;
} 

?>
