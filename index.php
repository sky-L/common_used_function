<?php
/**
 * Created by PhpStorm.
 * User: skylee
 * Date: 16/1/27
 * Time: 下午4:11
 */

use skylee\H;

require_once 'vendor/autoload.php';



$obj = H::short_url("http://www.xxx.com");



var_dump($obj);