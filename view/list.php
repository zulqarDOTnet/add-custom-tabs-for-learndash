<div class="wrap">
    <h2><?php esc_attr_e( 'LearnDash LMS - Add Custom Tabs', 'zulqar.net' ); ?> <a href="<?php echo esc_url( admin_url('admin.php?page=zulqardotnet-lms-ct&action=new') ); ?>" class="page-title-action"><?php esc_attr_e( 'Add New', 'zulqar.net' ); ?></a></h2>

    <form method="post">
    <input type="hidden" name="page" value="zulqardotnet-lms-ct">
    <?php
        $list_table = new zulqarDOTnet_LMS_Custom_Tabs();
        $list_table->prepare_items();
        $list_table->search_box( 'search', 'search_id' );
        $list_table->display();
    ?>
    <?php wp_nonce_field( 'zulqar-net-lmsct' ); ?>
</form>
</div>
