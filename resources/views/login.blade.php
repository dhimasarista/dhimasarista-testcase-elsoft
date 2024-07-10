@php
    $errors = ["message" => "not found"];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
    <link
        rel="stylesheet"
        type="text/css"
        href="../vendor/TopLoaderService/TopLoaderService.css"
    />
    <script src="../vendor/TopLoaderService/TopLoaderService.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <link
        rel="stylesheet"
        type="text/css"
        href="../src/plugins/TopLoaderService/TopLoaderService.css"
    />
    <script>
        const ErrorResponse = (data) => {
            if (data) {
                if (typeof data.message === 'string') {
                    // Jika ada properti 'message' dengan tipe string
                    return data.message;
                } else {
                    // Jika tidak ada properti 'message' atau bukan string, cek properti lainnya
                    for (const key in data) {
                        if (data.hasOwnProperty(key)) {
                            const value = data[key];
                            if (Array.isArray(value) && value.length > 0 && typeof value[0] === 'string') {
                                // Jika properti ini adalah array yang berisi string
                                return value[0]; // Ambil pesan pertama dari array
                            }
                        }
                    }
                }
            }
        }
    </script>
    <style>
    * {
        margin: 0px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .LoginPageContainer {
        height: 100vh;
        overflow: auto;
    }

    .LoginPageInnerContainer {
        display: flex;
        min-height: 100%;
    }

    .LoginPageInnerContainer .ImageContianer {
        width: 40%;
        background-image: url('https://images.unsplash.com/photo-1535551951406-a19828b0a76b?q=80&w=1732&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
        background-size: cover;
        background-position: center;
        min-height: 100%;
        padding: 5%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .LoginPageInnerContainer .ImageContianer .GroupImage {
        width: 100%;
        display: block;
    }

    .LoginPageInnerContainer .LoginFormContainer {
        flex-grow: 2;
        background-color: white;
        min-height: 100%;
        padding: 5%;
        background: url(https://i.imgur.com/BKyjjFa.png) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }

    .LoginPageInnerContainer .LoginFormContainer .LogoContainer .logo {
        height: 60px;
        margin-bottom: 30px;
    }

    .LoginPageInnerContainer .LoginFormContainer .header {
        font-size: 32px;
        font-weight: 500;
    }

    .LoginPageInnerContainer .LoginFormContainer .subHeader {
        color: #9aa4ad;
        margin-top: 5px;
        margin-bottom: 40px;
    }

    .LoginPageInnerContainer .LoginFormContainer .inputContainer {
        color: #3f3f45;
        margin: 20px 0px;
    }

    .LoginPageInnerContainer .LoginFormContainer .inputContainer .label {
        display: flex;
        width: 100%;
        justify-content: flex-start;
        align-items: center;
        margin-right: 7px;
        margin-bottom: 10px;
    }

    .LoginPageInnerContainer .LoginFormContainer .inputContainer .label .labelIcon {
        width: 20px;
        margin-right: 10px;
        display: block;
    }

    .LoginPageInnerContainer .LoginFormContainer .inputContainer .input {
        display: block;
        width: calc(100% - 20px);
        font-size: 15px;
        padding: 10px;
        border: 1px solid #d6d7db;
        border-radius: 5px;
        margin-top: 5px;
        outline: 0px !important;
    }

    .LoginPageInnerContainer .LoginFormContainer .OptionsContainer {
        display: flex;
        justify-content: space-between;
    }

    .LoginFormContainer {
        display: flex;
        align-items: center;
    }

    .LoginFormInnerContainer {
        max-width: 500px;
    }

    .LoginPageInnerContainer .LoginFormContainer .checkbox {
        width: 15px;
        height: 15px;
        margin: 0px;
        display: block;
        border: 1px solid #d6d7db;
    }

    .LoginPageInnerContainer .LoginFormContainer .checkboxContainer {
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

    .LoginPageInnerContainer .LoginFormContainer .checkboxContainer label {
        display: block;
        padding: 0px 5px;
        color: #9aa4ad;
    }

    .LoginPageInnerContainer .LoginFormContainer .ForgotPasswordLink {
        color: #e7483b;
        text-decoration: none;
    }

    .LoginFormContainer .LoginFormInnerContainer .LoginButton {
        margin-top: 30px;
        display: block;
        width: 100%;
        padding: 10px;
        font-weight: bold;
        color: white;
        background-color: #000000;
        border: 0px;
        outline: 0px;
        cursor: pointer;
    }

    .LoginFormContainer .LoginFormInnerContainer .LoginButton:active {
        background-color: #4520ff;
    }
    .LoginFormContainer .LoginFormInnerContainer .GuestButton {
        text-align: center;
        margin-top: 30px;
        display: block;
        width: 100%;
        font-weight: bold;
        color: black;
        opacity: 0.9;
        border: 0px;
        outline: 0px;
        cursor: pointer;
    }

    .LoginFormContainer .LoginFormInnerContainer .GuestButton:hover {

        color: #3f3f45;
    }


    @@media only screen and (max-width: 1200px) {
        .LoginPageInnerContainer .ImageContianer {
            width: 50%;
        }
    }

    @@media only screen and (max-width: 800px) {
        .LoginPageInnerContainer .ImageContianer {
            display: none;
        }

        .LoginFormContainer {
            justify-content: center;
        }
    }

    .LoginPageContainer::-webkit-scrollbar {
        width: 5px;
    }

    .LoginPageContainer::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .LoginPageContainer::-webkit-scrollbar-thumb {
        background: #2e1f7a;
    }

    .LoginPageContainer::-webkit-scrollbar-thumb:hover {
        background: #4520ff;
    }
    #guest-button{
                margin: 40px;
                /* text-decoration: none; */
                color: white;
    }
    #guest-button:hover{
        background-color: black;
    }
    </style>
</head>
<body>
    <div class="LoginPageContainer">
        <div class="LoginPageInnerContainer">
            <div class="ImageContianer"></div>
            <div class="LoginFormContainer">
                <div class="LoginFormInnerContainer">
                    <div class="LogoContainer">
                        {{-- <img src="https://www.pngkey.com/png/full/529-5291672_sample-logo-png-transparent-background.png" class="logo"> --}}
                        <h1><i>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"><path fill="currentColor" d="M10.25 2c.19 0 .36.11.44.26l2.22 3.96l.09.28l-.09.28l-2.22 3.96c-.08.15-.25.26-.44.26h-4.5c-.19 0-.36-.11-.44-.26L3.09 6.78L3 6.5l.09-.28l2.22-3.96c.08-.15.25-.26.44-.26h4.5m0 11c.19 0 .36.11.44.26l2.22 3.96l.09.28l-.09.28l-2.22 3.96c-.08.15-.25.26-.44.26h-4.5c-.19 0-.36-.11-.44-.26l-2.22-3.96L3 17.5l.09-.28l2.22-3.96c.08-.15.25-.26.44-.26h4.5m9.25-5.5c.19 0 .36.11.44.26l2.22 3.96l.09.28l-.09.28l-2.22 3.96c-.08.15-.25.26-.44.26H15c-.19 0-.36-.11-.44-.26l-2.22-3.96l-.09-.28l.09-.28l2.22-3.96c.08-.15.25-.26.44-.26h4.5Z"/></svg>
                        </i>Hello, World!</h1>
                        <br>
                    </div>
                    <header class="header">Log in</header>
                    <header class="subHeader">Welcome to <b>My Test Case</b>. Please Enter your Details</header>

                    <form>
                        @csrf
                        <div class="inputContainer">
                            <label class="label" for="username">
                                <i class="labelIcon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 256 256"><path fill="currentColor" d="M229.19 213c-15.81-27.32-40.63-46.49-69.47-54.62a70 70 0 1 0-63.44 0C67.44 166.5 42.62 185.67 26.81 213a6 6 0 1 0 10.38 6c19.21-33.19 53.15-53 90.81-53s71.6 19.81 90.81 53a6 6 0 1 0 10.38-6ZM70 96a58 58 0 1 1 58 58a58.07 58.07 0 0 1-58-58Z"/></svg>
                                </i>
                                <span>Username</span></label>
                            <input class="input" type="text" name="username" placeholder="Enter your Username" required>
                        </div>
                        <div class="inputContainer">
                            <label class="label" for="password">
                                <i class="labelIcon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48"><circle cx="33.4" cy="14.8" r="3.9" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M20.4 20.4a11.47 11.47 0 0 1 5.2-13.3a11.31 11.31 0 0 1 14.1 2.3a11.32 11.32 0 0 1-13 17.9"/><path fill="none" stroke="currentColor" d="M20.4 20.4L5.5 37v5.4h6.1l.7-4.2l6.5-.4l.5-5.5l5.5-.1l1.8-4.8"/></svg>
                                </i>
                                <span>Password</span></label>
                            <input name="password" class="input" type="password" placeholder="Enter your Password" required>
                        </div>
                        <div style="color: red;">
                            <span id="error-message"></span>
                        </div>
                        <br>
                        <div class="OptionsContainer">
                            <div class="checkboxContainer">
                                <input type="checkbox" id="RememberMe" class="checkbox" name="remember"> <label for="RememberMe">Remember Me</label>
                            </div>
                            <a class="ForgotPasswordLink">Forgot Password?</a>
                        </div>
                        <button class="LoginButton" id="login-button">Login</button>
                        {{-- <a href="/guest" class="GuestButton">Guest</a> --}}
                    </form>
                    <script src="../plugins/jquery/jquery.min.js"></script>
                    <script>
                        document.getElementById("login-button").addEventListener("click", (e) => {
                            e.preventDefault()
                            TopLoaderService.start();
                            $.ajax({
                            url: '/login',
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            data: JSON.stringify({
                                username: $("input[name='username'").val(),
                                password: $("input[name='password'").val()
                            }),
                            success: function(response) {
                                // Menampilkan pesan sukses jika ada
                                $("#error-message").text(response.message);
                                // Mengarahkan ke halaman utama setelah login berhasil
                                window.location.replace("/");
                            },
                            error: function(xhr, status, error) {
                                // Menampilkan pesan kesalahan jika terjadi kesalahan
                                console.log(xhr);
                                $("#error-message").text(ErrorResponse(xhr.responseJSON));
                            },
                            complete: function() {
                                TopLoaderService.end();
                            }
                        });
                        })
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
