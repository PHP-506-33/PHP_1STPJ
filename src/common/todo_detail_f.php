<?php 

include_once( "db_connect.php" );

/*********************************************
함수 : todo_select_detail_info
기능 : list에서 선택한 값에 대한 상세 내용 출력
파라미터 : &$parma_arr (레퍼런스 참조)
리턴 값 : $result
**********************************************/
function todo_select_detail_info( &$param_arr ){
    $sql = 
        " SELECT "
        ." list_no "
        ." ,list_title "
        ." ,list_detail "
        ." ,list_start_date "
        ." ,list_due_date "
        ." ,list_clear_flg "
        ." ,list_imp_flg "
        ." FROM "
        ." todo_list_info "
        ." WHERE "
        ." list_no = :list_no ";

    $arr_prepare = 
            array(
                ":list_no" => $param_arr["list_no"]
            );
    $conn = null; 
    try {
        db_conn($conn);
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result = $stmt->fetchAll();
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $conn = null;
    }
    return $result[0];
}

/*********************************************
함수 : todo_update_detail_list
기능 : 할 일 완료로 변경(clear_flg를 0에서 1로 변경)
파라미터 : &$parma_no (레퍼런스 참조)
리턴 값 : $result_cnt
**********************************************/
function todo_update_detail_list( &$param_no ){
    $sql = 
        " UPDATE "
        ." todo_list_info "
        ." SET "
        ." list_clear_flg = '1' "
        ." ,list_clear_date = now() "
        ." WHERE "
        ." list_no = :list_no ";

    $arr_prepare = 
            array(
                ":list_no" => $param_no
            );
    $conn = null;
    try {
        db_conn($conn);
        $conn->beginTransaction();
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result_cnt = $stmt->rowCount();
        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        return $e->getMessage();
    } finally {
        $conn = null;
    }
    return $result_cnt;
}

/*********************************************
함수 : todo_select_detail_list
기능 : 상세 페이지에 들어온 list_no의 남은 할 일 표시(최대 3개, 당일 할 일만 표시)
파라미터 : &$parma_arr (레퍼런스 참조)
리턴 값 : $result
**********************************************/
function todo_select_detail_list( &$param_date ){
    $sql =
        " SELECT "
        ." list_no "
        ." ,list_title "
        ." ,list_start_date "
        ." ,list_due_date "
        ." FROM "
        ." todo_list_info "
        ." WHERE "
        ." list_clear_flg = '0' "
        ." AND "
        ." DATE_SUB(list_start_date, INTERVAL 1 DAY) <= :list_start_date "
        // ." AND "
        // ." list_start_date = :list_start_date "
        ." ORDER BY list_start_date "
        ." LIMIT 3 ";

    $arr_prepare_2 = array(
        ":list_start_date" => $param_date['list_start_date']
    );
    $conn = null;
    try {
        db_conn($conn);
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare_2 );
        $result = $stmt->fetchAll();
    } catch (Exception $e) {
        return $e->getMessage();
    } finally {
        $conn = null;
    }
    return $result;
}

// todo 
// var_dump(todo_select_detail_list('2023-04-19 09:00:00'));
?>