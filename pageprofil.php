<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=bdd_btb', 'bethe_best', 'be_the_best_phpmyadmin_480');

if(isset($_GET['id']) AND $_GET['id'] > 0) {
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM utilisateur WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
?>
<html>
  <head>
        
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
        <link rel="icon" type="image/jpg" href="images/icon.jpg" width="100px"/>
        
        <title>BeTheBest - Page Profil</title>
    
    </head>
   <body>

       <div class="entete">
      
      <div class="img"><img src="images/logo.png" alt="" /></div>
   
   </div>

         <a href="index.html"><h4 align="right">Déconnexion <img src="images/power.png" alt="" width="1%"/></h4></a>
     
<hr>

<h5>

<a href="envoi.php">Inbox <img src="images/mail.png" alt="" width="1%"/> |</a>

<a href="acceuil.php">Fil d'actualité <img src="images/fil.png" alt="" width="1%"/> |</a>

    


<a href="messagerie.html">Tchat Public <img src="images/tchat.png" alt="" width="1%"/> |</a>

<a href="modifier.php">Modification <img src="images/reglage.png" alt="" width="1%"/> |</a>

<a href="contact.html">Nous contacter <img src="images/telephone.png" alt="" width="1%"/> |</a>

</h5>
<hr/>








     
         <p>Bienvenue <b><?php echo $userinfo['pseudo']; ?></b>! &#x1F60A;</p>
         <br /><br />
          
          <div align="center">

          <?php 
         //si elle n'est pas vide
         if(!empty($userinfo['avatar']))
          {
           ?>
        <div class="roundedImage"> <img src="membres/avatars/<?php echo $userinfo["avatar"]; ?>" width="150%"/></div>
         <?php 
         }
         ?><br/><br/>
         <h4>Votre pseudo est : <u><b><?php echo $userinfo['pseudo']; ?></h4></b></u>
         
         <h4>Votre mail est : <u><b><?php echo $userinfo['mail']; ?></h4></b></u>
         <br />
         <?php
         if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
         ?>
         <br />

         <?php
         }
         ?>
      
      </div>


   </body>
</html>
<?php   
}
?>