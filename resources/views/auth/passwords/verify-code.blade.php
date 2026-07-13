<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Code</title>
</head>
<body>
    <p>Enter 6-digit Code sent to: <strong>{{ session('masked') }}</strong></p>
    @if($errors->any()) <div style="color:red">{{ $errors->first() }}</div> @endif
    <form method="POST" action="{{ route('verify.code.submit') }}">
        @csrf
        <input type="text" name="code" placeholder="Enter 6-digit code" required>
        <button type="submit">Verify Code</button>
    </form>
</body>
</html>