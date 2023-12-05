<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

require './vendor/autoload.php';
require 'dao.php';

Flight::route('GET /', function(){
  new Dao;
  //echo'Hello World';
  //echo phpinfo();
});

Flight::route('POST /register', function(){

    $fullname = Flight::request()->data->fullname;
    $username = Flight::request()->data->username;
    $password = Flight::request()->data->password;
    $email = Flight::request()->data->email;
    $phone = Flight::request()->data->phone;
    

    if (strlen($username) < 3) {
        Flight::json(array(
          'status' => 'error',
          'message' => 'The username should be longer than 3 characters.'
        ));
        die;
      }
  
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        Flight::json(array(
          'status' => 'error',
          'message' => "The email '" . $email . "' address is not valid."
        ));
        die;
      }

    // Use of database connection from dao.php
    $dao = new Dao();

    $stmt = $dao->conn->prepare("INSERT INTO users (full_name, username, password, email, phone_num) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$fullname, $username, $password, $email, $phone]);


    // validation
    Flight::json(array(
      'status' => 'success',
      'message' => 'User registered successfully'
    ));
});

Flight::route('POST /login', function(){

    $username = Flight::request()->data->username;
    $password = Flight::request()->data->password;


    
    $dao = new Dao();
    $stmt = $dao->conn->prepare("SELECT * FROM `users` WHERE username ='$username' AND password = '$password'");
    $stmt->execute();
    $result= $stmt->fetchAll(PDO::FETCH_ASSOC);
    Flight::json($result);

   // $_SESSION['hello'] = $result[][];
/*
    Flight::json(array(
        'status' => 'success',
        'message' => 'User registered successfully'
      ));
*/


    // db connect
    /*Flight::json(array(
      'status' => 'error',
      'message' => 'User not found.'
    ));*/
    //die;

});

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="user",
 *     description="User related operations"
 * )
 * @OA\Info(
 *     version="1.0",
 *     title="Example for response examples value",
 *     description="Example info",
 *     @OA\Contact(name="Swagger API Team")
 * )
 * @OA\Server(
 *     url="http://localhost/SSSD/sssd-2023-19001956/api/",
 *     description="API server"
 * )
 */
class OpenApiSpec
{
}


/**
 * @OA\Post(
 *     path="/users",
 *     summary="Adds a new user - with oneOf examples",
 *     description="Adds a new user",
 *     operationId="addUser",
 *     tags={"user"},
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="username",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="phone",
 *                     oneOf={
 *                     	   @OA\Schema(type="string"),
 *                     	   @OA\Schema(type="integer"),
 *                     }
 *                 ),
 *                  @OA\Property(
 *                     property="email",
 *                     type="string"
 *                 ),
 * 
 *                 example={"id": "a3fb6", "name": "Jessica Smith", "phone": 12345678}
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK",
 *         @OA\JsonContent(

 *             @OA\Examples(example="result", value={"success": true}, summary="An result object."),
 *             @OA\Examples(example="bool", value=false, summary="A boolean value."),
 *         )
 *     )
 * )
 */


Flight::start();

?>