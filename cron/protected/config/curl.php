<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 2015.11.13
 * Time: 23:28
 */
return [
    CURLOPT_SSL_VERIFYPEER=>false,
    CURLOPT_SSL_VERIFYHOST=>0,
    CURLOPT_USERAGENT=>"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36",
    CURLOPT_CONNECTTIMEOUT=>20, // The number of seconds to wait while trying to connect. Use 0 to wait indefinitely.
    CURLOPT_TIMEOUT=>600, // The maximum number of seconds to allow cURL functions to execute.
    CURLOPT_HEADER=>1,
    CURLOPT_FOLLOWLOCATION=>(ini_get('open_basedir') == '' && (ini_get('safe_mode') == 'Off' || ini_get('safe_mode')=='')) ? true : false,
];