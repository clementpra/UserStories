<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once '../header.php'; ?>
    <title>Modifier</title>
</head>

<body>
    <?php require_once '../navbar.php'; ?>

    <div class="container">
        <div class="card shadow-lg rounded">
            <div class="card-header">
                <h5 id="Title">Modifier votre profil</h5>
            </div>
            <div class="card-body">
                <form action="/process/personne_process.php" method="POST">
                    <input type="hidden" name="action" value="modifyPersonne">
                    <input type="hidden" name="idPersonne" value="<?php echo $_GET['id']; ?>">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom">
                        <label for="prenom">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom">
                        <label for="dateDeNaissance">Date de naissance</label>
                        <input type="date" class="form-control" id="dateDeNaissance" name="dateDeNaissance">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <label for="telephone">Téléphone</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone">
                        <label for="lieuRencontre">Ville</label>
                        <select name="lieuRencontre" id="lieuRencontre" class="form-control">
                            <option value="new">Ajouter une nouvelle ville</option>
                        </select>
                        <div id="dataLieu" style="display: none;"></div>
                        <input type="submit" class="btn btn-primary mt-3" value="Modifier">
                    </div>
                </form>
            </div>
        </div>
        <div class="card shadow-lg rounded mt-3">
            <div class="card-header">
                <h5>Vos connaissances</h5>
            </div>
            <div class="card-body">
                <button class="btn btn-outline-info" id="you">Vous</button>
                <button class="btn btn-outline-info" id="createdBy">Crée par vous</button>
                <button class="btn btn-outline-secondary" id="toggleLastName" activé="false">Afficher les noms de famille</button>
                <div class="container" id="connaissances">

                </div>
            </div>
        </div>
</body>


<script>
    function populateForm(idUser) {
        fetch('/process/personne_process.php', {
                method: 'POST',
                body: new URLSearchParams({
                    action: 'getPersonneInfoByid',
                    id: idUser
                })
            })
            .then(response => response.json())
            .then(data => {
                let title = document.getElementById('Title');
                title.textContent = `Modifier votre profil`; //TODO: modifier le titre pour l'administateur
                document.getElementById('nom').value = data.nom;
                document.getElementById('prenom').value = data.prenom;
                document.getElementById('dateDeNaissance').value = data.dateDeNaissance;
                document.getElementById('email').value = data.mail;
                document.getElementById('telephone').value = data.numéro;
                if (data.idVille != null) {
                    document.getElementById('lieuRencontre').value = data.idVille;
                    let divDataLieu = document.getElementById('dataLieu');
                    divDataLieu.innerHTML = ``;
                }
            });
    }







    document.addEventListener('DOMContentLoaded', function() {
        idUser = <?php echo $_GET['id']; ?>;
        populateVille()
        populateForm(idUser)
        getAllRelation('getRelationForUser', idUser)

        let you = document.getElementById('you');
        let createdBy = document.getElementById('createdBy');


        you.addEventListener('click', function() {
            getAllRelation('getRelationForUser', idUser)
        });

        createdBy.addEventListener('click', function() {
            getAllRelation('getRelationCreatedByUser', idUser)
        });


        let form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(form);
            fetch('/process/personne_process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '/view/modifyPersonne.php?id=' + idUser;
                    } else {
                        alert(data.error);
                    }
                });
        });
    });
</script>

</html>