<?php
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Admin Menu
 */
class ZCTDLM_Admin {

    /**
     * Kick-in the class
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu()
    {
        // Check user capabilities
        if (!current_user_can('manage_options')) {
            return;
        }
        $hook = add_menu_page( __( 'LearnDash LMS - Add Custom Tabs', 'zulqar.net' ), __( 'LearnDash LMS - Add Custom Tabs', 'zulqar.net' ), 'manage_options', 'zctdlm', array( $this, 'plugin_page' ), 'dashicons-groups', 3 );
        add_action( "load-$hook", [ $this, 'screen_option' ] );
        add_submenu_page( 'zctdlm', __( 'LearnDash LMS - Add Custom Tabs', 'zulqar.net' ), __( 'LearnDash LMS - Add Custom Tabs', 'zulqar.net' ), 'manage_options', 'zctdlm', array( $this, 'plugin_page' ) );
    }

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function plugin_page()
    {
        if ( isset( $_POST['_wpnonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['_wpnonce'] ) ) , 'zctdlm_nonce' ) ) {
            die( esc_attr( 'Security check', 'zulqar.net' ) );
        }

        $action = isset( $_GET['action'] ) ? sanitize_text_field($_GET['action']) : 'list';
        $id     = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ($action) {
            case 'view':
                $template = dirname(dirname( __FILE__ )) . '/view/single.php';
                break;

            case 'edit':
                $template = dirname(dirname( __FILE__ )) . '/view/edit.php';
                break;

            case 'new':
                $template = dirname(dirname( __FILE__ )) . '/view/new.php';
                break;

            case 'delete':
                if($id > 0) {
                    global $wpdb;
                    $table_name = $wpdb->prefix . 'zctdlm';
                    // phpcs:disable
                    // phpcs:ignore WordPress.DB.DirectDatabaseQuery
                    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.NoCaching
                    $wpdb->delete($table_name, array('id' => $id), array('%d'));
                    // phpcs:enable
                }
                echo "<script>location.replace('admin.php?page=zctdlm');</script>";
                break;

            default:
                $template = dirname(dirname( __FILE__ )) . '/view/list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
     * Screen options
     */
    public static function set_screen( $status, $option, $value ) {
        return $value;
    }

    public function screen_option()
    {
        $option = 'per_page';
        $args   = [
            'label'   => 'Tabs per Page',
            'default' => 10,
            'option'  => 'users_per_page'
        ];
        add_screen_option( $option, $args );
    }
}
