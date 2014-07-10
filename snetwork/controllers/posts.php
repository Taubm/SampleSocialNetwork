<?php
// Контроллер
Class Controller_Posts Extends Controller_Base {
	
	// Шаблон
	public $layouts = "layout";

	// Не используется для данного контроллера
	function index(){
		$this->error->show('Страница не найдена.');
	}
	
	// Добавление записи на стену
	function add() {
		// Проверим, авторизован ли пользователь
		$this->checkAuth();
		
		// Проверим, установлены ли все необходимые параметры
		$params = array(&$_POST['post'], &$_POST['post']['text']);
		if (!$this->checkParams($params)) {
			$this->error->show('В post-запросе указаны не все необходимые параметры.');
		}

		// Сохраняем запись
		$model = new Model_Posts(); 
		$model->text = $_POST['post']['text'];
		$model->author_id = $_SESSION['id'];
		$result = $model->save(); 

		// Перенаправляем на предыдущую страницу
		echo "<meta http-equiv=\"refresh\" content=\"0;url=" . $_SERVER['HTTP_REFERER'] . "\">";
	}

	// Удаление записи
	function delete() {
		// Проверим, авторизован ли пользователь
		$this->checkAuth();

		// Проверим, установлены ли все необходимые параметры
		$params = array(&$_POST['post'], &$_POST['post']['id']);
		if (!$this->checkParams($params)) {
			$this->error->show('В post-запросе указаны не все необходимые параметры.');
		}

		// post_id должен быть числом
		if (!is_numeric($_POST['post']['id'])) {
			$this->error->show('Неверные параметры post-запроса.');
		}

		// Проверим, существует ли запись
		$model = new Model_Posts();
		$post = $model->getRowById($_POST['post']['id']);
		if (empty($post)) {
			$this->error->show('Этой записи не существует.');
		}

		// Проверим права доступа - удалить может только автор
		if ($post['author_id']!=$_SESSION['id']) {
			$this->error->show('Удалить запись может только ее автор.');
		}

		// Удаляем
		$select = array(
			'where' => 'id = '.$_POST['post']['id']
		);
		$result = $model->deleteBySelect($select);

		// Перенаправляем на предыдущую страницу
		echo "<meta http-equiv=\"refresh\" content=\"0;url=" . $_SERVER['HTTP_REFERER'] . "\">";
	}

}