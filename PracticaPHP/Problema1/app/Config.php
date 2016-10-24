<?php

$GLOBALS['urlapp'] = 'http://localhost/PracticaPHP/Problema1/App/';

require 'controllers/OfertasControl.php';


$oferta = new OfertasControl();
$oferta->Inicio();