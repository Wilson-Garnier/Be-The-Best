<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=bdd_btb', 'bethe_best', 'be_the_best_phpmyadmin_480');

if(isset($_SESSION['id'])) {
   $requser = $bdd->prepare("SELECT * FROM utilisateur WHERE id = ?");
   $requser->execute(array($_SESSION['id']));
   $user = $requser->fetch();
   if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['pseudo']) {
      $newpseudo = htmlspecialchars($_POST['newpseudo']);
      $insertpseudo = $bdd->prepare("UPDATE utilisateur SET pseudo = ? WHERE id = ?");
      $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['mail']) {
      $newmail = htmlspecialchars($_POST['newmail']);
      $insertmail = $bdd->prepare("UPDATE utilisateur SET mail = ? WHERE id = ?");
      $insertmail->execute(array($newmail, $_SESSION['id']));
      header('Location: profil.php?id='.$_SESSION['id']);
   }
   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
      $mdp1 = sha1($_POST['newmdp1']);
      $mdp2 = sha1($_POST['newmdp2']);
      if($mdp1 == $mdp2) {
         $insertmdp = $bdd->prepare("UPDATE utilisateur SET motdepasse = ? WHERE id = ?");
         $insertmdp->execute(array($mdp1, $_SESSION['id']));
         header('Location: pageprofil.php?id='.$_SESSION['id']);
      } else {
         $msg = "Vos deux mdp ne correspondent pas !";
      }
   }

if (isset($_FILES['avatar']) AND !empty($_FILES['avatar']['name'])) 
{
  //limite de la taille de fichier profil  en octet
  $tailleMax = 2097152;
  //les format de photo qui sont  valide 
  $extensionValides =array('jpg','jpeg','gif','png' );
  //on verifie si le format est respecte
  if ($_FILES['avatar']['size'] <= $tailleMax)
   {
    
    //pour verifie et mettre tous le nom en miniscule et le strrchr de prendre l'extension du fichier et d'ignorer le premier caractere dela chaine
    $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
    if (in_array($extensionUpload,$extensionValides)) 
    {
    $chemin ="membres/avatars/".$_SESSION['id'].".".$extensionUpload;
    $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
    if ($resultat)
     {
      
      $updateavatar =$bdd->prepare('UPDATE utilisateur SET avatar= :avatar WHERE id = :id');
      $updateavatar->execute(array( 
          'avatar' => $_SESSION['id'].".".$extensionUpload,
          'id' => $_SESSION['id']
        ));
         header('Location: pageprofil.php?id='.$_SESSION['id']);
    }
    else{
      $msg ="Erreur durant l'importance de votre photo de profil";
    }

    }
    else{
      $msg="Votre photo de profil doit etre au format jpg,jpeg,gif,png";
    }
  }
  else{
    $msg="Votre photo de profil ne doit pas depasser 2Mo ";
  }

}




?>
<html>
   <head>
        
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style.css" />
        <link rel="icon" type="image/jpg" href="images/icon.jpg" width="100px"/>
        
        <title>BeTheBest - Modifier</title>
    
    </head>
   <body>

         <div class="entete">
      
      <div class="img"><img src="images/logo.png" alt="" /></div>
   
   </div><br/>

     
         
         <h2 align="center"><u>Modifier votre profil</u></h2>

         <table align="center">
         
            <form method="POST" action="" enctype="multipart/form-data">
               

            <tr>   
               
               <td><label>Pseudo :</label></td>
               <td><input type="text" name="newpseudo" placeholder="Pseudo" size="30" value="<?php echo $user['pseudo']; ?>" /></td>
               
            </tr>

            <tr></tr><tr></tr>

            <tr>
               <td><label>Mail :</label></td>
                <td><input type="text" name="newmail" placeholder="Mail" size="30" value="<?php echo $user['mail']; ?>" /></td>
            </tr> 
            
            <tr></tr><tr></tr>

            <tr>
               <td><label>Mot de passe :</label></td>
               <td><input type="password" name="newmdp1" size="30" placeholder="Mot de passe"/></td>
            
            </tr>

            <tr></tr><tr></tr>

            <tr>  
               <td><label>Confirmation de votre mot de passe :</label></td>
               <td><input type="password" name="newmdp2" size="30" placeholder="Confirmation du mot de passe" /></td>
            </tr>   
            
            <tr></tr><tr></tr>

            <tr>

               <td><label>Photo de profil</label></td>
              
               <td><input type="file" name="avatar"></td>

            </tr>

         </table>
            
<br/>
               <div align="center">           
               <input class="favorite styled" type="submit" value="Mettre à jour mon profil " />
               </div>



            </form>
            <?php if(isset($msg)) { echo $msg; } ?>
         
      
   </body>
</html>
<?php   
}
else {
   header("Location:connexion.php");
}
?>