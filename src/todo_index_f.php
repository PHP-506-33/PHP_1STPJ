<?php

include_once( "common/db_connect.php" );

// --------------------
// 리스트 제목 불러오는 함수
// --------------------
function select_list_paging( &$param_arr )
{
    $sql = 
    " SELECT "
    ."      list_title "
    ."      ,list_start_date "
    ."      ,list_due_date "
    ." FROM "
    ."      todo_list_info "
    ." WHERE "
    ."      list_imp_flg = :list_imp_flg "
    ."      AND "
    ."      list_clear_flg = :list_clear_flg "
    ."      AND "
    ."      list_due_date >= :list_date "
    ." ORDER BY "
    ."      list_no ASC "
    ." LIMIT :limit_num OFFSET :offset "
    ;

    $arr_prepare =
        array(
            ":list_date"        => $param_arr["list_date"]
            ,":list_imp_flg"    => $param_arr["list_imp_flg"]
            ,":list_clear_flg"  => $param_arr["list_clear_flg"]
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

// --------------------
// 리스트 제목 검색하는 함수
// --------------------
function select_list_search( &$param_arr )
{
    $sql = 
    " SELECT "
    ."      list_title "
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
    ."      list_no ASC "
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

?>