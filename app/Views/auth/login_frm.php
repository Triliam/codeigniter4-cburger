<?= $this->extend('layouts/layout_auth') ?>
<?= $this->section('content') ?>

 <div class="login-box">

        <div class="text-center mb-3">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo">
        </div>

       <!-- <form action="#" method="post"> -->
        <?= form_open('/auth/submit') ?>
            <div class="mb-3">
                <p class="mb-2">Restaurante</p>
                <select name="select_restaurant" id="select_restaurant" class="form-select">
                    <option value=""></option>
                    <?php foreach($restaurants as $restaurant): ?>
                        <?php
                            $selected ='';
                            if(!empty($select_restaurant) && $select_restaurant == $restaurant->id){
                                $selected = 'selected';
                            } 
                        ?>
                        <option value="<?= Encrypt($restaurant->id) ?>" <?= $selected ?>><?= $restaurant->name ?></option>
                    <?php endforeach; ?>
                </select>
               <?= display_error('select_restaurant', $validation_errors) ?>
            </div>

            <hr>

            <div class="mb-3">
                <input class="form-control" type="text" id="text_username" name="text_username" placeholder="Usuário" value="<?= old('text_username') ?>">
                <?= display_error('text_username', $validation_errors) ?>
            </div>
            <div class="mb-3">
                <input class="form-control" type="password" id="text_password" name="text_password" placeholder="Senha" value="<?= old('text_password') ?>">
                <?= display_error('text_password', $validation_errors) ?>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn-login" value="ENTRAR">
            </div>
        <!-- </form> -->
         <?= form_close() ?>

        <div class="text-center">
            <p>Não tem conta? <a href="#" class="login-link">Cadastre-se</a></p>
            <p><a href="#" class="login-link">Reperar senha</a></p>
        </div>
        <?php if(!empty($login_error)): ?>
            <div class="alert alert-danger text-center p-1">
                <?= $login_error ?>
        <?php endif; ?>
            </div>
    </div>

<?= $this->endSection() ?>