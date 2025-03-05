<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>

    <h2>Admin Dashboard</h2>

    <!-- Success Message -->
    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <!-- Logout Button -->
    <a href="{{ route('admin.logout') }}">Logout</a>

    <hr>

    <h3>Agent Management</h3>
    
    <!-- Add Agent Button -->
    <a href="{{ route('admin.agents.create') }}">Add New Agent</a>

    <!-- Agents Table -->
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>PAN Card</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agents as $agent)
            <tr>
                <td>{{ $agent->id }}</td>
                <td>{{ $agent->name }}</td>
                <td>{{ $agent->phone }}</td>
                <td>{{ $agent->email }}</td>
                <td>{{ $agent->pan_card }}</td>
                <td>
                    <a href="{{ route('admin.agents.edit', $agent->id) }}">Edit</a> |
                    <a href="{{ route('admin.agents.delete', $agent->id) }}" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
