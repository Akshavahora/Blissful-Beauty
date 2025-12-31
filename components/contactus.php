<?php
session_start();

require_once('../dbconnection/connection.php');
require_once __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$content = '';
include('./header.php');

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Validation
    if (strlen($name) < 3) {
        $error = "Name must be at least 3 characters long.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif (strlen($message) < 10) {
        $error = "Message must be at least 10 characters long.";
    } else {

        try {
            $mail = new PHPMailer(true);

            // SMTP CONFIG
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'akshu87588@gmail.com';
            $mail->Password   = 'mhti xaan tube xcig'; // App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // EMAIL SETUP
            $mail->setFrom('akshu87588@gmail.com', 'Blissful Beauty');
            $mail->addAddress('vahoraakshu@gmail.com'); // Admin
            $mail->addReplyTo($email, $name);           // User

            $mail->isHTML(true);
            $mail->Subject = 'New Contact Message';
            $mail->Body = "
                <h3>New Contact Message</h3>
                <p><b>Name:</b> {$name}</p>
                <p><b>Email:</b> {$email}</p>
                <p><b>Message:</b><br>{$message}</p>
            ";

            $mail->send();
            $success = true;

        } catch (Exception $e) {
            $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>

<body class="bg-gray-100">

<!-- HERO SECTION -->
<section class="relative h-64 flex items-center justify-center bg-cover bg-center"
style="background-image:url('https://images.unsplash.com/photo-1515378791036-0648a3ef77b2');">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative text-center text-white">
        <h1 class="text-4xl font-bold">Contact Us</h1>
        <p>We would love to hear from you</p>
    </div>
</section>

<!-- FORM + MAP -->
<section class="max-w-6xl mx-auto px-4 py-12 grid md:grid-cols-2 gap-10">

<!-- CONTACT FORM -->
<div class="bg-white p-8 rounded shadow">

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && $success): ?>
        <p class="text-green-600 text-center mb-4">
            Message sent successfully!
        </p>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $error): ?>
        <p class="text-red-600 text-center mb-4">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <input type="text" name="name" placeholder="Your Name" required
               class="w-full p-3 border rounded">

        <input type="email" name="email" placeholder="Your Email" required
               class="w-full p-3 border rounded">

        <textarea name="message" rows="5" placeholder="Your Message" required
                  class="w-full p-3 border rounded"></textarea>

        <button class="w-full bg-teal-600 text-white py-3 rounded hover:bg-teal-700">
            Send Message
        </button>
    </form>
</div>

<!-- Google Map Card -->
        <div class="bg-white p-6 rounded-2xl shadow-2xl border border-gray-100 flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-teal-700 mb-4 text-center">Find Us</h2>
            <div class="rounded-lg overflow-hidden border border-gray-200 shadow-md">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3769.830313194165!2d72.85875187511026!3d19.115098650744127!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be7c9ce246611f1%3A0x3e0b82a825ccce33!2sKanakia%20Wall%20Street!5e0!3m2!1sen!2sin!4v1739591258653!5m2!1sen!2sin" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

</section>

</body>

<?php include('./footer.php'); ?>
