<?php

// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require '../vendor/autoload.php';

// General helper functions
require_once '../helpers/helpers.php';

require_once '../engine/ignition.php';

//Init Core Library
$init = new Core;
