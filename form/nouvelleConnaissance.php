<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once '../header.php'; ?>
    <title>Nouvelle connaissance</title>
</head>
<body>
    <?php require_once '../navbar.php'; ?>
    </br>   
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card shadow-lg rounded">
                    <div class="card-header">
                        <h5>Connaissance 1</h5>
                    </div>
                    <div class="card-body">
                        <select class="form-select selectPersonne" name="personne1" id="personne1">
                            <option value="new">Ajouter une nouvelle connaissance</option>
                        </select>
                        <div id="data1" style="display: none;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-lg rounded">
                    <div class="card-header">
                        <h5>Relation</h5>
                    </div>
                    <div class="card-body">
                        <label for="typeRelation">Type de relation</label>
                        <select name="typeRelation" id="typeRelation" class="form-control">

                        </select>
                        <label for="annee">Année rencontre</label>
                        <input type="number" max="2100" min="1900" name="annee" id="annee" class="form-control">
                        <label for="lieuRencontre">Lieu de rencontre</label>
                        <select name="lieuRencontre" id="lieuRencontre" class="form-control">
                            <option value="new">Ajouter un nouveau lieu</option>
                        </select>
                        <div id="dataLieu" style="display: none;"></div>
                        <label for="souvenir">Souvenir/commantaire</label>
                        <textarea name="souvenir" id="souvenir" class="form-control"></textarea>
                    </div>
                </div>          
            </div>
            <div class="col">
                <div class="card shadow-lg rounded">
                    <div class="card-header">
                        <h5>Connaissance 2</h5>
                    </div>
                    <div class="card-body">
                        <select class="form-select selectPersonne" name="personne2" id="personne2">
                            <option value="new">Ajouter une nouvelle connaissance</option>
                        </select>
                        <div id="data2" style="display: none;">
                        </div>
                    </div>
                </div>
            </div>
            </br>     
        </div>
        <div class="row">
            <div class="col">
                </br>
                <input type="submit" value="Enregistrer" class="btn btn-primary" style="width: 100%;" id="create">
            </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-2.0.3.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    const form=document.querySelector('form');

    function init(){

        const select = document.querySelectorAll('.selectPersonne');
        //select the first option by default
        
        /////////////////////////////////////
        //POPULATE THE SELECT WITH PERSONNE//
        /////////////////////////////////////
        select.forEach((element)=>{
            element.firstChild.selected = true;
            fetch('../process/personne_process.php', {
                method: 'POST',
                body: new URLSearchParams({
                    action: 'getAllPersonne'
                })
            })
            .then(response => response.json())
            .then(data => {
                data.forEach(personne => {
                    const option = document.createElement('option');
                    option.value = personne.idPersonne;
                    option.textContent = `${personne.nom} ${personne.prenom}`;
                    option.setAttribute('idPersonne', personne.idPersonne);
                    element.appendChild(option);
                });
            });


            div = element.nextElementSibling;
            showForm(div)
            element.addEventListener('change', (e)=>{
                if(e.target.value === 'new'){
                    //afficher le formulaire pour ajouter une nouvelle connaissance
                    div = element.nextElementSibling;
                    showForm(div)
                }else{
                    idPersonne = e.target.value;
                    data1 = document.querySelector('#personne1');
                    data2 = document.querySelector('#personne2');
                    if (e.target.name == "personne1") {
                        console.log("personne1");
                        option = data2.querySelectorAll('option');
                        option.forEach((element)=>{
                            if (element.value === idPersonne) {
                                element.setAttribute('disabled', 'true');
                            }else{
                                element.removeAttribute('disabled');
                            }
                        });
                    }else{
                        console.log("personne2");
                        option = data1.querySelectorAll('option');
                        option.forEach((element)=>{
                            if (element.value === idPersonne) {
                                element.setAttribute('disabled', 'true');
                            }else{
                                element.removeAttribute('disabled');
                            }
                        });
                    }
                    
                    fetch('../process/personne_process.php', {
                        method: 'POST',
                        body: new URLSearchParams({
                            action: 'getPersonneInfoByid',
                            id: e.target.value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        //const div = document.querySelector('#data1');
                        div = element.nextElementSibling;
                        loadForm(data, div);
                    });
                }
            });

        })


        /////////////////////////////////////
        //SEND THE RELATION TO THE DATABASE//
        /////////////////////////////////////
        create = document.querySelector('#create');
        create.addEventListener('click', async (e)=>{
            e.preventDefault();


            //check if the value are ok
            annee = document.querySelector('#annee');
            if (annee.value === '') {
                toastr.error('Veillez renseigner une année valide');
                return;
            }else if (annee.value > 2100) {
                toastr.error('Veillez renseigner une année valide');
                return;
            }else if (annee.value < 1900) {
                toastr.error('Veillez renseigner une année valide');
                return;
            }



            //create the body for the relation fetch
            const formDataRelation = new FormData();

            //PERSONNE 1
            select1 = document.querySelector('#personne1');
            if (select1.value === 'new') {
                const data1=document.querySelector('#data1');
                idPersonne1=await addPerson(data1);
                formDataRelation.append('idPersonne1', idPersonne1.id);
            }else{
                formDataRelation.append('idPersonne1', select1.value);
            }

            //PERSONNE 2
            select2 = document.querySelector('#personne2');
            if (select2.value === 'new') {
                const data2=document.querySelector('#data2');
                idPersonne2=await addPerson(data2);
                formDataRelation.append('idPersonne2', idPersonne2.id);
            }else{
                formDataRelation.append('idPersonne2', select2.value);
            }


            selectVille=document.querySelector('#lieuRencontre');
            if (selectVille.value === 'new') {
                const dataVille=document.querySelector('#dataLieu');
                ville = document.querySelector('#inputVille');
                if (ville.value === '') {
                    toastr.error('Veillez choisir une ville');
                    return;
                }
                idVille=await addVille(dataVille);
                console.log(idVille);
                formDataRelation.append('idVille', idVille);
            }else{
                formDataRelation.append('idVille', selectVille.value);
            }
            typeRelation = document.querySelector('#typeRelation');
            annee = document.querySelector('#annee');
            lieuRencontre = document.querySelector('#lieuRencontre');
            souvenir = document.querySelector('#souvenir');




            formDataRelation.append('idLien', typeRelation.value);
            formDataRelation.append('annee', annee.value);
            formDataRelation.append('commentaire', souvenir.value);
            formDataRelation.append('action', 'addRelation');

            fetch('../process/relation_process.php', {
                method: 'POST',
                body: formDataRelation
            }).then(response => response.json())
            .then(data => {
                if(data.success){
                    toastr.success('Relation ajoutée'); 
                    window.location.href = '/form/nouvelleConnaissance.php';
                }else{ 
                    toastr.error(data.error);
                }
            });
        });



        //////////////////////////////////////////////
        //populate the select with the relation type//
        //////////////////////////////////////////////
        fetch('../process/relation_process.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'getAllRelationType'
            })
        }).then(response => response.json())
        .then(data => {
            console.log(data);
            const typeRelation = document.querySelector('#typeRelation');
            data.forEach(relation => {
                const option = document.createElement('option');
                option.value = relation.idLien;
                option.textContent = relation.libelle;
                option.setAttribute('idRelation', relation.idLien);
                typeRelation.appendChild(option);
            });
        });
        
        /////////////////////////////////////
        //populate the select with the town//
        /////////////////////////////////////
        populateVille();
        
    }


    function populateVille(){
        fetch('../process/ville_process.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: 'getAllVille'
            })
        }).then(response => response.json())
        .then(data => {
            console.log(data);
            const lieuRencontre = document.querySelectorAll('#lieuRencontre');
            lieuRencontre.forEach((element)=>{
                element.innerHTML = '';
                const option = document.createElement('option');
                option.value = 'new';
                option.textContent = 'Ajouter une nouvelle ville';
                element.appendChild(option);
                data.forEach(lieu => {
                    
                    const option = document.createElement('option');
                    option.value = lieu.idVille;
                    option.textContent = lieu.libelle;
                    option.setAttribute('idLieu', lieu.idVille);
                    element.appendChild(option);


                    divVille=element.nextElementSibling;
                    showInputVille(divVille);

                    element.addEventListener('change', (e)=>{
                        if(e.target.value === 'new'){
                            //afficher le formulaire pour ajouter une nouvelle ville
                            div = e.target.nextElementSibling;
                            showInputVille(div)
                        }else{
                            div = e.target.nextElementSibling;
                            div.innerHTML = '';
                            div.setAttribute('style', 'display: none;');
                        }
                    });
                });
            });


            divVille=lieuRencontre.nextElementSibling;
            showInputVille(divVille);

            lieuRencontre.addEventListener('change', (e)=>{
                if(e.target.value === 'new'){
                    //afficher le formulaire pour ajouter une nouvelle ville
                    div = e.target.nextElementSibling;
                    showInputVille(div)
                }else{
                    div = e.target.nextElementSibling;
                    div.innerHTML = '';
                    div.setAttribute('style', 'display: none;');
                }
            });
            

        });
    }







    async function addPerson(dataParam){
        const input = dataParam.querySelectorAll('input');
        //create the body for the fetch

        const formData = new FormData();

        selectVille= dataParam.querySelector('#lieuRencontre');
        if (selectVille.value === 'new') {
            const dataVille=dataParam.querySelector('#dataLieu');
            ville = dataParam.querySelector('#inputVille');
            console.log(dataVille);
            if (ville.value === '') {
                toastr.error('Veillez choisir une ville');
                return;
            }
            idVille=await addVille(dataVille);
            console.log(idVille);
            formData.append('idVille', idVille);
        }else{
            formData.append('idVille', selectVille.value);
        }


        input.forEach((element)=>{
            if(element.value !== ''){
                formData.append(element.name, element.value);
            }
        });
        formData.append("action", "addPersonne");
        response=await fetch('../process/personne_process.php', {
            method: 'POST',
            body: formData
        })
        reponse=await response.json();
        if (reponse.success) {
            toastr.success('Personne ajoutée');
        }else{
            toastr.error(reponse.error);
        }
        //return the id of the new person
        return reponse;
    }








        
    async function addVille(dataParam){
        found=false;
        console.log(dataParam)
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

        response=await fetch('../process/ville_process.php', {
            method: 'POST',
            body: formCheck
        })
        data=await response.json();
        console.log(data);

        if (!data){
            console.log('pas trouver');
            formData.append("action", "addVille");

            response=await fetch('../process/ville_process.php', {
                method: 'POST',
                body: formData
            })
            //return the id of the new town
            idVille = await response.json();
            return idVille.id; 
        }else{
            console.log('trouver');
            found=true;
            return data.idVille;
        }
    }








    function showForm(div){
        div.innerHTML = '';
        div.setAttribute('style', 'display: block;');
        const h5 = document.createElement('h5');
        h5.textContent = 'Informations';
        div.appendChild(h5);

        label = document.createElement('label');
        label.textContent = 'Prénom';
        div.appendChild(label);
        input = document.createElement('input');
        input.type = 'text';
        input.name = 'prenom';
        input.setAttribute('required', 'true');
        input.setAttribute('class', 'form-control');
        div.appendChild(input);

        label = document.createElement('label');    
        label.textContent = 'Nom';
        div.appendChild(label);
        input = document.createElement('input');
        input.type = 'text';
        input.name = 'nom';
        input.setAttribute('required', 'true');
        input.setAttribute('class', 'form-control');
        div.appendChild(input);

        label = document.createElement('label');
        label.textContent = 'dateDeNaissance';
        div.appendChild(label);
        input = document.createElement('input');
        input.type = 'date';
        input.name = 'date de naissance';
        input.setAttribute('class', 'form-control');
        div.appendChild(input);
        
        label = document.createElement('label');
        label.textContent = 'Mail';
        div.appendChild(label);
        input = document.createElement('input');
        input.type = 'email';
        input.name = 'mail';
        input.setAttribute('class', 'form-control');
        div.appendChild(input);

        label = document.createElement('label');
        label.textContent = 'Numéro';
        div.appendChild(label);
        input = document.createElement('input');
        input.type = 'tel';
        input.name = 'numéro';
        input.setAttribute('class', 'form-control');
        div.appendChild(input);

        label = document.createElement('label');
        label.textContent = 'Ville';
        div.appendChild(label);
        select = document.createElement('select');
        select.name = 'ville';
        select.setAttribute('class', 'form-control');
        select.setAttribute('id', 'lieuRencontre');
        div.appendChild(select);
        option = document.createElement('option');
        option.value = 'new';
        option.textContent = 'Ajouter une nouvelle ville';
        select.appendChild(option);
        
        divVille = document.createElement('div');
        divVille.setAttribute('id', 'dataLieu');
        divVille.setAttribute('style', 'display: none;');
        div.appendChild(divVille);
        showInputVille(divVille);
        populateVille();
    }


    function loadForm(data, div){
        console.log(data);
        console.log(div);
        div.innerHTML = '';
        

        h5 = document.createElement('h5');
        h5.textContent = 'Informations';

        div.appendChild(h5);

        nom= document.createElement('p');
        nom.textContent = `Nom: ${data.nom}`;

        prenom= document.createElement('p');
        prenom.textContent = `Prénom: ${data.prenom}`;

        age= document.createElement('p');
        console.log(data.dateDeNaissance);
        if (data.dateDeNaissance != null) {
            agePersonne = new Date().getFullYear() - new Date(data.dateDeNaissance).getFullYear();
            age.textContent = `Age: ${agePersonne}`;
        }else{
            age.textContent = `Age: Non renseigné`;
        }


        if (data.mail == null) {
            data.mail = 'Non renseigné';
        }
        mail= document.createElement('p');
        mail.textContent = `Mail: ${data.mail}`;

        if (data.numéro == null) {
            data.numéro = 'Non renseigné';
        }
        numéro= document.createElement('p');
        numéro.textContent = `Numéro: ${data.numéro}`;

        if (data.ville == null) {
            data.ville = 'Non renseigné';
        }
        ville= document.createElement('p');
        ville.textContent = `Ville: ${data.ville}`;

        div.appendChild(nom);
        div.appendChild(prenom);
        div.appendChild(age);
        div.appendChild(mail);
        div.appendChild(numéro);
        div.appendChild(ville);
        div.setAttribute('style', 'display: block;');


    }

    function showInputVille(div){
        div.innerHTML = '';
        div.setAttribute('style', 'display: block;');
    

        label = document.createElement('label');
        label.textContent = 'Ville';
        div.appendChild(label);
        input = document.createElement('input');
        input.type = 'text';
        input.setAttribute('required', 'true');
        input.setAttribute('class', 'form-control');
        input.setAttribute('id', 'inputVille');
        div.appendChild(input);
    }


    document.addEventListener('DOMContentLoaded', init);
    //init();
</script>
</html>