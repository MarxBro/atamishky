<?php
include_once("functions.inc.php");
include_once("user.conf.inc.php");

$action=$_GET["action"];
$by=$_GET["by"];
$pub=$_GET["pub"];

print "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\"
\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">"
?>

<html xmlns="http://www.w3.org/1999/xhtml" lang="es-AR" xml:lang="en-US">
<head>
<meta http-equiv="Content-type" content="text/xhtml+xml; charset=utf-8" />
<meta name="robots" content="index,follow" />
<?php
print "<meta name=\"keywords\" content=\"".$PAGE_KEYWORDS."\" />";
print "<meta name=\"description\" content=\"".$PAGE_DESCRIPTION."\"/>";
print "<title>".$PAGE_TITLE."</title>";
print "<link rel=\"shortcut icon\" href=\"".$FAVICON."\" />";    
print "<link rel=\"unapi-server\" type=\"application/xml\" title=\"unAPI\" href=\"".$atamishky_HOME."/unapi.php\" />";
if(isset($EXTERNAL_CSS))
    print "<link href=\"".$EXTERNAL_CSS."\" rel=\"stylesheet\" type=\"text/css\" />";
    print "<link href=\"".$atamishky_HOME."/site.css\" rel=\"stylesheet\" type=\"text/css\" />";
    print "<script id=\"atamishkyjs\" src=\"".$atamishky_HOME."/ajax.js\" type=\"text/javascript\"></script>";
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>
<script type="text/javascript" src="/includes/qp.js"></script>
<script type="text/javascript">
/* <![CDATA[ */
$(document).ready(function() {
        //$("ul.paging").quickPager();
	$("div.content").quickPager({pagerLocation:"both"});

});
/* ]]> */
</script>
</head>
<body>
<?php
include "atamishky.php";
?>
</body>
</html>
