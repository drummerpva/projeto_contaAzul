<?php

class loginController extends controller {

    public function index() {
        $u = new Users();
        if ($u->isLogged()) {
            header("Location: " . BASE_URL);
            exit;
        }
        $data = [];
        if (!empty($_POST['email'])) {
            $email = addslashes($_POST['email']);
            $pass = md5($_POST['password']);
            if ($u->doLogin($email, $pass)) {
                header("Location: " . BASE_URL);
                exit;
            } else {
                $data['error'] = "Usuário e/ou senha inválidos";
            }
        }



        $this->loadView('login', $data);
    }

    public function logOut() {
        $u = new Users();
        $u->setLoggedUser();
        $u->logOut();
        header("Location: " . BASE_URL);
        exit;
    }

}
