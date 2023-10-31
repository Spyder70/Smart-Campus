<?php
session_start();
//require("connect.php");
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Admin.php");


$Course_Registration_Head="menu-open";
$C_Subjects="active";

$PageName="Add Course Subjects";
//$L_Department="active";





$C_msg="";


if($_POST)
{

$Course_Date=$_POST['Course_Date'];
$Exam_Type=$_POST['Exam_Type'];
$Subject_Type=$_POST['Subject_Type'];
$Subject_Code=$_POST['Subject_Code'];
$Subject_Name=$_POST['Subject_Name'];
$Sem=$_POST['Sem'];
$Branch=$_POST['Branch'];
$Credit=$_POST['Credit'];

$Th_Pract=$_POST['Th_Pract'];
$Hours=$_POST['Hours'];
$Area=$_POST['Area'];
$Scheme=$_POST['Scheme'];


if(isset($_POST['D_Submit']))
{

$sql1="select Sub_ID from Course_Subjects where Course_Date='$Course_Date' and Subject_Code='$Subject_Code' and Exam_Type='$Exam_Type' and Branch='$Branch' and Subject_Name='$Subject_Name'";
$query1 = $dbh->prepare($sql1);
$query1->execute();
$count = $query1->rowCount();
if($count==0)
{

$sql2="insert into Course_Subjects (Course_Date,Exam_Type,Subject_Type,Subject_Code,Subject_Name,Sem,Branch,Credit,Th_Pract,Hours,Area,Scheme)   values('$Course_Date','$Exam_Type','$Subject_Type','$Subject_Code','$Subject_Name','$Sem','$Branch','$Credit','$Th_Pract','$Hours','$Area','$Scheme')";

    $query2 = $dbh->prepare($sql2);

    if($query2->execute())
    {
	$last_id = $dbh->lastInsertId();
	if($Subject_Type=="Core" and  $Exam_Type=="Regular")
	{
	$insr=$insr+1;
	// insert for all applicable student_id's
	/*
	if($Branch=="CHE" or $Branch=="PHY")
	{
	$sql3="insert into Course_Registration(Sub_ID,Student_ID) SELECT '$last_id' as Sub_ID,Student_ID from Student_Info
	where Sem='$Sem-1' and Cycle='$Branch' and Status='R'";
	}
	else
	{
	$sql3="insert into Course_Registration(Sub_ID,Student_ID) SELECT '$last_id' as Sub_ID,Student_ID from Student_Info
	where Sem='$Sem-1' and Program='$Branch' and Status='R'";
	}
	$query3 = $dbh->prepare($sql3);
	$query3->execute();
	*/
	}
	$C_msg="$Subject_Code - $Subject_Name is Added Successfully";
    }
    else
    {
    	$C_msg="Error with Insertion";
    }
}
else
{
    $C_msg="$Subject_Name <br> Already There in $Course_Date!";
}

}// Submit End - Insert End
if(isset($_POST['D_Update']))
{
$Sub_ID=$_POST['Sub_ID'];
// Update it
// While Update   delete  Student alloted with this id    insert again with new Same id's with compatible sem branch
$sql1="select Sub_ID from Course_Subjects where Course_Date='$Course_Date' and Subject_Code='$Subject_Code' and Exam_Type='$Exam_Type'
and Branch='$Branch' and Sub_ID!='$Sub_ID'";
$query1 = $dbh->prepare($sql1);
$query1->execute();
$count = $query1->rowCount();
if($count==0)
{


$sql2="update Course_Subjects set Course_Date='$Course_Date',Exam_Type='$Exam_Type', Subject_Type='$Subject_Type',Subject_Code='$Subject_Code', Subject_Name='$Subject_Name', Sem='$Sem', Branch='$Branch', Credit='$Credit',Th_Pract='$Th_Pract',Hours='$Hours',Area='$Area',Scheme='$Scheme'
where  Sub_ID='$Sub_ID'";


	$query2 = $dbh->prepare($sql2);
	if( $query2->execute())
		$C_msg="Updated was Successfull";
	else
		$C_msg="Error with Insertion";
}
else
{
    $C_msg="$Subject_Name <br> Already There..!";
}

}//Update End
}// POST End

if($_GET)
{
//Fetch and Display
    $GSub_ID=$_GET['GSub_ID'];
    $sql ="SELECT * FROM Course_Subjects where  Sub_ID=:GSub_ID";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':GSub_ID', $GSub_ID);
    $query-> execute();
    $results2=$query->fetchAll(PDO::FETCH_OBJ);
    foreach($results2 as $result2)
    {

    	$GCourse_Date=$result2->Course_Date;
	$GExam_Type=$result2->Exam_Type;
	$GSubject_Type=$result2->Subject_Type;
	$GSubject_Code=$result2->Subject_Code;
	$GSubject_Name=$result2->Subject_Name;
	$GSem=$result2->Sem;
	$GBranch=$result2->Branch;
	$GCredit=$result2->Credit;
	$GTh_Pract=$result2->Th_Pract;
	$GHours=$result2->Hours;
	$GArea=$result2->Area;
	$GScheme=$result2->Scheme;
    }

}
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

        <form method="post" action="Add_Course.php">

         <!-- SELECT2 EXAMPLE -->
        <div class="card card-default" style="margin-top:-25px;">

          <!-- /.card-header -->



          <div class="card-body" >
            <div class="row">


		<div class="col-md-3">
		 <div class="form-group">
                  <label>Course Date</label>

                   <input  type="date" class="form-control input" style="width:100%;" value="<?php echo $GCourse_Date; ?>"
                    <?php /* if(isset($GCourse_Date)){ echo " readonly "; }  */  ?>
                      name="Course_Date" id="Course_Date" required />
                 </div>
                 <!-- /.form-group -->
		</div>




		<div class="col-md-2">
		  <div class="form-group">
                   <label>Exam Type</label>
                   <input type="hidden" value="<?php echo $GSub_ID; ?>" name="Sub_ID" id="Sub_ID">
                   <select class="form-control select2"  id="Exam_Type" name="Exam_Type"  required>
                   <?php if(isset($GExam_Type)){ ?>
                             <option value="<?php echo $GExam_Type; ?>" selected"><?php echo $GExam_Type; ?></option>
                   <?php } else { ?>
                    <option selected="selected"></option>
                    <?php } ?>
                    <option value="Regular">Regular</option>
                    <option value="Supplementary">Supplementary</option>

                  </select>
                  </div>
                <!-- /.form-group -->
		</div>



		<div class="col-md-2">
		  <div class="form-group">
                   <label>Subject Type</label>

                   <select class="form-control select2"  id="Subject_Type" name="Subject_Type"  required>
                   <?php if(isset($GSubject_Type)){ ?>
                             <option value="<?php echo $GSubject_Type; ?>" selected"><?php echo $GSubject_Type; ?></option>
                   <?php } else { ?>
                    <option selected="selected"></option>
                    <?php } ?>
                    <option value="Core Theory">Core Theory</option>
                    <option value="Core Studios">Core Studios</option>
                    <option value="Elective Level-2">Elective Level-2</option>
                    <option value="Elective Level-3">Elective Level-3</option>
                    <option value="Elective Open">Elective Open</option>
                    <option value="Elective Global">Elective Global </option>
                    <option value="VAC">VAC</option>

                  </select>
                  </div>
                <!-- /.form-group -->
		</div>


		<div class="col-md-1">
		  <div class="form-group">
                   <label>Sem</label>

                   <select class="form-control select2"  id="Sem" name="Sem"  required>
                   <?php if(isset($GSem)){ ?>
                             <option value="<?php echo $GSem; ?>" selected"><?php echo $GSem; ?></option>
                   <?php } else { ?>
                    <option selected="selected"></option>
                    <?php } ?>
                    <option value="1">1</option> <option value="2">2</option>
                    <option value="3">3</option> <option value="4">4</option>
                    <option value="5">5</option> <option value="6">6</option>
                    <option value="7">7</option> <option value="8">8</option>
                    <option value="9">9</option> <option value="10">10</option>

                  </select>
                  </div>
                <!-- /.form-group -->
		</div>


		<div class="col-md-2">
		  <div class="form-group">
                   <label>Branch</label>

                   <select class="form-control select2"  id="Branch" name="Branch"  required>
                   <?php if(isset($GBranch)){ ?>
                             <option value="<?php echo $GBranch; ?>" selected"><?php echo $GBranch; ?></option>
                   <?php } else { ?>
                    <option selected="selected"></option>
                    <?php } ?>
                   <!-- <option value="PHY">PHY</option>
                    <option value="CHE">CHE</option> -->

                    	 <?php
                    	$sql ="SELECT Short_Name FROM Department ";
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
                   <label>Theory/Studios</label>

                   <select class="form-control select2"  id="Th_Pract" name="Th_Pract"  required>
                   <?php if(isset($GTh_Pract)){ ?>
                             <option value="<?php echo $GTh_Pract; ?>" selected"><?php echo $GTh_Pract; ?></option>
                   <?php } else { ?>
                    <option selected="selected"></option>
                    <?php } ?>
                    <option value="T">THEORY</option>
                    <option value="S">STUDIOS</option>
                  </select>
                  </div>
                <!-- /.form-group -->
		</div>



		<div class="col-md-2">
		 <div class="form-group">
                  <label>Subject Code</label>

                   <input  type="text" class="form-control input" style="width:100%;" value="<?php echo $GSubject_Code; ?>"
                    <?php /* if(isset($GSubject_Code)){ echo " readonly "; }  */ ?>
                   name="Subject_Code" id="Subject_Code" required />
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-5">
		 <div class="form-group">
                  <label>Subject Name</label>
                   <input  type="text" class="form-control input" style="width:100%;" value="<?php echo $GSubject_Name; ?>"
                    <?php /* if(isset($GSubject_Name)){ echo " readonly "; }  */ ?>
                   name="Subject_Name" id="Subject_Name" required />
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-1">
		 <div class="form-group">
                  <label>Credit</label>

                   <input  type="text" class="form-control input" style="width:100%;" value="<?php echo $GCredit; ?>"
                    <?php /*if(isset($GCredit)){ echo " readonly "; } */ ?>
                   name="Credit" id="Credit" required />
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-3">
		 <div class="form-group">
                  <label>NUMBER OF CONTACT HOURS</label>

                   <input  type="text" class="form-control input" style="width:100%;"
                    value="<?php if(isset($GHours)){ echo $GHours; }else{ echo ""; } ?>"
                   name="Hours" id="Hours" required />
                 </div>
                 <!-- /.form-group -->
		</div>



              <!-- /.col -->
            </div>
            <!-- /.row -->
             <div class="card-footer">

        	<?php
        	if($_GET)
		{
		?>
	    <center>
	    <button type="submit" name="D_Update" id="D_Update" class="btn  btn-outline-success btn-lg ">
	    Update Subject</button></center>

		<?php
		}
		else
		{
		?>
	   <center><button type="submit" name="D_Submit" id="D_Submit" class="btn  btn-outline-success btn-lg ">
	   Add Subject</button></center>

		<?php
		}
		?>
          </div>

          </div>
          <!-- /.card-body -->
         </div>



         </form>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->










<section class="content">
      <div class="container-fluid">
        <div class="row">

          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><b>Subjects Sort By Branch  </b></h3>




                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 200px;">



                     <select class="form-control select2 float-right"  id="S_CDate" name="S_CDate"  required>
                     <option selected="selected"></option>

                   <?php


                    	$sql ="SELECT Branch FROM Course_Subjects Group By Branch  Order By Branch DESC";

    			$query= $dbh -> prepare($sql);
    			$query-> execute();
    			$results2=$query->fetchAll(PDO::FETCH_OBJ);
    			foreach($results2 as $result2)
    			{  ?>
          <option value="<?php echo $result2->Branch;?>"> <?php echo $result2->Branch;?> </option>

    			<?php
    			}  ?>

                  </select>
                </div>

                  </div>

                </div>

              </div>


              <!-- /.card-header -->




              <!--   Display  CompanyWise Registraion Count  -->

              <div class="card-body table-responsive p-0" style="height: 400px;">
                <table class="table table-head-fixed table-hover text-nowrap" id="cusbs">
                 <thead style="cursor: pointer;">
                    <tr>
                      <th>Edit</th>
                      <th>Exam</th>
                      <th>Sub_Type</th>
                      <th>Th-Prac</th>
                      <th>Sub_Code</th>
                      <th>Sub_Name</th>
                      <th>Sem</th>
                      <th>Branch</th>
                      <th>Credit</th>
                      <th>Hours</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody id="TBY">


                  	<!--  Table from Ajax -->

                    </tr>

                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->

         <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
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
</script>




<?php require('../Head/Foot.php');   ?>

<script>

$("#S_CDate").change(function ()
{
     var C_Date = $("#S_CDate").val();


     if(C_Date!="")
     {
      $.ajax({
	type: 'POST',
	url: 'Ajax/Fetch_Course.php',
	data: {C_Date:C_Date},
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


$("#S_CBranch").change(function ()
{
     var C_Branch = $("#S_CBranch").val();


     if(C_Branch!="")
     {
      $.ajax({
	type: 'POST',
	url: 'Ajax/Fetch_CourseBranch.php',
	data: {C_Branch:C_Branch},
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





$('th').click(function(){
    var table = $(this).parents('table').eq(0)
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
    this.asc = !this.asc
    if (!this.asc){rows = rows.reverse()}
    for (var i = 0; i < rows.length; i++){table.append(rows[i])}
})
function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index), valB = getCellValue(b, index)
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
    }
}
function getCellValue(row, index){ return $(row).children('td').eq(index).text() }


function Dlt(st1)
{
    if (confirm('Are you Sure ..! \n All Data Linked to this Subject will be Lost'))
    {
     if(st1!="")
     {

       $.ajax({
	type: 'POST',
	url: 'Ajax/Delete_Course.php',
	data: {D_id:st1},
	success:function(data)
		{
		alert(data);
		$("#S_CDate").change();
		}
	    });
      }
    }

}
</script>
