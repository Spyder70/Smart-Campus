<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Faculty.php");


//$Course_Registration_Head="menu-open";
//$Add_Subjects="active";

$PageName="Students Attendance Percentage-wise Report 	";
$Report_Head="menu-open";
$Attendance_Percent="active";
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


<form method="post" action="#">

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

                    	$sql ="SELECT Course_Date FROM Faculty_Subjects where
                    	Faculty_ID='$Faculty_ID' Group By Course_Date order by Course_Date desc  ";
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
                   <label>Exam Type</label>
                   <select class="form-control select2"  id="Exam_Type" name="Exam_Type"  required>

                    <option value="" selected="selected"></option>


                  </select>
                  </div>
                <!-- /.form-group -->
		</div>


		<div class="col-md-6">
		  <div class="form-group">
                   <label>Choose Subject</label>

                   <select class="form-control select2"  id="Subject" name="Subject"  required>
                    <option selected="selected"></option>

                  </select>
                  </div>
                <!-- /.form-group -->
		</div>




		<div class="col-md-2">
		  <div class="form-group">
                   <label>Range(%)</label>
                   <select class="form-control select2"  id="Range" name="Range"  required>

                    <option value="" selected="selected"></option>
                    <option value="All">0-100</option>	<option value="85">85-100</option>	<option value="84.99"><85</option>


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
      <div class="container-fluid"  id="LoadImg">
      <center><img src="../images/loading.gif"></center>

      </div><!-- /.container-fluid -->
</section>







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


$("#LoadImg").hide();








$("#C_Date").change(function()
{

    var val = $("#C_Date").val();
    var val2="Exam_Type";
    if(val!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Data_Att_Fetch.php',
	data: {C_Date:val,Fetch:val2},
	success:function(data)
		{
		$("#Exam_Type").html(data);
		}
	    });
     }
     else
     {
      $("#Exam_Type").html("");
     }
     $("#Subject").html("");
     $("#Range").val("").change();

});



$("#Exam_Type").change(function()
{

    var val = $("#C_Date").val();
    var Exam_Type = $("#Exam_Type").val();
    var val2="Subjects";
    if(Exam_Type!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Data_Att_Fetch.php',
	data: {C_Date:val,Exam_Type:Exam_Type,Fetch:val2},
	success:function(data)
		{
		$("#Subject").html(data);
		}
	    });
     }
     else
     {
      $("#Subject").html("");
     }
     $("#Range").val("").change();
});





$("#Subject").change(function()
{
    var val = $("#C_Date").val();
    var FS_ID = $("#Subject").val();
    var Exam_Type = $("#Exam_Type").val();
    $("#Range").val("").change();
    $("#TBY").html("")
});



$("#Range").change(function()
{
    var val = $("#C_Date").val();
    var FS_ID = $("#Subject").val();
    var Exam_Type = $("#Exam_Type").val();
    var Range = $("#Range").val();
    var val2="ShowList";
    if(Range!="" && FS_ID!="" && Exam_Type!=""  && val!="")
    {
    $("#LoadImg").show();
    $.ajax({
	type: 'POST',
	url: 'Ajax/AttPercent_Report.php',
	data: {C_Date:val,FS_ID:FS_ID,Exam_Type:Exam_Type,Range:Range,Fetch:val2},
	success:function(data)
		{
		 $("#LoadImg").hide();
		 $("#TBY").html(data);

		 }
	    });
     }
     else
     {
       $("#LoadImg").hide();
      //Clr_F();
       $("#TBY").html("")
     }
});

</script>
