<?php
session_start();

function generatePasswords() {
    $word = "admin";
    $permutations = [];

    // Generate all permutations
    function permute($str, $l, $r, &$result) {
        if ($l == $r) {
            $result[] = $str;
        } else {
            for ($i = $l; $i <= $r; $i++) {
                $str = swap($str, $l, $i);
                permute($str, $l + 1, $r, $result);
                $str = swap($str, $l, $i); // backtrack
            }
        }
    }

    function swap($str, $i, $j) {
        $arr = str_split($str);
        $temp = $arr[$i];
        $arr[$i] = $arr[$j];
        $arr[$j] = $temp;
        return implode('', $arr);
    }

    permute($word, 0, strlen($word) - 1, $permutations);
    return array_unique($permutations); // Remove duplicates
}

// Get the valid password based on the minute
function getCurrentPassword() {
    $passwords = generatePasswords();
    $minuteIndex = intval(date("i")) % count($passwords); // Use current minute as index
    return $passwords[$minuteIndex];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Generate the current valid password
    $valid_user = "admin";
    $valid_pass = getCurrentPassword();

    if ($username === $valid_user && $password === $valid_pass) {
        $_SESSION['logged_in'] = true;
        header("Location: success.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <h2>Login Page</h2>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <p style="color: green;">Current Password: <strong><?php echo getCurrentPassword(); ?></strong></p>
    
    <form method="POST" action="login.php">
        <label>Username:</label><br>
        <input type="text" name="username" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
