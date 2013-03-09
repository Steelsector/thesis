<?php
//ha volt módosítás, elmentjük
if($_POST["save"]){
myquery("update articles set title='?', text='?', sc_link='?' where id='?'",$_POST["title"], $_POST["text"], $_POST["sc_link"], $art);
}

//lekérjük a cikket
$result=myquery("select * from articles where id='?'", $art);

//text field, link mentés
if(count($result)){
	$title=$result[0]["title"];
	$text=$result[0]["text"];
	$sc_link=$result[0]["sc_link"];
	$article.="
		<form method='post' enctype='multipart/form-data'>
		<p align='center'><input type='text' name='title' value='$title'/></p>
		<div id='cked' align='center'>
		<script src='ckeditor/ckeditor.js'></script>
		<textarea id='text' name='text'>$text</textarea>
		<script type='text/javascript'>
		<!--
		CKEDITOR.replace('text', {width: 400, height: 300});
		//-->
		</script>
		</div>
		<p align='center'>Soundcloud widget code src:<input type='text' id='sc_link' name='sc_link' value='$sc_link'></p>	
		<p align='center'><input type='submit' name='save' value='Save'></p>
		</form>
		";
}
?>