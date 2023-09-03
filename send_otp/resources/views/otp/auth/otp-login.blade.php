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
            <h1>Login wiht Mobile</h1>

            @if (session('error'))
                <div style="color: red">{{session('error')}}</div>
            @endif

            <form action="{{route('otp.generate')}}" method="POST">
                @csrf
                <label for=""> Phone Number</label>
                <br>
                <input type="text"  name="mobile_no" required placeholder="Enter Your Valid Mobile Number">
                <br>
                @error('mobile_no')
                    <strong style="color: red">{{$message}}</strong>
                @enderror
                <br>
                <button type="submit">Generate OTP</button>
            </form>
        </div>
    </section>
</body>
</html>