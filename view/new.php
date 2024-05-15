<div class="wrap">
    <h1><?php esc_attr_e( 'LearnDash LMS - Add Custom Tabs', 'zulqar.net' ); ?></h1>

    <form action="" method="post">

        <table class="form-table">
            <tbody>
                <tr class="row-title">
                    <th scope="row">
                        <label for="title"><?php esc_attr_e( 'Title', 'zulqar.net' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="title" id="title" class="regular-text" placeholder="<?php echo esc_attr( '', '' ); ?>" value="" required="required" />
                    </td>
                </tr>
                <tr class="row-content">
                    <th scope="row">
                        <label for="content"><?php esc_attr_e( 'Content', 'zulqar.net' ); ?></label>
                    </th>
                    <td>
                        <?php
                            $content   = '';
                            $editor_id = 'content';
                            wp_editor( $content, $editor_id );
                        ?>
                    </td>
                </tr>
                <tr class="row-icon-name">
                    <th scope="row">
                        <label for="icon_name"><?php esc_attr_e( 'Icon', 'zulqar.net' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="icon_name" id="icon_name" class="regular-text" placeholder="<?php echo esc_attr( 'ld-icon-download', 'zulqar.net' ); ?>" value="<?php esc_attr_e( 'ld-icon-download', 'zulqar.net' ); ?>" required="required" />
                    </td>
                </tr>
                <tr class="row-courses">
                    <th scope="row">
                        <?php esc_attr_e( 'Display on courses?', 'zulqar.net' ); ?>
                    </th>
                    <td>
                        <label for="courses"><input type="checkbox" name="courses" id="courses" value="1" checked /> </label>
                    </td>
                </tr>
                <tr class="row-lessons">
                    <th scope="row">
                        <?php esc_attr_e( 'Display on lessons?', 'zulqar.net' ); ?>
                    </th>
                    <td>
                        <label for="lessons"><input type="checkbox" name="lessons" id="lessons" value="1" checked /> </label>
                    </td>
                </tr>
                <tr class="row-topics">
                    <th scope="row">
                        <?php esc_attr_e( 'Display on topics?', 'zulqar.net' ); ?>
                    </th>
                    <td>
                        <label for="topics"><input type="checkbox" name="topics" id="topics" value="1" checked /> </label>
                    </td>
                </tr>
                <tr class="row-quizzes">
                    <th scope="row">
                        <?php esc_attr_e( 'Display on quizzes?', 'zulqar.net' ); ?>
                    </th>
                    <td>
                        <label for="quizzes"><input type="checkbox" name="quizzes" id="quizzes" value="1" checked /> </label>
                    </td>
                </tr>
                <tr class="row-groups">
                    <th scope="row">
                        <?php esc_attr_e( 'Display on groups?', 'zulqar.net' ); ?>
                    </th>
                    <td>
                        <label for="groups"><input type="checkbox" name="groups" id="groups" value="1" checked /> </label>
                    </td>
                </tr>
                <tr class="row-status">
                    <th scope="row">
                        <?php esc_attr_e( 'Status', 'zulqar.net' ); ?>
                    </th>
                    <td>
                        <label for="status"><input type="checkbox" name="status" id="status" value="1" checked /> </label>
                    </td>
                </tr>
             </tbody>
        </table>

        <input type="hidden" name="field_id" value="0">

        <?php wp_nonce_field( 'zulqar-net-lmsct' ); ?>
        <?php submit_button( __( 'Add New Tab', 'zulqar.net' ), 'primary', 'Sbumit' ); ?>

    </form>
</div>
