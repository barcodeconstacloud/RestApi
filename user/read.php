<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../objects/user.php';
include_once '../functions/functions.php';

$database = new Database();
$db = $database -> getConnection();

  
// prepare product object
$user = new User($db);
isset($_GET['id']) ? array_push($user -> id, $_GET['id']) : die();
$fmt = isset($_GET['fmt']) ? $_GET['fmt'] : false;
$stmt = $user -> read();
$num = $stmt -> rowCount();

if($num>0){
  
    $userArray=array();
    $userArray["records"]=array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        if($fmt == "false") {
            $userRecord=array(
                "id" => $id,
                "name" => $name,
                "email" => $Email,
                "phone" => $Phone,
                "city" => $City
            );  
        } else {
            $userRecord = array(array2csv(array($id,$name,$Email,$Phone,$City)));
        }
        array_push($userArray["records"], $userRecord);
    }
  
    // set response code - 200 OK
    http_response_code(200);
  
    // show products data in json format
    echo json_encode($userArray);
} else {
  
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user no products found
    echo json_encode(
        array("message" => "No users found.")
    );
}
?>



