<?php

require_once '/var/www/html/process/dbConnector.php';

class personne
{


    static function getAllPersonne()
    {
        $pdo = PDOMySQLConnector::getClient();
        $query = $pdo->prepare('SELECT idPersonne,nom,prenom FROM personne');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static function getAllPersonneForView()
    {
        $pdo = PDOMySQLConnector::getClient();
        $query = $pdo->prepare('SELECT idPersonne,nom,prenom,Ville.libelle, dateDeNaissance,mail,numéro FROM personne 
                                left join Ville ON  personne.idVille = Ville.idVille');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    static function getPersonneInfoByid($id)
    {
        $pdo = PDOMySQLConnector::getClient();
        $query = $pdo->prepare('SELECT * FROM personne WHERE idPersonne = :id');
        $query->execute(array(
            'id' => $id
        ));
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    static function searchPersonne($nom, $prenom)
    {
        $pdo = PDOMySQLConnector::getClient();
        $query = $pdo->prepare('SELECT * FROM personne WHERE nom LIKE :nom AND prenom LIKE :prenom');
        $query->execute(array(
            'nom' => '%' . $nom . '%',
            'prenom' => '%' . $prenom . '%'
        ));
        return $query->fetch(PDO::FETCH_ASSOC);
    }


    static function addPersonne($nom, $prenom, $dateNaissance, $mail, $numéro, $ville)
    {
        $pdo = PDOMySQLConnector::getClient();
        $query = "INSERT INTO personne (";
        if ($nom != null) {
            $query .= "nom,";
        }
        if ($prenom != null) {
            $query .= "prenom,";
        }
        if ($dateNaissance != null) {
            $query .= "dateDeNaissance,";
        }
        if ($mail != null) {
            $query .= "mail,";
        }
        if ($numéro != null) {
            $query .= "numéro,";
        }
        if ($ville != null) {
            $query .= "idVille,";
        }
        $query = substr($query, 0, -1);
        $query .= ") VALUES (";
        if ($nom != null) {
            $query .= "\"" . $nom . "\",";
        }
        if ($prenom != null) {
            $query .= "\"" . $prenom . "\",";
        }
        if ($dateNaissance != null) {
            $query .= "\"" . $dateNaissance . "\",";
        }
        if ($mail != null) {
            $query .= "\"" . $mail . "\",";
        }
        if ($numéro != null) {
            $query .= "\"" . $numéro . "\",";
        }
        if ($ville != null) {
            $query .= "\"" . $ville . "\",";
        }
        $query = substr($query, 0, -1);
        $query .= ")";
        $query = $pdo->prepare($query);
        //$query = $pdo->prepare('INSERT INTO personne (nom, prenom, dateNaissance, mail, numéro, ville) VALUES (:nom, :prenom, :dateNaissance, :mail, :numéro, :ville)');
        $query->execute();
        return $pdo->lastInsertId();
    }


    static function addPersonneForSigngIn($nom, $prenom, $dateNaissance, $mail, $numéro, $ville, $username, $password)
    {
        $pdo = PDOMySQLConnector::getClient();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO personne (";
        if ($nom != null) {
            $query .= "nom,";
        }
        if ($prenom != null) {
            $query .= "prenom,";
        }
        if ($dateNaissance != null) {
            $query .= "dateDeNaissance,";
        }
        if ($mail != null) {
            $query .= "mail,";
        }
        if ($numéro != null) {
            $query .= "numéro,";
        }
        if ($ville != null) {
            $query .= "idVille,";
        }
        $query .= "username,";
        $query .= "password,";
        $query = substr($query, 0, -1);
        $query .= ") VALUES (";
        if ($nom != null) {
            $query .= "\"" . $nom . "\",";
        }
        if ($prenom != null) {
            $query .= "\"" . $prenom . "\",";
        }
        if ($dateNaissance != null) {
            $query .= "\"" . $dateNaissance . "\",";
        }
        if ($mail != null) {
            $query .= "\"" . $mail . "\",";
        }
        if ($numéro != null) {
            $query .= "\"" . $numéro . "\",";
        }
        if ($ville != null) {
            $query .= "\"" . $ville . "\",";
        }
        $query .= "\"" . $username . "\",";
        $query .= "\"" . $hashedPassword . "\",";
        $query = substr($query, 0, -1);
        $query .= ")";
        $query = $pdo->prepare($query);
        //$query = $pdo->prepare('INSERT INTO personne (nom, prenom, dateNaissance, mail, numéro, ville) VALUES (:nom, :prenom, :dateNaissance, :mail, :numéro, :ville)');
        $query->execute();
        return $pdo->lastInsertId();
    }



    static function updatePersonne($id, $nom, $prenom, $dateNaissance, $mail, $numero, $ville, $username, $password)
    {
        $pdo = PDOMySQLConnector::getClient();

        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = $pdo->prepare('
                UPDATE personne 
                SET 
                    nom = :nom, 
                    prenom = :prenom, 
                    dateDeNaissance = :dateNaissance, 
                    mail = :mail, 
                    numéro = :numero, 
                    idVille = :idVille, 
                    username = :username, 
                    password = :newPassword 
                WHERE 
                    idPersonne = :id
            ');

        $query->execute(array(
            ':id' => $id,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':dateNaissance' => $dateNaissance,
            ':mail' => $mail,
            ':numero' => $numero,
            ':idVille' => $ville,
            ':username' => $username,
            ':newPassword' => $hashedPassword
        ));
    }

    static function modifyPersonne($id, $nom, $prenom, $dateNaissance, $mail, $numero, $ville)
    {
        $pdo = PDOMySQLConnector::getClient();

        $query = $pdo->prepare('
                UPDATE personne 
                SET 
                    nom = :nom, 
                    prenom = :prenom, 
                    dateDeNaissance = :dateNaissance, 
                    mail = :mail, 
                    numéro = :numero, 
                    idVille = :idVille
                WHERE 
                    idPersonne = :id
            ');

        $query->execute(array(
            ':id' => $id,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':dateNaissance' => $dateNaissance,
            ':mail' => $mail,
            ':numero' => $numero,
            ':idVille' => $ville
        ));
    }


    static function login($username, $password)
    {
        $pdo = PDOMySQLConnector::getClient();
        $query = $pdo->prepare('SELECT * FROM personne WHERE username = :username');
        $query->execute(array(
            'username' => $username
        ));
        $personne = $query->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $personne['password'])) {
            return $personne;
        } else {
            return null;
        }
    }
}
