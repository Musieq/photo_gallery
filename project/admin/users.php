<?php
include 'includes/header.php';

/** User init **/
$user = new User();
?>
    <div id="layoutSidenav">

    <!-- Sidenav -->
<?php
include 'includes/sidenav.php';
?>

    <!-- Page content -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Users</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">All users</li>
                </ol>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Login</th>
                                <th scope="col">Creation date</th>
                                <th scope="col">Role</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        <?php
                        $allUsers = $user->getAllUsers();

                        foreach ($allUsers as $row) {
                            ?>
                            <tr>
                                <td><?=$row['username']?></td>
                                <td><?=$row['login']?></td>
                                <td><?=$row['creation_date']?></td>
                                <td><?=$row['role']?></td>
                            </tr>
                            <?php
                        }

                        //TODO: pagination
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </main>
<?php
include 'includes/footer.php';
