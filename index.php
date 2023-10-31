<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location:login.php');
}

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] != 'admin') {

    if ($_SESSION['user_role'] == 'manager') {
        header("Location:manager.php");
    } else {
        header("Location:user.php");
    }
}

if (isset($_POST) && isset($_POST['update_role'])) {
    $users = file('./data/users.txt');
    $updatedUsers = [];
    $i = 0;
    foreach ($users as $user) {

        $user = json_decode($user, true);
        $email = $_POST['email'][$i];
        $role = $_POST['role'][$i];
        $username = $_POST['username'][$i];

        if ($user['userEmail'] == $email) {
            $user['role'] = $role;
            $user['userName'] = $username;
        }
        $updatedUsers[] = json_encode($user) . "\n";

        // var_dump($_POST);
        $i++;
    }
    // var_dump($updatedUsers);
    file_put_contents('./data/users.txt', $updatedUsers);
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Area</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-8 offset-2 mt-4">

                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h6>Dashboard Area</h6>
                        <a href="./logout.php" class="bg-danger text-light py-2 px-2 ml-auto">Logout</a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Logged In As</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo $_SESSION['user_name']; ?></td>
                                    <td><?php echo $_SESSION['user_email']; ?></td>
                                    <td><?php echo $_SESSION['user_role']; ?></td>
                                </tr>
                                <tr>
                            </tbody>
                        </table>
                        <?php
                        if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                            $users = file('./data/users.txt');
                            if (count($users) > 0) {
                        ?>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center my-2">
                                    <h6 class="mt-4">User list:</h6>
                                    <div>
                                        <a class="btn btn-sm btn-primary" href="add-new-user.php">Add New User</a>
                                    </div>
                                </div>
                                <form action="" method="POST">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Email</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            foreach ($users as $user) {
                                                $user = json_decode($user, true);
                                            ?>
                                                <tr>
                                                    <td><?php echo $user['userEmail']; ?></td>
                                                    <td><input class="form-control" type="text" name="username[]" value="<?php echo $user['userName']; ?>"></td>
                                                    <td>
                                                        <select name="role[]" id="" class="form-control">
                                                            <option disabled>Select Role</option>
                                                            <option <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?> value="admin">Admin</option>
                                                            <option <?php echo $user['role'] == 'manager' ? 'selected' : ''; ?> value="manager">Manager</option>
                                                            <option <?php echo $user['role'] == 'user' ? 'selected' : ''; ?> value="user">User</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <input type="hidden" name="email[]" value="<?php echo $user['userEmail']; ?>">
                                            <?php } ?>
                                            <tr>
                                        </tbody>
                                    </table>

                                    <button class="btn btn-success" name="update_role" type="submit">Update</button>
                                </form>
                        <?php }
                        } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>