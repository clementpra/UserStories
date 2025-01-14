<?php
session_start();

require_once '/var/www/html/class/personne.php';

$action = $_POST['action'];

switch ($action) {
    case 'getAllPersonne':
        echo json_encode(personne::getAllPersonne());
        break;
    case 'getAllPersonneForView':
        echo json_encode(personne::getAllPersonneForView());
        break;
    case 'login':
        $username = $_POST['username'];
        $password = $_POST['password'];
        $personne = personne::login($username, $password);
        if ($personne != null) {
            $_SESSION['idPersonne'] = $personne['idPersonne'];
            $_SESSION['username'] = $personne['username'];
            $_SESSION['nom'] = $personne['nom'];
            $_SESSION['prenom'] = $personne['prenom'];
            $_SESSION['dateDeNaissance'] = $personne['dateDeNaissance'];
            $_SESSION['mail'] = $personne['mail'];
            $_SESSION['numéro'] = $personne['numéro'];
            $_SESSION['ville'] = $personne['idVille'];
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        break;
    case 'signout':
        session_destroy();
        echo json_encode(['success' => true]);
        break;
    case 'addPersonne':
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        if (isset($_POST['dateDeNaissance'])) {
            $dateNaissance = $_POST['dateDeNaissance'];
        } else {
            $dateNaissance = null;
        }
        if (isset($_POST['email'])) {
            $mail = $_POST['email'];
        } else {
            $mail = null;
        }
        if (isset($_POST['telephone'])) {
            $telephone = $_POST['telephone'];
        } else {
            $telephone = null;
        }
        if (isset($_POST['idVille'])) {
            $ville = $_POST['idVille'];
        } else {
            $ville = null;
        }
        if (isset($_SESSION['idPersonne'])) {
            $idAuteur = $_SESSION['idPersonne'];
            $lastId = personne::addPersonne($nom, $prenom, $dateNaissance, $mail, $telephone, $ville, $idAuteur);
            echo json_encode(['success' => true, 'id' => $lastId]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Vous devez être connecté pour ajouter une personne']);
        }
        break;
    case 'addPersonneForSigngIn':
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        if (isset($_POST['dateNaissance'])) {
            $dateNaissance = $_POST['dateNaissance'];
        } else {
            $dateNaissance = null;
        }
        if (isset($_POST['email'])) {
            $mail = $_POST['email'];
        } else {
            $mail = null;
        }
        if (isset($_POST['telephone'])) {
            $telephone = $_POST['telephone'];
        } else {
            $telephone = null;
        }
        if (isset($_POST['idVille'])) {
            $ville = $_POST['idVille'];
        } else {
            $ville = null;
        }
        $lastId = personne::addPersonneForSigngIn($nom, $prenom, $dateNaissance, $mail, $telephone, $ville, $_POST['username'], $_POST['password']);
        echo json_encode(['success' => true, 'id' => $lastId]);
        break;
    case 'updatePersonne':
        $id = $_POST['id'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        if (isset($_POST['dateNaissance'])) {
            $dateNaissance = $_POST['dateNaissance'];
        } else {
            $dateNaissance = null;
        }
        if (isset($_POST['email'])) {
            $mail = $_POST['email'];
        } else {
            $mail = null;
        }
        if (isset($_POST['telephone'])) {
            $telephone = $_POST['telephone'];
        } else {
            $telephone = null;
        }
        if (isset($_POST['idVille'])) {
            $ville = $_POST['idVille'];
        } else {
            $ville = null;
        }
        personne::updatePersonne($id, $nom, $prenom, $dateNaissance, $mail, $telephone, $ville, $_POST['username'], $_POST['password']);
        echo json_encode(['success' => true]);
        break;
    case 'modifyPersonne':
        $id = $_POST['idPersonne'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        if (isset($_POST['dateDeNaissance'])) {
            $dateNaissance = $_POST['dateDeNaissance'];
        } else {
            $dateNaissance = null;
        }
        if (isset($_POST['email'])) {
            $mail = $_POST['email'];
        } else {
            $mail = null;
        }
        if (isset($_POST['telephone'])) {
            $telephone = $_POST['telephone'];
        } else {
            $telephone = null;
        }
        if (isset($_POST['lieuRencontre'])) {
            $ville = $_POST['lieuRencontre'];
        } else {
            $ville = null;
        }
        personne::modifyPersonne($id, $nom, $prenom, $dateNaissance, $mail, $telephone, $ville);
        echo json_encode(['success' => true]);
        break;
    case 'getPersonneInfoByid':
        echo json_encode(personne::getPersonneInfoByid($_POST['id']));
        break;
    case 'searchPersonne':
        echo json_encode(personne::searchPersonne($_POST['nom'], $_POST['prenom']));
        break;
    default:
        echo json_encode(['error' => 'Action inconnue']);
        break;
}
