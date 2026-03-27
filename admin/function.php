<?php
//  Dashboard Start
function visitedUsers(){
    global $connect;

    // total users

    $userSql = "SELECT count(*) AS total FROM cookies";

    $userPrep = mysqli_prepare($connect, $userSql);

    mysqli_stmt_execute($userPrep);

    if($userResult = mysqli_stmt_get_result($userPrep)){

        $count = mysqli_fetch_assoc($userResult);
        $userCount = $count['total'];

        echo"
            
            <div class='stat-value'>$userCount</div>

        ";
    }
}

function todayUser(){

    global $connect;

    // today User
    $todayUser = date("Y-m-d");

    $todayUserSql = "SELECT count(*) AS total FROM cookies WHERE DATE(`visit_time`) = ?";

    $todayUserPrep = mysqli_prepare($connect, $todayUserSql);

    $todayUserBind = mysqli_stmt_bind_param($todayUserPrep, "s", $todayUser);

    mysqli_stmt_execute($todayUserPrep);

    $todayUserResult = mysqli_stmt_get_result($todayUserPrep);

    $todayCountUser = mysqli_fetch_assoc($todayUserResult);

    $todayUserCount = $todayCountUser['total'];

    if($todayUserCount > 0){
        
        echo"
        <small>Today users visit: </small>+$todayUserCount
        ";

    }else{

        echo"
        <small>Today users visit: </small>0
        ";

    }

}

function message(){
    global $connect;

    // today message
    
    // total message

    $messageSql = "SELECT count(*) AS total FROM message";

    $messagePrep = mysqli_prepare($connect, $messageSql);
    
    mysqli_stmt_execute($messagePrep);
    
    if($messageResult = mysqli_stmt_get_result($messagePrep)){
        
        $count = mysqli_fetch_assoc($messageResult);
        $messageCount = $count['total'];

        echo"
            <div class='stat-value'>$messageCount</div>
        ";
    }
}

function todayMessage(){

    global $connect;

    $msgtoday = date('Y-m-d');
    
    $todayMessageSql = "SELECT count(*) AS total FROM message WHERE DATE(`date`) = ?";
    
    $todayMessagePrep = mysqli_prepare($connect, $todayMessageSql);
    
    $todayMessageBind = mysqli_stmt_bind_param($todayMessagePrep, "s", $msgtoday);
    
    mysqli_stmt_execute($todayMessagePrep);
    
    $todayMessageResult = mysqli_stmt_get_result($todayMessagePrep);
    
    $todayCount = mysqli_fetch_assoc($todayMessageResult);
    
    $todayMessageCount = $todayCount['total'];

    if($todayMessageCount > 0){

        echo"
            <small>Today's message: </small>+$todayMessageCount
        ";

    }else{
        echo"
            <small>Today's message: </small>0
        ";
    }


}

function webProject(){

    global $connect;

    $projSql = "SELECT count(*) AS total FROM website_projects";

    $projPrep = mysqli_prepare($connect, $projSql);

    mysqli_stmt_execute($projPrep);

    if($projResult = mysqli_stmt_get_result($projPrep)){
        $projFetch = mysqli_fetch_assoc($projResult);

        $projCount = $projFetch['total'];

        echo"
            <div class='stat-value'>$projCount</div>
        ";
    }
}

function graphicProject(){

    global $connect;

    $projSql = "SELECT count(*) AS total FROM graphics_design_projects";

    $projPrep = mysqli_prepare($connect, $projSql);

    mysqli_stmt_execute($projPrep);

    if($projResult = mysqli_stmt_get_result($projPrep)){
        $projFetch = mysqli_fetch_assoc($projResult);

        $projCount = $projFetch['total'];

        echo"
            <div class='stat-value'>$projCount</div>
        ";
    }
}

function allVisitedUsers(){
    global $connect;

    // total users

    $userSql = "SELECT * FROM cookies";

    $userPrep = mysqli_prepare($connect, $userSql);

    mysqli_stmt_execute($userPrep);

    if($userResult = mysqli_stmt_get_result($userPrep)){

        while($fetch = mysqli_fetch_assoc($userResult)){

            $userId = $fetch['user_id'];
            $userIp = $fetch['ip_address'];
            $userBrowser = $fetch['browser'];
            $userBrowserVersion = $fetch['browser_version'];
            $userOs = $fetch['user_os'];
            $userDevice = $fetch['user_device'];
            $visit = $fetch['visit_time'];
    
            echo"
                
                <tr>
                    <td>
                        <div class='table-user-info'>
                            <span class='table-user-name'>$userId</span>
                        </div>
                    </td>
                    <td>$userIp</td>
                    <td>$userBrowser</td>
                    <td>$userBrowser</td>
                    <td>$userOs</td>
                    <td>$userDevice</td>
                    <td>$visit</td>
                    <td>
                        <button class='card-btn' style='padding: 6px 12px;'>Edit</button>
                    </td>
                </tr>
    
            ";
        }
    }
}

// Dashboard Function Ends

// Notification Page Start

function notificationMsg(){

    global $connect;

    $notSql = "SELECT count(*) AS total FROM message";

    $notPrep = mysqli_prepare($connect, $notSql);

    mysqli_stmt_execute($notPrep);

    if($notResult = mysqli_stmt_get_result($notPrep)){
        $notFetch = mysqli_fetch_assoc($notResult);

        $notCount = $notFetch['total'];

        echo"
            <small class='stat-value'>$notCount</small> 
        ";
    }
}

function totalMsg(){

    global $connect;

    include_once "decrypt.php";

    $msgSql = "SELECT * FROM message ORDER BY `date` DESC";

    $msgPrep = mysqli_prepare($connect, $msgSql);

    mysqli_stmt_execute($msgPrep);

    if($msgResult = mysqli_stmt_get_result($msgPrep)){

        $msgNum = mysqli_num_rows($msgResult) > 0;

        if($msgNum){

            while($msgFetch = mysqli_fetch_assoc($msgResult)){

                $msgFullName = $msgFetch['full_name'];
                $msgEmail = decryptdata($msgFetch['email'], $key);
                $msg = decryptdata($msgFetch['message'], $key);
                $msgId = $msgFetch['message_id'];
                $msgDate = $msgFetch['date'];
        
                
                if(strlen($msg) > 100){
                    
                    $msgShort = substr($msg, 0, 100)."... see more";
                    
                    echo"
                        <a href='reply.php?to=$msgId' class='message'>
                            <div class='message-head'>
                                <b>From:</b>
                                <p>$msgEmail</p>
                            </div>
                            <div class='message-body'>
                                <b>Message:</b>
                                <p>$msgShort</p>
                            </div>
                            <div class='message-action'>
                                <div class='message-date'>
                                    <b>Date:</b>
                                    <p>$msgDate</p>
                                </div>
                            </div>
                        </a>
                    ";

                }else{
                    echo"
                        <a href='reply.php?to=$msgId' class='message'>
                            <div class='message-head'>
                                <b>From:</b>
                                <p>$msgEmail</p>
                            </div>
                            <div class='message-body'>
                                <b>Message:</b>
                                <p>$msg</p>
                            </div>
                            <div class='message-action'>
                                <div class='message-date'>
                                    <b>Date:</b>
                                    <p>$msgDate</p>
                                </div>
                            </div>
                        </a>
                    ";
                }

            }
    

        }else{
            echo"
                <p style='text-align: center;'>No message</p>
            ";
        }

    }
}

function formInput(){
    global $connect;

    include_once "decrypt.php";

    if(isset($_GET['to'])){
        $linkId = $_GET['to'];

        $replySql = "SELECT * FROM message WHERE `message_id` = ?";

        $replyPrep = mysqli_prepare($connect, $replySql);

        $replyBind = mysqli_stmt_bind_param($replyPrep, "s", $linkId);

        mysqli_stmt_execute($replyPrep);

        if($replyResult = mysqli_stmt_get_result($replyPrep)){
            $replyNum = mysqli_num_rows($replyResult) > 0;

            if($replyNum){

                $replyFetch = mysqli_fetch_assoc($replyResult);

                $replyFullName = decryptdata($replyFetch['full_name'], $key);
                $replyEmail = decryptdata($replyFetch['email'], $key);
                
                echo"
                    <div class='form-group'>
                        <label class='form-label' for='name'>Receipent Name</label>
                        <input type='text' name='name' class='form-input' value='$replyFullName' readonly required>
                    </div>
        
                    <div class='form-group'>
                        <label class='form-label' for='email'>Email Address</label>
                        <input type='email' name='email' class='form-input' value='$replyEmail' readonly required>
                    </div>
        
                ";

            }else{
                echo"
                <script>
                window.location.href='notification.php'</script>
                ";
            }
        }
    }else{
        echo"
            <script>
                window.location.href='notification.php'
            </script>
        ";
    }
}

// Notification Page End

// Web project start

function website(){

    global $connect;

    $webSql = "SELECT count(*) AS total FROM website_projects";

    $webPrep = mysqli_prepare($connect, $webSql);

    mysqli_stmt_execute($webPrep);

    if($webResult = mysqli_stmt_get_result($webPrep)){
        $webFetch = mysqli_fetch_assoc($webResult);

        $webCount = $webFetch['total'];

        echo"
            <small class='stat-value'>$webCount</small> 
        ";
    }
}

function totalWeb(){

    include_once "decrypt.php";

    global $connect;

    $websiteSql = "SELECT * FROM website_projects ORDER BY `date` DESC";

    $websitePrep = mysqli_prepare($connect, $websiteSql);

    mysqli_stmt_execute($websitePrep);

    if($websiteResult = mysqli_stmt_get_result($websitePrep)){

        $websiteNum = mysqli_num_rows($websiteResult) > 0;

        if($websiteNum){

            while($websiteFetch = mysqli_fetch_assoc($websiteResult)){

                $websiteId = $websiteFetch['project_id'];
                $websiteName = decryptdata($websiteFetch['name'], $key);
                $description = decryptdata($websiteFetch['description'], $key);
                $websiteStack = decryptdata($websiteFetch['tech_stack'], $key);
                $websiteImg = $websiteFetch['project_image'];
                $websiteDate = $websiteFetch['date'];
                
                echo"
                    <div class='message' style='display: flex; flex-direction: row; align-items: center; padding: 10px; justify-content: space-between;'>
                        <a href='web-edit.php?webproject=$websiteId'>$websiteName</a>

                        <span style='display: flex; column-gap: 10px;'>
                        
                        <a href='delete.php?deletewebproject=$websiteId'>
                            <svg xmlns='http://www.w3.org/2000/svg' height='24px' viewBox='0 -960 960 960' width='24px' fill='#EA3323'><path d='M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z'/></svg>
                        </a>
                        </span>
                    </div>
                ";

            }
    

        }else{
            echo"
                <p style='text-align: center;'>No Website Project</p>
            ";
        }

    }
}

function WebFormInput(){

    include_once "decrypt.php";

    global $connect;

    if(isset($_GET['webproject'])){

        $webId = $_GET['webproject'];

        $editWebProjSql = "SELECT * FROM `website_projects` WHERE `project_id` = ?";

        $editWebProjPrep = mysqli_prepare($connect, $editWebProjSql);

        $editWebProjBind = mysqli_stmt_bind_param($editWebProjPrep, "s", $webId);

        mysqli_stmt_execute($editWebProjPrep);

        if($editWebProjResult = mysqli_stmt_get_result($editWebProjPrep)){
            $editWebProjNum = mysqli_num_rows($editWebProjResult) > 0;

            if($editWebProjNum){

                $editWebProjFetch = mysqli_fetch_assoc($editWebProjResult);

                $editWebProjId = $editWebProjFetch['project_id'];
                $editWebProjName = decryptdata($editWebProjFetch['name'], $key);
                $editWebProjDesc = decryptdata($editWebProjFetch['description'], $key);
                $editWebProjImage = $editWebProjFetch['project_image'];
                $editWebProjStack = strtoupper(decryptdata($editWebProjFetch['tech_stack'], $key));
                $editWebProjLink = decryptdata($editWebProjFetch['project_link'], $key);
                $editWebProjDate = $editWebProjFetch['date'];
                
                echo"
                <div class='image-container' style='width: 100%; min-height: 200px; border-radius: 10px;'>
                    <img src='../images/website-snippet-folder/$editWebProjImage' alt='$editWebProjImage' style='width: 100%; height: 100%; object-fit: cover; border-radius: 10px;'>
                </div>

                <small> Date created: $editWebProjDate</small>
                <form method='POST'>
                
                    <div class='form-group'>
                        <div>
                            <label for='name'>Project Name</label>
                            <div style='display: flex; justify-content: space-between; align-items: center;'>
                                <input type='text' name='name' class='form-input' value='$editWebProjName' required style='width: 85%;' autocomplete='off'>
                            
                                <button type='submit' name='update_website_name' class='btn btn-primary'  style='width: 10%;'>Save</button>
                            </div>
                        </div>
                    </div>

                </form>

                
                <form method='POST'>
                
                    <div class='form-group'>
                        <div>
                            <label for='name'>Project Stack</label>
                            <div style='display: flex; justify-content: space-between; align-items: center;'>
                                <input type='text' name='stack' class='form-input' value='$editWebProjStack' required style='width: 85%;' autocomplete='off'>
                                
                                <button type='submit' name='update_website_stack' class='btn btn-primary'  style='width: 10%;'>Save</button>
                            </div>
                        </div>
                    </div>
                
                </form>
                
                <form method='POST' enctype='multipart/form-data'>
                
                    <div class='form-group'>
                        <div>
                            <label for='image'>Project Image</label>
                            <div style='display: flex; justify-content: space-between; align-items: center;'>
                                <div style='width: 85%;'>
                                    <input type='file' name='update_image' class='form-input' required>
                                    <small>current image: $editWebProjImage</small>
                                </div>
                            
                                <button type='submit' name='update_website_image' class='btn btn-primary'  style='width: 10%;'>Save</button>
                            </div>
                        </div>
                    </div>

                </form>
                
                <form method='POST'>
                
                    <div class='form-group'>
                        <div>
                            <label for='name'>Project Link</label>
                            <div style='display: flex; justify-content: space-between; align-items: center;'>
                                <input type='text' name='link' class='form-input' value='$editWebProjLink' required style='width: 85%;' autocomplete='off'>
                            
                                <button type='submit' name='update_website_link' class='btn btn-primary'  style='width: 10%;'>Save</button>
                            </div>
                        </div>
                    </div>

                </form>

                <form method='POST'>
                
                    <div class='form-group'>
                        <div>
                            <label for='name'>Description</label>

                            <textarea class='form-input' required rows='10' placeholder='Type a message' name='message' autocomplete='off'>$editWebProjDesc</textarea>
                        
                            <button type='submit' name='update_website_msg' class='btn btn-primary' >Save</button>
                        </div>
                    </div>

                </form>

                ";

            }else{
                echo"
                <script>
                window.location.href='web-project.php'</script>
                ";
            }
        }
    }else{
        echo"
            <script>
                window.location.href='web-project.php'
            </script>
        ";
    }
}

// End of Web section

// Graphics section

function graphics(){

    global $connect;

    $graphicSql = "SELECT count(*) AS total FROM graphics_design_projects";

    $graphicPrep = mysqli_prepare($connect, $graphicSql);

    mysqli_stmt_execute($graphicPrep);

    if($graphicResult = mysqli_stmt_get_result($graphicPrep)){
        $graphicFetch = mysqli_fetch_assoc($graphicResult);

        $graphicCount = $graphicFetch['total'];

        echo"
            <small class='stat-value'>$graphicCount</small> 
        ";
    }
}

function totalGraphics(){

    include_once "decrypt.php";

    global $connect;

    $graphicSql = "SELECT * FROM graphics_design_projects ORDER BY `date` DESC";

    $graphicPrep = mysqli_prepare($connect, $graphicSql);

    mysqli_stmt_execute($graphicPrep);

    if($graphicResult = mysqli_stmt_get_result($graphicPrep)){

        $graphicNum = mysqli_num_rows($graphicResult) > 0;

        if($graphicNum){

            while($graphicFetch = mysqli_fetch_assoc($graphicResult)){

                $graphicId = $graphicFetch['project_id'];
                $graphicName = decryptdata($graphicFetch['name'], $key);
                $image = $graphicFetch['image'];
                $graphicStack = decryptdata($graphicFetch['tools'], $key);
                $graphicDate = $graphicFetch['date'];
                
                $stackUpper = strtoupper($graphicStack);
                
                echo"
                    <div class='message' style='display: flex; flex-direction: row; align-items: center; padding: 10px; justify-content: space-between;'>
                        <a href='graphics-edit.php?graphicsproject=$graphicId'>$graphicName</a>

                        <span style='display: flex; column-gap: 10px;'>
                        
                        <a href='delete.php?deletegraphicsproject=$graphicId'>
                            <svg xmlns='http://www.w3.org/2000/svg' height='24px' viewBox='0 -960 960 960' width='24px' fill='#EA3323'><path d='M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z'/></svg>
                        </a>
                        </span>
                    </div>
                ";

            }
    

        }else{
            echo"
                <p style='text-align: center;'>No Graphics Project</p>
            ";
        }

    }
}

function graphicsFormInput(){

    include_once "decrypt.php";

    global $connect;

    if(isset($_GET['graphicsproject'])){

        $graphicsId = $_GET['graphicsproject'];

        $editGraphicsProjSql = "SELECT * FROM `graphics_design_projects` WHERE `project_id` = ?";

        $editGraphicsProjPrep = mysqli_prepare($connect, $editGraphicsProjSql);

        $editGraphicsProjBind = mysqli_stmt_bind_param($editGraphicsProjPrep, "s", $graphicsId);

        mysqli_stmt_execute($editGraphicsProjPrep);

        if($editGraphicsProjResult = mysqli_stmt_get_result($editGraphicsProjPrep)){
            $editGraphicsProjNum = mysqli_num_rows($editGraphicsProjResult) > 0;

            if($editGraphicsProjNum){

                $editGraphicsProjFetch = mysqli_fetch_assoc($editGraphicsProjResult);

                $editGraphicsProjId = $editGraphicsProjFetch['project_id'];
                $editGraphicsProjName = decryptdata($editGraphicsProjFetch['name'], $key);
                $editGraphicsProjImage = $editGraphicsProjFetch['image'];
                $editGraphicsProjStack = strtoupper(decryptdata($editGraphicsProjFetch['tools'], $key));
                $editGraphicsProjDate = $editGraphicsProjFetch['date'];
                
                echo"
                <div class='image-container' style='width: 100%; border-radius: 10px;'>
                    <img src='../images/graphics-design-folder/$editGraphicsProjImage' alt='$editGraphicsProjImage' style='width: 100%; height: 100%; object-fit: cover; border-radius: 10px;'>
                </div>

                <small> Date created: $editGraphicsProjDate</small>
                <form method='POST'>
                
                    <div class='form-group'>
                        <div>
                            <label for='name'>Project Name</label>
                            <div style='display: flex; justify-content: space-between; align-items: center;'>
                                <input type='text' name='name' class='form-input' value='$editGraphicsProjName' required style='width: 85%;' autocomplete='off'>
                            
                                <button type='submit' name='update_graphics_name' class='btn btn-primary'  style='width: 10%;'>Save</button>
                            </div>
                        </div>
                    </div>

                </form>

                
                <form method='POST'>
                
                    <div class='form-group'>
                        <div>
                            <label for='name'>Project Tool</label>
                            <div style='display: flex; justify-content: space-between; align-items: center;'>
                                <input type='text' name='stack' class='form-input' value='$editGraphicsProjStack' required style='width: 85%;' autocomplete='off'>
                                
                                <button type='submit' name='update_graphics_stack' class='btn btn-primary'  style='width: 10%;'>Save</button>
                            </div>
                        </div>
                    </div>
                
                </form>
                
                <form method='POST' enctype='multipart/form-data'>
                
                    <div class='form-group'>
                        <div>
                            <label for='image'>Project Image</label>
                            <div style='display: flex; justify-content: space-between; align-items: center;'>
                                <div style='width: 85%;'>
                                    <input type='file' name='update_image' class='form-input' required>
                                    <small>current image: $editGraphicsProjImage</small>
                                </div>
                            
                                <button type='submit' name='update_graphics_image' class='btn btn-primary'  style='width: 10%;'>Save</button>
                            </div>
                        </div>
                    </div>

                </form>

                ";

            }else{
                echo"
                <script>
                window.location.href='graphics-project.php'</script>
                ";
            }
        }
    }else{
        echo"
            <script>
                window.location.href='graphics-project.php'
            </script>
        ";
    }
}

// End of Graphics section

// configuration Section

function configInput(){
    global $connect;
    
    $id = 1;

    $editConfigSql = "SELECT * FROM `about` WHERE `id` = ?";

    $editConfigPrep = mysqli_prepare($connect, $editConfigSql);

    $editConfigBind = mysqli_stmt_bind_param($editConfigPrep, "s", $id);

    mysqli_stmt_execute($editConfigPrep);

    if($editConfigResult = mysqli_stmt_get_result($editConfigPrep)){
        $editConfigNum = mysqli_num_rows($editConfigResult) > 0;

        if($editConfigNum){

            $editConfigFetch = mysqli_fetch_assoc($editConfigResult);

            $editConfigIntroName = $editConfigFetch['intro-name'];
            $editConfigIntroAbout = $editConfigFetch['intro-about'];
            $editConfigSubIntro = $editConfigFetch['sub-intro'];
            $editConfigHeroImg = $editConfigFetch['hero-image'];
            $editConfigSubImage = $editConfigFetch['sub-intro-image'];
            
            echo"
            
            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>Hero Intro Name</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <input type='text' name='name' class='form-input' value='$editConfigIntroName' required style='width: 85%;' autocomplete='off'>
                        
                            <button type='submit' name='intro_name' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>

            </form>

            
            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>Hero Intro About</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <textarea class='form-input' required rows='7' placeholder='Type a message' name='message' autocomplete='off'>$editConfigIntroAbout</textarea>
                            
                            <button type='submit' name='intro_about' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>
            
            </form>

            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>Sub-Intro About</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            
                            <textarea class='form-input' required rows='7' placeholder='Type a message' name='message' autocomplete='off'>$editConfigSubIntro</textarea>
                            
                            <button type='submit' name='sub_intro_about' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>
            
            </form>
            
            <form method='POST' enctype='multipart/form-data'>
            
                <div class='form-group'>
                    <div>
                        <label for='image'>Hero Image</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <div style='width: 85%;'>
                                <input type='file' name='hero_image' class='form-input' required>
                                <small>current image: $editConfigImage</small>
                            </div>
                        
                            <button type='submit' name='hero_intro_image' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>

            </form>
            
            <form method='POST' enctype='multipart/form-data'>
            
                <div class='form-group'>
                    <div>
                        <label for='image'>Sub Intro Image</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <div style='width: 85%;'>
                                <input type='file' name='hero_image' class='form-input' required>
                                <small>current image: $editConfigSubImage</small>
                            </div>
                        
                            <button type='submit' name='sub_intro_image' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>

            </form>

            ";

        }else{
            echo"
            
            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>Hero Intro Name</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <input type='text' name='name' class='form-input' required style='width: 85%;' autocomplete='off'>
                        
                            <button type='submit' name='intro_name' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>

            </form>

            
            
            <form method='POST' enctype='multipart/form-data'>
            
            <div class='form-group'>
            <div>
            <label for='image'>Hero Image</label>
            <div style='display: flex; justify-content: space-between; align-items: center;'>
            <div style='width: 85%;'>
            <input type='file' name='hero_image' class='form-input' required>
            </div>
            
            <button type='submit' name='hero_intro_image' class='btn btn-primary' style='width: 10%;'>Save</button>
            </div>
            </div>
            </div>
            
            </form>
            
            <form method='POST' enctype='multipart/form-data'>
            
            <div class='form-group'>
            <div>
            <label for='image'>Sub Intro Image</label>
            <div style='display: flex; justify-content: space-between; align-items: center;'>
            <div style='width: 85%;'>
            <input type='file' name='hero_image' class='form-input' required>
            </div>
            
            <button type='submit' name='sub_intro_image' class='btn btn-primary' style='width: 10%;'>Save</button>
            </div>
            </div>
            </div>
            
            </form>
            
            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>Hero Intro About</label>
                        <div>
                            <textarea class='form-input' required rows='7' placeholder='Type a message' name='message' autocomplete='off'></textarea>
                            
                            <button type='submit' name='intro_about' class='btn btn-primary'>Save</button>
                        </div>
                    </div>
                </div>
            
            </form>

            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>Sub-Intro About</label>
                        <div>
                            <textarea class='form-input' required rows='7' placeholder='Type a message' name='message' autocomplete='off'></textarea>
                            
                            <button type='submit' name='sub_intro_about' class='btn btn-primary'>Save</button>
                        </div>
                    </div>
                </div>
            
            </form>

            ";
        }
    }
}

function configInputSocial(){
    global $connect;
    
    $id = 1;

    $editConfigSql = "SELECT * FROM `social_link` WHERE `id` = ?";

    $editConfigPrep = mysqli_prepare($connect, $editConfigSql);

    $editConfigBind = mysqli_stmt_bind_param($editConfigPrep, "s", $id);

    mysqli_stmt_execute($editConfigPrep);

    if($editConfigResult = mysqli_stmt_get_result($editConfigPrep)){
        $editConfigNum = mysqli_num_rows($editConfigResult) > 0;

        if($editConfigNum){

            $editConfigFetch = mysqli_fetch_assoc($editConfigResult);

            $editTelegram = $editConfigFetch['telegram'];
            $editTwitter = $editConfigFetch['twitter'];
            $editDiscord = $editConfigFetch['Discord'];
            $editGithub = $editConfigFetch['Discord'];
            $editEmail = $editConfigFetch['Email'];
            $editLinkedin = $editConfigFetch['linkedin'];
            
            echo"
            
            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>Telegram</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <input type='text' name='telegram' class='form-input' value='$editTelegram' required style='width: 85%;' autocomplete='off'>
                        
                            <button type='submit' name='telegram_link' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>

            </form>

            
            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>X (Formerly twitter) Link</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <input type='text' name='twitter' class='form-input' value='$editTwitter' required style='width: 85%;' autocomplete='off'>
                            
                            <button type='submit' name='twitter_link' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>
            
            </form>

            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>Discord Link</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <input type='text' name='discord' class='form-input' value='$editDiscord' required style='width: 85%;' autocomplete='off'>
                            
                            <button type='submit' name='discord' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>
            
            </form>
            
            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>Github Link</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <input type='text' name='github' class='form-input' value='$editGithub' required style='width: 85%;' autocomplete='off'>
                            
                            <button type='submit' name='github_link' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>
            
            </form>

            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>Email Address</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <input type='text' name='email' class='form-input' value='$editEmail' required style='width: 85%;' autocomplete='off'>
                            
                            <button type='submit' name='email_address' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>
            
            </form>

            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>Linkedin Link</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <input type='text' name='linkedin' class='form-input' value='$editLinkedin' required style='width: 85%;' autocomplete='off'>
                            
                            <button type='submit' name='linkein_link' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>
            
            </form>
            ";

        }else{
            echo"
            
            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>Telegram Link</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <input type='text' name='telegram' class='form-input' required style='width: 85%;' autocomplete='off'>
                        
                            <button type='submit' name='telegram_link' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>

            </form>

            
            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>X (Formerly Twitter) Link</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <input type='text' name='twitter' class='form-input' required style='width: 85%;' autocomplete='off'>
                            
                            <button type='submit' name='twitter_link' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>
            
            </form>

            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>Discord Link</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <input type='text' name='discord' class='form-input' required style='width: 85%;' autocomplete='off'>
                            
                            <button type='submit' name='discord_link' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>
            
            </form>
            
            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>Github Link</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <input type='text' name='github' class='form-input' required style='width: 85%;' autocomplete='off'>
                            
                            <button type='submit' name='github_link' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>
            
            </form>

            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>Email Address</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <input type='text' name='email' class='form-input' required style='width: 85%;' autocomplete='off'>
                            
                            <button type='submit' name='email_address' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>
            
            </form>

            <form method='POST'>
            
                <div class='form-group'>
                    <div>
                        <label for='name'>Linkedin Link</label>
                        <div style='display: flex; justify-content: space-between; align-items: center;'>
                            <input type='text' name='linkedin' class='form-input' required style='width: 85%;' autocomplete='off'>
                            
                            <button type='submit' name='linkedin_link' class='btn btn-primary' style='width: 10%;'>Save</button>
                        </div>
                    </div>
                </div>
            
            </form>
            ";
        }
    }
}
