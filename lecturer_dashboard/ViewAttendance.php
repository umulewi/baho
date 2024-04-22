<?php  
session_start();
if (!isset($_SESSION['username'])) {
    header("location: ../index.php");
    exit();
}
?>

<?php

include '../connection.php';
include  'dashboard.php';

$username = $_SESSION['username'];

$sql_lec = "SELECT lecturer_id FROM lecturer INNER JOIN users ON lecturer.users_id = users.users_id WHERE users.username = :username";
$stmt_lec = $pdo->prepare($sql_lec);
$stmt_lec->bindParam(':username', $username);
$stmt_lec->execute();
$lecturer = $stmt_lec->fetch(PDO::FETCH_ASSOC);
$lecturer_id = $lecturer['lecturer_id'];

$sql_course = "SELECT *  FROM lecturer_course INNER JOIN course ON lecturer_course.course_id = course.course_id WHERE lecturer_id = :lecturer_id";
$stmt_course = $pdo->prepare($sql_course);
$stmt_course->bindParam(':lecturer_id', $lecturer_id);
$stmt_course->execute();
$course = $stmt_course->fetch(PDO::FETCH_ASSOC);
$course_id = $course['course_id'];
$course_name = $course['course_name'];

$sql_dates = "SELECT DISTINCT date FROM student_attendance WHERE course_id = :course_id ORDER BY date";
$stmt_dates = $pdo->prepare($sql_dates);
$stmt_dates->bindParam(':course_id', $course_id);
$stmt_dates->execute();
$dates = $stmt_dates->fetchAll(PDO::FETCH_ASSOC);   



   ?>
 

<style>
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: teal;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .btn {
            padding: 8px 12px;
            text-decoration: none;
            border-radius: 4px;
            color: white;
            font-weight: bold;
        }
        .btn.delete {
            background-color: crimson;
        }
        .btn.update {
            background-color: #b0b435;
        }
    </style>

    </style>
</head>

<table id="attendance-table" class="table">
    <thead>
        <tr>
            <th>Student Name</th>
            <th>Reg. Number</th>
            <?php
            foreach ($dates as $date) {
                echo "<th>{$date['date']}</th>";
            }
            ?>
            <th>Attended</th>
            <th>Not Attended</th>
            
            <th>Attendance Percentage</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php
          $sql_students = "SELECT DISTINCT student.student_id,student.reg_no, student.student_name AS student_name FROM student JOIN student_course ON student.student_id = student_course.student_id JOIN course ON student_course.course_id = course.course_id JOIN lecturer_course ON course.course_id = lecturer_course.course_id WHERE lecturer_course.lecturer_id = :lecturer_id AND course.course_id = :course_id";
        $stmt_students = $pdo->prepare($sql_students);
        $stmt_students->bindParam(':lecturer_id', $lecturer_id);
        $stmt_students->bindParam(':course_id', $course_id);
        $stmt_students->execute();
        $students = $stmt_students->fetchAll(PDO::FETCH_ASSOC);

        foreach ($students as $student) {
            echo "<tr>";
            echo "<td>{$student['student_name']}</td>";
            echo "<td>{$student['reg_no']}</td>";
            foreach ($dates as $date) {
                $sql_attendance = "SELECT attentance FROM student_attendance WHERE student_id = :student_id AND course_id = :course_id AND date = :date";
                $stmt_attendance = $pdo->prepare($sql_attendance);
                $stmt_attendance->bindParam(':student_id', $student['student_id']);
                $stmt_attendance->bindParam(':course_id', $course_id);
                $stmt_attendance->bindParam(':date', $date['date']);
                $stmt_attendance->execute();
                $attendance = $stmt_attendance->fetchColumn();
                echo "<td>" . ($attendance == 1 ? 'Present' : 'Absent') . "</td>";
            }

            // Fetch attendance data for the current student
            $stmt_attendance_data = $pdo->prepare("SELECT 
                SUM(CASE WHEN attentance = '1' THEN 1 ELSE 0 END) AS attended_count,
                SUM(CASE WHEN attentance = '0' THEN 1 ELSE 0 END) AS not_attended_count,
                COUNT(DISTINCT date) AS total_dates,
                COUNT(DISTINCT lecturer_id) AS total_lecturer
                FROM student_attendance
                WHERE student_id = :student_id");
            $stmt_attendance_data->bindParam(':student_id', $student['student_id']);
            $stmt_attendance_data->execute();
            $attendance_data = $stmt_attendance_data->fetch(PDO::FETCH_ASSOC);
            $totalAttendance = $attendance_data['attended_count'] + $attendance_data['not_attended_count'];
            $attendance_percentage = $totalAttendance > 0 ? round(($attendance_data['attended_count'] / $totalAttendance) * 100, 2) : 0;

            if($attendance_percentage>70){
                $xx="eligble";
            }
            else {
                $xx="not eligble";
            }
            

            // Output the attendance data
            echo "<td>{$attendance_data['attended_count']}</td>";
            echo "<td>{$attendance_data['not_attended_count']}</td>";
        
           
            echo "<td>{$attendance_percentage}%</td>";
            echo "<td>{$xx}</td>";

            echo "</tr>";
        }
        ?>
    </tbody>
</table>
<br>


<button  id="print-button" class="btn" style="background-color: teal; cursor: pointer;">Print Excel</button>


<script>
document.getElementById("print-button").addEventListener("click", function() {
    var table = document.getElementById("attendance-table").cloneNode(true);
    
    // Create a new Excel file
    var blob = new Blob([table.outerHTML], {
        type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
    });
    var link = document.createElement("a");
    link.href = window.URL.createObjectURL(blob);
    
    // Set the file name
    link.download = "attendance.xls";
    
    // Trigger the download
    link.click();
});
</script>

                    
                