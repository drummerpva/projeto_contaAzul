<?php

class UsersController extends controller
{

    public function __construct()
    {
        $u = new Users();
        if (!$u->isLogged()) {
            header("Location: " . BASE_URL . "login");
            exit;
        }
    }

    public function index()
    {
        $data = [
        ];
        $u = new Users();
        $u->setLoggedUser();
        $comp = new Companies($u->getCompany());
        if ($u->hasPerssion("usersView")) {
            $data['companyName'] = $comp->getName();
            $data['userEmail'] = $u->getEmail();
            $data['usersList'] = $u->getList($u->getCompany());
            $this->loadTemplate('users', $data);
            exit;
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    public function add()
    {
        $data = [
        ];
        $u = new Users();
        $u->setLoggedUser();
        $comp = new Companies($u->getCompany());
        $data['companyName'] = $comp->getName();
        $data['userEmail'] = $u->getEmail();
        if ($u->hasPerssion("usersView")) {
            $p = new Permissions();
            if (!empty($_POST['email'])) {
                $email = addslashes($_POST['email']);
                $pass = md5($_POST['password']);
                $group = addslashes($_POST['group']);
                $a = $u->add($email, $pass, $group, $u->getCompany());
                if ($a) {
                    header("Location: " . BASE_URL . "users");
                    exit;
                } else {
                    $data['errorMsg'] = "Usuários já existe!";
                }

            }

            $data['groupsList'] = $p->getGroupsList($u->getCompany());
            $this->loadTemplate('usersAdd', $data);
            exit;
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    public function edit($id)
    {
        if (!empty($id)) {
            $data = [];
            $u = new Users();
            $u->setLoggedUser();
            $comp = new Companies($u->getCompany());
            $data['companyName'] = $comp->getName();
            $data['userEmail'] = $u->getEmail();
            if ($u->hasPerssion("usersView")) {
                $p = new Permissions();

                if (!empty($_POST['group'])) {
                    $group = addslashes($_POST['group']);
                    $u->update($group, $id, $u->getCompany());
                    if (!empty($_POST['password'])) {
                        $pass = md5($_POST['password']);
                        $u->updatePass($pass, $id, $u->getCompany());
                    }
                    header("Location: " . BASE_URL . "users");
                    exit;
                }

                $data['userInfo'] = $u->getInfo($id, $u->getCompany());
                $data['groupsList'] = $p->getGroupsList($u->getCompany());
                $this->loadTemplate('usersEdit', $data);
                exit;
            } else {
                header("Location: " . BASE_URL);
                exit;
            }
        }else{
            header("Location: ".BASE_URL."users");
            exit;
        }
    }
    public function del($id)
    {
        if (!empty($id)) {
            $data = [];
            $u = new Users();
            $u->setLoggedUser();
            $comp = new Companies($u->getCompany());
            $data['companyName'] = $comp->getName();
            $data['userEmail'] = $u->getEmail();
            if ($u->hasPerssion("usersView")) {
                $u->del($id, $u->getCompany());
                header("Location: ".BASE_URL."users");
                exit;
            } else {
                header("Location: " . BASE_URL);
                exit;
            }
        }else{
            header("Location: ".BASE_URL."users");
            exit;
        }
    }

}
