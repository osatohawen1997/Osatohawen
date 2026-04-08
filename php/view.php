<?php

include "../database-connection/connect-db.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- FAVICON -->
    <link rel="shortcut icon" href="../images/homepage-image-folder/1765198114796.png" type="image/x-icon">

    <!-- Embedded fonts from Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Custom css -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/reponsiveness.css">

    <!-- Bootsstrap Framework -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>

    <div class="container-fluid">
        <div class="row view-row">
            <div class="col-xl-12 col-lg-12 col-sm-12 d-flex justify-content-center align-items-center view-col" style='height: 100vh;'>

                <?php

                if(isset($_GET['gr'])){

                    $gr_id = $_GET['gr'];

                    $grSql = "SELECT `image` FROM `graphics_design_projects` WHERE `image` = ?";

                    $grSqlPrep = mysqli_prepare($connect, $grSql);

                    $grSqlBind = mysqli_stmt_bind_param($grSqlPrep, "s", $gr_id);

                    mysqli_stmt_execute($grSqlPrep);

                    if($grSqlResult = mysqli_stmt_get_result($grSqlPrep)){

                        $grNum = mysqli_num_rows($grSqlResult) > 0;

                        if($grNum){

                            $grFetch = mysqli_fetch_assoc($grSqlResult);

                            $grDisplay = $grFetch['image'];

                            echo"
                            
                                <img src='../images/graphics-design-folder/$grDisplay' alt='$grDisplay' class='img-fluid' style='max-height: 400px; max-width:800px;'>

                            ";

                        }else{

                            header("Location: homepage.php");

                        }

                    }else{

                        die(mysqli_error($connect));

                    }

                }elseif(isset($_GET['wr'])){

                    include_once "../admin/decrypt.php";

                    $key = $_ENV['ENCRYPTION_KEY'];

                    $wr_id = $_GET['wr'];

                    $wrSql = "SELECT * FROM `website_projects` WHERE `project_id` = ?";

                    $wrSqlPrep = mysqli_prepare($connect, $wrSql);

                    $wrSqlBind = mysqli_stmt_bind_param($wrSqlPrep, "s", $wr_id);

                    mysqli_stmt_execute($wrSqlPrep);

                    if($wrSqlResult = mysqli_stmt_get_result($wrSqlPrep)){

                        $wrNum = mysqli_num_rows($wrSqlResult) > 0;

                        if($wrNum){

                            $wrFetch = mysqli_fetch_assoc($wrSqlResult);

                            $wrName = decryptdata($wrFetch['name'], $key);
                            $wrStack = strtoupper(decryptdata($wrFetch['tech_stack'], $key));
                            $wrDesc = decryptdata($wrFetch['description'], $key);
                            $wrLink = decryptdata($wrFetch['project_link'], $key);

                            echo"
                            
                                <div class='p-3 view-container rounded'>

                                    <div class='mb-4 mt-4'>

                                        <span clas='details-container'>
                                            <b>Site Name:</b>
                                            <span>$wrName</span>
                                        </span>
                                    
                                    </div>
                                    
                                    <div class='mb-4'>

                                        <span>
                                            <b>Tech Stack:</b>
                                            <span>$wrStack</span>
                                        </span>
                                    
                                    </div>
                                    
                                    <div class='mb-4'>

                                        <span>
                                            <b>Description:</b>
                                            <span>$wrDesc</span>
                                        </span>
                                    
                                    </div>

                                    <div class='mb-4 mt-5 d-flex justify-content-center'>

                                        <a href='$wrLink' class='btn'>Visit Website</a>
                                    
                                    </div>

                                
                                </div>

                            ";

                        }else{

                            header("Location: homepage.php");

                        }

                    }else{

                        die(mysqli_error($connect));

                    }

                }else{
                    
                    header("Location: homepage.php");
                    
                }

                ?>
            </div>
        </div>
    </div>
    
</body>
</html>

