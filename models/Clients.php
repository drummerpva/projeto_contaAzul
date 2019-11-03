<?php
class Clients extends Model
{
    public function getList($offset, $comp)
    {
        $array = [];
        $sql = $this->db->prepare("SELECT * FROM clients WHERE id_company = :comp LIMIT :offset, 10");
        $sql->bindValue(":comp", $comp, PDO::PARAM_INT);
        $sql->bindValue(":offset", $offset, PDO::PARAM_INT);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }
    public function searchClientByName($name, $comp)
    {
        $array = [];
        $sql = $this->db->prepare("SELECT Id, name FROM clients WHERE id_company = :comp AND name LIKE :name LIMIT 20");
        $sql->bindValue(":comp", $comp);
        $sql->bindValue(":name", "%" . $name . "%");
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }
        return $array;
    }
    public function getCount($comp)
    {
        $sql = $this->db->prepare("SELECT COUNT(1) as c FROM clients WHERE id_company = :comp");
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        $sql = $sql->fetch();
        return $sql['c'];
    }

    public function add($comp, $name, $email = "", $phone = "", $stars = "3", $internalObs = "", $addressZipCode = "", $address = "", $addressNumber = "",
        $address2 = "", $addressNeighb = "", $addressCity = "", $addressState = "", $addressCountry = "") {
        $sql = $this->db->prepare("INSERT INTO clients(id_company, name, email, phone, stars, internal_obs, address_zipcode, address, addressNumber, address2, address_neighb, address_city, address_state, address_country) VALUES(:comp, :name, :email, :phone, :stars, :internal_obs, :address_zipcode, :address, :addressNumber, :address2, :address_neighb, :address_city, :address_state, :address_country)");
        $sql->bindValue(":comp", $comp);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":phone", $phone);
        $sql->bindValue(":stars", $stars);
        $sql->bindValue(":internal_obs", $internalObs);
        $sql->bindValue(":address_zipcode", $addressZipCode);
        $sql->bindValue(":address", $address);
        $sql->bindValue(":addressNumber", $addressNumber);
        $sql->bindValue(":address2", $address2);
        $sql->bindValue(":address_neighb", $addressNeighb);
        $sql->bindValue(":address_city", $addressCity);
        $sql->bindValue(":address_state", $addressState);
        $sql->bindValue(":address_country", $addressCountry);
        $sql->execute();
        return $this->db->lastInsertId();
    }

    public function update($id, $comp, $name, $email, $phone, $stars, $internalObs, $addressZipCode, $address, $addressNumber,
        $address2, $addressNeighb, $addressCity, $addressState, $addressCountry) {
        $sql = $this->db->prepare("UPDATE clients  SET name = :name, email = :email, phone = :phone, stars = :stars, internal_obs = :internal_obs, address_zipcode = :address_zipcode, address = :address, addressNumber = :addressNumber, address2 = :address2, address_neighb = :address_neighb, address_city = :address_city, address_state = :address_state, address_country = :address_country WHERE Id = :id AND id_company = :comp");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":phone", $phone);
        $sql->bindValue(":stars", $stars);
        $sql->bindValue(":internal_obs", $internalObs);
        $sql->bindValue(":address_zipcode", $addressZipCode);
        $sql->bindValue(":address", $address);
        $sql->bindValue(":addressNumber", $addressNumber);
        $sql->bindValue(":address2", $address2);
        $sql->bindValue(":address_neighb", $addressNeighb);
        $sql->bindValue(":address_city", $addressCity);
        $sql->bindValue(":address_state", $addressState);
        $sql->bindValue(":address_country", $addressCountry);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
    }

    public function getInfo($id, $comp)
    {
        $array = [];
        $sql = $this->db->prepare("SELECT * FROM clients WHERE Id = :id AND id_company = :comp");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }
        return $array;
    }
    public function del($id, $comp)
    {
        $sql = $this->db->prepare("DELETE FROM clients WHERE Id = :id AND id_company = :comp");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
    }

}
