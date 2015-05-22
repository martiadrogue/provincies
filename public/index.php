<?php

mb_internal_encoding('UTF-8');
require_once '../vendor/autoload.php';

use Com\Martiadrogue\Mpwarfwk\BootstrapDev;
use Com\Martiadrogue\Mpwarfwk\Connection\Http\Request;

$request = Request::createFromGlobals();
$bootstrap = new BootstrapDev();
$bootstrap->boot($request);
