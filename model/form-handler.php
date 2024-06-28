<?php

if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class ZCTDLM_Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'handle_form' ) );
    }

    /**
     * Handle the tab new and edit form
     *
     * @return void
     */
    public function handle_form() {
        if ( ! isset( $_POST['Sbumit'] ) ) {
            return;
        }

        if ( isset( $_POST['_wpnonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash ( $_POST['_wpnonce'] ) ) , 'zctdlm_nonce' ) ) {
            die( esc_attr( 'Security check', 'zulqar.net' ) );
        }

        if ( ! current_user_can( 'read' ) ) {
            wp_die( esc_attr( 'Permission Denied!', 'zulqar.net' ) );
        }

        $errors   = array();
        $page_url = admin_url( 'admin.php?page=zctdlm' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        $title = isset( $_POST['title'] ) ? sanitize_text_field( $_POST['title'] ) : '';
        $content = isset( $_POST['content'] ) ? wp_kses_post( $_POST['content'] ) : '';
        $icon_name = isset( $_POST['icon_name'] ) ? sanitize_text_field( $_POST['icon_name'] ) : '';
        $courses = isset( $_POST['courses'] ) ? sanitize_text_field( $_POST['courses'] ) : '';
        $lessons = isset( $_POST['lessons'] ) ? sanitize_text_field( $_POST['lessons'] ) : '';
        $topics = isset( $_POST['topics'] ) ? sanitize_text_field( $_POST['topics'] ) : '';
        $quizzes = isset( $_POST['quizzes'] ) ? sanitize_text_field( $_POST['quizzes'] ) : '';
        $groups = isset( $_POST['groups'] ) ? sanitize_text_field( $_POST['groups'] ) : '';
        $status = isset( $_POST['status'] ) ? sanitize_text_field( $_POST['status'] ) : '';

        // some basic validation
        if ( ! $title ) {
            $errors[] = esc_attr( 'Error: Title is required', 'zulqar.net' );
        }

        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => $first_error ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = array(
            'title' => $title,
            'content' => $content,
            'icon_name' => $icon_name,
            'courses' => $courses,
            'lessons' => $lessons,
            'topics' => $topics,
            'quizzes' => $quizzes,
            'groups' => $groups,
            'status' => $status,
        );

        // New or edit?
        if ( ! $field_id ) {

            $insert_id = zctdlm_insert_tab( $fields );

        } else {

            $fields['id'] = $field_id;

            $insert_id = zctdlm_insert_tab( $fields );
        }

        if ( is_wp_error( $insert_id ) ) {
            $redirect_to = add_query_arg( array( 'message' => 'error' ), $page_url );
        } else {
            $redirect_to = add_query_arg( array( 'message' => 'success' ), $page_url );
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }
}

new ZCTDLM_Form_Handler();
