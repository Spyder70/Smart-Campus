<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
//require("../Authenticate/Support.php");
require_once('../PrintPDF/tcpdf_include.php');

//$Course_Registration_Head="menu-open";
//$Add_Subjects="active";

$PageName="View Individual Student Details";
$AReport_Head="menu-open";
$Report_Head="menu-open";
$Search_Stud="active";
$Faculty_ID=$_SESSION['F_ID'];


if( ($_SESSION['F_Role']!='Support') && (strpos($_SESSION['F_Desig'], "HEAD") == false) && (strpos($_SESSION['F_Desig'], "HOD") == false) && (strpos($_SESSION['F_Desig'], "COORDINATOR") == false ) )
{
  echo "No Access..!";
  header("location:../DashBoard/index.php");
  exit;
}



$C_msg="";




?>



<?php require('../Head/Head.php'); ?>
<script src="../dist/js/tableToExcel.js"></script>



<style>

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 40%;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>









 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid" >
        <div class="row mb-2" >
        
          <div id="myModal" class="modal">
  		<!-- Modal content -->
  		<div class="modal-content">
    		<span class="close">&times;</span>
    		<p><?php echo $C_msg; ?></p>
  		</div>
	</div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


<form method="post" action="Search_PDF.php" target="_blank">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      
        
      
         <!-- SELECT2 EXAMPLE -->
        <div class="card card-default" style="margin-top:-30px;">
          
          <!-- /.card-header -->
        
          
          
          <div class="card-body" style="margin-bottom:-30px;margin-top:-5px;">
            <div class="row">
            
            
            <div class="col-md-2">
            </div>
            
		<div class="col-md-4">
		 <div class="form-group">
                  <label>Student USN </label>
                 
                   <input type="text" class="form-control input"  id="St_usn" name="St_usn" placeholder="Enter the USN" required>
                                      
                 </div>
                 <!-- /.form-group -->
		</div>
		
		
		
		<div class="col-md-3">
		  <div class="form-group">
                   <center><label>View Report</label></center>
                  <button type="submit" id="dwn" class="btn btn-primary float-right" style="margin-right: 5px;">
                   <i class="fas fa-file-pdf"></i> Download As PDF
                  </button>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		
		
	
               

              <!-- /.col -->
            </div>
            <!-- /.row -->
         
          </div>
          <!-- /.card-body -->
         </div>
         
        
        
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
 
  








<section class="content">
      <div class="container-fluid"  id="TBY">
        
       
       
       
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
     </form>
 </div>
  <!-- /.content-wrapper -->














  
<script>
// Get the modal
var modal = document.getElementById("myModal");
// Get the button that opens the modal
//var btn = document.getElementById("myBtn");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks the button, open the modal 
<?php  
	if($C_msg!="")
	{
		echo "modal.style.display = 'block';";
	}
	else
	{
		echo "modal.style.display = 'none';";
	}
?>
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>




<?php require('../Head/Foot.php');   ?>

<script>




</script>

