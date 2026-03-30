<?php

function socialLink(){

    include_once "../admin/decrypt.php";

    global $connect;

    $id = 1;

    $sqlSocial = "SELECT * FROM `social_link` WHERE `id` = ?";

    $sqlSocialPrep = mysqli_prepare($connect, $sqlSocial);

    $sqlSocialBind = mysqli_stmt_bind_param($sqlSocialPrep, "s", $id);

    mysqli_stmt_execute($sqlSocialPrep);

    if($sqlSocialResult = mysqli_stmt_get_result($sqlSocialPrep)){

        $sqlSocialNum = mysqli_num_rows($sqlSocialResult) > 0;

        if($sqlSocialNum){

            $sqlSocialFetch = mysqli_fetch_assoc($sqlSocialResult);

            $SocialTelegram = decryptdata($sqlSocialFetch['telegram'], $key);
            $SocialTwitter = decryptdata($sqlSocialFetch['twitter'], $key);
            $SocialDiscord = decryptdata($sqlSocialFetch['discord'], $key);
            $SocialGithub = decryptdata($sqlSocialFetch['github'], $key);
            $SocialEmail = decryptdata($sqlSocialFetch['email'], $key);
            $SocialLinkedin = decryptdata($sqlSocialFetch['linkedin'], $key);

            echo"
            
                <a href='$SocialTelegram' class='btn'>
                    <i class='fa-brands fa-telegram'></i>
                </a>
                <a href='$SocialTwitter' class='btn' target='_blank'>
                    <i class='fa-brands fa-x-twitter'></i>
                </a>
                <a href='$SocialDiscord' class='btn'>
                    <i class='fa-brands fa-discord'></i>
                </a>
                <a href='$SocialGithub' class='btn'>
                    <i class='fa-brands fa-github'></i>
                </a>
                <a href='mailto:$SocialEmail' class='btn'>
                    <i class='fa-solid fa-envelope'></i>
                </a>
                <a href='$SocialLinkedin' class='btn'>
                    <i class='fa-brands fa-linkedin'></i>
                </a>   
            
            ";

        }else{

            echo"
            
                <a href='' class='btn'>
                    <i class='fa-brands fa-telegram'></i>
                </a>
                <a href='' class='btn' target='_blank'>
                    <i class='fa-brands fa-x-twitter'></i>
                </a>
                <a href='' class='btn'>
                    <i class='fa-brands fa-discord'></i>
                </a>
                <a href='' class='btn'>
                    <i class='fa-brands fa-github'></i>
                </a>
                <a href='' class='btn'>
                    <i class='fa-solid fa-envelope'></i>
                </a>
                <a href='' class='btn'>
                    <i class='fa-brands fa-linkedin'></i>
                </a>   
            
            ";

        }
    }

}

// for Desktop View

function graphicsDesignDesktop(){
    
    include_once "../admin/decrypt.php";

    $key = $_ENV['ENCRYPTION_KEY'];

    global $connect;

    $sqlGraphics = "SELECT * FROM `graphics_design_projects` ORDER BY `date` ASC";

    $sqlGraphicsPrep = mysqli_prepare($connect, $sqlGraphics);

    mysqli_stmt_execute($sqlGraphicsPrep);

    if($sqlGraphicsResult = mysqli_stmt_get_result($sqlGraphicsPrep)){
        
        $sqlGraphicsNum = mysqli_num_rows($sqlGraphicsResult) > 0;

        if($sqlGraphicsNum){
            while($sqlGraphicsFetch = mysqli_fetch_assoc($sqlGraphicsResult)){

                $graphicsId = $sqlGraphicsFetch['project_id'];

                $graphicsName = decryptdata($sqlGraphicsFetch['name'], $key);

                $graphicsImage = $sqlGraphicsFetch['image'];

                echo"
                
                <div class='project-card'>
                    <div class='image-box'>
                        <img src='../images/graphics-design-folder/$graphicsImage' alt='$graphicsImage'>
                    </div>
                    <div class='project-title'>
                        <p>$graphicsName</p>
                    </div>
                    <div class='title'>
                        <a href='#' target='_blank' class='btn'>
                            <i class='fa-solid fa-arrow-right'></i>
                        </a>
                    </div>
                </div>
                
                ";

            }
        }else{
            echo"
                <p class='text-center'>No Project Available.</p>
            ";
        }
    }

}

// for mobile view
function graphicsDesign(){
    
    include_once "../admin/decrypt.php";

    $key = $_ENV['ENCRYPTION_KEY'];

    global $connect;

    $sqlGraphics = "SELECT * FROM `graphics_design_projects` ORDER BY RAND() LIMIT 6";

    $sqlGraphicsPrep = mysqli_prepare($connect, $sqlGraphics);

    mysqli_stmt_execute($sqlGraphicsPrep);

    if($sqlGraphicsResult = mysqli_stmt_get_result($sqlGraphicsPrep)){
        
        $sqlGraphicsNum = mysqli_num_rows($sqlGraphicsResult) > 0;

        if($sqlGraphicsNum){
            while($sqlGraphicsFetch = mysqli_fetch_assoc($sqlGraphicsResult)){

                $graphicsId = $sqlGraphicsFetch['project_id'];

                $graphicsName = decryptdata($sqlGraphicsFetch['name'], $key);

                $graphicsImage = $sqlGraphicsFetch['image'];

                echo"
                
                    <div class='project-card'>
                        <div class='image-box'>
                            <img src='../images/graphics-design-folder/$graphicsImage' alt='$graphicsImage'>
                        </div>
                        <div class='project-title'>
                            <p>$graphicsName</p>
                        </div>
                        <div class='title'>
                            <a href='#' target='_blank' class='btn'>
                                <i class='fa-solid fa-arrow-right'></i>
                            </a>
                        </div>
                    </div>
                
                ";

            }
        }
    }

}