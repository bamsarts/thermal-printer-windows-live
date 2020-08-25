<?php

/* Demonstration of available options on the qrCode() command */
require __DIR__ . '/vendor/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
// use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

try{
    $qrData = $_GET['qr'];
    $redirect = $_GET['redirect'];
    $computer = $_GET['computer'];
    $printerName = $_GET['printer'];

    $connector = new WindowsPrintConnector($printerName);
    $printer = new Printer($connector);
    
    $printer -> feed();
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> qrCode("$qrData", Printer::QR_ECLEVEL_L, 10);
    $printer -> text("$qrData\n");
    $printer -> feed(2);

    // Cut & close
    $printer -> cut();
    $printer -> close();

    header("Location: $redirect");
    exit();

}catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}


?>
