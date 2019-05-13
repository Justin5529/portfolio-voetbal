<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';

 
// instantiate member object
include_once '../objects/members.php';

//authentication 

 
$database = new Database();
$db = $database->getConnection();
 
$member = new Member($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->voornaam) &&
    !empty($data->achternaam) &&
    !empty($data->lidnummer)
){
 
    // set member property values
    $member->voornaam = $data->voornaam;
    $member->tussenvoegsel = $data->tussenvoegsel;
    $member->achternaam = $data->achternaam;
    $member->lidnummer = $data->lidnummer;
    $member->details = $data->details;
    
 
    // create the member
    if($member->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "member was created."));
    }
 
    // if unable to create the member, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create member."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create member. Data is incomplete."));
}
?>