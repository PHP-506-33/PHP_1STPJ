<?php 
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/PHP_1STPJ-main/src/" );
    define( "URL_DB", SRC_ROOT."common/db_connect.php" );
    include_once( URL_DB );
    // $arr_prepare = array(
    //     "list_no" => 1
    // );
    // $detail_info = todo_select_detail_info( $arr_prepare );
    // $detail_today = todo_select_detail_list( $arr_prepare );
    // select
    $arr_get = $_GET;
    $arr_prepare = array(
        "list_no"   => (int)$arr_get["list_no"]
    );
    $detail_info = todo_select_detail_info( $arr_prepare );
    $detail_today = todo_select_detail_list( $arr_prepare );
    $today_list = $arr_get["date_pick"];

    // update
    
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/todo_detail_c.css">
    <title>Detail</title>
</head>
<body>
    <form action="todo_index.php">
        <div class="detail">
            <div class="profile"> <!-- 프로필 -->
                <div class="prof_img">
                    <img src="./common/grow1.png" alt="profile">
                </div>
                <span class="prof_name_level">
                    Lv.<?php  ?><br>
                    name
                </span>
            </div>
            <div class="detail_calender"> <!-- 달력 -->
                <h3>Calender</h3>
                <table> <!-- html&css 달력(고정된 값의 달력) -->
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
            <div class="detail_today"> <!-- 현재 선택한 할 일과 같은 날의 남은 할 일 표시 -->
                <h3>Today</h3>
                <div class="today_info"> <!-- foreach로 남은 할 일 출력하기/CSS : 할 일 당 색 다르게 설정 -->
                <?php if($today_list === $detail_today["list_start_date"]){
                        foreach($detail_today as $value){ ?>
                        <span>| <?php echo $value; ?> </span>
                <?php } } ?>
                </div>
            </div>
        </div>
        <div class="detail_info"> <!-- 현재 선택한 할 일 제목, 날짜, 상세 내용 -->
            <div class="info_title"> 
                <h2><?php ?></h2>
                <span class="todo_date">
                    <!-- strtotime() : 문자열 형태의 날짜를 입력받아 UNIX timestamp(초 단위로 세어지는 정수로 표현한 값) 형식의 값을 돌려주는 함수 -->
                    <?php echo date("m.d", strtotime($detail_info["list_start_date"]))." ~ ".date("m.d", strtotime($detail_info["list_due_date"])); ?>
                <span>
                <hr>
            </div>
            <div class="detail_content">
                <div class="detail_title">
                    <input type="checkbox" class="todo_check">
                    <span class="todo_title"><?php echo $detail_info["list_title"] ?><span>
                    <span class="todo_date">
                        <?php echo date("H : i", strtotime($detail_info["list_start_date"]))." ~ ".date("H : i", strtotime($detail_info["list_due_date"])); ?>
                    <span>
                </div>
                <div class="detila_content">
                    <textarea name="" id="" cols="50" rows="10">
                        <?php echo $detail_info["list_detail"]?>
                    </textarea>
                </div>
            </div>
            <button type="submit" class="com">완료</button>
        </div>
        <button><a href="todo_update.php?list_no=<?php echo $arr_prepare["list_no"] ?>">수정</a></button>
        <button><a href="todo_index.php">돌아가기</a></button>
    </form>
</body>
</html>