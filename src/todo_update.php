<?php

function update_todo_list_info_no( &$param_arr )
{
    $sql = 
    " UPDATE "
    ." todo_list_info "
    ." SET "
    ." list_title = :list_title "
    ." ,list_detail = :list_detail "
    ." ,list_start_date = :list_start_date "
    ." ,list_due_date = :list_due_date "
    ." ,list_imp_flg = :list_imp_flg "
    ." WHERE "
    ." list_no = :list_no "
    ;
    $arr_prepare =
        array(
            ":list_title" => $param_arr["list_title"]
            ,":list_detail" => $param_arr["list_detail"]
            ,":list_start_date" => $param_arr["list_start_date"]
            ,":list_due_date" => $param_arr["list_due_date"] 
            ,":list_imp_flg" => $param_arr["list_imp_flg"] 
            );

    $conn = null;
    try
    {
        db_conn( $conn );
        $conn->beginTransaction();
        $stmt = $conn->prepare( $sql );
        $stmt->execute( $arr_prepare );
        $result_cnt = $stmt->rowCount();
        $conn->commit();
    }
    catch( Exception $e )
    {
        $conn->rollback();
        return $e->getMessage();
        
    }
    finally
    {
        $conn = null; 
    }
    return $result_cnt;
}

?>