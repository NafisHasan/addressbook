<?php
$host = "127.0.0.1"; 
$userName = "addressbook"; 
$userPass = "test"; 
$database = "addressbook"; 

$connectQuery = mysqli_connect($host,$userName,$userPass,$database);

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
?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script>
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

    }});
});
	</script>
<title>Address Book</title>
</head>
<body>
<h1 style="color:green;text-align:center;">Address Book</buton>

<div class="add" >
    <button style="text-align:center;" id="newdata">Add New Data</h2>
    <p id="msg" style="text-align:center;"></p>
    <form id="dataform" method="POST" style="display:none;">
          <label>First Name</label>
          <input type="text" placeholder="Enter Firdt Name" name="firstName" required>
          <label>Last Name</label>
          <input type="text" placeholder="Enter Last Name" name="lastName" required>
          <label>Company Name</label>
          <input type="text" placeholder="Enter Company Name" name="comName" >
          <label>Email Address</label>
          <input type="email" placeholder="Enter Email Address" name="email" required>
          <label>City</label>
          <input type="city" placeholder="Enter Full City" name="city" required>
          <label>Country</label>
          <input type="text" placeholder="Enter Full Country" name="country" required>
          <label>State</label>
          <input type="text" placeholder="Enter Full State" name="state" >
          <label>Address</label>
          <input type="text" placeholder="Enter Address" name="address" required>
          <label>Telephone Number</label>
          <input type="number" placeholder="Enter Telephone Number" name="teleNumber" >
          <label>Phone Number</label>
          <input type="number" placeholder="Enter Phone Number" name="phoneNumber" >
          <button type="submit">Submit</button>
    </form>
</div>  
    <table border="1px" style="width:80%; line-height:40px; margin-left: auto; margin-right: auto; border-collapse: collapse;">
        <thead>
            <tr>
            	<th>ID</th>    
				<th>First Name</th>
                <th>Last Name</th>
                <th>Company Name</th>
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
					<td><?php echo $row['address']; ?></td>
					<td><?php echo $row['teleNumber']; ?></td>
					<td><?php echo $row['email']; ?></td>
					<td><?php echo $row['phoneNumber']; ?></td>
					<td><a href= <?php echo $_SERVER['PHP_SELF']. "?id=" . $row['id'] . "&mode=update" ?>>Update</a>   <a href= <?php echo $_SERVER['PHP_SELF']. "?id=" . $row['id'] ."&mode=delete" ?> >Delete</a></td>
                    
                <tr>
            <?php } ?>
        </tbody>
    </table>
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
	width: 40%;	
	margin-left: auto; 
	margin-right: auto;
    padding-bottom: 50px;
}

.view{	
	margin-left: auto; 
	margin-right: auto;
}
</style>