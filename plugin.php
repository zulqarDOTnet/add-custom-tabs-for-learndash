<?php
/*
 * Plugin Name:       Add Custom Tabs for LearnDash LMS
 * Plugin URI:        https://wordpress.org/plugins/add-custom-tabs-for-learndash
 * Description:       This plugin adds custom tabs to LearnDash for courses/lessons/topics/quizzes and groups.
 * Version:           1.0
 * Requires at least: 5.4
 * Requires PHP:      7.4
 * Author:            Zulqarnain Zafar
 * Author URI:        https://zulqar.net/
 * GitHub Plugin URI: https://github.com/zulqarDOTnet/add-custom-tabs-for-learndash
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       add-custom-tabs-for-learndash
 */

if ( !defined( 'ABSPATH' ) ) exit;

include dirname(__FILE__) . '/model/db.php';
register_activation_hook( __FILE__, "ZCTDLM_ACTIVATE" );
register_deactivation_hook( __FILE__, "ZCTDLM_DEACTIVATE" );

add_action("init", function() {
    include dirname(__FILE__) . '/controller/menu.php';
    include dirname(__FILE__) . '/controller/main.php';
    include dirname(__FILE__) . '/model/functions.php';
    include dirname(__FILE__) . '/model/form-handler.php';
    new ZCTDLM_Admin();
});
?>
