<?php

$connect = new PDO('mysql:host=localhost;dbname=commentdb', 'root', '');

$error = '';
$name = '';
$comment_data = '';
$email = '';

if(empty($_POST["name"]))
{
 $error .= '<p class="text-danger">Name is required</p>';
}
else
{
   $name = $_POST["name"];
 //$name = mysqli_real_escape_string($connect ,$_POST["name"]);
}

if(empty($_POST["comment_data"]))
{
 $error .= '<p class="text-danger">Comment is required</p>';
} 
else
{
 $comment_data = $_POST["comment_data"];
}

if(empty($_POST["email"]))
{
 $error .= '<p class="text-danger">Email is required</p>';
}
else
{
 $email = $_POST["email"];
}

if($error == '')
{
 $query = "
 INSERT INTO comments
 (father_id, name, comment, email, created_at) 
 VALUES (:father_id, :name, :comment, :email, :created_at)
 ";
 $statement = $connect->prepare($query);

$statement->bindValue(':father_id', $_POST["id"]);
$statement->bindValue(':name', $name, PDO::PARAM_STR);
$statement->bindValue(':comment', $comment_data, PDO::PARAM_STR);
$statement->bindValue(':email', $email, PDO::PARAM_STR);

//  $statement->execute();


 $statement->execute(
  array(
   ':father_id' => $_POST["id"],
   ':comment'    => $comment_data,
   ':name' => $name,
   ':email' => $email,
   ':created_at' => date("Y-m-d"),
  )
 );
 $error = '<label class="text-success">Comment Added</label>';
}

$data = array(
 'error'  => $error
);
echo json_encode($data);
?>