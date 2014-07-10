<?php
// Загрузка классов "на лету"
function __autoload($className) {
	$filename = strtolower($className) . '.php';
	// Определяем класс и находим для него путь
	$expArr = explode('_', $className);
	if(empty($expArr[1]) OR $expArr[1] == 'Base'){
		$folder = 'classes';			
	}else{			
		switch(strtolower($expArr[0])){
			case 'controller':
				$folder = 'controllers';	
				break;
				
			case 'model':					
				$folder = 'models';	
				break;
				
			default:
				$folder = 'classes';
				break;
		}
	}
	// Путь до класса
	$file = SITE_PATH . $folder . DS . $filename;
	// Проверяем наличие файла
	if (file_exists($file) == false) {
		return false;
	}		
	// Подключаем файл с классом
	include ($file);
}

// Запускаем реестр (хранилище)
$registry = new Registry;