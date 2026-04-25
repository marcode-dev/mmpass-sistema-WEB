<?php

class Router {
    public static function run() {
        session_start();
        
        $url = $_GET['url'] ?? 'login';
        $url = rtrim($url, '/');

        // Mapeamento de rotas simples
        switch ($url) {
            case 'login':
                require_once 'controllers/AuthController.php';
                (new AuthController())->showLogin();
                break;
            
            case 'auth/login':
                require_once 'controllers/AuthController.php';
                (new AuthController())->login();
                break;

            case 'cadastro':
                require_once 'controllers/AuthController.php';
                (new AuthController())->showRegister();
                break;

            case 'auth/register':
                require_once 'controllers/AuthController.php';
                (new AuthController())->register();
                break;

            case 'logout':
                require_once 'controllers/AuthController.php';
                (new AuthController())->logout();
                break;

            case 'dashboard':
                require_once 'controllers/DashboardController.php';
                (new DashboardController())->index();
                break;

            case 'meus-eventos':
                require_once 'controllers/EventController.php';
                (new EventController())->list();
                break;

            case 'eventos/save':
                require_once 'controllers/EventController.php';
                (new EventController())->save();
                break;

            case 'eventos/detalhes':
                require_once 'controllers/EventController.php';
                (new EventController())->details();
                break;

            case 'eventos/delete':
                require_once 'controllers/EventController.php';
                (new EventController())->delete();
                break;

            case 'cupons':
                require_once 'controllers/CouponController.php';
                (new CouponController())->index();
                break;

            case 'cupons/save':
                require_once 'controllers/CouponController.php';
                (new CouponController())->save();
                break;

            case 'cupons/update':
                require_once 'controllers/CouponController.php';
                (new CouponController())->update();
                break;

            case 'cupons/delete':
                require_once 'controllers/CouponController.php';
                (new CouponController())->delete();
                break;

            default:
                header("HTTP/1.0 404 Not Found");
                echo "Página não encontrada!";
                break;
        }
    }
}
