<?php
session_start();
require_once '/var/www/html/class/ville.php';

$action = $_POST['action'];

switch ($action){
    case 'getAllVille':
        echo json_encode(ville::getAllVille());
        break;
    case 'addVille':
        $libelle = $_POST['libelle'];
        if($_SESSION['idPersonne']){
            $idAuteur = $_SESSION['idPersonne'];
            $lastId= ville::addVille($libelle, $idAuteur);
            echo json_encode(['success' => true, 'id' => $lastId]);
        }else{
            echo json_encode(['success' => false, 'error' => 'Vous devez être connecté pour ajouter une ville']);
        }

        break;
    case 'getVilleByLibelle':
        $libelle = $_POST['libelle'];
        echo json_encode(ville::getVilleByLibelle($libelle));
        break;
    default:
        echo json_encode(['error' => 'Action inconnue']);
        break;
}