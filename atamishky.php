<?php 
include_once("functions.inc.php");
include_once("user.conf.inc.php");

$action=$_GET["action"];
?>

<div class="atamishky">

<?php 
  if(isset($EXTERNAL_HEADER))
    include $EXTERNAL_HEADER 
?>

<div class="whitebox">
<div class="content">
<div align="right">
<form name="searchform" action="javascript:doSearch()" method="post">
<fieldset>
<legend>B&uacute;squeda</legend>
   T&iacute;tulo:      <input type="radio" name="tipo" id="t" checked="checked" />
   Descripci&oacute;n: <input type="radio" name="tipo" id="d" />
   <input type="text" name="q" />
   <input type="submit" value="Buscar" />
</fieldset>
</form>
</div>
<div class="entry1">
  <div class="entrybody" style="visibility:visible;">
<?php
      if($MENU_STYLE == "HORIZONTAL")
	print "<table id=\"filters\" width=\"100%\">";
      else // default: VERTICAL
	print "<table width=\"100%\">";
?>
<tr>
<td>
Ordenar Catálogo:
</td>
<?php

foreach ($MENU as $_category => $items)
{
  print "<td>";
  if($_category == "keywords")
    {
        //print "<b><a href=\"javascript:void(0)\" onclick=\"showCategory('','showkeywords')\">por ".$_category."</a></b>&#160;&#160;&#160;<br />";
        print "<b><a href=\"javascript:void(0)\" onclick=\"showCategory('','showkeywords')\">por "."tags"."</a></b>&#160;&#160;&#160;<br />";
    }

  else if($_category == "author")
    {
      print "<b><a href=\"javascript:void(0)\" onclick=\"showCategory('','showauthors')\">por "."autor"."</a></b>&#160;&#160;&#160;<br />";
    }
  else if($_category == "bibliografia")
    {
      print "<b><a href=\"javascript:void(0)\" onclick=\"showCategory('','showbibliografia')\">por ".$_category."</a></b>&#160;&#160;&#160;<br />";
    }
  else
    {
      print "<b><a href=\"javascript:void(0)\" onclick=\"showCategory('$_category','all')\">por ".$longname[$_category]."</a></b>&#160;&#160;&#160;<br />";

    }

  print "<ul>";

  if($_category == "keywords")
    {
      print "<li><a href=\"javascript:void(0)\" onclick=\"showCategory('','showkeywords')\">ver todos</a></li>"; 
    }
  if($_category == "author")
    {
      print "<li><a href=\"javascript:void(0)\" onclick=\"showCategory('','showauthors')\">ver todos</a></li>"; 
    }
  if($_category == "bibliografia")
    {
      print "<li><a href=\"javascript:void(0)\" onclick=\"showCategory('','showbibliografia')\">ver todos</a></li>"; 
    }

  foreach ($items as $_item)
  {
    $_itemtext = ($_category == "entrytype") ? $longnameEntrytype[$_item] : $_item;
    print "<li><a href=\"javascript:void(0)\" onclick=\"showCategory('$_category','$_item')\">".$_itemtext."</a></li>"; 
  }
  print "</ul>";
  print "</td>";
}
?>

</tr>
</table>
</div>
</div>
</div><!-- // categorytable -->

<?php
  if($action == "showkeywordscloud")
    {
      echo "<div class=\"content\">";
      echo "<div class=\"entry1\">";
      echo "<div id=\"keywordsCloud\" class=\"bigLinks\">";
      include("ajax.php");
      echo "</div>";
      echo "</div>";
      echo "</div>";
      echo "<script type=\"text/javascript\">toggleKeywordsCloud='s';</script>";
    }
else if($action == "showauthorlist")
    {
      echo "<div class=\"content\">";
      echo "<div class=\"entry1\">";
      echo "<div id=\"keywordsCloud\" class=\"authorListLinks\">";
      include("ajax.php");
      echo "</div>";
      echo "</div>";
      echo "</div>";
      echo "<script type=\"text/javascript\">toggleAuthorList='s';</script>";
    }
  else
    {
      echo "<div id=\"keywordsCloud\" class=\"bigLinks\">";
      echo "</div>";
    }

echo "<div id=\"CfPTable\">";
if($action != "showkeywordscloud" && $action != "showauthorlist")
    include("ajax.php");  // 'include' is google-friendly, allows index.php?blahblah
echo "</div>";
?>

</div> <!-- whitebox -->

<div class="bottomleft">
  <span>
<a href="index.php?action=copyright">Copyright</a> &#149;
ATAM - IUNA. 2015.
</span><br/><br/><br/>&nbsp;
</div> 
<?php 
  if(isset($EXTERNAL_FOOTER))
    include $EXTERNAL_FOOTER 
?>
</div> <!-- atamishky -->
