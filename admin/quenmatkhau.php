<?php 
$loi="";
if (isset($_POST['nutguiyeucau'])==true){
    $email = $_POST['email'];
    $conn=new PDO("mysql:host=localhost;dbname=restaurant_website;charset=utf8","admin","12345");
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql="SELECT * FROM users WHERE email = ?";
    $stmt=$conn->prepare($sql);
    $stmt->execute( [$email] );
    $count = $stmt->rowCount();
    if($count==0){
        $loi="Email khong khop voi bat ki tai khoan nao";
    }else{
        $matkhaumoi= substr(md5(rand(0,999999)),0,8);
        $sql="UPDATE users SET password =? WHERE email =?" ;
        $stmt=$conn->prepare($sql);
        $stmt->execute([$matkhaumoi,$email ]);
         "Da thay doi mat khau thanh cong";
        //ok
        Guimatkhaimoi($email,$matkhaumoi);
        echo '<script type="text/javascript">
                alert("Thong bao thay doi mat khau thanh cong");
                window.location.href = "dashboard.php";
              </script>';
        exit(); 
    }
}

?>
<?php  
function Guimatkhaimoi($email,$matkhaumoi){
    require "PHPMailer-master/src/PHPMailer.php"; 
    require "PHPMailer-master/src/SMTP.php"; 
    require 'PHPMailer-master/src/Exception.php'; 
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);
    try {
        $mail->SMTPDebug = 0; 
        $mail->isSMTP();  
        $mail->CharSet  = "utf-8";
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true; 
        $mail->Username = 'thien86087@st.vimaru.edu.vn'; 
        $mail->Password = '3538309Aa1';  
        $mail->SMTPSecure = 'ssl';   
        $mail->Port = 465;               
        $mail->setFrom('thien86087@st.vimaru.edu.vn', 'AdminThien' ); 
        $mail->addAddress($email); 
        $mail->isHTML(true); 
        $mail->Subject = 'Thong bao cap lai mat khau';
        $noidungthu = "<p>Cap lai mat khau</p>
            MAT KHAU CUA BAN LA {$matkhaumoi}
        "; 
        $mail->Body = $noidungthu;
        $mail->smtpConnect( array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
                "allow_self_signed" => true
            )
        ));
        $mail->send();
        'Đã gửi mail xong';
    } catch (Exception $e) {
        echo 'Error: ', $mail->ErrorInfo;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Quên mật khẩu</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .custom-container {
            margin-top: 50px;
        }

        .custom-card {
            border: 2px solid #1dc116;
            border-radius: 16px;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            text-align: center;
            font-size: 30px;
            color: #1dc116;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container custom-container">
    <div class="row justify-content-center">
        <div class="col-md-6 custom-card">
            <form method="post">
                <?php if($loi!="") { ?>
                    <div class="alert alert-danger"><?= $loi ?></div>
                <?php } ?>
                <div class="mb-3">
                    <div class="form-title">
                        <label for="">Quên mật khẩu</label>
                    </div>
                    <label for="email" class="form-label">Nhập email</label>
                    <input value="<?php if (isset($email) == true) echo $email ?>" type="email" class="form-control" id="email" name="email">
                </div>
                <button type="submit" name="nutguiyeucau" value="nutgui" class="btn btn-success">Gửi yêu cầu</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>


