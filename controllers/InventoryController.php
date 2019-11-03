<?php

class InventoryController extends controller
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
        $data = [];
        $u = new Users();
        $u->setLoggedUser();
        $comp = new Companies($u->getCompany());
        $data['companyName'] = $comp->getName();
        $data['userEmail'] = $u->getEmail();
        if ($u->hasPerssion("inventoryView")) {
            $i = new Inventory();
            $data['addPermission'] = $u->hasPerssion("inventoryAdd");
            $data['editPermission'] = $u->hasPerssion("inventoryEdit");
            $p = $_GET['p'] ?? 1;
            $p = (int) $p;
            if ($p == 0) {
                $p = 1;
            }
            $offset = (10 * ($p - 1));
            $data['inventoryList'] = $i->getList($offset, $u->getCompany());
            $this->loadTemplate("inventory", $data);
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    public function add()
    {
        $data = [];
        $u = new Users();
        $u->setLoggedUser();
        $comp = new Companies($u->getCompany());
        $data['companyName'] = $comp->getName();
        $data['userEmail'] = $u->getEmail();
        if ($u->hasPerssion("inventoryAdd")) {
            $i = new Inventory();
            if (!empty($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $price = (Double) str_replace(",", ".", str_replace(".", "", addslashes($_POST['price'])));
                $quant = (int) addslashes($_POST['quant']);
                $minQuant = (int) addslashes($_POST['minQuant']);
                $i->add($name, $price, $quant, $minQuant, $u->getCompany(), $u->getId());
                header("Location: " . BASE_URL . "inventory");
                exit;
            }

            $this->loadTemplate("inventoryAdd", $data);
        } else {
            header("Location: " . BASE_URL . "inventory");
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
            if ($u->hasPerssion("inventoryEdit")) {
                $i = new Inventory();
                if (!empty($_POST['name'])) {
                    $name = addslashes($_POST['name']);
                    $price = (Double) str_replace(",", ".", str_replace(".", "", addslashes($_POST['price'])));
                    $quant = (int) addslashes($_POST['quant']);
                    $minQuant = (int) addslashes($_POST['minQuant']);
                    $i->edit($id, $name, $price, $quant, $minQuant, $u->getCompany(), $u->getId());
                    header("Location: " . BASE_URL . "inventory");
                    exit;
                }
                $data['inventoryInfo'] = $i->getProduct($id, $u->getCompany());

                $this->loadTemplate("inventoryEdit", $data);
            } else {
                header("Location: " . BASE_URL . "inventory");
                exit;
            }
        } else {
            header("Location: " . BASE_URL . "inventory");
            exit;
        }
    }
    public function del($id)
    {
        if (!empty($id)) {
            $u = new Users();
            $u->setLoggedUser();
            if ($u->hasPerssion("inventoryEdit")) {
                $i = new Inventory();
                $i->del($id, $u->getCompany(), $u->getId());
            }
        }
        header("Location: " . BASE_URL . "inventory");
        exit;

    }

}
