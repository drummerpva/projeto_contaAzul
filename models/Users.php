<?php

class Users extends Model
{

    private $userInfo;
    private $permissions;

    public function isLogged()
    {
        if (!empty($_SESSION['ccUser'])) {
            return true;
        } else {
            return false;
        }
    }

    public function findUsersInGroup($idG)
    {
        $sql = $this->db->prepare("SELECT COUNT(1) as c FROM users WHERE users.group = :idG");
        $sql->bindValue(":idG", $idG, PDO::PARAM_INT);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            if ($sql['c'] > 0) {
                return true;
            } else {
                return false;
            }
        }
    }
    public function userExists($email, $comp)
    {
        $sql = $this->db->prepare("SELECT id FROM users WHERE email = :email AND id_company = :comp");
        $sql->bindValue(":email", $email);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function add($email, $pass, $group, $comp)
    {
        if (!$this->userExists($email, $comp)) {
            $sql = $this->db->prepare("INSERT INTO users(email, password, users.group, id_company) VALUES(:email, :pass, :gp, :comp)");
            $sql->bindValue(":email", $email);
            $sql->bindValue(":pass", $pass);
            $sql->bindValue(":gp", $group);
            $sql->bindValue(":comp", $comp);
            $sql->execute();
            return 1;
        } else {
            return 0;
        }
    }

    public function update($group, $id, $comp)
    {
        $sql = $this->db->prepare("UPDATE users SET users.group = :g WHERE Id = :id AND id_company = :comp");
        $sql->bindValue(":g", $group);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
    }

    public function updatePass($pass, $id, $comp)
    {
        $sql = $this->db->prepare("UPDATE users SET password = :pass WHERE Id = :id AND id_company = :comp");
        $sql->bindValue(":pass", $pass);
        $sql->bindValue(":id", $id);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
    }

    public function del($id, $comp)
    {
        $sql = $this->db->prepare("DELETE FROM users WHERE Id = :id AND id_company = :comp");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
    }

    public function setLoggedUser()
    {
        if (!empty($_SESSION['ccUser'])) {
            $id = $_SESSION['ccUser'];
            $sql = $this->db->prepare("SELECT * FROM users WHERE Id = :id");
            $sql->bindValue(":id", $id);
            $sql->execute();
            if ($sql->rowCount() > 0) {
                $this->userInfo = $sql->fetch(PDO::FETCH_ASSOC);
                $this->permissions = new Permissions();
                $this->permissions->setGroup($this->userInfo['group'], $this->userInfo['id_company']);
            }
        }
    }

    public function getInfo($id, $comp)
    {
        $array = [];
        $sql = $this->db->prepare("SELECT * FROM users WHERE Id = :id AND id_company = :comp");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function hasPerssion($p)
    {
        return $this->permissions->hasPermission($p);
    }

    public function getEmail()
    {
        if (!empty($this->userInfo['email'])) {
            return $this->userInfo['email'];
        } else {
            return "";
        }
    }
    public function getId()
    {
        if (!empty($this->userInfo['Id'])) {
            return $this->userInfo['Id'];
        } else {
            return "";
        }
    }
    public function getList($comp)
    {
        $array = [];
        $sql = $this->db->prepare("SELECT *,
            (SELECT permission_groups.name FROM permission_groups WHERE permission_groups.Id = users.group) as groupName
            FROM users WHERE id_company = :comp");
        $sql->bindValue(":comp", $comp);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll(PDO::FETCH_ASSOC);
        }

        return $array;
    }
    public function getCompany()
    {
        if (!empty($this->userInfo['id_company'])) {
            return $this->userInfo['id_company'];
        } else {
            return 0;
        }
    }

    public function doLogin($email, $pass)
    {
        $sql = $this->db->prepare("SELECT * FROM users WHERE email = :email AND password = :pass");
        $sql->bindValue(":email", $email);
        $sql->bindValue(":pass", $pass);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $_SESSION['ccUser'] = $sql['Id'];
            return true;
        } else {
            return false;
        }
    }

    public function logOut()
    {
        unset($_SESSION['ccUser']);
    }

}
