<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Faculty.php");
require_once('../PrintPDF/tcpdf_include.php');

//$Course_Registration_Head="menu-open";
//$Add_Subjects="active";

$PageName="MIS Report of Faculties";
$Report_Head="menu-open";
$MIS_Rep="active";
$Faculty_ID=$_SESSION['F_ID'];

if ((strpos($_SESSION['F_Desig'], "HEAD") == false) && (strpos($_SESSION['F_Desig'], "HOD") == false) &&  (strpos($_SESSION['F_Desig'], "COORDINATOR") == flase) )
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


<form method="post" action="MIS.php" target="_blank">

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
  <div class="container-fluid">
       <div class="row" id="TBY">
          
          
        
          
          
      
         
          
          
        </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section><!-- /.content -->



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


$("#C_Date").change(function() 
{
    
    var val = $("#C_Date").val();
    var val2="Fac";
    if(val!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/FL_List.php',
	data: {C_Date:val,Fetch:val2},
	success:function(data)
		{
		$("#TBY").html(data);
		}
	    });  
     }
     else
     {
      $("#TBY").html("");
     }
     
});

</script>

