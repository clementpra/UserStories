<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>Connexion</title>
</head>
<body>
    <div class="container justify-content-center align-items-center d-flex" style="height: 100vh;">

                <h1 class="col-sm display-1 text-center">Connexion</h1>


                <form action="process/login_process.php" method="post" class="card shadow-lg rounded col-6">
                    <input type="hidden" name="action" value="login">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <p><a href="register.php">Mot de passe oublié ?</a></p>
                        <a href="signup.php" class="btn btn-outline-primary">Créer un compte</a>
                        <button type="submit" class="btn btn-primary">Connexion</button>
                    </div>
                </form>

    </div>

</body>

<script>
    document.querySelector('form').addEventListener('submit', function(e){
        e.preventDefault();
        let form = new FormData(this);
        fetch('process/personne_process.php', {
            method: 'POST',
            body: form
        }).then(response => response.json())
        .then(data => {
            if(data.success){
                window.location.href = 'index.php';
            }else{
                alert('Nom d\'utilisateur ou mot de passe incorrect');
            }
        });
    });
</script>
</html>