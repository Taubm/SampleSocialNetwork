<?php
// Роутер
Class Router {

	private $registry;
	private $path;
	private $args = array();

	// Получаем хранилище
	function __construct($registry) {
		$this->registry = $registry;
	}

	// Задаем путь до папки с контроллерами
	function setPath($path) {
        $path = trim($path, '/\\');
        $path .= DS;
		// если путь не существует, сигнализируем об этом
        if (is_dir($path) == false) {
			throw new Exception ('Invalid controller path: `' . $path . '`');
        }
        $this->path = $path;
	}	
	
	// Определение контроллера и экшена из урла
	private function getController(&$file, &$controller, &$action, &$args) {
        $route = (empty($_GET['route'])) ? '' : $_GET['route'];
		unset($_GET['route']);
        if (empty($route)) {
			$route = 'index'; 
		}
		
        // Получаем части урла
        $route = trim($route, '/\\');
        $parts = explode('/', $route);

        // Находим контроллер
        $cmd_path = $this->path;
        foreach ($parts as $part) {
			$fullpath = $cmd_path . $part;

			// Проверка существования папки
			if (is_dir($fullpath)) {
				$cmd_path .= $part . DS;
				array_shift($parts);
				continue;
			}

			// Находим файл
			if (is_file($fullpath . '.php')) {
				$controller = $part;
				array_shift($parts);
				break;
			}
        }

		// Если в урле не указан контроллер, то используем по умолчанию index
        if (empty($controller)) {
			$controller = 'index'; 
		}

        // Получаем action
        $action = array_shift($parts);
        if (empty($action)) { 
			$action = 'index'; 
		}

        $file = $cmd_path . $controller . '.php';
        $args = $parts;
	}
	
	function start() {
		$error = new Error();

        // Анализируем путь
        $this->getController($file, $controller, $action, $args);
		
        // Проверка существования файла
        if (is_readable($file) == false) {
        	$error->show('Страница не найдена.');
        }
		
        // Подключаем файл
        include ($file);

        // Создаём экземпляр контроллера
        $class = 'Controller_' . $controller;
        $controller = new $class($this->registry);
		
        // Проверка существования action
        if (is_callable(array($controller, $action)) == false) {
        	$error->show('Страница не найдена.');
        }

        // Выполняем action
        $controller->$action();
	}

}
