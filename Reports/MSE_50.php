<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/DataEntry.php");
require_once('../PrintPDF/tcpdf_include.php');

//$Course_Registration_Head="menu-open";
//$Add_Subjects="active";

$PageName="MSE Less Than 50%";
$AReport_Head="menu-open";
$MSE_50="active";
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


<form method="post" action="MSE_PDF.php" target="_blank">

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
                   <!--<option value="CHE"> CHE </option>
    		   <option value="PHY"> PHY </option>-->
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
                   for($i=1;$i<=10;$i++)
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
                   <label>MSE</label>
                   <select class="form-control select2"  id="MSE" name="MSE"  required>
                   <option value=''></option>
                   <option value='MSE_1'>MSE_1</option>
                   <option value='MSE_2'>MSE_2</option>
                   <option value='MSE_3'>MSE_3</option> 
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
       <div class="row" id="Sub_Table">









        </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section><!-- /.content -->

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


function GetAll()
{
    var C_Date = $("#C_Date").val();
    var Sem = $("#Sem").val();
    var Branch = $("#Branch").val();
    var MSE = $("#MSE").val();
    var val2="DispAll";
    if(C_Date!="" && Sem!="" && Branch!="" && MSE!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Show_MSE50.php',
	data: {C_Date:C_Date,Sem:Sem,Branch:Branch,MSE:MSE,Fetch:val2},
	success:function(data)
		{
		$("#Sub_Table").html("");
		$("#Sub_Table").html(data);
		}
	    });
     }
     else
     {
      $("#Sub_Table").html("");
     }
}


$("#C_Date").change(function()
{
  GetAll();
});




$("#Sem").change(function()
{
  GetAll();
});


$("#Branch").change(function()
{
 GetAll();
});

$("#MSE").change(function()
{
 GetAll();
});



/*
$("#Exam_Type").change(function()
{
    var val = $("#C_Date").val();
    var Exam_Type = $("#Exam_Type").val();
    var val2="Sem";
    if(val!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Show_Registered.php',
	data: {C_Date:val,Exam_Type:Exam_Type,Fetch:val2},
	success:function(data)
		{
		Clr_F();
		$("#Sub_Table").html("");
		$("#Sem").html(data);
		}
	    });
     }
     else
     {
      Clr_F();
      $("#Sem").html("");
      $("#Sub_Table").html("");
     }
});

*/
</script>
