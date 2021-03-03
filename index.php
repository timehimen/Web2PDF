<?php

require_once 'web2pdf.class.php';

use \Web2PDF\Web2PDF;

use Web2PDF\Exceptions\CommandFailedException;
use Web2PDF\Exceptions\CommandNotFoundException;

$pdf = new Web2PDF("wkhtmltopdf");

$pdf->set_option("lowquality");

try {
    echo nl2br($pdf->exec("google.com")->get_output());
}
catch (CommandFailedException $e) {
    echo "Command failed <br>" . $e->getMessage();
    echo $pdf->get_output();
}
catch (CommandNotFoundException $e) {
    echo "Command not found <br>" . $e->getMessage();
}