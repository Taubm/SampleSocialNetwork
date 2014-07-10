<?php 
foreach($comments as $comment) { 
?>
									<div name="comment-<?=$comment['id'];?>">
										<div class="col-sm-11">
											<a href="./user?id=<?=$comment['author_id'];?>"><?=$comment['firstname'];?>:</a>
										</div>
										<div class="col-sm-1">
<?php if (isset($_SESSION['id']) &&
($_SESSION['id']==$comment['wall_id'] || $_SESSION['id']==$comment['author_id'])) { 
?>
											<div>
									        	<button class="btn btn-sm btn-link" name="deleteComm" id="delComm-<?=$comment['id'];?>"> X </button>
							        		</div>
<?php 
} 
?>
										</div>
										<div class="col-sm-12">
											<pre><?=$comment['text']?></pre>
											<small><?=$comment['date'];?></small>
											<hr color='blue'>
										</div>
									</div>
<?php 
}
?>	