#!/usr/bin/php5-cgi
<?php

include_once("conf/config.php");
myconnect();

$rss_source=0;
$result=myquery("select * from rss_source where active=1");
foreach ($result as $value) {
	$rss_source=$value["id"];
	$rss_link=$value["link"];

	@$f=fopen($rss_link, "r");
	if($f){
		$xml_parser = xml_parser_create();
		xml_set_element_handler($xml_parser, "startElement", "endElement");
		xml_set_character_data_handler($xml_parser, "characterData");
		while($line=fgets($f, 10000)){
			if(!xml_parse($xml_parser, $line, feof($f))){
				sprintf("XML error: %s a line %d",
							xml_error_string(xml_get_error_code($xml_parser)),
							xml_get_current_line_number($xml_parser));
			}
		}
		xml_parser_free($xml_parser);
		fclose($f);
	}
}

function startElement($parser, $name, $attrs){
	global $item, $tag;
	if ($name=="ITEM"){
		$item=array();
		$tag="";
	} else {
		$tag=$name;
	}
}

function characterData($parser, $data){
	global $tag, $item;
	if ($tag and trim($data)){
		$item[$tag].=$data;
	}
}

function endElement($parser, $name){
	global $item, $rss_source;
	if($name=="ITEM"){
		// idő átszámítása
		$months["Jan"]=1; $months["Feb"]=2; $months["Mar"]=3; $months["Apr"]=4;
		$months["May"]=5; $months["Jun"]=6; $months["Jul"]=7; $months["Aug"]=8;
		$months["Sep"]=9; $months["Oct"]=10; $months["Nov"]=11; $months["Dec"]=12;
		$pubdate=$item["PUBDATE"];
		$date=mktime(intval(substr($pubdate, 17, 2)), intval(substr($pubdate, 20, 2)), 0,
							$months[substr($pubdate, 8 ,3)],
							intval(substr($pubdate, 5, 2)), intval(substr($pubdate, 12, 4)));

		$title=str_replace('"', '\"', $item["TITLE"]);
		$link=str_replace('"', '\"', $item["LINK"]);
		$guid=str_replace('"', '\"', $item["GUID"]);
		$desc=str_replace('"', '\"', $item["DESCRIPTION"]);
		$comments=str_replace('"', '\"', $item["COMMENTS"]);
		$dc_creator=str_replace('"', '\"', $item["DC:CREATOR"]);
		$category=str_replace('"', '\"', $item["CATEGORY"]);
		$result=myquery("select * from rss where guid='?'", $guid);
		if (!$result) {
					myquery("insert into rss set title='?', link='?', pubdate='?', guid='?',
						description='?', comments='?', dc_creator='?',
						category='?', source='?' ",
						$title, $link, $date, $guid, $desc, $comments, $dc_creator, $category, $rss_source );
		}
	}
}
myclose();
?>