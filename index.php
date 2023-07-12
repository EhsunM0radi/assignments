<?php
require_once('model/database.php');
require_once('model/assinments_db.php');
require_once('model/course_db.php');


$assignment_id = filter_input(INPUT_POST, 'assignment_id', FILTER_VALIDATE_INT);
$description = htmlspecialchars(filter_input(INPUT_POST, 'description'));
$course_name = htmlspecialchars(filter_input(INPUT_POST, 'course_name'));


$course_id = filter_input(INPUT_POST, 'course_id', FILTER_VALIDATE_INT);
if (!$course_id) {
    $course_id = filter_input(INPUT_GET, 'course_id', FILTER_VALIDATE_INT);
}

$action = htmlspecialchars(filter_input(INPUT_POST, 'action'));
if (!$action) {
    $action = htmlspecialchars(filter_input(INPUT_GET, 'action'));
    if (!$action) {
        $action = 'list_assignments';
    }
}

switch ($action) {
    case "list_courses":
        $courses = get_courses();
        include('view/course_list.php');
        break;
    case "add_course":
        add_course($course_name);
        header("Location: .?action=list_courses");
        break;
    case "add_assignment":
        if ($course_id && $description) {
            add_assignment($course_id, $description);
            header("Location: .?course_id=$course_id");
        } else {
            $error = "Invalid assignment data. Check all fields and try again.";
            include('view/error.php');
            exit();
        }
        break;
    case "delete_course":
        if ($course_id) {
            try {
                delete_course($course_id);
            } catch (PDOException $e) {
                $error = "You cannot delete a course if assignments exist in the course.";
                include('view/error.php');
                exit();
            }
            header("Location: .?action=list_courses");
        }
        break;
    case "delete_assignment":
        if ($assignment_id) {
            delete_assignment($assignment_id);
            header("Location: .?course_id=$course_id");
        } else {
            $error = "Missing or incorrect assignment id.";
            include('view/error.php');
            exit();
        }
        break;
    default:
        $course_name = get_course_name($course_id);
        $courses = get_courses();
        $assignments = get_assignments_by_course($course_id);
        include('view/assignment_list.php');
}
