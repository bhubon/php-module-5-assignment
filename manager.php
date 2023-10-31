<?php
session_start();
if (!isset($_SESSION['login'])) {
    header('Location:login.php');
}

if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'user') {
    header("Location:user.php");
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Area</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-8 offset-2 mt-4">

                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h6>Manager Dashboard Area</h6>
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
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>