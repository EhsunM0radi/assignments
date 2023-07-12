<?php


function get_courses()
{
    global $db;
    $query = 'SELECT * FROM courses ORDER BY ID';
    $statement = $db->prepare($query);
    $statement->execute();
    $courses = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $courses;
}


function get_course_name($course_id)
{
    if (!$course_id) {
        return "All Courses";
    }
    global $db;
    $query = 'SELECT `Name` FROM courses Where ID = :course_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':course_id', $course_id);
    $statement->execute();
    $course_name = $statement->fetch();
    $statement->closeCursor();
    return $course_name;
}

function delete_course($course_id)
{
    global $db;
    $query = 'DELETE FROM courses WHERE ID = :course_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':course_id', $course_id);
    $statement->execute();
    $statement->closeCursor();
}

function add_course($course_name)
{
    global $db;
    $query = 'INSERT INTO courses (`Name`) VALUES (:Name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':Name', $course_name);
    $statement->execute();
    $statement->closeCursor();
}
