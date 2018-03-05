<!doctype html>
<html lang="en">
<head>
    <!-- All the files that are required -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Varela+Round' rel='stylesheet' type='text/css'>

    <!--Bootstrap-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/template/css/login.css">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-12">
            <!-- Where all the magic happens -->
            <!-- LOGIN FORM -->
            <div class="text-center" style="padding:50px 0">
                <div class="logo">login</div>
                <!-- Main Form -->
                <div class="login-form-1">
                    <form id="login-form" class="text-left" method="post" action="">
                        <div class="login-form-main-message"></div>
                        <div class="main-login-form">
                            <div class="login-group">
                                <div class="form-group">
                                    <label for="lg_username" class="sr-only">Username</label>
                                    <input type="text" class="form-control" id="lg_username" name="lg_username" placeholder="username">
                                </div>
                                <div class="form-group">
                                    <label for="lg_password" class="sr-only">Password</label>
                                    <input type="password" class="form-control" id="lg_password" name="lg_password" placeholder="password">
                                </div>
                                <div class="form-group login-group-checkbox">
                                    <input type="checkbox" value="1" id="lg_remember" name="lg_remember">
                                    <label for="lg_remember">remember</label>
                                </div>
                            </div>
                            <button type="submit" name="login-submit" class="login-button"><i class="fa fa-chevron-right"></i></button>
                        </div>
                    </form>
                </div>
                <!-- end:Main Form -->
            </div>
        </div>
    </div>
</div>


<!--Bootstrap-->
<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>