<?php

class SalesController extends controller
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
        if ($u->hasPerssion("salesView")) {
            $s = new Sales();
            $data['addPermission'] = $u->hasPerssion("salesAdd");
            $data['editPermission'] = $u->hasPerssion("salesEdit");
            $data['statuses'] = [
                "0" => "Aguardando Pagamento",
                "1" => "Pago",
                "2" => "Cancelado",
            ];
            $p = $_GET['p'] ?? 1;
            $p = (int) $p;
            if ($p == 0) {
                $p = 1;
            }
            $offset = (10 * ($p - 1));
            $data['salesList'] = $s->getList($offset, $u->getCompany());
            $this->loadTemplate("sales", $data);
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
        if ($u->hasPerssion("salesAdd")) {
            $s = new Sales();
            if (!empty($_POST['clientId'])) {
                $idClient = addslashes($_POST['clientId']);
                $status = addslashes($_POST['status']);
                $quant = $_POST['quant'];

                //echo "<pre>";
                //print_r($_POST);
                //exit;

                //$totalPrice = (Double) str_replace(",", ".", str_replace(".", "", $_POST['totalPrice']));
                $s->addSale($u->getCompany(), $idClient, $u->getId(), $quant, $status);
                header("Location: " . BASE_URL . "sales");
                exit;
            }

            $this->loadTemplate("salesAdd", $data);
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    public function edit($id)
    {
        $data = [];
        $u = new Users();
        $u->setLoggedUser();
        $comp = new Companies($u->getCompany());
        $data['companyName'] = $comp->getName();
        $data['userEmail'] = $u->getEmail();
        if ($u->hasPerssion("salesView")) {
            $s = new Sales();
            $data['permissionEdit'] = $u->hasPerssion("salesEdit");
            if (isset($_POST['status']) && $data['permissionEdit']) {
                $status = addslashes($_POST['status']);

                $s->updateSale($u->getCompany(), $id, $status);
                header("Location: " . BASE_URL . "sales");
                exit;
            }
            $data['statuses'] = [
                "0" => "Aguardando Pagamento",
                "1" => "Pago",
                "2" => "Cancelado",
            ];
            $data['salesInfo'] = $s->getInfo($id, $u->getCompany());
            

            $this->loadTemplate("salesEdit", $data);
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }

}
