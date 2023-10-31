<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");

$Link_Home="active";

$placein=$_SESSION['placein'];
$usn=$_SESSION['usn'];
$college_email=$_SESSION['email'];
$user_type=$_SESSION['utype'];
$user_mode=$_SESSION['uactive'];		
$user_registered=$_SESSION['registered'];

$prev_pic_path=$_SESSION['p_pic_path'];
$user_job_enable=$_SESSION['p_job_enable'];
			


if($placein!="admin")
{
	echo "Please Do Login First..!";
	header("location:../Login.php");			
	exit;
}


$Students_Total;
$Students_Registered;
$Students_Blocked;
$Company_Total;

	$sel = $dbh->prepare('select * from users');
	$sel->execute();
    	$Students_Total=$sel->rowCount();
    	
    	$sel = $dbh->prepare('select * from students');
	$sel->execute();
    	$Students_Registered=$sel->rowCount();
    	
    	$sel = $dbh->prepare('select * from users where active=3');
	$sel->execute();
    	$Students_Blocked=$sel->rowCount();
    	
    	$sel = $dbh->prepare('select * from jobs');
	$sel->execute();
    	$Company_Total=$sel->rowCount();
    	

?>



<?php require('Head.php'); ?>









  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) --
        <div class="row">
        <!--
          <div class="col-lg-3 col-6">
            <!-- small box --
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $Students_Total-1; ?></h3>

                <p>Total No. Of Students</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col --
          
          
          <div class="col-lg-3 col-6">
            <!-- small box --
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $Students_Registered; ?></h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col --
          
          
          <div class="col-lg-3 col-6">
            <!-- small box        --
            <div class="small-box bg-danger">
              <div class="inner">
                 <h3><?php echo $Students_Blocked; ?></h3>

                <p>Blocked Students</p>
              </div>
              <div class="icon">
                <i class="fas fa-thumbs-down"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col --
          
          <div class="col-lg-3 col-6">
            <!-- small box --
            <div class="small-box bg-success">
              <div class="inner">
                  <h3><?php echo $Company_Total; ?></h3>

                <p>Company Visits</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col --
        </div>
        <!-- /.row -->
        
        
        
        
        
         
        
        
        
  <!-- Info boxes -->
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
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Likes</span>
                <span class="info-box-number">41,410</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Sales</span>
                <span class="info-box-number">760</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">New Members</span>
                <span class="info-box-number">2,000</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

       

        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-12">
            <!-- MAP & BOX PANE -->
           
            <div class="row">
              <div class="col-md-6">
                <!-- USERS LIST -->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Recent Profile Updates</h3>

                    <div class="card-tools">
                      <span class="badge badge-danger">Recenet 12 Updates</span>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                  
                     <ul class="users-list clearfix">
                  
       <?php
        $sql = "SELECT * from students Order By updated_at desc LIMIT 12";
	$query = $dbh->prepare($sql);
	//$query->bindParam(':var1', $F_USN);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$cnt=1;
	if($query->rowCount() > 0)
	 {
		foreach($results as $result)
		{
		
                  
                  ?>
                    
                       <li>
                        <img src="../Student/<?php echo $result->passport_image_url; ?>" style="" alt="User Image">
                        <a class="users-list-name" href="#"> <?php echo $result->usn; ?></a>
                        <span class="users-list-date"><?php echo substr($result->first_name,0,10); ?></span>  
                        <span class="users-list-date"><?php echo $result->updated_at; ?></span>
                      </li>
                      
                      
                      
                      
                      
        <?php
        
        	}
        }
        
        ?>
                      
                    </ul>
                    <!-- /.users-list -->
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer text-center">
                    <a href="StudentSearch.php">For More </a>
                  </div>
                  <!-- /.card-footer -->
                </div>
                <!--/.card -->
                
              </div>
              <!-- /.col -->
              
              
              
              
               <div class="col-md-6">
                <!-- USERS LIST -->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Academic Toppers </h3>

                    <div class="card-tools">
                      <span class="badge badge-danger">Top 9 </span>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                  
                     <ul class="users-list clearfix">
                  
       <?php
        $sql = "SELECT * from students Order By cgpa desc LIMIT 9";
	$query = $dbh->prepare($sql);
	//$query->bindParam(':var1', $F_USN);
	$query->execute();
	$results=$query->fetchAll(PDO::FETCH_OBJ);
	$cnt=1;
	if($query->rowCount() > 0)
	 {
		foreach($results as $result)
		{
		
                  
                  ?>
                    
                       <li>
                        <img src="../Student/<?php echo $result->passport_image_url; ?>" style="" alt="User Image">
                        <a class="users-list-name" href="#"> <?php echo $result->usn; ?></a>
                        <span class="users-list-date"><?php echo substr($result->first_name,0,10); ?></span>  
                        <span class="users-list-date"><?php echo "CGPA:".$result->cgpa; ?></span>
                      </li>  
                      
        <?php
        
        	}
        }
        
        ?>
                      
                    </ul>
                    <!-- /.users-list -->
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer text-center">
                    <a href="StudentSearch.php">For More </a>
                  </div>
                  <!-- /.card-footer -->
                </div>
                <!--/.card -->
                
              </div>
              <!-- /.col -->
              
              
              
              
              
              
            </div>
            <!-- /.row -->

            <!-- TABLE: LATEST ORDERS -->
           
          </div>
          <!-- /.col -->











          <div class="col-md-4">
            <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Inventory</span>
                <span class="info-box-number">5,200</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="far fa-heart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Mentions</span>
                <span class="info-box-number">92,050</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Downloads</span>
                <span class="info-box-number">114,381</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="far fa-comment"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Direct Messages</span>
                <span class="info-box-number">163,921</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->

         

         
          </div>
          <!-- /.col -->
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
  
  
  
  <?php require('Foot.php');   ?>
