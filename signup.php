<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
</head>
<body>
    <h2>Sign Up</h2>
    <form action="register.php" method="post">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label><br>
        <!-- Adding a hint for password complexity -->
        <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
        title="Password should be at least 8 characters long, contain at least one digit, one lowercase letter, and one uppercase letter" required><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="contact">Contact:</label><br>
        <input type="text" id="contact" name="contact" required><br><br>
        
        <input type="submit" value="Sign Up">
    </form>
    <!-- Additional information about password requirements -->
    <p>Password should be at least 8 characters long, contain at least one digit, one lowercase letter, and one uppercase letter.</p>
</body>
</html>
