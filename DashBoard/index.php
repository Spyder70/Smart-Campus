<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");

$PageName="Dash Board";
$Link_Home="active";

//$usn=$_SESSION['usn'];


/*
if($placein!="admin")
{
	echo "Please Do Login First..!";
	header("location:../Login.php");
	exit;
}

*/

$Students_Total;
$Faculties_Total;
$Students_Blocked=0;
$Company_Total=0;

	$Add_sql="Select Count(*) as Stot from Student_Info";
	$Add_query= $dbh -> prepare($Add_sql);
	$Add_query-> execute();
	$row = $Add_query->fetch();
	$Students_Total=$row['Stot'];

    	$Add_sql="Select Count(*) as Ftot from Faculty";
	$Add_query= $dbh -> prepare($Add_sql);
	$Add_query-> execute();
	$row = $Add_query->fetch();
	$Faculties_Total=$row['Ftot'];

	$Add_sql="Select Count(*) as Ctot from Department";
	$Add_query= $dbh -> prepare($Add_sql);
	$Add_query-> execute();
	$row = $Add_query->fetch();
	$Course_Total=$row['Ctot'];




?>



<?php require('../Head/Head.php'); ?>









  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">

    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $Students_Total; ?></h3>

                <p>Students</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="../Students/Students.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->


          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $Faculties_Total; ?></h3>

                <p>Faculties</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="../Faculty/Faculty.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->


          <div class="col-lg-3 col-6">
            <!-- small box        -->
            <div class="small-box bg-danger">
              <div class="inner">
                 <h3><?php echo 0;// echo $Students_Blocked; ?></h3>

                <p>Blocked Students</p>
              </div>
              <div class="icon">
                <i class="fas fa-thumbs-down"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                  <h3><?php echo $Course_Total; ?></h3>

                <p>PROGRAMS</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

<html>
				      <style>
				        .image-section {
				          height: 55vh;
				          display: block;
				          justify-content: center;
				          align-items: center;

				        }

				        img {

				          width: 100%;
				          height: 110%;
				          object-fit: cover;

				        }
				      </style>

				      <body>
				        <section class="image-section">
				          <img src="../images/Arch.jpg" alt="your-image-alt-text">
				        </section>
				      </body>
				      </body>

				      </html>







  <!-- Info boxes --
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">CPU Traffic</span>
                <span class="info-box-number">
                  10
                  <small>%</small>
                </span>
              </div>
              <!-- /.info-box-content --
            </div>
            <!-- /.info-box --
          </div>
          <!-- /.col --
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Likes</span>
                <span class="info-box-number">41,410</span>
              </div>
              <!-- /.info-box-content --
            </div>
            <!-- /.info-box --
          </div>
          <!-- /.col -->

          <!-- fix for small devices only --
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Sales</span>
                <span class="info-box-number">760</span>
              </div>
              <!-- /.info-box-content --
            </div>
            <!-- /.info-box --
          </div>
          <!-- /.col --
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">New Members</span>
                <span class="info-box-number">2,000</span>
              </div>
              <!-- /.info-box-content --
            </div>
            <!-- /.info-box --
          </div>
          <!-- /.col --
        </div>
        <!-- /.row -->



			
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->



<?php require('../Head/Foot.php');   ?>
