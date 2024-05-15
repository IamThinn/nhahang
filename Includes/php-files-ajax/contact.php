<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'D:\Dowload\PHPMailer-6.9.1\src\PHPMailer.php';
require 'D:\Dowload\PHPMailer-6.9.1\src\Exception.php';
require 'D:\Dowload\PHPMailer-6.9.1\src\SMTP.php';

include '../functions/functions.php';

if (isset($_POST['contact_name']) && isset($_POST['contact_email']) && isset($_POST['contact_subject']) && isset($_POST['contact_message'])) {

    $contact_name = test_input($_POST['contact_name']);
    $contact_email  = test_input($_POST['contact_email']);
    $contact_subject = test_input($_POST['contact_subject']);
    $contact_message = test_input($_POST['contact_message']);

    // Địa chỉ email của bạn
    $to_email = "thien86087@st.vimaru.edu.vn";

    // Tiêu đề email
    $subject = $contact_subject;
    
    // Nội dung email
    $message = "From: $contact_name\n\nEmail: $contact_email\n\nMessage:\n$contact_message";
    // Khởi tạo đối tượng PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Cấu hình SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'thien86087@st.vimaru.edu.vn';
        $mail->Password   = '3538309Aa1';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Cấu hình người gửi và người nhận
        $mail->setFrom($contact_email, $contact_name);
        $mail->addAddress($to_email);

        // Thiết lập nội dung email
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8'; // Set the character set to UTF-8
        $mail->Subject = $subject;
        $mail->Body    = $message;

        // Gửi email
        $mail->send();
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            The message has been sent successfully
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php
    } catch (Exception $e) {
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Sorry, there was an error sending your message. <?php echo $mail->ErrorInfo; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php
    }
}
?>
