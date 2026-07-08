<?php
require_once '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer{
    public function SendAccountInfo($email, $nama_karyawan, $username, $password_default){
        $mail = new PHPMailer(true);
        try{
            // SMTP
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "ggungde0@gmail.com";
            $mail->Password = "xond pjtp motc kfkq";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Pengirim
            $mail->setFrom("ggungde0@gmail.com", "POS Apotek");

            // Penerima
            $mail->addAddress($email, $nama_karyawan);

            // Isi Email
            $mail->isHTML(true);
            $mail->Subject = "Informasi Akun POS Apotek";

            $mail->Body = "
                <h3>Halo, $nama_karyawan</h3>

                <p>Akun Anda telah berhasil dibuat.</p>

                <table border='1' cellpadding='8' cellspacing='0'>
                    <tr>
                        <td><b>Username</b></td>
                        <td>$username</td>
                    </tr>

                    <tr>
                        <td><b>Password</b></td>
                        <td>$password_default</td>
                    </tr>
                </table>

                <br>

                <p>Silakan login ke Sistem POS Apotek menggunakan akun di atas.</p>

                <p>Terima kasih.</p>
            ";

            $mail->send();

            return true;

        }catch(Exception $e){
            return false;
        }
    }

     public function SendResetInfo($email, $nama_karyawan, $username, $password_default){
        $mail = new PHPMailer(true);
        try{
            // SMTP
            $mail->isSMTP();
            $mail->Host = "smtp.gmail.com";
            $mail->SMTPAuth = true;
            $mail->Username = "ggungde0@gmail.com";
            $mail->Password = "xond pjtp motc kfkq";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            // Pengirim
            $mail->setFrom("ggungde0@gmail.com", "POS Apotek");

            // Penerima
            $mail->addAddress($email, $nama_karyawan);

            // Isi Email
            $mail->isHTML(true);
            $mail->Subject = "Informasi Akun POS Apotek";
            $mail->Body = "
                <h3>Halo, $nama_karyawan</h3>

                <p>Password Anda telah berhasil direset.</p>

                <table border='1' cellpadding='8' cellspacing='0'>
                    <tr>
                        <td><b>Username</b></td>
                        <td>$username</td>
                    </tr>

                    <tr>
                        <td><b>Password</b></td>
                        <td>$password_default</td>
                    </tr>
                </table>

                <br>

                <p>Silakan login ke Sistem POS Apotek menggunakan akun di atas.</p>

                <p>Terima kasih.</p>
            ";

            $mail->send();

            return true;

        }catch(Exception $e){
            return false;
        }
    }


}