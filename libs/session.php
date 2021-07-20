<?php
// assign session
function session_set($key,$val){
    $_SESSION[$key] = $val;
}
// get session
function session_get($key){
    return (isset($_SESSION[$key]) ? $_SESSION[$key] : false);
}
// delete session
function session_delete($key){
    if(isset($_SESSION[$key])){
        unset($_SESSION[$key]);
    }
}
?>