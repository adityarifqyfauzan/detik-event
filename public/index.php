<?php

use Aditya\DetikTest\Controllers\EventController;
use Aditya\DetikTest\Controllers\TicketController;

require __DIR__ .'/../bootstrap/bootstrap.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

// event endpoint
$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($uri[2] == 'event') {

    $eventID = null;
    if (isset($uri[3])) {
        $eventID = (int) $uri[3];
    }

    $eventController = new EventController($dbConnection, $requestMethod, $eventID);
    $eventController->processRequest();

} else if ($uri[2] == 'ticket') {

    $ticketID = null;
    $ticketCode = null;
    
    if (isset($uri[3])) {
        $ticketID = $uri[3];
    }
    if (isset($_GET['code'])) {
        $ticketCode = $_GET['code'];
    }

    $ticketController = new TicketController($dbConnection, $requestMethod, $ticketID, $ticketCode);
    $ticketController->processRequest();

} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}
