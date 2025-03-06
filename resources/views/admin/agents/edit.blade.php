<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Agent</title>
</head>
<body>

    <h2>Edit Agent Details</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('admin.agents.update', $agent->id) }}" method="POST">
        @csrf
        <label>Name:</label>
        <input type="text" name="name" value="{{ $agent->name }}" required><br><br>

        <label>Email:</label>
        <input type="email" name="email" value="{{ $agent->email }}" required><br><br>

        <label>Phone:</label>
        <input type="text" name="phone" value="{{ $agent->phone }}" required><br><br>

        <label>PAN Card:</label>
        <input type="text" name="pan_card" value="{{ $agent->pan_card }}" required><br><br>

        <button type="submit">Update Agent</button>
    </form>

</body>
</html>
