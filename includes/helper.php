<?php 
//***** Debug *****//
function dd(){
    echo '<pre>';
    $numargs  = func_num_args();
    $arg_list = func_get_args();
    for ($i = 0; $i < $numargs; $i++) {
        echo var_dump($arg_list[$i]);
    }
    echo '</pre>';
    exit(0);
}

//***** Request *****//
function request($name, $default = null){

    if(isset($_REQUEST[$name])) {
        return $_REQUEST[$name];
    }

    return $default;
}

//***** Pagination *****//
function queryString($params = []){
    $query = [];
    foreach ($params as $key => $value) {
        if($value){
            $query[] = $key.'='.$value;
        }
    }

    return '?'.implode('&', $query);
}