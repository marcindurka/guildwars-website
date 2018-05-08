<?php
class UserModel extends Model{
    public function register(){
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if(isset($_POST['email'])){
            $registration_data_check=true;
            $nick=$post['nick'];
            if ((strlen($nick)<3)||(strlen($nick)>20)){
                $registration_data_check=false;
                $_SESSION['error_nick1']="Nick musi posiadać od 3 do 20 znaków!";
            }
            if (ctype_alnum($nick)==false){
                $registration_data_check=false;
                $_SESSION['error_nick2']="Nick może się składać tylko z liter i cyfr (bez polskich znaków)";
            }
            $email= $post['email'];
            $email2=filter_var($email,FILTER_SANITIZE_EMAIL);
            if ((filter_var($email,FILTER_VALIDATE_EMAIL)==false)||($email2!=$email)){
                $registration_data_check=false;
                $_SESSION['error_email']="Podaj poprawny adres email!";
            }
            $password1=$_POST['password1'];
            $password2=$_POST['password2']; 
            if((strlen($password1)<8)||(strlen($password1)>20)){
                $registration_data_check=false;
                $_SESSION['error_password']="Hasło musi posiadać od 8 do 20 znaków!";
            }
            if ($password1!=$password2){
                $registration_data_check=false;
                $_SESSION['error_password']="Podane hasła nie są identyczne!";            
            }
            $password_hash = password_hash($password1,PASSWORD_DEFAULT);              
            if (!isset($_POST['rules'])){
                $registration_data_check=false;
                $_SESSION['error_rules']="Potwierdź regulamin!";  
            }  
            $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.SECRETKEY.'&response='.$post['g-recaptcha-response']);
            $answer = json_decode($check);
            if ($answer->success==false){
                $registration_data_check=false;
                $_SESSION['error_captcha']="Czyżbyś był botem?";   
            }
        }
        mysqli_report(MYSQLI_REPORT_STRICT);
        try{
            $connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME); 
            if ($connection->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }else{
                if($post['submit']){
                    $db_check=$connection->query("SELECT id_user FROM users WHERE email ='$email'");
                    if(!$db_check){
                        throw new Exception ($connection->error);
                    }
                    $email_count=$db_check->num_rows;
                    if($email_count>0)
                    {
                        $registration_data_check=false;
                        $_SESSION['e_email']="Email w bazie już istnieje!";
                    }
                    $db_check=$connection->query("SELECT id_user FROM users WHERE name='$nick'");
                    if(!$db_check){
                        throw new Exception ($connection->error);
                    }
                    $nick_count=$db_check->num_rows;
                    if($nick_count>0)
                    {
                        $registration_data_check=false;
                        $_SESSION['e_nick']="Login zajęty! Wybierz inny.";
                    }
                    if($registration_data_check==true)
                    {
                        if ($connection->query("INSERT INTO users VALUES (NULL, '$nick', '$password_hash', '$email','Nieaktywny',1,0,0,0)"))
                        {
                            $_SESSION['registerok']=true;
                            header('Location: '.ROOT_URL);
                        }else{
                            throw new Exception ($connection->error);
                        } 
                    }                
                    $connection->close();
                }
            }     
        } catch (Exception $ex) {
            echo 'Błąd! Coś niestety nie działa :(';
            echo '<br/>Szczegóły błędu:<br/>'.$ex;
        }
        return;
    }  
    public function login() {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        mysqli_report(MYSQLI_REPORT_STRICT);
        try{
            $connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME); 
            if ($connection->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }else{
                if($post['submit']){
                    $password=$post['password'];
                    $login=htmlentities($post['login'],ENT_QUOTES, "UTF-8");
                    if($db_data=$connection->query(
                    sprintf("SELECT * FROM users where name='%s' AND active=1",mysqli_real_escape_string($connection,$login),mysqli_real_escape_string($connection,$password))))  {
                        $user_count=$db_data->num_rows;
                        if($user_count>0){
                            $row=$db_data->fetch_assoc();
                            if(password_verify($password, $row['password'])){
                                $_SESSION['is_logged_in'] = true;
                                $_SESSION['user_data']=array(
                                    'id_user'   => $row['id_user'],
                                    'name'      => $row['name'],
                                    'email'     => $row['email'],
                                    'rank'      => $row['rank'],
                                    'admin'     => $row['admin'],
                                    'groups'    => $row['groups'],
                                    'gw2id'     => $row['gw2id'],
                                    'active'    => $row['active']
                                    );
                                $api = new apigw2();
                                $apikeyinfo= $api->validate_apikey($_SESSION['user_data']['gw2id']);
                                $_SESSION['apikeyinfo']=$apikeyinfo;
                                unset($_SESSION['error']);
                                $db_data->free();
                                header('Location: '.ROOT_URL);
                            }else{
                                $_SESSION['error']='<div class="error">Nieprawidłowy login lub hasło!</div>';
                                //header('Location: '.ROOT_URL);
                                echo "błąd logowania 2";
                            }
                        }else{
                            $_SESSION['error']='<div class="error">Nieprawidłowy login lub hasło!</div>';
                            //header('Location: '.ROOT_URL);                        
                            echo "błąd logowania 3";
                        }
                    }       
                    $connection->close();
                }
            }     
        } catch (Exception $ex) {
            echo 'Błąd! Coś niestety nie działa :(';
            echo '<br/>Szczegóły błędu:<br/>'.$ex;
        }
        return;
    }
    public function profile(){
        return;
    }
    private function updateApiKey($userapikey, $nick, $connection){
        $api = new apigw2();
        $apikeyinfo= $api->validate_apikey($userapikey);
        $_SESSION['apikeyinfo']=$apikeyinfo;
        if((strlen($userapikey)!=72)||($apikeyinfo['name']=="No key")) {
            Messages::setMsg('Nieprawidłowy klucz API', 'error');}
            else{
            if ($connection->query("UPDATE users SET gw2id='$userapikey' WHERE name='$nick'")){
                $_SESSION['user_data']['gw2id']=$userapikey;
                Messages::setMsg('Dodano klucz API', 'ok');
                }else{
                    throw new Exception ($connection->error);
                } 
                           /* echo 'INSERT INTO apikeyinfo (apikey, name, account, inventories, characters, tradingpost, wallet, unlocks, pvp, builds, progression, guilds)VALUES ('
                .$userapikey.', '
                .$apikeyinfo['name'].', '
                .$apikeyinfo['account'].', '
                .$apikeyinfo['inventories'].', '
                .$apikeyinfo['characters'].', '
                .$apikeyinfo['tradingpost'].', '
                .$apikeyinfo['wallet'].', '
                .$apikeyinfo['unlocks'].', '
                .$apikeyinfo['pvp'].', '
                .$apikeyinfo['builds'].', '
                .$apikeyinfo['progression'].', '
                .$apikeyinfo['guilds'].', '
                ;
            if ($connection->query('INSERT INTO apikeyinfo (apikey, name, account, inventories, characters, tradingpost, wallet, unlocks, pvp, builds, progression, guilds)VALUES ('
                .$userapikey.', '
                .$apikeyinfo['name'].', '
                .$apikeyinfo['account'].', '
                .$apikeyinfo['inventories'].', '
                .$apikeyinfo['characters'].', '
                .$apikeyinfo['tradingpost'].', '
                .$apikeyinfo['wallet'].', '
                .$apikeyinfo['unlocks'].', '
                .$apikeyinfo['pvp'].', '
                .$apikeyinfo['builds'].', '
                .$apikeyinfo['progression'].', '
                .$apikeyinfo['guilds'].', '
                ))
                {

                }else{
                    throw new Exception ($connection->error);
                    
               }   */
            }

        return;
    }

    public function settings(){
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        mysqli_report(MYSQLI_REPORT_STRICT);    
        try{
            $connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME); 
            if ($connection->connect_errno!=0){
                throw new Exception(mysqli_connect_errno());}
                else {
                $userapikey=$post['userapikey'];
                $nick=$_SESSION['user_data']['name'];
                $db_data=$connection->query("SELECT id_user FROM users WHERE name='$nick'");
                if(!$db_data){
                    throw new Exception ($connection->error);
                }
                if($post['updateapikey']=='Aktualizuj klucz API'){
                    $this->updateApiKey($userapikey, $nick, $connection);
                    $connection->close(); 
                    $db_data->free();
                }
                if($post['updateapikey']=='Usuń klucz API'){
                    if ($connection->query("UPDATE users SET gw2id='' WHERE name='$nick'")){
                        $_SESSION['user_data']['gw2id']="";
                        $api = new apigw2();
                        $apikeyinfo= $api->validate_apikey($_SESSION['user_data']['gw2id']);
                        $_SESSION['apikeyinfo']=$apikeyinfo;
                        Messages::setMsg('Usunięto klucz API', 'ok');
                    }else{
                        throw new Exception ($connection->error);
                    } 
                } 
            }     
        }catch (Exception $ex) {
            echo 'Błąd! Coś niestety nie działa :( <br/>Szczegóły błędu:<br/>'.$ex;
            }
        return;
    }
   
}