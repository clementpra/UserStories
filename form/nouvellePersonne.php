<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- toastr cdn : -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    
    <title>Nouvelle personne</title>
</head>
<body>
    <div class="container">
        <form class="row" action="process/personne.php" method="POST">
            <div class="col">
                <div class="card shadow-lg rounded">
                    <div class="card-header">
                        <h5>Personne</h5>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="action" value="addPersonne">
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" id="nom" class="form-control">
                        <label for="prenom">Prénom</label>
                        <input type="text" name="prenom" id="prenom" class="form-control">
                        <label for="dateNaissance">Date de naissance</label>
                        <input type="date" name="dateNaissance" id="dateNaissance" class="form-control">
                        <label for="ville">Ville</label>
                        <input type="text" name="ville" id="ville" class="form-control">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control">
                        <label for="telephone">Téléphone</label>
                        <input type="tel" name="telephone" id="telephone" class="form-control">
                        </br>
                        <input type="submit" value="Enregistrer" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="http://code.jquery.com/jquery-2.0.3.min.js" ></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    const form = document.querySelector('form');

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        fetch('process/personne_process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                toastr.success("Personne ajoutée","Succès",{
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                });
                form.reset();
            } else {
                
            }
        });
    });
</script>
</html>