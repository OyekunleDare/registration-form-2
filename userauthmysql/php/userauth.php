<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $country, $email, $gender, $password){
    $conn = db();
	$chk = mysqli_query($conn,"SELECT * FROM students WHERE email = '$email'");
	$arr = mysqli_num_rows($chk);
	if($arr==0){
		$query = mysqli_query($conn,"INSERT INTO students (full_names,country,email,gender,password) VALUES ('$fullnames','$country','$email','$gender','$password')");
		if($query){
			echo "User Successfully registered";
			header("Location:../forms/login.html");
		}else{
			echo "<p align='center'>Registration failed</p>";
		}
		
	}else{
		echo "<p align='center'>Email address already exist in our database</p>";
?>
<p align="center">Please click <a href="../forms/register.html" style="text-decoration: underline; color: red;">here</a> to return to the registration page or <a href="../forms/login.html" style="color: red; text-decoration: underline;">login</a> with your existing email address</p>
<?php
	}
}


//login users
function loginUser($email, $password){
    $conn = db();
    echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME) </h1>";
    $chk = mysqli_query($conn,"SELECT * FROM students WHERE email = '$email'");
	if(mysqli_num_rows($chk)>0){
		$chkpass = mysqli_fetch_array($chk);
		$pass = $chkpass['password'];
		if($pass==$password){
			session_start();
			$_SESSION['username'] = $chkpass['full_names'];
			$_SESSION['password'] = $password;
			header("Location:../dashboard.php");
		}else{
			echo "Password Incorrect <br/> Please <a href='../forms/login.html' style='text-decoration: underline;'>retry</a>";
		}
	}else{
		//echo "Email Invalid";
		header("Location:../forms/login.html");
	}
}

//reset password
function resetPassword($email, $password){
    $conn = db();
    echo "<h1 style='color: red'>RESET YOUR PASSWORD (IMPLEMENT ME)</h1>";	
	$chk = mysqli_query($conn,"SELECT * FROM students WHERE email = '$email'");
	if(mysqli_num_rows($chk)>0){
		$query = mysqli_query($conn,"UPDATE students SET password = '$password' WHERE email = '$email'");
		if($query){
?>
	<p style="color: green;">Password reset successful. <br> Please <a href="../forms/login.html" style="text-decoration: underline;">login</a></p>
<?php
		}
	}else{
?>
	<p style="color: red;">User does not exist. <br> Please <a href="../forms/resetpassword.html" style="text-decoration: underline;">retry</a></p>
<?php
	}
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";
    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] . 
                "</td> <td style='width: 150px'>" . $data['country'] . 
                "</td>
                <form action='action.php' method='post'>
                <input type='hidden' name='id'" .
                 "value=" . $data['id'] . ">".
                "<td style='width: 150px'> <button type='submit', name='delete'> DELETE </button>".
                "</form></td></tr>";
        }
        echo "</table></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
     $conn = db();
     $query = mysqli_query($conn,"DELETE FROM students WHERE id = $id");
	 if($query){
		 echo "User with id " . $id . " deleted successfully";
	 }
 }
