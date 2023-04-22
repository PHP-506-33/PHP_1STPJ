<?php

include_once( "db_connect.php" );

// --------------------
// 리스트 제목 검색하는 함수
// --------------------
function select_list_search( &$param_arr )
{
    $sql = 
    " SELECT "
    ."      list_no "
    ."      ,list_title "
    ."      ,list_start_date "
    ."      ,list_due_date "
    ."      ,list_imp_flg "
    ."      ,list_clear_flg "
    ." FROM "
    ."      todo_list_info "
    ." WHERE "
    ."      DATE_SUB(list_start_date, INTERVAL 1 DAY) <= :list_start_date "
    ."      AND "
    ."      list_due_date >= :list_due_date "
    ."      AND "
    ."      list_title LIKE CONCAT('%', :searchword, '%') "
    ." ORDER BY "
    ."      list_clear_flg ASC "
    ."      ,list_imp_flg DESC "
    ."      ,list_due_date ASC "
    ."      ,list_start_date DESC "
    ."      ,list_no DESC "
    ." LIMIT :limit_num OFFSET :offset "
    ;

    $arr_prepare =
        array(
            ":list_start_date"        => $param_arr["list_start_date"]
            ,":list_due_date"        => $param_arr["list_due_date"]
            ,":searchword"           => $param_arr["searchword"]
            ,":limit_num"       => $param_arr["limit_num"]
            ,":offset"          => $param_arr["offset"]
        );

    $conn = null;
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    }
    catch( Exception $e )
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result;
}

function select_list_cnt( &$param_arr )
{
    $sql = 
    " SELECT "
    ."      COUNT(*) cnt "
    ." FROM "
    ."      todo_list_info "
    ." WHERE "
    ."      DATE_SUB(list_start_date, INTERVAL 1 DAY) <= :list_start_date "
    ."      AND "
    ."      list_due_date >= :list_due_date "
    ."      AND "
    ."      list_title LIKE CONCAT('%', :searchword, '%') "
    ;

    $arr_prepare =
        array(
            ":list_start_date"        => $param_arr["list_start_date"]
            ,":list_due_date"        => $param_arr["list_due_date"]
            ,":searchword"           => $param_arr["searchword"]
        );

    $conn = null;
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    }
    catch( Exception $e )
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result;
}

function select_list_paging( $param_page, $param_max, $param_date, $param_search )
{
    if($param_max > 1)
    {
        for($i=1; $i <= $param_max; $i++)
        {
            echo "<a href='todo_index.php?page_num=".$i."&list_start_date=".$param_date."&search=".$param_search."'>".$i."</a>";
        }
    }
}

function li_display( $param_arr, $param_date )
{
    foreach ($param_arr as $val)
    {
        if( $param_date === substr($val['list_due_date'], 0, 10) )
        {
            $alert = "<span class='d_day'>D-DAY</span>";
        }
        else if( $param_date === date("Y-m-d", strtotime($val['list_due_date']." -1 day")) )
        {
            $alert = "<span class='d_1'>D-1</span>";
        }
        else
        {
            $alert = "<i class='fa-solid fa-angle-right'></i>";
        }
        if($val['list_clear_flg'] === '1')
        {
            $checkbox = "<i class='fa-solid fa-square-check'></i>";
            if($val['list_imp_flg'] === '1')
            {
                $impmark = "<i class='fa-solid fa-star'></i>";
                $list_class = "cle_imp";
            }
            else
            {
                $impmark = "<i></i>";
                $list_class = "cle_nimp";
            }
        }
        else
        {
            $checkbox = "<i class='fa-regular fa-square'></i>";
            if($val['list_imp_flg'] === '1')
            {
                $impmark = "<i class='fa-solid fa-star'></i>";
                $list_class = "unc_imp";
            }
            else
            {
                $impmark = "<i></i>";
                $list_class = "unc_nimp";
            }
        }

        echo "<li><a href='todo_detail.php?list_no=".$val['list_no']."&list_start_date=".$param_date."'><div class='list_container ".$list_class."'>".$checkbox.$impmark."<span class='list_title_s'>".$val['list_title']."</span><span class='list_date'>".trim_date($val['list_start_date'])." ~ ".trim_date($val['list_due_date'])."</span>".$alert."</div></a></li>";
    }
}

// --------------------
// 포인트 계산 함수
// --------------------
function point_cal()
{
    $sql = 
    " SELECT "
    ."      COUNT(*) point "
    ." FROM "
    ."      todo_list_info "
    ." WHERE "
    ."      list_clear_flg = '1' "
    ;

    $arr_prepare = array();

    $conn = null;
    try
    {
        db_conn( $conn );
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    }
    catch( Exception $e )
    {
        return $e->getMessage();
    }
    finally
    {
        $conn = null;
    }

    return $result[0]["point"];
}

// --------------------
// 레벨 계산 함수
// --------------------
function level_cal()
{
    if(point_cal() === 0)
    {
        $result = 1;
    }
    else if(point_cal() <= 50)
    {
        $result = ceil(point_cal() / 10);
    }
    else
    {
        $result = 5;
    }
    return $result;
}

// --------------------
// 날짜 다듬는 함수
// --------------------
function trim_date( $param_str )
{
    $result = substr($param_str, 5, 5);
    return $result;
}

function make_calendar( $param_year, $param_month, $param_day )
{
    $temp_arr_31 = [1, 3, 5, 7, 8, 10, 12];
    $temp_arr_30 = [4, 6, 9, 11];

    if( in_array( $param_month, $temp_arr_31 ) )
    {
        $ii = 31;
    }
    else if( in_array( $param_month, $temp_arr_30 ) )
    {
        $ii = 30;
    }
    else
    {
        if( $param_year % 4 === 0 )
        {
            $ii = 29;
        }
        else
        {
            $ii = 28;
        }
    }

    for ($i=1; $i <= $param_day; $i++)
    {
        echo "<span></span>";
    }

    for ($i=1; $i <= $ii; $i++)
    { 
        if($i < 10)
        {
            if($param_month < 10)
            {
                echo "<a href='todo_index.php?list_start_date=".$param_year."-0".$param_month."-0".$i."'>".$i."</a>";
            }
            else
            {
                echo "<a href='todo_index.php?list_start_date=".$param_year."-".$param_month."-0".$i."'>".$i."</a>";
            }
        }
        else
        {
            if($param_month < 10)
            {
                echo "<a href='todo_index.php?list_start_date=".$param_year."-0".$param_month."-".$i."'>".$i."</a>";
            }
            else
            {
                echo "<a href='todo_index.php?list_start_date=".$param_year."-".$param_month."-".$i."'>".$i."</a>";
            }
        }
    }
}

// TODO: start
// $arr = array(
//     "list_start_date"         => "2023-04-19 12:00:00"
//     ,"list_due_date"           => "2023-04-19 12:00:00"
//     ,"searchword"       => "중요"
//     ,"limit_num"        => 5
//     ,"offset"           => 0
//     );
// $result = select_list_search( $arr );
// print_r( $result );
// TODO: end

// TODO: start
// echo level_cal();
// TODO: end

?>