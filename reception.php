<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=bdd_btb', 'bethe_best', 'be_the_best_phpmyadmin_480');
if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {
$msg = $bdd->prepare('SELECT * FROM messages_priv WHERE id_destinataire = ?');
$msg->execute(array($_SESSION['id']));
$msg_nbr = $msg->rowCount();

header('Refresh: 5;');

?>
<!DOCTYPE html>
<html>
   <head>
        
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
        <link rel="icon" type="image/jpg" href="images/icon.jpg" width="100px"/>
        
        <title>BeTheBest - Réception</title>
    
    </head>

<body>

      <div class="entete">
      
      <div class="img"><img src="images/logo.png" alt="" /></div>
   
   </div>

   <br/>

   <div align="center">

   <img src="images/box.png" alt="" width="20%" />

</div>

   <hr/>



   <h5>

<a href="envoi.php">Nouveau Message<img src="images/mail.png" alt="" width="1%" /> |</a>

<a href="acceuil.php">Fil d'actualité <img src="images/fil.png" alt="" width="1%"/> |</a>

<a href="messagerie.html">Tchat Public <img src="images/tchat.png" alt="" width="1%"/> |</a>


<a href="contact.html">Nous contacter <img src="images/telephone.png" alt="" width="1%"/> |</a>
</h5>
<hr/><br/>


   <h3>Votre boîte de réception:</h3><br/>
   <?php
   if($msg_nbr == 0) { echo "Vous n'avez aucun message..."; }
   while($m = $msg->fetch()) {
      $p_exp = $bdd->prepare('SELECT pseudo FROM utilisateur WHERE id = ?');
      $p_exp->execute(array($m['id_expediteur']));
      $p_exp = $p_exp->fetch();
      $p_exp = $p_exp['pseudo'];
   ?>
   <b><u><?= $p_exp ?></b></u> : vous a envoyé: <br /><br/>
   <?= nl2br($m['message']) ?><br />
     _____________________________________<br/>

   <?php } ?>
</body>
</html>
<?php } ?>