<?php

/**
 * Get all tab
 *
 * @param $args array
 *
 * @return array
 */
function learndash_zaddcustomtabs_get_all_tab( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'     => 10,
        'offset'     => 0,
        'orderby'    => 'id',
        'order'      => 'ASC',
    );

    $args      = wp_parse_args( $args, $defaults );
    $cache_key = 'learndash_zaddcustomtabs-cache-default';
    $items     = wp_cache_get( $cache_key, 'zulqar.net' );

    $search = "";
    if ( isset( $_REQUEST['_wpnonce'] ) && !empty( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( $_REQUEST['_wpnonce'], 'zulqar-net-lmsct' ) ) {
        if ( isset($_POST['s']) ) {
            $search = esc_attr( $_POST['s'] );
        }
    } elseif ( isset( $_REQUEST['_wpnonce'] ) )  {
        die( esc_attr( 'Security check', 'zulqar.net' ) );
    }

    // phpcs:disable
    if ( !empty($search) ) {
        // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
        $query = $wpdb->prepare(
            "SELECT * FROM `{$wpdb->prefix}learndash_zaddcustomtabs` WHERE (`title` LIKE %s OR `content` LIKE %s) ORDER BY ".sanitize_text_field($args['orderby'])." ".sanitize_text_field(strtoupper($args['order']))." LIMIT %d, %d",
            '%' . $wpdb->esc_like($search) . '%',
            '%' . $wpdb->esc_like($search) . '%',
            intval($args['offset']),
            intval($args['number'])
        );
        //if ( false === $items ) {
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery
            // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
            $items = $wpdb->get_results($query);
            wp_cache_set( $cache_key, $items, 'zulqar.net' );
        //}
    } else {
        $query = $wpdb->prepare(
            "SELECT * FROM `{$wpdb->prefix}learndash_zaddcustomtabs` ORDER BY ".sanitize_text_field($args['orderby'])." ".sanitize_text_field(strtoupper($args['order']))." LIMIT %d, %d",
            intval($args['offset']),
            intval($args['number'])
        );
        //if ( false === $items ) {
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery
            // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
            $items = $wpdb->get_results($query);
            wp_cache_set( $cache_key, $items, 'zulqar.net' );
        //}
        // phpcs:enable
    }

    return $items;
}


/**
 * Fetch all tab from database
 *
 * @return array
 */
function learndash_zaddcustomtabs_get_tab_count() {
    global $wpdb;

    // phpcs:ignore WordPress.DB.DirectDatabaseQuery
    return (int) $wpdb->get_var( 'SELECT COUNT(*) FROM `' . $wpdb->prefix . 'learndash_zaddcustomtabs`' );
}

/**
 * Fetch a single tab from database
 *
 * @param int   $id
 *
 * @return array
 */
function learndash_zaddcustomtabs_get_tab( $id = 0 ) {
    global $wpdb;

    // phpcs:ignore WordPress.DB.DirectDatabaseQuery
    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM `' . $wpdb->prefix . 'learndash_zaddcustomtabs` WHERE id = %d', $id ) );
}

/**
 * Insert a new tab
 *
 * @param array $args
 */
function learndash_zaddcustomtabs_insert_tab( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'id'         => null,
        'title' => '',
        'content' => '',
        'icon_name' => '',
        'status' => '',

    );

    $args       = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . 'learndash_zaddcustomtabs';

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
