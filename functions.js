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



function getAllRelation(action, id) {
    fetch('/process/relation_process.php', {
            method: 'POST',
            body: new URLSearchParams({
                action: action,
                idPersonne: id
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            afficherRelation(data)
            const toggleLastName = document.getElementById('toggleLastName');
            toggleLastName.addEventListener('click', function() {
                if (toggleLastName.getAttribute('activé') == 'true') {
                    toggleLastName.setAttribute('activé', 'false');
                    toggleLastName.setAttribute('class', 'btn btn-outline-secondary');
                    afficherRelation(data, false)
                    return;
                } else {
                    toggleLastName.setAttribute('activé', 'true');
                    toggleLastName.setAttribute('class', 'btn btn-secondary');
                    afficherRelation(data, true)
                }
            });
        });
}


function afficherRelation(data, showLastName = false) {
    taille = data.length;

    let connaissances = document.getElementById('connaissances');
    connaissances.innerHTML = ``;

    let div = document.createElement('div');
    div.classList.add('row');
    i = 0;
    data.forEach(element => {
        let divCol = document.createElement('div');
        divCol.classList.add('col');
        let card = document.createElement('div');
        card.classList.add('card', 'shadow-lg', 'rounded', 'mt-3');
        let cardHeader = document.createElement('div');
        cardHeader.classList.add('card-header');
        let h5 = document.createElement('h5');
        if (showLastName) {
            h5.textContent = element.nom_personne1 + " " + element.prenom_personne1 + " et " + element.nom_personne2 + " " + element.prenom_personne2;
        } else {
            h5.textContent = element.prenom_personne1 + " et " + element.prenom_personne2;
        }
        cardHeader.appendChild(h5);
        let cardBody = document.createElement('div');
        cardBody.classList.add('card-body');
        let p = document.createElement('p');
        p.innerHTML = `Rencontré en ${element.annee} à ${element.libelle} <br> <p>Commantaire : </p>${element.commentaire}`;


        let buttonModify = document.createElement('button');
        buttonModify.classList.add('btn', 'btn-primary', 'btn-sm');
        buttonModify.textContent = 'Modifier';
        buttonModify.addEventListener('click', function() {
            console.log('modifier'); //TODO: ajouter la fonctionnalité de modification
        });


        cardBody.appendChild(p);
        cardBody.appendChild(buttonModify);
        card.appendChild(cardHeader);
        card.appendChild(cardBody);
        divCol.appendChild(card);
        div.appendChild(divCol);
        i++;
        if (i % 2 == 0) {
            connaissances.appendChild(div);
            div = document.createElement('div');
            div.classList.add('row');
        }
    });

    connaissances.appendChild(div);


}