<?php
$host = "127.0.0.1"; 
$userName = "addressbook"; 
$userPass = "test"; 
$database = "addressbook"; 

$connectQuery = mysqli_connect($host,$userName,$userPass,$database);
$msg="";
$id="";
$mode="";
$city="";
$state="";
$country="";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $mode = $_GET['mode'];
}
if ( $mode=="delete") {
    mysqli_query($connectQuery,"DELETE FROM addressbook where id=$id");
}
if (isset($_GET['city'])) {
    $city=legal_input($_GET['city']);
}
if (isset($_GET['country'])) {
    $country=legal_input($_GET['country']);
}
if (isset($_GET['state'])) {
    $state=legal_input($_GET['state']);
}


function legal_input($value) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
}
if (empty($city) && empty($country) && empty($state)) {
if(mysqli_connect_errno()){
    echo mysqli_connect_error();
    exit();
}else{
    $selectQuery = "SELECT * FROM `addressbook` ORDER BY `id` ASC";
    $result = mysqli_query($connectQuery,$selectQuery);
    if(mysqli_num_rows($result) > 0){
    }else{
        $msg = "No Record found";
    }
}
}
elseif(empty($state)){
    if(mysqli_connect_errno()){
        echo mysqli_connect_error();
        exit();
    }else{
        $selectQuery = "SELECT * FROM `addressbook` WHERE city='$city' and country='$country' ORDER BY `id` ASC";
        $result = mysqli_query($connectQuery,$selectQuery);
        if(mysqli_num_rows($result) > 0){
        }else{
            $msg = "No Record found";
        }
    }
}
else{
    if(mysqli_connect_errno()){
        echo mysqli_connect_error();
        exit();
    }else{
        $selectQuery = "SELECT * FROM `addressbook` WHERE city='$city' and country='$country' and state='$state' ORDER BY `id` ASC";
        $result = mysqli_query($connectQuery,$selectQuery);
        if(mysqli_num_rows($result) > 0){
        }else{
            $msg = "No Record found";
        }
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
        function deleteevent() {
            window.location.reload(true);
        }
		$(document).ready(function(){
        $("#newdata").click(function(){
            if($('#dataform').css('display') == 'none'){
                $('#dataform').show();
                $('#newdata').text('Close');
                }
            else{
                $('#dataform').hide();
                $('#newdata').text('Add New Data');}
        });
        $("#filterdata").click(function(){
            if($('#filterform').css('display') == 'none'){
                $('#filterform').show();
                $('#filterdata').text('Close Filter');
                }
            else{
                $('#filterform').hide();
                $('#filterdata').text('Filter');
                window.location.reload(true)}
        });
        
        
        });

        $(document).on('submit','#dataform',function(e){
        e.preventDefault();
       
        $.ajax({
        method:"POST",
        url: "create.php",
        data:$(this).serialize(),
        success: function(data){
        $('#msg').html(data);
        $('#dataform').find('input').val('')
        window.location.reload(true)

    }});
});
	</script>
<title>Address Book</title>
</head>
<body>
<h1 style="color:green;text-align:center;">Address Book</h1>

<div class="add" >
    <button style="text-align:center;" id="newdata">Add New Data</button>
    <p id="msg" style="text-align:center;"></p>
    <form id="dataform" method="POST" style="display:none;">
          <label>First Name</label>
          <input type="text" placeholder="Enter Firdt Name" name="firstName" required>
          <label>Last Name</label>
          <input type="text" placeholder="Enter Last Name" name="lastName" required>
          <label>Company Name</label>
          <input type="text" placeholder="Enter Company Name" name="comName" >
          <label>City</label>
          <input type="city" placeholder="Enter Full City" name="city" required>
          <label>State</label>
          <input type="text" placeholder="Enter Full State" name="state" >
          <label>Country</label>
          <input type="text" placeholder="Enter Full Country" name="country" required>
          <label>Address</label>
          <input type="text" placeholder="Enter Address" name="address" required>
          <label>Email Address</label>
          <input type="email" placeholder="Enter Email Address" name="email" required>
          <label>Telephone Number</label>
          <input type="number" placeholder="Enter Telephone Number" name="teleNumber" >
          <label>Phone Number</label>
          <input type="number" placeholder="Enter Phone Number" name="phoneNumber" >
          <button type="submit">Submit</button>
    </form>
</div>
<div class="add" >
    <button style="text-align:center;" id="filterdata">Filter</button>
    <form action="index.php" id="filterform" method="GET" style="display:none;">
          
          <label>City</label>
          <input type="city" placeholder="Enter Full City" name="city" required>
          <label>State</label>
          <input type="text" placeholder="Enter Full State" name="state" >
          <label>Country</label>
          <input type="text" placeholder="Enter Full Country" name="country" required>
          <button type="submit">Filter</button>
    </form>
</div> 
    
    <table border="1px" style="width:80%; line-height:40px; margin-left: auto; margin-right: auto; border-collapse: collapse;">
        <thead>
            <tr>
            	<th>ID</th>    
				<th>First Name</th>
                <th>Last Name</th>
                <th>Company Name</th>
                <th>city</th>
                <th>state</th>
                <th>country</th>
                <th>Address</th>
				<th>Tel</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                while($row = mysqli_fetch_assoc($result)){?>
                <tr>
					<td><?php echo $row['id']; ?></td>
					<td><?php echo $row['firstName']; ?></td>
                    <td><?php echo $row['lastName']; ?></td>
					<td><?php echo $row['comName']; ?></td>
                    <td><?php echo $row['city']; ?></td>
                    <td><?php echo $row['state']; ?></td>
                    <td><?php echo $row['country']; ?></td>
					<td><?php echo $row['address']; ?></td>
					<td><?php echo $row['email']; ?></td>
					<td><?php echo $row['teleNumber']; ?></td>
					<td><?php echo $row['phoneNumber']; ?></td>
					<td><a href= <?php echo "update.php". "?id=" . $row['id']?>>Update</a>   <a href= <?php echo $_SERVER['PHP_SELF']. "?id=" . $row['id'] ."&mode=delete" ?> onclick="deleteevent()">Delete</a></td>
                
                <tr>
            <?php }
            ?>
        </tbody>
    </table>
    <?php echo "<p style='text-align:center;'>$msg</p>" ?>   
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

button[type=submit], #newdata, #filterdata {
  
    cursor: pointer;
    float: right;
    width: 100%;
	padding: 12px;
	border: 1px solid #ccc;
	border-radius: 4px;
	box-sizing: border-box;
	resize: vertical;
}
.add{
	width: 80%;	
	margin-left: auto; 
	margin-right: auto;
    
}
#dataform, #filterform{
    padding-bottom: 50px;
    width: 100%;	
	margin-left: auto; 
	margin-right: auto;
}

.view{	
	margin-left: auto; 
	margin-right: auto;
}
tbody tr {
        background-color: #f2f2f2;}
</style>