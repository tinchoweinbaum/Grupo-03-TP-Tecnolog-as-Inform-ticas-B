<?php
/**
*    File        : backend/controllers/studentsSubjectsController.php
*    Project     : CRUD PHP
*    Author      : Tecnologías Informáticas B - Facultad de Ingeniería - UNMdP
*    License     : http://www.gnu.org/licenses/gpl.txt  GNU GPL 3.0
*    Date        : Mayo 2025
*    Status      : Prototype
*    Iteration   : 1.0 ( prototype )
*/

require_once("./repositories/studentsSubjects.php");

function handleGet($conn) 
{
    //logica especifica a validacion por front de estudiante ya en asignacion (ej. 4)
    if (isset($_GET['student_id'])) 
    {
        $student_id = intval($_GET['student_id']);
        $stmt = $conn->prepare("SELECT * FROM students_subjects WHERE student_id = ?");
        if (!$stmt) {
            http_response_code(500);
            echo json_encode(["error" => "Error preparando consulta: " . $conn->error]);
            return;
        }
        $stmt->bind_param("i", $student_id); 
        $stmt->execute();
        $result = $stmt->get_result();
        $studentsSubjects = [];
        while ($row = $result->fetch_assoc()) {
            $studentsSubjects[] = $row;
        }
        $stmt->close();
        echo json_encode($studentsSubjects);
        return;
    }

    $studentsSubjects = getAllSubjectsStudents($conn);
    echo json_encode($studentsSubjects);
}

function handlePost($conn) 
{
    $input = json_decode(file_get_contents("php://input"), true);
    
    $result = assignSubjectToStudent($conn, $input['student_id'], $input['subject_id'], $input['approved']);
    if ($result['inserted'] > 0) 
    {
        echo json_encode(["message" => "Asignación realizada"]);
    } 
    else 
    {
        http_response_code(500);
        echo json_encode(["error" => "Error al asignar"]);
    }
}

function handlePut($conn) 
{
    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input['id'], $input['student_id'], $input['subject_id'], $input['approved'])) 
    {
        http_response_code(400);
        echo json_encode(["error" => "Datos incompletos"]);
        return;
    }

    $result = updateStudentSubject($conn, $input['id'], $input['student_id'], $input['subject_id'], $input['approved']);
    if ($result['updated'] > 0) 
    {
        echo json_encode(["message" => "Actualización correcta"]);
    } 
    else 
    {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo actualizar"]);
    }
}

function handleDelete($conn) 
{
    $input = json_decode(file_get_contents("php://input"), true);

    $result = removeStudentSubject($conn, $input['id']);
    if ($result['deleted'] > 0) 
    {
        echo json_encode(["message" => "Relación eliminada"]);
    } 
    else 
    {
        http_response_code(500);
        echo json_encode(["error" => "No se pudo eliminar"]);
    }
}
?>
