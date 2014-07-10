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
                      <div class="network-header">
                        <h1 align="center" class="network-title">Авторизация</h1>
                      </div>
                      <div class="network-post">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                          <form method='post' action=<?=URL . "auth"?>>
                            <div class="form-group">
                              <input name='user[email]' maxlength="30" pattern="([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})" class="form-control input-sm" placeholder="email" required autofocus value="<?=$email;?>">
                            </div>
                            <div class="form-group">
                              <input name='user[pass]' maxlength="30" pattern="[A-Za-zА-Яа-я0-9]+" type="password" class="form-control input-sm" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                              <button class="btn btn-primary btn-block" type="submit"> Войти </button>
                            </div>
                          </form>
                        </div>
                      </div>