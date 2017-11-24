<?php

function p($arr){
    echo "<pre>";
    print_r($arr);
}

function d($var){
    echo "<pre>";
    var_dump($var);
}

/**
 * 检查checkbox是否被全中
 *
 * @param $id
 * @param $ids
 */
function checkBoxChecked($id, $ids, $status = 'checked') {

    echo ($ids && in_array($id,$ids)) ? $status : false;

}

function routeName($route){

    return !$route?:route(config("routetoname.{$route}"));
}

//网站域名
function webDomain($rtn = false){
    $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
    if(!$rtn)
        echo $http_type.$_SERVER['HTTP_HOST'];
    else
        return $http_type.$_SERVER['HTTP_HOST'];
}