<?php

// Connexion à la base de donnée chat .
$db = new PDO('mysql:host=localhost;dbname=bdd_btb;charset=utf8', 'bethe_best', 'be_the_best_phpmyadmin_480', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);


 // On doit analyser la demande faite via l'URL (GET) afin de déterminer si on souhaite récupérer les messages ou en écrire un

$task = "list";

if(array_key_exists("task", $_GET)){
  $task = $_GET['task'];
}

if($task == "write"){
  postMessage();
} else {
  getMessages();
}

function getMessages(){
  global $db;

  //  On requête la base de données pour sortir les 20 derniers messages
  $resultats = $db->query("SELECT * FROM messages ORDER BY cree_le DESC LIMIT 20");
  //  On traite les résultats
  $messages = $resultats->fetchAll();
  //  On affiche les données sous forme de JSON
  echo json_encode($messages);
}

  //Si on veut écrire au contraire, il faut analyser les paramètres envoyés en POST et les sauver dans la base de données

function postMessage(){
  global $db;
  //  Analyser les paramètres passés en POST (auteur, contenu)
  
  if(!array_key_exists('auteur', $_POST) || !array_key_exists('contenu', $_POST)){

    echo json_encode(["status" => "error", "message" => "Un champ ou plusieurs n'ont pas été envoyés"]);
    return;

  }

  $auteur = $_POST['auteur'];
  $contenu = $_POST['contenu'];

  //  Créer une requête qui permettra d'insérer ces données
  $query = $db->prepare('INSERT INTO messages SET auteur = :auteur, contenu = :contenu, cree_le = NOW()');

  $query->execute([
    "auteur" => $auteur,
    "contenu" => $contenu,
  ]);

  //  Donner un statut de succes ou d'erreur au format JSON
  echo json_encode(["status" => "success"]);
}
?>