<!-- === Coding by CodingLab | www.codinglabweb.com === -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href=<?php echo site_url('css/login.css')?>>
    <!--<title>Login & Registration Form</title-->
    
</head>
<body>
    <div class="context">
        <div class="container">
            <div class="forms">
                <div class="form login">
                    <span class="title">Login</span>
                    <?php  echo form_open('Login/signin'); ?>   
                        <div class="input-field">
                            <input name="email" type="text" placeholder="Enter your email" required>
                            <i class="uil uil-envelope icon"></i>
                        </div>
                        <div class="input-field">
                            <input type="password" name="password" class="password" placeholder="Enter your password" required>
                            <i  class="uil uil-lock icon"></i>
                        </div>
                        <div class="checkbox-text">
                            <!-- <div class="checkbox-content">
                                <input type="checkbox" id="logCheck">
                                <label for="logCheck" class="text">Remember me</label>
                            </div> -->
                            
                            <!-- <a href="#" class="text">Forgot password?</a> -->
                        </div>
    
                        <div class="input-field button">
                            <input type="submit" class="btn-btn-default submit" value="Login Now">
                        </div>
                    <?php  echo form_close(); ?>   
    
                    <div class="login-signup">
                        <span class="text">Not a member?
                            <a type="button" onclick="addActive()" href="#" class="text signup-link">Signup now</a>
                        </span>
                    </div>
                </div>
    
                <!-- Registration Form -->
                <div class="form signup">
                    <span class="title">Registration</span>
                    <?php  echo form_open('Login/signup'); ?>   
                        <div class="input-field">
                            <input name="fullname" type="text" placeholder="Enter your name" required>
                            <i class="uil uil-user"></i>
                        </div>
                        <div class="input-field">
                            <input name="email" type="text" placeholder="Enter your email" required>
                            <i class="uil uil-envelope icon"></i>
                        </div>
                        <div class="input-field">
                            <input name="password" type="text" class="password pwd1" placeholder="Create a password" required>
                            <i class="uil uil-lock icon"></i>
                        </div>
                        <div class="input-field">
                            <input onblur="pwdTest()" name="password1" type="password" class="password pwd2" placeholder="Confirm a password" required>
                            <i  class="uil uil-lock icon"></i>
                        </div>
    
                        <div class="input-field button">
                            <input type="submit" value="Sign up">
                        </div>
                        <?php  echo form_close(); ?>   
    
                    <div class="login-signup">
                        <span class="text">Already a member?
                            <a type="button" onclick="removeActive()" class="text login-link">Login</a>
                        </span>
                    </div>
                </div>
            </div>
    </div>
</div>
<div class="area" >
    <ul class="circles">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
    </ul>
</div >
    <script>
        const container = document.querySelector(".container"),
            signUp = document.querySelector(".signup-link"),
            login = document.querySelector(".login-link");
    // js code to appear signup and login form
    function addActive (){
        container.classList.add("active");
    }
    function removeActive(){
        container.classList.remove("active");
    };
    var pwd1 = document.querySelector('.pwd1');
    var pwd2 = document.querySelector('.pwd2');

    function pwdTest(){
        if(pwd1.value !== pwd2.value){
            pwd2.style.color = "red" ;
            pwd2.setAttribute('type' , 'text') ;
        }
    }

    </script>

<!-- Code injected by live-server -->
</body>
</html>
