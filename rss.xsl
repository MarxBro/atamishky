<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method='xml' version='1.0' encoding='UTF-8' indent='yes'/>

<xsl:param name="atamishkyhome">http</xsl:param>
<xsl:param name="pagetitle">title</xsl:param>
<xsl:param name="pagedescription">description</xsl:param>
<xsl:param name="favicon">favicon</xsl:param>

<xsl:template match="/">
<rss version="2.0">
  <channel>
    <title><xsl:value-of select="$pagetitle" /></title>
    <link rel="shortcut icon" href="{$favicon}"/>    
    <link><xsl:value-of select="$atamishkyhome" /></link>
    <description><xsl:value-of select="$pagedescription" /></description>
    <language>en-us</language>
    <copyright>ATAM</copyright>


<xsl:variable name="vMonthNames" 
    select="'|January|February|March|April|May|June|July|August|September|October|November|December'"/>

	<xsl:for-each select="entries/entry">
	<xsl:sort select="year" order="descending"/>
	<xsl:sort 
           select="string-length(concat(substring-before($vMonthNames,substring-before(month,' ')), substring-before($vMonthNames,month)))" data-type="number" order="descending" />

	<item>
	<title><xsl:value-of select="title"/></title>
	<xsl:variable name="pubid" select="@name" />
	<link><xsl:value-of select="$atamishkyhome" />/index.php?action=showcategory&amp;by=ID&amp;pub=<xsl:value-of select="@name"/></link>
	<description>
    <html><body>
        <xsl:for-each select="authors/author">
            <xsl:if test="position()=last()">y&#160;</xsl:if>
            <xsl:value-of select="."/>
            ;&#160;
        </xsl:for-each>
        <p><xsl:value-of select="title"/></p>
	    <p><xsl:value-of select="decripcion"/></p>
	    <p><xsl:value-of select="entrytype"/></p>
	    <p><xsl:value-of select="address"/></p>
	    <p><xsl:value-of select="year"/></p>
	    <p><xsl:value-of select="publisher"/></p>
	    <p><xsl:value-of select="link"/></p>
        </body></html>
	</description>
    	</item>
      	</xsl:for-each>
</channel>
</rss>

</xsl:template>
</xsl:stylesheet>
