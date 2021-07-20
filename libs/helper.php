<?php
// get method
$id = isset($_GET['id']) ? abs(intval($_GET['id'])) : false;
$do = isset($_GET['do']) ? trim(htmlspecialchars($_GET['do'])) : false;
$homeurl = 'http://localhost/newspaper/';
// create url
function homeurl($url = ''){
    global $homeurl;
    return $homeurl.$url;
}
// redirect
function redirect($url){
    header("Location:{$url}");
    exit();
}
// get value from POST
function input_post($key){
    return isset($_POST[$key]) ? trim(htmlspecialchars($_POST[$key])) : false;
}
// get value from GET
function input_get($key){
    return isset($_GET[$key]) ? trim(htmlspecialchars($_GET[$key])) : false;
}
// show error
function showError($error,$key){
    echo '<div class="text-danger">'.(empty($error[$key]) ? "" : $error[$key]).'</div>';
}

?>