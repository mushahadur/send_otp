<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OTP Generate</title>
</head>
<body>
    <section>
        <div class="container">
            <h1>Verifiy Phone Number {{$user_id}}</h1>

            @if (session('success'))
                <div style="color: green">{{session('success')}}</div>
            @endif
            @if (session('error'))
                <div style="color: red">{{session('error')}}</div>
            @endif
            <form action="{{route('otp.getLogin')}}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{$user_id}}">
                <label for=""> Enter OTP</label>
                <br>
                <input type="text"  name="otp" placeholder="Enter Your OTP">
                <br>
                @error('otp')
                    <strong style="color: red">{{$message}}</strong>
                @enderror
                <br>
                <button type="submit">Verifiay and Login</button>
            </form>
        </div>
    </section>
</body>
</html>