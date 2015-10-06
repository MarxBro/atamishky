<?php

$longname['year'] = 'Año';
$longname['researcharea'] = 'research area';
$longname['entrytype'] = 'Tipo de Recurso';
$longname['ID'] = 'ID';
$longname['author'] = 'Autor';
$longname['keyword'] = 'keyword';
$longname['searchtitle'] = 'title containing';

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
$longnameEntrytype['all'] = 'all';


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

    //$xp->setParameter($namespace, 'id1', 'value1');
    //$xp->setParameter($namespace, 'id2', 'value2');

    $namespace = null;
    $xp->setParameter($namespace, $params);

    // transform the XML into HTML using the XSL file
    if ($html = $xp->transformToXML($xml_doc)) {
      return $html;
     } else {
      trigger_error('XSL transformation failed.', E_USER_ERROR);
     } 

} //function transform

//esta funcion es pelotudisima y no la quiero ni ver.

//contributed by Turgut Durduran
//function yearArraySince($startYear)
//{
  //$current_year = date('Y');
  //$yeararray = array();
  //for ($i = 0; $current_year-$i >= $startYear ; $i++)
    //{
      //$yeararray[$i] = $current_year-$i;
    //}
  //return $yeararray;
//}

?>
