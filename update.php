<?php
$host = "127.0.0.1"; 
$userName = "addressbook"; 
$userPass = "test"; 
$database = "addressbook"; 

$connectQuery = mysqli_connect($host,$userName,$userPass,$database);
$msg="";
$id="";
$result="";
if (isset($_GET['id'])) {
$id = $_GET['id'];
if(mysqli_connect_errno()){
    echo mysqli_connect_error();
    exit();
}else{
    $selectQuery = "SELECT * FROM `addressbook` WHERE id=$id";
    $result = mysqli_query($connectQuery,$selectQuery);
    if(mysqli_num_rows($result) > 0){
    }else{
        $msg = "No Record found";
    }
}
}
// convert illegal input value to ligal value formate
function legal_input($value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
}
// function to insert user data into database table
function insert_data($firstName,$lastName,$comName,$email,$city,$country,$state,$address,$teleNumber,$phoneNumber){
 
    global $connectQuery;
    global $id;

     $query="UPDATE addressbook SET firstName='$firstName',lastName='$lastName',comName='$comName',address='$address',teleNumber=$teleNumber,email='$email',phoneNumber=$phoneNumber,country='$country',city='$city',state='$state' WHERE id=$id";

    $execute=mysqli_query($connectQuery,$query);
    if($execute==true)
    {
      echo "Data was updated successfully";
    }
    else{
     echo  "Error: " . $sql . "<br>" . mysqli_error($connectQuery);
    }
}
if (isset($_POST['firstName'])) {
    $id     = legal_input($_POST['id']);
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
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script>

        $(document).on('submit','#dataform',function(e){
        e.preventDefault();
       
        $.ajax({
        method:"POST",
        url: "update.php",
        data:$(this).serialize(),
        success: function(data){
        $('#msg').html(data);
        $('#dataform').find('input').val('')

    }});
});
	</script>
<title>Address Book</title>
</head>
<body>
<h2 style="color:green;text-align:center;">Update ID: <?php echo $id?></h2>
<?php echo "<p style='text-align:center;'>$msg</p>" ?>
<div class="add" >
    <p id="msg" style="text-align:center;"></p>
    <?php
    if(!empty($result))
    while($row = mysqli_fetch_assoc($result)){?>
    <form id="dataform" method="POST">
          <input type="hidden" value=<?php echo $row['id']; ?> name="id" >
          <label>First Name</label>
          <input type="text" value=<?php echo $row['firstName']; ?> name="firstName" required>
          <label>Last Name</label>
          <input type="text" value=<?php echo $row['lastName']; ?> name="lastName" required>
          <label>Company Name</label>
          <input type="text" value=<?php echo $row['comName']; ?> name="comName" >
          <label>City</label>
          <input type="city" value=<?php echo $row['city']; ?> name="city" required>
          <label>State</label>
          <input type="text" value=<?php echo $row['state']; ?> name="state" >
          <label>Country</label>
          <input type="text" value=<?php echo $row['country']; ?> name="country" required>
          <label>Address</label>
          <input type="text" value=<?php echo $row['address']; ?> name="address" required>
          <label>Email Address</label>
          <input type="email" value=<?php echo $row['email']; ?> name="email" required>
          <label>Telephone Number</label>
          <input type="number" value=<?php echo $row['teleNumber']; ?> name="teleNumber" >
          <label>Phone Number</label>
          <input type="number" value=<?php echo $row['phoneNumber']; ?> name="phoneNumber" >
          <button type="submit">Update</button>
    </form>
    <?php }
    ?>
</div>
</body>
</html>
<style>
	input[type=text], select, textarea, input[type=email], input[type=city], input[type=number]{
	width: 100%;
	padding: 12px;
	border: 1px solid #ccc;
	border-radius: 4px;
	box-sizing: border-box;
	resize: vertical;
}

button[type=submit] {
  
    cursor: pointer;
    float: right;
    width: 100%;
	padding: 12px;
	border: 1px solid #ccc;
	border-radius: 4px;
	box-sizing: border-box;
	resize: vertical;
}
.add, #dataform{
	width: 80%;	
	margin-left: auto; 
	margin-right: auto;
    
}
</style>