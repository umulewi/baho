<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['first_name'] = $_POST['first_name'];
    $_SESSION['last_name'] = $_POST['last_name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['phone'] = $_POST['phone'];
    $_SESSION['select_service'] = $_POST['select_service'];
    $_SESSION['select_price'] = $_POST['select_price'];
    $_SESSION['comments'] = $_POST['comments'];

    header("Location: login_or_signup.php");
    exit();
}
?>



<div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="contact_form">
                        <div id="message"></div>
                        <form id="contactform" class="row" action="" name="contactform" method="post">
                            <fieldset class="row-fluid">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Your Email">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Your Phone">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label class="sr-only">Select Service</label>
                                    <select name="select_service" id="select_service" class="selectpicker form-control" data-style="btn-white">
                                        <option value="12" style="font-weight: bold;color:black">Choose  a service to get started:</option>
                                        <option value="Regular Maintenance Services" style="font-weight: bold;color:black">Regular Maintenance Services</option>
                                        <option value="Specialized Cleaning Services" style="font-weight: bold;color:black">Specialized Cleaning Services</option>
                                        <option value="Commercial Services" style="font-weight: bold;color:black">Commercial Services</option>
                                        <option value="Maintenance and Care Services" style="font-weight: bold;color:black">Maintenance and Care Services</option>
                                        <option value="Others" style="font-weight: bold;color:black">Others</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label class="sr-only">What is max price?</label>
                                    <select name="select_price" id="select_price" class="selectpicker form-control" data-style="btn-white">
                                        <option value="invalid">Salary Range Expectations:</option>
                                        <option value="35000 - 69000">35,000 Rwf - 69,000 Rwf</option>
                                        <option value="70000 - 89000">70,000 Rwf - 89,000 Rwf</option>
                                        <option value="$4000 - $10000">Rwf 90,000 - 130,000 Rwf</option>
                                    </select>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <textarea class="form-control" name="comments" id="comments" rows="6" placeholder="Give us more details.."></textarea>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                                    <button type="submit" value="SEND" id="submit" class="btn btn-light btn-radius btn-brd grd1 btn-block">Submit</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div><!-- end col -->
            </div>