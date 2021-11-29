<?php

require __DIR__ . "/../../vendor/autoload.php";

use MelhorEnvio\Shipment;
use MelhorEnvio\Resources\Shipment\Product;
use MelhorEnvio\Enums\Environment;

// Create Shipment Instance
$shipment = new Shipment(
    'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImZmYzU2YTIwZWZjNGJhODI2MTk2NTgyNzQ3N2NkY2YxZDIyNWI4NzJiOTk4OWIxNGJiMzNkMTgwYTBjMzk3ZmM4MTNjMzk1ZTJkNDM3ZTc4In0.eyJhdWQiOiI5NTYiLCJqdGkiOiJmZmM1NmEyMGVmYzRiYTgyNjE5NjU4Mjc0NzdjZGNmMWQyMjViODcyYjk5ODliMTRiYjMzZDE4MGEwYzM5N2ZjODEzYzM5NWUyZDQzN2U3OCIsImlhdCI6MTYzNzkzMzA5OCwibmJmIjoxNjM3OTMzMDk4LCJleHAiOjE2Njk0NjkwOTgsInN1YiI6IjY2ODc0ZWYxLWEwNTItNDI0ZS04NGFmLTcwYjk0MmFjNWFhNSIsInNjb3BlcyI6WyJjYXJ0LXJlYWQiLCJjYXJ0LXdyaXRlIiwiY29tcGFuaWVzLXJlYWQiLCJjb21wYW5pZXMtd3JpdGUiLCJjb3Vwb25zLXJlYWQiLCJjb3Vwb25zLXdyaXRlIiwibm90aWZpY2F0aW9ucy1yZWFkIiwib3JkZXJzLXJlYWQiLCJwcm9kdWN0cy1yZWFkIiwicHJvZHVjdHMtZGVzdHJveSIsInByb2R1Y3RzLXdyaXRlIiwicHVyY2hhc2VzLXJlYWQiLCJzaGlwcGluZy1jYWxjdWxhdGUiLCJzaGlwcGluZy1jYW5jZWwiLCJzaGlwcGluZy1jaGVja291dCIsInNoaXBwaW5nLWNvbXBhbmllcyIsInNoaXBwaW5nLWdlbmVyYXRlIiwic2hpcHBpbmctcHJldmlldyIsInNoaXBwaW5nLXByaW50Iiwic2hpcHBpbmctc2hhcmUiLCJzaGlwcGluZy10cmFja2luZyIsImVjb21tZXJjZS1zaGlwcGluZyIsInRyYW5zYWN0aW9ucy1yZWFkIiwidXNlcnMtcmVhZCIsInVzZXJzLXdyaXRlIiwid2ViaG9va3MtcmVhZCIsIndlYmhvb2tzLXdyaXRlIl19.bqGgUjnX5YKOVtqYXG4ZC5sF0QTAex0fwwForrXMAQfypPH88CQQwYTVj5zenZwzk6vTpogAiwUw0cVIKTXwUFCVRjmnjYFaaGyKP51hKLyNoffJVdPozK3ohO3BZsZm3UwKJehlsAeKFck1UWr6cIjJaev9kzlL167lJF6_vSar7MaYNDb9Kf7lsX_960EtjSGobAvcDnPK5--a8IyJr76l-0IqWnaaCCk3N2TJI5Dqhh2aqq-jHk3I94qmcoh4UyVkuKOdNfw8dPRxqNrNoKXAfEFVSO9o1uGVLtbJcwprtTf55DTTbKrX7_Q2rBr3mYEuYk4VACD8H_YWO7Wb2PhGfPC5bab4fKJFXM2PFWeVG2aycBJjE3xKAIuhEXLJaYOIQN-D_utfISVoO9IYqojmAR9PohFhrr3pHbQmnHnWcdbzm5dL1KfpjHmb7m66IydEp8HHGyzD7eIqSNlbtmt66D6GS1K-Osh_a2PUXNyLl1vl9WCXD_pe7z8XQN2rANjaZIy7sXTkcM_ZByVKnazS8cE__klOG-RItBF0FJ81MpYf1mT98hc98kvmdZfIcd0RefH6UkB0-4qwsCm74oPqI5mHKT-EeaZUHpKltTqhuzB_9JlK3VqEl1jZGjiwQePIrrakcuIb4uz2Es9Dkwr7Z9mO0GOm1xTfac_k7Xs',
    Environment::SANDBOX);

try {
    // Create Calculator Instance
    $calculator = $shipment->calculator();

    // Builds the calculator payload.
    $calculator->postalCode('01010010', '20271130');

    $calculator->setOwnHand();
    $calculator->setReceipt(false);
    $calculator->setCollect(false);

    $calculator->addProducts(
        new Product(uniqid(), 40, 30, 50, 10.00, 100.0, 1),
        new Product(uniqid(), 5, 1, 10, 0.1, 50.0, 1)
    );

    pre($calculator->getPayload());

    $quotations = $calculator->calculate();
} catch (Exception $exception) {
    $quotations = $exception;
}

pre($quotations);

function pre($mixed){
    echo "<pre>";
    print_r($mixed);
    echo "</pre>";
}
exit;
