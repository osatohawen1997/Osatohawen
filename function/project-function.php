<?php

function myName(){

    global $connect;

    include_once "../admin/decrypt.php";

    $key = $_ENV['ENCRYPTION_KEY'];

    $id = 1;

    $sqlName = "SELECT `intro-name` FROM `about` WHERE `id` = ?";

    $sqlNamePrep = mysqli_prepare($connect, $sqlName);

    $sqlNameBind = mysqli_stmt_bind_param($sqlNamePrep, "s", $id);

    mysqli_stmt_execute($sqlNamePrep);

    if($sqlNameResult = mysqli_stmt_get_result($sqlNamePrep)){

        $sqlNameNum = mysqli_num_rows($sqlNameResult) > 0;

        if($sqlNameNum){

            $sqlNameFetch = mysqli_fetch_assoc($sqlNameResult);

            $nameFetch = decryptdata($sqlNameFetch['intro-name'], $key);

            echo"
                <span>$nameFetch</span>
            ";

        }
    }
}

function heroTitle(){

    global $connect;

    include_once "../admin/decrypt.php";

    $key = $_ENV['ENCRYPTION_KEY'];

    $id = 1;

    $sqlTitle = "SELECT `intro-about` FROM `about` WHERE `id` = ?";

    $sqlTitlePrep = mysqli_prepare($connect, $sqlTitle);

    $sqlTitleBind = mysqli_stmt_bind_param($sqlTitlePrep, "s", $id);

    mysqli_stmt_execute($sqlTitlePrep);

    if($sqlTitleResult = mysqli_stmt_get_result($sqlTitlePrep)){

        $sqlTitleNum = mysqli_num_rows($sqlTitleResult) > 0;

        if($sqlTitleNum){

            $sqlTitleFetch = mysqli_fetch_assoc($sqlTitleResult);

            $titleFetch = decryptdata($sqlTitleFetch['intro-about'], $key);

            echo"
            <p>$titleFetch</p>
            ";

        }
    }
}

function subTitle(){

    global $connect;

    include_once "../admin/decrypt.php";

    $key = $_ENV['ENCRYPTION_KEY'];

    $id = 1;

    $sqlSubTitle = "SELECT `sub-intro` FROM `about` WHERE `id` = ?";

    $sqlSubTitlePrep = mysqli_prepare($connect, $sqlSubTitle);

    $sqlSubTitleBind = mysqli_stmt_bind_param($sqlSubTitlePrep, "s", $id);

    mysqli_stmt_execute($sqlSubTitlePrep);

    if($sqlSubTitleResult = mysqli_stmt_get_result($sqlSubTitlePrep)){

        $sqlSubTitleNum = mysqli_num_rows($sqlSubTitleResult) > 0;

        if($sqlSubTitleNum){

            $sqlSubTitleFetch = mysqli_fetch_assoc($sqlSubTitleResult);

            $subTitleFetch = decryptdata($sqlSubTitleFetch['sub-intro'], $key);

            echo"
                <p>$subTitleFetch</p>
            ";

        }
    }
}

function heroImage(){

    global $connect;

    $id = 1;

    $sqlHero = "SELECT `hero-image` FROM `about` WHERE `id` = ?";

    $sqlHeroPrep = mysqli_prepare($connect, $sqlHero);

    $sqlHeroBind = mysqli_stmt_bind_param($sqlHeroPrep, "s", $id);

    mysqli_stmt_execute($sqlHeroPrep);

    if($sqlHeroResult = mysqli_stmt_get_result($sqlHeroPrep)){
        
        $sqlHeroNum = mysqli_num_rows($sqlHeroResult) > 0;

        if($sqlHeroNum){

            $sqlHeroFetch = mysqli_fetch_assoc($sqlHeroResult);
            
            if(!empty($heroImage = $sqlHeroFetch['hero-image'])){

                echo"
                
                    <img src='../images/homepage-image-folder/$heroImage' alt='$heroImage' class='img-fluid'>
                
                ";

            }else{

                echo"
                
                    <img src='../images/homepage-image-folder/1768173146557.jpg' alt='Osatohawen-pfp' class='img-fluid'>

                ";

            }
            
        }

    }else{

        die(mysqli_error($connect));
        
    }

}

function subIntroImage(){

    global $connect;

    $id = 1;

    $sqlSubIntro = "SELECT `sub-intro-image` FROM `about` WHERE `id` = ?";

    $sqlSubIntroPrep = mysqli_prepare($connect, $sqlSubIntro);

    $sqlSubIntroBind = mysqli_stmt_bind_param($sqlSubIntroPrep, "s", $id);

    mysqli_stmt_execute($sqlSubIntroPrep);

    if($sqlSubIntroResult = mysqli_stmt_get_result($sqlSubIntroPrep)){
        
        $sqlSubIntroNum = mysqli_num_rows($sqlSubIntroResult) > 0;

        if($sqlSubIntroNum){

            $sqlSubIntroFetch = mysqli_fetch_assoc($sqlSubIntroResult);
            
            if(!empty($subIntroImage = $sqlSubIntroFetch['sub-intro-image'])){

                echo"
                
                    <img src='../images/homepage-image-folder/$subIntroImage' alt='$subIntroImage' class='img-fluid'>
                
                ";

            }else{

                echo"
                
                    <img src='../images/homepage-image-folder/1768173146557.jpg' alt='Osatohawen pfp' class='img-fluid'>

                ";

            }
            
        }

    }else{

        die(mysqli_error($connect));
        
    }

}

// social links

function socialLink(){

    include_once "../admin/decrypt.php";

    global $connect;

    $key = $_ENV['ENCRYPTION_KEY'];

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

function socialLinkFooter(){

    include_once "../admin/decrypt.php";

    global $connect;

    $key = $_ENV['ENCRYPTION_KEY'];

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
                <a href='' class='btn'>
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

function websiteDesktop(){
    
    include_once "../admin/decrypt.php";

    $key = $_ENV['ENCRYPTION_KEY'];

    global $connect;

    $sqlwebsite = "SELECT * FROM `website_projects` ORDER BY `date` ASC";

    $sqlwebsitePrep = mysqli_prepare($connect, $sqlwebsite);

    mysqli_stmt_execute($sqlwebsitePrep);

    if($sqlwebsiteResult = mysqli_stmt_get_result($sqlwebsitePrep)){
        
        $sqlwebsiteNum = mysqli_num_rows($sqlwebsiteResult) > 0;

        if($sqlwebsiteNum){
            while($sqlwebsiteFetch = mysqli_fetch_assoc($sqlwebsiteResult)){

                $websiteId = $sqlwebsiteFetch['project_id'];

                $websiteName = decryptdata($sqlwebsiteFetch['name'], $key);

                $websiteImage = $sqlwebsiteFetch['project_image'];

                echo"
                
                <div class='project-card'>
                    <div class='image-box'>
                        <img src='../images/website-snippet-folder/$websiteImage' alt='$websiteImage'>
                    </div>
                    <div class='project-title'>
                        <p>$websiteName</p>
                    </div>
                    <div class='title'>
                        <a href='view.php?wr=$websiteId' class='btn'>
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
                        <a href='view.php?gr=$graphicsImage' class='btn'>
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

function websiteProj(){
    
    include_once "../admin/decrypt.php";

    $key = $_ENV['ENCRYPTION_KEY'];

    global $connect;

    $sqlWebsite = "SELECT * FROM `website_projects` ORDER BY RAND() LIMIT 6";

    $sqlWebsitePrep = mysqli_prepare($connect, $sqlWebsite);

    mysqli_stmt_execute($sqlWebsitePrep);

    if($sqlWebsiteResult = mysqli_stmt_get_result($sqlWebsitePrep)){
        
        $sqlWebsiteNum = mysqli_num_rows($sqlWebsiteResult) > 0;

        if($sqlWebsiteNum){
            while($sqlWebsiteFetch = mysqli_fetch_assoc($sqlWebsiteResult)){

                $websiteId = $sqlWebsiteFetch['project_id'];

                $websiteName = decryptdata($sqlWebsiteFetch['name'], $key);

                $websiteLink = decryptdata($sqlWebsiteFetch['project_link'], $key);

                $websiteImage = $sqlWebsiteFetch['project_image'];

                echo"
                
                    <div class='project-card'>
                        <div class='image-box'>
                            <img src='../images/website-snippet-folder/$websiteImage' alt='$websiteImage'>
                        </div>
                        <div class='project-title'>
                            <p>$websiteName</p>
                        </div>
                        <div class='title'>
                            <a href='view.php?wr=$websiteId' class='btn'>
                                <i class='fa-solid fa-arrow-right'></i>
                            </a>
                        </div>
                    </div>
                
                ";

            }
        }
    }

}

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
                            <a href='view.php?gr=$graphicsImage' class='btn'>
                                <i class='fa-solid fa-arrow-right'></i>
                            </a>
                        </div>
                    </div>
                
                ";

            }
        }
    }

}

