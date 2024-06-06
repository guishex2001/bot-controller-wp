<?php
/*
Plugin Name: Bot Controller
Description: Controla el estado de un bot de WhatsApp desde WordPress.
Version: 1.0
Author: Tu Nombre
*/

// Función para activar el plugin
function activar_plugin() {
    // Aquí puedes realizar cualquier configuración necesaria al activar el plugin
}

// Función para desactivar el plugin
function desactivar_plugin() {
    // Aquí puedes realizar cualquier limpieza necesaria al desactivar el plugin
}

// Función para borrar el plugin
function borrar_plugin() {
    // Aquí puedes realizar cualquier limpieza necesaria al borrar el plugin
}

// Registrando los hooks de activación, desactivación y desinstalación del plugin
register_activation_hook(__FILE__, 'activar_plugin');
register_deactivation_hook(__FILE__, 'desactivar_plugin');
register_uninstall_hook(__FILE__, 'borrar_plugin');

// Incluir archivos necesarios
require_once plugin_dir_path(__FILE__) . 'includes/cpt.php';
require_once plugin_dir_path(__FILE__) . 'includes/api.php';

// Agregar el menú de administración
add_action('admin_menu', 'crear_menu_bot_controller');

function crear_menu_bot_controller() {
    add_menu_page(
        'Bot Controller',
        'Bot Controller',
        'manage_options',
        'bot_controller_menu',
        'mostrar_contenido_bot_controller',
        'dashicons-admin-generic',
        2
    );

    add_submenu_page(
        'bot_controller_menu',
        'Bot Status',
        'Bot Status',
        'manage_options',
        'edit.php?post_type=bot_status'
    );
}

// Función para mostrar el contenido de la página del menú
function mostrar_contenido_bot_controller() {
    ?>
    <div class="bot-controller-settings">
        <h1>Configuración del Bot Controller</h1>
        <p>Desde aquí puedes configurar el estado del bot de WhatsApp.</p>
    </div>
    <?php
}
?>
