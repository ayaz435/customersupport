<!DOCTYPE html>
<html>
<head>
    <title>Welcome to YourApp</title>
</head>
<body>
    <p>Hello {{ $user->name }},</p>
    <p>Welcome to YourApp! Your account has been Updated.</p>
    <p>Your login details:</p>
    <p>Email: {{ $user->email }}</p>
    <p>Password: {{ $user->password }}</p>
    <p>Thank you for joining us!</p>
</body>
</html>
