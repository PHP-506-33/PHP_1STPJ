<?php 
    define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");
    // echo DOC_ROOT;
    define("ROOT_URL", DOC_ROOT."src/todo_list/common/db_connect.php");
    // echo ROOT_URL;
    include_once( ROOT_URL );
    // select
    // $arr_get = $_GET;
    // $detail_info = todo_select_detail_info( $arr_get["list_no"] );
    // $detail_today = todo_select_detail_list( $arr_get["list_no"] );

    // update
    
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
</head>
<body>
    <form action="todo_index.php">
        <div class="detail">
            <div class="profill">
                <div class="prof_img">
                    <img src="" alt="profill">
                </div>
                <span class="prof_name_level">
                    Lv.<?php ?><br>
                    <?php ?>
                </span>
            </div>
            <div class="detail_calender">
                <h3>Calender</h3>
                <table>
                    <thead>< 23.04 ></thead>
                    <tr>
                        <?php for ($i=1; $i<=7; $i++) { ?>
                            <td><?php echo "○" ?></td>
                        <?php } ?>
                    </tr>
                    <tr>
                    <?php for ($i=1; $i<=7; $i++) { ?>
                            <td><?php echo "○" ?></td>
                        <?php } ?>
                    </tr>
                    <tr>
                    <?php for ($i=1; $i<=7; $i++) { ?>
                            <td><?php echo "○" ?></td>
                        <?php } ?>
                    </tr>
                    <tr>
                    <?php for ($i=1; $i<=7; $i++) { ?>
                            <td><?php echo "○" ?></td>
                        <?php } ?>
                    </tr>
                </table>
            </div>
            <div class="detail_today">
                <h3>Today</h3>
                <div class="today_info">
                    <p class="today_1">| <?php echo date("H : i", time()); ?></p>
                    <p class="today_2">|<?php ?></p>
                    <p class="today_3">|<?php ?></p>
                </div>
            </div>
        </div>
        <div class="detail_info">
            <div class="info_title">
                <h2><?php ?></h2>
                
                
                <hr>
            </div>
            <div class="detail_content">
                <div class="detail_title">
                    <input type="checkbox" class="todo_check">
                    <span class="todo_title"><?php ?><span>
                    <span class="todo_date"><?php ?><span>
                </div>
                <div class="detila_content">
                    <textarea name="" id="" cols="50" rows="10"><?php ?></textarea>
                </div>
            </div>
            <button type="submit" class="com">완료</button>
        </div>
        <button><a href="todo_update.php?list_no=<?php ?>">수정</a></button>
        <button><a href="todo_list.php">돌아가기</a></button>
    </form>
</body>
</html>