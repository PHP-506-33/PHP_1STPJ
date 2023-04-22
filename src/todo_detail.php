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
        // strtotime() : 문자열 형태의 날짜를 입력받아 UNIX timestamp(초 단위로 세어지는 정수로 표현한 값) 형식의 값을 돌려주는 함수
        $today_list = date("Y-m-d", strtotime($detail_info["list_start_date"]));
        $today = date("Y-m-d", strtotime($detail_today[0]["list_start_date"]));
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

    $list_start_date = $arr_get["list_start_date"];
    $year_pick = substr($list_start_date, 0, 4);
    $month_pick = substr($list_start_date, 5, 2);
    $firstday = $year_pick."-".$month_pick."-01";
    $day_pick = date('w', strtotime($firstday));
    $limit_num = 5;

    $arr_prepare1 = array(
        "list_start_date"   => $list_start_date
        ,"list_due_date"    => $list_start_date
        ,"limit_num"        => $limit_num
        );
    $result_paging = select_list_detail( $arr_prepare1 );
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/todo_detail_c.css">
    <script src="https://kit.fontawesome.com/8c69259d3d.js" crossorigin="anonymous"></script>
    <title>Detail</title>
</head>
<header>
    <a href="todo_index.php"><img src="./common/img/title.png" alt="header_title"></a>
</header>
<body>
    <div class="total_container">
        <div class="detail">
            <div class="profile"> <!-- 프로필 -->
                <div class="prof_img">
                    <img class="grow_img" src="./common/img/grow<?php echo level_cal() ?>.png" alt="grow1">
                </div>
                <span class="prof_name_level">
                    Lv. <?php echo level_cal() ?><br>
                    point : <?php echo point_cal() ?>
                </span>
                <hr class="prof_hr">
            </div>
            <div class="detail_total_calender">
            <h3>Calender</h3>
                <div class="detail_calender"> <!-- 달력 -->
                <div class="calendar_title">
                    <p><?php echo $month_pick ?>월</p>
                </div>
                <div class="day_list">
                    <span>일</span><span>월</span><span>화</span><span>수</span><span>목</span><span>금</span><span>토</span>
                    <?php make_calendar_detail( $year_pick, $month_pick, $day_pick ) ?>
                </div>
                </div>
            </div>
            <div class="detail_today"> <!-- 현재 선택한 할 일과 같은 날의 남은 할 일 표시 -->
                <h3>Left to do</h3>
                <div class="today_info"> <!-- foreach로 남은 할 일 출력하기/CSS : 할 일 당 색 다르게 설정 -->
                    <ul>
                        <?php li_display_detail( $result_paging, $list_start_date ) ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="detail_info"> <!-- 현재 선택한 할 일 제목, 날짜, 상세 내용 -->
            <div class="info_title"> 
                <span class="todo_date">
                    <?php echo date("m.d", strtotime($detail_info["list_start_date"]))." ~ ".date("m.d", strtotime($detail_info["list_due_date"])); ?>
                <span>
                <hr>
            </div>
            <div class="imp_star">
                <?php if($detail_info["list_imp_flg"] === '1'){ ?>
                    <span class="imp">
                        <i class="fa-solid fa-star" style="color: #FFDA56;"></i>
                    </span>
                    <?php }else{ ?>
                    <span class="no_imp">
                        <i class="fa-regular fa-star" style="color: #1d293f;"></i>
                    </span>
                <?php } ?>
            </div>
            <form action="todo_detail.php" method="post">
            <div class="detail_content">
                <div class="detail_title">
                    <div class="detail_info_title">
                            <input type="hidden" value="<?= $arr_prepare["list_no"] ?>" name="list_no">
                            <?php if($detail_info["list_clear_flg"] === '1'){ ?>
                                <input type="checkbox" id="check" value="0" checked>
                            <?php }else{ ?>
                                <input type="checkbox" id="check" name="check" class="todo_check" value="check">
                            <?php } ?>
                            <label for="check" class="todo_title"><?= $detail_info["list_title"] ?></label>
                            <label for="check" class="todo_date_time">
                                <?php echo date("H : i", strtotime($detail_info["list_start_date"]))." ~ ".date("H : i", strtotime($detail_info["list_due_date"])); ?>
                            <label>
                    </div>
                </div>
                    <textarea name="" id="" cols="50" rows="10" readonly><?php echo $detail_info["list_detail"]?></textarea>
            </div>
                <div class="com_btn">
                <button type="submit" class="com">완료</button>
                </div>
                </form>
        </div>
        <a href="todo_update.php?list_no=<?php echo $arr_prepare["list_no"] ?>"><button class="modify_btn" type="button">수정</button></a>
        <a href="todo_index.php"><button class="return_btn" type="button">돌아가기</button></a>
    </div>
</body>
</html>