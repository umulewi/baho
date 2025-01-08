<section id="get-a-quote" class="get-a-quote">
      <div class="container" data-aos="fade-up">

        <div class="row g-0">

          <div class="col-lg-5 quote-bg" style="background-image: url(assets/img/storage-service.jpg);"></div>

          <div class="col-lg-7">
            <form action="" method="post" class="php-email-form">
              <h3>Get a quote</h3>
              <p>Whether it's for enhancing your business operations or creating a memorable digital experience, we're here to help you succeed</p>
              <div class="row gy-4">
                <div class="col-md-6">
                  <select name="departure" class="form-control" style="border-radius: none;height: 48px;" required>
                    <option value="" style="color: rgb(73, 71, 71);">Project Type</option>
                    <option value="mobile-app">Mobile App Development</option>
                    <option value="website-develop">Website Development</option>
                    <option value="digital-marketing">Digital Marketing</option>
                    <option value="SEO-Marketing">SEO Marketing</option>
                  
                    <!-- Add more cities as needed -->
                  </select>
                </div>
                <div class="col-md-6">
                  <select name="who" class="form-control" id="entityType" style="border-radius: none;height: 48px;" required>
                    <option value="" style="color: rgb(73, 71, 71);">You are a</option>
                    <option value="Individual">Individual</option>
                    <option value="Company">Company</option>
                    <option value="Organization">Organization</option>
                   
                  
                    <!-- Add more cities as needed -->
                  </select>
                </div>

                <div class="col-md-6">
                  <input type="text" name="budget" class="form-control" placeholder="Budget" required>
                </div>

                <div class="col-md-6">
                  <input type="text" name="timeline" class="form-control" placeholder="Timeline" required>
                </div>

                

                

                <div class="col-lg-12">
                  <h4>Your Personal Details</h4>
                </div>

                <div class="col-md-12">
                  <input type="text" name="name" class="form-control" placeholder="Name" required>
                </div>
                <div class="col-md-12">
                  <input type="text" name="company" class="form-control" placeholder="Company Name" required>
                </div>
                <div class="col-md-12 ">
                  <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="phone" placeholder="Phone" required>
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="details" rows="6" placeholder="Tell Us More About Your Project..." required></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your quote request has been sent successfully. Thank you!</div>

                  <button type="submit">Get a quote</button>
                </div>

              </div>
            </form>
          </div><!-- End Quote Form -->

        </div>

      </div>
    </section><!-- End Get a Quote Section -->

<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departure=$_POST['departure'];
    $who=$_POST['who'];
    $budget=$_POST['budget'];
    $timeline=$_POST['timeline'];
    $name = $_POST['name'];
    $company=$_POST['company'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $details = $_POST['details'];
    $mail = new PHPMailer(true);

    try {
        // Sending email to the site owner
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ntegerejimanalewis@gmail.com';
        $mail->Password = 'mrbotszhkgvfivvz';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom($email, $name);
        $mail->addAddress('ukonayisabyelewis@gmail.com'); // Replace with your own email address
        $mail->addReplyTo($email, $name);

        $mail->isHTML(false);
        $mail->Subject = "Get a Quotes";
        $mail->Body = "Mr./Mrs. $name,w

[He/She] has selected the project type: $departure and represents $who. [He/She] has decided on a budget of $budget within the timeline of $timeline. The company name is $company.

Email: $email
Phone number: $phone

Message:
$details";
        $mail->send();

        // Sending confirmation email to the sender
        $confirmationMail = new PHPMailer(true);
        $confirmationMail->isSMTP();
        $confirmationMail->Host = 'smtp.gmail.com';
        $confirmationMail->SMTPAuth = true;
        $confirmationMail->Username = 'ntegerejimanalewis@gmail.com';
        $confirmationMail->Password = 'mrbotszhkgvfivvz';
        $confirmationMail->SMTPSecure = 'tls';
        $confirmationMail->Port = 587;
        $confirmationMail->setFrom('ukonayisabyelewis@gmail.com', 'Your Company Name');
        $confirmationMail->addAddress($email); // Send to the user's email
        $confirmationMail->isHTML(false);
        $confirmationMail->Subject = "Confirmation of Receipt";
        $confirmationMail->Body = "Dear $name,\n\nThank you for reaching out to us. We have received your message and will get back to you shortly.\n\nBest regards,\nYour Company Name";

        $confirmationMail->send();

        echo "Email sent successfully!";
    } catch (Exception $e) {
        echo "Email sending failed. Error: {$mail->ErrorInfo}";
    }
}
?>
