<?php
// Контроллер
Class Controller_User Extends Controller_Base {
	
	// Шаблон
	public $layouts = "layout";

	// Количество записей на странице
	private $postsOnPage = 20;

	private function pageCreate($id, $str) {
		if ($str!='..') {
			return '<a href="?id=' . $id . '&p=' . $str . '">' . $str . '</a>';
		} else {
			return '<a>..</a>';
		}
	}

	// Стена пользователя
	function index(){
		// Проверим, установлены ли все необходимые параметры
		$params = array(&$_GET['id']);
		if (!$this->checkParams($params)) {
			$this->error->show('Страница не найдена.');
		}

		// id должен быть числом
		if (!is_numeric($_GET['id'])) {
			$this->error->show('Страница не найдена.');
		}

		// Получаем пользователя из БД
		$model = new Model_Users(); 
		$user = $model->getRowById($_GET['id']); 
		if (empty($user)) {
			$this->error->show('Такого пользователя не существует.');
		}
		
		// Если номер страницы не указан, то устанавливаем 1
		if (!isset($_GET['p'])) {
			$pageNum=1;
		} else {
			if (is_numeric($_GET['p']) && $_GET['p']>0) {
				$pageNum = $_GET['p'];
			} else {
				echo "<meta http-equiv=\"refresh\" content=\"0;url=" . URL . "user?id=" . $user['id'] . "\">";
				exit;
			}
		}

		// Получаем записи
		$model = new Model_Posts();
		$start = $this->postsOnPage*($pageNum-1);
		$end = $this->postsOnPage;
		$posts = $model->get($_GET['id'], $start, $end);

		if (empty($posts)) {
			$posts = [];
		}

		// Получим количество всех записей пользователя
		$postCount = $model->getCount($_GET['id']);  

		// Вычислим число страниц
		if ($postCount>0) {
			$pageCount = intval(($postCount-1)/($this->postsOnPage))+1;
		} else {
			$pageCount = 1;
		}


		$pages = [];
		if ($pageCount>1) {
			if ($pageCount<10) {
				for ($i=1; $i<=$pageCount; $i++) {
					array_push($pages, $this->pageCreate($user['id'], $i));
				}
			} else {
				if ($pageNum<5) {
					for ($i=1; $i<=5; $i++) {
					array_push($pages, $this->pageCreate($user['id'], $i));
					}
					array_push($pages, $this->pageCreate($user['id'], '..'));
					array_push($pages, $this->pageCreate($user['id'], $pageCount));
				}
				if ($pageNum>$pageCount-4) {
					array_push($pages, $this->pageCreate($user['id'], 1));
					array_push($pages, $this->pageCreate($user['id'], '..'));
					for ($i=$pageCount-4; $i<=$pageCount; $i++) {
						array_push($pages, $this->pageCreate($user['id'], $i));
					}
				}
				if ($pageNum>=5 && $pageNum<=$pageCount-4) {
					array_push($pages, $this->pageCreate($user['id'], 1));
					array_push($pages, $this->pageCreate($user['id'], '..'));
					for ($i=$pageNum-2; $i<=$pageNum+2; $i++) {
						array_push($pages, $this->pageCreate($user['id'], $i));
					}
					array_push($pages, $this->pageCreate($user['id'], '..'));
					array_push($pages, $this->pageCreate($user['id'], $pageCount));
				}
			}
		}

		// Проверим номер запрашиваемой страницы
		if ($pageNum>$pageCount) {
			echo "<meta http-equiv=\"refresh\" content=\"0;url=" . URL . "user?id=" . $user['id'] . "&p=" . $pageCount . "\">";
			exit;
		}

		$this->template->vars('user', $user);
		$this->template->vars('posts', $posts);
		$this->template->vars('pages', $pages);
		$this->template->view('index');
	}

	// Просмотр профиля
	function profile() {
		// Проверим, авторизован ли пользователь
		$this->checkAuth();

		// Получим пользователя
		$model = new Model_Users();
		$user = $model->getRowById($_SESSION['id']); 
		
		// Количество его записей
		$model = new Model_Posts();
		$postCount = $model->getCount($_SESSION['id']);

		// Количество его комментариев
		$model = new Model_Comments();
		$commCount = $model->getCount($_SESSION['id']);

		$this->template->vars('commCount', $commCount);
		$this->template->vars('postCount', $postCount);
		$this->template->vars('user', $user);
		$this->template->view('profile');
	}

}
