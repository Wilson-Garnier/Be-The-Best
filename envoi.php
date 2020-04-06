<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=bdd_btb', 'bethe_best', 'be_the_best_phpmyadmin_480');
if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {
   if(isset($_POST['envoi_message'])) {
      if(isset($_POST['destinataire'],$_POST['message']) AND !empty($_POST['destinataire']) AND !empty($_POST['message'])) {
         $destinataire = htmlspecialchars($_POST['destinataire']);
         $message = htmlspecialchars($_POST['message']);
         $id_destinataire = $bdd->prepare('SELECT id FROM utilisateur WHERE pseudo = ?');
         $id_destinataire->execute(array($destinataire));
         $dest_exist = $id_destinataire->rowCount();
         if($dest_exist == 1) {
            $id_destinataire = $id_destinataire->fetch();
            $id_destinataire = $id_destinataire['id'];
            $ins = $bdd->prepare('INSERT INTO messages_priv(id_expediteur,id_destinataire,message) VALUES (?,?,?)');
            $ins->execute(array($_SESSION['id'],$id_destinataire,$message));
            $error = "Votre message a bien été envoyé !";
         } else {
            $error = "Cet utilisateur n'existe pas...";
         }
      } else {
         $error = "Veuillez compléter tous les champs";
      }
   }
   $destinataires = $bdd->query('SELECT pseudo FROM utilisateur ORDER BY pseudo');
   ?>
   <!DOCTYPE html>
   <html>
   <head>
        
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
        <link rel="icon" type="image/jpg" href="images/icon.jpg" width="100px"/>
        
        <title>BeTheBest - Envoi</title>
    
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

<a href="reception.php">Message Reçu<img src="images/mail.png" alt="" width="1%" /> |</a>

<a href="acceuil.php">Fil d'actualité <img src="images/fil.png" alt="" width="1%"/> |</a>

<a href="messagerie.html">Tchat Public <img src="images/tchat.png" alt="" width="1%"/> |</a>



<a href="contact.html">Nous contacter <img src="images/telephone.png" alt="" width="1%"/> |</a>
</h5>
<hr/><br/>

<?php if(isset($error)) { echo '<span style="color:red">'.$error.'</span>'; } ?><br/>


      <form method="POST">
         

      	<h4>Sélectionner le pseudo de la personne</h4>

         <select name="destinataire">
            <?php while($d = $destinataires->fetch()) { ?>
            <option><?= $d['pseudo'] ?></option>
            <?php } ?>
         </select>
        
         <br /><br />

         <h4>Entrez votre message</h4>

         <textarea placeholder="Votre message" name="message"></textarea>
         <br /><br />
         <input class="favorite styled" type="submit" value="Envoyer" name="envoi_message" />
         <br /><br />
         
      </form>
      <br />
      
   </body>
   </html>
<?php
}
?>