						<div class="network-header">
						    <h1 class="network-title">10 самых популярных пользователей</h1>
						</div>
						<table class="table table-striped">
							<tr>
								<td>#</td>
								<td>ФИО</td>
								<td>Комментариев к записям</td>
							</tr>
<?php 
// Вывод информации о пользователях
foreach($users as $user) { ?>
							<tr>
								<td><?=$user['position']?></td>
								<td><a href=<?='"' . URL . 'user?id=' . $user['id'] . '"'?>><?=$user['lastname'];?> <?=$user['firstname'];?> <?=$user['secondname'];?></a></td>
								<td><?=$user['count'];?></td>
							</tr>
<?php 
} 
?>
						</table>
