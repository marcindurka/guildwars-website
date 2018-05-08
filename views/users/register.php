<?php
    if(isset($_SESSION['is_logged_in'])){
        header('Location: '.ROOT_URL);
    }
?>
<div class="registerbox site" >
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
        <ul class="register-form">
            <li>
                Login:<input type="text" name="nick"/>
                <?php
                    if (isset($_SESSION['error_nick'])){
                    echo '<div class="error1">'.$_SESSION['error_nick'].'</div>';
                    unset($_SESSION['error_nick']);
                    }
                ?>
            </li>
            <li>
                Adres email:<input type="text" name="email"/>
                <?php
                    if (isset($_SESSION['error_email'])){
                    echo '<div class="error2">'.$_SESSION['error_email'].'</div>';
                    unset($_SESSION['error_email']);
                    }
                ?>
            </li>
            <li>
                Hasło:<input type="password" name="password1"/>
                <?php
                    if (isset($_SESSION['error_password'])) {
                    echo '<div class="error1">'.$_SESSION['error_password'].'</div>';
                    unset($_SESSION['error_password']);
                    }
                ?>                   
            </li>
            <li>
                Potwierdź hasło:<input type="password" name="password2"/>
            </li>
            <li>
                <label>
                    <input type="checkbox" name="rules"/> Akceptuję regulamin
                </label>
                <?php
                    if (isset($_SESSION['error_rules'])) 
                    {
                    echo '<div class="error3">'.$_SESSION['error_rules'].'</div>';
                    unset($_SESSION['error_rules']);
                    }
                ?>       
            </li>
            <li>
                <div class="g-recaptcha" data-sitekey="<?php echo CAPTCHA;?>"></div>
                <?php
                    if (isset($_SESSION['error_captcha'])) 
                    {
                    echo '<div class="error4">'.$_SESSION['error_captcha'].'</div>';
                    unset($_SESSION['error_captcha']);
                    }
                ?>                 
            </li>
            <li>
                <input name="submit" type=submit value="Zarejestruj się"/>
            </li>
            <li>
                <a href="<?php echo ROOT_URL; ?>users/login"><div class="links center">Powrót</div></a>
            </li>
        </ul>
    </form>         
</div>












