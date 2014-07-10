                      <div class="network-header">
                        <h1 align="center" class="network-title">Возникла ошибка</h1>
                      </div>
                      <div class="network-post">
                        <div class="col-sm-12">
                          <?php 
// Блок для вывода ошибок
if (isset($error)) { 
  ?>
                          <div class="alert alert-danger">
                            <pre><?=$error?></pre>
                          </div>
<?php 
} 
?>
                        </div>
                      </div>