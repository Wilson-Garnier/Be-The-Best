<?php
$bdd = new PDO("mysql:host=localhost;dbname=bdd_btb;charset=utf8", "bethe_best", "be_the_best_phpmyadmin_480");
if(isset($_GET['id']) AND !empty($_GET['id'])) {
   $suppr_id = htmlspecialchars($_GET['id']);
   $suppr = $bdd->prepare('DELETE FROM article WHERE id = ?');
   $suppr->execute(array($suppr_id));
   header('Location: http://127.0.0.1/fildactualite');
}
?>