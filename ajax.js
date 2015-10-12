var xmlHttp;
var toggleBib = {};
var toggleEntryDetail = {};
var toggleKeywordsCloud = 'h';
var toggleAuthorList = 'h';
var loadingMessage = "<div class=\"loading\">Loading...</div>";

var jspathel = document.getElementById('atamishkyjs');
var jspath = jspathel.getAttribute('src');
var atamishky_home_dir = jspath.substring(0, jspath.lastIndexOf('/')+1); 
// e.g. http://www.aaa.com/atamishky/

function showCategory(strBy, str)
{ 
toggleBib = {};
toggleEntryDetail = {};

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 } 

//alert ("showCategory called");

if(str == "showkeywords")
 {
// s for show
  toggleKeywordsCloud = 's';
  showKeywordsCloud();
 }
else if(str == "showauthors")
 {
// s for show
  toggleAuthorList = 's';
  showAuthorList();
 }
else if(str == "showbibliografia")
 {
// s for show
  toggleBiblioList = 's';
  showbibiografialist();
 }
else if(str == "showaddress")
 {
// s for show
  toggleAdList = 's';
  showaddresslist();
 }
else
 {
// h for hide
  toggleKeywordsCloud = 'h';
  toggleAuthorList = 'h';
  toggleBiblioList = 'h';
     
     // this if-else is because div with id keywordsCloud appears alone for some cases and inside div (class entry1) in some other cases.
     kc=document.getElementById("keywordsCloud");
     if (kc.parentNode.className == "entry1") //(strBy == "keyword")
	 document.getElementById("keywordsCloud").parentNode.style.display = "none"; // authorlist also has some div id.
     else
	 document.getElementById("keywordsCloud").innerHTML="";

  var url=atamishky_home_dir+"ajax.php"
  url=url+"?action=showcategory&by="+strBy+"&pub="+str
  url=url+"&sid="+Math.random()
  xmlHttp.onreadystatechange=stateChanged 
  xmlHttp.open("GET",url,true)
  xmlHttp.send(null)
 }
}

function stateChanged() 
{ 
 if (xmlHttp.readyState<4)
   document.getElementById("CfPTable").innerHTML=loadingMessage
 else if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("CfPTable").innerHTML=xmlHttp.responseText 
 if(toggleKeywordsCloud == 'h')
     document.getElementById("keywordsCloud").innerHTML="";
 else  if(toggleAuthorList == 'h')
     document.getElementById("keywordsCloud").innerHTML=""; // they have same div id

 } 
}

function getBib(pub)
{ 
if(toggleBib[pub]!='s')
{
	toggleBib[pub]='s';
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
 	{
	 alert ("Browser does not support HTTP Request")
	 return
	 } 
	// alert ("getBib called")
	var url=atamishky_home_dir+"ajax.php"
	url=url+"?action=showbib&pub="+pub
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=function () { 
                                    openBib(pub, xmlHttp);
                                    }
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}
else
{
	toggleBib[pub]='h';
	document.getElementById("bib"+pub).innerHTML='';
}
}


function openBib(pub, xmlHttp) 
{ 
 document.getElementById("bib"+pub).style.visibility="visible";
 if (xmlHttp.readyState<4)
 { 
 document.getElementById("bib"+pub).innerHTML=loadingMessage
 }
 else if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("bib"+pub).innerHTML=xmlHttp.responseText 
 } 
}

function getEntryDetail(pub)
{ 
    
if(toggleEntryDetail[pub]!='s')
{
	toggleEntryDetail[pub]='s';
	xmlHttp=GetXmlHttpObject()
	if (xmlHttp==null)
 	{
	 alert ("Browser does not support HTTP Request")
	 return
	 } 
	// alert ("getEntryDetail called")
	var url=atamishky_home_dir+"ajax.php"
	url=url+"?action=showentrydetail&pub="+pub
	url=url+"&sid="+Math.random()
	xmlHttp.onreadystatechange=function () { 
                                    openEntryDetail(pub, xmlHttp);
                                    }
	xmlHttp.open("GET",url,true)
	xmlHttp.send(null)
}
else
{
	toggleEntryDetail[pub]='h';
	toggleBib[pub]='h';
	document.getElementById("entrydetail"+pub).innerHTML='';
	document.getElementById("entrydetail"+pub).style.visibility="hidden";
	document.getElementById("bib"+pub).innerHTML='';
	document.getElementById("bib"+pub).style.visibility="hidden";
}
}

function openEntryDetail(pub, xmlHttp) 
{ 
 document.getElementById("entrydetail"+pub).style.visibility="visible";
 if (xmlHttp.readyState<4)
 { 
 document.getElementById("entrydetail"+pub).innerHTML=loadingMessage
 }
 else if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("entrydetail"+pub).innerHTML=xmlHttp.responseText 
 } 
}


function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}



function showKeywordsCloud()
{ 
toggleKeywordsCloud='s';

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 } 

//alert ("showKeywordsCloud called");

var url=atamishky_home_dir+"ajax.php"
url=url+"?action=showkeywordscloud"
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChangedKeywords
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}

function showAuthorList()
{ 
toggleAuthorList='s';

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 } 

//alert ("showAuthorList called");

var url=atamishky_home_dir+"ajax.php"
url=url+"?action=showauthorlist"
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChangedKeywords
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}

//agregado 

function showbibiografialist()
{ 
toggleBiblioList='s';

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 } 

var url=atamishky_home_dir+"ajax.php"
url=url+"?action=showbibliografia"
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChangedKeywords
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}

/*agregado*/
function showaddresslist()
{ 
toggleAdList='s';

xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 } 

var url=atamishky_home_dir+"ajax.php"
url=url+"?action=showaddress"
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChangedKeywords
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}

function stateChangedKeywords() 
{ 
  if (xmlHttp.readyState<4)
 { 
 document.getElementById("keywordsCloud").innerHTML=loadingMessage; 
 document.getElementById("CfPTable").innerHTML="";
 } 
 else if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("keywordsCloud").innerHTML=xmlHttp.responseText; 
 document.getElementById("CfPTable").innerHTML="";
 } 
}

function doSearch()
{
    var query = document.forms['searchform'].q.value;
    if (document.getElementById('d').checked) {
        showCategory('searchdescripcion', query.toLowerCase());
    } else if (document.getElementById('a').checked) {
        //showCategory('searchautor', query.toLowerCase());
        // vamos a probar algo nuevo.
        search_autores(query.toLowerCase());
    } else {
        showCategory('searchtitle', query.toLowerCase());
    }
}

/*
Esto anduvo. No es muy elegante, pero xsl me tiene los huevos emplatados.
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
    xmlHttp.onreadystatechange=stateChangedKeywords_filter(buscado);
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}
/*esta funcion es llamada por lo de arriba*/
function stateChangedKeywords_filter(buscado){
    if (xmlHttp.readyState<4) { 
        document.getElementById("keywordsCloud").innerHTML=loadingMessage; 
        document.getElementById("CfPTable").innerHTML="";
    } else if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
        var resultado_query = xmlHttp.responseText;
        var parser = new DOMParser(); // necesito un parser nuevo, porque no hay DOM.
        var lista_resultado_query = parser.parseFromString(resultado_query,"text/xml");
        var lis = lista_resultado_query.querySelectorAll('#keywordsCloud li');
        // Hacer algun tipo de filtrado en la busqueda, no?
        var re = new RegExp(buscado, "gi");
        var vergo = '';
        for(var i=0; li=lis[i]; i++) {
            var puto = lis[i].children[0];
            var text = puto.innerText || puto.textContent;
            if (re.test(text)) {
                vergo += '<li><a href="javascript:void(0)" onclick="showCategory(\'author\',\'' + li.textContent + '\')">' + li.textContent + '</a></li>';
            }
        }
        document.getElementById("keywordsCloud").innerHTML='<ul>'+ vergo +'</ul>'; 
        document.getElementById("CfPTable").innerHTML="";
    } 
}
