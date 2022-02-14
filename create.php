<?php

$host = "127.0.0.1"; 
$userName = "addressbook"; 
$userPass = "test"; 
$database = "addressbook"; 

$connectQuery = mysqli_connect($host,$userName,$userPass,$database);

//legal input values
 $firstName     = legal_input($_POST['firstName']);
 $lastName     = legal_input($_POST['lastName']);
 $comName     = legal_input($_POST['comName']);
 $email = legal_input($_POST['email']);
 $city         = legal_input($_POST['city']);
 $country      = legal_input(($_POST['country']));
 $state         = legal_input($_POST['state']);
 $address         = legal_input($_POST['address']);
 $teleNumber         = legal_input($_POST['teleNumber']);
 $phoneNumber         = legal_input($_POST['phoneNumber']);

if(empty($comName)){
    $comName     = "NULL";
}
if(empty($teleNumber)){
    $teleNumber  = "NULL";
}
if(empty($phoneNumber)){
    $phoneNumber = "NULL";
}
if(empty($state)){
    $state       = "NULL";
}

if(!empty($firstName) && !empty($lastName) && !empty($email) && !empty($city) && !empty($country) && !empty($address)){
    //  Sql Query to insert user data into database table
    insert_data($firstName,$lastName,$comName,$email,$city,$country,$state,$address,$teleNumber,$phoneNumber);
}else{
 echo "First Name, Last Name, Email, City, Country, Address fields are required";
}
 
// convert illegal input value to ligal value formate
function legal_input($value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
}

// // function to insert user data into database table
 function insert_data($firstName,$lastName,$comName,$email,$city,$country,$state,$address,$teleNumber,$phoneNumber){
 
     global $connectQuery;

      $query="INSERT INTO addressbook(firstName,lastName,comName,address,teleNumber,email,phoneNumber,country,city,state) VALUES('$firstName','$lastName','$comName','$address',$teleNumber,'$email',$phoneNumber,'$country','$city','$state')";

     $execute=mysqli_query($connectQuery,$query);
     if($execute==true)
     {
       echo "Data was inserted successfully";
     }
     else{
      echo  "Error: " . $sql . "<br>" . mysqli_error($connectQuery);
     }
 }

?>