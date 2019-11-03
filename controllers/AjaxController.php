<?php

class AjaxController extends controller
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
    {}
    public function searchClients()
    {
        $data = [
        ];
        $u = new Users();
        $u->setLoggedUser();
        $c = new Clients();
        if (!empty($_GET['q'])) {
            $q = addslashes($_GET['q']);
            $clients = $c->searchClientByName($q, $u->getCompany());
            foreach ($clients as $cItem) {
                $data[] = [
                    "name" => $cItem['name'],
                    "link" => BASE_URL . "clients/edit/" . $cItem['Id'],
                    "id" => $cItem['Id'],
                ];
            }
        }

        echo json_encode($data);
        exit;
    }
    public function searchProducts()
    {
        $data = [
        ];
        $u = new Users();
        $u->setLoggedUser();
        $i = new Inventory();
        if (!empty($_GET['q'])) {
            $q = addslashes($_GET['q']);
            $data = $i->searchProductsByName($q, $u->getCompany());
        }

        echo json_encode($data);
        exit;
    }

    public function addClient()
    {
        $data = [];
        if (!empty($_POST['name'])) {

            $c = new Clients();
            $u = new Users();
            $u->setLoggedUser();
            $name = addslashes($_POST['name']);
            $data['id'] = $c->add($u->getCompany(), $name);

        }
        echo json_encode($data);
        exit;
    }

}
