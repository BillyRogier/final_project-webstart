<?php

use App\Autoloader;
use Core\Autoloader as CoreAutoloader;
use Core\Config;
use Core\Database\Database;
use Core\Route\Route;

class App
{
    public $title;
    public $desc;
    private $db_instance;
    private $config;
    private static $_instance;
    private $controller;

    private function __construct()
    {
        $this->config = Config::getInstance(ROOT . '/config/config.php');
        $this->title = $this->config->get('app')['name'];
        define('URL', $this->config->get('app')['base_url']);
        define('BASE_PUBLIC', $this->config->get('app')['public_url']);
        define('UPLOAD_DIR', ROOT . $this->config->get('app')['upload_dir']);
    }

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new App();
        }
        return self::$_instance;
    }

    public static function load()
    {
        $sessionLifetime = 24 * 60 * 60; // 1 jour en secondes
        ini_set('session.cookie_lifetime', $sessionLifetime);
        ini_set('session.gc_maxlifetime', $sessionLifetime);
        session_start();
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = uniqid();
        }
        require ROOT . '/app/Autoloader.php';
        Autoloader::register();
        require ROOT . '/core/Autoloader.php';
        CoreAutoloader::register();
    }

    public function getDb()
    {
        $db = $this->config->get('db');
        if (is_null($this->db_instance)) {
            $this->db_instance = new Database($db['db_name'], $db['db_user'], $db['db_pass'], $db['db_host']);
        }
        return $this->db_instance;
    }

    public function getController($class)
    {
        $class_name = '\\App\\Controller\\' . $class;
        $this->controller = new $class_name();
        return $this->controller;
    }

    public function tryRoute(string $class, $path)
    {
        $ref = new ReflectionClass('\\App\\Controller\\' . $class);
        $path = $path[1];
        foreach ($ref->getMethods() as $method) {
            $methodsAttributes = $method->getAttributes(Route::class);
            $function = $method->getName();
            foreach ($methodsAttributes as $prop) {
                if (!empty($prop)) {
                    $instance = $prop->newInstance();
                    if ($instance->path === $path) {
                        $route = $this->getController($class)->$function();
                    } else if (str_contains($instance->path, "{")) {
                        $explode_path = explode("/", $path);
                        $instance_path = explode("/", $instance->path);
                        $arrayAgrts = [];
                        $i = 0;
                        if (count($explode_path) == count($instance_path)) {
                            foreach ($explode_path as $cle => $value) {
                                if ($instance_path[$cle] === $value) {
                                    continue;
                                } else if (str_contains($instance_path[$cle], "{")) {
                                    if ($method->getParameters()[$i]->getType() == "int") {
                                        if (!preg_match('/^[0-9]/', $value)) {
                                            return "404";
                                        }
                                    }
                                    array_push($arrayAgrts, $value);
                                    $i++;
                                } else {
                                    break;
                                }
                            }
                            if (count($method->getParameters()) == count($arrayAgrts)) {
                                if (!isset($route)) {
                                    if (empty($arrayAgrts[count($arrayAgrts) - 1])) {
                                        header("location:" . URL . substr($path, 0, -1));
                                    }
                                    $route = call_user_func_array(array($this->getController($class), $function), $arrayAgrts);
                                }
                            }
                        }
                    }
                }
            }
        }
        if (!isset($route) || empty($route)) {
            $route = "404";
        } else if (gettype($route) == "string") {
            $_SESSION['message'] = "";
            exit;
        }
        return $route;
    }

    public function xmlRequest($route)
    {
        foreach ($route->getRenderArray() as $cle => $value) {
            $$cle = $value;
        }

        if (!empty($route->getTemplates())) {
            $this->title .= " | " . $title;
            $this->desc .= isset($desc) || !empty($desc) ? $desc : "";

            ob_start();

            $app = $this;
            require_once ROOT . "/pages" . $route->getPath();

            $content = ob_get_clean();
            require_once ROOT  . "/pages/templates" . $route->getTemplates();
        } else {
            require_once ROOT . "/pages" . $route->getPath();
        }
    }

    public function getRoutes()
    {

        $d = ROOT . '/app/Controller';
        $controllers = [];
        foreach (scandir($d) as $file) {
            if (str_contains($file, ".php")) {
                array_push($controllers, str_ireplace(".php", "", $file));
            }
        }

        $parts = $_SERVER['PHP_SELF'];
        $path = explode("index.php", $parts);

        foreach ($controllers as $controller) {
            $route = $this->tryRoute($controller, $path);
            if ($route != "404") {
                return $route;
                break;
            }
        }

        if ($route == '404') {
            header("HTTP/1.0 404 Not Found");
            exit;
        }
    }

    public function getProperties($tableClass)
    {
        $ref = new ReflectionClass($tableClass);
        $array = [];
        foreach ($ref->getProperties() as $propertie) {
            $methodsAttributes = $propertie->getAttributes();
            foreach ($methodsAttributes as $atrb) {
                $array[$propertie->getName()] = $atrb->newInstance();
            }
        }
        return $array;
    }

    public function isAdmin()
    {
        if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
            return false;
        } else {
            return true;
        }
    }

    public function isUser()
    {
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            return false;
        } else {
            return true;
        }
    }
}
