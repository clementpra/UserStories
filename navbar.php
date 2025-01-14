<!--navbar.php-->
<style>
    nav{
        background-color: #f8f9fa;
        border-bottom: solid;
        border-color: #e9ecef;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">US</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/index.php">Acceuil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/view/graphConnaissances.php">Les connaissances</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/form/nouvelleConnaissance.php">Relation</a>
                </li>
                
            </ul>

            <?php if(isset($_SESSION["username"])){?>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION["username"]; ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Mon compte</a>
                    <a class="dropdown-item" id="signout" href="#">Deconnexion</a>
                </div>
                </div>  
            <?php }else{ ?>
                   <a class="btn btn-light" href="/signin.php">Connexion</a>
            <?php } ?>
                

            
        </div>
    </div>
</nav>
</br>

<script>
    document.getElementById('signout').addEventListener('click', function(e){
        e.preventDefault();
        fetch('/process/personne_process.php',{
            method: 'POST',
            body: new URLSearchParams({
                action: 'signout'
            })
        }).then(response => response.json())
        .then(data => {
            if(data.success){
                window.location.href = '/index.php';
            }
        });
    });
</script>