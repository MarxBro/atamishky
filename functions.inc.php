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
$longname['searchautor'] = 'autor';

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

?>
