<?php

class ReportController extends controller
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
        if ($u->hasPerssion("reportView")) {

            $this->loadTemplate("report", $data);
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    public function sales()
    {
        $data = [];
        $u = new Users();
        $u->setLoggedUser();
        $comp = new Companies($u->getCompany());
        $data['companyName'] = $comp->getName();
        $data['userEmail'] = $u->getEmail();
        if ($u->hasPerssion("reportView")) {
            $data['statuses'] = [
                "0" => "Aguardando Pagamento",
                "1" => "Pago",
                "2" => "Cancelado",
            ];

            $this->loadTemplate("reportSales", $data);
        } else {
            header("Location: " . BASE_URL);
            exit;
        }

    }
    public function salesPdf()
    {
        $data = [];
        $u = new Users();
        $u->setLoggedUser();
        if ($u->hasPerssion("reportView")) {
            $data['statuses'] = [
                "0" => "Aguardando Pagamento",
                "1" => "Pago",
                "2" => "Cancelado",
            ];
            $clientName = addslashes($_GET['clientName']);
            $period1 = addslashes($_GET['period1']);
            $period2 = addslashes($_GET['period2']);
            $status = addslashes($_GET['status']);
            $order = addslashes($_GET['order']);
            $s = new Sales();
            $data['salesList'] = $s->getSalesFiltered($clientName, $period1, $period2, $status, $order, $u->getCompany());
            $data['filters'] = $_GET;
            ob_start();
            $this->loadView("reportSalesPdf", $data);
            $html = ob_get_contents();
            ob_end_clean();
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }
    public function inventory()
    {
        $data = [];
        $u = new Users();
        $u->setLoggedUser();
        $comp = new Companies($u->getCompany());
        $data['companyName'] = $comp->getName();
        $data['userEmail'] = $u->getEmail();
        if ($u->hasPerssion("reportView")) {

            $this->loadTemplate("reportInventory", $data);
        } else {
            header("Location: " . BASE_URL);
            exit;
        }

    }
    public function inventoryPdf()
    {
        $data = [];
        $u = new Users();
        $u->setLoggedUser();
        if ($u->hasPerssion("reportView")) {
            $i = new Inventory();
            $data['inventoryList'] = $i->getInventoryFiltered($u->getCompany());
            $data['filters'] = $_GET;
            ob_start();
            $this->loadView("reportInventoryPdf", $data);
            $html = ob_get_contents();
            ob_end_clean();
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($html);
            $mpdf->Output();
        } else {
            header("Location: " . BASE_URL);
            exit;
        }
    }

}
