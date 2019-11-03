<?php
class Sales extends Model
{
    public function getList($offset, $comp)
    {
        $array = [];
        $sql = $this->db->prepare("SELECT *,(SELECT clients.name from clients WHERE clients.Id = sales.id_client) as nameClient FROM sales WHERE id_company = :comp ORDER BY date_sale DESC LIMIT :oft, 10");
        $sql->bindValue(":comp", $comp);
        $sql->bindValue(":oft", $offset, PDO::PARAM_INT);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }
    public function getInfo($id, $comp)
    {
        $array = [];
        $sql = $this->db->prepare("SELECT *, (SELECT clients.name FROM clients WHERE sales.id_client = clients.Id) as clientName FROM sales WHERE Id = :id AND id_company = :comp");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array['info'] = $sql->fetch(PDO::FETCH_ASSOC);
            $sql = $this->db->prepare("SELECT *,(SELECT inventory.name FROM inventory WHERE sales_products.id_product = inventory.Id) as productName FROM sales_products WHERE id_sale = :id AND id_company = :comp");
            $sql->bindValue(":id", $id);
            $sql->bindValue(":comp", $comp);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $array['products'] = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        return $array;

    }
    public function updateSale($comp, $id, $status)
    {
        $sql = $this->db->prepare("UPDATE sales SET status = :status WHERE Id = :id AND id_company = :comp");
        $sql->bindValue(":status", $status);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
    }
    public function addSale($comp, $cli, $user, $quant, $status)
    {
        $i = new Inventory();
        $totalPrice = 0;

        $sql = $this->db->prepare("INSERT INTO sales SET id_company = :comp, id_client = :cli, id_user = :user, date_sale = NOW(), total_price = :price, status = :status");
        $sql->bindValue(":comp", $comp);
        $sql->bindValue(":cli", $cli);
        $sql->bindValue(":user", $user);
        $sql->bindValue(":price", $totalPrice);
        $sql->bindValue(":status", $status);
        $sql->execute();
        $idSale = $this->db->lastInsertId();
        $totalPrice = 0;
        foreach ($quant as $key => $value) {
            $sql = $this->db->prepare("SELECT price FROM inventory WHERE Id = ? AND id_company = ?");
            $sql->execute([$key, $comp]);
            if ($sql->rowCount() > 0) {
                $row = $sql->fetch();
                $price = $row['price'];
                $sql = $this->db->prepare("INSERT INTO sales_products SET id_company = :comp, id_sale = :sale, id_product = :prod, quant = :quant, sale_price = :price");
                $sql->bindValue(":comp", $comp);
                $sql->bindValue(":sale", $idSale);
                $sql->bindValue(":prod", $key);
                $sql->bindValue(":quant", $value);
                $sql->bindValue(":price", $price);
                $sql->execute();
                $i->decrease($key, $comp, $value, $user);
                $totalPrice += $price * $value;
            }

        }
        $sql = $this->db->prepare("UPDATE sales SET total_price = :price WHERE Id = :id AND id_company = :comp");
        $sql->bindValue(":price", $totalPrice);
        $sql->bindValue(":id", $idSale);
        $sql->bindValue(":comp", $comp);
        $sql->execute();

    }

    public function getSalesFiltered($clientName, $period1, $period2, $status, $order, $comp)
    {
        $array = [];
        $sql = "SELECT s.*, c.name as nameClient FROM  sales s
            LEFT JOIN clients c ON c.Id = s.id_client
            WHERE ";
        $where = [];
        $where[] = "s.id_company = :comp";
        if (!empty($clientName)) {
            $where[] = "c.name LIKE :cName";
        }
        if (!empty($period1) && !empty($period2)) {
            $where[] = "s.date_sale BETWEEN :p1 AND :p2";
        }
        if ($status != "") {
            $where[] = "s.status = :status";
        }
        $sql .= implode(" AND ", $where);
        switch ($order) {
            case 'dateDesc':
            default:
                $sql .= " ORDER BY s.date_sale DESC";
                break;
            case 'dateAsc':
                $sql .= " ORDER BY s.date_sale ASC";
                break;
            case 'status':
                $sql .= " ORDER BY s.status";
                break;
        }
        $sql = $this->db->prepare($sql);
        $sql->bindValue(":comp", $comp);
        if (!empty($clientName)) {
            $sql->bindValue(":cName", "%" . $clientName . "%");
        }
        if (!empty($period1) && !empty($period2)) {
            $sql->bindValue(":p1", $period1);
            $sql->bindValue(":p2", $period2);
        }
        if ($status != "") {
            $sql->bindValue(":status", $status);
        }
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }

    public function getTotalRevenue($p1, $p2, $comp)
    {
        $float = 0.0;
        $sql = $this->db->prepare("SELECT SUM(total_price) as total FROM sales WHERE date_sale BETWEEN :p1 AND :p2 AND id_company = :comp");
        $sql->bindValue(":p1", $p1);
        $sql->bindValue(":p2", $p2);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $float = (Float) $sql['total'];
        }
        return $float;
    }
    public function getTotalExpenses($p1, $p2, $comp)
    {
        $float = 0.0;
        $sql = $this->db->prepare("SELECT SUM(total_price) as total FROM purchases WHERE date_purchase BETWEEN :p1 AND :p2 AND id_company = :comp");
        $sql->bindValue(":p1", $p1);
        $sql->bindValue(":p2", $p2);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $float = (Float) $sql['total'];
        }
        return $float;
    }
    public function getSoldProducts($p1, $p2, $comp)
    {
        $int = 0;
        $sql = $this->db->prepare("SELECT Id FROM sales WHERE date_sale BETWEEN :p1 AND :p2 AND id_company = :comp");
        $sql->bindValue(":p1", $p1);
        $sql->bindValue(":p2", $p2);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $p = [];
            foreach ($sql->fetchAll() as $sI) {
                $p[] = $sI['Id'];
            }
            $sql = $this->db->prepare("SELECT COUNT(1) as total FROM sales_products WHERE id_sale IN(" . implode(",", $p) . ")");
            $sql->execute();
            $sql = $sql->fetch();
            $int = $sql['total'];

        }

        return $int;
    }
    public function getRevenueList($p1, $p2, $comp)
    {
        $array = [];
        $currentDay = $p1;
        while ($p2 != $currentDay) {
            $array[$currentDay] = 0;
            $currentDay = date('Y-m-d', strtotime($currentDay." +1 day"));
        }

        $sql = $this->db->prepare("SELECT DATE_FORMAT(date_sale,'%Y-%m-%d') as date_sale, SUM(total_price) as total FROM sales WHERE date_sale BETWEEN :p1 AND :p2 AND id_company = :comp GROUP BY DATE_FORMAT(date_sale,'%Y-%m-%d')");
        $sql->bindValue(":p1", $p1);
        $sql->bindValue(":p2", $p2);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $sI) {
                $array[$sI['date_sale']] = $sI['total'];
            }
        }
        return $array;
    }
    public function getPaymentsList($p1, $p2, $comp)
    {
        $array = [
            '0'=>0,
            '1'=>0,
            '2'=>0
        ];

        $sql = $this->db->prepare("SELECT COUNT(1) as total, status FROM sales WHERE date_sale BETWEEN :p1 AND :p2 AND id_company = :comp GROUP BY status ORDER BY status ASC");
        $sql->bindValue(":p1", $p1);
        $sql->bindValue(":p2", $p2);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $sI) {
                $array[$sI['status']] = $sI['total'];
            }
        }
        return $array;
    }
    public function getExpensesList($p1, $p2, $comp)
    {
        $array = [];
        $currentDay = $p1;
        while ($p2 != $currentDay) {
            $array[$currentDay] = 0;
            $currentDay = date('Y-m-d', strtotime($currentDay." +1 day"));
        }

        $sql = $this->db->prepare("SELECT DATE_FORMAT(date_purchase,'%Y-%m-%d') as date_purchase, SUM(total_price) as total FROM purchases WHERE date_purchase BETWEEN :p1 AND :p2 AND id_company = :comp GROUP BY DATE_FORMAT(date_purchase,'%Y-%m-%d')");
        $sql->bindValue(":p1", $p1);
        $sql->bindValue(":p2", $p2);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $sI) {
                $array[$sI['date_purchase']] = $sI['total'];
            }
        }
        return $array;
    }
}
