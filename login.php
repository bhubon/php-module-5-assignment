<?php
session_start();
$emailMessage = '';
$passwordMessage = '';
$message = '';
if (isset($_POST) && isset($_POST['login'])) {

    if (!isset($_POST['email']) || $_POST['email'] == '') {
        $emailMessage = 'Email is required!';
    }
    if (!isset($_POST['password']) || $_POST['password'] == '') {
        $passwordMessage = 'Password is required!';
    }

    if (isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {

        $email = filter_var($_POST['email']);
        $password = filter_var($_POST['password']);

        $users = file('./data/users.txt');

        if (empty($users)) {
            $message = 'Invalid login credential!';
        } else {

            foreach ($users as $user) {
                $user = json_decode($user, true);

                if ($user['userEmail'] == $email && $user['userPassword'] == $password) {

                    $_SESSION['login'] = true;
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['user_name'] = $user['userName'];
                    $_SESSION['user_email'] = $user['userEmail'];

                    if ($_SESSION['user_role'] == 'admin') {

                        header("Location:index.php");
                    } elseif ($_SESSION['user_role'] == 'manager') {

                        header("Location:manager.php");
                    } else {

                        header("Location:user.php");
                    }

                    break;
                } else {
                    $message = 'Invalid login credential!';
                }
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
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-8 offset-2 mt-4">

                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                <small id="emailHelp" class="form-text text-danger"><?php echo $emailMessage; ?></small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                <small id="emailHelp" class="form-text text-danger"><?php echo $passwordMessage; ?></small>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary">Login</button>
                            <small id="emailHelp" class="form-text text-danger"><?php echo $message; ?></small>
                            <a href="registration.php">Or create an account</a>
                            <?php
                            if (isset($_SESSION['register_message'])) {
                            ?>
                                <p class="text-success font-weight-bold text-center"><?php echo $_SESSION['register_message']; ?></p>
                            <?php
                                unset($_SESSION['register_message']);
                            }
                            ?>
                        </form>

                        <div class="user-detail mt-4">
                            <h6 class="mb-2">Default Users:</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>admin</td>
                                        <td>admin@gmail.com</td>
                                        <td>admin</td>
                                    </tr>
                                    <tr>
                                        <td>manager</td>
                                        <td>manager@gmail.com</td>
                                        <td>manager</td>
                                    </tr>
                                    <tr>
                                        <td>user</td>
                                        <td>user@gmail.com</td>
                                        <td>user</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>