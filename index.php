<?php

/**
 * Microframework
 *
 * @author   Edwin Ramírez <tavo198718@gmail.com>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/

require_once __DIR__ . '/bootstrap/autoload.php';

$url = (isset( $_GET['url'] ) ) ? $_GET['url'] : '/Home';

controller($url);











