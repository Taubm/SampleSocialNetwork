<?php
// Класс вывода ошибок
Class Error {

	function show($error) {
		$contentPage = SITE_PATH . 'views' . DS . 'error' . DS . 'index.php';
		$this->vars['error'] = $error;
		include (SITE_PATH . 'views' . DS . 'layouts' . DS . 'layout.php');
		exit;
	}

}