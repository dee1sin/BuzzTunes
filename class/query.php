<?php

// add @ after website is complete
require_once "common.php";

class QUERY extends common {

    public static $connect;

    function __construct() {
        parent::__construct();
        QUERY::$connect = common::$con;
    }

    static function query($query) {
        $_temp = mysqli_query(QUERY::$connect, $query);
        QUERY::report($query);
        return $_temp;
    }

    static function report($query) {
        if (QUERY::error() != "") {
            $_get = http_build_query($_GET);
            $_post = http_build_query($_POST);
            QUERY::query("insert into log_query_error(query,error,page,seen,time,get_params,post_params) values('{$query}','" . QUERY::error() . "','" . $_SERVER['REQUEST_URI'] . "',0," . time() . ",'".$_get."','".$_post."')");
        }
    }

    static function c($query) {
        $result = QUERY::query($query);
        QUERY::report($query);
        $res = mysqli_fetch_array($result);
        return $res[0];
    }

    static function QA($query) {
        $_temp = mysqli_fetch_array(mysqli_query(QUERY::$connect, $query));
        QUERY::report($query);
        return $_temp;
    }

    static function insert($query) {
        $_temp = mysqli_query(QUERY::$connect, $query);
        QUERY::report($query);
        return  $_temp;
    }

    static function update($query) {
        $_temp = mysqli_query(QUERY::$connect, $query);
        QUERY::report($query);
        return  $_temp;
    }

    static function delete($query) {
        $_temp = mysqli_query(QUERY::$connect, $query);
        QUERY::report($query);
        return  $_temp;
    }

    static function select($query) {
        $_temp = mysqli_query(QUERY::$connect, $query);
        QUERY::report($query);
        return  $_temp;
    }

    static function error() {
        return mysqli_error(QUERY::$connect);
    }

}

$QUERY = new QUERY();
?>
