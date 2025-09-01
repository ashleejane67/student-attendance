<?php
require_once "Student.php";
require_once "Attendance.php";

$student = new Student();
$attendance = new Attendance();

if (isset($_POST['add_student'])) {
    $student->add($_POST['name']);
}
if (isset($_POST['update_student'])) {
    $student->update($_POST['id'], $_POST['name']);
}
if (isset($_GET['delete_student'])) {
    $student->delete($_GET['delete_student']);
}
if (isset($_GET['edit_student'])) {
    $editStudent = $student->getById($_GET['edit_student']);
}

if (isset($_POST['mark_attendance'])) {
    foreach ($_POST['attendance'] as $student_id => $status) {
        $attendance->mark($student_id, $status);
    }
}
if (isset($_POST['update_attendance'])) {
    $attendance->update($_POST['id'], $_POST['student_id'], $_POST['status']);
}
if (isset($_GET['delete_attendance'])) {
    $attendance->delete($_GET['delete_attendance']);
}
if (isset($_GET['edit_attendance'])) {
    $editAttendance = $attendance->getById($_GET['edit_attendance']);
}

$students = $student->all();
$records = $attendance->all();
?>
<!DOCTYPE html>
<html>
<head>
    <title>IT313 Student Attendance</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f4f8fb;
            margin: 20px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        h2 {
            color: #2c3e50;
            margin-top: 40px;
            border-left: 5px solid #3498db;
            padding-left: 10px;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 6px 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 7px 15px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover { background: #2980b9; }
        a { color: #e74c3c; text-decoration: none; }
        a:hover { text-decoration: underline; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            background: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        }
        th, td {
            border: 1px solid #e0e0e0;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #34495e;
            color: white;
        }
        .present { color: green; font-weight: bold; }
        .absent { color: red; font-weight: bold; }
        .late { color: orange; font-weight: bold; }
        .attendance-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 15px;
            margin: 8px 0;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .attendance-row strong {
            flex: 1;
            font-size: 16px;
            color: #2c3e50;
        }
        .attendance-options label {
            margin-right: 20px;
            font-size: 14px;
            color: #444;
        }
        .attendance-options input {
            margin-right: 5px;
        }
    </style>
</head>
<body>
<h1>📘 IT313 Student Attendance </h1>

<h2>Students</h2>
<form method="POST">
    <input type="hidden" name="id" value="<?= isset($editStudent) ? $editStudent['id'] : '' ?>">
    <input type="text" name="name" placeholder="Student Name"
           value="<?= isset($editStudent) ? $editStudent['name'] : '' ?>" required>
    <?php if (isset($editStudent)): ?>
        <button type="submit" name="update_student">Update</button>
        <a href="index.php">Cancel</a>
    <?php else: ?>
        <button type="submit" name="add_student">Add</button>
    <?php endif; ?>
</form>

<table>
<tr><th>ID</th><th>Name</th><th>Action</th></tr>
<?php foreach($students as $s): ?>
<tr>
    <td><?= $s['id'] ?></td>
    <td><?= $s['name'] ?></td>
    <td>
        <a href="?edit_student=<?= $s['id'] ?>">Edit</a> | 
        <a href="?delete_student=<?= $s['id'] ?>">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<h2>Students List</h2>
<form method="POST">
    <?php foreach($students as $s): ?>
        <div class="attendance-row">
            <strong><?= $s['name'] ?></strong>
            <div class="attendance-options">
                <label><input type="radio" name="attendance[<?= $s['id'] ?>]" value="Present" required> Present</label>
                <label><input type="radio" name="attendance[<?= $s['id'] ?>]" value="Absent"> Absent</label>
                <label><input type="radio" name="attendance[<?= $s['id'] ?>]" value="Late"> Late</label>
            </div>
        </div>
    <?php endforeach; ?>
    <button type="submit" name="mark_attendance">💾 Save Attendance</button>
</form>

<h2>Attendance Records</h2>
<table>
<tr><th>ID</th><th>Student</th><th>Status</th><th>Date</th><th>Action</th></tr>
<?php foreach ($records as $r): ?>
<tr>
    <td><?= $r['id'] ?></td>
    <td><?= $r['name'] ?></td>
    <td class="<?= strtolower($r['status']) ?>"><?= $r['status'] ?></td>
    <td><?= $r['date'] ?></td>
    <td>
        <a href="?edit_attendance=<?= $r['id'] ?>">Edit</a> | 
        <a href="?delete_attendance=<?= $r['id'] ?>">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

</body>
</html>

