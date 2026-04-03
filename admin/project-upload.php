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

<?php
// Web Configuration For Intro Section

if(isset($_POST['intro_name'])){

    $introName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);

    $introNameEncrypt = encryptdata($introName, $key);

    $sqlintroName = "SELECT * FROM `about`";

    $sqlintroNamePrep = mysqli_prepare($connect, $sqlintroName);

    mysqli_stmt_execute($sqlintroNamePrep);

    if($sqlintroNameResult = mysqli_stmt_get_result($sqlintroNamePrep)){

        $sqlintroNameNum = mysqli_num_rows($sqlintroNameResult) > 0;

        if($sqlintroNameNum){

            $id = 1;

            $introNameUpdate = "UPDATE `about` SET `intro-name` = ? WHERE `id` = ?";

            $introNameUpdatePrep = mysqli_prepare($connect, $introNameUpdate);

            $introNameUpdateBind = mysqli_stmt_bind_param($introNameUpdatePrep, "ss", $introNameEncrypt, $id);

            mysqli_stmt_execute($introNameUpdatePrep);

            echo"<p class='alert-success'>Hero Intro Name has been updated successfully.</p>";

        }else{

            $introNameInsert = "INSERT INTO `about` (`intro-name`) VALUES (?)";

            $introNameInsertPrep = mysqli_prepare($connect, $introNameInsert);

            $introNameInsertBind = mysqli_stmt_bind_param($introNameInsertPrep, "s", $introNameEncrypt);

            mysqli_stmt_execute($introNameInsertPrep);

            echo"<p class='alert-success'>Hero Intro Name has been saved successfully.</p>";

        }
    }

}elseif(isset($_POST['intro_about'])){

    $introAbout = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

    $introAboutEncrypt = encryptdata($introAbout, $key);

    $sqlintroAbout = "SELECT * FROM `about`";

    $sqlintroAboutPrep = mysqli_prepare($connect, $sqlintroAbout);

    mysqli_stmt_execute($sqlintroAboutPrep);

    if($sqlintroAboutResult = mysqli_stmt_get_result($sqlintroAboutPrep)){

        $sqlintroAboutNum = mysqli_num_rows($sqlintroAboutResult) > 0;

        if($sqlintroAboutNum){

            $id = 1;

            $introAboutUpdate = "UPDATE `about` SET `intro-about` = ? WHERE `id` = ?";

            $introAboutUpdatePrep = mysqli_prepare($connect, $introAboutUpdate);

            $introAboutUpdateBind = mysqli_stmt_bind_param($introAboutUpdatePrep, "ss", $introAboutEncrypt, $id);

            mysqli_stmt_execute($introAboutUpdatePrep);

            echo"<p class='alert-success'>Hero Intro About has been updated successfully.</p>";

        }else{

            $introAboutInsert = "INSERT INTO `about` (`intro-About`) VALUES (?)";

            $introAboutInsertPrep = mysqli_prepare($connect, $introAboutInsert);

            $introAboutInsertBind = mysqli_stmt_bind_param($introAboutInsertPrep, "s", $introAboutEncrypt);

            mysqli_stmt_execute($introAboutInsertPrep);

            echo"<p class='alert-success'>Hero Intro About has been saved successfully.</p>";

        }
    }

}elseif(isset($_POST['sub_intro_about'])){

    $subIntroAbout = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

    $subIntroAboutEncrypt = encryptdata($subIntroAbout, $key);

    $sqlsubIntroAbout = "SELECT * FROM `about`";

    $sqlsubIntroAboutPrep = mysqli_prepare($connect, $sqlsubIntroAbout);

    mysqli_stmt_execute($sqlsubIntroAboutPrep);

    if($sqlsubIntroAboutResult = mysqli_stmt_get_result($sqlsubIntroAboutPrep)){

        $sqlsubIntroAboutNum = mysqli_num_rows($sqlsubIntroAboutResult) > 0;

        if($sqlsubIntroAboutNum){

            $id = 1;

            $subIntroAboutUpdate = "UPDATE `about` SET `sub-intro` = ? WHERE `id` = ?";

            $subIntroAboutUpdatePrep = mysqli_prepare($connect, $subIntroAboutUpdate);

            $subIntroAboutUpdateBind = mysqli_stmt_bind_param($subIntroAboutUpdatePrep, "ss", $subIntroAboutEncrypt, $id);

            mysqli_stmt_execute($subIntroAboutUpdatePrep);

            echo"<p class='alert-success'>Sub-Intro About has been updated successfully.</p>";

        }else{

            $subIntroAboutInsert = "INSERT INTO `about` (`sub-intro`) VALUES (?)";

            $subIntroAboutInsertPrep = mysqli_prepare($connect, $subIntroAboutInsert);

            $subIntroAboutInsertBind = mysqli_stmt_bind_param($subIntroAboutInsertPrep, "s", $subIntroAboutEncrypt);

            mysqli_stmt_execute($subIntroAboutInsertPrep);

            echo"<p class='alert-success'>Sub-Intro About has been saved successfully.</p>";

        }
    }

}elseif(isset($_POST['hero_intro_image'])){

    $id = 1;

    $image_name = $_FILES['hero_image'] ['name'];
    
    $allowFormats = ['jpeg', 'jpg', 'png', 'JPEG', 'PNG', 'JPG'];

    $fileExtension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

    $maxFileSize = 8 * 1024 * 1024;

    $sqlHero = "SELECT * FROM `about` WHERE `id` = ?";

    $sqlHeroPrep = mysqli_prepare($connect, $sqlHero);

    $sqlHeroBind = mysqli_stmt_bind_param($sqlHeroPrep, "s", $id);

    mysqli_stmt_execute($sqlHeroPrep);

    if($sqlHeroResult = mysqli_stmt_get_result($sqlHeroPrep)){

        $sqlHeroNum = mysqli_num_rows($sqlHeroResult) > 0;

        if($sqlHeroNum){

            $sqlHeroFetch = mysqli_fetch_assoc($sqlHeroResult);
        
            $heroImg = $sqlHeroFetch['hero-image'];

            $existImage = __DIR__ . "/../images/homepage-image-folder/" . $heroImg;

            if(!empty($heroImg) && file_exists($existImage) && is_writable($existImage)){
            
                if(unlink($existImage)){

                    $image_name = $_FILES['hero_image'] ['name'];
        
                    $allowFormats = ['jpeg', 'jpg', 'png', 'JPEG', 'PNG', 'JPG'];

                    $fileExtension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

                    $maxFileSize = 8 * 1024 * 1024;


                    if(!in_array($fileExtension, $allowFormats)){
            
                        echo"<p class='alert-failed'>Invalid image format (Jpeg, Jpg, Png are allowed)</p>";

                    }elseif($_FILES['hero_image'] ['size'] > $maxFileSize){
                        
                        // Check file size if its more than 8mb

                        echo"<p class='alert-failed'>Exceeded File Size (8MB).</p>";
                                                                    
                    }else{

                        $heroImgUniqId = uniqid('hero_image_' . $fileExtension);
                        
                        $uploadTo = __DIR__.'/../images/homepage-image-folder/' . basename($heroImgUniqId);

                        if(move_uploaded_file($_FILES['hero_image']['tmp_name'], $uploadTo)){

                            $sqlUpdate = "UPDATE `about` SET `hero-image` = ? WHERE `id` = ?";

                            $sqlUpdatePrep = mysqli_prepare($connect, $sqlUpdate);

                            $sqlUpdateBind = mysqli_stmt_bind_param($sqlUpdatePrep, "ss", $heroImgUniqId, $id);

                            if(mysqli_stmt_execute($sqlUpdatePrep)){

                                echo"<p class='alert-success'>Hero Image Updated Successfully.</p>";
                                
                            }else{
                                die(mysqli_error($connect));
                            }
                            
                        }
                    }
                }
            
            }else{
            
                if(!in_array($fileExtension, $allowFormats)){
                
                    echo"<p class='alert-failed'>Invalid image format (Jpeg, Jpg, Png are allowed)</p>";
        
                }elseif($_FILES['hero_image'] ['size'] > $maxFileSize){
                    
                    // Check file size if its more than 5mb
            
                    echo"<p class='alert-failed'>Exceeded File Size (5MB).</p>";
                                                                
                                                                
                }else{

                    $heroImgUniqId = uniqid('hero_image_' . $fileExtension);
                    
                    $uploadTo = __DIR__.'/../images/homepage-image-folder/' . basename($heroImgUniqId);
            
                    $sqlUpdate = "UPDATE `about` SET `hero-image` = ? WHERE `id` = ?";
                    
                    $sqlUpdatePrep = mysqli_prepare($connect, $sqlUpdate);

                    $sqlUpdateBind = mysqli_stmt_bind_param($sqlUpdatePrep, "ss", $heroImgUniqId, $id);
            
                    if(mysqli_stmt_execute($sqlUpdatePrep)){

                        move_uploaded_file($_FILES['hero_image']['tmp_name'], $uploadTo);

                        echo"<p class='alert-success'>Hero Image Added Successfully.</p>";

                    }else{

                        die(mysqli_error($connect));

                    }
                }
            
            }

        }else{
            
            if(!in_array($fileExtension, $allowFormats)){
                
                echo"<p class='alert-failed'>Invalid image format (Jpeg, Jpg, Png are allowed)</p>";
        
            }elseif($_FILES['hero_image'] ['size'] > $maxFileSize){
                
                // Check file size if its more than 5mb
        
                echo"<p class='alert-failed'>Exceeded File Size (5MB).</p>";
                                                             
                                                             
            }else{
                $heroImgUniqId = uniqid('hero_image_' . $fileExtension);
                
                $uploadTo = __DIR__.'/../images/homepage-image-folder/' . basename($heroImgUniqId);
        
                if(move_uploaded_file($_FILES['hero_image']['tmp_name'], $uploadTo)){

                    $heroInsert = "INSERT INTO `about` (`hero-image`) VALUES (?)";
            
                    $heroPrep = mysqli_prepare($connect, $heroInsert);
            
                    $heroBind = mysqli_stmt_bind_param($heroPrep, "s", $heroImgUniqId);
            
                    mysqli_stmt_execute($heroPrep);
                    
                    echo"<p class='alert-success'>Hero Image Added Successfully.</p>";
                    
                }
            }

        }

    }else{
        die(mysqli_error($connect));
    }

}elseif(isset($_POST['sub_intro_image'])){

    $id = 1;

    $image_name = $_FILES['sub_image']['name'];
    
    $allowFormats = ['jpeg', 'jpg', 'png', 'JPEG', 'PNG', 'JPG'];

    $fileExtension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

    $maxFileSize = 8 * 1024 * 1024;

    $sqlSubHero = "SELECT * FROM `about` WHERE `id` = ?";

    $sqlSubHeroPrep = mysqli_prepare($connect, $sqlSubHero);

    $sqlSubHeroBind = mysqli_stmt_bind_param($sqlSubHeroPrep, "s", $id);

    mysqli_stmt_execute($sqlSubHeroPrep);

    if($sqlSubHeroResult = mysqli_stmt_get_result($sqlSubHeroPrep)){

        $sqlSubHeroNum = mysqli_num_rows($sqlSubHeroResult) > 0;

        if($sqlSubHeroNum){

            $sqlSubHeroFetch = mysqli_fetch_assoc($sqlSubHeroResult);
        
            $subHeroImg = $sqlSubHeroFetch['sub-intro-image'];

            $subExistImage = __DIR__ . "/../images/homepage-image-folder/" . $subHeroImg;

            if(!empty($subHeroImg) && file_exists($subExistImage) && is_writable($subExistImage)){
            
                if(unlink($subExistImage)){

                    $image_name = $_FILES['sub_image'] ['name'];
        
                    $allowFormats = ['jpeg', 'jpg', 'png', 'JPEG', 'PNG', 'JPG'];

                    $fileExtension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

                    $maxFileSize = 8 * 1024 * 1024;


                    if(!in_array($fileExtension, $allowFormats)){
            
                        echo"<p class='alert-failed'>Invalid image format (Jpeg, Jpg, Png are allowed)</p>";

                    }elseif($_FILES['sub_image'] ['size'] > $maxFileSize){
                        
                        // Check file size if its more than 8mb

                        echo"<p class='alert-failed'>Exceeded File Size (8MB).</p>";
                                                                    
                    }else{

                        $subHeroImgUniqId = uniqid('sub_image_' . $fileExtension);
                        
                        $uploadTo = __DIR__.'/../images/homepage-image-folder/' . basename($subHeroImgUniqId);

                        if(move_uploaded_file($_FILES['sub_image']['tmp_name'], $uploadTo)){

                            $sqlUpdate = "UPDATE `about` SET `sub-intro-image` = ? WHERE `id` = ?";

                            $sqlUpdatePrep = mysqli_prepare($connect, $sqlUpdate);

                            $sqlUpdateBind = mysqli_stmt_bind_param($sqlUpdatePrep, "ss", $subHeroImgUniqId, $id);

                            if(mysqli_stmt_execute($sqlUpdatePrep)){

                                echo"<p class='alert-success'>Sub Intro Image Updated Successfully.</p>";
                                
                            }else{
                                die(mysqli_error($connect));
                            }
                            
                        }
                    }
                }
            
            }else{
            
                if(!in_array($fileExtension, $allowFormats)){
                
                    echo"<p class='alert-failed'>Invalid image format (Jpeg, Jpg, Png are allowed)</p>";
        
                }elseif($_FILES['sub_image'] ['size'] > $maxFileSize){
                    
                    // Check file size if its more than 5mb
            
                    echo"<p class='alert-failed'>Exceeded File Size (5MB).</p>";
                                                                
                                                                
                }else{

                    $subHeroImgUniqId = uniqid('sub_image_' . $fileExtension);
                    
                    $uploadTo = __DIR__.'/../images/homepage-image-folder/' . basename($subHeroImgUniqId);
            
                    $sqlUpdate = "UPDATE `about` SET `sub-intro-image` = ? WHERE `id` = ?";
                    
                    $sqlUpdatePrep = mysqli_prepare($connect, $sqlUpdate);

                    $sqlUpdateBind = mysqli_stmt_bind_param($sqlUpdatePrep, "ss", $subHeroImgUniqId, $id);
            
                    if(mysqli_stmt_execute($sqlUpdatePrep)){

                        move_uploaded_file($_FILES['sub_image']['tmp_name'], $uploadTo);

                        echo"<p class='alert-success'>Sub Intro Image Added Successfully.</p>";

                    }else{

                        die(mysqli_error($connect));

                    }
                }
            
            }

        }else{
            
            if(!in_array($fileExtension, $allowFormats)){
                
                echo"<p class='alert-failed'>Invalid image format (Jpeg, Jpg, Png are allowed)</p>";
        
            }elseif($_FILES['sub_image'] ['size'] > $maxFileSize){
                
                // Check file size if its more than 5mb
        
                echo"<p class='alert-failed'>Exceeded File Size (5MB).</p>";
                                                             
                                                             
            }else{
 
                $subHeroImgUniqId = uniqid('sub_image_' . $fileExtension);
                
                $subHeroInsert = "INSERT INTO `about` (`sub-intro-image`) VALUES (?)";
        
                $subHeroPrep = mysqli_prepare($connect, $subHeroInsert);
        
                $subHeroBind = mysqli_stmt_bind_param($subHeroPrep, "s", $subHeroImgUniqId);
        
                if(mysqli_stmt_execute($subHeroPrep)){

                    $uploadTo = __DIR__.'/../images/homepage-image-folder/' . basename($subHeroImgUniqId);
                    
                    if(move_uploaded_file($_FILES['sub_image']['tmp_name'], $uploadTo)){
                        
                        echo"<p class='alert-success'>Sub Intro Image Added Successfully.</p>";
    
                    }

                }else{
                    die(mysqli_error($connect));
                }
                
            }

        }

    }else{
        die(mysqli_error($connect));
    }

}


?>

<?php

// Web Configuration For Social Links

if(isset($_POST['telegram_link'])){

    $telegram = filter_input(INPUT_POST, 'telegram', FILTER_SANITIZE_SPECIAL_CHARS);

    $telegramEncrypt = encryptdata($telegram, $key);

    $sqlTelegram = "SELECT * FROM `social_link`";

    $sqlTelegramPrep = mysqli_prepare($connect, $sqlTelegram);

    mysqli_stmt_execute($sqlTelegramPrep);

    if($sqlTelegramResult = mysqli_stmt_get_result($sqlTelegramPrep)){

        $sqlTelegramNum = mysqli_num_rows($sqlTelegramResult) > 0;

        if($sqlTelegramNum){

            $id = 1;

            $telegramUpdate = "UPDATE `social_link` SET `telegram` = ? WHERE `id` = ?";

            $telegramUpdatePrep = mysqli_prepare($connect, $telegramUpdate);

            $telegramUpdateBind = mysqli_stmt_bind_param($telegramUpdatePrep, "ss", $telegramEncrypt, $id);

            mysqli_stmt_execute($telegramUpdatePrep);

            echo"<p class='alert-success'>Telegram has been updated successfully.</p>";

        }else{

            $telegramInsert = "INSERT INTO `social_link` (`telegram`) VALUES (?)";

            $telegramInsertPrep = mysqli_prepare($connect, $telegramInsert);

            $telegramInsertBind = mysqli_stmt_bind_param($telegramInsertPrep, "s", $telegramEncrypt);

            mysqli_stmt_execute($telegramInsertPrep);

            echo"<p class='alert-success'>Telegram has been saved successfully.</p>";

        }
    }

}elseif(isset($_POST['twitter_link'])){

    $twitter = filter_input(INPUT_POST, 'twitter', FILTER_SANITIZE_SPECIAL_CHARS);

    $twitterEncrypt = encryptdata($twitter, $key);

    $sqlTwitter = "SELECT * FROM `social_link`";

    $sqlTwitterPrep = mysqli_prepare($connect, $sqlTwitter);

    mysqli_stmt_execute($sqlTwitterPrep);

    if($sqlTwitterResult = mysqli_stmt_get_result($sqlTwitterPrep)){

        $sqlTwitterNum = mysqli_num_rows($sqlTwitterResult) > 0;

        if($sqlTwitterNum){

            $id = 1;

            $twitterUpdate = "UPDATE `social_link` SET `twitter` = ? WHERE `id` = ?";

            $twitterUpdatePrep = mysqli_prepare($connect, $twitterUpdate);

            $twitterUpdateBind = mysqli_stmt_bind_param($twitterUpdatePrep, "ss", $twitterEncrypt, $id);

            mysqli_stmt_execute($twitterUpdatePrep);

            echo"<p class='alert-success'>Twitter has been updated successfully.</p>";

        }else{

            $twitterInsert = "INSERT INTO `social_link` (`twitter`) VALUES (?)";

            $twitterInsertPrep = mysqli_prepare($connect, $twitterInsert);

            $twitterInsertBind = mysqli_stmt_bind_param($twitterInsertPrep, "s", $twitterEncrypt);

            mysqli_stmt_execute($twitterInsertPrep);

            echo"<p class='alert-success'>Twitter has been saved successfully.</p>";

        }
    }

}elseif(isset($_POST['discord_link'])){

    $discord = filter_input(INPUT_POST, 'discord', FILTER_SANITIZE_SPECIAL_CHARS);

    $discordEncrypt = encryptdata($discord, $key);

    $sqlDiscord = "SELECT * FROM `social_link`";

    $sqlDiscordPrep = mysqli_prepare($connect, $sqlDiscord);

    mysqli_stmt_execute($sqlDiscordPrep);

    if($sqlDiscordResult = mysqli_stmt_get_result($sqlDiscordPrep)){

        $sqlDiscordNum = mysqli_num_rows($sqlDiscordResult) > 0;

        if($sqlDiscordNum){

            $id = 1;

            $discordUpdate = "UPDATE `social_link` SET `discord` = ? WHERE `id` = ?";

            $discordUpdatePrep = mysqli_prepare($connect, $discordUpdate);

            $discordUpdateBind = mysqli_stmt_bind_param($discordUpdatePrep, "ss", $discordEncrypt, $id);

            mysqli_stmt_execute($discordUpdatePrep);

            echo"<p class='alert-success'>Discord has been updated successfully.</p>";

        }else{

            $discordInsert = "INSERT INTO `social_link` (`discord`) VALUES (?)";

            $discordInsertPrep = mysqli_prepare($connect, $discordInsert);

            $discordInsertBind = mysqli_stmt_bind_param($discordInsertPrep, "s", $discordEncrypt);

            mysqli_stmt_execute($discordInsertPrep);

            echo"<p class='alert-success'>Discord has been saved successfully.</p>";

        }
    }

}elseif(isset($_POST['github_link'])){

    $github = filter_input(INPUT_POST, 'github', FILTER_SANITIZE_SPECIAL_CHARS);

    $githubEncrypt = encryptdata($github, $key);

    $sqlGithub = "SELECT * FROM `social_link`";

    $sqlGithubPrep = mysqli_prepare($connect, $sqlGithub);

    mysqli_stmt_execute($sqlGithubPrep);

    if($sqlGithubResult = mysqli_stmt_get_result($sqlGithubPrep)){

        $sqlGithubNum = mysqli_num_rows($sqlGithubResult) > 0;

        if($sqlGithubNum){

            $id = 1;

            $githubUpdate = "UPDATE `social_link` SET `github` = ? WHERE `id` = ?";

            $githubUpdatePrep = mysqli_prepare($connect, $githubUpdate);

            $githubUpdateBind = mysqli_stmt_bind_param($githubUpdatePrep, "ss", $githubEncrypt, $id);

            mysqli_stmt_execute($githubUpdatePrep);

            echo"<p class='alert-success'>Github has been updated successfully.</p>";

        }else{

            $githubInsert = "INSERT INTO `social_link` (`github`) VALUES (?)";

            $githubInsertPrep = mysqli_prepare($connect, $githubInsert);

            $githubInsertBind = mysqli_stmt_bind_param($githubInsertPrep, "s", $githubEncrypt);

            mysqli_stmt_execute($githubInsertPrep);

            echo"<p class='alert-success'>Github has been saved successfully.</p>";

        }
    }

}elseif(isset($_POST['email_address'])){

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);

    $emailEncrypt = encryptdata($email, $key);

    $sqlEmail = "SELECT * FROM `social_link`";

    $sqlEmailPrep = mysqli_prepare($connect, $sqlEmail);

    mysqli_stmt_execute($sqlEmailPrep);

    if($sqlEmailResult = mysqli_stmt_get_result($sqlEmailPrep)){

        $sqlEmailNum = mysqli_num_rows($sqlEmailResult) > 0;

        if($sqlEmailNum){

            $id = 1;

            $emailUpdate = "UPDATE `social_link` SET `email` = ? WHERE `id` = ?";

            $emailUpdatePrep = mysqli_prepare($connect, $emailUpdate);

            $emailUpdateBind = mysqli_stmt_bind_param($emailUpdatePrep, "ss", $emailEncrypt, $id);

            mysqli_stmt_execute($emailUpdatePrep);

            echo"<p class='alert-success'>Email Address has been updated successfully.</p>";

        }else{

            $emailInsert = "INSERT INTO `social_link` (`email`) VALUES (?)";

            $emailInsertPrep = mysqli_prepare($connect, $emailInsert);

            $emailInsertBind = mysqli_stmt_bind_param($emailInsertPrep, "s", $emailEncrypt);

            mysqli_stmt_execute($emailInsertPrep);

            echo"<p class='alert-success'>Email Address has been saved successfully.</p>";

        }
    }

}elseif(isset($_POST['linkedin_link'])){

    $linkedin = filter_input(INPUT_POST, 'linkedin', FILTER_SANITIZE_SPECIAL_CHARS);

    $linkedinEncrypt = encryptdata($linkedin, $key);

    $sqlLinkedin = "SELECT * FROM `social_link`";

    $sqlLinkedinPrep = mysqli_prepare($connect, $sqlLinkedin);

    mysqli_stmt_execute($sqlLinkedinPrep);

    if($sqlLinkedinResult = mysqli_stmt_get_result($sqlLinkedinPrep)){

        $sqlLinkedinNum = mysqli_num_rows($sqlLinkedinResult) > 0;

        if($sqlLinkedinNum){

            $id = 1;

            $linkedinUpdate = "UPDATE `social_link` SET `linkedin` = ? WHERE `id` = ?";

            $linkedinUpdatePrep = mysqli_prepare($connect, $linkedinUpdate);

            $linkedinUpdateBind = mysqli_stmt_bind_param($linkedinUpdatePrep, "ss", $linkedinEncrypt, $id);

            mysqli_stmt_execute($linkedinUpdatePrep);

            echo"<p class='alert-success'>Linkedin has been updated successfully.</p>";

        }else{

            $linkedinInsert = "INSERT INTO `social_link` (`linkedin`) VALUES (?)";

            $linkedinInsertPrep = mysqli_prepare($connect, $linkedinInsert);

            $linkedinInsertBind = mysqli_stmt_bind_param($linkedinInsertPrep, "s", $linkedinEncrypt);

            mysqli_stmt_execute($linkedinInsertPrep);

            echo"<p class='alert-success'>Linkedin has been saved successfully.</p>";

        }
    }

}


?>