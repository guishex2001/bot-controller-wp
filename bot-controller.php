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
        <h1>Bienvenido a Bot Controller</h1>
        <p>Este plugin te permite gestionar tus bots. Puedes configurar el estado del bot, horario de funcionamiento y conectarlo a través del API a tu chatbot.</p>
        <div class="bot-controller-info">
            <h2>Funciones del Plugin</h2>
            <ul>
                <li>Activar o desactivar el bot manualmente.</li>
                <li>Configurar el bot para que funcione en un horario específico.</li>
                <li>Gestionar el estado del bot a través de endpoints API REST.</li>
                <li>Endpoints 1: Listado de los bots "http://tusitio.ejemplo/wp-json/bot/v1/status/"</li>
                <li>Endpoints 2: Estado de un bot "http://tusitio.ejemplo/wp-json/bot/v1/status/{id}"</li>
                <li>Visualizar el estado del bot y su enlace QR desde el panel de administración.</li>
            </ul>           
        </div>
        <p>Desarrollado por guishex2001
            <a href="https://codecat.site/" target="_blank">Portafolio Web</a> | 
            <a href="https://github.com/guishex2001" target="_blank">GitHub</a> | 
            <a href="https://www.linkedin.com/in/guilledataanalytics2001/" target="_blank">LinkedIn</a>
        </p>
    </div>
    <style>
        .bot-controller-settings {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .bot-controller-settings h1 {
            font-size: 28px;
            margin-bottom: 20px;
            text-align: center;
        }

        .bot-controller-settings p {
            font-size: 16px;
            margin-bottom: 20px;
            text-align: center;
        }

        .bot-controller-info {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
        }

        .bot-controller-info h2 {
            font-size: 24px;
            margin-bottom: 10px;
            text-align: center;
        }

        .bot-controller-info ul {
            list-style-type: disc;
            padding-left: 20px;
        }

        .bot-controller-info ul li {
            font-size: 16px;
            margin-bottom: 10px;
        }
    </style>
    <?php
}
?>
