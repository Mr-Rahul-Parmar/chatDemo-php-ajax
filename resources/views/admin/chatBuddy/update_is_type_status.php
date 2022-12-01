
<?php

//update_is_type_status.php

$connect = new PDO("mysql:host=localhost;dbname=ChatBuddy", "root", "3rd@123");

session_start();
$id = Auth::id();

$query = "
UPDATE chat_message_buddies
SET is_type = '".$_POST["is_type"]."'
WHERE from_user_id = '".$id."'
";

$statement = $connect->prepare($query);

$statement->execute();

?>
