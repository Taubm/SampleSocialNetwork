<?php
// Класс хранилища
Class Registry {

	private $vars = array();
	
	// Запись данных
	function set($key, $var) {
        if (isset($this->vars[$key]) == true) {
			throw new Exception('Unable to set var `' . $key . '`. Already set.');
        }
        $this->vars[$key] = $var;
        return true;
	}

	// Получение данных
	function get($key) {
		if (isset($this->vars[$key]) == false) {
			return null;
		}
		return $this->vars[$key];
	}

	// Удаление данных
	function remove($var) {
		unset($this->vars[$key]);
	}

}
