<?php
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/PHP_1STPJ-main/src/" );
    define( "URL_DB", SRC_ROOT."todo_insert_db.php" );
    include_once( URL_DB );
    
    $http_method = $_SERVER["REQUEST_METHOD"];

    if( $http_method === "POST" )
    {
        $arr_post = $_POST;
        if(isset($arr_post["todo_imp"])) // 중요 체크박스 체크하면 값이 1, 안하면 0으로 설정
        {
            $imp_flg = "1";
        }
        else
        {
            $imp_flg= "0";
        }
        $arr_info =
            array(
                "list_title" => $arr_post["todo_title"]
                ,"list_detail" => $arr_post["todo_contents"]
                ,"list_start_date" => $arr_post["todo_start"]
                ,"list_due_date" => $arr_post["todo_end"]
                ,"list_imp_flg" => $imp_flg
            );

        // DB의 list_no의 총 갯수구하기
        $result_cnt = select_list_no_cnt();

        // list_no의 갯수구한 거에서 + 1해서 이걸로 새로 작성한 리스트의 상세페이지 넘버로
        $insert_page_num = $result_cnt["cnt"] + 1;
    }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>todo_insert</title>
    <link ref="stylesheet" href="./css/todo_insert.css">
</head>
<body>
    <div class="container">
        <h1>todo_list</h1>
    <div class="form_container">
        <form class="form_contents" method="post" action="todo_insert.php">
                <label for="title">퀘스트 제목</label>
                <input type="text" id="title" name="todo_title">
            <br>
                <label for="contents">퀘스트 내용</label>
                <input type="text" id="contents" name="todo_contents">
            <br>
                <label for="start_date">시작</label>
                <input type="datetime-local" id="start_date" name="todo_start">
                <label for="end_date">종료</label>
                <input type="datetime-local" id="end_date" name="todo_end">
            <br>
                <label for="important">중요<label>
                <input type="checkbox" name="todo_imp" id="important" value="1">
            <br>
                <button><a href="todo_index.php">취소<a></button>
                <button type="submit"><a href="todo_detail.php?list_no=<?php echo $insert_page_num ?>">수락<a></button>
        </form>
    </div>
    </div>
</body>
</html>
