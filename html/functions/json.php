<?

function output_json($data) { 
    $json = json_encode($data);
    header('content-type: application/json; charset=utf-8');
    header("access-control-allow-origin: *");
    echo isset($_GET['callback']) ? "{$_GET['callback']}($json)" : $json;    
}

?>