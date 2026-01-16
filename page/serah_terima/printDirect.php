
<?php
/* Change to the correct path if you copy this example! */
require __DIR__ . '/../../assets/pos/vendor/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
$connector = new WindowsPrintConnector("Panda");

    /* Print a "Hello world" receipt" */
    $printer = new Printer($connector);

    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $printer -> setTextSize(4,4);
    $printer -> text("A/2\n");
    $printer -> text("\n");
    $printer -> setTextSize(1,1);
    $printer -> text("LABEL FINISH GOOD\n");
    $printer -> text("PT INDOFOOD FRITOLAY MAKMUR\n");
    $printer -> text("PLANT CIKUPA\n");
    $printer -> setTextSize(1,1);
    $printer -> text("LINE PC 32\n");
    $printer -> text("\n");
    // Nama Produk
    $printer -> setJustification(Printer::JUSTIFY_LEFT);
    $printer -> text("Produk");
    $printer -> setPrintLeftMargin(128);
    $printer -> text(":");
    $printer -> setPrintLeftMargin(150);
    $printer -> text("BEB 68 GR\n");
    // Jumlah
    $printer -> setPrintLeftMargin(0);
    $printer -> text("Jumlah");
    $printer -> setPrintLeftMargin(128);
    $printer -> text(":");
    $printer -> setPrintLeftMargin(150);
    $printer -> text("10");
    $printer -> setPrintLeftMargin(300);
    $printer -> text("No Pallet :");
    $printer -> setPrintLeftMargin(450);
    $printer -> text("1\n");
    // Waktu
    $printer -> setPrintLeftMargin(0);
    $printer -> text("Waktu");
    $printer -> setPrintLeftMargin(128);
    $printer -> text(":");
    $printer -> setPrintLeftMargin(150);
    $printer -> text("2020-09-23");
    $printer -> setPrintLeftMargin(300);
    $printer -> text("- 10:35:05\n");
    // Barcode
    $printer -> setJustification(Printer::JUSTIFY_CENTER);
    $testStr = "Testing 123";
    $printer -> qrCode($testStr, Printer::QR_ECLEVEL_L, 8);
    $printer -> text("\n");
    $printer -> setJustification(Printer::JUSTIFY_LEFT);
    $printer -> setPrintLeftMargin(0);
    $printer -> text("Diserahkan");
    $printer -> setPrintLeftMargin(300);
    $printer -> text("Diterima\n");
    $printer -> text("\n");
    $printer -> text("\n");
    
    $printer -> setJustification(Printer::JUSTIFY_LEFT);
    $printer -> setPrintLeftMargin(0);
    $printer -> text("Dwi Wanti");
    $printer -> setPrintLeftMargin(300);
    $printer -> text("Abdul\n");
    $printer -> text("\n");
    $printer -> text("\n");
    $printer -> text("\n");
    $printer -> text("\n");
    $printer -> text("\n");
    $printer -> text("\n");
    $printer -> text("\n");
    $printer -> text("\n");
    /* Close printer */
    $printer -> feed();
    $printer -> close();
