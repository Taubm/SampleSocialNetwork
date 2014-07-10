<?php

Class Model_Users Extends Model_Base {
	
	public function fieldsTable(){
		return array(
			'id' => 'Id',
			'firstname' => 'Имя',
			'secondname' => 'Отчество',
			'lastname' => 'Фамилия',
			'sex' => 'Пол',
			'email' => 'email',
			"pass" => 'Пароль'
		);
	}

	// Получим топ самых комментируемых пользователей, строк в топе - $count
	public function getTopUsers($count) {
		try{
			$db = $this->db;
			$stmt = $db->query("SELECT id, firstname, secondname, lastname, (
				select count(id) 
				from comments 
				where post_id in (
					select id 
					from posts 
					where author_id=usr.id and TIMESTAMPDIFF(DAY,date,NOW()) < 7)) as count 
			from users usr 
			order by count desc, lastname 
			limit 0," . $count);
			$rows = $stmt->fetchAll();

			// Номер позиции для удобства вывода
			$i = 0;
			foreach ($rows as &$row) {
				$row['position'] = ++$i;
			}
		}catch(PDOException $e) {
			echo $e->getMessage();
			exit;
		}
		return $rows;
	}

	// Получим пользователя по id
	function getRowById($id){
		try{
			$db = $this->db;
			$stmt = $db->query("SELECT * from users WHERE id = $id");
			$row = $stmt->fetch();
			
			// Изменим вывод пола
			if ($row['sex']=='m') {
				$row['sex']='муж';
			} else {
				$row['sex']='жен';
		}
		}catch(PDOException $e) {
			echo $e->getMessage();
			exit;
		}
		return $row;
	}
	
}