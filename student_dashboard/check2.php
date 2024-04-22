SELECT course.course_name, lecturer.lecturer_name FROM course LEFT JOIN lecturer_course ON course.course_id = lecturer_course.course_id LEFT JOIN lecturer ON lecturer_course.lecturer_id = lecturer.lecturer_id JOIN ( SELECT student_course.course_id FROM student_course JOIN student ON student_course.student_id = student.student_id JOIN users ON student.users_id = users.users_id WHERE users.username = 'lewis' GROUP BY student_course.course_id ) AS filtered_courses ON course.course_id = filtered_courses.course_id;"