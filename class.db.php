<?php
class database
{
    private $db;

    private function connectdb()
    {
        try {

            $login = 'root';
            $pass = '';
            $connect = "mysql:host=localhost;dbname=login";
            $this->db = new PDO($connect, $login, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    function __construct()
    {
        $this->connectdb();
    }
    public function add($id, $password, $role)
    {
        $sql = "INSERT INTO reslogin (id, password, role) 
        VALUES (:id, :password,:role)";
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);

            $result=$stmt->execute();
            return $result;
        } catch (PDOException $e) {
            return array("status" => "error", "message" => $e->getMessage());
        }
    }
    public function login($id, $password)
    {
        try {
            $stmt = $this->db->prepare("SELECT id , role FROM reslogin WHERE id = :id AND password = :password");
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':password', $password);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                return $rows;
                
            } 
            else {
                return array("status" => "error", "message"=>"incorrect id or password" );
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function edit($data)
    {
        try {
            $stmt = $this->db->prepare("UPDATE reslogin SET 
            password = ?,
            role = ?  
            WHERE id = ?");
            $result= $stmt->execute([
            $data['password'],
            $data['role'],
            $data['id']]);
            echo json_encode(['message' => 'Record updated successfully']);
            return $result;

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
     
    }
    public function del($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM reslogin WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->rowCount(); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function show()
    {
    
        try {
            $sql = "SELECT * FROM `reslogin`ORDER BY id  ";
            $res = $this->db->query($sql);
            $data = $res->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $data;
    }
}
