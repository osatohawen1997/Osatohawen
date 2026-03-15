<?php
// app/Mail.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail {

    private $mail;
    private $config;

    public function __construct() {
        $this->config = require __DIR__ . '\user-config-mail.php';
        $this->mail   = new PHPMailer(true);
        $this->setup();
    }

    // Setup SMTP settings
    private function setup() {
        $this->mail->isSMTP();
        $this->mail->Host       = $this->config['host'];
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $this->config['username'];
        $this->mail->Password   = $this->config['password'];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = $this->config['port'];
        $this->mail->setFrom(
            $this->config['from'],
            $this->config['from_name']
        );

        $this->mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
                'cafile'            => 'C:/php-8.5.3/extras/cacert.pem'
            ]
        ];
    }

    // Send email
    public function send($to, $subject, $body, $altBody = '') {
        try {
            $this->mail->clearAddresses(); // Clear previous recipients
            $this->mail->addAddress($to);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            $this->mail->AltBody = $altBody ?: strip_tags($body);

            $this->mail->send();
            return ['success' => true, 'message' => 'Email sent successfully'];

        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}