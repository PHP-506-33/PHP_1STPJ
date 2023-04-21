<?php
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/PHP_1STPJ-main/src/" );
    define( "URL_DB", SRC_ROOT."common/db_connect.php" );
    include_once( URL_DB );

    $http_method = $_SERVER["REQUEST_METHOD"];
    $arr_get = $_GET;

    if($http_method === "POST")
    {
        $result_list_no = $arr_get["list_no"];
        $result_cnt = delete_todo_info( $arr_get["list_no"] );
        header( "Location: todo_index.php" );
        exit;
    }
    // $result_info = todo_select_detail_info($arr_get["list_no"]);

?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>todo_delete</title>
</head>
<body>
    <div class="container">
        <h1>Todo List</h1>
    <div class="delete_container">
        <p>퀘스트를 포기하시겠습니까?</p>
        <p>주의! 포기한 퀘스트는 사라집니다</p>
    </div>
        
        <a href="todo_detail.php?list_no=<?php echo $arr_get["list_no"]."&list_start_date=".$arr_get["list_start_date"] ?>">취소</a>
        
        <form method="post" action="todo_delete.php?list_no=<?php echo $arr_get["list_no"]."&list_start_date=".$arr_get["list_start_date"] ?>">
        <input type="hidden" name="list_no" value="<?php echo $arr_get["list_no"] ?>">
        <button type="submit">삭제</button>
        </form>
        
    </div>
</body>
</html>

