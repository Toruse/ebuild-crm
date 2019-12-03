<!DOCTYPE html>
<html>
<head>
    <title>Register Data Email</title>
</head>
<body>
    <h2>
        User {{$user->full_name}}
    </h2>
    <p>
        <strong>Email:</strong> {{$user->email}}<br>
        <strong>Phone:</strong> {{$user->phone}}<br>
        <strong>Password:</strong> {{$fields['password']}}
    </p>
</body>
</html>