<?php

class Companies extends Model {

    private $companyInfo;

    public function __construct($id) {
        parent::__construct();
        $sql = $this->db->prepare("SELECT * FROM companies WHERE Id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $this->companyInfo = $sql->fetch(PDO::FETCH_ASSOC);
        }
    }
    public function getName(){
        if(!empty($this->companyInfo['name'])){
            return $this->companyInfo['name'];
        }else{
            return ""; 
        }
    }

}
