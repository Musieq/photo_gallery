<?php
require "includes/header.php";

/**
 * @var object $session
 * @var object $user
 */

if($session->isSignedIn()) {
    redirect("index.php");
}

if (isset($_POST['submitRegister'])) {
    $username = $_POST['inputUsername'];
    $password = $_POST['inputPassword'];
    $confirmPassword = $_POST['inputPasswordConfirm'];
    $email = $_POST['inputEmail'];

    if ($password === $confirmPassword) {
        $user->register($username, $password, $email);
    } else {
        $user->error = 'Passwords are different';
    }
}
?>


<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                            <div class="card-body">
                                <form method="post" action="register.php">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputUsername" name="inputUsername" type="text" placeholder="Username" />
                                        <label for="inputUsername">Username</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputEmail" name="inputEmail" type="email" placeholder="name@example.com" />
                                        <label for="inputEmail">Email address</label>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="inputPassword" name="inputPassword" type="password" placeholder="Create a password" />
                                                <label for="inputPassword">Password</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="inputPasswordConfirm" name="inputPasswordConfirm" type="password" placeholder="Confirm password" />
                                                <label for="inputPasswordConfirm">Confirm Password</label>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
                                    $user->displayError();
                                    ?>

                                    <div class="mt-4 mb-0">
                                        <div class="d-grid"><button type="submit" class="btn btn-primary" id="submitRegister" name="submitRegister">Create account</button></div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>


<?php
require "includes/footer.php";
?>
