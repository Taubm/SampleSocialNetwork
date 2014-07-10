<?php
// Базовый класс контроллера
Abstract Class Controller_Base {

	protected $error;
	protected $registry;
	protected $template;
	protected $layouts; // шаблон
	
	public $vars = array();

	// Подключаем шаблоны
	function __construct($registry) {
		// Отображение ошибок
		$this->error = new Error();

		$this->registry = $registry;
		// Шаблоны
		$this->template = new Template($this->layouts, get_class($this));
	}

	abstract function index();

	// Проверяем, авторизирован ли пользователь
	function checkAuth() {
		if (!$_SESSION) {
			$this->error->show('Вы должны быть авторизованы для доступа к этой странице.');
		}
	}

	// Проверяем, установлены ли все нужные параметры
	function checkParams($params) {
		foreach ($params as $param) {
			if (!isset($param) || $param=='') {
				return false;
			}
		}
		return true;
	}
}
