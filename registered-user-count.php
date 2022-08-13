<?php
function custom_admin_bar_menu_new_user_count() {
    
    $user_query = new WP_User_Query( array(
        'fields'    => 'ID',
    ) );
    $users = $user_query->get_results();

    foreach( $users as $user ) {
        $user_object = get_userdata( $user );
        $cutoffdate = date('Y-m-d H:i:s', strtotime('-5 minute'));
        if( $user_object->user_registered > $cutoffdate ) {
            $items[] = $user_object->display_name;
            $rr = count($items);
        }
    }

    if ( current_user_can( 'manage_options' ) ) {
        global $wp_admin_bar;

        $wp_admin_bar->add_menu( array(
            'id'    => 'new-user-count', 
            'title' => '<span class="ab-icon dashicons dashicons-admin-users"></span><span class="update-plugins" style="background: red;padding: 0 7px;border-radius: 50%;">' . $rr . '</span>',
            'href'  => get_admin_url( NULL, 'users.php' ),
        ) );

    }
}
add_action( 'admin_bar_menu', 'custom_admin_bar_menu_new_user_count' , 500 );
