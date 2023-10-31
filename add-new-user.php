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
$usernameMessage = '';
$emailMessage = '';
$passwordMessage = '';
$roleMessage = '';
$message = '';
$error = false;
if (isset($_POST) && isset($_POST['register'])) {
    if (!isset($_POST['username']) || $_POST['username'] == '') {
        $usernameMessage = 'Username is required!';
    }
    if (!isset($_POST['email']) || $_POST['email'] == '') {
        $emailMessage = 'Email is required!';
    }
    if (!isset($_POST['password']) || $_POST['password'] == '') {
        $passwordMessage = 'Password is required!';
    }
    if (!isset($_POST['role']) || $_POST['role'] == '') {
        $roleMessage = 'Select User Role!';
    }

    if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {

        $role = filter_var($_POST['role']);
        $username = filter_var($_POST['username']);
        $email = filter_var($_POST['email']);
        $password = filter_var($_POST['password']);

        $users = file('./data/users.txt');
        foreach ($users as $user) {

            $user = json_decode($user, true);

            if ($user['userName'] == $username) {
                $message = "Username already exists";
                $error = true;
            } elseif ($user['userEmail'] == $email) {
                $message = "Email already exists";
                $error = true;
            }
        }

        if (!$error) {


            $userData = array("role" => $role, "userName" => $username, "userEmail" => $email, "userPassword" => $password);
            $userDataJson = json_encode($userData);

            if (file_put_contents('./data/users.txt', $userDataJson . "\n", FILE_APPEND)) {
                $message = 'Successfully registered!';
                header('Location:index.php');
            } else {
                $message = 'Something went wrong!';
            }
        }
    }
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
                        <h6>Add New User (Logged in as : <?php echo $_SESSION['user_name']; ?>)</h6>
                        <a href="./logout.php" class="bg-danger text-light py-2 px-2 ml-auto">Logout</a>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option disabled>Select Role</option>
                                    <option <?php echo isset($_POST['role']) && $_POST['role'] == 'user' ? 'selected': ''; ?> value="user">User</option>
                                    <option <?php echo isset($_POST['role']) && $_POST['role'] == 'manager' ? 'selected': ''; ?> value="manager">Manager</option>
                                    <option <?php echo isset($_POST['role']) && $_POST['role'] == 'admin' ? 'selected': ''; ?> value="admin">Admin</option>
                                </select>
                                <small id="emailHelp" class="form-text text-danger"><?php echo $roleMessage; ?></small>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" id="username" placeholder="Enter username" value="<?php echo isset($_POST['username']) ? filter_var($_POST['username']) : ''; ?>">
                                <small id="emailHelp" class="form-text text-danger"><?php echo $usernameMessage; ?></small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="<?php echo isset($_POST['email']) ? filter_var($_POST['email']) : ''; ?>">
                                <small id="emailHelp" class="form-text text-danger"><?php echo $emailMessage; ?></small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                <small id="emailHelp" class="form-text text-danger"><?php echo $passwordMessage; ?></small>
                            </div>
                            <button type="submit" name="register" class="btn btn-primary">Register</button>
                            <small id="emailHelp" class="form-text text-danger"><?php echo $message; ?></small>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>