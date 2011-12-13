<?php

ini_set('display_errors', 1);

$theme = array(
  'D' => 'green', // protest/govt response to protest
  'P' => 'orange', // political move
  'R' => 'red', // regime change
  'I' => 'blue', // international/external response
);

$fp = fopen('middle-east-road-timeline', 'r');
$events = array();
fgetcsv($fp, 0, "\t");
$writer = new xmlwriter();
$writer->openURI('2.rss');
//$writer->openURI('php://output');
//$writer->openMemory();
$writer->startDocument('1.0');
$writer->setIndent(4);
$writer->startElement('rss'); 
$writer->writeAttribute('version', '2.0'); 
$writer->writeAttribute('xmlns:geo', 'http://www.w3.org/2003/01/geo/wgs84_pos#');
$writer->writeAttribute('xmlns:dc', 'http://purl.org/dc/elements/1.1/');
$writer->writeAttribute('xmlns:georss', 'http://www.georss.org/georss/');
$writer->startElement('channel'); 
$writer->writeElement('title', 'Arab spring'); 
$writer->writeElement('pubDate', date("D, d M Y H:i:s O")); 
while($row = fgetcsv($fp, 0, "\t")) {
  $lat_longs = explode(";", $row[7]);
  foreach($lat_longs as $lat_long) {
      $writer->startElement('item');
      $writer->writeElement('title', $row[2]);
      $writer->startElement('description');
      $writer->writeCData($row[3]);
      $writer->endElement();
	  $writer->writeElement('image', $row[5]);
	  $writer->writeElement('eventIcon', $row[5]);
	  $writer->writeElement('date', $row[0]);
	  $writer->writeElement('country', $row[1]);
      $writer->writeElement('link', $row[4]);
	  $writer->writeElement('category', $row[6]);
	  $writer->writeElement('theme', $row[6]);
	  $date = DateTime::createFromFormat('d/m/Y', $row[0]);
      $writer->writeElement('pubDate', $date->format("D, d M Y H:i:s O"));
    if ($lat_long != '-') {
	  list($lat, $long) = explode(',', $lat_long);
      $writer->writeElement('geo:lat', $lat);
	  $writer->writeElement('geo:long', $long);
    }
	  $writer->endElement();
  }
}
$writer->endElement();
$writer->endElement();

/*
<item>
  <title>3.7 - 7.8 mi SW of Calexico, CA</title>
  <description><![CDATA[<img src="http://earthquake.usgs.gov/eqcenter/shakemap/thumbs/shakemap_sc_14420076.jpg" width="100" align="left" hspace="10"/><p>Date: Mon, 09 Feb 2009 21:53:58 UTC<br/>Lat/Lon: 32.605/-115.606<br/>Depth: 16.86</p>]]></description>
  <link>http://earthquake.usgs.gov/eqcenter/shakemap/sc/shake/14420076/</link>
  <pubDate>Mon, 09 Feb 2009 21:57:26 +0000</pubDate>
  <geo:lat>32.605</geo:lat>
  <geo:long>-115.606</geo:long>
  <dc:subject>3</dc:subject>
</item>