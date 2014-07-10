						<div class="network-header">
						    <h1 class="network-title"><?=$user['lastname'];?> <?=$user['firstname'];?> <?=$user['secondname'];?></h1>
						</div>
						<div class="col-sm-3">
							Статистика:<br>
							Пол: <?=$user['sex'];?><br>
							email: <?=$user['email'];?><br>
						</div>
						<div class="col-sm-9">
<?php 
// Блок добавления поста, если текущий пользователь - владелец просматриваемой стены
if (isset($_SESSION['id']) && $_SESSION['id']==$user['id']) { 
	?>
							<div class="col-sm-12">
								<form method='post' action='./posts/add'>
							    	<textarea class="form-control" name='post[text]' rows="2" required></textarea>
							    	<button class="btn btn-sm btn-primary" type=submit> Добавить </button>
							    </form>
							    <p>Записи:</p>
							</div>
<?php 
} 
// Вывод записей
foreach($posts as $post) { 
?>
							<div class="network-post">
								<div class="col-sm-11">
									<p class='network-post-meta'><?=$post['date']?></p>
							    </div>
								<div class="col-sm-1">
<?php 
	// Блок удаления поста, если текущий пользователь - владелец стены
	if (isset($_SESSION['id']) && $_SESSION['id']==$user['id']) { 
?>
									<form method='post' action='./posts/delete'>
						         		<input type="hidden" name="post[id]" value=<?=$post['id']?>>
						        		<button class="btn btn-sm btn-primary" type=submit> X </button>
						        	</form>
<?php 
	} 
?>
								</div>
								<div class="col-sm-12">
									<pre><?=$post['text'];?></pre>
								</div>
								<div class="col-sm-1">
								</div>
								<div class="col-sm-11">
									<div id="load" class="col-sm-12">
										<button class="btn btn-sm btn-primary btn-block" act="get" name="load" id="getComments-<?=$post['id']?>"> Загрузить предыдущие </button>
									</div>
									<div id="comments-<?=$post['id']?>" name="comments">
<?php $comments = $post['comments'];
// Отображение комментариев
include(SITE_PATH . 'views' . DS . 'parts' . DS . 'comments.php'); ?>
									</div>					
<?php 
// Возможность комментирования для авторизованных пользователей
	if (isset($_SESSION['id'])) { 
?>
									<div class="col-sm-12">
										<form action="">
											<textarea class="form-control" id='commText-<?=$post['id']?>' rows="1" required></textarea>
											<button class="btn btn-sm btn-primary" type="button" id="addComm-<?=$post['id']?>" name="addComm"> Добавить </button>
										</form>
									</div>
<?php 
	} 
?>
								</div>
								<div class="col-sm-12">
									<hr color='blue'>
								</div>
							</div>
<?php 
} 
?>
							<div class="pager col-sm-12">
<?php foreach ($pages as $page) {
?>
								<?=$page?>
<?php
}
?>
							</div>
						</div>
						<script src="./public/js/comments.js"></script>
