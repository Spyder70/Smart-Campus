<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Faculty.php");


//$Course_Registration_Head="menu-open";
//$Add_Subjects="active";

$PageName="Delete Students Attendance";
$Entry_Head="menu-open";
$DeleteAttendance="active";
$Faculty_ID=$_SESSION['F_ID'];


$C_msg="";

if($_POST)
{
$Hand_Id=$_POST['delid'];

$sqlb ="SELECT * FROM Subject_Handled where Handle_ID='$Hand_Id' ";
$queryb= $dbh -> prepare($sqlb);
$queryb-> execute();
$rowb = $queryb->fetch();
$FS_ID=$rowb['FS_ID'];
$A_Date=$rowb['Att_Date'];
$Period=$rowb['Period'];
$L_Batch=$rowb['LBatch'];
$Sub_ID=$rowb['Sub_ID'];
$C_Date=$rowb['Course_Date'];

$sqla ="SELECT Section FROM Faculty_Subjects where FS_ID='$FS_ID' ";
$querya= $dbh -> prepare($sqla);
$querya-> execute();
$rowa = $querya->fetch();
$Section=$rowa['Section'];


// delete from Attendance
 $sql1="delete from Student_Attendance where FS_ID='$FS_ID' and Att_Date='$A_Date' and Period='$Period' and LBatch='$L_Batch'";
 $query1 = $dbh->prepare($sql1);
 $query1->execute();

 $sql2="delete from Subject_Handled where FS_ID='$FS_ID' and Att_Date='$A_Date' and Period='$Period' and LBatch='$L_Batch'";
 $query2 = $dbh->prepare($sql2);
 $query2->execute();

 include("TotalAttendance.php");

 $C_msg=" $A_Date Period:$Period is deleted..";
}






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


		<div class="col-md-7">
		  <div class="form-group">
                   <label>Choose Subject</label>

                   <select class="form-control select2"  id="Subject" name="Subject"  required>
                    <option selected="selected"></option>

                  </select>
                  </div>
              
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

function FadeAll(){
 $(".se-pre-con").fadeIn();;
};








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

});



$("#Subject").change(function()
{
    var val = $("#C_Date").val();
    var FS_ID = $("#Subject").val();
    var Exam_Type = $("#Exam_Type").val();
    //var Range = $("#Range").val();
    var val2="ShowList";
    if( FS_ID!="" && Exam_Type!=""  && val!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/DeleteAtt.php',
	data: {C_Date:val,FS_ID:FS_ID,Exam_Type:Exam_Type,Fetch:val2},
	success:function(data)
		{

		 $("#TBY").html(data);

		 }
	    });
     }
     else
     {
      //Clr_F();
       $("#TBY").html("")
     }
});

</script>
