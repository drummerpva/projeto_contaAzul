<?php

class Permissions extends Model {

    private $group;
    private $permissions = [];

    public function setGroup($idG, $idC) {
        $this->group = $idG;
        $sql = $this->db->prepare("SELECT params FROM permission_groups WHERE Id = :id AND id_company = :idC");
        $sql->bindValue(":id", $idG);
        $sql->bindValue(":idC", $idC);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $row = $sql->fetch();
            if (empty($row['params'])) {
                $row['params'] = 0;
            }
            $sql = $this->db->prepare("SELECT name FROM permission_params WHERE Id IN ({$row['params']}) AND id_company = :idC");
            $sql->bindValue(":idC", $idC);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                foreach ($sql->fetchAll() as $i) {
                    $this->permissions[] = $i['name'];
                }
            }
        }
    }

    public function add($name, $idC) {
        $sql = $this->db->prepare("INSERT INTO permission_params(name, id_company) VALUES(:name, :idC)");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":idC", $idC);
        $sql->execute();
    }

    public function addGroup($name, $perm, $idC) {
        $sql = $this->db->prepare("INSERT INTO permission_groups(name, params,id_company) VALUES(:name, :params,:idC)");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":params", $perm);
        $sql->bindValue(":idC", $idC);
        $sql->execute();
    }
    public function editGroup($name, $perm, $id) {
        $sql = $this->db->prepare("UPDATE permission_groups SET name = :name, params = :params WHERE Id = :id");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":params", $perm);
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function del($id) {
        $sql = $this->db->prepare("DELETE FROM permission_params WHERE Id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
    }

    public function delGroup($id) {
        $u = new Users();
        if (!$u->findUsersInGroup($id)) {
            $sql = $this->db->prepare("DELETE FROM permission_groups WHERE Id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
        }
    }

    public function hasPermission($p) {
        if (in_array($p, $this->permissions)) {
            return true;
        } else {
            return false;
        }
    }

    public function getList($comp) {
        $array = [];
        $sql = $this->db->prepare("SELECT * FROM permission_params WHERE id_company = :c");
        $sql->bindValue(":c", $comp);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }
    public function getGroupsList($comp) {
        $array = [];
        $sql = $this->db->prepare("SELECT * FROM permission_groups WHERE id_company = :c");
        $sql->bindValue(":c", $comp);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }
    public function getGroup($id,$comp) {
        $array = [];
        $sql = $this->db->prepare("SELECT * FROM permission_groups WHERE Id = :id AND id_company = :c");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":c", $comp);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(PDO::FETCH_ASSOC);
            $array['params'] = explode(",",$array['params']);
        }
                
        return $array;
    }

}
