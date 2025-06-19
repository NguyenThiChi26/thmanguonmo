<?php
class AccountModel
{
    private $conn;
    private $table_name = "account";
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function getAccountByUsername($username)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username 
LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
    public function save($username, $fullName, $password, $role = 'user')
    {
        if ($this->getAccountByUsername($username)) {
            return false;
        }
        $query = "INSERT INTO " . $this->table_name . " SET username=:username, 
fullname=:fullname, password=:password, role=:role";
        $stmt = $this->conn->prepare($query);
        $username = htmlspecialchars(strip_tags($username));
        $fullName = htmlspecialchars(strip_tags($fullName));
        $password = password_hash($password, PASSWORD_BCRYPT);
        $role = htmlspecialchars(strip_tags($role));
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":fullname", $fullName);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":role", $role);
        return $stmt->execute();
    }
    public function update($username, $fullName, $password = null, $email = null, $phone = null, $address = null, $image = null)
    {
        $query = "UPDATE " . $this->table_name . " SET fullname=:fullname";
        
        if ($password) {
            $query .= ", password=:password";
        }
        if ($email) {
            $query .= ", email=:email";
        }
        if ($phone) {
            $query .= ", phone=:phone";
        }
        if ($address) {
            $query .= ", address=:address";
        }
        if ($image) {
            $query .= ", image=:image";
        }
        
        $query .= " WHERE username=:username";

        $stmt = $this->conn->prepare($query);
        
        $username = htmlspecialchars(strip_tags($username));
        $fullName = htmlspecialchars(strip_tags($fullName));
        if ($email) {
            $email = htmlspecialchars(strip_tags($email));
            $stmt->bindParam(":email", $email);
        }
        if ($phone) {
            $phone = htmlspecialchars(strip_tags($phone));
            $stmt->bindParam(":phone", $phone);
        }
        if ($address) {
            $address = htmlspecialchars(strip_tags($address));
            $stmt->bindParam(":address", $address);
        }
        if ($image) {
            $image = htmlspecialchars(strip_tags($image));
            $stmt->bindParam(":image", $image);
        }
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":fullname", $fullName);
        
        if ($password) {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $stmt->bindParam(":password", $password);
        }

        return $stmt->execute();
    }
    public function getAccountById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getList()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function delete($username)
    {
        $account = $this->getAccountByUsername($username);
        if (!$account || $account->role === 'admin') {
            return false;
        }

        $query = "DELETE FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        return $stmt->execute();
    }
}
