<?php
/**
 * FRONT CONTROLLER - MMPass
 * Ponto de entrada único do sistema seguindo o padrão POO MVC.
 */

require_once __DIR__ . '/core/Router.php';

// Inicia o roteamento
Router::run();
?>