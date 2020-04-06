<?php
session_start(); ?>

<?php
$bdd = new PDO("mysql:localhost;dbname=bdd_btb;charset=utf8", "bethe_best", "be_the_best_phpmyadmin_480");
$articles = $bdd->query('SELECT * FROM article ORDER BY date_time_publication DESC');
?>
<!DOCTYPE html>
<html>
<head>
        
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
        <link rel="icon" type="image/jpg" href="images/icon.jpg" width="100px"/>
        
        <title>BeTheBest - Discover</title>
    
    </head>
   <a id="haut"></a>

   <div class="entete">
      
      <div class="img"><img src="images/logo.png" alt="" /></div>
   
   </div>
<body>


   
   <br> <div align="center"><img src="images/discover.png" alt="" width="10%" /></div><br>



<hr/>



   <h5><a href="redaction.php">Ajouter un article <img src="images/redaction.png" alt="" width="1%"/> |</a>

<a href="messagerie.html">Tchat Public <img src="images/tchat.png" alt="" width="1%"/> |</a>



<a href="contact.html">Nous contacter <img src="images/telephone.png" alt="" width="1%"/> |</a>
</h5>
<hr/>



   
      <?php while($a = $articles->fetch()) { ?>
     
         <h3><b><?= $a['titre'] ?></b></h3>

         <?= $a['date_time_publication'] ?><br/><br/><br/>
            <a href="article.php?id=<?= $a['id'] ?>">
            

            <img src="miniatures/<?= $a['id'] ?>.jpg" width="40%" /><br />

            <fieldset><br/><legend>Contenu</legend><?= $a['contenu'] ?></fieldset><br/><br/><br/>


            
         </a>
          
   
      <?php } ?>
   <a href="#haut"><img src="images/haut.jpg" alt="" width="1%"/></a>
</body>
</html>