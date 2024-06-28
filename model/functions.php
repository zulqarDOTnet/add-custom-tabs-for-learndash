<?php

if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Get all tab
 *
 * @param $args array
 *
 * @return array
 */
function zctdlm_get_all_tab( $args = array() ) {
    global $wp_version, $wpdb;

    $defaults = array(
        'number'     => 10,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'zctdlm-cache-default';
    $items     = wp_cache_get( $cache_key, 'zulqar.net' );

    $search = "";
    if ( isset( $_POST['_wpnonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['_wpnonce'] ) ) , 'zctdlm_nonce' ) ) {
        die( esc_attr( 'Security check', 'zulqar.net' ) );
    }

    if ( isset($_POST['s']) ) {
        $search = esc_html(sanitize_text_field($_POST['s']));
    }

    $ordered_by = sanitize_sql_orderby( $args['orderby'] . ' ' .  $args['order'] );

    if ( ! empty( $search ) ) {
        // phpcs:disable
        // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        // phpcs:ignore WordPress.DB.PreparedSQLPlaceholders.UnsupportedIdentifierPlaceholder
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery
        if ( version_compare( $wp_version, '6.2', '<' ) ) {
            $items = $wpdb->get_results( $wpdb->prepare(
                "SELECT * FROM `{$wpdb->prefix}zctdlm` WHERE (`title` LIKE %s OR `content` LIKE %s) ORDER BY {$ordered_by} LIMIT %d, %d",
                '%' . $wpdb->esc_like( $search ) . '%',
                '%' . $wpdb->esc_like( $search ) . '%',
                //$ordered_by,
                intval( $args['offset'] ),
                intval( $args['number'] )
            ) );
        } else {
            $items = $wpdb->get_results( $wpdb->prepare(
                "SELECT * FROM %i WHERE (%i LIKE %s OR %i LIKE %s) ORDER BY {$ordered_by} LIMIT %d, %d",
                "{$wpdb->prefix}zctdlm",
                "title",
                '%' . $wpdb->esc_like( $search ) . '%',
                "content",
                '%' . $wpdb->esc_like( $search ) . '%',
                //$ordered_by,
                intval( $args['offset'] ),
                intval( $args['number'] )
            ) );
        }
    } else {
        if ( version_compare( $wp_version, '6.2', '<' ) ) {
            $items = $wpdb->get_results( $wpdb->prepare(
                "SELECT * FROM `{$wpdb->prefix}zctdlm` ORDER BY {$ordered_by} LIMIT %d, %d",
                //$ordered_by,
                intval( $args['offset'] ),
                intval( $args['number'] )
            ) );
        } else {
            $items = $wpdb->get_results( $wpdb->prepare(
                "SELECT * FROM %i ORDER BY {$ordered_by} LIMIT %d, %d",
                "{$wpdb->prefix}zctdlm",
                //$ordered_by,
                intval( $args['offset'] ),
                intval( $args['number'] )
            ) );
        }
        // phpcs:enable
    }

    wp_cache_set( $cache_key, $items, 'zulqar.net' );

    return $items;
}

/**
 * Fetch all tab from database
 *
 * @return array
 */
function zctdlm_get_tab_count() {
    global $wpdb;

    // phpcs:ignore WordPress.DB.DirectDatabaseQuery
    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM `' . $wpdb->prefix . 'zctdlm`' );
}

/**
 * Fetch a single tab from database
 *
 * @param int   $id
 *
 * @return array
 */
function zctdlm_get_tab( $id = 0 ) {
    global $wpdb;

    // phpcs:ignore WordPress.DB.DirectDatabaseQuery
    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM `' . $wpdb->prefix . 'zctdlm` WHERE id = %d', $id ) );
}

/**
 * Insert a new tab
 *
 * @param array $args
 */
function zctdlm_insert_tab( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'id'         => null,
        'title' => '',
        'content' => '',
        'icon_name' => '',
        'status' => '',

    );

    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . 'zctdlm';

    // some basic validation
    if ( empty( $args['title'] ) ) {
        return new WP_Error( 'no-title', __( 'No Title provided.', 'zulqar.net' ) );
    }

    // remove row id to determine if new or update
    $row_id = (int) $args['id'];
    unset( $args['id'] );

    if ( ! $row_id ) {
        $args['date'] = current_time( 'mysql' );
        // insert a new
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery
        if ( $wpdb->insert( $table_name, $args ) ) {
            return $wpdb->insert_id;
        }
    } else {
        // do update method here
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery
        if ( $wpdb->update( $table_name, $args, array( 'id' => $row_id ) ) ) {
            return $row_id;
        }
    }

    return false;
}
