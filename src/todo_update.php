<?php
define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/PHP_1STPJ-main/src/" );
define( "URL_DB", SRC_ROOT."common/db_connect.php" );
define( "URL_UPDATE_F", SRC_ROOT."todo_update.php" );
include_once( URL_DB );
include_once( URL_UPDATE_F ); 

$http_method = $_SERVER["REQUEST_METHOD"];

if( $http_method === "GET" )
{
  $list_no = 1;
  if( array_key_exists( "list_no", $_GET ) )
  {
    $list_no = $_GET["list_no"];
  }
  $result_info = select_list_info_no( $list_no );
  


  $result_imp_flg = $result_info["list_imp_flg"];
    if($result_imp_flg == "1" )
    {
      $one_1 = "checked";
    }
    else
    {
      $one_1 ="";
    }
  }
  

else
  {
    $arr_post = $_POST;
    $list_imp_flg = isset($arr_post["list_imp_flg"]) ? 1 : 0;
    $arr_info = 
    array(
      "list_no" => $arr_post["list_no"],
      "list_title" => $arr_post["list_title"],
      "list_detail" => $arr_post["list_detail"],
      "list_start_date" => $arr_post["list_start_date"],
      "list_due_date" => $arr_post["list_due_date"],
      "list_imp_flg" => $list_imp_flg
         );

    $result_cnt = update_todo_list_info_no( $arr_info );


  header( "Location: todo_detail.php?list_no=".$arr_post["list_no"]."&list_start_date=".substr($arr_post["list_start_date"],0,10) );
  exit();
  
  }

// if($arr_post["list_imp_flg"] == "1" )
//   {
//     $one_1 = "checked";
//   }
// else
//   {
//     $one_1 ="";
//   }

// if( $http_method === "POST")
// {
//   $arr_post = $_POST;
//   if(isset($arr_post["list_imp_flg"]))
//   {
//     $imp_flg = "1";
//   }
//   else
//   {
//     $imp_flg = "0";
//   }

//   $arr_info =
//   array
//         (
//             ":list_no" => $arr_post["list_no"]
//             ,":list_title" => $arr_post["list_title"]
//             ,":list_detail" => $arr_post["list_detail"]
//             ,":list_start_date" => $arr_post["list_start_date"]
//             ,":list_due_date" => $arr_post["list_due_date"] 
//             ,":list_imp_flg" => $arr_post["list_imp_flg"]
//         );
     
// $result_cnt = update_todo_list_info_no( $arr_info );



// $arr_post = $_POST;
//     $list_imp_flg = 0;
//     $list_imp_flg = isset($arr_post["list_imp_flg"]) && $arr_post["list_imp_flg"] == 1 ? 1 : 0;
//     $arr_info =
//     array(
//       "list_no" => $arr_post["list_no"]
//       ,"list_title" => $arr_post["list_title"]
//       ,"list_detail" => $arr_post["list_detail"]
//       ,"list_start_date" => $arr_post["list_start_date"]
//       ,"list_due_date" => $arr_post["list_due_date"] 
//       ,"list_imp_flg" => $list_imp_flg
//       );
?>

<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel='stylesheet' href='../src/css/todo_update_c.css'>
<title>수정하기</title>
</head>
<body>
<form method="post" action="todo_update.php">
  <div class= "list_edit">
     <label for="list_no">목록 번호</label>
      <input type="text" name="list_no" value="<?php echo $result_info["list_no"] ?>" readonly >
      <br>
      <label for="list_title">제목</label>
      <input type="text" name="list_title" value="<?php echo $result_info["list_title"] ?>" required>
      <br>
      <label for="list_detail">내용</label>
      <input type="text" name="list_detail" id="list_detail" value="<?php echo $result_info["list_detail"] ?>" required>
      <br>
      <label for="list_start_date">시작 날짜</label>
      <input type="datetime-local" name="list_start_date" id="list_start_date" value="<?php echo $result_info["list_start_date"] ?>" required>
      <br>
      <label for="list_due_date">마감 날짜</label>
      <input type="datetime-local" name="list_due_date" id="list_due_date" value="<?php echo$result_info["list_due_date"] ?>" required>
      <br>
      <label for="list_imp_flg">중요</label>
      <input type="checkbox" name="list_imp_flg" id="list_imp_flg" value="1" <?php echo $one_1; ?>>
      <br>
      <button type="submit">수정</button>
      <a href = "todo_detail.php?list_no=<?php echo $result_info["list_no"]."&list_start_date=".substr($result_info["list_start_date"],0,10) ?>"><button type="button">취소</button></a> 
      <a href = "todo_delete.php?list_no=<?php echo $result_info["list_no"] ?>"><button type="button">삭제</button></a>
  <div>
</form>
<!-- <button type="button" ><a href= "list_detail.php" id="hii">목록</a></button> -->
</body>
</html>