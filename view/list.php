<?php if ( !defined( 'ABSPATH' ) ) exit; ?>

<div class="wrap">
    <h2><?php esc_attr_e( 'Add Custom Tabs for LearnDash LMS', 'zulqar.net' ); ?> <a href="<?php echo esc_url( admin_url('admin.php?page=zctdlm&action=new') ); ?>" class="page-title-action"><?php esc_attr_e( 'Add New', 'zulqar.net' ); ?></a></h2>

    <form method="post">
    <input type="hidden" name="page" value="zctdlm">
    <?php
        $list_table = new ZCTDLM_Table();
        $list_table->prepare_items();
        $list_table->search_box( 'search', 'search_id' );
        $list_table->display();
    ?>
    <?php wp_nonce_field( 'zctdlm_nonce' ); ?>
</form>
</div>
