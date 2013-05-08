<?
function url_clean($url){ 
    $url_array              = parse_url($url);
    $url_array['scheme']    = $url_array['scheme'] . "://";
    $url_array['path']      = urlencode($url_array['path']);
    @$url_array['query']    = "?" . urlencode($url_array['query']);
    @$url_array['fragment'] = "#" . urlencode($url_array['fragment']);    
    $url = implode($url_array);
    return($url);
}



?>