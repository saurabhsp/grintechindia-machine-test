<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>

    <h2>Edit User</h2>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('agent.users.update', $user->id) }}" method="POST">
        @csrf
        <label>Name:</label>
        <input type="text" name="name" value="{{ $user->name }}" required>
        <br><br>

        <label>Email:</label>
        <input type="email" name="email" value="{{ $user->email }}" required>
        <br><br>

        <label>Phone:</label>
        <input type="text" name="phone" value="{{ $user->phone }}" required>
        <br><br>

        <button type="submit">Update User</button>
    </form>

    <br>
    <a href="{{ route('agent.users.index') }}">Back to User List</a>

</body>
</html>
