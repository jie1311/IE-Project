<?php
//run continiouely
ignore_user_abort(true);
set_time_limit(0);

while (true) {
    //connect to database
    $link = mysql_connect('localhost', 'root', '');
    mysql_select_db("dbcleanmelbourne");
    $query = mysql_query("SELECT e_email e FROM email");

    //use the package
    require_once("src/phpmailer/class.phpmailer.php");
    require_once("src/phpmailer/class.smtp.php");
    $mail = new PHPMailer();

    //build the email
    $mail->CharSet = "UTF-8";
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->Username = "new.breath.noreply@gmail.com";
    $mail->Password = "NewBreath123";
    $mail->SetFrom("new.breath.noreply@gmail.com", "NewBreathTeam");
    $mail->AddReplyTo("new.breath.noreply@gmail.com", "NewBreathTeam");
    $mail->Subject = "Have you checked the events about asthma in Melbourne this week?";
    $mail->MsgHTML("<p>Dear user, </p>"
            . "<p>Have you checked the events about asthma in Melbourne this week?</p>"
            . "<p>Click the link below to check:</p>"
            . "<p>http://newbreath.azurewebsites.net/Development/event.php</p>"
            . "<p>Kind Regards</p>"
            . "<p>New Breath Team</p>");
    while ($data = mysql_fetch_array($query)):
        $mail->AddAddress($data['e'], "User");
    endwhile;

    if (!$mail->Send()) {
        echo $mail->ErrorInfo;
    } else {
        echo "Y";
    }
    
    mysql_close($link);
    sleep(60 * 60 * 24 * 7);
}
?>