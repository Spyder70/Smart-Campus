<?php
/*Active Links

$Link_Home;
$L_Department
$L_Faculty



Headings
$Register_Head;
$Course_Registraton_Head;




Registration_Link

$S_Admission;
$S_Students
$S_Allotment;





*/

include ('../Checklog.php');
$fname=$_SESSION['F_Name'];
$_SESSION['F_Role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" href="../images/favicon.ico">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>SmartCampus | 2021</title>


  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">

  <link rel="stylesheet" href="../css/ionicons.min.css">
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <!--<link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css">
   <link rel="stylesheet" href="../plugins/jquery/jquery.min.js">-->
   <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css">



  <!-- daterange picker -->
  <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">

  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="../plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="../plugins/dropzone/min/dropzone.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">




</head>
<body class="hold-transition sidebar-mini layout-fixed">


<style>
/* Paste this css to your style sheet file or under head tag */
/* This only works with JavaScript,
if it's not present, don't show loader */
.no-js #loader { display: none;  }
.js #loader { display: block; position: absolute; left: 100px; top: 0; }
.se-pre-con {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url(../images/Preloader_2.gif) center no-repeat #fff;
}
</style>

<script src="../plugins/jquery/jquery1.min.js"></script>
<script>
	//paste this code under head tag or in a seperate js file.
	// Wait for window load
	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut();;
	});
</script>

</head>

<body>
	<!-- Paste this code after body tag -->
	<div class="se-pre-con"></div>
	<!-- Ends -->











<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>


      <li class="nav-item d-none d-sm-inline-block <?php echo $Link_Home; ?>">
        <h4 class="nav-link"><?php echo'<p style="color:#000066;">Dashboard</p>' ?></h4>
      </li><!--
      <li class="nav-item d-none d-sm-inline-block <?php echo $Link_Dash; ?>">
        <a href="../DashBoard.php" class="nav-link">Dash Board</a>
      </li>
       <li class="nav-item d-none d-sm-inline-block <?php echo $Link_Company; ?>">
        <a href="Admission.php" class="nav-link">Admission</a>
      </li>

       -->


   </ul>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4"style="background-color:#d9d9d9";>
    <!-- Brand Logo
    <center>
    <a href="../DashBoard/" class="brand-link">
        <center><img src="../dist/img/nitte.jpg" alt="AdminLTE Logo"  style="height:100px;width:100px;border-radius: 50%;margin-bottom:-20px;"></center>
      <span class="brand-text font-weight-bold" style="margin-left:100px;">   </span>
    </a>
     </center> -->


    <!-- Sidebar -->
    <div class="sidebar" >
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 " >
       <center><a  style="color:orange;font-weight:bold;font-size:27px" href="../DashBoard/index.php"><marquee style="color:#000066;font-weight:bold;">Architecture-School</marquee></a>
         <br><span style="color:Black;font-weight:bold;font-size:px"><?php
         if(strlen($fname)>22)
         {
         echo "<p>$fname</p>";
         }
         else
         {
         echo $fname;
         }?></span></center>

      </div>

      <!-- SidebarSearch Form
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search Student" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>




      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


<style>
p{
  color:#000066;
  font-weight:bold;
  font-size:px;
}
i
{
  color:Black;
}

p:hover, h1:hover, a:hover {
  background-color: #80b3ff;
}
</style>
        <li class="nav-item">
            <a href="../DashBoard/index.php" class="nav-link <?php echo $Link_Home; ?>">
              <i style="color:Black;" class="nav-icon fas fa-home"></i>
              <p style="color:Black;font-weight:bold;font-size:px;">
                Home
               <!-- <span class="right badge badge-danger">New</span>        fa-tachometer-alt-->
              </p>
            </a>
          </li>
          <?php  if($_SESSION['F_Role']=='Admin')
          {
          ?>
         <li class="nav-item">
            <a href="../Department/Department.php" class="nav-link <?php echo $L_Department; ?>">
              <i class="nav-icon fas fa-cubes"></i>
              <p>
                Department
               <!-- <span class="right badge badge-danger">New</span>        fa-tachometer-alt-->
              </p>
            </a>
          </li>

          <?php
          }
          if($_SESSION['F_Role']=='Support')
          {
          ?>

          <li class="nav-item">
            <a href="../Support/Search_Student.php" class="nav-link <?php echo $Search_Stud; ?>">
              <i class="nav-icon fas fa-search"></i>
              <p>
                Search Student
               <!-- <span class="right badge badge-danger">New</span>        fa-tachometer-alt-->
              </p>
            </a>
          </li>


         <li class="nav-item">
            <a href="../Support/Section_Report.php" class="nav-link <?php echo $Sec_Rep; ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Section Report
               <!-- <span class="right badge badge-danger">New</span>        fa-tachometer-alt-->
              </p>
            </a>
          </li>

           <li class="nav-item">
                 <a href="../Support/AbsentOn.php" class="nav-link <?php echo $Absenties_List; ?>">
                  <i class="nav-icon fas fa-ban"></i>
                  <p>Absent On </p>
                 </a>
           </li>

          <?php
          }




          ?>


           <?php  if($_SESSION['F_Role']=='Admin' || $_SESSION['F_Role']=='DataEntry')
           {
           ?>
          <li class="nav-item <?php echo $Register_Head;?>">
            <a href="#" class="nav-link <?php echo $S_Admission.$S_Students.$S_Allotment; ?>">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>Registration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

            	<li class="nav-item">
            	 <a href="../Register/Admission.php" class="nav-link <?php echo $S_Admission; ?>">
              	    <i class="nav-icon fas fa-user-plus"></i>
                    <p>Admission
                     <!-- <span class="right badge badge-danger">New</span> -->
                    </p>
                </a>
               </li>

               <li class="nav-item">
                <a href="../Students/Students.php" class="nav-link <?php echo $S_Students; ?>">
                  <i class="nav-icon fas fa-list-ol"></i>
                  <p>Students List </p>
                </a>
              </li>


              	      <?php
              	       if($_SESSION['F_Role']=='Admin')
          	       {
          	       ?>

                          <li class="nav-item">
                             <a href="../Allotment/Allotment.php" class="nav-link <?php echo $S_Allotment; ?>">
                             <i class="nav-icon fas fa-hand-holding-usd"></i>
                             <p>Allotments </p>
                             </a>
                          </li>

                    <?php } ?>

            </ul>
          </li> <!--Reg End--->

           <?php } ?>




          <?php
          if($_SESSION['F_Role']=='Admin')
          {
          ?>


          <!--Subject Reg Start--->

           <li class="nav-item <?php echo $Course_Registration_Head;?>">
            <a href="#" class="nav-link <?php
            echo $C_Subjects.$CB_Subjects.$Add_CRegistration.$Remove_CRegistration.$Bulk_CRegistration.$Ind_CRegistration; ?>">
              <i class="nav-icon fas fa-copyright"></i>
              <p>Course Registration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
               <ul class="nav nav-treeview">

            	<li class="nav-item">
            	 <a href="../Course_Registration/Add_Course.php" class="nav-link <?php echo $C_Subjects; ?>">
              	    <i class="nav-icon fas fa-folder-plus"></i>
                    <p>Add Subjects
                     <!-- <span class="right badge badge-danger">New</span> -->
                    </p>
                </a>
               </li>

               <li class="nav-item">
            	 <a href="../Course_Registration/Bulk_Course.php" class="nav-link <?php echo $CB_Subjects; ?>">
              	    <i class="nav-icon fas fa-ambulance"></i>
                    <p>Add Bulk Subjects
                     <!-- <span class="right badge badge-danger">New</span> -->
                    </p>
                </a>
               </li>


              <li class="nav-item">
            	 <a href="../Course_Registration/Bulk_Subject_Register.php" class="nav-link <?php echo $Bulk_CRegistration; ?>">
              	    <i class="nav-icon fas fa-suitcase-rolling"></i>
                    <p>Bulk Registration
                     <!-- <span class="right badge badge-danger">New</span> -->
                    </p>
                </a>
             </li>

              



             <!-- Old One

             <li class="nav-item">
            	 <a href="../Course_Registration/Add_Registration.php" class="nav-link <?php echo $Add_CRegistration; ?>">
              	    <i class="nav-icon fas fa-user-plus"></i>
                    <p>Register USN's
                     <!-- <span class="right badge badge-danger">New</span> --
                    </p>
                </a>
             </li>

             <li class="nav-item">
            	 <a href="../Course_Registration/Remove_Registration.php" class="nav-link <?php echo $Remove_CRegistration; ?>">
              	    <i class="nav-icon fas fa-user-plus"></i>
                    <p>Un-Register USN's
                     <!-- <span class="right badge badge-danger">New</span> --
                    </p>
                </a>
             </li>

            End Old  -->



              </ul>
            </li>



            <li class="nav-item <?php echo $Faculty_Head;?>">
            <a href="#" class="nav-link <?php echo $L_Faculty.$Fin_FSub.$Swap_FSub; ?>">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>Faculties
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

            <li class="nav-item">
                <a href="../Faculty/Faculty.php" class="nav-link <?php echo $L_Faculty; ?>">
                  <i class="nav-icon fas fa-users"></i>
                  <p>All Faculties </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="../Faculty/FinalizedSubjects.php" class="nav-link <?php echo $Fin_FSub; ?>">
                  <i class="nav-icon fas fa-money-bill-wave-alt"></i>
                  <p>Finalized Subjects </p>
                </a>
            </li>
             <li class="nav-item">
                <a href="../Faculty/SwapSubjects.php" class="nav-link <?php echo $Swap_FSub; ?>">
                  <i class="nav-icon fas fa-exchange-alt"></i>
                  <p>Swap Subjects </p>
                </a>
            </li>

            </ul>
            </li>

           <?php } ?>
             <?php  if($_SESSION['F_Role']=='Admin' || $_SESSION['F_Role']=='DataEntry')
              {
              ?>
            <li class="nav-item <?php echo $AReport_Head;?>">
            <a href="#" class="nav-link <?php echo $POST_MSE.$Absenties_List.$Sub_Reg_list.$MSE_50.$ALL_MSE.$S_StudentsDB; ?>">
              <i class="nav-icon fas fa-file-export"></i>
              <p>Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
               <ul class="nav nav-treeview">
                 <li class="nav-item">
                 <a href="../Reports/MSE_POST.php" class="nav-link <?php echo $POST_MSE; ?>">
                  <i class="nav-icon fas fa-tasks"></i>
                  <p>Progress Report </p>
                 </a>
                 </li>
                <?php
        	 if($_SESSION['F_Role']=='Admin')
          	 {
                 ?>

                <li class="nav-item">
                 <a href="../Students/StudentsDB.php" class="nav-link <?php echo $S_StudentsDB; ?>">
                  <i class="nav-icon fas fa-file-alt"></i>
                  <p>Students DB </p>
                 </a>
                 </li>


                 <li class="nav-item">
                 <a href="../Reports/Absenties.php" class="nav-link <?php echo $Absenties_List; ?>">
                  <i class="nav-icon fas fa-ban"></i>
                  <p>Absenties List </p>
                 </a>
                 </li>

                 <li class="nav-item">
                 <a href="../Reports/Registered_List.php" class="nav-link <?php echo $Sub_Reg_list; ?>">
                  <i class="nav-icon fas fa-address-book"></i>
                  <p>Registration List </p>
                 </a>
                 </li>

                 <li class="nav-item">
                 <a href="../Reports/MSE_Report.php" class="nav-link <?php echo $ALL_MSE; ?>">
                  <i class="nav-icon fas fa-address-card"></i>
                  <p>MSE Report </p>
                 </a>
                 </li>

                 <li class="nav-item">
                 <a href="../Reports/MSE_50.php" class="nav-link <?php echo $MSE_50; ?>">
                  <i class="nav-icon fas fa-less-than-equal"></i>
                  <p>MSE < 50% </p>
                 </a>
                 </li>
                 <?php } ?>
                </ul>
            </li>

           <?php
                 if($_SESSION['F_Role']=='Admin')
                 {
                 ?>
            <li class="nav-item">
            <a href="../BackupDB/Backup.php" class="nav-link <?php echo $Sql_Back; ?>">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Backup DB
               <!-- <span class="right badge badge-danger">New</span>        fa-tachometer-alt-->
              </p>
            </a>
          </li>
         <?php } ?>


      <?php } ?>








          <?php
          if($_SESSION['F_Role']=='Faculty')
          {
          ?>


          <li class="nav-item <?php echo $Entry_Head;?>">
            <a href="#" class="nav-link <?php
              echo $Add_Attendance.$Add_Subjects.$CIA_Entry.$Student_Eligible.$DeleteAttendance; ?>">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>Data Entry
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
               <ul class="nav nav-treeview">



               <li class="nav-item">
                <a href="../All_Faculty/Add_Subjects.php" class="nav-link <?php echo $Add_Subjects; ?>">
                  <i class="nav-icon fas fa-plus-square"></i>
                  <p>Add Subjects </p>
                </a>
              </li>


            	<li class="nav-item">
                <a href="../All_Faculty/Add_Attendance.php" class="nav-link <?php echo $Add_Attendance; ?>">
                  <i class="nav-icon fas fa-bell"></i>
                  <p>Add Attendance </p>
                </a>
           	</li>

           	<li class="nav-item">
                <a href="../All_Faculty/DeleteAttendance.php" class="nav-link <?php echo $DeleteAttendance; ?>">
                  <i class="nav-icon fas fa-bell-slash"></i>
                  <p>Delete Attendance </p>
                </a>
           	</li>


               <li class="nav-item">
                <a href="../All_Faculty/CIA_Entry.php" class="nav-link <?php echo $CIA_Entry; ?>">
                  <i class="nav-icon fas fa-person-booth"></i>
                  <p>CIA Entry </p>
                </a>
           	</li>

           	<li class="nav-item">
                <a href="../All_Faculty/Student_Eligible.php" class="nav-link <?php echo $Student_Eligible; ?>">
                  <i class="nav-icon fas fa-id-card"></i>
                  <p>Student Eligibility </p>
                </a>
           	</li>

              </ul>
            </li>


             <li class="nav-item <?php echo $Report_Head;?>">
            <a href="#" class="nav-link <?php
             echo $Attendance_Percent.$Attendance_Register.$CIA_Sheet.$Marks_Report.$MIS_Rep.$Search_Stud; ?>">
              <i class="nav-icon fas fa-file-export"></i>
              <p>Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
               <ul class="nav nav-treeview">



            <?php if ((strpos($_SESSION['F_Desig'], "HEAD") == true) || (strpos($_SESSION['F_Desig'], "HOD") == true) ||  (strpos($_SESSION['F_Desig'], "COORDINATOR") == true) )
            {   ?>

                <li class="nav-item">
                <a href="../MIS/MIS.php" class="nav-link <?php echo $MIS_Rep; ?>">
                  <i class="nav-icon fas fa-users"></i>
                  <p>MIS Reports </p>
                </a>
                </li>

		<li class="nav-item">
                <a href="../Support/Search_Student.php" class="nav-link <?php echo $Search_Stud; ?>">
                  <i class="nav-icon fas fa-search"></i>
                  <p> Search Student
                  <!-- <span class="right badge badge-danger">New</span>        fa-tachometer-alt-->
                  </p>
                </a>
                </li>


                <!-- Added for Coordinator -->


           <li class="nav-item">
            <a href="../Support/Section_Report.php" class="nav-link <?php echo $Sec_Rep; ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Section Report
               <!-- <span class="right badge badge-danger">New</span>        fa-tachometer-alt-->
              </p>
            </a>
          </li>

           <li class="nav-item">
                 <a href="../Support/AbsentOn.php" class="nav-link <?php echo $Absenties_List; ?>">
                  <i class="nav-icon fas fa-ban"></i>
                  <p>Absent On </p>
                 </a>
           </li>





            <?php } ?>


               <li class="nav-item">
                <a href="../All_Faculty/Attendance_Register.php" class="nav-link <?php echo $Attendance_Register; ?>">
                  <i class="nav-icon fas fa-clipboard-list"></i>
                  <p>Attendance Register </p>
                </a>
              </li>


            	<li class="nav-item">
                <a href="../All_Faculty/Attendance_Percent.php" class="nav-link <?php echo $Attendance_Percent; ?>">
                  <i class="nav-icon fas fa-percent"></i>
                  <p>Attendance %-wise</p>
                </a>
           	</li>



               <li class="nav-item">
                <a href="../All_Faculty/Marks_Report.php" class="nav-link <?php echo $Marks_Report; ?>">
                  <i class="nav-icon fas fa-boxes"></i>
                  <p>Marks Report </p>
                </a>
           	</li>


               <li class="nav-item">
                <a href="../All_Faculty/CIA_Sheet.php" class="nav-link <?php echo $CIA_Sheet; ?>">
                  <i class="nav-icon fas fa-stream"></i>
                  <p>CIA SHEET </p>
                </a>
           	</li>



              </ul>
            </li>



         <?php } ?>



        <li class="nav-item">
                <a href="../ChangePassword/ChangePassword.php" class="nav-link  <?php echo $Link_SChange; ?>">
                  <i class="nav-icon fas  fa-unlock-alt "></i>
                  <p>Change Password</p>
                </a>
        </li>

        <!---


        CUT PASTE CORNER



        -->


           <li class="nav-item">
            <a href="../Logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p style="color:black">
               	 Log-Out
               <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>


           <!--    Blank Space  -->
          <li class="nav-item">
            <a href="" class="nav-link">
              <i class="nav-icon fas "></i>
              <p style="color:yellow">
               <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
