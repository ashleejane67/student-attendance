<?php
require_once "db.php";

class Attendance {
    private $conn;
    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }
    public function mark($student_id,$status) {
        $stmt = $this->conn->prepare("INSERT INTO attendance (student_id,status) VALUES (:student_id,:status)");
        $stmt->execute(['student_id'=>$student_id,'status'=>$status]);
    }
    public function all() {
        $sql = "SELECT a.id, s.name, a.student_id, a.status, a.date 
                FROM attendance a JOIN students s ON a.student_id=s.id";
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM attendance WHERE id=:id");
        $stmt->execute(['id'=>$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function update($id,$student_id,$status) {
        $stmt = $this->conn->prepare("UPDATE attendance SET student_id=:student_id, status=:status WHERE id=:id");
        $stmt->execute(['id'=>$id,'student_id'=>$student_id,'status'=>$status]);
    }
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM attendance WHERE id=:id");
        $stmt->execute(['id'=>$id]);
    }
}
?>
