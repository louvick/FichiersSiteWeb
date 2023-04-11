<?php 
// Ne modifiez pas cette fonction. Elle est complète et appelée par la fonction « registerOrder() ».
function createOrder(array &$paypalInfos) : object {
    require('./vendor/autoload.php');

    $request = new PayPalCheckoutSdk\Orders\OrdersCreateRequest();
    $request->prefer('return=representation');
    $request->body = buildRequestBody($paypalInfos);

    if (!empty($request->body)) {
        $client = Sample\PayPalClient::client();
        return $client->execute($request);
    }

    return null;
}

function buildRequestBody(array &$paypalInfos) : array {
    require('./model/ProduitManager.php');

    // Retournez, ici, le grand tableau d’une commande PayPal présenté plus tôt dans cet énoncé
    // de laboratoire. Vous devrez formatter ce grand tableau pour que les noms des produits, leur
    // prix et leur quantité respectifs soient placés sous la clé « items » (un index (0, 1, 2, etc.)
    // par produit sous la clé « items »). Le nom et le prix unitaire de chaque produit devront être
    // récupérés en BD à l’aide du fichier ProduitManager.php.
}

function registerOrder(int $idUtilisateur, array $paypalInfos) : object {
    $paypalTransaction = createOrder($paypalInfos);
    
    if (!is_null($paypalTransaction)) {
        require('./model/CommandeManager.php');
        
        // Procédez à l’insertion de la commande et des informations de la transaction Paypal dans
        // les tables tbl_commande_produit et tbl_commande respectivement et ce, à l’aide du fichier
        // CommandeManager.php.
        
        return $paypalTransaction;
    }

    return null;
}

// Ajoutez ici la fonction qui permettra d’enregistrer dans la BD les informations de l’acheteur à partir
// de l’événement « checkout order approved ». Ajoutez aussi la fonction qui permettra de faire passer à
// 1 le statut de la commande sur réception de l’événement « payment capture completed ».


?>