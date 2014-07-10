<?php
// Контроллер
Class Controller_Comments Extends Controller_Base {
	
	// Шаблон
	public $layouts = '';
	
	// Не используется для данного контроллера
	function index(){
		$this->error->show('Страница не найдена.');
	}
	
	// Добавить комментарий
	function add() {
		// Проверим, авторизован ли пользователь
		$this->checkAuth();

		// Проверим, установлены ли все необходимые параметры
		$params = array(&$_POST['comment'], &$_POST['comment']['text'], &$_POST['comment']['post_id']);
		if (!$this->checkParams($params)) {
			$this->error->show('В post-запросе указаны не все необходимые параметры.');
		}

		// post_id должен быть числом
		if (!is_numeric($_POST['comment']['post_id'])) {
			$this->error->show('Неверные параметры post-запроса.');
		}
		
		// Проверим, существует ли комментируемый пост
		$model = new Model_Posts();
		$post = $model->getRowById($_POST['comment']['post_id']); 
		if (empty($post)) {
			$this->error->show('Комментируемой записи не существует.');
		}
		
		// Сохраняем комментарий
		$model = new Model_Comments();
		$model->text = $_POST['comment']['text'];
		$model->post_id = $_POST['comment']['post_id'];
		$model->author_id = $_SESSION['id'];
		$result = $model->save(); 

		// Возвращаем комментарий
		$comments = $model->getLastComment($model->post_id);
		$this->template->vars('comments', $comments);
		$this->template->partsView('comments');
	}

	// Получить комментарии
	function get() {
		// Количество комментариев
		$count = 50;

		// post_id должен быть числом
		if (!is_numeric($_GET['post_id'])) {
			$this->error->show('Неверные параметры get-запроса.');
		}

		// Проверим, установлены ли все необходимые параметры
		$params = array(&$_GET['post_id']);
		if (!$this->checkParams($params)) {
			$this->error->show('В get-запросе указаны не все необходимые параметры.');
		}

		// Получим комментарии
		$model = new Model_Comments();
		$comments = $model->getLastComments($_GET['post_id'], $count);

		// Вернем как "врезку"
		$this->template->vars('comments', $comments);
		$this->template->partsView('comments');
	}

	// Удаление комментария
	function delete() {
		// Проверим, авторизован ли пользователь
		$this->checkAuth();

		// Проверим, установлены ли все необходимые параметры
		$params = array(&$_POST['comment'], &$_POST['comment']['id']);
		if (!$this->checkParams($params)) {
			$this->error->show('В post-запросе указаны не все необходимые параметры.');
		}

		// id должен быть числом
		if (!is_numeric($_POST['comment']['id'])) {
			$this->error->show('Неверные параметры post-запроса.');
		}

		// Проверим существование комментария
		$model = new Model_Comments();
		$comment = $model->getRowById($_POST['comment']['id']); 
		if (empty($comment)) {
			$this->error->show('Этого комментария не существует.');
		}

		// Узнаем id хозина стены
		$ownerId = $model->getWallOwnerId($comment['id']);

		// Проверим права доступа: удалить может хозяин стены или автор комментария
		if ($comment['author_id']!=$_SESSION['id'] &&
			$comment['author_id']!=$ownerId) {
			$this->error->show('Удалить запись может только ее автор или владелец стены.');
		}

		// Удаляем
		$select = array(
			'where' => 'id = '.$_POST['comment']['id']
		);
		$result = $model->deleteBySelect($select);
	}

}