<?php

include_once("functions.inc.php");

$atamishky_HOME="http://biblio.atamvirtual.com.ar";
$atamishky_EMBEDDING_URL=$atamishky_HOME."/";

// OPTIONAL: page title
$PAGE_TITLE="ATAM bibliografía";
// OPTIONAL: page description
$PAGE_DESCRIPTION="Búsqueda de bibliografía en la Mediateca del ATAM";
// OPTIONAL: page keywords
$PAGE_KEYWORDS="Publications";
// OPTIONAL: favicon - used for the page and the RSS feed
$FAVICON=$atamishky_EMBEDDING_URL."favicon.ico";


// MANDATORY: The year of the earliest publication
$START_YEAR = 1999;

// Style of the publication filtering menu. Possible values: "HORIZONTAL", "VERTICAL"
// Prefer horizontal if the year list is too long. The default value is vertical.
$MENU_STYLE = "VERTICAL";

// MANDATORY: Menu matrix - comment out the rows to exclude.
$MENU = array(
	      //"year" => yearArraySince($START_YEAR), //array('2009', '2008', '2007', '2006', '2005', '2004', '2003', '2002', '2001'),
	      //"researcharea" => array('Your research area', 'Your other research area'),
	      "keywords" => array(),
	      "entrytype" => array('book', 'misc','musica', 'video'),
	      "author" => array()
	      );

$EXTERNAL_HEADER="includes/h.html";
$EXTERNAL_FOOTER="includes/f.html";

//$EXTERNAL_CSS="../../css/stylesheet.css";

include_once("user.conf.inc.php");

?>
