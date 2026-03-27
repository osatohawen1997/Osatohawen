<?php

include_once "../php/encrypt.php";

if(isset($_POST['add_website'])){

    $projName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $encryptName = encryptdata($projName, $key);

    $projId = uniqid('website_project_', true);

    $projLink = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_SPECIAL_CHARS);

    $encryptLink = encryptdata($projLink, $key);

    $techStack = filter_input(INPUT_POST, 'tech_stack', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $encryptStack = encryptdata($techStack, $key);

    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);

    $encryptDesc = encryptdata($description, $key);
    
    $image_name = $_FILES['image'] ['name'];
    
    $allowFormats = ['jpeg', 'jpg', 'png', 'JPEG', 'PNG', 'JPG'];

    $fileExtension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

    $maxFileSize = 5 * 1024 * 1024;

    if(!in_array($fileExtension, $allowFormats)){
        
        echo"<p class='alert-failed'>Invalid image format (Jpeg, Jpg, Png are allowed)</p>";

    }elseif($_FILES['image'] ['size'] > $maxFileSize){
        
        // Check file size if its more than 5mb

        echo"<p class='alert-failed'>Exceeded File Size (5MB).</p>";
                                                     
                                                     
    }else{
        $projImgUniqId = uniqid('website_' . $fileExtension);
        
        $uploadTo = __DIR__.'/../images/website-snippet-folder/' . basename($projImgUniqId);

        if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadTo)){
            $webInsert = "INSERT INTO `website_projects` (`name`, `project_id`, `description`, `project_image`, `tech_stack`, `project_link`) VALUES (?, ?, ?, ?, ?, ?)";
    
            $webPrep = mysqli_prepare($connect, $webInsert);
    
            $webBind = mysqli_stmt_bind_param($webPrep, "ssssss", $encryptName, $projId, $encryptDesc, $projImgUniqId, $encryptStack, $encryptLink);
    
            mysqli_stmt_execute($webPrep);
            
            echo"<p class='alert-success'>Project Added Successfully.</p>";
            
        }
    }
    
}elseif(isset($_POST['add_graphics'])){

    $projId = uniqid('graphics_project_', true);

    $projName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $encryptName = encryptdata($projName, $key);

    $projTool = filter_input(INPUT_POST, 'tool', FILTER_SANITIZE_SPECIAL_CHARS);

    $encryptTool = encryptdata($projTool, $key);
    
    $image_name = $_FILES['image'] ['name'];
    
    $allowFormats = ['jpeg', 'jpg', 'png', 'JPEG', 'PNG', 'JPG'];

    $fileExtension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

    $maxFileSize = 8 * 1024 * 1024;

    if(!in_array($fileExtension, $allowFormats)){
        
        echo"<p class='alert-failed'>Invalid image format (Jpeg, Jpg, Png are allowed)</p>";

    }elseif($_FILES['image'] ['size'] > $maxFileSize){
        
        // Check file size if its more than 5mb

        echo"<p class='alert-failed'>Exceeded File Size (5MB).</p>";
                                                     
                                                     
    }else{
        $projImgUniqId = uniqid('graphics_' . $fileExtension);
        
        $uploadTo = __DIR__.'/../images/graphics-design-folder/' . basename($projImgUniqId);

        if(move_uploaded_file($_FILES['image']['tmp_name'], $uploadTo)){
            $graphicsInsert = "INSERT INTO `graphics_design_projects` (`name`, `project_id`, `tools`, `image`) VALUES (?, ?, ?, ?)";
    
            $graphicsPrep = mysqli_prepare($connect, $graphicsInsert);
    
            $graphicsBind = mysqli_stmt_bind_param($graphicsPrep, "ssss", $encryptName, $projId, $encryptTool, $projImgUniqId);
    
            mysqli_stmt_execute($graphicsPrep);
            
            echo"<p class='alert-success'>Project Added Successfully.</p>";
            
        }
    }
    
}

?>

<?php

// Update Website Project

if(isset($_POST['update_website_name'])){

    $webProjId = $_GET['webproject'];

    $sqlSelect = "SELECT * FROM `website_projects` WHERE `project_id` = ?";

    $sqlPrep = mysqli_prepare($connect, $sqlSelect);

    $sqlBind = mysqli_stmt_bind_param($sqlPrep, "s", $webProjId);

    mysqli_stmt_execute($sqlPrep);

    $sqlResult = mysqli_stmt_get_result($sqlPrep);

    if($sqlNum = mysqli_num_rows($sqlResult) > 0){

        $webName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);

        $encryptName = encryptdata($webName, $key);

        $sqlUpdate = "UPDATE `website_projects` SET `name` = ?, `last_update` = NOW() WHERE `project_id` = ?";

        $sqlUpdatePrep = mysqli_prepare($connect, $sqlUpdate);

        $sqlUpdateBind = mysqli_stmt_bind_param($sqlUpdatePrep, "ss", $encryptName, $webProjId);

        if(mysqli_stmt_execute($sqlUpdatePrep)){

            echo"<p class='alert-success'>Project Name Updated Successfully.</p>";
            
        }else{
            die(mysqli_error($connect));
        }
    }

}elseif(isset($_POST['update_website_stack'])){

    $webProjId = $_GET['webproject'];

    $sqlSelect = "SELECT * FROM `website_projects` WHERE `project_id` = ?";

    $sqlPrep = mysqli_prepare($connect, $sqlSelect);

    $sqlBind = mysqli_stmt_bind_param($sqlPrep, "s", $webProjId);

    mysqli_stmt_execute($sqlPrep);

    $sqlResult = mysqli_stmt_get_result($sqlPrep);

    if($sqlNum = mysqli_num_rows($sqlResult) > 0){

        $webStack = filter_input(INPUT_POST, 'stack', FILTER_SANITIZE_SPECIAL_CHARS);

        $encryptStack = encryptdata($webStack, $key);

        $sqlUpdate = "UPDATE `website_projects` SET `tech_stack` = ?, `last_update` = NOW() WHERE `project_id` = ?";

        $sqlUpdatePrep = mysqli_prepare($connect, $sqlUpdate);

        $sqlUpdateBind = mysqli_stmt_bind_param($sqlUpdatePrep, "ss", $encryptStack, $webProjId);

        if(mysqli_stmt_execute($sqlUpdatePrep)){

            echo"<p class='alert-success'>Project Stack Updated Successfully.</p>";
            
        }else{
            die(mysqli_error($connect));
        }
    }

}elseif(isset($_POST['update_website_link'])){

    $webProjId = $_GET['webproject'];

    $sqlSelect = "SELECT * FROM `website_projects` WHERE `project_id` = ?";

    $sqlPrep = mysqli_prepare($connect, $sqlSelect);

    $sqlBind = mysqli_stmt_bind_param($sqlPrep, "s", $webProjId);

    mysqli_stmt_execute($sqlPrep);

    $sqlResult = mysqli_stmt_get_result($sqlPrep);

    if($sqlNum = mysqli_num_rows($sqlResult) > 0){

        $webLink = filter_input(INPUT_POST, 'link', FILTER_SANITIZE_SPECIAL_CHARS);

        $encryptLink = encryptdata($webLink, $key);

        $sqlUpdate = "UPDATE `website_projects` SET `project_link` = ?, `last_update` = NOW() WHERE `project_id` = ?";

        $sqlUpdatePrep = mysqli_prepare($connect, $sqlUpdate);

        $sqlUpdateBind = mysqli_stmt_bind_param($sqlUpdatePrep, "ss", $encryptLink, $webProjId);

        if(mysqli_stmt_execute($sqlUpdatePrep)){

            echo"<p class='alert-success'>Project Link Updated Successfully.</p>";
            
        }else{
            die(mysqli_error($connect));
        }
    }
}elseif(isset($_POST['update_website_msg'])){

    $webProjId = $_GET['webproject'];

    $sqlSelect = "SELECT * FROM `website_projects` WHERE `project_id` = ?";

    $sqlPrep = mysqli_prepare($connect, $sqlSelect);

    $sqlBind = mysqli_stmt_bind_param($sqlPrep, "s", $webProjId);

    mysqli_stmt_execute($sqlPrep);

    $sqlResult = mysqli_stmt_get_result($sqlPrep);

    if($sqlNum = mysqli_num_rows($sqlResult) > 0){

        $webMsg = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

        $encryptMsg = encryptdata($webMsg, $key);

        $sqlUpdate = "UPDATE `website_projects` SET `description` = ?, `last_update` = NOW() WHERE `project_id` = ?";

        $sqlUpdatePrep = mysqli_prepare($connect, $sqlUpdate);

        $sqlUpdateBind = mysqli_stmt_bind_param($sqlUpdatePrep, "ss", $encryptMsg, $webProjId);

        if(mysqli_stmt_execute($sqlUpdatePrep)){

            echo"<p class='alert-success'>Project Description Updated Successfully.</p>";
            
        }else{
            die(mysqli_error($connect));
        }
    }

}elseif(isset($_POST['update_website_image'])){

    $webProjId = $_GET['webproject'];

    $sqlImgSelect = "SELECT `project_image` FROM `website_projects` WHERE `project_id` = ?";

    $sqlImgPrep = mysqli_prepare($connect, $sqlImgSelect);

    $sqlImgBind = mysqli_stmt_bind_param($sqlImgPrep, "s", $webProjId);

    mysqli_stmt_execute($sqlImgPrep);

    $sqlImgResult = mysqli_stmt_get_result($sqlImgPrep);

    if($sqlImgNum = mysqli_num_rows($sqlImgResult) > 0){

        $sqlFetch = mysqli_fetch_assoc($sqlImgResult);
        
        $projImg = $sqlFetch['project_image'];

        $existImage = __DIR__ . "/../images/website-snippet-folder/" . $projImg;

        if(file_exists($existImage) && is_writable($existImage)){
        
            if(unlink($existImage)){

                $image_name = $_FILES['update_image'] ['name'];
    
                $allowFormats = ['jpeg', 'jpg', 'png', 'JPEG', 'PNG', 'JPG'];

                $fileExtension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

                $maxFileSize = 8 * 1024 * 1024;


                if(!in_array($fileExtension, $allowFormats)){
        
                    echo"<p class='alert-failed'>Invalid image format (Jpeg, Jpg, Png are allowed)</p>";

                }elseif($_FILES['update_image'] ['size'] > $maxFileSize){
                    
                    // Check file size if its more than 8mb

                    echo"<p class='alert-failed'>Exceeded File Size (8MB).</p>";
                                                                
                }else{
                    $projImgUniqId = uniqid('website_' . $fileExtension);
                    
                    $uploadTo = __DIR__.'/../images/website-snippet-folder/' . basename($projImgUniqId);

                    if(move_uploaded_file($_FILES['update_image']['tmp_name'], $uploadTo)){

                        $sqlUpdate = "UPDATE `website_projects` SET `project_image` = ?, `last_update` = NOW() WHERE `project_id` = ?";

                        $sqlUpdatePrep = mysqli_prepare($connect, $sqlUpdate);

                        $sqlUpdateBind = mysqli_stmt_bind_param($sqlUpdatePrep, "ss", $projImgUniqId, $webProjId);

                        if(mysqli_stmt_execute($sqlUpdatePrep)){

                            echo"<p class='alert-success'>Project Image Updated Successfully.</p>";
                            
                        }else{
                            die(mysqli_error($connect));
                        }
                        
                    }
                }
            }
        
        }else{
            echo"<p class='alert-success'>Project Existing Image is not present.</p>";
        }
    }
}

?>

<?php

if(isset($_POST['update_graphics_name'])){

    $graphicsProjId = $_GET['graphicsproject'];

    $sqlSelect = "SELECT * FROM `graphics_design_projects` WHERE `project_id` = ?";

    $sqlPrep = mysqli_prepare($connect, $sqlSelect);

    $sqlBind = mysqli_stmt_bind_param($sqlPrep, "s", $graphicsProjId);

    mysqli_stmt_execute($sqlPrep);

    $sqlResult = mysqli_stmt_get_result($sqlPrep);

    if($sqlNum = mysqli_num_rows($sqlResult) > 0){

        $graphicsName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);

        $encryptName = encryptdata($graphicsName, $key);

        $sqlUpdate = "UPDATE `graphics_design_projects` SET `name` = ?, `last_update` = NOW() WHERE `project_id` = ?";

        $sqlUpdatePrep = mysqli_prepare($connect, $sqlUpdate);

        $sqlUpdateBind = mysqli_stmt_bind_param($sqlUpdatePrep, "ss", $encryptName, $graphicsProjId);

        if(mysqli_stmt_execute($sqlUpdatePrep)){

            echo"<p class='alert-success'>Project Graphics Name Updated Successfully.</p>";
            
        }else{
            die(mysqli_error($connect));
        }
    }

}elseif(isset($_POST['update_graphics_stack'])){

    $graphicsProjId = $_GET['graphicsproject'];

    $sqlSelect = "SELECT * FROM `graphics_design_projects` WHERE `project_id` = ?";

    $sqlPrep = mysqli_prepare($connect, $sqlSelect);

    $sqlBind = mysqli_stmt_bind_param($sqlPrep, "s", $graphicsProjId);

    mysqli_stmt_execute($sqlPrep);

    $sqlResult = mysqli_stmt_get_result($sqlPrep);

    if($sqlNum = mysqli_num_rows($sqlResult) > 0){

        $graphicsStack = filter_input(INPUT_POST, 'stack', FILTER_SANITIZE_SPECIAL_CHARS);

        $encryptStack = encryptdata($graphicsStack, $key);

        $sqlUpdate = "UPDATE `graphics_design_projects` SET `tools` = ?, `last_update` = NOW() WHERE `project_id` = ?";

        $sqlUpdatePrep = mysqli_prepare($connect, $sqlUpdate);

        $sqlUpdateBind = mysqli_stmt_bind_param($sqlUpdatePrep, "ss", $encryptStack, $graphicsProjId);

        if(mysqli_stmt_execute($sqlUpdatePrep)){

            echo"<p class='alert-success'>Project Graphics Tool Updated Successfully.</p>";
            
        }else{
            die(mysqli_error($connect));
        }
    }

}elseif(isset($_POST['update_graphics_image'])){

    $graphicsProjId = $_GET['graphicsproject'];

    $sqlImgSelect = "SELECT `image` FROM `graphics_design_projects` WHERE `project_id` = ?";

    $sqlImgPrep = mysqli_prepare($connect, $sqlImgSelect);

    $sqlImgBind = mysqli_stmt_bind_param($sqlImgPrep, "s", $graphicsProjId);

    mysqli_stmt_execute($sqlImgPrep);

    $sqlImgResult = mysqli_stmt_get_result($sqlImgPrep);

    if($sqlImgNum = mysqli_num_rows($sqlImgResult) > 0){

        $sqlFetch = mysqli_fetch_assoc($sqlImgResult);
        
        $projImg = $sqlFetch['image'];

        $existImage = __DIR__ . "/../images/graphics-design-folder/" . $projImg;

        if(file_exists($existImage) && is_writable($existImage)){
        
            if(unlink($existImage)){

                $image_name = $_FILES['update_image'] ['name'];
    
                $allowFormats = ['jpeg', 'jpg', 'png', 'JPEG', 'PNG', 'JPG'];

                $fileExtension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

                $maxFileSize = 8 * 1024 * 1024;


                if(!in_array($fileExtension, $allowFormats)){
        
                    echo"<p class='alert-failed'>Invalid image format (Jpeg, Jpg, Png are allowed)</p>";

                }elseif($_FILES['update_image'] ['size'] > $maxFileSize){
                    
                    // Check file size if its more than 8mb

                    echo"<p class='alert-failed'>Exceeded File Size (8MB).</p>";
                                                                
                }else{
                    $projImgUniqId = uniqid('graphics_' . $fileExtension);
                    
                    $uploadTo = __DIR__.'/../images/graphics-design-folder/' . basename($projImgUniqId);

                    if(move_uploaded_file($_FILES['update_image']['tmp_name'], $uploadTo)){

                        $sqlUpdate = "UPDATE `graphics_design_projects` SET `image` = ?, `last_update` = NOW() WHERE `project_id` = ?";

                        $sqlUpdatePrep = mysqli_prepare($connect, $sqlUpdate);

                        $sqlUpdateBind = mysqli_stmt_bind_param($sqlUpdatePrep, "ss", $projImgUniqId, $graphicsProjId);

                        if(mysqli_stmt_execute($sqlUpdatePrep)){

                            echo"<p class='alert-success'>Project Graphics Image Updated Successfully.</p>";
                            
                        }else{
                            die(mysqli_error($connect));
                        }
                        
                    }
                }
            }
        
        }else{
            echo"<p class='alert-success'>Project Existing Image is not present.</p>";
        }
    }
}

?>