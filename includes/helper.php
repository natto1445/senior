<?php 

/*
	 ถ้า Appserv ให้ไปเปิดไฟล PHP.ini
	 เปิดการใช้งาน PDO ก่อน ดังนี้
	 extension=php_pdo.dll
	 extension=php_pdo_mssql.dll
	extension=php_pdo_mysql.dll
	จากนั้น Restart Apace +mysql ///
*/

class DB{
	
	public $host = 'localhost';
	public $database = 'seniorproject';
    public $username = 'root';
    public $password = '12345678';

	public $pdo;

	public $selectdb;
	public $db;
	public $sql;
	public $table;
	public $where;
	public $data_query;

    function __construct() {
        $this->connect();
    }

	function connect(){
    	$this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->database.';charset=utf8', $this->username, $this->password);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$this->pdo->exec("set names utf8");

        if($this->pdo) return true;
        else return false;
	}

	 // ปิดการทำงาน MYSQL //
	function closedb( ){
		$this->pdo =null;
	}

	// เพิ่มข้อมูล ///
	function add_db($table="table", $data="data"){
		$key = array_keys($data);
        $value = array_values($data);
		$sumdata = count($key);
		for ($i=0;$i<$sumdata;$i++)
        {
            if (empty($add)){
                $add="(";
            }else{
                $add=$add.",";
            }
            if (empty($val)){
                $val="(";
            }else{
                $val=$val.",";
            }
            $add=$add.$key[$i];
            $val=$val."\"".$value[$i]."\"";
        }
        $add=$add.")";
        $val=$val.")";

        $sql="INSERT INTO ".$table." ".$add." VALUES ".$val;
        $this->data_query = $this->connect_db->prepare($sql);
		$this->data_query->execute();

       // echo $sql;
        if ($this->data_query){
            return true;
        }else{
            $this->_error();
            return false;
        }
	}

	// อัพเดตข้อมูล ///
    function update_db($table="table",$data="data",$where="where"){
        $key = array_keys($data);
        $value = array_values($data);
        $sumdata = count($key);
        $set="";
        for ($i=0;$i<$sumdata;$i++)
        {
            if (!empty($set)){
                $set=$set.",";
            }
            $set=$set.$key[$i]."=\"".$value[$i]."\"";
        }
        $sql="UPDATE ".$table." SET ".$set." WHERE ".$where;

       // $this->data_query = $this->connect_db->exec($sql);
		 $this->data_query = $this->connect_db->prepare($sql);
		$this->data_query->execute();

        if ($this->data_query){
            return true;
        }else{
            $this->_error();
            return false;
        }
    }

	// ลบข้อมูล //
    function del($table="table",$where="where"){
        $sql="DELETE FROM ".$table." WHERE ".$where;

      //  $this->data_query = $this->connect_db->exec($sql);

		$this->data_query = $this->connect_db->prepare($sql);
		$this->data_query->execute();

        if ($this->data_query){
            return true;
        }else{
            $this->_error();
            return false;
        }
    }

	function query_manual($sql){
		$this->data_query = $this->connect_db->prepare($sql);
		$this->data_query->execute();

        if ($this->data_query){
            return true;
        }else{
            $this->_error();
            return false;
        }

	}

  	// หาจำนวนแถว //
    function num_rows($table="table",$field="field",$where="where") {
        if ($where=="") {
            $where = "";
        } else {
            $where = " WHERE ".$where;
        }
         $sql = "SELECT ".$field." FROM ".$table.$where;
     	// $this->data_query = $this->connect_db->query($sql);

		 $this->data_query = $this->connect_db->prepare($sql);
		$this->data_query->execute();

        if($this->data_query){
            return $this->data_query->rowCount();
        }else{
            $this->_error();
            return false;
        }
    }

	// เลือกจำนวนข้อมูลมาแสดง //
    function select_query($sql="sql"){
       	//  $this->data_query = $this->connect_db->query($sql);
		$this->data_query = $this->connect_db->prepare($sql);
		$this->data_query->execute();

        if ($this->data_query){
            return $this->data_query;
        }else{
            $this->_error();
            return false;
        }
    }

	// เลือกจำนวนข้อมูลมาแสดงทั้งหมดคำสั่งเดียว  คืนค่าเป็น Array //
	function select_query_All($sql="sql"){
       	//  $this->data_query = $this->connect_db->query($sql);
		$this->data_query = $this->connect_db->prepare($sql);
		$this->data_query->execute();

		$fetch = $this->data_query->fetchAll(PDO::FETCH_ASSOC);
        return $fetch;
    }

    public function query($sql){
        $this->data_query = $this->pdo->prepare($sql);
        return $this;
    }

    public function get(){

        $this->data_query->execute();
        $fetch = $this->data_query->fetchAll(PDO::FETCH_ASSOC);

        $lists = [];

        foreach ($fetch as $key => $row){
            $lists[] = (object) $row;
        }

        return $lists;
    }

    public function count(){

        $this->data_query->execute();
        $fetch = $this->data_query->fetchAll(PDO::FETCH_ASSOC);
        return (int) $fetch[0]['aggregate'];
    }

    public function paginate($perPage = 10){

        // $this->total = $this->query("SELECT count(*) as aggregate FROM tbcontract JOIN tbcustomer ON tbcontract.cusCard = tbcustomer.cusCard JOIN tbtaxi ON tbcontract.carID = tbtaxi.carID JOIN tbuser ON tbuser.usrID = tbcontract.usrID")->get()[0]->aggregate;

        // $this->perPage = $perPage;

        // $this->lastPage = max((int) ceil($total / $perPage), 1);
        // /*
        // $this->path = $this->path !== '/' ? rtrim($this->path, '/') : $this->path;
        // */
        // $this->currentPage = $this->setCurrentPage($currentPage, $this->pageName);
        // $this->items = $items instanceof Collection ? $items : Collection::make($items);
    }

	// หาจำนวนจาก SQL  //
    function rows($sql="sql"){
        // $this->data_query = $this->connect_db->exec($sql);
      if ($res = $sql->rowCount()){
            return $res;
        }else{
        //  echo   $this->_error();
            return false;
        }
    }

	// ดึงค่ามาแสดงทีละแถว ////
    function fetch($sql="sql"){

        $results =  $sql->fetch(PDO::FETCH_ASSOC);

        if($results){
            return $results;
        }else{
           // $this->_error();
            return false;
        }
    }

	// แสดง Error ///
    function _error(){
      	echo ($this->connect_db->errorInfo());
    }

    function lastinsertId($filed="field",$table="table",$where=""){
        $sql = "SELECT ".$filed." FROM ".$table." ";
        if($where!=""){
                $sql .= " WHERE ".$where;
            }
            $sql .= " ORDER BY ".$filed." DESC LIMIT 1";
        $this->data_query = $this->connect_db->prepare($sql);
        $this->data_query->execute();
        $results =  $this->data_query->fetch(PDO::FETCH_ASSOC);
        return   $results[$filed];

    }

	function new_insert_id(){
		return $this->connect_db->lastInsertId();
	}

}

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

function request($name, $default = null){

    if(isset($_REQUEST[$name])) {
        return $_REQUEST[$name];
    }

    return $default;
}

function queryString($params = []){
    $query = [];
    foreach ($params as $key => $value) {
        if($value){
            $query[] = $key.'='.$value;
        }
    }

    return '?'.implode('&', $query);
}





