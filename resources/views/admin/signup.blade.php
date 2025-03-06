<!DOCTYPE html>
<html>
<head>
    <title>Admin Signup</title>
</head>
<body>
    <h2>Admin Signup</h2>
    <h5>Already have an Account <a href="{{url('admin/login')}}">Click Here</a></h5>

    <form method="POST" action="{{ url('admin/signup') }}">
        
        @csrf
        <label>Name:</label>
        <input type="text" name="name" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Signup</button>
    </form>
</body>
</html>
