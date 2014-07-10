<?php
// Контроллер
Class Controller_Auth Extends Controller_Base {
	
	// Шаблон
	public $layouts = "layout";

	// Длина поля от 3 до 30 символов
	private function checkLength($field) {
		if ($field==null) {
			return false;
		}
		$length = strlen($field);
		if ($length<3 || $length>30) {
			return false;
		}
		return true;
	}

	// Для полей, состоящих из букв и цифр
	private function checkPassChars($field) {
		return preg_match('/^[A-Za-zА-Яа-я0-9]+$/', $field);
	}

	private function validate($user) {
		if (!$this->checkLength($user['email']) || !filter_var($user['email'], FILTER_VALIDATE_EMAIL)) { return false; }
		if (!$this->checkLength($user['pass']) || !$this->checkPassChars($user['pass'])) { return false; }
		return true;
	}

	// Авторизация
	function index() {
		// Проверка всех необходимых параметров
		$params = array(&$_POST['user'], &$_POST['user']['email'], &$_POST['user']['pass']);
		if (!$this->checkParams($params)) {
			$this->template->vars('email', '');
			$this->template->view('index');
		} else {
			// Валидация
			if (!$this->validate($_POST['user'])) {
				$this->template->vars('error', 'Все поля обязательны для заполнения.');
				$this->template->vars('email', '');
				$this->template->view('index');
			}

			// Попробуем получить из БД пользователя с указанными email и паролем
			$user = $_POST['user'];
			$select = array(
				'where' => 'email = \'' . $user['email'] . '\' and pass = \'' . md5($user['pass']) .'\''
				);
			$model = new Model_Users($select);
			$dbuser = $model->getOneRow();
			if ($dbuser) {
				// Если найден - устанавливаем id для сессии и перенаправляем на стену пользователя
				$_SESSION["id"]=$dbuser['id'];
	  			echo "<meta http-equiv=\"refresh\" content=\"0;url=" . URL . "user?id=" . $dbuser['id'] . "\">";
			} else {
				// Если нет - просим повторить попытку
				$this->template->vars('email', $user['email']);
				$this->template->vars('error', 'Неверная пара логин/пароль.');
				$this->template->view('index');
			}
		}
	}

	// Выход
	function logout() {
		$this->checkAuth();
		
		unset($_SESSION["id"]);
		session_destroy();
		echo "<meta http-equiv=\"refresh\" content=\"0;url=" . $_SERVER['HTTP_REFERER'] . "\">";
	}

}