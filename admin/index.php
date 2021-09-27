<?php
session_start();

if($_SESSION['auth'] == "true"){
    Header("Location: /admin/logger.php");
  }
  
if(isset($_POST['login'])){
	$login = $_POST['login'];
	$pass = $_POST['pass'];

	if($login != "foammy" || $pass != "hamsterhaha17"){
		$status = "<p style='color: darkred'>Authorization error!</p>";
	}else{
		$_SESSION['auth'] = "true";
		$status = "<font color=green>Auth success!</font>";
        Header("Location: /admin/logger.php");
	}
}
?>

<html>
    <head>
        <title>что-то на богатом</title>
        <script src='https://www.google.com/recaptcha/api.js?hl=ru'></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    </head>

    <body>
    <div class="btn-music">
    <i style="color:gray" class="fa fa-code"> Created by <a style="color: cyan" href="https://foammy.pw">Foammy </a></i>
</div>
    <div id="particles-js"></div>
<script src="../assets/particles.min.js"></script>

<script>
particlesJS("particles-js", {
  "particles": {
    "number": {
      "value": 900,
      "density": {
        "enable": true,
        "value_area": 789.1476416322727
      }
    },
    "color": {
      "value": "#02f7f7"
    },
    "shape": {
      "type": "circle",
      "stroke": {
        "width": 0,
        "color": "#02f7f7"
      },
      "polygon": {
        "nb_sides": 5
      },
      "image": {
        "src": "img/github.svg",
        "width": 100,
        "height": 100
      }
    },
    "opacity": {
      "value": 0.48927153781200905,
      "random": false,
      "anim": {
        "enable": true,
        "speed": 1,
        "opacity_min": 0,
        "sync": false
      }
    },
    "size": {
      "value": 2,
      "random": true,
      "anim": {
        "enable": true,
        "speed": 2,
        "size_min": 0,
        "sync": false
      }
    },
    "line_linked": {
      "enable": false,
      "distance": 150,
      "color": "#02f7f7",
      "opacity": 0.4,
      "width": 1
    },
    "move": {
      "enable": true,
      "speed": 1.4,
      "direction": "none",
      "random": true,
      "straight": false,
      "out_mode": "out",
      "bounce": false,
      "attract": {
        "enable": false,
        "rotateX": 600,
        "rotateY": 1200
      }
    }
  },
  "interactivity": {
    "detect_on": "canvas",
    "events": {
      "onhover": {
        "enable": true,
        "mode": "bubble"
      },
      "onclick": {
        "enable": true,
        "mode": "push"
      },
      "resize": true
    },
    "modes": {
      "grab": {
        "distance": 400,
        "line_linked": {
          "opacity": 1
        }
      },
      "bubble": {
        "distance": 83.91608391608392,
        "size": 1,
        "duration": 3,
        "opacity": 1,
        "speed": 3
      },
      "repulse": {
        "distance": 200,
        "duration": 0.4
      },
      "push": {
        "particles_nb": 4
      },
      "remove": {
        "particles_nb": 2
      }
    }
  },
  "retina_detect": true
});
</script>


<style>
form {
  border: 3px solid #f1f1f1;
  border-color: gray;
  position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
  border-radius: 8px;
}

.btn-music {
	font-family: fanta;
	text-align: right;
	font-size: 1em;
	left:-1%;
	width: 100%;
	position: absolute;
	top: 96%;
  z-index: 999;
}

body{
    background-image: url("https://i.imgur.com/OqH4GUk.jpg");
    --moz-background-size:100%;
-webkit-background-size:100%;
-o-background-size:100%;
background-size:100%;
}

/* Full-width inputs */
input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

/* Set a style for all buttons */
button {
  background-color: #4CAF50;
  color: #262626;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

/* Add a hover effect for buttons */
button:hover {
  opacity: 0.8;
}

/* Extra style for the cancel button (red) */
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #262626;
}

/* Center the avatar image inside this container */
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}

/* Avatar image */
img.avatar {
  width: 40%;
  border-radius: 50%;
}

/* Add padding to containers */
.container {
  padding: 16px;
}

/* The "Forgot password" text */
span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
    display: block;
    float: none;
  }
  .cancelbtn {
    width: 100%;
    color: white;
  }
}

</style>
        <form method="post">
        <div class="container" style="background-color: #1c1c1c; opacity: 0.7; box-shadow: 0 0 10px rgba(0,0,0,0.8);">
            <label style="color: cyan" for="uname"><b>Логин</b></label>
            <input style="background-color: #262626; border-radius: 8px; color: cyan" type="text" placeholder="Enter Username" name="login" required>

            <label style="color: cyan" for="psw"><b>Пароль</b></label>
            <input style="background-color: #262626; border-radius: 8px; color: cyan" type="password" placeholder="Enter Password" name="pass" required>
            <button style="color: white; border-radius: 8px;" type="submit">Войти</button>
        </div>

        <div class="container" style="background-color:gray">
            <font color=white><?=$status?></font>
        </div>
    </form>
    <body>
</html>