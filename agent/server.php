<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recaptcha_secret = 'your_secret_key'; // Replace with your secret key
    $recaptcha_token = $_POST['recaptcha_token'];

    // Verify the reCAPTCHA token with Google
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_token}");
    $response_data = json_decode($response);

    if ($response_data->success && $response_data->score >= 0.5) {
        // Success: Proceed with your form processing
        echo "reCAPTCHA verified successfully.";
    } else {
        // Failed reCAPTCHA validation
        echo "reCAPTCHA verification failed.";
    }
}
?>
