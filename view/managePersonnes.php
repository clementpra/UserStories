<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once '../header.php'; ?>
    <title>Document</title>
</head>

<body>
    <?php require_once '../navbar.php'; ?>

    <div class="container">
        <div class="card shadow-lg rounded">
            <div class="card-header">
                <h5>Toutes les personnes</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Date de naissance</th>
                            <th scope="col">Mail</th>
                            <th scope="col">Numéro</th>
                            <th scope="col">Ville</th>
                            <th scope="col"></th> <!-- space for the modify button -->
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                    </tbody>
                </table>
            </div>
        </div>
</body>


<script>
    function getAllPersonne() {
        fetch('/process/personne_process.php', {
                method: 'POST',
                body: new URLSearchParams({
                    action: 'getAllPersonneForView'
                })
            })
            .then(response => response.json())
            .then(data => affichage(data));
    }

    function affichage(data) {
        let tableBody = document.getElementById('tableBody');
        console.log(data);
        data.forEach(personne => {
            let tr = document.createElement('tr');
            let nom = document.createElement('td');
            nom.textContent = personne.nom;
            let prenom = document.createElement('td');
            prenom.textContent = personne.prenom;
            let dateNaissance = document.createElement('td');
            dateNaissance.textContent = personne.dateDeNaissance;
            let mail = document.createElement('td');
            mail.textContent = personne.mail;
            let numéro = document.createElement('td');
            numéro.textContent = personne.numéro;
            let ville = document.createElement('td');
            ville.textContent = personne.libelle;

            let tdButton = document.createElement('td');
            let modifyButton = document.createElement('button');
            modifyButton.textContent = 'Voir plus';
            modifyButton.classList.add('btn', 'btn-primary', 'btn-sm');
            modifyButton.addEventListener('click', function() {
                window.location.href = '/view/modifyPersonne.php?id=' + personne.idPersonne;
            });
            tdButton.appendChild(modifyButton);


            tr.appendChild(nom);
            tr.appendChild(prenom);
            tr.appendChild(dateNaissance);
            tr.appendChild(mail);
            tr.appendChild(numéro);
            tr.appendChild(ville);
            tr.appendChild(tdButton);
            tableBody.appendChild(tr);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        getAllPersonne();
    });
</script>

</html>