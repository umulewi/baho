<html>
  <head>
    <title>reCAPTCHA Enterprise Demo</title>
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LeLiLEqAAAAAMR6SssLwyaXNjDz88B9axezt6tH"></script>
  </head>
  <body>
    <form id="recaptcha-form" action="server.php" method="POST">
      <!-- reCAPTCHA widget -->
      <div class="g-recaptcha" data-sitekey="6LeLiLEqAAAAAMR6SssLwyaXNjDz88B9axezt6tH"></div>
      <br/>
      <input type="hidden" name="recaptcha_token" id="recaptcha-token">
      <input type="submit" value="Submit" onclick="onClick(event)">
    </form>

    <script>
      function onClick(e) {
        e.preventDefault(); // Prevent default form submission
        grecaptcha.enterprise.ready(async () => {
          const token = await grecaptcha.enterprise.execute(
            '6LeLiLEqAAAAAMR6SssLwyaXNjDz88B9axezt6tH', 
            { action: 'LOGIN' }
          );
          // Add the token to the hidden input field
          document.getElementById('recaptcha-token').value = token;
          // Submit the form after getting the token
          document.getElementById('recaptcha-form').submit();
        });
      }
    </script>
  </body>
</html>
