<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Sample social network</title>
		<link rel="stylesheet" href="/nakubani/public/stylesheets/bootstrap.css">
    	<link rel="stylesheet" href="/nakubani/public/stylesheets/bootstrap-responsive.css">
    	<link rel="stylesheet" href="/nakubani/public/stylesheets/network.css">
    	<script src="http://code.jquery.com/jquery-latest.js"></script>
    	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
	</head>
	<body class="ng-scope">
		<div class="page-wrapper">
			<div class="network-masthead">
				<div class="container">
					<nav class="navbar-header">
						<a class="network-nav-item" href=<?=URL?>>Топ-10</a>
					</nav>
					<div class="navbar-collapse collapse">
						<form class="navbar-form navbar-right" role="form" method="post" action=<?=URL . "auth/logout"?>>
							<div class="btn-toolbar">
<?php
// Вывод блока кнопок для неавторизованных пользователей
if (empty($_SESSION)) { ?>
								<div class="btn-group">
									<button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-modal-sm">Войти</button>
								</div>
								<div class="btn-group">
									<button type="button" class="btn btn-success" onclick=<?='"location.href=\'' . URL . 'registration\'"'?>> Регистрация </button>
								</div>
<?php 
// Соответственно, блок кнопок для авторизованных пользователей
} else { 
?>
								<div class="btn-group">
                    				<button type="button" class="btn btn-success" onclick=<?='"location.href=\'' . URL . 'user?id='.$_SESSION['id'].'\'"'?>> Моя стена </button>
                    			</div>
                    			<div class="btn-group">
                    				<button type="button" class="btn btn-success" onclick=<?='"location.href=\'' . URL . 'user/profile\'"'?>> Профиль </button>
                    			</div>
								<div class="btn-group">
                    				<button class="btn btn btn-success" type=submit> Выйти </button>
                    			</div>
<?php 
}
?>
							</div>
						</form>
					</div>
				</div>
			</div>
<?php 
// Модальное окно авторизации
include 'modal.php'; 
?>
			<div class="container">
				<div class="row">
					<div class="col-sm-12 network-main">
<?php
// Контент
include ($contentPage);
?>
					</div>
				</div>
			</div>
			<div class="page-buffer"></div>
		</div>
		<div class="network-footer">
			<p>Created by Tai</p>
		</div>
	</body>
</html>