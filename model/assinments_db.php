<?php

function get_assignments_by_course($course_id)
{
    global $db;
    if ($course_id) {
        $query = 'SELECT A.ID, A.Description, C.Name FROM assignments A LEFT JOIN courses C ON A.courseID = C.ID WHERE A.courseID = :course_id ORDER BY A.ID';
        $statement = $db->prepare($query);
        $statement->bindValue(':course_id', $course_id);
    } else {
        $query = 'SELECT A.ID, A.Description, C.Name FROM assignments A LEFT JOIN courses C ON A.courseID = C.ID ORDER BY C.ID';
        $statement = $db->prepare($query);
    }
    $statement->execute();
    $assignments = $statement->fetchAll(PDO::FETCH_ASSOC);
    $statement->closeCursor();
    return $assignments;
}

function delete_assignment($assignment_id)
{
    global $db;
    $query = 'DELETE FROM assignments WHERE ID = :assign_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':assignment_id', $assignment_id);
    $statement->execute();
    $statement->closeCursor();
}

function add_assignment($course_id, $description)
{
    global $db;
    $query = 'INSERT INTO assignments (`Description`, courseID) VALUES (:descr, :courseID)';
    $statement = $db->prepare($query);
    $statement->bindValue(':descr', $description);
    $statement->bindValue(':courseID', $course_id);
    $statement->execute();
    $statement->closeCursor();
}
