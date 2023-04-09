
window.onload = () => {
    let form = document.querySelectorAll("#addProduitForm")[0];
    form.addEventListener("submit", addProduit);
    document.querySelectorAll("input[src='./inc/img/add-icon.png']")[0].addEventListener("click",function() {show(form);});
    let deleteIcon = document.querySelectorAll("input[src='./inc/img/delete-icon.png']");

    for(let i =0;i<deleteIcon.length;i++) {
        deleteIcon[i].addEventListener("click",suppr);
    }
}


function show(form) {
    if(form.classList.contains("hidden")) {
        form.classList.remove("hidden");
    }
    else {
        form.classList.add("hidden");
    }
}

function suppr(event) {
    if(confirm("Etes-vous sur de vouloir supprimer cet element ?")) {
        event.target.parentElement.remove();
        testajax("action=supression&id_produit="+event.target.value)
    }
    else {
        
    }
}

function testajax(bodyRequest)  {
    
    // Création de l'objet XMLHttpRequest
    let xhttp = new XMLHttpRequest();

    // Fonction automatiquement appelée quand l'état de la requête change

    xhttp.onreadystatechange = function() {
        if (this.readyState === 4) {
            if (this.status === 200) {
                

                alert("La requête AJAX a marché");
                document.querySelectorAll('#addProduitForm input[name="produit"]')[0].value ="";
                document.querySelectorAll('#addProduitForm select')[0].value=1;
                document.querySelectorAll('#addProduitForm input[name="description"]')[0].value="";
                document.querySelectorAll('#addProduitForm')[0].classList.add("hidden");
                let tableau = new URLSearchParams(bodyRequest);

                if(tableau.get('action')=='createProduit') {
                    let div = `
                <div>
                <h3>Produit: `+tableau.get('produit')+` </h3>
                <p>Description: `+tableau.get('description')+` </p>
                <input type="image" src="./inc/img/delete-icon.png" alt="Supprimer un produit" value="`+this.response+`">
                <hr>
                </div>`;
                document.querySelectorAll("div:last-of-type input[src='./inc/img/delete-icon.png']")[0].parentElement.insertAdjacentHTML("afterend",div);
                }
                let deleteIcon = document.querySelectorAll("input[src='./inc/img/delete-icon.png']");

                for(let i =0;i<deleteIcon.length;i++) {
                    deleteIcon[i].addEventListener("click",suppr);
                }
                /* Que faire avec le résultat de la requête ? Le
                résultat se trouve dans "this.responseText". */
            }
            // Si la requête n'a pas fonctionné (code d'erreur "400 Bad Request")
            else if (this.status === 400) {
                alert("La requête AJAX n'a pas marché");
            }
        }
    };
    /* Quelle URL doit-on appeler ? La méthode utilisée est-elle en GET
    ou en POST ? */
    xhttp.open("post", "index.php", true);
    xhttp.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    xhttp.send(bodyRequest);
};

function addProduit(event) {
    event.preventDefault();
    let produit = document.querySelectorAll('#addProduitForm input[name="produit"]')[0].value
    let categorie = document.querySelectorAll('#addProduitForm select')[0].value;
    let description = document.querySelectorAll('#addProduitForm input[name="description"]')[0].value;
    if(produit&&categorie&&description) {
        bodyRequest = "action=createProduit&produit="+produit +"&categorie="+ categorie +"&description="+ description;
        testajax(bodyRequest);
    }
    else {
        alert("Les valeurs sont nulles");
    }
    

}


