<?php
include_once ( "functions.inc.php" );
include_once ( "user.conf.inc.php" );

$action = $_GET["action"];
$by     = $_GET["by"]    ;
$pub    = $_GET["pub"]   ;

if($action != null){
    if($action == "showbib"){
        $xmlfile         = 'bibtex.xml';
        $xslfile         = 'showbib.xsl';
        $params['pubid'] = $pub;
        echo transform($xmlfile, $xslfile, $params);
    }
    else if($action == "showentrydetail") {
        $xmlfile                         = 'bibtex.xml';
        $xslfile                         = 'showentrydetail.xsl';
        $params['pubid']                 = $pub;
        $params['atamishkyhome']         = $atamishky_HOME;
        $params['atamishkyembeddingurl'] = $atamishky_EMBEDDING_URL;
        echo transform($xmlfile, $xslfile, $params);
    }
    else if($action == "showkeywordscloud") {
        $xmlfile = 'bibtex.xml';
        $xslfile = 'showkeywordscloud.xsl';
        echo transform($xmlfile, $xslfile, $params);
    }
    else if($action == "showauthorlist") {
        $xmlfile = 'bibtex.xml';
        $xslfile = 'showauthorlist.xsl';
        echo transform($xmlfile, $xslfile, $params);
    }
    else if($action == "showbibliografia") {
        $xmlfile = 'bibtex.xml';
        $xslfile = 'showbibliografia.xsl';
        echo transform($xmlfile, $xslfile, $params);
    }
    else if($action == "showcategory") {	
        $categoryby   = $by;
        $categorytype = $pub;
        $sorttype     = $by;
        $breadcrumb1  = "por " . $longname[$categoryby];
        if ( $categoryby == 'entrytype' ) {
            $breadcrumb2 = $longnameEntrytype[$categorytype];
        } else {
            $breadcrumb2 = $categorytype;
        }

        $xmlfile                         = 'bibtex.xml';
        $xslfile                         = 'bibtex.xsl';
        $params['categoryby']            = $categoryby;
        $params['categorytype']          = $categorytype;
        $params['sorttype']              = $sorttype;
        $params['breadcrumb1']           = $breadcrumb1;
        $params['breadcrumb2']           = $breadcrumb2;
        $params['atamishkyhome']         = $atamishky_HOME;
        $params['atamishkyembeddingurl'] = $atamishky_EMBEDDING_URL;
        echo transform($xmlfile, $xslfile, $params);
    }
    else if($action == 'copyright') {
        include('copyright.php');
    }
} else {
    // $pub empty, action empty -> index.php
    $xmlfile                         = 'bibtex.xml';
    $xslfile                         = 'bibtex.xsl';
    $params['categoryby']            = "year";
    $params['categorytype']          = "all";
    $params['sorttype']              = "year";
    $params['breadcrumb1']           = "por año";
    $params['breadcrumb2']           = "todos";
    $params['atamishkyhome']         = $atamishky_HOME;
    $params['atamishkyembeddingurl'] = $atamishky_EMBEDDING_URL;
    echo transform( $xmlfile, $xslfile, $params );
}

// si la acción no es ninguna de estas (y milagrosaente es algo),
// mostrar el permalink de cualquier forma... no se bien para que, pero
// en lugar de dejarlo en manos del xsl, esta aca.
if (    $action != null && 
        $action != "showentrydetail" && 
        $action != "showbibliografia" && 
        $action != "showbib" && 
        $action != "showkeywordscloud" && 
        $action != "showauthorlist" && 
        $action != "copyright" && 
        $action != "search" 
    ) {
    echo "<div class=\"content\">";
    echo "<div class=\"entry1\">";
    echo "<div class=\"entrybody\" style=\"visibility:visible;\">";
    echo "Enlace a esta pagina (Permalink): <br/>";

    $permalink = $atamishky_EMBEDDING_URL . "?action=" . $action;

    if ( $by != null ) {
        $permalink = $permalink . "&amp;by=" . $by;
    }
    if ( $pub != null ) {
        $permalink = $permalink . "&amp;pub=" . $pub;
    }

    echo "<a href=\"".$permalink."\">".$permalink."</a>";
    echo "</div>";
    echo "</div>";
    echo "</div>";

}

?>
