<?php
$usernameMessage = '';
$emailMessage = '';
$passwordMessage = '';
$message = '';
$error = false;
if (isset($_POST) && isset($_POST['register'])) {
    // var_dump($_POST);
    if (!isset($_POST['username']) || $_POST['username'] == '') {
        $usernameMessage = 'Username is required!';
    }
    if (!isset($_POST['email']) || $_POST['email'] == '') {
        $emailMessage = 'Email is required!';
    }
    if (!isset($_POST['password']) || $_POST['password'] == '') {
        $passwordMessage = 'Password is required!';
    }

    if (isset($_POST['username']) && !empty($_POST['username']) && isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])) {

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

            $userData = array("role" => "user", "userName" => $username, "userEmail" => $email, "userPassword" => $password);
            $userDataJson = json_encode($userData);

            if (file_put_contents('./data/users.txt', $userDataJson . "\n", FILE_APPEND)) {
                $message = 'Successfully registered!';
                session_start();
                $_SESSION['register_message'] = 'Successfully Registered. Please login';
                header('Location:login.php');
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
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-8 offset-2 mt-4">

                <div class="card">
                    <div class="card-header">
                        Register as a user
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
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
                            <small id="emailHelp" class="form-text text-danger font-weight-bold"><?php echo $message; ?></small>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>