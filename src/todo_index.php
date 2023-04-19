<?php 

define( "SRC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/PHP_1STPJ/src/" );
define( "URL_DB", SRC_ROOT."common/db_connect.php" );
include_once( URL_DB );
include_once( "todo_index_f.php" );

if( array_key_exists("page_num", $_GET) )
{
    $page_num = $_GET["page_num"];
}
else
{
    $page_num = 1;
}

$date_ymdhis = date("Y-m-d H:i:s");
$date_ymd = date("Y-m-d");
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
}

if( array_key_exists("search", $_GET))
{
    $search = $_GET["search"];
}
else
{
    $search = "";
}

$arr_prepare = array(
    "list_start_date"   => $date_ymd
    ,"list_due_date"    => $date_ymd
    ,"searchword"       => $search
    ,"limit_num"        => $limit_num
    ,"offset"           => $offset
    );
$result_paging = select_list_search( $arr_prepare );

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <span>Lv. 10</span>
            </div>
            <div class="calendar">
                <form method="get" action="todo_index.php">
                    <input type="date" name="date_pick">
                    <button type="submit">날짜입력</button>
                </form>
            </div>
        </div>
        <div class="main">
            <div class="date_section">
                <h2><?php echo $date_ymd ?></h2>
            </div>
            <div class="list_section">
                <ul>
                    <?php
                    foreach ($result_paging as $val) {
                    ?>
                    <li><?php echo $val["list_title"]?></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>
            <div class="move_section">

            </div>
        </div>
        <div class="button_section">

        </div>
    </div>
</body>
</html>