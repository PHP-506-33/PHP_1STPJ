<?php 
    define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/PHP_1STPJ-main/src/" );
    define( "URL_DB", SRC_ROOT."common/db_connect.php" );
    include_once( URL_DB );

    $http_method = $_SERVER["REQUEST_METHOD"];
    if($http_method === "GET"){
        // select
        $arr_get = $_GET;
        $arr_prepare = array(
            "list_no"   => (int)$arr_get["list_no"]
        );
        $arr_prepare_2 = array(
            "list_start_date" => $arr_get["list_start_date"]
        );
        $detail_info = todo_select_detail_info( $arr_prepare );
        $detail_today = todo_select_detail_list( $arr_prepare_2 );
        $today_list = date("Y-m-d", strtotime($detail_info["list_start_date"]));
        $today = date("Y-m-d", strtotime($detail_today[0]["list_start_date"]));
        // $today_search = array_search(strtotime($detail_info["list_start_date"]) ,$today);
        // var_dump($today_search);
    }else{
        // update
        $list_no_post = $_POST["list_no"];
        $check_post = null;
        if($check_post = "check"){
            $result_cnt = todo_update_detail_list( $list_no_post );
            if($result_cnt === 1){
                header( "Location: todo_index.php" );
                exit();
            }
        }else{
            $check_post = null;
        }
    }
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
    <form action="todo_detail.php" method="post">
        <div class="detail">
            <div class="profile"> <!-- 프로필 -->
                <div class="prof_img">
                    <!-- <img src="./common/grow1.png" alt="profile"> -->
                </div>
                <span class="prof_name_level">
                    Lv. 이름<br>
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
                <h3>Left to do</h3>
                <div class="today_info"> <!-- foreach로 남은 할 일 출력하기/CSS : 할 일 당 색 다르게 설정 -->
                    <ul>
                    <?php 
                    
                        foreach ($detail_today as $key => $value) {
                            // if(){
                    ?>
                        <li>
                            <?php 
                                // if(1 == $today_list){ 
                                ?>
                                <a href="todo_detail.php?list_no=<?php echo $value["list_no"]?>&list_start_no=<?php echo date("Y-m-d", strtotime($value["list_start_date"])) ?>">
                                    <?php echo $value["list_title"]." ".date("m.d / H : i", strtotime($value["list_start_date"]))." ~ ".date("H : i", strtotime($value["list_due_date"]));?>
                                </a>
                            <?php } ?>
                        </li>
                    <?php //} ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="detail_info"> <!-- 현재 선택한 할 일 제목, 날짜, 상세 내용 -->
            <div class="info_title"> 
                <h2><?php echo $detail_info["list_title"] ?></h2>
                <span class="todo_date">
                    <!-- strtotime() : 문자열 형태의 날짜를 입력받아 UNIX timestamp(초 단위로 세어지는 정수로 표현한 값) 형식의 값을 돌려주는 함수 -->
                    <?php echo date("m.d", strtotime($detail_info["list_start_date"]))." ~ ".date("m.d", strtotime($detail_info["list_due_date"])); ?>
                    <?php if($detail_info["list_imp_flg"] === '1'){ ?>
                        <span class="imp">★</span>
                    <?php }else{ ?>
                        <span class="no_imp">☆</span>
                    <?php } ?>
                <span>
                <hr>
            </div>
                <div class="detail_content">
                    <!-- <form action="todo_index.php" method="post" class="detail_title"> -->
                    <input type="hidden" value="<?= $arr_prepare["list_no"] ?>" name="list_no">
                    <?php if($detail_info["list_clear_flg"] === '1'){ ?>
                        <input type="checkbox" value="0" checked>
                    <?php }else{ ?>
                        <input type="checkbox" name="check" class="todo_check" value="check">
                    <?php } ?>
                    <span class="todo_title"><?= $detail_info["list_title"] ?> <span>
                    <span class="todo_date">
                        <?php echo date("H : i", strtotime($detail_info["list_start_date"]))." ~ ".date("H : i", strtotime($detail_info["list_due_date"])); ?>
                    <span>
                    <div class="detila_content">
                        <textarea name="" id="" cols="50" rows="10" readonly>
                            <?php echo $detail_info["list_detail"]?>
                        </textarea>
                    </div>
                </div>
                <button type="submit" class="com">완료</button>
            <!-- </form> -->
        </div>
        <a href="todo_update.php?list_no=<?php echo $arr_prepare["list_no"] ?>"><button type="button">수정</button></a>
        <a href="todo_index.php"><button type="button">돌아가기</button></a>
    </form>
</body>
</html>