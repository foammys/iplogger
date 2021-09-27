<?php
session_start();
if($_SESSION['auth'] != "true"){
  Header("Location: /admin/");
}

function randomPassword() {
  $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
  $pass = array(); //remember to declare $pass as an array
  $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
  for ($i = 0; $i < 8; $i++) {
      $n = rand(0, $alphaLength);
      $pass[] = $alphabet[$n];
  }
  return implode($pass); //turn the array into a string
}

if(isset($_GET['rem'])){
	$id = $_GET['rem'];
	include("db_settings.php");
	$conn = new mysqli($host, $user, $password, $db);
   
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }
   
   if($id == "*"){
	   $sql = "DELETE FROM `$table`";
   }else{
   $sql = "DELETE FROM `$table` WHERE `id` = '".$id."'";
   }
   $result = $conn->query($sql);
   Header("Location: /admin/logger.php");
}

if(isset($_GET['act'])){
  switch($_GET['act']){
    case "logout":
      $_SESSION['auth'] = "false";
      session_destroy();
      Header("Location: /admin/");
      break;

  }
}

if(isset($_GET['down'])){
  include("db_settings.php");
	$conn = new mysqli($host, $user, $password, $db);
  $sql = "SELECT * FROM `$table` ORDER BY `$table`.`identify` DESC";
  $retval = $conn->query($sql);
  $num_rows = $retval->num_rows;
  $rnd = randomPassword() . ".txt";
  $db = "";
  for($i = 0; $i < $num_rows; ++$i){ 
    $row = mysqli_fetch_array($retval);
    $db .= $row['ip'] . "   " . $row['browser'] . "   " . $row['isp'] . "   " . $row['system'] . "   " . $row['proxy'] . "\r\n";
  }
  file_put_contents("logs/" . $rnd, $db);
  Header("Location: /admin/logs/" . $rnd);
}

?>


<!doctype html>
<html lang="en">

<head>
  <title>Foammy > IpLogger</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <!-- Material Kit CSS -->
  <link href="assets/css/material-dashboard.css?v=2.1.0" rel="stylesheet" />
</head>

<body class="dark-edition">
  <div class="wrapper ">
    <div class="sidebar" data-color="purple" data-background-color="black" data-image="./assets/img/background.png">
      <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
      <div class="logo">
        <a href="#" class="simple-text logo-normal">
          Foammy
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item active  ">
            <a class="nav-link" href="javascript:void(0)">
              <i class="material-icons">people</i>
              <p>Главная</p>
            </a>
          </li>
          <!-- your sidebar here -->
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:void(0)">IP Логи</a>
          </div>
          

          <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" href="javscript:void(0)" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">person</i>
                  <p class="d-lg-none d-md-block">
                    Some Actions
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="?act=logout">Выход</a>
                </div>
              </li>
            </ul>
          </div>

      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="container-fluid">
          <!-- your content here -->
          <div class="row">
            <div class="col-md-12">
              <div class="card card-plain">
                <div class="card-header card-header-primary">
                  <h4 class="card-title mt-0">Логи</h4>
                  <?php
                  include("db_settings.php");
                  $conn = new mysqli($host, $user, $password, $db);
                    
                    if(! $conn ) {
                        die('Could not connect: ' . mysql_error());
                    }
                    
                    $sql = "SELECT * FROM `$table`";
                    $retval = $conn->query($sql);
                    $num_rows = $retval->num_rows;
                  echo '<p class="card-category">Кол-во логов: '.$num_rows.'</p>';
                  ?>
                  <ul class="nav nav-tabs" data-tabs="tabs">
                        <li class="nav-item" onclick="window.open('?rem=*')">
                          <a class="nav-link" href="?rem=*" data-toggle="tab">
                            <i class="material-icons">delete</i> Delete all
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      <li class="nav-item" onclick="window.open('?down')">
                          <a class="nav-link" href="?down"data-toggle="tab">
                            <i class="material-icons">sim_card_download</i> Download DB
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                      </ul>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead class="">
                        <th>
                          Айпи
                        </th>
                        <th>
                          Браузер
                        </th>
                        <th>
                          Провайдер
                        </th>
                        <th>
                          Система
                        </th>
                        <th>
                          Информация
                        </th>
                        <th>
                          Страна
                        </th>
                        <th>
                          Прокси
                        </th>
                        <th>
                          Действия
                        </th>
                      </thead>
                      <tbody>
                        <?php
                          include("db_settings.php");
                          $conn = new mysqli($host, $user, $password, $db);
                            
                            if(! $conn ) {
                                die('Could not connect: ' . mysql_error());
                            }
                            
                            $sql = "SELECT * FROM `$table` ORDER BY `$table`.`identify` DESC";
                            $retval = $conn->query($sql);
                            $num_rows = $retval->num_rows;
                            for($i = 0; $i < $num_rows; ++$i){ 
                              $row = mysqli_fetch_array($retval);
                              if($row['proxy'] != "true"){
                                $proxy = '<div class="badge badge-success badge-success-alt">'.$row['proxy'].'</div>';
                              }else{
                                $proxy = '<div class="badge badge-danger">'.$row['proxy'].'</div>';
                              }
                              echo'
                          <tr>
                            <td>'.$row['ip'].'<br><div class="badge badge-success badge-success-alt">'.$row['date'].'</div></td>
                            <td>'.$row['browser'].'</td>
                            <td>'.$row['isp'].'</td>
                            <td>'.$row['system'].'</td>
                            <td>'.$row['user_agent'].'</td>
                            <td><div class="badge badge-success badge-success-alt">'.$row['city'].'</div></td>
                            <td>'.$proxy.'</td>

                            <td>
                            <div class="dropdown">
                              <button class="btn btn-white btn-link btn-sm" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="Включены" aria-expanded="Отключены">
                                    <i class="material-icons" data-toggle="tooltip" data-placement="top"
                                      title="Actions">more_horiz</i>
                                  </button>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <a class="dropdown-item text-danger" href="?rem='.$row['id'].'"><i class="bx bxs-trash mr-2"></i> Удалить из списка</a>
                                <a class="dropdown-item text-info" href="https://ru.infobyip.com/ip-'.$row['ip'].'.html"><i class="bx bxs-eject mr-2"></i> Информация об IP</a>
                              </div>
                            </div>
                          </td>

                          </tr>';
                            }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>





        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <nav class="float-left">
            <ul>
              <li>

              </li>
            </ul>
          </nav>
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, Created <i class="material-icons">favorite</i> by
            <a href="/" target="_blank">Foammy</a>
          </div>
          <!-- your footer here -->
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="./assets/js/core/jquery.min.js"></script>
  <script src="./assets/js/core/popper.min.js"></script>
  <script src="./assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="https://unpkg.com/default-passive-events"></script>
  <script src="./assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!--  Google Maps Plugin    -->
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <!-- Chartist JS -->
  <script src="./assets/js/plugins/chartist.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="./assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="./assets/js/material-dashboard.js?v=2.1.0"></script>
  <!-- Material Dashboard DEMO methods, don't include it in your project! -->
  <script src="./assets/demo/demo.js"></script>
  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        $('.fixed-plugin a').click(function(event) {
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');


          var new_image = $(this).find("img").attr('src');

          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }

          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }

          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');

          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');

          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

          } else {

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

            setTimeout(function() {
              $('body').addClass('sidebar-mini');

              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
    });
  </script>
</body>

</html>