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

function dateFormat($date){
    $date = explode('-', $date);
    return @$date[2].'/'.@$date[1].'/'.@$date[0];
}

function displaySearch($search, $dateStart, $dateEnd){

    if($search == '' and $dateStart == '' and $dateEnd == ''){
        return '';
    }

    $show = 'ค้นหาจาก - ';

    if($search){
        $show = "ค้นหาจาก '$search' ";
    }

    if($dateStart and $dateEnd){
        $show .= "ช่วงวันที่ ".dateFormat($dateStart)." - ".dateFormat($dateEnd);
    } else if ($dateStart){
        $show .= "ตั้งแต่วันที่ ".dateFormat($dateStart);
    } else if ($dateEnd){
        $show .= "ถึงวันที่ ".dateFormat($dateEnd);
    }

    return $show;
}