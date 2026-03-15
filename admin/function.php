<?php

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

                $replyFullName = $replyFetch['full_name'];
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
