<?php
// Контроллер
Class Controller_Registration Extends Controller_Base {
	
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

	// Для полей, состоящих из букв
	private function checkChars($field) {
		return !preg_match('/^([A-ZА-Я]{1}[a-zа-я]+(\-[A-ZА-Я]{1}[A-Za-zА-Яа-я]+)*)+$/', $field);
	}

	// Для полей, состоящих из букв и цифр
	private function checkPassChars($field) {
		return preg_match('/^[A-Za-zА-Яа-я0-9]+$/', $field);
	}

	// Функция проверки пользователя
	private function validate($user) {
		$errors = [];
		// Поля
		if (!$this->checkLength($user['firstname']) || !$this->checkChars($user['firstname'])) { array_push($errors, 'Имя должно содержать от 3 до 30 букв.'); }
		if (!$this->checkLength($user['secondname']) || !$this->checkChars($user['secondname'])) { array_push($errors, 'Отчество должно содержать от 3 до 30 букв.'); }
		if (!$this->checkLength($user['lastname']) || !$this->checkChars($user['lastname'])) { array_push($errors, 'Фамилия должна содержать от 3 до 30 букв.'); }
		if (!$this->checkLength($user['pass']) || !$this->checkPassChars($user['pass'])) { array_push($errors, 'Пароль должен содержать от 3 до 30 символов (буквы латинского или русского алфавита или цифры).'); }
		if ($user['sex']!='m' && $user['sex']!='f') { array_push($errors, 'Неверно указан пол.'); }
		if (!$this->checkLength($user['email']) || !filter_var($user['email'], FILTER_VALIDATE_EMAIL)) { array_push($errors, 'Некорректно указан email.'); }

		// Проверка на уникальность email
		$select = array(
			'where' => 'email = \'' . $user['email'] . '\''
			);
		$model = new Model_Users($select);
		$user = $model->getOneRow();
		if (!empty($user)) { array_push($errors, 'Пользователь с указанным email уже <br>зарегистрирован.'); }

		return $errors;
	}

	// Регистрация
	function save() {
		// Проверим, установлены ли все необходимые параметры
		$params = array(&$_POST['user']);
		if (!$this->checkParams($params)) {
			echo "<meta http-equiv=\"refresh\" content=\"0;url=" . URL . "registration\">";
			exit;
		}

		$user = $_POST['user'];

		// Проверим данные на корректность
		$errors = $this->validate($user);
		if (empty($errors)) {
			// Сохраняем пользователя
			$model = new Model_Users();
			$model->firstname = $user['firstname'];
			$model->secondname = $user['secondname'];
			$model->lastname = $user['lastname'];
			$model->email = $user['email'];
			$model->pass = md5($user['pass']);
			$model->sex = $user['sex'];
			$result = $model->save();

			// Перенаправляем на страницу авторизации
			echo "<meta http-equiv=\"refresh\" content=\"0;url=" . URL . "auth\">";
			exit;
		} else {
			// Показываем форму регистрации со всеми бнаруженными ошибками
			$this->template->vars('user', $user);
			$this->template->vars('errors', $errors);
			$this->template->view('index');
		}
	}
	
	// Отображение формы регистрации
	function index() {
		$user = [
			'firstname' => '',
			'secondname' => '',
			'lastname' => '',
			'email' => '',
			'sex' => ''
			];
		$this->template->vars('user', $user);
		$this->template->view('index');
	}
	
}