<?php
include("classes/loadfiles.php");
                        
                        
$email = "";
$password = "";
$errors = "";
                        
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = new Login();
    $errors = $login->evaluate_data($_POST);
                        
    if (empty($errors)) {
        // If there are no errors, set a session variable to indicate successful login
        $_SESSION['success_message'] = "You have successfully logged in!";
        header("Location: profile.php");
        die;
    }
    //sanitize inputs before displaying them back                 
    $email = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Friendzone | Log in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body style='font-family: tahoma; background-color: #ffe6e6;'>

<div class="container">
    <div class="row justify-content-between align-items-center py-3">
        <div class="col-auto">
            <h1 class="m-0">Friendzone</h1>
        </div>
        <div class="col-auto">
            <a href="Signup.php" class="btn btn-primary">Sign up</a>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Errors detected:</h4>
                    <?php echo $errors; ?>
                </div>
            <?php endif; ?>
            <form method="post">
                <h2 class="mb-4">Log in to Friendzone</h2>
                <div class="mb-3">
                    <input name="email" value="<?php echo $email ?>" type="text" class="form-control" placeholder="Email">
                </div>
                <div class="mb-3">
                    <div class="input-group">
                        <input name="password" id="password" value="<?php echo $password ?>" type="password" class="form-control" placeholder="Password">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i id="eyeIcon" class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Log in</button>
            </form>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success!</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                if (isset($_SESSION['success_message'])) {
                    echo $_SESSION['success_message'];
                    unset($_SESSION['success_message']); // Clear the success message after displaying
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-LC3pqB0e8gqROOQqOdu4KlZPcdkaOJIeX5+FikEJEF1WbqG2VNUvjxRyyO/K4hWf" crossorigin="anonymous"></script>

<script>
    // Show success modal on page load if success message exists
    $(document).ready(function () {
        <?php if (isset($_SESSION['success_message'])): ?>
            $('#successModal').modal('show');
        <?php endif; ?>
    });

    // Toggle password visibility
    $(document).ready(function() {
        $('#togglePassword').click(function() {
            var passwordField = $('#password');
            var passwordFieldType = passwordField.attr('type');
            if (passwordFieldType === 'password') {
                passwordField.attr('type', 'text');
                $('#eyeIcon').removeClass('bi-eye-slash').addClass('bi-eye');
            } else {
                passwordField.attr('type', 'password');
                $('#eyeIcon').removeClass('bi-eye').addClass('bi-eye-slash');
            }
        });
    });
</script>

</body>
</html>



