<?php

require_once 'web2pdf.class.php';

use \Web2PDF\Web2PDF;

$pdf = new Web2PDF("google.com");

try {
    echo nl2br($pdf->exec()->get_output());
}
catch (CommandFailedException $e) {
    echo "Command failed <br>" . $e->getMessage();
}
catch (CommandNotFoundException $e) {
    echo "Command not found <br>" . $e->getMessage();
}