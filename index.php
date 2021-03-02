<?php

require_once 'Web2PDF.php';

$pdf = new Web2PDF("https://facebook.com");

echo nl2br($pdf->exec()->get_output());