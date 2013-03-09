<?php

$id=$_GET["id"];
$cat=$_GET["cat"];
$limit=10;
$start=$_GET["start"];
if (!$start or $start<0) $start=0;

//lista kiírása
$res=myquery("select count(id) from rss where active=1 ");
$count=intval($res[0]["count(id)"]);
$result=myquery("select *
 				from rss where
 				active=1 order by pubdate desc limit ?, ?", $start, $limit);

foreach($result as $row){
	$rid=$row["id"];
	$rtitle=$row["title"];
	$rdesc=htmlspecialchars_decode($row["description"]);
	$rlink=$row["link"];
	$post.="
	<div class='post'>
		<div class='title'><a href='$rlink' target='_blank'>$rtitle</a></div>
		<div class='text'>$rdesc</div>
		<div class='next'><a href='$rlink' target='_blank'>Tovább</a></div>
	 </div>
	 ";	
}


if ($start>0) $pager.="
        	<div class='new'>
                <a href='index.php?start=".($start-$limit)."'>Újabbban..</a>
            </div>\n";
if ($start+$limit<$count) $pager.="
        <div class='old'>
                <a href='index.php?start=".($start+$limit)."'>Korábban..</a>
        </div>\n";
$page=intval($start/$limit)+1;
if($page>1){
	$pager.="<div align='center' style='margin: 25px;'>$page. oldal</div>\n";
}

?>