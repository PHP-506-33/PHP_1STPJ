<?php
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/PHP_1STPJ-main/src/" );
    define( "URL_DB", SRC_ROOT."common/db_connect.php" );
    include_once( URL_DB );

        $arr_get = $_GET;
        $arr_prepare = array(
            "list_no" => (int)$arr_get["list_no"]
        );
        $result_cnt = delete_todo_info( $arr_prepare["list_no"] );

    
    // 취소버튼에 a태그 상세페이지로 가는거 리스트 넘버가져오는 함수 사용해서 넣기
    // 삭제버튼 누르면 list DB에서 삭제하고 리스트페이지로 가도록
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
        <button><a href="todo_detail.php?list_no=<?php echo $arr_get["list_no"] ?>">취소</a></button>
        <form action="todo_delete" method="get">
        <a href="todo_index.php">삭제<a>
        </form>
    </div>
</body>
</html>

