<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Email</title>
</head>
<body>
    @if (session('status'))
        <div style="color: green;">
            {{ session('status') }}
        </div>
    @elseif ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Only show this if $masked is present in the session -->
   <form method="POST" action="{{ route('verify.email') }}">
        @csrf
        <input type="email" name="email" required>
        <button type="submit">Send Verification Code</button>
    </form>
</body>
</html>