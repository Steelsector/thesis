<?php

$id=$_GET["id"];
$cat=$_GET["cat"];
$start=$_GET["start"]; if (!$start) $start=0;


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
	if($cat and is_numeric($cat)){
		$result=myquery("select *
						from articles a where
						category='?' and active=1 order by id desc limit ?, 5", $cat, $start);
	}else {
		$result=myquery("select *
		 				from articles a where
		 				active=1 order by id desc limit ?, 5", $start);
	}
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
$page=5;

if($start==0){
			$pager.="
					<div class='old' name='new'>
						<a href='index.php?start=$start+$page'>Older posts</a>
					</div>
			";
		} else {
			$pager.="
					<div class='new' name='new'>New posts
						<a href='index.php?start=$start-$page'>New Posts</a>
					</div>
					<div class='old' name='new'>
						<a href='index.php?start=$start+$page'>Older posts</a>
					</div>

			";
		}

?>