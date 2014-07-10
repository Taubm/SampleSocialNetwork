<?php
// Включим отображение всех ошибок
error_reporting (E_ALL); 
// Подключаем конфиг
include ('/config.php'); 

// Соединяемся с БД
$dbObject = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=UTF8', DB_USER, DB_PASS);

// Подключаем ядро сайта
include (SITE_PATH . DS . 'core' . DS . 'core.php'); 

// Подключаем класс для вывода ошибок
include (SITE_PATH . DS . 'classes' . DS . 'error.php');

// Загружаем router
$router = new Router($registry);
// Записываем данные в реестр
$registry->set ('router', $router);
// Задаем путь до папки контроллеров.
$router->setPath (SITE_PATH . 'controllers');
// Запускаем маршрутизатор
$router->start();
