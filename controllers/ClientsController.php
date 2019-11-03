<?php

class ClientsController extends controller
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
        $data['companyName'] = $comp->getName();
        $data['userEmail'] = $u->getEmail();
        if ($u->hasPerssion("clientsView")) {
            $c = new Clients();
            $p = $_GET['p'] ?? 1;
            $p = (int) $p;
            if ($p == 0) {
                $p = 1;
            }
            $offset = (10 * ($p - 1));
            $data['pag'] = $p;
            $data['clientsList'] = $c->getList($offset, $u->getCompany());
            $data['clientsCount'] = $c->getCount($u->getCompany());
            $data['pCount'] = ceil($data['clientsCount'] / 10);
            $data['editPermission'] = $u->hasPerssion("clientsEdit");
            $this->loadTemplate('clients', $data);
            exit;
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    public function del($id)
    {
        if (!empty($id)) {
            $data = [
            ];
            $u = new Users();
            $u->setLoggedUser();
            if ($u->hasPerssion("clientsEdit")) {
                $c = new Clients();
                $c->del($id, $u->getCompany());
            }
        }
        header("Location: " . BASE_URL . "clients");
        exit;
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
        if ($u->hasPerssion("clientsEdit")) {
            $c = new Clients();
            if (!empty($_POST['name'])) {
                $name = addslashes($_POST['name']);
                $email = addslashes($_POST['email']);
                $phone = addslashes($_POST['phone']);
                $stars = addslashes($_POST['stars']);
                $internalObs = addslashes($_POST['internalObs']);
                $addressZipCode = addslashes($_POST['addressZipCode']);
                $address = addslashes($_POST['address']);
                $addressNumber = addslashes($_POST['addressNumber']);
                $address2 = addslashes($_POST['address2']);
                $addressNeighb = addslashes($_POST['addressNeighb']);
                $addressCity = addslashes($_POST['addressCity']);
                $addressState = addslashes($_POST['addressState']);
                $addressCountry = addslashes($_POST['addressCountry']);
                $c->add($u->getCompany(), $name, $email, $phone, $stars, $internalObs, $addressZipCode, $address, $addressNumber,
                    $address2, $addressNeighb, $addressCity, $addressState, $addressCountry);
                header("Location: " . BASE_URL . "clients");
            }

            $this->loadTemplate('clientsAdd', $data);
            exit;
        } else {
            header("Location: " . BASE_URL . "clients");
            exit;
        }
    }
    public function edit($id)
    {
        if (!empty($id)) {
            $data = [
            ];
            $u = new Users();
            $u->setLoggedUser();
            $comp = new Companies($u->getCompany());
            $data['companyName'] = $comp->getName();
            $data['userEmail'] = $u->getEmail();
            if ($u->hasPerssion("clientsEdit")) {
                $c = new Clients();
                if (!empty($_POST['name'])) {
                    $name = addslashes($_POST['name']);
                    $email = addslashes($_POST['email']);
                    $phone = addslashes($_POST['phone']);
                    $stars = addslashes($_POST['stars']);
                    $internalObs = addslashes($_POST['internalObs']);
                    $addressZipCode = addslashes($_POST['addressZipCode']);
                    $address = addslashes($_POST['address']);
                    $addressNumber = addslashes($_POST['addressNumber']);
                    $address2 = addslashes($_POST['address2']);
                    $addressNeighb = addslashes($_POST['addressNeighb']);
                    $addressCity = addslashes($_POST['addressCity']);
                    $addressState = addslashes($_POST['addressState']);
                    $addressCountry = addslashes($_POST['addressCountry']);
                    $c->update($id, $u->getCompany(), $name, $email, $phone, $stars, $internalObs, $addressZipCode, $address, $addressNumber,
                        $address2, $addressNeighb, $addressCity, $addressState, $addressCountry);
                    header("Location: " . BASE_URL . "clients");
                }
                $data['clientInfo'] = $c->getInfo($id, $u->getCompany());

                $this->loadTemplate('clientsEdit', $data);
                exit;
            } else {
                header("Location: " . BASE_URL . "clients");
                exit;
            }
        } else {
            header();
        }
    }

}
