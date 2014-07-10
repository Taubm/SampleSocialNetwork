<?php

Class Model_Comments Extends Model_Base {
	
	public function fieldsTable(){
		return array(
			'id' => 'Id',
			'text' => 'Text',
			'author_id' => 'Author Id',
			'post_id' => 'Post Id',
			'date' => 'Date'
		);
	}

	// Получим id хозяина стены, на которой размещен пост с указанным комментарием
	public function getWallOwnerId($id) {
		try{
			$db = $this->db;
			$stmt = $db->query("SELECT author_id
								FROM posts
								WHERE id = (
								SELECT post_id
								FROM comments
								WHERE id =" . $id .")");
			$rows = $stmt->fetchAll();
		}catch(PDOException $e) {
			echo $e->getMessage();
			exit;
		}
		return $rows[0]['author_id'];
	}

	// Получим последний комментарий для указанной записи
	public function getLastComment($postId) {
		try{
			$db = $this->db;
			$stmt = $db->query("select posts.author_id as wall_id, comments.id, comments.text, firstname, comments.date, comments.author_id from comments inner join users on users.id=comments.author_id inner join posts on posts.id=comments.post_id where post_id=".$postId. " order by comments.id DESC limit 0, 1");
			$rows = $stmt->fetchAll();
			if (!empty($rows)) {
				$rows[0]['date'] = date('d.m.Y в H:i', strtotime($rows[0]['date']));
			}
		}catch(PDOException $e) {
			echo $e->getMessage();
			exit;
		}
		return $rows;
	}

	// Получим следующие $count комментариев
	public function getLastComments($postId, $count) {
		try{
			$db = $this->db;
			$stmt = $db->query("select * from (select posts.author_id as wall_id, comments.id, comments.text, firstname, comments.date, comments.author_id from comments inner join users on users.id=comments.author_id inner join posts on posts.id=comments.post_id where post_id=" .$postId . " order by comments.id DESC limit 0, " . $count . ") as comm order by id");
			$rows = $stmt->fetchAll();
			foreach ($rows as &$row) {
				$row['date'] = date('d.m.Y в H:i', strtotime($row['date']));
			}
		}catch(PDOException $e) {
			echo $e->getMessage();
			exit;
		}
		return $rows;
	}

	// Получим количество комментариев для указанного пользователя
	public function getCount($author_id){
		try{
			$db = $this->db;
			$stmt = $db->query("SELECT count(*) from comments where author_id=".$author_id);
			$row = $stmt->fetch();
		}catch(PDOException $e) {
			echo $e->getMessage();
			exit;
		}
		return $row[0];
	}
	
}