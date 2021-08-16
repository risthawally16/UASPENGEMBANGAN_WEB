<?php
session_start();

require 'autoload.php';

//cek cookie
if(isset($_COOKIE['id']) && iseet($_COOKIE['key'])){
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];
    
    //ambil username berdasarkan id$
    $result = mysqli_query($conn, "SELECT username FROM anggota WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
    
    //cek cookie dan username
    if($key === hash('sha265', $row['usernmae'])){
        $_SESSION['login'] = true;
    }
    
}

if (isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
}



if(isset($_POST["login"])){
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $result = mysqli_query($connect, "SELECT * FROM anggota WHERE
                    username ='$username'");
    
    //cek username
    
    if(mysqli_num_rows($result)===1){
        
        //cek password
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["password"])){
            
            //set session
            $_SESSION["login"] = true;
            
            // cek remember me
            if (isset($_POST['remember'])){
                //buat cookie
                
                setcookie('id',$row['id'], time() + 60);
                setcookie('key', hash('sha256', $row['username']), time()+60);
            }
            
            header("Location: index.php");
            exit;
        }
    }
    
    $error = true;
}



?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Halaman Login</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
 <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
	 <style>
            body{
                background-color: #eee;
            }
        </style>
    </head>
    <body>
        	 <div class="col-md-4 col-md-offset-4 form-login">

	<?php if(isset($error)):?>
		<p>username / password salah</p>
	<?php endif; ?>  
	<div class="outter-form-login">
        <div class="logo-login">
            <em class="glyphicon glyphicon-user"></em>
        </div>             
	<form action="" method="post">
        </div>
            <form action="check-login.php" class="inner-login" method="post">
             <h3 class="text-center title-login">Login</h3>
                <div class="form-group">
                       <input type="text" class="form-control" name="username" placeholder="Username" required="">
                </div>
	            <div class="form-group">
                       <input type="password" class="form-control" name="password" placeholder="Password" required="">
                </div>   
                <div class="form-group mt-2 d-grid">
                       <button class="btn btn-info" name="login">Login</button>
                </div>
                <div class="text-center forget">
                       <p>Forgot Password ?</p>
                </div>
        </div>
	</form>
</html>