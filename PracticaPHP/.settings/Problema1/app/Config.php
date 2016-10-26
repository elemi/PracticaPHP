<?php

$GLOBALS['urlapp'] = 'http://localhost/PracticaPHP1/Problema1/app/';

require 'controllers/OfertasControl.php';

$oferta = new OfertasControl();
$oferta->Inicio();