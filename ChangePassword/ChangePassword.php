<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");

//$Link_ACompany="active";
//$Link_CHead="menu-open";

$PageName="Change Password";
$Link_SChange="active";



$FID=$_SESSION['F_ID'];
			


if($_SESSION['F_Role']!="admin")
{
	//echo "Please Do Login First..!";
	//header("location:../Login.php");			
	//exit;
}
$C_msg="";


if($_POST)
{

$Pass1=$_POST['Pass1'];


if(isset($_POST['D_Submit']))
{
if($FID==$Pass1 or $FID==strtoupper($Pass1) or $FID=="admin")
{
$C_msg="Unable to Change Password ..! <br>Dont Use Username as your Password..";
}
else
{
$sql ="Update Faculty set Password=:Pass1 WHERE Faculty_ID=:FID ";
    	$query= $dbh -> prepare($sql);
    	$query-> bindParam(':Pass1', $Pass1, PDO::PARAM_STR);
    	$query-> bindParam(':FID', $FID, PDO::PARAM_STR);
    	if($query-> execute())
		$C_msg=" Password Updated Successfully-$FID";
	else
		$C_msg="Error with Update";
}//else
}//Submit End
}// POST End


?>



<?php require('../Head/Head.php'); ?>




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




    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      
        <form method="post" action="ChangePassword.php">
      
         <!-- SELECT2 EXAMPLE -->
        <div class="card card-default" style="margin-top:25px;">
          
          <!-- /.card-header -->
        
          
          
          <div class="card-body" >
            <div class="row">
            
            <div class="col-md-1"></div>
		
		
		<div class="col-md-5">
		 <div class="form-group">
                  <label>New Password</label>
                 
                   <input  type="password" class="form-control input" style="width:100%;" value="<?php echo $Dept_GName; ?>"
                   name="Pass1" id="Pass1" required />
                 </div>
                 <!-- /.form-group -->
		</div>
		
		
		
				
		<div class="col-md-5">
		 <div class="form-group">
                  <label>Confirm Password</label>
                 
                   <input  type="password" class="form-control input" style="width:100%;" value="<?php echo $Course_GName; ?>"
                   name="Pass2" id="Pass2"  required/>
                 </div>
                 <!-- /.form-group -->
		</div>
		
		
		
		
               
		
               

              <!-- /.col -->
            </div>
            <!-- /.row -->
             
        
          </div>
          <!-- /.card-body -->
         </div>
         
             <center><button type="submit" name="D_Submit" id="D_Submit" class="btn  btn-outline-success btn-lg " onclick="return Validate()">
	  Update The Password</button></center>
        
         </form>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
 
 
          
        	
	 
	   	
		
         









    <!-- /.content -->
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


// Validation
    function Validate() {
        var password = document.getElementById("Pass1").value;
        var confirmPassword = document.getElementById("Pass2").value;
        if (password != confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }
        return true;
    }
</script>


<?php require('../Head/Foot.php');   ?>



