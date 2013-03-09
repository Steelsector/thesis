<?php

$id=$_GET["id"];
$cat=$_GET["cat"];
$limit=10;
$start=$_GET["start"];
if (!$start or $start<0) $start=0;

if($id and is_numeric($id)){
	//post kiírása
	$result=myquery("select * from articles where id=? and active=1", $id);
	if (count($result)){
			$title=$result[0]["title"];
			$text=htmlspecialchars_decode($result[0]["text"]);
			$sc_link=$result[0]["sc_link"];
			if (!$sc_link){	
			$post.="
			<div class='post'>
				<div class='title'>$title</div>
				<div class='text'>$text</div>
			 ";		 
			 $post.="</div>\n";
			} else {
				$post.="
			<div class='post'>
				<div class='title'>$title</div>
				<div class='text'>$text</div>
				 <div class='player'><iframe width='100%' height='166' scrolling='no' frameborder='no' src=$sc_link></iframe></div>
				";				
			 $post.="</div>\n";
			}
	}

} else {
//lista kiírása
	$res=myquery("select id from articles where category='?' and active=1 order by id desc", $cat);
	$count=count($res);
	if(count($res)==1){
		$aid=$res[0]["id"];
		header("Location: index.php?id=$aid");
		exit();
	}
	$result=myquery("select *
					from articles a where
					category='?' and active=1 order by id desc limit ?, ?", $cat, $start, $limit);
	foreach($result as $row){
		$aid=$row["id"];
		$atitle=$row["title"];
		$atext=htmlspecialchars_decode($row["text"]);
		$p=strpos($atext, "</p>")+4;
		$atext=substr($atext, 0, $p);
		$post.="
		<div class='post'>
			<div class='title'><a href='index.php?id=$aid'>$atitle</a></div>
			<div class='text'>$atext</div>
			<div class='next'><a href='index.php?id=$aid'>Tovább</a></div>
		 </div>
		 ";		
	}
}

if ($start>0) $pager.="
        	<div class='new'>
                <a href='index.php?start=".($start-$limit)."&cat=$cat'>Újabbban..</a>
            </div>\n";
if ($start+$limit<$count) $pager.="
        <div class='old'>
                <a href='index.php?start=".($start+$limit)."&cat=$cat'>Korábban..</a>
        </div>\n";
$page=intval($start/$limit)+1;
if($page>1){
	$pager.="<div align='center' style='margin: 25px;'>$page. oldal</div>\n";
}

?>