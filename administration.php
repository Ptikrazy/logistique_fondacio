<?php

require_once 'include/init.php';

$title = 'Administration';
require_once 'include/head.php';

if (isset($_POST['submit'])) {

    if (!check_password($_POST['login'], $_POST['password'])) {

        echo 'coucou';

    }

    else {

        redirect('/administration.php');

    }


}

else {

?>
    <h3>Login</h3><br>
    <form action="" method="POST">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="login">Identifiant</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="login" id="login" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="password">Mot de passe</label>
            <div class="col-sm-3">
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Connexion</button>
            </div>
        </div>
    </form>

<?php

}

require_once 'include/foot.php';

?>