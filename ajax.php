<?php
include_once ( "functions.inc.php" );
include_once ( "user.conf.inc.php" );

$action = sano( $_GET["action"] );
$by     = sano( $_GET["by"]     );
$pub    = sano( $_GET["pub"]    );
//$action = $_GET["action"] ;
//$by     = $_GET["by"]     ;
//$pub    = $_GET["pub"]    ;

if($action != null){
    //Links de formato del doc
    if($action == "showbib"){
        $xmlfile         = 'catalogo.xml';
        $xslfile         = validar_xsl('lib/showbib.xsl');
        $params['pubid'] = $pub;
        echo transform($xmlfile, $xslfile, $params);
    }
    if($action == "showAPA"){
        $xmlfile         = 'catalogo.xml';
        $xslfile         = validar_xsl('lib/showAPA.xsl');
        $params['pubid'] = $pub;
        echo transform($xmlfile, $xslfile, $params);
    }
    if($action == "showISO"){
        $xmlfile         = 'catalogo.xml';
        $xslfile         = validar_xsl('lib/showISO.xsl');
        $params['pubid'] = $pub;
        echo transform($xmlfile, $xslfile, $params);
    }
    //Link ajax al detalle de la accion
    else if($action == "showentrydetail") {
        $xmlfile                         = 'catalogo.xml';
        $xslfile                         = validar_xsl('lib/showentrydetail.xsl');
        $params['pubid']                 = $pub;
        $params['atamishkyhome']         = $atamishky_HOME;
        $params['atamishkyembeddingurl'] = $atamishky_EMBEDDING_URL;
        //--------------------
        //esto sirve para hacer que las entradas en el estado de los prestamos no aparezcan con los detalles toggleados de movida.
        $prty = sano($_GET["xxx"]);
        $params['nodetails'] = "false";
        if ($prty === "xxx"){
            $params['nodetails'] = "true";
        }
        //--------------------
        $resultado_pre_prestamo = transform($xmlfile, $xslfile, $params);
        //Procesar los prestamos.
        if ($pub){
            if (booked_items_check_status($pub)){
                $resultado_pre_prestamo = str_replace('Disponible', '<a href="javascript:void(0)" style="color: red;" onclick="getprs_items()">PRESTADO</a>', $resultado_pre_prestamo);
            }
        }
        //sacar div content, lo agrega ajax.js al vuelo.
        $sacar_div_container = '<div class="content_pager" id="cntt">';
        $sacar_div_container_ending = '</div></body>';
        $resultado_pre_prestamo = str_replace($sacar_div_container,'',$resultado_pre_prestamo);
        $resultado_pre_prestamo = str_replace($sacar_div_container_ending,'</body>',$resultado_pre_prestamo);
        echo $resultado_pre_prestamo;
    }
    else if($action == "showkeywordscloud") {
        $xmlfile = 'catalogo.xml';
        $xslfile = validar_xsl('lib/showkeywordscloud.xsl');
        echo transform($xmlfile, $xslfile, $params);
    }
    else if($action == "showauthorlist") {
        $xmlfile = 'catalogo.xml';
        $xslfile = validar_xsl('lib/showauthorlist.xsl');
        echo transform($xmlfile, $xslfile, $params);
    }
    else if($action == "showbibliografia") {
        $xmlfile = 'catalogo.xml';
        $xslfile = validar_xsl('lib/showbibliografia.xsl');
        echo transform($xmlfile, $xslfile, $params);
    }
    else if($action == "showaddress") {
        $xmlfile = 'catalogo.xml';
        $xslfile = validar_xsl('lib/showaddress.xsl');
        echo transform($xmlfile, $xslfile, $params);
    }
    else if($action == "getprs") {
        $rest = '<html><body>';
        $thingy = IcanHas_booked_items_array();
        foreach ($thingy as $prs){
            $rest .= '<p>' . $prs . '</p>';
        }
        $rest .= '</body></html>';
        echo $rest;
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
        $xmlfile                         = 'catalogo.xml';
        $xslfile                         = validar_xsl('lib/catalogo.xsl');
        $params['categoryby']            = $categoryby;
        $params['categorytype']          = $categorytype;
        $params['sorttype']              = $sorttype;
        $params['breadcrumb1']           = $breadcrumb1;
        $params['breadcrumb2']           = $breadcrumb2;
        $params['atamishkyhome']         = $atamishky_HOME;
        $params['atamishkyembeddingurl'] = $atamishky_EMBEDDING_URL;
        //echo transform($xmlfile, $xslfile, $params);
        $resultado_pre_prestamo = transform($xmlfile, $xslfile, $params);

        //Procesar los prestamos. II
        if ($pub){
            //solo aca es posible cambiar el estado del prestamo.
              if ($_GET["prestamo"]){
                $pass    =  $_GET["prestamo"];
                if (pass_prestamo($pass)){
                  booked_items_change_status($pub);
                  //echo "el estado ha cambiado desde -showcategory-";
                }
              }
            if (booked_items_check_status($pub)){
              // procesar el prestamo
                $resultado_pre_prestamo = str_replace('Disponible', '<a href="javascript:void(0)" style="color: red;" onclick="getprs_items()">PRESTADO</a>', $resultado_pre_prestamo);
            }
        } 
        echo $resultado_pre_prestamo;
    }
    else if($action == 'copyright') {
        include('copyright.php');
    }
    else if($action == 'ayuda') {
        include('ayuda.php');
    }
    else if($action == 'reglamento') {
        include('reglamento.php');
    }
} else {
    // $pub empty, action empty -> index.php
    $xmlfile                         = 'catalogo.xml';
    $xslfile                         = validar_xsl('lib/catalogo.xsl');
    $params['categoryby']            = "year";
    $params['categorytype']          = "all";
    $params['sorttype']              = "year";
    $params['breadcrumb1']           = "por año";
    $params['breadcrumb2']           = "todos";
    $params['atamishkyhome']         = $atamishky_HOME;
    $params['atamishkyembeddingurl'] = $atamishky_EMBEDDING_URL;
    echo transform( $xmlfile, $xslfile, $params );
}

//Mostrar el permalink si no es ninguna de estas pags.
if (    $action != null && 
        $action != "showentrydetail" && 
        $action != "showbibliografia" && 
        $action != "showaddress" && 
        $action != "showbib" && 
        $action != "showAPA" && 
        $action != "showISO" && 
        $action != "showkeywordscloud" && 
        $action != "showauthorlist" && 
        $action != "copyright" && 
        $action != "search"  &&
        $action != "getpr"  &&
        $action != "getprs" 
    ) {
    //este parámetro solo pasa si el request viene de los prestamos.
    if ($_GET['xxx'] != "xxx"){
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

}

?>
