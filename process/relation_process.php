<?php
session_start();
require_once '/var/www/html/class/relation.php';

$action = $_POST['action'];

switch ($action) {
    case 'getAllRelation':
        echo json_encode(relation::getAllRelation());
        break;
    case 'getAllRelationForShow':
        echo json_encode(relation::getAllRelationForShow());
        break;
    case 'getAllRelationForGraph':
        echo json_encode(relation::getAllRelationForGraph());
        break;
    case 'getAllTypeRelation':
        echo json_encode(relation::getAllRelationType());
        break;
    case 'addRelation':
        $idPersonne1 = $_POST['idPersonne1'];
        $idPersonne2 = $_POST['idPersonne2'];
        $annee = $_POST['annee'];
        $idLien = $_POST['idLien'];
        $idVille = $_POST['idVille'];
        $commentaire = $_POST['commentaire'];
        if (isset($_SESSION['idPersonne'])) {
            $idAuteur = $_SESSION['idPersonne'];
            $lastId = relation::addRelation($idPersonne1, $idPersonne2, $idAuteur, $annee, $idVille, $commentaire, $idLien);
            echo json_encode(['success' => true, 'id' => $lastId]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Vous devez être connecté pour ajouter une relation']);
        }
        break;
    case 'getAllRelationType':
        echo json_encode(relation::getAllRelationType());
        break;
    case 'getRelationForUser':
        echo json_encode(relation::getRelationForUser($_POST['idPersonne']));
        break;
    case 'getRelationCreatedByUser':
        echo json_encode(relation::getRelationCreatedByUser($_POST['idPersonne']));
        break;
    default:
        echo json_encode(['error' => 'Action inconnue']);
        break;
}
