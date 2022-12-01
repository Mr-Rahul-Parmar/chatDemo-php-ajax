<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Forgot Password (v2)</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
        </div>
        <div class="card-body">
            <div class="container">

                <div class="card" style="margin-top: 10px">
                    <div class="card-header">
                        Enter Verification code
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success" id="successRegsiter" style="display: none;"></div>
                        <form>
                            <input type="text" id="verificationCode" class="form-control" placeholder="Enter verification code">
                            <button type="button" class="btn btn-success" onclick="codeverify();">Verify code</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
<script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
<script>
    var firebaseConfig = {
        apiKey: "AIzaSyDu5aMnNrBaJLE6-bUzC3821gy1bX_N9og",
        authDomain: "demostudent-352910.firebaseapp.com",
        projectId: "demostudent-352910",
        storageBucket: "demostudent-352910.appspot.com",
        messagingSenderId: "679384392039",
        appId: "1:679384392039:web:f1589548f0fb3145020fc2",
        measurementId: "G-7T2PR6KE6K"
    };
    firebase.initializeApp(firebaseConfig);
</script>
<script type="text/javascript">
    window.onload=function () {
        render();
    };
    function render() {
        window.recaptchaVerifier=new firebase.auth.RecaptchaVerifier('recaptcha-container');
        recaptchaVerifier.render();
    }
    function phoneSendAuth() {
        var number = $("#number").val();
        firebase.auth().signInWithPhoneNumber(number,window.recaptchaVerifier).then(function (confirmationResult) {
            window.confirmationResult=confirmationResult;
            coderesult=confirmationResult;
            console.log(coderesult);
            $("#sentSuccess").text("Message Sent Successfully.");
            $("#sentSuccess").show();
        }).catch(function (error) {
            $("#error").text(error.message);
            $("#error").show();
        });
    }
    function codeverify() {
        var code = $("#verificationCode").val();
        coderesult.confirm(code).then(function (result) {
            var user=result.user;
            console.log(user);
            $("#successRegsiter").text("you are register Successfully.");
            $("#successRegsiter").show();
        }).catch(function (error) {
            $("#error").text(error.message);
            $("#error").show();
        });
    }
</script>
</body>
</html>
