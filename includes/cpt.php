<?php
function create_bot_status_cpt() {
    register_post_type('bot_status',
        array(
            'labels' => array(
                'name' => __('Bot Status'),
                'singular_name' => __('Bot Status')
            ),
            'public' => true,
            'has_archive' => false,
            'show_in_menu' => false, // Ocultar del menú principal
            'show_in_rest' => true,
            'supports' => array('title'),
            'capability_type' => 'post',
        )
    );
}
add_action('init', 'create_bot_status_cpt');

function add_bot_status_meta_boxes() {
    add_meta_box('bot_status_meta', 'Bot Settings', 'bot_status_meta_box_callback', 'bot_status', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_bot_status_meta_boxes');

function bot_status_meta_box_callback($post) {
    $status = get_post_meta($post->ID, '_bot_status', true);
    $use_schedule = get_post_meta($post->ID, '_bot_use_schedule', true);
    $start_time = get_post_meta($post->ID, '_bot_start_time', true);
    $end_time = get_post_meta($post->ID, '_bot_end_time', true);
    $qr_link = get_post_meta($post->ID, '_bot_qr_link', true);
    ?>
    <p>
        <label for="bot_status">¿Activar Bot?</label>
        <select name="bot_status" id="bot_status">
            <option value="1" <?php selected($status, '1'); ?>>Sí</option>
            <option value="0" <?php selected($status, '0'); ?>>No</option>
        </select>
    </p>
    <p>
        <label for="bot_use_schedule">¿Activar horario?</label>
        <select name="bot_use_schedule" id="bot_use_schedule">
            <option value="1" <?php selected($use_schedule, '1'); ?>>Sí</option>
            <option value="0" <?php selected($use_schedule, '0'); ?>>No</option>
        </select>
    </p>
    <?php if ($use_schedule == '1') : ?>
        <p>
            <label for="bot_start_time">Hora de inicio</label>
            <input type="time" name="bot_start_time" id="bot_start_time" value="<?php echo esc_attr($start_time); ?>">
        </p>
        <p>
            <label for="bot_end_time">Hora de fin</label>
            <input type="time" name="bot_end_time" id="bot_end_time" value="<?php echo esc_attr($end_time); ?>">
        </p>
    <?php endif; ?>
    <p>
        <label for="bot_qr_link">Enlace al QR</label>
        <input type="url" name="bot_qr_link" id="bot_qr_link" value="<?php echo esc_url($qr_link); ?>" style="width: 100%;">
    </p>
    <?php
}

function save_bot_status_meta($post_id) {
    if (array_key_exists('bot_status', $_POST)) {
        update_post_meta($post_id, '_bot_status', $_POST['bot_status']);
    }
    if (array_key_exists('bot_use_schedule', $_POST)) {
        update_post_meta($post_id, '_bot_use_schedule', $_POST['bot_use_schedule']);
    }
    if (array_key_exists('bot_start_time', $_POST)) {
        update_post_meta($post_id, '_bot_start_time', $_POST['bot_start_time']);
    }
    if (array_key_exists('bot_end_time', $_POST)) {
        update_post_meta($post_id, '_bot_end_time', $_POST['bot_end_time']);
    }
    if (array_key_exists('bot_qr_link', $_POST)) {
        update_post_meta($post_id, '_bot_qr_link', esc_url_raw($_POST['bot_qr_link']));
    }
}
add_action('save_post', 'save_bot_status_meta');

// Agregar columnas personalizadas a la vista de lista del CPT
function add_custom_columns($columns) {
    $columns['bot_status'] = __('Estado');
    $columns['bot_qr_link'] = __('Enlace QR');
    return $columns;
}
add_filter('manage_bot_status_posts_columns', 'add_custom_columns');

function custom_column_content($column, $post_id) {
    switch ($column) {
        case 'bot_status':
            $status = get_post_meta($post_id, '_bot_status', true);
            echo $status ? 'Activo' : 'Inactivo';
            break;
        case 'bot_qr_link':
            $qr_link = get_post_meta($post_id, '_bot_qr_link', true);
            echo $qr_link ? '<a href="' . esc_url($qr_link) . '" target="_blank">Ver QR</a>' : 'No disponible';
            break;
    }
}
add_action('manage_bot_status_posts_custom_column', 'custom_column_content', 10, 2);
?>
