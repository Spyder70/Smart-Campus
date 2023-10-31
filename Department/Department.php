<?php
session_start();
//require("connect.php");
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Admin.php");

//$Link_ACompany="active";
//$Link_CHead="menu-open";

$PageName="Department Details";
$L_Department="active";





$C_msg="";


if($_POST)
{


$Course_Type=$_POST['Course_Type'];
$Dept_Name=$_POST['Dept_Name'];
$Course_Name=$_POST['Course_Name'];
$Short_Name=$_POST['Short_Name'];



if(isset($_POST['D_Submit']))
{
$sql2="insert into Department(Course_Type,Dept_Name,Course_Name,Short_Name)
values(:Course_Type1,:Dept_Name1,:Course_Name1,:Short_Name1)";

/*
echo $title.$description.$company_name.$academic_year.$sslc.$puc.$diploma.$degree.$degree_cgpa.$cgpa.$gap_edu.$min_dob
.$max_dob.$ctc_pa.$max_activebacklog.$registration_date.$talk_date.$interview_date.$test_date.$notes.$status.$created_at.$updated_at;

*/

$query2 = $dbh->prepare($sql2);

$query2->bindParam(':Course_Type1',$Course_Type);
$query2->bindParam(':Dept_Name1',$Dept_Name);
$query2->bindParam(':Course_Name1',$Course_Name);
$query2->bindParam(':Short_Name1',$Short_Name);

$query2->execute();
if( $query2 )
$C_msg=$Dept_Name." is Added Successfully";
else
$C_msg="Error with Insertion";

}//Insert End
if(isset($_POST['D_Update']))
{

// Update it
// While Update   delete  job_postings_branches   insert again with new branch id's

$Dept_id=$_POST['Dept_id'];

$sql2="update Department set Course_Type=:Course_Type1,Dept_Name=:Dept_Name1,Course_Name=:Course_Name1,
Short_Name=:Short_Name1  where  Dept_id=:Dept_id1";


$query2 = $dbh->prepare($sql2);

$query2->bindParam(':Course_Type1',$Course_Type);
$query2->bindParam(':Dept_Name1',$Dept_Name);
$query2->bindParam(':Course_Name1',$Course_Name);
$query2->bindParam(':Short_Name1',$Short_Name);
$query2->bindParam(':Dept_id1',$Dept_id);

$query2->execute();

if( $query2 )
$C_msg="Updated was Successfull";
else
$C_msg="Error with Insertion";


}//Update End

//DeleteStarts
if(isset($_POST['D_Delete']))
{

// Delete it
// While delete  job_postings_branches   insert again with new branch id's

$Dept_id=$_POST['Dept_id'];

$sqlDelete="Delete from Department where Dept_id=:Dept_id1";


$query2 = $dbh->prepare($sqlDelete);

$query2->bindParam(':Dept_id1',$Dept_id);

$query2->execute();

if( $query2)
$C_msg="Delete was Successfull";
else
$C_msg="Error with Insertion";


}//Delete End
}// POST End
/*if (isset($_POST['D_Delete']) {
        $id = get_safe_value($conn, $_GET['id']);
        $delete_sql ="Delete from Department where Dept_id=:Dept_id1";
        mysqli_query($conn, $delete_sql);
    }*/
if($_GET)
{
//Fetch and Display
    $Dept_Gid=$_GET['D_ID'];
    $sql ="SELECT * FROM Department where  Dept_id=:Dept_Gid1";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':Dept_Gid1', $Dept_Gid);
    $query-> execute();
    $results2=$query->fetchAll(PDO::FETCH_OBJ);
    foreach($results2 as $result2)
    {
    	$Course_GType=$result2->Course_Type;
	$Dept_GName=$result2->Dept_Name;
	$Course_GName=$result2->Course_Name;
	$Short_GName=$result2->Short_Name;
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

        <form method="post" action="Department.php">

         <!-- SELECT2 EXAMPLE -->
        <div class="card card-default" style="margin-top:-25px;">

          <!-- /.card-header -->



          <div class="card-body" >
            <div class="row">







		<div class="col-md-2">
		  <div class="form-group">
                   <label>Course Type</label>
                   <input type="hidden" value="<?php echo $Dept_Gid; ?>" name="Dept_id" id="Dept_id">
                   <select class="form-control select2"  id="Course_Type" name="Course_Type"  required>
                   <?php if(isset($Course_GType)){ ?>
                             <option value="<?php echo $Course_GType; ?>" selected"><?php echo $Course_GType; ?></option>
                   <?php } else { ?>
                    <option selected="selected"></option>
                    <?php } ?>
                    <option value="UG">UG</option>
                   <!-- <option value="PG">PG</option>-->

                  </select>
                  </div>
                <!-- /.form-group -->
		</div>




		<div class="col-md-4">
		 <div class="form-group">
                  <label>Department Name</label>

                   <input  type="text" class="form-control input" style="width:100%;" value="<?php echo $Dept_GName; ?>"
                    <?php if(isset($Course_GType)){ echo " readonly "; }?>
                   name="Dept_Name" id="Dept_Name" required />
                 </div>
                 <!-- /.form-group -->
		</div>




		<div class="col-md-4">
		 <div class="form-group">
                  <label>Course Name</label>

                   <input  type="text" class="form-control input" style="width:100%;" value="<?php echo $Course_GName; ?>"
                   name="Course_Name" id="Course_Name"  required/>
                 </div>
                 <!-- /.form-group -->
		</div>



		<div class="col-md-2">
		 <div class="form-group">
                  <label>Course ShortName</label>
                   <input type="hidden" name="EShort_Name" id="EShort_Name" value="<?php echo $Short_GName; ?>" />
                   <input  type="text" class="form-control input" style="width:100%;" value="<?php echo $Short_GName; ?>"
                    <?php if(isset($Course_GType)){ echo " readonly "; }?>
                    name="Short_Name" id="Short_Name" required />
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
	    Update Department Info</button>
      <button type="submit" name="D_Delete" id="D_Delete" class="btn  btn-outline-danger btn-lg ">Delete Department Info</button>
</center>
		<?php
		}
		else
		{
		?>
	   <center><button type="submit" name="D_Submit" id="D_Submit" class="btn  btn-outline-success btn-lg ">
	   Add New Department</button></center>

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
                <h3 class="card-title"><b>Existing Departments </b></h3>
		<!--
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                     <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>  -->
              </div>
              <!-- /.card-header -->



              <?php
              				$sel = $dbh->prepare('select * from Department order by Dept_Name asc');
    					$sel->execute();
    					$results=$sel->fetchAll(PDO::FETCH_OBJ);

              ?>

              <!--   Display  CompanyWise Registraion Count  -->



              <div class="card-body table-responsive p-0" style="height: 400px;">
                <table class="table table-head-fixed table-hover text-nowrap">
                 <thead style="cursor: pointer;">
                    <tr>
                      <th>Edit</th>
                      <th>Course Type</th>
                      <th>Department Name</th>
                      <th>Course Name</th>
                      <th>Course Short Name</th>


                    </tr>
                  </thead>
                  <tbody>
                  	<?php
                  	foreach($results as $result)
			{
			echo "<tr>";

			?>

                      	<td><a href="Department.php?D_ID=<?php echo $result->Dept_id  ; ?>"><i class="nav-icon fas fa-edit"></i> Edit </a></td>
                      	<td><?php echo $result->Course_Type  ; ?></td>

  			<td ><?php echo $result->Dept_Name  ; ?></td>
  			<td ><?php echo $result->Course_Name  ; ?></td>

  			<td><?php echo $result->Short_Name  ; ?></td>

                      	<?php
                      	echo "</tr>";
                      	}
			?>

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

$("#Short_Name").change(function ()
{
     var Short_Name = $("#Short_Name").val();
     var EShort_Name = $("#EShort_Name").val();

     if(Short_Name!="")
     {
      $.ajax({
	type: 'POST',
	url: 'Ajax/Validate_DEP.php',
	data: {Short_Name:Short_Name,EShort_Name:EShort_Name},
	success:function(data)
		{
		//$("#Program").html(data);
			if(data!="Success")
			{
			alert(data);
			$("#Short_Name").val("");
			}
			else
			{

			}
		}
	    });
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
</script>
