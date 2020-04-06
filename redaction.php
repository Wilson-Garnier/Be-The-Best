<?php
$bdd = new PDO("mysql:host=localhost;dbname=bdd_btb;charset=utf8", "bethe_best", "be_the_best_phpmyadmin_480");
$mode_edition = 0;
if(isset($_GET['edit']) AND !empty($_GET['edit'])) {
   $mode_edition = 1;
   $edit_id = htmlspecialchars($_GET['edit']);
   $edit_article = $bdd->prepare('SELECT * FROM article WHERE id = ?');
   $edit_article->execute(array($edit_id));
   if($edit_article->rowCount() == 1) {
      $edit_article = $edit_article->fetch();
   } else {
      die('Erreur : l\'article n\'existe pas...');
   }
}
if(isset($_POST['article_titre'], $_POST['article_contenu'])) {
   if(!empty($_POST['article_titre']) AND !empty($_POST['article_contenu'])) {
      
      $article_titre = htmlspecialchars($_POST['article_titre']);
      $article_contenu = htmlspecialchars($_POST['article_contenu']);
      if($mode_edition == 0) {
         // var_dump($_FILES);
         // var_dump(exif_imagetype($_FILES['miniature']['tmp_name']));
         $ins = $bdd->prepare('INSERT INTO article (titre, contenu, date_time_publication) VALUES (?, ?, NOW())');
         $ins->execute(array($article_titre, $article_contenu));
         $lastid = $bdd->lastInsertId();
         
         if(isset($_FILES['miniature']) AND !empty($_FILES['miniature']['name'])) {
            if(exif_imagetype($_FILES['miniature']['tmp_name']) == 2) {
               $chemin = 'miniatures/'.$lastid.'.jpg';'.png';'.jpeg';
               move_uploaded_file($_FILES['miniature']['tmp_name'], $chemin);
            } else {
               $message = 'Votre image doit être au format jpg';
            }
         }
         $message = 'Votre article a bien été posté';
      } else {
         $update = $bdd->prepare('UPDATE article SET titre = ?, contenu = ?, date_time_edition = NOW() WHERE id = ?');
         $update->execute(array($article_titre, $article_contenu, $edit_id));
         header('Location: http://127.0.0.1/fildactualite/article.php?id='.$edit_id);
         $message = 'Votre article a bien été mis à jour !';
      }
   } else {
      $message = 'Veuillez remplir tous les champs';
   }
}
?>
<!DOCTYPE html>
<html>
 <head>
        
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
        <link rel="icon" type="image/jpg" href="images/icon.jpg" width="100px"/>
        
        <title>BeTheBest - Rédaction</title>
    
    </head>
<body>

<div class="entete">
      
      <div class="img"><img src="images/logo.png" alt="" /></div>
   
   </div>
</br><br/>

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

      <a href="acceuil.php"><h4>◄ retour</h4></a></br><br/>

<hr/>

<h3>Saisissez un titre</h3>

   <form method="POST" enctype="multipart/form-data">
      <input type="text" name="article_titre" placeholder="Titre"<?php if($mode_edition == 1) { ?> value="<?= 
      $edit_article['titre'] ?>"<?php } ?> /><br /><br />
      
         <h3>Saisissez un contenu</h3>

      <textarea name="article_contenu" placeholder="Contenu de l'article"><?php if($mode_edition == 1) { ?><?= 
      $edit_article['contenu'] ?><?php } ?></textarea><br /><br />
      <?php if($mode_edition == 0) { ?>
      
         <h3>Insérer une image</h3>

      <input type="file" name="miniature" /><br /><br />
      <?php } ?>
      <br />
      
      <input class="favorite styled" type="submit" value="Envoyer l'article" />
   </form>
   <br />
   <?php if(isset($message)) { echo $message; } ?>
<hr/>

</body>
</html>