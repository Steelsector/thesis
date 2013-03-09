<?php
$art=$_GET["art"];
if (!$art) $art=0;
if ($_POST["arttitle"]) {
  myquery("insert into articles set title='?',
                                    category='?',
                                    user='?'",
                                    $_POST["arttitle"], $cat, $_SESSION["uid"]);
  $art=myinsertid();
  header("Location: index.php?cat=$cat&art=$art");
}

if ($_POST["artdel"]) {
  myquery("update articles set active=0 where id='?'",$_POST["artdel"]);
}
$result=myquery("select * from articles where active=1 and category=$cat order by id");
foreach ($result as $row) {
  $rowid=$row["id"];
  $rowtitle=$row["title"];
  if ($rowid==$art){
    $class="active";
    } else {
      $class="passive";
    }
  $articles.="
  <div id='article_item'>
    <form method='post'>
      <a href='index.php?cat=$cat&art=$rowid' class='$class'>$rowtitle</a>
      <input type='hidden' name='artdel' value='$rowid' />
      <input type='submit' value='Delete' />
    </form>
  </div>  
  ";
}
//articles title megadás
$articles.="
  <form method='post'>
    <input type='text' name='arttitle' />
    <input type='submit' name='newart' value='OK' />
  </form>"; 
?>
