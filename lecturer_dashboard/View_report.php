<?php  
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../index.php");
    exit();
}

include '../connection.php';
include 'dashboard.php';
$username = $_SESSION['username'];

$stmt_students = $pdo->prepare("SELECT student.student_id, student.student_name FROM student INNER JOIN student_course ON student.student_id = student_course.student_id WHERE student_course.course_id = :course_id");
$stmt_students->bindParam(':course_id', $course_id);
$stmt_students->execute();
$students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

foreach ($students as $student) {
    $student_id = $student['student_id'];

    $stmt_attendance = $pdo->prepare("SELECT 
        SUM(CASE WHEN student_attendance.attentance = '1' THEN 1 ELSE 0 END) AS attended_count,
        SUM(CASE WHEN student_attendance.attentance = '0' THEN 1 ELSE 0 END) AS not_attended_count,
        COUNT(DISTINCT student_attendance.date) AS total_dates,
        COUNT(DISTINCT student_attendance.lecturer_id) AS total_lecturers
        FROM student_attendance
        WHERE student_attendance.student_id = :student_id");
    $stmt_attendance->bindParam(':student_id', $student_id);
    $stmt_attendance->execute();
    $attendance = $stmt_attendance->fetch(PDO::FETCH_ASSOC);

    $totalAttendance = $attendance['attended_count'] + $attendance['not_attended_count'];
    $attendance_percentage = $totalAttendance > 0 ? round(($attendance['attended_count'] / $totalAttendance) * 100, 2) : 0;

    echo "<table class='table' style='table-layout: auto;'>";
    echo "<thead><tr><th>No.</th><th>Student</th><th>Attended</th><th>Not Attended</th><th>Total Dates</th><th>Total Lecturers</th><th>Attendance Percentage</th></tr></thead><tbody>";
    echo "<tr>";
    echo "<td>{$student['student_id']}</td>";
    echo "<td>{$student['student_name']}</td>";
    echo "<td>{$attendance['attended_count']}</td>";
    echo "<td>{$attendance['not_attended_count']}</td>";
    echo "<td>{$attendance['total_dates']}</td>";
    echo "<td>{$attendance['total_lecturers']}</td>";
    echo "<td>{$attendance_percentage}%</td>";
    echo "</tr>";
    echo "</tbody></table>";
}
?>
