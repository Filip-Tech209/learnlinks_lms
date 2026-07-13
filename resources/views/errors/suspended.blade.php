<!DOCTYPE html>
<html>
<body>
    <h1>Account Access Denied</h1>
    <p>{{ session('message', 'Account suspended, contact admin.') }}</p>
    <a href="{{ route('login') }}">Back to Login</a>
</body>
</html>