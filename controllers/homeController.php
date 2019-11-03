<?php

class homeController extends controller {

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
        $data['companyName'] = $comp->getName();
        $data['userEmail'] = $u->getEmail();
        $data['statuses'] = [
            "0" => "Aguardando Pagamento",
            "1" => "Pago",
            "2" => "Cancelado",
        ];
        $s = new Sales();

        $data['productsSold'] = $s->getSoldProducts(date('Y-m-d',strtotime("-30 days")), date('Y-m-d'), $u->getCompany());
        $data['revenue'] = $s->getTotalRevenue(date('Y-m-d',strtotime("-30 days")), date('Y-m-d'), $u->getCompany());
        $data['expenses'] = $s->getTotalExpenses(date('Y-m-d',strtotime("-30 days")), date('Y-m-d'), $u->getCompany());

        $data['daysList'] = [];
        for($q=30;$q>0;$q--){
            $data['daysList'][] = date('d/m',strtotime("-".$q." days"));
        }
        $data['revenueList'] = $s->getRevenueList(date('Y-m-d',strtotime("-30 days")), date('Y-m-d'),$u->getCompany());
        $data['expensesList'] = $s->getExpensesList(date('Y-m-d',strtotime("-30 days")), date('Y-m-d'),$u->getCompany());
        $data['paymentsList'] = $s->getPaymentsList(date('Y-m-d',strtotime("-30 days")), date('Y-m-d'),$u->getCompany());



        $this->loadTemplate('home', $data);
    }

}
