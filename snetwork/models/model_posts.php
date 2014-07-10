<?php

Class Model_Posts Extends Model_Base {
	
	public function fieldsTable(){
		return array(
			'id' => 'Id',
			'text' => 'Text',
			'author_id' => 'Author Id',
			'date' => 'Date'
		);
	}

	// Получим количество записей пользователя
	public function getCount($author_id){
		try{
			$db = $this->db;
			$stmt = $db->query("select count(*) from posts where author_id=".$author_id);
			$row = $stmt->fetch();
		}catch(PDOException $e) {
			echo $e->getMessage();
			exit;
		}
		return $row[0];
	}

	// Получим последние посты указанного автора с $start по $start+$count
	public function get($id, $start, $count) {
		try{
			$db = $this->db;
			$stmt = $db->query("select *
			from posts 
			where author_id=" . $id . " 
			order by id desc  
			limit " . $start . ", " . $count);
			
			$rows = $stmt->fetchAll();
			
			// Для каждой записи получим комментарии
			$model = new Model_Comments();
			foreach ($rows as &$row) {
				$row['date'] = date('d.m.Y', strtotime($row['date']));
				$comments = $model->getLastComment($row['id']);
				$row['comments'] = $comments;
			}
		}catch(PDOException $e) {
			echo $e->getMessage();
			exit;
		}
		return $rows;
	}
	
}