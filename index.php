<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic GuestBook By the Wheelchair Guy</title>
    <style>
    
    input[type="text"], input[type="email"]  {
       margin-left:60px;
       display: block;
         margin-top: -20px;
 
    }
    label{
       
 text-align: right;
   
    }
    
    
    </style>
</head>
<body>

</body>
</html>
 <form action='index.php' method='post'>
<label> Name</label> <input type="text" name='name'><br>
<label> E-mail </label> <input type="email" name='email'><br>
<label>Message </label> <input type="text" name='msg'><br>
<input type="submit" value="post">

 </form>
 <hr>
 

<?php




           if(isset($_POST['name'])) {
                $fname = $_POST['name'];
                $email = $_POST['email'];
                $msg = $_POST['msg'];
                
                
                     $file = fopen("comment.html","a");
                     fwrite($file, "<b>First name </b>". $fname."<br>");
                     fwrite($file, "<b>E-Mail</b> ".$email."<br>");
                     fwrite($file, "<b>Message</b> ".$msg."<hr>");
                     fclose($file);
                    }


            
          

               require("comment.html");
?>



    
    