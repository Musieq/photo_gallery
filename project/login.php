<?php
require "includes/header.php";
/**
 * @var object $session
 * @var object $user
 */

if($session->isSignedIn()) {
    redirect("index.php");
}

if (isset($_POST['submitLogin'])) {
    $username = $_POST['inputUsername'];
    $password = $_POST['inputPassword'];
    // TODO: remember me


    $user->login($username, $password);
}
?>

<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                            <div class="card-body">
                                <form method="post" action="login.php">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputUsername" name="inputUsername" type="text" placeholder="Username" />
                                        <label for="inputUsername">Username</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputPassword" name="inputPassword" type="password" placeholder="Password" />
                                        <label for="inputPassword">Password</label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                        <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                    </div>

                                    <?php
                                    $user->displayError();
                                    ?>

                                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <a class="small" href="admin/password.html">Forgot Password?</a>
                                        <button type="submit" class="btn btn-primary" id="submitLogin" name="submitLogin">Login</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center py-3">
                                <div class="small"><a href="admin/register.html">Need an account? Sign up!</a></div>
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