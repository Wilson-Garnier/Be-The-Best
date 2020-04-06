<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=bdd_btb', 'bethe_best', 'be_the_best_phpmyadmin_480');

if(isset($_POST['formconnexion'])) {
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mdpconnect = sha1($_POST['mdpconnect']);
   if(!empty($mailconnect) AND !empty($mdpconnect)) {
      $requser = $bdd->prepare("SELECT * FROM utilisateur WHERE mail = ? AND motdepasse = ?");
      $requser->execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();
      if($userexist == 1) {
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         $_SESSION['mail'] = $userinfo['mail'];
         header("Location: pageprofil.php?id=".$_SESSION['id']);
      } else {
         $erreur = "Mauvais mail ou mot de passe !";
      }
   } else {
      $erreur = "Tous les champs doivent être complétés !";
   }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
      <link rel="stylesheet" href="style.css" />
        <title>BeTheBest - Connexion</title>
        <link rel="icon" type="image/jpg" href="images/icon.jpg" width="100px"/>
    </head>
   
   <body align="center">
       
<br/><br/><br/><br/><br/><br/><br/>
      
      <h1>Connectez-vous pour chattez avec vos amis !</h1>

      
    
      
         <img src="images/profil.png" alt="" width="15%" /><br/><br/><br/>
      
     

         <form method="POST" action="">
        


  <?php
         if(isset($erreur)) {
            echo '<font color="red" size="4">'.$erreur."</font>";
            echo'<br/><br/>';
         }
         ?>
     
          <b>Mail :</b><br/>

            <input type="email" name="mailconnect" placeholder="Saisissez votre Mail" size="21"/><br/><br/>


           <b>Mot de passe :</b><br/>
           <input type="password" name="mdpconnect" placeholder="Saisissez votre Mot de passe" size="21"/><br/><br/>
     



           
            <input class="favorite styled" type="submit" name="formconnexion" value="Se connecter" />
           <a href="index.html"><input class="favorite styled" type="button" value="Retour &agrave; l'accueil"></a>
 

</table>

         </form>
         
    

   
   </body>
</html>