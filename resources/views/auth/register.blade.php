<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <title>Register</title>
</head>

<body>
    @if (session('message'))
        <div class="alert alert-danger">
            {{ session('message') }}
        </div>
    @endif

    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Register</h4>
                        @if ($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif
                    </div>
                    <div class="card-body">
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" placeholder="Enter your username"
                                    value="{{ old('username') }}">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Full Name</label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                    id="full_name" name="full_name" placeholder="Enter your full name"
                                    value="{{ old('full_name') }}">
                                @error('full_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Enter your email"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" placeholder="Enter your phone number"
                                    value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-control @error('gender') is-invalid @enderror" id="gender"
                                    name="gender">
                                    <option value="">Select gender</option>
                                    <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Male</option>
                                    <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Female</option>
                                    <option value="O" {{ old('gender') == 'O' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Enter your password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Confirm your password">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="agreeTerms" name="agreeTerms"
                                    {{ old('agreeTerms') ? 'checked' : '' }}>
                                <label class="form-check-label" for="agreeTerms">I agree to the <a href="#">Terms
                                        and Conditions</a></label>
                                @error('agreeTerms')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                            Bạn đã có tài khoản?  <a href="{{ route('login.form') }}"> login</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background: linear-gradient(120deg, #3498db 0%, #6dd5fa 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Arial, sans-serif;
        }

        .container {
            margin-top: 60px;
        }

        .card {
            border-radius: 18px;
            box-shadow: 0 6px 32px rgba(52, 152, 219, 0.13);
            border: none;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(90deg, #3498db 0%, #6dd5fa 100%) !important;
            color: #fff !important;
            border-bottom: none;
            padding: 24px 24px 12px 24px;
            text-align: center;
        }

        .card-title,
        .card-header h4 {
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 0;
        }

        .card-body {
            padding: 28px 28px 18px 28px;
        }

        .form-label {
            font-weight: 600;
            color: #2980b9;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #dbeafe;
            font-size: 1rem;
            padding: 10px 12px;
            background: #f8fafc;
            transition: border 0.2s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3498db;
            background: #fff;
            box-shadow: 0 0 0 2px #eaf6fb;
        }

        .is-invalid {
            border-color: #e74c3c !important;
            background: #fff0f0;
        }

        .invalid-feedback,
        .text-danger {
            color: #e74c3c;
            font-size: 0.96rem;
            margin-top: 2px;
        }

        .btn-primary {
            background: #3498db;
            color: #fff;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 28px;
            letter-spacing: 1px;
            border: none;
            transition: background 0.18s;
        }

        .btn-primary:hover {
            background: #217dbb;
            color: #fff;
        }

        .form-check-input:checked {
            background-color: #3498db;
            border-color: #3498db;
        }

        .alert {
            border-radius: 8px;
            font-size: 1rem;
            margin-bottom: 18px;
            box-shadow: 0 2px 8px rgba(231, 76, 60, 0.07);
        }

        @media (max-width: 768px) {
            .container {
                margin-top: 24px;
            }

            .card-body {
                padding: 16px 8px 10px 8px;
            }

            .card-header {
                padding: 14px 8px 8px 8px;
            }
        }
    </style>
</body>

</html>
