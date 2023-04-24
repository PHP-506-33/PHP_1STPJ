<?php 
define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/PHP_1STPJ-main/src/" );
define( "URL_DB", SRC_ROOT."common/db_connect.php" );
include_once( URL_DB );

if( array_key_exists("page_num", $_GET) )
{
    $page_num = $_GET["page_num"];
}
else
{
    $page_num = 1;
}

$date_ymd = date("Y-m-d");
$list_start_date = $date_ymd;
$limit_num = 6;
$offset = ( $page_num - 1 ) * $limit_num;

if( array_key_exists("list_start_date", $_GET))
{
    if( $_GET["list_start_date"] === "" )
    {
        $date_ymd = date("Y-m-d");
    }
    else
    {
        $date_ymd = $_GET["list_start_date"];
    }
    $list_start_date = $date_ymd;
}

if( array_key_exists("search", $_GET))
{
    $search = $_GET["search"];
    if( $search === "" )
    {
        $list_start_date = $date_ymd;
        $date_ymd2 = $date_ymd;
    }
    else
    {
        $list_start_date = "검색 결과";
        $date_ymd2 = '1971-01-01';
    }
}
else
{
    $search = "";
    $date_ymd2 = $date_ymd;
}

$arr_prepare1 = array(
    "list_start_date"   => $date_ymd
    ,"list_due_date"    => $date_ymd2
    ,"searchword"       => $search
    ,"limit_num"        => $limit_num
    ,"offset"           => $offset
    );
$result_paging = select_list_search( $arr_prepare1 );

$arr_prepare2 = array(
    "list_start_date"   => $date_ymd
    ,"list_due_date"    => $date_ymd2
    ,"searchword"       => $search
    );

$result_cnt = select_list_cnt( $arr_prepare2 );
$max_page_num = ceil( $result_cnt[0]["cnt"] / $limit_num );

$year_pick = (int)substr($date_ymd, 0, 4);
$month_pick = (int)substr($date_ymd, 5, 2);
$firstday = $year_pick."-".$month_pick."-01";
$day_pick = date('w', strtotime($firstday));

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/todo_index_c.css">
    <script src="https://kit.fontawesome.com/15c1734573.js" crossorigin="anonymous"></script>
    <title>Index</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><a href="todo_index.php"><img src="common/img/title.png" alt="title"></a></h1>
        </div>
        <div class="paper">
        <div class="sidebar">
            <div class="profile">
                <div class="profile_img">
                    <img class="grow_img" src="common/img/grow<?php echo level_cal() ?>.png" alt="grow">
                </div>
                <div class="profile_text">
                    <span class="level">Lv. <?php echo level_cal() ?></span>
                    <span class="point">Point : <?php echo point_cal() ?></span>
                </div>
            </div>
            <hr>
            <span class="calendar_text">Calendar</span>
            <div class="calendar">
                <form method="get" action="todo_index.php">
                    <input type="date" name="list_start_date">
                    <button type="submit" class="calendar_btn"><i class="fa-solid fa-angles-right"></i></button>
                </form>
                <div class="calendar_title">
                    <a href="todo_index.php?list_start_date=<? echo $year_pick."-".date("m", strtotime($date_ymd." -1 month"))."-01" ?>"><i class="fa-solid fa-chevron-left"></i></a>
                    <span><?php echo $month_pick ?>월</span>
                    <a href="todo_index.php?list_start_date=<? echo $year_pick."-".date("m", strtotime($date_ymd." +1 month"))."-01" ?>"><i class="fa-solid fa-chevron-right"></i></a>
                </div>
                <div class="day_list">
                    <span>일</span><span>월</span><span>화</span><span>수</span><span>목</span><span>금</span><span>토</span>
                    <?php make_calendar( $year_pick, $month_pick, $day_pick ) ?>
                </div>
            </div>
        </div>
        <div class="main">
            <div class="upper_section">
            <div class="date_section">
                <h2><?php echo $list_start_date ?></h2>
                <hr>
            </div>
            <div class="list_section">
                <ul>
                    <?php li_display( $result_paging, $date_ymd ) ?>
                </ul>
            </div>
            </div>
            <div class="lower_section">
            <div class="page_section">
                <?php select_list_paging( $page_num, $max_page_num, $date_ymd, $search ) ?>
            </div>
            <div class="search_section">
                <form method="get" action="todo_index.php">
                    <input type="search" name="search">
                    <button type="submit" class="search_btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
            <div class="move_section">
                    <a class=left_btn href="todo_index.php?list_start_date=<? echo date("Y-m-d", strtotime($date_ymd." -1 day")) ?>"><i class="fa-solid fa-chevron-left"></i></a>
                    <a class=right_btn href="todo_index.php?list_start_date=<? echo date("Y-m-d", strtotime($date_ymd." +1 day")) ?>"><i class="fa-solid fa-chevron-right"></i></a>
            </div>
            </div>
            <div class="button_section">
                <a href="todo_insert.php"><span class="insert_btn">작성하기</span></a>
            </div>
        </div>
        </div>
    </div>
</body>
</html>