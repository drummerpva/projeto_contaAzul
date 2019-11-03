<?php
class Inventory extends Model
{
    public function getList($offset, $comp)
    {
        $array = [];
        $sql = $this->db->prepare("SELECT * FROM inventory WHERE id_company = :comp LIMIT :offset, 10");
        $sql->bindValue(":comp", $comp, PDO::PARAM_INT);
        $sql->bindValue(":offset", $offset, PDO::PARAM_INT);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }
    public function decrease($prod, $comp, $qt, $user)
    {
        $sql = $this->db->prepare("UPDATE inventory SET quant = quant - :q WHERE Id = :id AND id_company = :comp");
        $sql->bindValue(":q", $qt, PDO::PARAM_INT);
        $sql->bindValue(":id", $prod);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        $this->setHistory($prod, $user, "dwn", $comp);
    }
    public function searchProductsByName($name, $comp)
    {
        $array = [];
        $sql = $this->db->prepare("SELECT Id, name, price FROM inventory WHERE id_company = :comp AND name LIKE :name LIMIT 20");
        $sql->bindValue(":comp", $comp);
        $sql->bindValue(":name", "%" . $name . "%");
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;

    }

    public function getProduct($id, $comp)
    {
        $array = [];
        $sql = $this->db->prepare("SELECT * FROM inventory WHERE Id = :id AND id_company = :comp");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function add($name, $price, $quant, $minQuant, $comp, $idUser)
    {
        $sql = $this->db->prepare("INSERT INTO inventory SET name = :name, price = :price, quant = :quant, min_quant = :minQuant, id_company = :comp");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":price", $price);
        $sql->bindValue(":quant", $quant);
        $sql->bindValue(":minQuant", $minQuant);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        $idProd = $this->db->lastInsertId();

        //adicionar histórico
        $this->setHistory($idProd, $idUser, "add", $comp);
    }
    public function edit($id, $name, $price, $quant, $minQuant, $comp, $idUser)
    {
        $sql = $this->db->prepare("UPDATE inventory SET name = :name, price = :price, quant = :quant, min_quant = :minQuant WHERE Id = :id AND id_company = :comp");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":price", $price);
        $sql->bindValue(":quant", $quant);
        $sql->bindValue(":minQuant", $minQuant);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        $idProd = $id;

        //adicionar histórico
        $this->setHistory($idProd, $idUser, "edt", $comp);
    }
    public function del($id, $comp, $idUser)
    {
        $sql = $this->db->prepare("DELETE FROM inventory WHERE Id = :id AND id_company = :comp");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        $idProd = $id;

        //adicionar histórico
        $this->setHistory($idProd, $idUser, "del", $comp);
    }
    public function setHistory($idProd, $idUser, $action, $comp)
    {
        $sql = $this->db->prepare("INSERT INTO inventory_history SET id_product = :prod, id_user = :user, action = :action, date_action = NOW(), id_company = :comp");
        $sql->bindValue(":prod", $idProd);
        $sql->bindValue(":user", $idUser);
        $sql->bindValue(":action", $action);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
    }

    public function getInventoryFiltered($comp)
    {
        $array = [];
        $sql = $this->db->prepare("SELECT *,(min_quant - quant) as dif FROM inventory WHERE quant <= min_quant AND id_company = :comp ORDER BY dif DESC");
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }
}
