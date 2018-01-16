<?php
if(isset($_SESSION['USERNAME'])){$Username=$_SESSION['USERNAME'];}else{$Username="";header("location:logout.php");}
?>
<nav class="navbar navbar-inverse top-bar navbar-fixed-top">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button> <span class="menu-icon" id="menu-icon"><i class="fa fa-times" aria-hidden="true" id="chang-menu-icon"></i></span>
        <a class="navbar-brand" href="#"><img src="images/logo.png" style="width: 36px;"> </a>
      </div>
      <div class="collapse navbar-collapse navbar-right" id="myNavbar">
        <!--form class="navbar-form navbar-left">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search">
            <div class="input-group-btn">
              <button class="btn btn-default" type="submit">
                <i class="glyphicon glyphicon-search"></i> </button>
            </div>
          </div>
        </form-->
        <ul class="nav navbar-nav">
          <li class=""><a href="#"><i class="fa fa-envelope"></i> <span class="badge">5</span></a> </li>
          <li class=""><a href="#"><i class="fa fa-bell"></i> <span class="badge">9</span></a> </li>
          <li class="">
            <a href="#" class="user-profile"> <span class=""><img class="img-responsive" src="https://lh3.googleusercontent.com/-HxSAl6WJSI0/WM-dbkQ1ONI/AAAAAAAADuY/RsjaXC3tg4oBozCUYyLr12ZjZ1_Cl91mACJoC/w424-h319-p-rw/sumit.png"></span> </a>
          </li>
          <li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $Username; ?>          
           <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li> <a href="#"><i class="fa fa-user"></i> Profile</a> </li>
              <li> <a href="#"><i class="fa fa-cog"></i> Setting</a> </li>
              <li> <a href="logout.php"><i class="fa fa-power-off"></i> Logout</a> </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>