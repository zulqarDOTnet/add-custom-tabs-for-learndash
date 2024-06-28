<?php

if ( !defined( 'ABSPATH' ) ) exit;

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
    require_once(ABSPATH . 'wp-admin/includes/screen.php');
    require_once(ABSPATH . 'wp-admin/includes/class-wp-screen.php');
    require_once(ABSPATH . 'wp-admin/includes/template.php');
}

/**
 * List table class
 */
class ZCTDLM_Table extends \WP_List_Table {

    function __construct() {
        parent::__construct( array(
            'singular' => 'tab',
            'plural'   => 'tabs',
            'ajax'     => false
        ) );
    }

    function get_table_classes() {
        return array( 'widefat', 'fixed', 'striped', $this->_args['plural'] );
    }

    /**
     * Message to show if no designation found
     *
     * @return void
     */
    function no_items() {
        esc_attr_e( 'You don\'t have any LearnDash LMS, Custom Tab yet.', 'zulqar.net' );
    }

    /**
     * Default column values if no callback found
     *
     * @param  object  $item
     * @param  string  $column_name
     *
     * @return string
     */
    function column_default( $item, $column_name )
    {
        switch ( $column_name ) {
            case 'title':
                return $item->title;
            case 'display':
                $display = $item->courses ? "Courses<br>" : "";
                $display .= $item->lessons ? "Lessons<br>" : "";
                $display .= $item->topics ? "Topics<br>" : "";
                $display .= $item->quizzes ? "Quizzes<br>" : "";
                $display .= $item->groups ? "Groups<br>" : "";
                return $display;
            case 'icon_name':
                return $item->icon_name;
            case 'status':
                return $item->status ? "Enabled" : 'Disabled';
            default:
                return isset( $item->$column_name ) ? $item->$column_name : '';
        }
    }

    /**
     * Get the column names
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            'cb'         => '<input type="checkbox" />',
            'title'      => __( 'Title', 'zulqar.net' ),
            'display'    => __( 'Display on?', 'zulqar.net' ),
            'icon_name'  => __( 'Icon', 'zulqar.net' ),
            'status'     => __( 'Status', 'zulqar.net' ),

        );
        return $columns;
    }

    /**
     * Render the designation name column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_title( $item ) {
        $actions           = array();
        $actions['edit']   = sprintf( '<a href="%s" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=zctdlm&action=edit&id=' . $item->id . '&_wpnonce='.wp_create_nonce( 'zctdlm_nonce' ) ), $item->id, __( 'Edit this item', 'zulqar.net' ), __( 'Edit', 'zulqar.net' ) );
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=zctdlm&action=delete&id=' . $item->id . '&_wpnonce='.wp_create_nonce( 'zctdlm_nonce' ) ), $item->id, __( 'Delete this item', 'zulqar.net' ), __( 'Delete', 'zulqar.net' ) );

        return sprintf( '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( 'admin.php?page=zctdlm&action=view&id=' . $item->id . '&_wpnonce='.wp_create_nonce( 'zctdlm_nonce' ) ), wp_unslash($item->title), $this->row_actions( $actions ) );
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'title' => array( 'Title', true )
        );

        return $sortable_columns;
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    function get_bulk_actions() {
        $actions = array(
            'trash'  => esc_attr( 'Delete', 'zulqar.net' ),
        );
        return $actions;
    }

    /**
     * Process the bulk actions
     *
     * @return array
     */
    function process_bulk_action() {
        if ( isset( $_POST['_wpnonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['_wpnonce'] ) ) , 'zctdlm_nonce' ) ) {
            die( esc_attr( 'Security check', 'zulqar.net' ) );
        }

        $action = $this->current_action();
        if( 'trash'===$action ) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'zctdlm';
            $delete_ids = is_array( $_POST['ids'] ) ? esc_sql($_POST['ids']) : [];
            foreach ( $delete_ids as $did ) {
                if( intval($did) > 0 ) {
                    // phpcs:disable
                    // phpcs:ignore WordPress.DB.DirectDatabaseQuery
                    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching
                    $wpdb->delete($table_name, array('id' => $did), array('%d'));
                    // phpcs:enable
                }
            }
            wp_redirect( esc_url( add_query_arg() ) );
            exit;
        }
    }

    /**
     * Render the checkbox column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="ids[]" value="%d" />', $item->id
        );
    }

    /**
     * Set the views
     *
     * @return array
     */
    public function get_views_() {
        $status_links   = array();
        $base_link      = admin_url( 'admin.php?page=sample-page' );

        foreach ($this->counts as $key => $value) {
            $class = ( $key == $this->page_status ) ? 'current' : 'status-' . $key;
            $status_links[ $key ] = sprintf( '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', add_query_arg( array( 'status' => $key ), $base_link ), $class, $value['label'], $value['count'] );
        }

        return $status_links;
    }

    /**
     * Prepare the class items
     *
     * @return void
     */
    function prepare_items()
    {
        if ( isset( $_POST['_wpnonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['_wpnonce'] ) ) , 'zctdlm_nonce' ) ) {
            die( esc_attr( 'Security check', 'zulqar.net' ) );
        }

        $columns               = $this->get_columns();
        $hidden                = array( );
        $sortable              = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $this->process_bulk_action();

        $per_page              = $this->get_items_per_page('users_per_page', 10);
        $current_page          = $this->get_pagenum();
        $offset                = ( $current_page -1 ) * $per_page;
        $this->page_status     = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '2';

        $args = array(
            'offset' => $offset,
            'number' => $per_page,
        );

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = sanitize_sql_orderby(strtolower(wp_unslash($_REQUEST['orderby'])));
            $args['order']   = sanitize_text_field(strtoupper(wp_unslash($_REQUEST['order'])));
        }

        $this->items  = zctdlm_get_all_tab( $args );

        $this->set_pagination_args( array(
            'total_items' => zctdlm_get_tab_count(),
            'per_page'    => $per_page
        ) );
    }
}

add_filter(
    'learndash_content_tabs',
    function($tabs = array(), $context = '', $course_id = 0, $user_id = 0) {
        $args = array(
            'offset' => 0,
            'number' => 999,
        );
        $items = zctdlm_get_all_tab( $args );
        if (is_array($items) && !empty($items)) {
            foreach ($items as $index => $tab) {
                if ( isset($tab->title) && isset($tab->content) && !isset($tabs[$tab->title]) && $tab->status == 1 ) {
                    $show = false;
                    if($context == 'course' && $tab->courses) {
                        $show = true;
                    }
                    if($context == 'lesson' && $tab->lessons) {
                        $show = true;
                    }
                    if($context == 'topic' && $tab->topics) {
                        $show = true;
                    }
                    if($context == 'quiz' && $tab->quizzes) {
                        $show = true;
                    }
                    if($context == 'group' && $tab->groups) {
                        $show = true;
                    }
                    if($show) {
                        $tabs[$tab->title] = array(
                            'id'      => $index,
                            'label'   => wp_unslash($tab->title),
                            'content' => wp_kses_post(wp_unslash($tab->content)),
                            'icon'    => $tab->icon_name
                        );
                    }
                }
            }
        }
        return $tabs;
    },
    30,
    4
);
