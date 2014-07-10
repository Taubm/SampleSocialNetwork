            <div class="modal fade bs-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> × </button>
                            <h2 class="form-signin-heading" id="myModalLabel"> Авторизация </h2>
                        </div>
                        <div class="modal-body">
                            <form method='post' action=<?=URL . "auth"?> class="form-signin" role="form">
                                <div class="form-group">
                                    <input name='user[email]' maxlength="30" pattern="([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})" class="form-control input-sm" placeholder="email" required autofocus>
                                </div>
                                <div class="form-group">
                                    <input name='user[pass]' maxlength="30" pattern="[A-Za-zА-Яа-я0-9]+" type="password" class="form-control input-sm" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit"> Войти </button>
                                </div>
                            </form>
                            <button class="btn btn-primary btn-block" onclick="location.href='<?=URL;?>registration'"> Зарегистрироваться </button>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
