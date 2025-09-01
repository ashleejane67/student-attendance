<?php
require_once "db.php";

class Student {
    private $conn;
    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }
    public function add($name) {
        $stmt = $this->conn->prepare("INSERT INTO students (name) VALUES (:name)");
        $stmt->execute(['name'=>$name]);
    }
    public function all() {
        return $this->conn->query("SELECT * FROM students")->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE id=:id");
        $stmt->execute(['id'=>$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function update($id,$name) {
        $stmt = $this->conn->prepare("UPDATE students SET name=:name WHERE id=:id");
        $stmt->execute(['id'=>$id,'name'=>$name]);
    }
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM students WHERE id=:id");
        $stmt->execute(['id'=>$id]);
    }
}
?>
