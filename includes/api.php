<?php
function register_bot_status_endpoint() {
    register_rest_route('bot/v1', '/status', array(
        'methods' => 'GET',
        'callback' => 'get_all_bot_status',
    ));

    register_rest_route('bot/v1', '/status/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_individual_bot_status',
    ));
}

function get_all_bot_status() {
    $posts = get_posts(array(
        'post_type' => 'bot_status',
        'numberposts' => -1, // Obtener todas las entradas
    ));

    $data = array();
    foreach ($posts as $post) {
        $status = get_post_meta($post->ID, '_bot_status', true);
        $use_schedule = get_post_meta($post->ID, '_bot_use_schedule', true);
        $start_time = get_post_meta($post->ID, '_bot_start_time', true);
        $end_time = get_post_meta($post->ID, '_bot_end_time', true);

        $current_time = current_time('H:i');
        $is_active = ($use_schedule === '1') ? ($current_time >= $start_time && $current_time <= $end_time) : ($status === '1');

        $data[] = array(
            'id' => $post->ID,
            'title' => $post->post_title,
            'status' => $is_active,
        );
    }

    return rest_ensure_response($data);
}

function get_individual_bot_status($data) {
    $post_id = $data['id'];
    $status = get_post_meta($post_id, '_bot_status', true);
    $use_schedule = get_post_meta($post_id, '_bot_use_schedule', true);
    $start_time = get_post_meta($post_id, '_bot_start_time', true);
    $end_time = get_post_meta($post_id, '_bot_end_time', true);

    $current_time = current_time('H:i');
    $is_active = ($use_schedule === '1') ? ($current_time >= $start_time && $current_time <= $end_time) : ($status === '1');

    return rest_ensure_response($is_active);
}

add_action('rest_api_init', 'register_bot_status_endpoint');
?>
