<?php

include_once("functions.inc.php");

// MANDATORY: URL address of the bebop installation folder on your server (without trailing slash ('/') at the end).
$BEBOP_HOME="http://biblio.atamvirtual.com.ar";

// MANDATORY (if Bebop is embedded into a webpage): URL of the page where Bebop is embedded (included).
// e.g. http://madnessproject.org/publications-bebop/
// Otherwise, leave the default value
$BEBOP_EMBEDDING_URL=$BEBOP_HOME."/";

// MANDATORY: full path to the Java executable (needed by addpub.php)
$JAVA_EXECUTABLE="/usr/bin/java";

// OPTIONAL: page title
$PAGE_TITLE="ATAM bibliografía";

// OPTIONAL: page description
$PAGE_DESCRIPTION="Búsqueda de bibliografía en la Mediateca del ATAM";

// OPTIONAL: page keywords
$PAGE_KEYWORDS="ATAM, UNA, Mediatec, bibliografia, libros";

// OPTIONAL: favicon - used for the page and the RSS feed
//$FAVICON="http://www.alari.ch/favicon.ico";


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

// You can embed Bebop into your website by including bebop.php at any location in your web page as explained in
// http://www.alari.ch/~derino/Software/Bebop/index.php#sec-7 (section "Embedding Bebop to your own website")
// or
// alternatively, you can set header and footer html snippets using the options below:
//
// OPTIONAL: Bebop page can be customized by including a header file of your own. Specify below the path to your header file.
//$EXTERNAL_HEADER="includes/header.html";

// OPTIONAL: Bebop page can be customized by including a footer file of your own. Specify below the path to your footer file.
//$EXTERNAL_FOOTER="includes/footer.html";

// OPTIONAL: an external CSS file may be needed by EXTERNAL_HEADER and EXTERNAL_FOOTER
// relative path to external css from bebop home directory
//$EXTERNAL_CSS="../../css/stylesheet.css";

include_once("user.conf.inc.php");

?>
