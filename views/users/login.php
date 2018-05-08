<?php
    if(isset($_SESSION['is_logged_in'])){
        header('Location: '.ROOT_URL);
    }
?>
<div class="loginbox site center">
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
        <div id="login-form">
            <label>Login:</label>
            <input type="text" name="login"/>
            <label>Hasło: </label>
            <input type="password" name="password"/>
            <input name="submit" type=submit value="Zaloguj się"/>
        </div>
        <div class="login-form-below center">  
            <a href="<?php echo ROOT_URL; ?>"><div class="links links-login">Powrót</div></a>
            <a href="<?php echo ROOT_URL; ?>users/register"><div class="links links-login">Rejestracja</div></a>
        </div>  
    </form>  
</div>