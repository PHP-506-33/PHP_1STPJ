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
$limit_num = 5;
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
    }
    else
    {
        $list_start_date = "검색 결과";
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
                    <img src="common/img/grow<?php echo level_cal() ?>.png" alt="grow1">
                </div>
                <div class="profile_text">
                    <span>이름</span>
                    <br>
                    <span>Lv. <?php echo level_cal() ?></span>
                </div>
            </div>
            <div class="calendar">
                <form method="get" action="todo_index.php">
                    <input type="date" name="list_start_date">
                    <button type="submit">날짜이동</button>
                </form>
            </div>
        </div>
        <div class="main">
            <div class="date_section">
                <h2><?php echo $list_start_date ?></h2>
                <hr>
            </div>
            <div class="list_section">
                <ul>
                    <?php li_display( $result_paging, $date_ymd ) ?>
                </ul>
            </div>
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
            <div class="button_section">
                <a href="todo_insert.php"><span class="insert_btn">작성하기</span></a>
            </div>
        </div>
        </div>
    </div>
</body>
</html>