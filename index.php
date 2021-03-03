<?php

require_once 'web2pdf.class.php';

$pdf = new Web2PDF("hi.com");

try {
    echo $pdf->exec()->get_result();
} catch (CommandFailedException $e) {
    echo "Command failed <br>" . $e->getMessage();
} catch (CommandNotFoundException $e) {
    echo "Command not found <br>" . $e->getMessage();
}