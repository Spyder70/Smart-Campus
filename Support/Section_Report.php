<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
//require("../Authenticate/Support.php");
require_once('../PrintPDF/tcpdf_include.php');

//$Course_Registration_Head="menu-open";
//$Add_Subjects="active";

$PageName="Section Wise Student Details";
$AReport_Head="menu-open";
$Sec_Rep="active";
$Faculty_ID=$_SESSION['F_ID'];


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


<form method="post" action="Section_PDF.php" target="_blank">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      
        
      
         <!-- SELECT2 EXAMPLE -->
        <div class="card card-default" style="margin-top:-30px;">
          
          <!-- /.card-header -->
        
          
          
          <div class="card-body" style="margin-bottom:-30px;margin-top:-5px;">
            <div class="row">
            
            
		<div class="col-md-2">
		 <div class="form-group">
                  <label>Course Date</label>
                 
                   <select class="form-control select2"  id="C_Date" name="C_Date"  required>
                   
                    <option selected="selected"></option>
                     <?php 
                    	
                    	$sql ="SELECT Course_Date FROM Course_Subjects  Group By Course_Date order by Course_Date desc  ";
    			$query= $dbh -> prepare($sql);
    			$query-> execute();
    			$results2=$query->fetchAll(PDO::FETCH_OBJ);
    			foreach($results2 as $result2)
    			{  ?>
    			<option value="<?php echo $result2->Course_Date;?>"> <?php echo $result2->Course_Date;?> </option>
    			<?php 
    			}  ?>
                  
                  </select>
                 </div>
                 <!-- /.form-group -->
		</div>
		
		
		<div class="col-md-2">
		  <div class="form-group">
                   <label>Branch</label>
                   <select class="form-control select2"  id="Branch" name="Branch"  required>
                   <option value=''></option>
                   <option value="CHE"> CHE </option>
    		   <option value="PHY"> PHY </option>
                    <?php 
                    	
                    	$sql ="SELECT Short_Name,Dept_id FROM Department order by Short_Name ";
    			$query= $dbh -> prepare($sql);
    			$query-> execute();
    			$results2=$query->fetchAll(PDO::FETCH_OBJ);
    			foreach($results2 as $result2)
    			{  ?>
    			<option value="<?php echo $result2->Short_Name;?>"> <?php echo $result2->Short_Name;?> </option>
    			<?php 
    			}  ?>
    			
                  
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		<div class="col-md-2">
		  <div class="form-group">
                   <label>Sem</label>
                   <select class="form-control select2"  id="Sem" name="Sem"  required>
                   <option value=''></option>
                   <?php
                   for($i=1;$i<=8;$i++)
                   {
                   echo "<option value='$i'>$i</option>";
                   }
                    ?>
                    
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		<div class="col-md-2">
		  <div class="form-group">
                   <label>Section</label>
                   <select class="form-control select2"  id="Section" name="Section"  required>
                   <option value=''></option>
                  <option value='A'>A</option>
                  <option value='B'>B</option>
                  <option value='C'>C</option>
                  <option value='D'>D</option>
                    
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		
		<div class="col-md-3">
		  <div class="form-group">
                   <center><label>Report</label></center>
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

