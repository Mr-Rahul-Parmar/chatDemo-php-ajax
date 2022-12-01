<?php

use Illuminate\Support\Facades\DB;

function changeDateFormate($date, $date_format)
{
    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);
}

function productImagePath($image_name)
{
    return public_path('images/products/' . $image_name);
}

$connect = new PDO("mysql:host=localhost;dbname=ChatBuddy", "root", "3rd@123");

function fetch_user_last_activity($user_id, $connect)
{
    $query = "SELECT * FROM users
 WHERE id = '$user_id'
 ORDER BY last_seen DESC
 LIMIT 1
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    foreach ($result as $row) {
        return $row['last_seen'];
    }
}

//function fetch_user_chat_history($from_user_id, $to_user_id, $connect)
//{
//    $query = "
// SELECT * FROM chat_message_buddies
// WHERE (from_user_id = '".$from_user_id."'
// AND to_user_id = '".$to_user_id."')
// OR (from_user_id = '".$to_user_id."'
// AND to_user_id = '".$from_user_id."')
// ORDER BY timestamp DESC
// ";
//    $statement = $connect->prepare($query);
//    $statement->execute();
//    $result = $statement->fetchAll();
//    $output = '<ul class="list-unstyled">';
//    foreach($result as $row)
//    {
//        $user_name = '';
//        if($row["from_user_id"] == $from_user_id)
//        {
//            $user_name = '<b class="text-success">You</b>';
//        }
//        else
//        {
//            $user_name = '<b class="text-danger">'.get_user_name($row['from_user_id'], $connect).'</b>';
//        }
//        $output .= '
//  <li style="border-bottom:1px dotted #ccc">
//   <p>'.$user_name.' - '.$row["chat_message"].'
//    <div align="right">
//     - <small><em>'.$row['timestamp'].'</em></small>
//    </div>
//   </p>
//  </li>
//  ';
//    }
//    $output .= '</ul>';
//    return $output;
//}

function count_unseen_message($from_user_id, $to_user_id, $connect)
{
    $query = "
 SELECT * FROM chat_message_buddies
 WHERE from_user_id = '$from_user_id'
 AND to_user_id = '$to_user_id'
 AND status = '1'
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $count = $statement->rowCount();
    $output = '';
    if ($count > 0) {
        $output = '<span class="label label-success">' . $count . '</span>';
    }
    return $output;
}


function fetch_is_type_status($user_id, $connect)
{
//    $user_id = Auth::id();
    $query = "
 SELECT is_type FROM chat_message_buddies
 WHERE from_user_id = '".$user_id."'
 ORDER BY status DESC
 LIMIT 1
 ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $output = '';
    foreach($result as $row)
    {
        if($row["is_type"] == 'yes')
        {
            $output = 'Typing...';
        }
    }
    return $output;
}
