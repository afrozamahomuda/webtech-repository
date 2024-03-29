<?php
function validateUser($username, $password) {
    


    $data = file_get_contents("data.json");
    $users = json_decode($data, true);

    
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            return true;
        }
    }

    return false;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (validateUser($username, $password)) {
        if (isset($_POST['remember'])) {
            setcookie('username', $username, time() + (78900 * 40), '/'); // Cookie expires in 30 days
        }
        header("Location: home.php");
        exit();
    } else {
        $loginError = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($loginError)) { ?>
        <p><?php echo $loginError; ?></p>
    <?php }
     ?>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <label>
            <input type="checkbox" name="remember"> Remember me
        </label>

        <input type="submit" value="Login">
    </form>
</body>
</html>
