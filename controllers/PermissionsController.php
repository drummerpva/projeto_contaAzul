<?php

class PermissionsController extends controller {

    public function __construct() {
        $u = new Users();
        if (!$u->isLogged()) {
            header("Location: " . BASE_URL . "login");
            exit;
        }
    }

    public function index() {
        $data = [
        ];
        $u = new Users();
        $u->setLoggedUser();
        $comp = new Companies($u->getCompany());
        if ($u->hasPerssion("permissionsView")) {
            $p = new Permissions();
            $data['permissionsList'] = $p->getList($u->getCompany());
            $data['permissionsGroupsList'] = $p->getGroupsList($u->getCompany());
            $data['companyName'] = $comp->getName();
            $data['userEmail'] = $u->getEmail();

            $this->loadTemplate('permissions', $data);
            exit;
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }

    public function add() {
        $data = [
        ];
        $u = new Users();
        $u->setLoggedUser();
        $comp = new Companies($u->getCompany());
        if ($u->hasPerssion("permissionsView")) {
            $p = new Permissions();
            if (!empty($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $p->add($name, $u->getCompany());
                header("Location: " . BASE_URL . "permissions");
                exit;
            }
            $data['companyName'] = $comp->getName();
            $data['userEmail'] = $u->getEmail();


            $this->loadTemplate('permissionAdd', $data);
            exit;
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }

    public function addGroup() {
        $data = [
        ];
        $u = new Users();
        $u->setLoggedUser();
        $comp = new Companies($u->getCompany());
        if ($u->hasPerssion("permissionsView")) {
            $p = new Permissions();
            if (!empty($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $permissions = $_POST['permissions'] ?? [];
                $permissions = implode(",", $permissions);
                $p->addGroup($name, $permissions,$u->getCompany());
                header("Location: " . BASE_URL . "permissions");
                exit;
            }
            $data['companyName'] = $comp->getName();
            $data['userEmail'] = $u->getEmail();
            $data['permissionsList'] = $p->getList($u->getCompany());


            $this->loadTemplate('permissionAddGroup', $data);
            exit;
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    public function editGroup($id) {
        $data = [
        ];
        $u = new Users();
        $u->setLoggedUser();
        $comp = new Companies($u->getCompany());
        if ($u->hasPerssion("permissionsView")) {
            $p = new Permissions();
            if (!empty($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $permissions = $_POST['permissions'] ?? [];
                $permissions = implode(",", $permissions);
                $p->editGroup($name, $permissions,$id);
                header("Location: " . BASE_URL . "permissions");
                exit;
            }
            $data['companyName'] = $comp->getName();
            $data['userEmail'] = $u->getEmail();
            $data['permissionsList'] = $p->getList($u->getCompany());
            $data['groupInfo'] = $p->getGroup($id, $u->getCompany());

            $this->loadTemplate('permissionEditGroup', $data);
            exit;
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }

    public function del($id) {
        $u = new Users();
        $u->setLoggedUser();
        if (!empty($id) && $u->hasPerssion("permissionsView")) {
            $p = new Permissions();
            $p->del($id);
        }
        header("Location: " . BASE_URL . "permissions");
        exit;
    }

    public function delGroup($id) {
        $u = new Users();
        $u->setLoggedUser();
        if (!empty($id) && $u->hasPerssion("permissionsView")) {
            $p = new Permissions();
            $p->delGroup($id);
        }
        header("Location: " . BASE_URL . "permissions");
        exit;
    }

}
