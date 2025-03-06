<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>

    <h2>Agent Dashboard</h2>

    <!-- Success Message -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Logout Button -->
    <a href="{{ route('agent.logout') }}">Logout</a>

    <hr>

    <h3>Users Management</h3>
    <h2>Welcome, {{ session('agent_name') }}</h2>

    <!-- Add User Button -->
    <a href="{{ route('agent.users.create') }}">Add New User</a>

    <!-- Users Table -->
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>
                    <a href="{{ route('agent.users.edit', $user->id) }}">Edit</a> |
                    <a href="{{ route('agent.users.delete', $user->id) }}" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
