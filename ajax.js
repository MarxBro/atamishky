var xmlHttp;
var toggleBib = {};
var toggleAPA = {}; 
var toggleISO = {}; 
var toggleEntryDetail = {};
var toggleKeywordsCloud = 'h';
var toggleAuthorList = 'h';
var loadingMessage = "<div class=\"loading\">Loading...</div>";
var jspathel = document.getElementById('atamishkyjs');
var jspath = jspathel.getAttribute('src');
var atamishky_home_dir = jspath.substring(0, jspath.lastIndexOf('/')+1); 

function showCategory(strBy, str) { 
    toggleBib = {};
    toggleAPA = {};
    toggleISO = {};
    toggleEntryDetail = {};
    xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null) {
        alert ("Browser does not support HTTP Request");
        return;
    }
    // s for show
    if(str == "showkeywords"){
        toggleKeywordsCloud = 's';
        showKeywordsCloud();
    } else if(str == "showauthors"){
        toggleAuthorList = 's';
        showAuthorList();
    } else if(str == "showbibliografia") {
        toggleBiblioList = 's';
        showbibiografialist();
    } else if(str == "showaddress") {
        toggleAdList = 's';
        showaddresslist();
    } else {
        toggleKeywordsCloud = 'h';
        toggleAuthorList = 'h';
        toggleBiblioList = 'h';

        // this is because div with id keywordsCloud appears alone or inside div (class entry1), depending the case.
        kc=document.getElementById("keywordsCloud");
        if (kc.parentNode.className == "entry1"){ 
            document.getElementById("keywordsCloud").parentNode.style.display = "none"; 
        } else {
            document.getElementById("keywordsCloud").innerHTML="";
        }
        var url=atamishky_home_dir+"ajax.php";
        url=url+"?action=showcategory&by="+strBy+"&pub="+str;
        url=url+"&sid="+Math.random();
        xmlHttp.onreadystatechange=stateChanged;
        xmlHttp.open("GET",url,true);
        xmlHttp.send(null);
    }
}

function stateChanged() { 
    if (xmlHttp.readyState<4){
        document.getElementById("CfPTable").innerHTML=loadingMessage;
    } else if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
        document.getElementById("CfPTable").innerHTML=xmlHttp.responseText;
            if(toggleKeywordsCloud == 'h'){
                document.getElementById("keywordsCloud").innerHTML="";
            } else if(toggleAuthorList == 'h'){
                document.getElementById("keywordsCloud").innerHTML=""; // both have same id
            }
    } 
}
function getBib(pub) { 
    /*hide_bibtex_div(pub);*/
    if(toggleBib[pub]!='s') {
        toggleBib[pub]='s';
        toggleAPA[pub]='h';
        toggleISO[pub]='h';
        xmlHttp=GetXmlHttpObject();
        if (xmlHttp==null) {
         alert ("Browser does not support HTTP Request");
         return;
         } 
        // alert ("getBib called")
        var url=atamishky_home_dir+"ajax.php";
        url=url+"?action=showbib&pub="+pub;
        url=url+"&sid="+Math.random();
        xmlHttp.onreadystatechange=function () { 
                                        openBib(pub, xmlHttp);
                                        }
        xmlHttp.open("GET",url,true);
        xmlHttp.send(null);
    }
    else {
        hide_bibtex_div(pub);
    /**//*toggleBib[pub]='h';*/
    /*toggleBib[pub]='h';*/
    /*document.getElementById("bib"+pub).innerHTML='';*/
    }
}

function getAPA(pub) { 
    if(toggleAPA[pub]!='s') {
        toggleAPA[pub]='s';
        toggleBib[pub]='h';
        toggleISO[pub]='h';
        xmlHttp=GetXmlHttpObject();
        if (xmlHttp==null) {
         alert ("Browser does not support HTTP Request");
         return;
         } 
        var url=atamishky_home_dir+"ajax.php";
        url=url+"?action=showAPA&pub="+pub;
        url=url+"&sid="+Math.random();
        xmlHttp.onreadystatechange=function () { 
                                        openBib(pub, xmlHttp);
                                        }
        xmlHttp.open("GET",url,true);
        xmlHttp.send(null);
    }
    else {
        hide_bibtex_div(pub);
    }
}
function getISO(pub) { 
    if(toggleISO[pub]!='s') {
        toggleISO[pub]='s';
        toggleBib[pub]='h';
        toggleAPA[pub]='h';
        xmlHttp=GetXmlHttpObject();
        if (xmlHttp==null) {
         alert ("Browser does not support HTTP Request");
         return;
         } 
        var url=atamishky_home_dir+"ajax.php";
        url=url+"?action=showISO&pub="+pub;
        url=url+"&sid="+Math.random();
        xmlHttp.onreadystatechange=function () { 
                                        openBib(pub, xmlHttp);
                                        }
        xmlHttp.open("GET",url,true);
        xmlHttp.send(null);
    } 
    else {
        hide_bibtex_div(pub);
    }
}
function hide_bibtex_div(pub){
    toggleBib[pub]='h';
    toggleAPA[pub]='h';
    toggleISO[pub]='h';
    document.getElementById("bib"+pub).innerHTML='';
    document.getElementById("bib"+pub).style.visibility="none";
}

function openBib(pub, xmlHttp) { 
    document.getElementById("bib"+pub).style.visibility="visible";
    if (xmlHttp.readyState<4) { 
        document.getElementById("bib"+pub).innerHTML=loadingMessage;
    } else if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
        document.getElementById("bib"+pub).innerHTML=xmlHttp.responseText;
    } 
}

function getEntryDetail(pub){ 
    if(toggleEntryDetail[pub]!='s') {
        toggleEntryDetail[pub]='s';
        xmlHttp=GetXmlHttpObject();
        if (xmlHttp==null)
        {
         alert ("Browser does not support HTTP Request");
         return;
         } 
        var url=atamishky_home_dir+"ajax.php";
        url=url+"?action=showentrydetail&pub="+pub;
        url=url+"&sid="+Math.random();
        xmlHttp.onreadystatechange=function () { 
                                        openEntryDetail(pub, xmlHttp);
                                        };
        /*esta llamada no es asincrona, como todas las demas.    */
        /*xmlHttp.open("GET",url,true)*/
        xmlHttp.open("GET",url,false);
        xmlHttp.send(null);
    } else {
        toggleEntryDetail[pub]='h';
        toggleBib[pub]='h';
        document.getElementById("entrydetail"+pub).innerHTML='';
        document.getElementById("entrydetail"+pub).style.visibility="hidden";
        document.getElementById("bib"+pub).innerHTML='';
        document.getElementById("bib"+pub).style.visibility="hidden";
    }
}

function openEntryDetail(pub, xmlHttp){ 
    document.getElementById("entrydetail"+pub).style.visibility="visible";
    if (xmlHttp.readyState<4){ 
        document.getElementById("entrydetail"+pub).innerHTML=loadingMessage;
    } else if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
        document.getElementById("entrydetail"+pub).innerHTML=xmlHttp.responseText;
    } 
}

function GetXmlHttpObject() {
    var xmlHttp=null;
    try {
        // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer
        try {
            xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) { 
            xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}

function showKeywordsCloud() { 
    toggleKeywordsCloud='s';
    xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null) {
        alert ("Browser does not support HTTP Request");
        return;
    } 
    var url=atamishky_home_dir+"ajax.php";
    url=url+"?action=showkeywordscloud";
    url=url+"&sid="+Math.random();
    xmlHttp.onreadystatechange=stateChangedKeywords;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}

function showAuthorList() { 
    toggleAuthorList='s';
    xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null) {
        alert ("Browser does not support HTTP Request");
        return;
    } 
    var url=atamishky_home_dir+"ajax.php";
        url=url+"?action=showauthorlist";
        url=url+"&sid="+Math.random();
        xmlHttp.onreadystatechange=stateChangedKeywords;
        xmlHttp.open("GET",url,true);
        xmlHttp.send(null);
}

function showbibiografialist() { 
    toggleBiblioList='s';
    xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null) {
        alert ("Browser does not support HTTP Request");
        return;
    }
    var url=atamishky_home_dir+"ajax.php";
    url=url+"?action=showbibliografia";
    url=url+"&sid="+Math.random();
    xmlHttp.onreadystatechange=stateChangedKeywords;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}

function showaddresslist() { 
    toggleAdList='s';
    xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null) {
        alert ("Browser does not support HTTP Request");
        return;
    } 
    var url=atamishky_home_dir+"ajax.php";
    url=url+"?action=showaddress";
    url=url+"&sid="+Math.random();
    xmlHttp.onreadystatechange=stateChangedKeywords;
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}

function stateChangedKeywords() { 
    if (xmlHttp.readyState<4) { 
        document.getElementById("keywordsCloud").innerHTML=loadingMessage; 
        document.getElementById("CfPTable").innerHTML="";
    } else if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
        document.getElementById("keywordsCloud").innerHTML=xmlHttp.responseText; 
        document.getElementById("CfPTable").innerHTML="";
    } 
}

function doSearch() {
    var query = document.forms['searchform'].q.value;
    if ( document.getElementById('x').selected ){
        showCategory('searchTODO',query.toLowerCase());    
    } else if ( document.getElementById('d').selected ) {
        showCategory('searchdescripcion', query.toLowerCase());
    } else if ( document.getElementById('a').selected ) {
        //showCategory('searchautor', query.toLowerCase());
        search_autores(query.toLowerCase());
    } else if ( document.getElementById('t').selected ){    // Titulo
        showCategory('searchtitle', query.toLowerCase());
    } else if ( document.getElementById('l').selected ){    // libros
        showCategory('searchLIBROS', query.toLowerCase());
    } else if ( document.getElementById('mi').selected ){   // miscelaneos
        showCategory('searchMISC', query.toLowerCase());
    } else if ( document.getElementById('v').selected ){    // videos
        showCategory('searchVIDEOS', query.toLowerCase());
    } else if ( document.getElementById('mu').selected ){   // musica
        showCategory('searchMUSICAS', query.toLowerCase());
    } else {
        showCategory('searchTODO', query.toLowerCase());    // TODO, default.
    }
}

/*
    Si la busqueda es por autor
        1 - Traer toda a lista de autores,
        2 - Filtar los nombres de autores que no coinciden.
        3 - Escribir el HTML resultante (como si nada hubiera pasado).
*/
function search_autores(buscado){
    toggleAuthorList='s';
    xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null){
        alert ("Browser does not support HTTP Request");
        return;
    } 
    var url=atamishky_home_dir+"ajax.php";
    url=url+"?action=showauthorlist";
    url=url+"&sid="+Math.random();
    xmlHttp.onreadystatechange=function(){ stateChangedKeywords_filter(buscado); };
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}
function stateChangedKeywords_filter(buscado){
    if (xmlHttp.readyState<4) { 
        document.getElementById("keywordsCloud").innerHTML=loadingMessage; 
        document.getElementById("CfPTable").innerHTML="";
    } else if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
        var resultado_query = '<html>' + xmlHttp.responseText + '</html>';
        var parser = new DOMParser(); // necesito un parser nuevo, porque no hay DOM.
        var lista_resultado_query = parser.parseFromString(resultado_query,"text/xml");
        var lis = lista_resultado_query.querySelectorAll('ul li');
        var re = new RegExp(buscado, "i");
        var vergo = '';
        var cuenta = 0;
        for(var i=0; li=lis[i]; i++) {
            var puto = lis[i].firstChild;
            var text = puto.innerText || puto.textContent;
            if (re.test(text)) {
                var litexto = li.innerText || li.textContent;
                vergo += '<li><a href="javascript:void(0)" onclick="showCategory(\'author\',\'' + litexto + '\')">' + litexto + '</a></li>';
                cuenta++;
            }
        }
        if (cuenta == 0){
            vergo = "No hubo resultados";
        }
        document.getElementById("keywordsCloud").innerHTML='<ul>'+ vergo +'</ul>'; 
        document.getElementById("CfPTable").innerHTML="";
    } 
}

function eventFire(el, etype){
  if (el.fireEvent) {
    el.fireEvent('on' + etype);
  } else {
    var evObj = document.createEvent('Events');
    evObj.initEvent(etype, true, false);
    el.dispatchEvent(evObj);
  }
}
function dale(){
  var todosTriggear = document.getElementsByClassName('clicky');
  for(var i = 0; i < todosTriggear.length; i++) {
    var esta = todosTriggear[i];
    /*console.log(esta);*/
    /*console.log(i);*/
    eventFire(esta,'click');
  }
}
/* Conseguir todos los items prestados. */
function getprs_items(){
    xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null){
        alert ("Browser does not support HTTP Request");
        return;
    } 
    var url=atamishky_home_dir+"ajax.php";
    url=url+"?action=getprs";
    url=url+"&sid="+Math.random();
    xmlHttp.onreadystatechange=function(){ stateChangedKeywords_prs(); };
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}
function stateChangedKeywords_prs(){
    if (xmlHttp.readyState<4) { 
        document.getElementById("keywordsCloud").innerHTML=loadingMessage; 
        document.getElementById("CfPTable").innerHTML="";
    } else if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
        var resultado_querido = '<html>' + xmlHttp.responseText + '</html>';
        var parsearte = new DOMParser(); // necesito un parser nuevo, porque no hay DOM.
        var lista_ar = parsearte.parseFromString(resultado_querido,"text/xml");
        var prsss = lista_ar.querySelectorAll('p');
        var vergota = '<div class="content_pager">';
        var cuenta = 0;
        for(var i=0; it_pr=prsss[i]; i++) {
            var texto = it_pr.innerText || it_pr.textContent;
            xmlHttp=GetXmlHttpObject();
            if (xmlHttp==null){
                alert ("Browser does not support HTTP Request");
                return;
            } 
            var url=atamishky_home_dir+"ajax.php";
            url=url+"?action=showcategory&by=ID&pub="+texto;
            url=url+"&xxx=xxx&sid="+Math.random();
            xmlHttp.onreadystatechange=function(){ 
                if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
                    var pe  = new DOMParser(); // necesito un parser nuevo, porque no hay DOM.
                    var Cnt = pe.parseFromString(xmlHttp.responseText,"text/xml");
                    var add_me = lista_ar.getElementById('cntt');
                    vergota += add_me;
                }                
            };
            xmlHttp.open("GET",url,false);
            xmlHttp.send(null);
            cuenta++;
        }
        if (cuenta == 0){
            vergota = "No hubo resultados";
        }
        document.getElementById("CfPTable").innerHTML= vergota + '</div>';
        document.getElementById("keywordsCloud").innerHTML= ""; 
    } 
}
