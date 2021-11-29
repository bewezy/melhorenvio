<?php

require __DIR__ . "/../../vendor/autoload.php";

use MelhorEnvio\Shipment;
use MelhorEnvio\Resources\Shipment\Package;
use MelhorEnvio\Enums\Service;
use MelhorEnvio\Enums\Environment;

// Create Shipment Instance
$shipment = new Shipment(
    'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImZmYzU2YTIwZWZjNGJhODI2MTk2NTgyNzQ3N2NkY2YxZDIyNWI4NzJiOTk4OWIxNGJiMzNkMTgwYTBjMzk3ZmM4MTNjMzk1ZTJkNDM3ZTc4In0.eyJhdWQiOiI5NTYiLCJqdGkiOiJmZmM1NmEyMGVmYzRiYTgyNjE5NjU4Mjc0NzdjZGNmMWQyMjViODcyYjk5ODliMTRiYjMzZDE4MGEwYzM5N2ZjODEzYzM5NWUyZDQzN2U3OCIsImlhdCI6MTYzNzkzMzA5OCwibmJmIjoxNjM3OTMzMDk4LCJleHAiOjE2Njk0NjkwOTgsInN1YiI6IjY2ODc0ZWYxLWEwNTItNDI0ZS04NGFmLTcwYjk0MmFjNWFhNSIsInNjb3BlcyI6WyJjYXJ0LXJlYWQiLCJjYXJ0LXdyaXRlIiwiY29tcGFuaWVzLXJlYWQiLCJjb21wYW5pZXMtd3JpdGUiLCJjb3Vwb25zLXJlYWQiLCJjb3Vwb25zLXdyaXRlIiwibm90aWZpY2F0aW9ucy1yZWFkIiwib3JkZXJzLXJlYWQiLCJwcm9kdWN0cy1yZWFkIiwicHJvZHVjdHMtZGVzdHJveSIsInByb2R1Y3RzLXdyaXRlIiwicHVyY2hhc2VzLXJlYWQiLCJzaGlwcGluZy1jYWxjdWxhdGUiLCJzaGlwcGluZy1jYW5jZWwiLCJzaGlwcGluZy1jaGVja291dCIsInNoaXBwaW5nLWNvbXBhbmllcyIsInNoaXBwaW5nLWdlbmVyYXRlIiwic2hpcHBpbmctcHJldmlldyIsInNoaXBwaW5nLXByaW50Iiwic2hpcHBpbmctc2hhcmUiLCJzaGlwcGluZy10cmFja2luZyIsImVjb21tZXJjZS1zaGlwcGluZyIsInRyYW5zYWN0aW9ucy1yZWFkIiwidXNlcnMtcmVhZCIsInVzZXJzLXdyaXRlIiwid2ViaG9va3MtcmVhZCIsIndlYmhvb2tzLXdyaXRlIl19.bqGgUjnX5YKOVtqYXG4ZC5sF0QTAex0fwwForrXMAQfypPH88CQQwYTVj5zenZwzk6vTpogAiwUw0cVIKTXwUFCVRjmnjYFaaGyKP51hKLyNoffJVdPozK3ohO3BZsZm3UwKJehlsAeKFck1UWr6cIjJaev9kzlL167lJF6_vSar7MaYNDb9Kf7lsX_960EtjSGobAvcDnPK5--a8IyJr76l-0IqWnaaCCk3N2TJI5Dqhh2aqq-jHk3I94qmcoh4UyVkuKOdNfw8dPRxqNrNoKXAfEFVSO9o1uGVLtbJcwprtTf55DTTbKrX7_Q2rBr3mYEuYk4VACD8H_YWO7Wb2PhGfPC5bab4fKJFXM2PFWeVG2aycBJjE3xKAIuhEXLJaYOIQN-D_utfISVoO9IYqojmAR9PohFhrr3pHbQmnHnWcdbzm5dL1KfpjHmb7m66IydEp8HHGyzD7eIqSNlbtmt66D6GS1K-Osh_a2PUXNyLl1vl9WCXD_pe7z8XQN2rANjaZIy7sXTkcM_ZByVKnazS8cE__klOG-RItBF0FJ81MpYf1mT98hc98kvmdZfIcd0RefH6UkB0-4qwsCm74oPqI5mHKT-EeaZUHpKltTqhuzB_9JlK3VqEl1jZGjiwQePIrrakcuIb4uz2Es9Dkwr7Z9mO0GOm1xTfac_k7Xs',
    Environment::SANDBOX
);

$idActul = "271fca9d-5435-4a35-9f04-67d226399c30";

$cart = $shipment->cart();

$viewPrices = false;
$addCart = false;
$pay = false;
$preview = false;
$generate = true;
$print = false;


if ($generate){

    $checkout = $shipment->checkout();
    $checkout->addOrder($idActul);
    try {
        $generate = $checkout->generate();
        pre($generate);
    } catch (\MelhorEnvio\Exceptions\CalculatorException $e) {
        echo (json_decode($e->getMessage()))->error;
    }

}

if ($print){

    $checkout = $shipment->checkout();
    $checkout->addOrder($idActul);
    try {
        $print = $checkout->print();
        echo "Print: <a href='{$print['url']}' target='_blank'>IMPRIMIR ETIQUETA</a> <br><br>";
    } catch (\MelhorEnvio\Exceptions\CalculatorException $e) {
        echo (json_decode($e->getMessage()))->error;
    }

}

if ($preview){

    $checkout = $shipment->checkout();
    $checkout->addOrder($idActul);
    try {
        $preview = $checkout->preview();
        echo "Preview:<a href='{$preview['url']}' target='_blank'>IMPRIMIR ETIQUETA</a> <br><br>";
    } catch (\MelhorEnvio\Exceptions\CalculatorException $e) {
        echo (json_decode($e->getMessage()))->error;
    }

}

if ($pay){
    $checkout = $shipment->checkout();
    $checkout->addOrder($idActul);
    try {
        pre($checkout->checkout());
    } catch (\MelhorEnvio\Exceptions\CalculatorException $e) {
        echo (json_decode($e->getMessage()))->error;
    }

}

if ($addCart){

    try {
        $cart->service(3);
        $cart->agency(49);
        $cart->from([
            "name" => "Fernando Ebert",
            "phone" => "53984470102",
            "email" => "contato@melhorenvio.com.br",
            "document" => "16571478358",
            "company_document" => "89794131000100",
            "state_register" => "123456",
            "address" => "Endereço do remetente",
            "complement" => "Complemento",
            "number" => "1",
            "district" => "Bairro",
            "city" => "São Paulo",
            "country_id" => "BR",
            "postal_code" => "01002001",
            "note" => ""
        ]);
        $cart->to([
            "name" => "Fernando Ebert",
            "phone" => "53984470102",
            "email" => "contato@melhorenvio.com.br",
            "document" => "71233932012",
            "company_document" => "89794131000101",
            "state_register" => "123456",
            "address" => "Endereço do remetente",
            "complement" => "Complemento",
            "number" => "1",
            "district" => "Bairro",
            "city" => "São Paulo",
            "country_id" => "BR",
            "postal_code" => "90570020",
            "note" => ""
        ]);
        $cart->addProducts(
            $cart->addProduct(["name" => "Papel adesivo para etiquetas 1", "quantity" => 1, "unitary_value" => 100.00]),
            $cart->addProduct(["name" => "Papel adesivo para etiquetas 2", "quantity" => 1, "unitary_value" => 100.00])
        );
        $cart->addVolumes(
            $cart->addVolume(["height" => 15, "width" => 20, "length" => 10, "weight" => 3.5])
        );
        $cart->setInsuranceValue(200.00);
        $cart->setReceipt(false);
        $cart->setNonCommercial(true);
        $cart->setOwnHand(false);
        $cart->setReverse(false);
        $cart->setInvoice("31190307586261000184550010000092481404848162");
        $cart->setPlatform("Cayman Sistemas");
        $cart->addTag('000001');


        $cartResponse = $cart->sendCart();
        pre($cartResponse);

    } catch (Exception $exception){
        pre($exception);
    }

    //try {
    //    pre($cart->find()->fetch());
    //    $findById = $cart->findById("b46547b6-4932-4e39-a39b-28f0a8fa0424");
    //    pre($findById->fetch());
    //    pre($findById->destroy());
    //} catch (\MelhorEnvio\Exceptions\CalculatorException $e) {
    //    pre($e);
    //}

}

if ($viewPrices){

    try {
        // Create Calculator Instance
        $calculator = $shipment->calculator();

        //Builds calculator payload
        $calculator->postalCode('01002001', '90570020');

        $calculator->setOwnHand();
        $calculator->setReceipt(false);
        $calculator->setCollect(false);

        $calculator->addPackages(
            new Package(15, 10, 10, 3.5, 200)
        );

        $calculator->addServices(
            Service::CORREIOS_PAC, Service::CORREIOS_SEDEX, Service::JADLOG_PACKAGE, Service::JADLOG_COM, Service::AZULCARGO_AMANHA
        );

        $quotations = $calculator->calculate();
    }catch (Exception $exception) {
        //Proper exception context
    }

    pre($quotations);

}

function pre($mixed){
    echo "<pre>";
    print_r($mixed);
    echo "</pre>";
}
exit;
