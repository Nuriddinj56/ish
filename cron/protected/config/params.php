<?php
return [
    /**
     * Apps timezone. List of supported timezones: http://php.net/manual/en/timezones.php
     */
    'timezone'=>'Europe/Vilnius',
	
    /**
     * Number of predictions
     */
    'schedulePrediction'=>200,
	
    /**
     * Ajax preload (create/edit)
     */
    'ajaxPrediction'=>20,
	
    /**
     * Cron Job response length in email
     */
    'kbEmailOutput'=>5,
	
    /**
     * Long name of App
     */
    'longAppName'=>'Web Cronjobs',
    
	/**
     *  Short name of App
     */
    'shortAppName'=>'<i class="fa fa-clock-o"></i>',
	
    /**
     * Cookie path
     * If you installed script in subdir. for example: http://my-domain.com/webcron, then the cookiePath must be: /webcron
     * If you installed script in web root. for example: http://my-domain.com, then the cookiePath must be: /
     */
    'cookiePath'=>'/',

    /**
     * The "from" email which is used in email notification
     */
    "notificationFrom"=>"no-reply@example.com",

    /**
     * Base URL of the App. Used for console program
     * If you installed script in subdirectory, then the URL must be in a following format: http://my-domain.com/sub-dir
     * If you installed script in web root, then the URL must be in a following format: http://my-domain.com
     */
    "baseUrl"=>'http://example.com',

    /**
     * List of supported languages
     */
    'languages'=>[
        'en-US'=>'English',
        'ru-RU'=>'Русский',
    ],

    /**
     * Secret key used for cookies encoding
     */
	'cookieValidationKey'=>'TXntdwyZRXYBNV05PZK6cfw1f8cp1vpv',

    /**
     * The key to run cron jobs handler via web (http(s))
     */
    'webHandlerKey'=>'',

    /**
     * cURL default options
     */
    'curl'=>require 'curl.php',
];
