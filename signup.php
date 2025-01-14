<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <title>Créer un compte</title>
</head>
<body>
    <div class="container justify-content-center align-items-center d-flex" style="height: 100vh;">

                <h1 class="col-sm display-1 text-center">Créer un compte</h1>


                <form action="process/login_process.php" method="post" class="card shadow-lg rounded col-6">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="firstname" name="firstname">
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="lastname" name="lastname">
                        </div>
                        <div class="mb-3">
                            <label for="dateNaissance" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control" id="dateNaissance" name="dateNaissance">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Téléphone</label>
                            <input type="text" class="form-control" id="phone" name="phone">
                        </div>
                        <div class="mb-3">
                            <label for="ville">Ville</label>
                            <select name="ville" id="ville" class="form-control">
                                <option value="new">Ajouter une nouvelle ville</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div id="dataLieu" style="display: none;"></div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">Creer un compte</button>
                        <a href="signin.php" class="btn btn-outline-primary">J'ai deja un compte</a>
                    </div>
                </form>

    </div>

</body>
<script src="https://code.jquery.com/jquery-2.0.3.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>

    document.addEventListener("DOMContentLoaded", function(event){

        /////////////////////////////////////
        //populate the select with the town//
        /////////////////////////////////////

        fetch('../process/ville_process.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'getAllVille'
            })
        }).then(response => response.json())
        .then(data => {
            console.log(data);
            const lieuRencontre = document.querySelector('#ville');
            data.forEach(lieu => {
                const option = document.createElement('option');
                option.value = lieu.idVille;
                option.textContent = lieu.libelle;
                option.setAttribute('idLieu', lieu.idVille);
                lieuRencontre.appendChild(option);
            });


            divVille=document.querySelector('#dataLieu');
            showInputVille(divVille);

            lieuRencontre.addEventListener('change', (e)=>{
                if(e.target.value === 'new'){
                    //afficher le formulaire pour ajouter une nouvelle ville
                    divVille=document.querySelector('#dataLieu');
                    showInputVille(divVille)
                }else{
                    divVille=document.querySelector('#dataLieu');
                    divVille.innerHTML = '';
                    divVille.setAttribute('style', 'display: none;');
                }
            });
            

        });



        ///////////////////////////////////
        //CHECK IF PERSONNE ALREADY EXIST//
        ///////////////////////////////////
        const prenom = document.querySelector('#firstname');
        const nom= document.querySelector('#lastname');
        nom.addEventListener('change', function(){
            if(prenom.value==""){
                toastr.error('Veuillez entrer votre prénom');
                return;
            }
            fetch('process/personne_process.php',{
                method: 'POST',
                body:new URLSearchParams({
                    action: 'searchPersonne',
                    nom: nom.value,
                    prenom: prenom.value,
                })
            }).then(response => response.json())
            .then(data => {
                console.log(data);
                if(data==false){
                    //toastr.error('Personne non trouvée');
                    if(document.querySelector('input[name="id"]')){
                        document.querySelector('input[name="id"]').value = "new";    
                    }else{
                        const form = document.querySelector('form');
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'id';
                        hiddenInput.value = "new";
                        form.appendChild(hiddenInput);
                    }
                    document.querySelectorAll('button').forEach(button => {
                            button.removeAttribute('disabled');
                            console.log(button);
                    });
                    return;
                }else{
                    if(data.username!=null){
                        toastr.warning('Vous avez deja un compte','Bonjour, '+prenom.value+" "+nom.value , {
                            timeOut: 0,
                            extendedTimeOut: 0, 
                            closeButton: true, });
                        document.querySelectorAll('button').forEach(button => {
                            button.setAttribute('disabled', 'true');
                        });
                        return;
                    }
                    
                    toastr.success('Vous avez deja était rentrer dans la base de donnée. Veuillez donc vérifier vos information et choisir un nom d\'utilisateur et mot de passe','Bonjour, '+prenom.value+" "+nom.value , {
                        timeOut: 0,
                        extendedTimeOut: 0, 
                        closeButton: true, });
                    console.log(data);
                    document.querySelector('#dateNaissance').value = data.dateDeNaissance;
                    document.querySelector('#phone').value = data.numéro;
                    document.querySelector('#ville').value = data.idVille;
                    divVille=document.querySelector('#dataLieu');
                    divVille.innerHTML = '';
                    divVille.setAttribute('style', 'display: none;');
                    document.querySelector('#email').value = data.mail;
                    if(document.querySelector('input[name="id"]')){
                        document.querySelector('input[name="id"]').value = data.idPersonne;
                    }else{
                        const form = document.querySelector('form');
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'id';
                        hiddenInput.value = data.idPersonne;
                        form.appendChild(hiddenInput);
                    }

                    
                    nom.removeEventListener('change',arguments.callee,false);
                }
            });
        });


        //////////////////////////
        //CREATE NEW USER      ///
        //////////////////////////
        const form = document.querySelector('form');
        form.addEventListener('submit',async function(e){

            //check if all the mandatory fields are filled
            if(prenom.value==""){
                toastr.error('Veuillez entrer votre prénom');
                e.preventDefault();
                return;
            }
            if(nom.value==""){
                toastr.error('Veuillez entrer votre nom');
                e.preventDefault();
                return;
            }
            if(document.querySelector('#username').value==""){
                toastr.error('Veuillez entrer un nom d\'utilisateur');
                e.preventDefault();
                return;
            }
            if(document.querySelector('#password').value==""){
                toastr.error('Veuillez entrer un mot de passe');
                e.preventDefault();
                return;
            }

            e.preventDefault();
            const formData = new FormData();

            input=form.querySelector('input[name="id"]');
            if(input){
                if(input.value=="new"){
                    formData.append('action','addPersonneForSigngIn');
                }else{
                    formData.append('action','updatePersonne');
                    formData.append('id',input.value);
                }
            }

            selectVille=document.querySelector('#ville');
            if (selectVille.value === 'new') {
                const dataVille=document.querySelector('#dataLieu');
                idVille=await addVille(dataVille);
                console.log(idVille);
                formData.append('idVille', idVille);
            }else{
                formData.append('idVille', selectVille.value);
            }


            formData.append('nom',document.querySelector('#lastname').value);
            formData.append('prenom',document.querySelector('#firstname').value);
            formData.append('dateNaissance',document.querySelector('#dateNaissance').value);
            formData.append('email',document.querySelector('#email').value);
            formData.append('telephone',document.querySelector('#phone').value);

            console.log("idVille :")
            console.log(formData.get('idVille'));

            
            
            formData.append('username',document.querySelector('#username').value);
            formData.append('password',document.querySelector('#password').value);


            fetch('process/personne_process.php',{
                method: 'POST',
                body: formData
            }).then(response => response.json())
            .then(data => {
                window.location.href = 'signin.php';
            });
        });






        async function addVille(dataParam){
            found=false;
            const input = dataParam.querySelectorAll('input');
            //create the body for the fetch
            const formData = new FormData();
            input.forEach((element)=>{
                if(element.value !== ''){
                    formData.append('libelle', element.value);
                }
            });

            //check if the town already exist
            formCheck = new FormData();
            formCheck.append('action', 'getVilleByLibelle');
            formCheck.append('libelle', formData.get('libelle'));
            console.log(formCheck.get('libelle'));

            response=await fetch('./process/ville_process.php', {
                method: 'POST',
                body: formCheck
            })
            data=await response.json();
            console.log(data);

            if (!data){
                console.log('pas trouver');
                found=false;
            }else{
                console.log('trouver');
                found=true;
                return data.idVille;
            }
            if(!found){
                console.log('whala j\'ai pas attendu');
            formData.append("action", "addVille");

            response=await fetch('./process/ville_process.php', {
                method: 'POST',
                body: formData
            })
            //return the id of the new town
            idVille = await response.json();
            return idVille.id; 
            }
        }



        function showInputVille(div){
            div.innerHTML = '';
            div.setAttribute('style', 'display: block;');
        

            label = document.createElement('label');
            label.textContent = 'Nouvelle ville';
            div.appendChild(label);
            input = document.createElement('input');
            input.type = 'text';
            input.name = 'nom';
            input.setAttribute('required', 'true');
            input.setAttribute('class', 'form-control');
            div.appendChild(input);
        }

    });

</script>
</html>