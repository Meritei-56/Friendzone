<?php
    include("classes/loadfiles.php");

    $first_name = "";
    $last_name = "";
    $gender = "";
    $email = "";

    $error_message = ""; // Initialize error message variable

    if($_SERVER['REQUEST_METHOD']=='POST'){

        $signup = new Signup();
        $result = $signup->evaluate_data($_POST);

        if($result != "") {
            $error_message = $result; // Store error message
        } else {
            // Redirect to login page upon successful registration
            header("Location: login.php");
            exit; // Use exit instead of die for clarity
        }

        // Retrieve form data to repopulate fields on error
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Friendzone | Sign up</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffe6e6;
        }

        #tit {
            background-color: #3254a8;
            color: white;
            padding: 10px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #signin_but {
            background-color: #42b72a;
            width: 70px;
            text-align: center;
            padding: 8px;
            border-radius: 4px;
        }

        #bar1 {
            background-color: white;
            max-width: 800px;
            margin: auto;
            margin-top: 50px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        #button {
            font-weight: bold;
            border: none;
            border-radius: 4px;
            background-color: #343aeb;
            color: white;
            width: 100%;
        }

        /* Custom style for error messages */
        .error-message {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div id="tit">
        <div>Friendzone</div>
        <a href="login.php" class="text-white">
            <div id="signin_but">Log in</div>
        </a>
    </div>
    <div id="bar1">
        <h2 class="mb-4">Sign up to Friendzone</h2>
        <form id="signupForm" method="post" action="" class="needs-validation" novalidate>
            <!-- Form inputs with dynamic error messages -->
            <div class="form-group">
                <input value="<?php echo $first_name ?>" name="first_name" type="text" class="form-control" placeholder="First Name" required>
                <div class="invalid-feedback">Please enter your first name.</div>
            </div>
            <div class="form-group">
                <input value="<?php echo $last_name ?>" name="last_name" type="text" class="form-control" placeholder="Last Name" required>
                <div class="invalid-feedback">Please enter your last name.</div>
            </div>
            <div class="form-group">
                <select name="gender" class="form-control" required>
                    <option value="">Select Gender</option>
                    <option value="Male" <?php if($gender == 'Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if($gender == 'Female') echo 'selected'; ?>>Female</option>
                </select>
                <div class="invalid-feedback">Please select your gender.</div>
            </div>
            <div class="form-group">
                <input value="<?php echo $email ?>" name="email" type="email" class="form-control" placeholder="Email" required>
                <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>
            <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="Enter Password" required>
                <div class="invalid-feedback">Please enter a password.</div>
            </div>
            <div class="form-group">
                <input name="password2" type="password" class="form-control" placeholder="Confirm Password" required>
                <div class="invalid-feedback">Please confirm your password.</div>
            </div>
            <button type="submit" class="btn btn-primary" id="button">Sign up</button>
        </form>

        <!-- Display error message if any -->
        <?php if (!empty($error_message)) : ?>
            <div class="alert alert-danger mt-3">
                <strong>Error(s) Detected:</strong><br>
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // JavaScript for dynamic error message display
        document.addEventListener('DOMContentLoaded', function() {
            var form = document.getElementById('signupForm');
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission

                // Remove previous error messages
                var errorMessages = document.querySelectorAll('.error-message');
                errorMessages.forEach(function(element) {
                    element.remove();
                });

                // Validate form fields
                var firstNameInput = document.getElementsByName('first_name')[0];
                var lastNameInput = document.getElementsByName('last_name')[0];
                var genderInput = document.getElementsByName('gender')[0];
                var emailInput = document.getElementsByName('email')[0];

                var isValid = true;

                if (!firstNameInput.value.trim()) {
                    displayErrorMessage(firstNameInput, 'Please enter your first name.');
                    isValid = false;
                }

                if (!lastNameInput.value.trim()) {
                    displayErrorMessage(lastNameInput, 'Please enter your last name.');
                    isValid = false;
                }

                if (genderInput.value === '') {
                    displayErrorMessage(genderInput, 'Please select your gender.');
                    isValid = false;
                }

                if (!emailInput.value.trim()) {
                    displayErrorMessage(emailInput, 'Please enter a valid email address.');
                    isValid = false;
                }

                if (isValid) {
                    form.submit(); // Submit form if validation passes
                }
            });

            // Function to display error message below input field
            function displayErrorMessage(inputElement, message) {
                var errorMessage = document.createElement('div');
                errorMessage.textContent = message;
                errorMessage.className = 'error-message';
                inputElement.parentNode.appendChild(errorMessage);
            }
        });
    </script>
</body>
</html>
