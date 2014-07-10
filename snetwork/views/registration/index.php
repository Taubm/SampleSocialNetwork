                        <div class="network-header">
                          <h1 align="center" class="network-title">Регистрация</h1>
                        </div>
                        <div class="network-post" >
                          <?php 
// Блок вывода ошибок
if (!empty($errors)) { 
?>
                            <div class="alert alert-danger col-sm-12">
<?php 
// Отображение ошибок
  foreach ($errors as $error) { 
?>
                              <small><?=$error?></small><br>                       
<?php 
  }
?>
                            </div>
<?php 
} 
?>
                          <div class="col-sm-4" >
                          </div>
                          <div class="col-sm-4" >
                            <form method='post' action=<?=URL . 'registration/save'?> role="form" >
                              <div class="form-group" >
                                <label class="control-label" for="lastname" > Фамилия: </label>
                                <input name='user[lastname]' maxlength="30" pattern="([A-ZА-Я]{1}[a-zа-я]+(\-[A-ZА-Я]{1}[A-Za-zА-Яа-я]+)*)" class="form-control" required id="lastname" value="<?=$user['lastname'];?>">
                              </div>
                              <div class="form-group" >
                                <label class="control-label" for="firstname" > Имя: </label>
                                <input name='user[firstname]' maxlength="30" pattern="([A-ZА-Я]{1}[a-zа-я]+(\-[A-ZА-Я]{1}[A-Za-zА-Яа-я]+)*)" class="form-control" required id="firstname" value="<?=$user['firstname'];?>">
                              </div>
                              <div class="form-group" >
                                <label class="control-label" for="secondname" > Отчество: </label>
                                <input name='user[secondname]' maxlength="30" pattern="([A-ZА-Я]{1}[a-zа-я]+(\-[A-ZА-Я]{1}[A-Za-zА-Яа-я]+)*)" class="form-control" required id="secondname" value="<?=$user['secondname'];?>">
                              </div>
                              <div class="form-group" >
                                <label class="control-label" for="sex"> Пол: </label>
                                <select name="user[sex]" id="sex">
                                  <option value="m">муж</option>
                                  <option value="f">жен</option>
                                </select>
                              </div>
                              <div class="form-group" >
                                <label class="control-label" for="email"> email: </label>
                                <input name='user[email]' maxlength="30" pattern="([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})" class="form-control" required autofocus id="email" value="<?=$user['email'];?>">
                              </div>
                              <div class="form-group" >
                                <label class="control-label" for="pass"> Пароль: </label>
                                <input name='user[pass]' maxlength="30" pattern="[A-Za-zА-Яа-я0-9]+" class="form-control" required id="pass" type="password">
                              </div>
                              <button class="btn btn btn-primary" type=submit> Сохранить </button>
                            </form>
                          </div>
                        </div>
