<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once 'header.php'; ?>
    <style>
        /* body{
            background-image: url("ressources/background.JPEG");
            background-size: cover;
            color : #FAF9F6;
            
        } */

        body::before {
            content: "";
            background: inherit;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1;
            filter: blur(5px);
        }

        .card_new {
            width: 20rem;
            text-align: left;
            transition: transform 0.3s ease;
        }

        .card_new:hover {
            background-color: #FAF9F6;
            transform: scale(1.05);
        }

        a {
            text-decoration: none;
        }
    </style>

    <title>Acceuil</title>
</head>

<body>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <?php require_once 'navbar.php'; ?>

    <!-- text in the middle of the page -->
    <div class="container-fluid justify-content-center align-items-center d-flex" style="height: 80vh;">
        <div class="row">
            <div class="col">
                <div class="card shadow-lg rounded m-3">
                    <div class="m-3">
                        <a href="/view/managePersonnes.php">
                            <div class="card shadow-lg rounded m-3 card_new" style="background-color: #FAF9F6;">
                                <div class="card-body">
                                    <h5 class="card-title">Personnes</h1>
                                </div>
                            </div>
                        </a>
                        <a href="/view/listConnaissance.php">
                            <div class="card shadow-lg rounded m-3 card_new" style="background-color: #FAF9F6;">
                                <div class="card-body">
                                    <h5 class="card-title">Connaissances</h1>
                                </div>
                            </div>
                        </a>
                        <div class="card shadow-lg rounded m-3 card_new" style="background-color: #FAF9F6;">
                            <div class="card-body">
                                <h5 class="card-title">Type Relation</h1>
                            </div>
                        </div>
                        <div class="card shadow-lg rounded m-3 card_new" href=# style="background-color: #FAF9F6;">
                            <div class="card-body">
                                <h5 class="card-title">Villes</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-lg rounded m-3">
                    <div class="col-12 text-center">
                        <div class="card shadow-lg rounded m-3 card_new" style="background-color: #FAF9F6;">
                            <div class="card-body">
                                <h5 class="card-title">Utilisateurs</h1>
                            </div>
                        </div>
                        <a href="/view/manageRoles.php">
                            <div class="card shadow-lg rounded m-3 card_new" style="background-color: #FAF9F6;">
                                <div class="card-body">
                                    <h5 class="card-title">Roles</h1>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</body>

</html>