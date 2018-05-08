<?php
class users extends Controller{
    protected function register(){
        $viewmodel = new UserModel();
        $this->returnView($viewmodel->register(), true);
    }
    protected function login(){
        $viewmodel = new UserModel();
        $this->returnView($viewmodel->login(), true);
    }
    protected function logout(){
        unset($_SESSION['is_logged_in']);
        unset($_SESSION['user_data']);
        unset($useraccount);
        session_destroy();
        header('Location: '.ROOT_URL);
    }
    protected function profile(){
        $viewmodel = new UserModel();
        $this->returnView($viewmodel->profile(), true);
    }
    protected function settings(){
        $viewmodel = new UserModel();
        $this->returnView($viewmodel->settings(), true);
    }


}