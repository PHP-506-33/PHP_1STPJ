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
$date_pick = $date_ymd;
$limit_num = 5;
$offset = ( $page_num - 1 ) * $limit_num;

if( array_key_exists("date_pick", $_GET))
{
    if( $_GET["date_pick"] === "" )
    {
        $date_ymd = date("Y-m-d");
    }
    else
    {
        $date_ymd = $_GET["date_pick"];
    }
    $date_pick = $date_ymd;
}

if( array_key_exists("search", $_GET))
{
    $search = $_GET["search"];
    if( $search === "" )
    {
        $date_pick = $date_ymd;
    }
    else
    {
        $date_pick = "검색 결과";
    }
}
else
{
    $search = "";
}

$arr_prepare1 = array(
    "list_start_date"   => $date_ymd
    ,"list_due_date"    => $date_ymd
    ,"searchword"       => $search
    ,"limit_num"        => $limit_num
    ,"offset"           => $offset
    );
$result_paging = select_list_search( $arr_prepare1 );

$arr_prepare2 = array(
    "list_start_date"   => $date_ymd
    ,"list_due_date"    => $date_ymd
    ,"searchword"       => $search
    );

$result_cnt = select_list_cnt( $arr_prepare2 );
$max_page_num = ceil( $result_cnt[0]["cnt"] / $limit_num );

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="todo_index_c.php">
    <title>Index</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>TITLE</h1>
        </div>
        <div class="sidebar">
            <div class="profile">
                <div class="profile_section"></div>
                <span>이름</span>
                <br>
                <span>Lv. <?php echo level_cal() ?></span>
            </div>
            <div class="calendar">
                <form method="get" action="todo_index.php">
                    <input type="date" name="date_pick">
                    <button type="submit">날짜이동</button>
                </form>
            </div>
        </div>
        <div class="main">
            <div class="date_section">
                <h2><?php echo $date_pick ?></h2>
            </div>
            <div class="list_section">
                <ul>
                    <?php
                    foreach ($result_paging as $val) {
                    ?>
                    <li><a href="todo_detail.php?list_no=<? echo $val["list_no"] ?>&date_pick=<? echo $date_ymd ?>"><div class="list_container"><span><?php echo $val["list_title"]?></span><span><?php echo trim_date($val["list_start_date"])." ~ ".trim_date($val["list_due_date"]) ?></span></div></a></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="page_section">
                <?php select_list_paging( $page_num, $max_page_num, $search ) ?>
            </div>
            <div class="search_section">
                <form method="get" action="todo_index.php">
                    <input type="search" name="search">
                    <button type="submit">검색</button>
                </form>
            </div>
            <div class="move_section">
                    <a href="todo_index.php?date_pick=<? echo date("Y-m-d", strtotime($date_ymd." -1 day")) ?>">◀</a>
                    <a href="todo_index.php?date_pick=<? echo date("Y-m-d", strtotime($date_ymd." +1 day")) ?>">▶</a>
            </div>
        </div>
        <div class="button_section">
            <a href="todo_insert.php">작성하기</a>
        </div>
    </div>
</body>
</html>