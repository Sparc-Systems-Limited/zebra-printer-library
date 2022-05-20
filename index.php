<?php
error_reporting(E_ALL);

function generateLabel($serial_no, $barcode, $item_name, $company, $printer_port){

try{
/* Get the port for the service. */
$port = $printer_port;

/* Get the IP address for the target host. This is the default port for printers*/
$host = "192.168.1.92";

/* construct the label */
$label = "^XA

^FX Top section with logo, name and address.
^CF0,60
^FO110,100^FD".$company."^FS

^FX Second section with item information
^CFA,30
^FO30,300^FDITEM NAME: ".$item_name."^FS
^FO30,340^FDSERIAL NO: ".$serial_no."^FS

^FX Third section with bar code.
^BY5,2,270
^FO100,550^BC^FD".$barcode."^FS

^XZ";

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error    ()) . "\n";
} else {
    echo "OK.\n";
}

echo "Attempting to connect to '$host' on port '$port'...";
$result = socket_connect($socket, $host, $port);
if ($result === false) {
    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror    (socket_last_error($socket)) . "\n";
} else {
    return "Label Printed";
}

socket_write($socket, $label, strlen($label));
socket_close($socket);
}

}catch(Exception $e) {

    return "Failed to Print Label";
}

?>