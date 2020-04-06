<?php
$bdd = new PDO("mysql:host=localhost;dbname=bdd_btb;charset=utf8", "bethe_best", "be_the_best_phpmyadmin_480");
if(isset($_GET['id']) AND !empty($_GET['id'])) {
   $get_id = htmlspecialchars($_GET['id']);
   $article = $bdd->prepare('SELECT * FROM article WHERE id = ?');
   $article->execute(array($get_id));
   if($article->rowCount() == 1) {
      $article = $article->fetch();
      $id = $article['id'];
      $titre = $article['titre'];
      $contenu = $article['contenu'];
      $likes = $bdd->prepare('SELECT id FROM likes WHERE id_article = ?');
      $likes->execute(array($id));
      $likes = $likes->rowCount();
      $dislikes = $bdd->prepare('SELECT id FROM dislikes WHERE id_article = ?');
      $dislikes->execute(array($id));
      $dislikes = $dislikes->rowCount();
   } else {
      die('Cet article n\'existe pas !');
   }
} else {
   die('Erreur');
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>BeTheBest - Article </title>
  <link rel="icon" type="image/jpg" href="images/icon.jpg" width="100px"/>
</head>

<style>
 body
{
background-color:#FAFAFA ;
}
h1
{
color:#AE0000;
}
a
{
color:black;
text-decoration:none; 
}


}


</style>

<body>

   <h1 class="titre" align="center"> Be The Best </h1></br><br/>

   <a href="acceuil.php"><h4>◄ retour</h4></a></br><br/>

   <hr/>

   <img src="miniatures/<?= $id ?>.jpg" width="400" />
   <u><h3><?= $titre ?></h3></u>
   <p><?= $contenu ?></p>

   <hr/><br/><br/>

   <a href="action.php?t=1&id=<?= $id ?>">Best &#128081; </a> (<?= $likes ?>)
   <br />
   <a href="action.php?t=2&id=<?= $id ?>">Bad &#x1F63F; </a> (<?= $dislikes ?>) 
</body>
</html>