<?php
/*
Plugin Name: LearnDash LMS - Add Custom Tabs
Description: This plugin adds custom tabs to LearnDash for courses/lessons/topics/quizzes and groups.
Version: 1.0
Author: zulqar.net@gmail.com
*/

if ( !defined( 'ABSPATH' ) ) exit;

include dirname(__FILE__) . '/model/db.php';
register_activation_hook( __FILE__, "activate_myplugin" );
register_deactivation_hook( __FILE__, "deactivate_myplugin" );

add_action("init", function() {
    include dirname(__FILE__) . '/controller/menu.php';
    include dirname(__FILE__) . '/controller/main.php';
    include dirname(__FILE__) . '/model/functions.php';
    include dirname(__FILE__) . '/model/form-handler.php';
    new zulqarDOTnet_LMSCT_Admin_Menu();
});
?>