<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet"  href=<?php echo site_url('css/master.css') ?>
    <link rel="stylesheet"  href=<?php echo site_url('css/login.css') ?>
    
    <!-- --===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
</head>
<body>
    <nav class="sidebar open">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src=<?php echo site_url('img/cspro.png') ?> alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">CSP</span>
                    <span class="profession">CONSEILS ET SOLUTIONS <br> PROGICIELS</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <!-- <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="Search...">
                </li> -->
                <ul class="menulinks">
<!-- client -->
            <?php if(session('id_cat')== 1): ?>        
                <li class="nav_link">
                        <a href="<?php echo site_url('tickets/displayTicketsByStatus/0') ?>">
                            <i class='bx bx-home-alt icon' ></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                <li class="nav_link">
                    <a href="<?php echo site_url('tickets/index') ?>">
                    <i class='bx bxs-edit-alt icon' ></i>    
                    <span class="text nav-text">Ajouter</span>
                    </a>
                </li>
            <?php endif; ?>        
<!-- client -->
<!-- technicien -->
            <?php if(session('id_cat')== 3): ?>        
                <li class="nav_link">
                    <a href="<?php echo site_url('/tickets/TicketsByTechs/')  ;  ?>">
                        <i class='bx bx-home-alt icon' ></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav_link">
                    <a href="#">

                    <i class='bx bx-calendar-edit icon' ></i>
                    <span class="text nav-text">Historique</span>
                    </a>
                </li>
            <?php endif; ?>        
<!-- technicien -->
<!-- Admin -->
            <?php if(session('id_cat')== 2): ?>        
                <li class="nav_link">
                    <a href="<?php echo site_url('Tickets/displayAllTickets/')  ;  ?>">
                        <i class='bx bx-paper-plane icon' ></i>
                        <span class="text nav-text">Tickets</span>
                    </a>
                </li>

                <li class="nav_link">
                    <a href=<?php echo site_url('Admin/clients')  ;  ?> >
                    <i class='bx bx-group icon' ></i>
                    <span class="text nav-text">Clients</span>
                    </a>
                </li>

                <li class="nav_link">
                    <a href=<?php echo site_url('Admin/technicien')  ;  ?> >
                    <i class='bx bx-laptop icon' ></i>
                    <span class="text nav-text">Techniciens</span>
                    </a>
                </li>

                <li class="nav_link">
                    <a href=<?php echo site_url('Admin/displayLogs')  ;  ?> >
                    <i class='bx bx-calendar-edit icon' ></i>
                    <span class="text nav-text">Historique</span>
                    </a>
                </li>

                <li class="nav_link">
                    <a href=<?php echo site_url('Admin/categories')  ;  ?> >
                    <i class='bx bx-category icon'></i>
                    <span class="text nav-text">Categories</span>
                    </a>
                </li>
            <?php endif; ?>        
<!-- Admin -->
<li class="nav_link">
                    <a href="<?php echo site_url('/Login/profile/')  ;  ?>">
                    <i class='bx bx-user-circle icon' ></i>
                    <span class="text nav-text">Profile</span>
                    </a>
                </li>

                </ul>
            </div>
            <?php if(session()->has('logged')): ?>
                <div class="bottom-content">
                    <li class="">
                        <a href=<?php echo site_url('login/logout') ?>  >
                            <i class='bx bx-log-out icon' ></i>
                            <span class="text nav-text">Logout</span>
                        </a>
                    </li>
                </div>
                <?php endif; ?>        
        </div>
    </nav>

        <section class="home" >
            <div class="top_nav">
                <div class="profile">
                    <div class="iconn"><img class="myImg" src="<?php echo site_url('img/user.jpg') ?>" alt=""></div>
                    <div class="name">
                        <h4><?php echo session('fullname') ?></h4>
                    </div>
                </div>
            </div>
            <?php $this->renderSection("content"); ?>
            <button onclick="topFunction()" id="myBtn" title="Go to top"><i class='bx bxs-hand-up' ></i></button>
        </section>

        <script>
            const body = document.querySelector('body'),
            sidebar = body.querySelector('nav'),
            toggle = body.querySelector(".toggle"),
            searchBtn = body.querySelector(".search-box"),
            modeSwitch = body.querySelector(".toggle-switch"),
            modeText = body.querySelector(".mode-text");
            toggle.addEventListener("click" , () =>{
                sidebar.classList.toggle("close");
            })
            searchBtn.addEventListener("click" , () =>{
                sidebar.classList.remove("close");
            }) 
        </script>
        <script>
            document.documentElement.style.scrollBehavior = "smooth";
            //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}
// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}
        </script>
    </body>
</html>
