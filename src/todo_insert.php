<?php
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/PHP_1STPJ-main/src/" );
    define( "URL_DB", SRC_ROOT."common/db_connect.php" );
    include_once( URL_DB );
    include_once( "common/todo_insert_f.php");

    $http_method = $_SERVER["REQUEST_METHOD"];

    // DB의 가장 최근 list_no 구하기
    $result_no = select_list_no_desc();
    // 구해온 list_no에서 + 1해서 새로 작성한 리스트의 상세페이지 번호로
    $insert_page_num = $result_no["list_no"] + 1;

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
    $insert_list_info = insert_todo_info($arr_info);

    header( "Location: todo_detail.php?list_no=".$insert_page_num."&list_start_date=".substr($arr_post["todo_start"], 0, 10)  );
    exit;
    }
    else
    {
        $insert_page_num = null;
    }
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>todo_insert</title>
    <link rel="stylesheet" href="css/todo_insert_c.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><a href="todo_index.php"><img src="common/img/title.png" alt="title"></a></h1>
        </div>
        <div class="contents_outside">
        <form class="form_contents" method="post" action="todo_insert.php">
        <div class="contents_container">
                <div class="contents_title">
                    <label for="title">퀘스트 제목</label>
                    <input type="text" id="title" name="todo_title" required>
                </div>
            <br>    
                <div class="contents_detail">
                    <label for="contents">퀘스트 내용</label>
                    <textarea id="contents" name="todo_contents"></textarea>
                </div>
            <br>
                <div class="start_end_date">
                    <span class="start_date_dir">    
                        <label for="start_date">시작</label>
                        <input type="datetime-local" id="start_date" name="todo_start" required value="">
                    </span>
                    <span class="end_date_dir">
                        <label for="end_date">종료</label>
                        <input type="datetime-local" id="end_date" name="todo_end" required>
                    </span>
                </div>
            <br>    
                <div class="contents_imp">
                    <input type="checkbox" name="todo_imp" id="important" value="1">
                    <label for="important">중요<label>
                </div>
                </div> 
                <div class="submit_button">
                    <a href="todo_index.php"><button type="button">취소</button></a>
                    
                    <button type="submit">수락</button>
                </div>
                </form>
        </form>
</div>
        
        
    </div>
</body>
</html>
