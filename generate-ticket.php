<?php

use Aditya\DetikTest\Helper\TicketCodeGenerator;
use Aditya\DetikTest\Models\Event;
use Aditya\DetikTest\Models\Ticket;

require __DIR__ .'/bootstrap/bootstrap.php';

parse_str(implode('&', array_slice($argv, 1)), $_GET);


if (!isset($_GET['event_id'])) {
    echo "event id harus diisi";   
    exit();
}
if (!isset($_GET['total'])) {
    echo "total tiket harus diisi";   
    exit();
}

$eventID = $_GET['event_id'];
$total = $_GET['total'];

// check event
$event = new Event($dbConnection);
$result = $event->get($eventID);

if (!$result) {
    echo "event dengan id: " . $eventID . " tidak ditemukan";
    exit();
}

echo "====================================\n";
echo "Ticket Generator \n";
echo "====================================\n";
echo "Event Name: " . $result['name'] . " \n";
echo "Ticket Total: " . $total . " \n";
echo "yakin ingin melanjutkan proses?(Y/n): ";

$test = pause();
$test = trim($test);

if ($test === "Y" || $test === "" || $test === null) {
    
    for($x = 1; $x <= $total; $x++){
         
        $ticketCode = TicketCodeGenerator::generate();
    
        $ticket = new Ticket($dbConnection);
    
        $input = [
            "event_id" => $eventID,
            "code" => $ticketCode
        ];
    
        $ticket->save($input);
    
        show_status($x, $total);
        usleep(10000);      
    }

    echo "Proses Generate Ticket Berhasil";
    // exit();
}


function pause() {
    $handle = fopen ("php://stdin","r");
    do { $line = fgets($handle); } while ($line == '');
    fclose($handle);
    return $line;
}

function show_status($done, $total, $size=30) {
 
    static $start_time;
 
    // if we go over our bound, just ignore it
    if($done > $total) return;
 
    if(empty($start_time)) $start_time=time();
    $now = time();
 
    $perc=(double)($done/$total);
 
    $bar=floor($perc*$size);
 
    $status_bar="\r[";
    $status_bar.=str_repeat("=", $bar);
    if($bar<$size){
        $status_bar.=">";
        $status_bar.=str_repeat(" ", $size-$bar);
    } else {
        $status_bar.="=";
    }
 
    $disp=number_format($perc*100, 0);
 
    $status_bar.="] $disp%  $done/$total";
 
    $rate = ($now-$start_time)/$done;
    $left = $total - $done;
    $eta = round($rate * $left, 2);
 
    $elapsed = $now - $start_time;
 
    $status_bar.= " remaining: ".number_format($eta)." sec.  elapsed: ".number_format($elapsed)." sec.";
 
    echo "$status_bar  ";
 
    flush();
 
    // when done, send a newline
    if($done == $total) {
        echo PHP_EOL;
    }
 
}