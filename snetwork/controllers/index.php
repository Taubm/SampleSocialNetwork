<?php
// Контроллер
Class Controller_Index Extends Controller_Base {
	
	// Шаблон
	public $layouts = "layout";
	
	// Топ самых комментируемых пользовтелей
	function index() {

		$model = new Model_Users(); 
		$users = $model->getTopUsers(10); // Указываем количество пользователей, которые попадут в топ
		
		$this->template->vars('users', $users);
		$this->template->view('index');
	}
	
}