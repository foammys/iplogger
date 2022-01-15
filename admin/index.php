<?php
session_start();

if($_SESSION['auth'] == "true"){
    Header("Location: /admin/logger.php");
  }
  
if(isset($_POST['login'])){
	$login = $_POST['login'];
	$pass = $_POST['pass'];

	if($login != "login" || $pass != "pass"){
		$status = "Неверный логин или пароль";
	}else{
		$_SESSION['auth'] = "true";
		$status = "Авторизация пройдена";
        Header("Location: /admin/logger.php");
	}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>
         Foammy | Panel
    </title>

    <link rel="stylesheet" href="static/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="static/assets/vendors/css/vendor.bundle.base.css">

    <!-- Specific Plugin CSS goes HERE -->
    

    <!-- Layout styles -->
    <link rel="stylesheet" href="static/assets/css/style.css">
    <!-- End layout styles -->

    <!-- Specific CSS goes HERE -->
    

  </head>
  <body>
    <div class="container-scroller">

        

  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="row w-100 m-0">
      <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
        <div class="card col-lg-4 mx-auto">
          <div class="card-body px-5 py-5">
            <h3 class="card-title text-left mb-3">Вход</h3>
            <form method="post" id="login-form">
              <div class="form-group">
                <label>Логин</label>
                <input type="text" class="form-control p_input" name="login" required>
              </div>
              <div class="form-group">
                <label>Пароль</label>
                <input type="password" class="form-control p_input" name="pass" required>
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-primary btn-block enter-btn">Вход</button>
              </div>
            </form>
		<label class="badge badge-danger" style="max-width: 100%; overflow-x: scroll;"><?=$status?></label>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- row ends -->
  </div>


    </div>
    <!-- container-scroller -->

    <script src="static/assets/vendors/js/vendor.bundle.base.js" type="dc9094346ba080a8f357dd93-text/javascript"></script>

    <!-- Specific Plugin JS goes HERE  -->
    

    <script src="static/assets/js/off-canvas.js" type="dc9094346ba080a8f357dd93-text/javascript"></script>
    <script src="static/assets/js/hoverable-collapse.js" type="dc9094346ba080a8f357dd93-text/javascript"></script>
    <script src="static/assets/js/misc.js" type="dc9094346ba080a8f357dd93-text/javascript"></script>
    <script src="static/assets/js/settings.js" type="dc9094346ba080a8f357dd93-text/javascript"></script>
    <script src="static/assets/js/todolist.js" type="dc9094346ba080a8f357dd93-text/javascript"></script>

    <!-- Specific Page JS goes HERE  -->
    
    
</html>