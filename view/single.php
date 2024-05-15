<div class="wrap">
    <h1><?php esc_attr_e( 'LearnDash LMS - Add Custom Tabs', 'zulqar.net' ); ?></h1>

    <?php $item = learndash_zaddcustomtabs_get_tab( $id ); ?>

        <table class="form-table">
            <tbody>
                <tr class="row-title">
                    <th scope="row">
                        <label for="title"><?php esc_attr_e( 'Title', 'zulqar.net' ); ?></label>
                    </th>
                    <td>
                        <?php echo esc_attr( $item->title ); ?>
                    </td>
                </tr>
                <tr class="row-content">
                    <th scope="row">
                        <label for="content"><?php esc_attr_e( 'Content', 'zulqar.net' ); ?></label>
                    </th>
                    <td>
                        <?php echo esc_textarea( $item->content ); ?>
                    </td>
                </tr>
                <tr class="row-icon-name">
                    <th scope="row">
                        <label for="icon_name"><?php esc_attr_e( 'Icon', 'zulqar.net' ); ?></label>
                    </th>
                    <td>
                        <?php echo esc_attr( $item->icon_name ); ?>
                    </td>
                </tr>
                <tr class="row-courses">
                    <th scope="row">
                        <?php esc_attr_e( 'Display on courses?', 'zulqar.net' ); ?>
                    </th>
                    <td>
                        <?php echo esc_attr( $item->courses ? "Yes" : 'No' ); ?>
                    </td>
                </tr>
                <tr class="row-lessons">
                    <th scope="row">
                        <?php esc_attr_e( 'Display on lessons?', 'zulqar.net' ); ?>
                    </th>
                    <td>
                        <?php echo esc_attr( $item->lessons ? "Yes" : 'No' ); ?>
                    </td>
                </tr>
                <tr class="row-topics">
                    <th scope="row">
                        <?php esc_attr_e( 'Display on topics?', 'zulqar.net' ); ?>
                    </th>
                    <td>
                        <?php echo esc_attr( $item->topics ? "Yes" : 'No' ); ?>
                    </td>
                </tr>
                <tr class="row-quizzes">
                    <th scope="row">
                        <?php esc_attr_e( 'Display on quizzes?', 'zulqar.net' ); ?>
                    </th>
                    <td>
                        <?php echo esc_attr( $item->quizzes ? "Yes" : 'No' ); ?>
                    </td>
                </tr>
                <tr class="row-groups">
                    <th scope="row">
                        <?php esc_attr_e( 'Display on groups?', 'zulqar.net' ); ?>
                    </th>
                    <td>
                        <?php echo esc_attr( $item->groups ? "Yes" : 'No' ); ?>
                    </td>
                </tr>
                <tr class="row-status">
                    <th scope="row">
                        <?php esc_attr_e( 'Status', 'zulqar.net' ); ?>
                    </th>
                    <td>
                        <?php echo esc_attr( $item->status ? "Enabled" : 'Disabled' ); ?>
                    </td>
                </tr>
             </tbody>
        </table>
</div>
