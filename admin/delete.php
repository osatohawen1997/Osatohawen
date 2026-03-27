<?php

include "../database-connection/connect-db.php";

if(isset($_GET['deletewebproject'])){

    $id = $_GET['deletewebproject'];

    $sqlId = "SELECT * FROM `website_projects` WHERE `project_id` = ?";

    $sqlPrep = mysqli_prepare($connect, $sqlId);

    $sqlBind = mysqli_stmt_bind_param($sqlPrep, "s", $id);

    mysqli_stmt_execute($sqlPrep);

    $sqlResult = mysqli_stmt_get_result($sqlPrep);

    if($sqlNum = mysqli_num_rows($sqlResult) > 0){

        $sqlDelete = "DELETE FROM `website_projects` WHERE `project_id` = ?";

        $sqlDeletePrep = mysqli_prepare($connect, $sqlDelete);

        $sqlDeleteBind = mysqli_stmt_bind_param($sqlDeletePrep, "s", $id);

        if(mysqli_stmt_execute($sqlDeletePrep)){
            echo"
                <script>
                    alert('Website deleted successfully')
                    window.location.href= 'web-project.php';
                </script>
            ";
        }

    }else{
        header("Location: dashboard.php");
    }

}elseif(isset($_GET['deletegraphicsproject'])){

    $id = $_GET['deletegraphicsproject'];

    $sqlId = "SELECT * FROM `graphics_design_projects` WHERE `project_id` = ?";

    $sqlPrep = mysqli_prepare($connect, $sqlId);

    $sqlBind = mysqli_stmt_bind_param($sqlPrep, "s", $id);

    mysqli_stmt_execute($sqlPrep);

    $sqlResult = mysqli_stmt_get_result($sqlPrep);

    if($sqlNum = mysqli_num_rows($sqlResult) > 0){

        $sqlDelete = "DELETE FROM `graphics_design_projects` WHERE `project_id` = ?";

        $sqlDeletePrep = mysqli_prepare($connect, $sqlDelete);

        $sqlDeleteBind = mysqli_stmt_bind_param($sqlDeletePrep, "s", $id);

        if(mysqli_stmt_execute($sqlDeletePrep)){
            echo"
                <script>
                    alert('Graphics deleted successfully')
                    window.location.href= 'graphics-project.php';
                </script>
            ";
        }

    }else{
        header("Location: dashboard.php");
    }

}else{
    header("Location: dashboard.php");
}

?>