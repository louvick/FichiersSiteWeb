window.onload = () => {
    let input = document.querySelectorAll(".grid-container input[name='produit']");

    for (let i = 0; i < input.length; i++) {
        console.log(input[i]);
        input[i].addEventListener("focusout",changeValue);
    }
}

function changeValue(e) {
    e.target.nextElementSibling.nextElementSibling.value = e.target.value*e.target.nextElementSibling.value;
    let input = document.querySelectorAll(".grid-container input[name='produit']");
    let total = document.querySelectorAll("#produitltot")[0];

    for (let i = 0; i < input.length; i++) {
        total.value= Number(total.value) + Number(input[i].nextElementSibling.nextElementSibling.value);
    }

}

function orderToJson() {
    // À compléter plus loin dans le laboratoire. Cette fonction doit retourner au format JSON les ID et
    // les quantités des produits figurant dans la commande de l’utilisateur.
}

function paypalAjax(sendUrl, sendBody) {
    return new Promise((resolve, reject) => {
        let xhr = new XMLHttpRequest();

        xhr.open("post", sendUrl);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onload = () => resolve(JSON.parse(xhr.responseText));
        xhr.onerror = () => reject(xhr.statusText);
        xhr.send(JSON.stringify(sendBody));
    });
}

paypal.Buttons({
    createOrder: function() {
        return paypalAjax("./paypal", orderToJson()).then(
            function(promiseResponse) {
                console.log("Transaction #" + promiseResponse.id + " initiated");
                return promiseResponse.id;
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(transactionDetails) {
                console.log("Transaction completed by " + transactionDetails.payer.name.given_name);
            });
        }
    }).render("#paypal-button-container");
