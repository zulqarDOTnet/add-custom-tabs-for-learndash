<?php
function activate_myplugin() {
	init_db_myplugin();
}

function init_db_myplugin()
{
	global $wpdb;
	$pluginTable = $wpdb->prefix . 'learndash_zaddcustomtabs';

    // phpcs:disable
    // phpcs:ignore WordPress.DB.DirectDatabaseQuery
    // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
	if( $wpdb->get_var( "show tables like '$pluginTable'" ) != $pluginTable )
    {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS `$pluginTable` (";
        $sql .= " `id` BIGINT(20) NOT NULL AUTO_INCREMENT , ";
        $sql .= " `title` VARCHAR(255) NULL DEFAULT NULL , ";
        $sql .= " `content` TEXT NULL DEFAULT NULL , ";
        $sql .= " `icon_name` VARCHAR(255) NULL DEFAULT NULL , ";
        $sql .= " `courses` int(1) NOT NULL DEFAULT 1, ";
        $sql .= " `lessons` int(1) NOT NULL DEFAULT 1, ";
        $sql .= " `topics` int(1) NOT NULL DEFAULT 1, ";
        $sql .= " `quizzes` int(1) NOT NULL DEFAULT 1, ";
        $sql .= " `groups` int(1) NOT NULL DEFAULT 1, ";
        $sql .= " `status` int(1) NOT NULL DEFAULT 1, ";
        $sql .= " `date` TIMESTAMP NOT NULL , ";
        $sql .= " PRIMARY KEY (`id`)) $charset_collate;";

		require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
    // phpcs:enable
}

function deactivate_myplugin() {
	//
}
