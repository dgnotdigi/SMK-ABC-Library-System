<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign in &mdash; SMK ABC Library</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body>
    <div class="login-page">
        <div class="login-card">
            <div class="login-brand">
                <div class="mark">&#10086;</div>
                <h1>SMK ABC Library</h1>
                <p>Sign in to search the catalog and manage checkouts</p>
            </div>

            @if ($errors->any())
                <div class="error-banner">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.attempt') }}">
                @csrf
                <div class="field">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" autocomplete="username" value="{{ old('username') }}" required autofocus />
                </div>
                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" autocomplete="current-password" required />
                </div>
                <button type="submit" class="btn btn-accent" style="width:100%; justify-content:center;">Sign in</button>
            </form>

            <div class="demo-creds">
                <div><strong>admin</strong> / admin123 &mdash; librarian account</div>
                <div><strong>student1</strong> / student123 &mdash; student account</div>
            </div>
        </div>
    </div>
</body>
</html>
