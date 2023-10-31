<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Admin.php");
//$Link_ACompany="active";
//$Link_CHead="menu-open";

$Faculty_Head="menu-open";
$PageName="Faculty Members";
$L_Faculty="active";


$C_msg="";

$GName="";
$GEmail="";
$GPhone="";
$Faculty_Gid="";

if($_POST)
{
$F_ID=$_POST['F_ID'];
$Name=$_POST['Name'];
$Designation=$_POST['Designation'];
$Department=$_POST['Department'];
$Email=$_POST['Email'];
$Phone=$_POST['Phone'];
$Role=$_POST['Role'];

$Password=$F_ID;
$Forgot_Key="";
if(isset($_POST['F_Submit']))
{
	$sql2="insert into Faculty(Faculty_ID,Name,Designation,Department,Email,Phone,Password,Role,Forgot_Key)
        values(:Faculty_ID,:Name,:Designation,:Department,:Email,:Phone,:Password,:Role,:Forgot_Key)";

	$query2 = $dbh->prepare($sql2);

	$query2->bindParam(':Faculty_ID',$F_ID);
	$query2->bindParam(':Name',$Name);
	$query2->bindParam(':Designation',$Designation);
	$query2->bindParam(':Department',$Department);
	$query2->bindParam(':Email',$Email);
	$query2->bindParam(':Phone',$Phone);
	$query2->bindParam(':Password',$Password);
	$query2->bindParam(':Role',$Role);
	$query2->bindParam(':Forgot_Key',$Forgot_Key);

	$query2->execute();
	if( $query2 )
	  $C_msg=$Name." is Added Successfully";
	else
	  $C_msg="Error with Insertion";
}//Insert End


if(isset($_POST['F_Update']))
{
	// Update it
	$EF_ID=$_POST['EF_ID']; // For Update

	$sql2="update Faculty set
	Name=:Name,
	Department=:Department,
	Designation=:Designation,
	Email=:Email,
	Phone=:Phone,
	Role=:Role  where  Faculty_ID=:Faculty_ID2";


	$query2 = $dbh->prepare($sql2);

	//$query2->bindParam(':Faculty_ID',$Faculty_ID);
	$query2->bindParam(':Name',$Name);
	$query2->bindParam(':Department',$Department);
	$query2->bindParam(':Designation',$Designation);
	$query2->bindParam(':Email',$Email);
	$query2->bindParam(':Phone',$Phone);
	$query2->bindParam(':Role',$Role);
	$query2->bindParam(':Faculty_ID2',$EF_ID);

	$query2->execute();

	if( $query2 )
	  $C_msg=$Name."'s Details Updated Successfull";
	else
	  $C_msg="Error with Insertion";
}//Update Info End

//Delete Fauculty Info
if(isset($_POST['F_Delete']))
{
	// Update it
	$EF_ID=$_POST['EF_ID']; // For Update

	$sql2="Delete from Faculty where Faculty_ID=:Faculty_ID2";


	$query2 = $dbh->prepare($sql2);

	//$query2->bindParam(':Faculty_ID',$Faculty_ID);
	$query2->bindParam(':Faculty_ID2',$EF_ID);

	$query2->execute();

	if( $query2 )
	  $C_msg=$Name."'s Details Deleted Successfull";
	else
	  $C_msg="Error with Insertion";
}//Delete Fauculty Info End


$EF_ID=$_POST['EF_ID'];
if(isset($_POST['F_UpdatePWD']) and strcmp($EF_ID,"ADMIN"))
{

	$sql2="update Faculty set Password=:Faculty_ID2  where  Faculty_ID=:Faculty_ID2";

	$query2 = $dbh->prepare($sql2);
	//$query2->bindParam(':Faculty_ID',$Faculty_ID);

	$query2->bindParam(':Faculty_ID2',$EF_ID);

	$query2->execute();

	if( $query2 )
	  $C_msg=$Name."'s Password Changed to UserID Successfully";
	else
	  $C_msg="Error with Update";
}//Update Password End


}// POST End



if($_GET)
{
//Fetch and Display
    $Faculty_Gid=$_GET['F_ID'];
    $sql ="SELECT * FROM Faculty where  Faculty_ID=:Faculty_Gid1";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':Faculty_Gid1', $Faculty_Gid);
    $query-> execute();
    $results2=$query->fetchAll(PDO::FETCH_OBJ);
    foreach($results2 as $result2)
    {
    	$GName=$result2->Name;
	$GDesignation=$result2->Designation;
	$GDepartment=$result2->Department;
	$GEmail=$result2->Email;
	$GPhone=$result2->Phone;
	$GRole=$result2->Role;

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

        <form method="post" action="Faculty.php">

         <!-- SELECT2 EXAMPLE -->
        <div class="card card-default" style="margin-top:-25px;">

          <!-- /.card-header -->



          <div class="card-body" >
            <div class="row">






		<!--
		<div class="col-md-2">
		  <div class="form-group">
                   <label>Course Type</label>
                   <input type="hidden" value="<?php echo $Faculty_Gid; ?>" name="Dept_id" id="Dept_id">
                   <select class="form-control select2"  id="Course_Type" name="Course_Type"  required>
                   <?php if(isset($Course_GType)){ ?>
                             <option value="<?php echo $Course_GType; ?>" selected"><?php echo $Course_GType; ?></option>
                   <?php } else { ?>
                    <option selected="selected"></option>
                    <?php } ?>
                    <option value="UG">UG</option>
                    <option value="PG">PG</option>

                  </select>
                  </div>

		</div>
		<!-- /.form-group -->

<?php
include ('../Checklog.php');
$fname=$_SESSION['F_Name'];
$frole=$_SESSION['F_Role'];
 ?>

		<div class="col-md-2">
		 <div class="form-group">
                  <label>Employee ID</label>
                    <input type="hidden" value="<?php echo $Faculty_Gid; ?>" name="EF_ID" id="EF_ID">
                    <input  type="text" class="form-control input" style="width:100%;" value="<?php echo $Faculty_Gid; ?>"
                   name="F_ID" id="F_ID"  <?php if(isset($GDesignation)){ echo "readonly"; }?> required />
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-3">
		 <div class="form-group">
                  <label>Faculty Name</label>

                   <input  type="text" class="form-control input" style="width:100%;" value="<?php echo $GName; ?>"
                   name="Name" id="Name" required />
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-4">
		  <div class="form-group">
                   <label>Designation</label>
                   <select class="form-control select2"  id="Designation" name="Designation"  required>
                   <?php if(isset($GDesignation)){ ?>
                             <option value="<?php echo $GDesignation; ?>" selected"><?php echo $GDesignation; ?></option>
                   <?php } else { ?>
                    <option selected="selected"></option>
                    <?php } ?>
                    <option value="PRINCIPAL">PRINCIPAL</option>
                    <option value="VICE PRINCIPAL/HOD">VICE PRINCIPAL/HOD</option>
                    <option value="PROFESSOR">PROFESSOR</option>
                    <option value="ASSOCIATE PROFESSOR/HEAD">ASSOCIATE PROFESSOR/HEAD</option>
                    <option value="TEACHING ASSISTANT">TEACHING ASSISTANT</option>
                    <option value="ASSISTANT PROFESSOR">ASSISTANT PROFESSOR</option>
                    <option value="ASSOCIATE PROFESSOR">ASSOCIATE PROFESSOR</option>
                    <option value="DIRECTOR & PROFESSOR">DIRECTOR & PROFESSOR</option>
                    <option value="IT ASSISTANT">IT ASSISTANT</option>
                    <option value="OFFICE ASSISTANT">OFFICE ASSISTANT</option>
                    <option value="OFFICE EXCECUTIVE">OFFICE EXCECUTIVE</option>
                    <option value="WORKSHOP ASSISTANT">WORKSHOP ASSISTANT</option>
                    <option value="ATTENDER">ATTENDER</option>
                    <option value="JUNIOR LIBRARIAN">JUNIOR LIBRARIAN</option>
                    <option value="OTHER">OTHER</option>
                  </select>
                  </div>
                <!-- /.form-group -->
		</div>


		<div class="col-md-3">
		  <div class="form-group">
                   <label>Department</label>
                   <select class="form-control select2"  id="Department" name="Department"  required>
                   <?php if(isset($GDepartment)){ ?>
                             <option value="<?php echo $GDepartment; ?>" selected"><?php echo $GDepartment; ?></option>
                   <?php } else { ?>
                    <option selected="selected"></option>
                    <?php } ?>
                  <option value="ADMINISTRATION">ADMINISTRATION</option>
                   <!--   <option value="CHEMISTRY">CHEMISTRY</option>
                    <option value="HUMANITIES">HUMANITIES</option>
                    <option value="MATHS">MATHS</option>
                    <option value="PHYSICS">PHYSICS</option> -->

                   <?php
                   	$sql ="SELECT DISTINCT Dept_Name FROM Department order by Dept_Name ";
    			$query= $dbh -> prepare($sql);
    			$query-> execute();
    			$results2=$query->fetchAll(PDO::FETCH_OBJ);
    			foreach($results2 as $result2)
    			{  ?>
    			<option value="<?php echo $result2->Dept_Name;?>"> <?php echo strtoupper($result2->Dept_Name);?> </option>
    			<?php
    			} ?>

                    <option value="M.C.A">M.C.A</option>
                  </select>
                  </div>
                <!-- /.form-group -->
		</div>



		<div class="col-md-4">
		 <div class="form-group">
                  <label>Faculty Email ID</label>

                   <input  type="text" class="form-control input" style="width:100%;" value="<?php echo $GEmail; ?>"
                   name="Email" id="Email" required />
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-2">
		 <div class="form-group">
                  <label>Employee Phone</label>

                   <input  type="text" class="form-control input" style="width:100%;" value="<?php echo $GPhone; ?>"
                   name="Phone" id="Phone" required />
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-2">
		  <div class="form-group">
                   <label>Role</label>
                   <select class="form-control select2"  id="Role" name="Role"  required>
                   <?php if(isset($GRole)){ ?>
                             <option value="<?php echo $GRole; ?>" selected"><?php echo $GRole; ?></option>
                   <?php } else { ?>
                    <option selected="selected"></option>
                    <?php } ?>
                    <option value="Faculty">Faculty</option>
                    <option value="Support">Support</option>
                    <option value="DataEntry">DataEntry</option>
                    <option value="Admin">Admin</option>



                  </select>
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
	    <button type="submit" name="F_Update" id="F_Update" class="btn  btn-outline-success btn-lg ">
	    Update Faculty Info</button>
	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    <button type="submit" name="F_UpdatePWD" id="F_UpdatePWD" class="btn  btn-outline-success btn-lg ">
	    RESET PASSWORD</button>
			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button type="submit" name="F_Delete" id="F_Delete" class="btn  btn-outline-danger btn-lg ">Delete Faculty Info</button>
	    </center>

		<?php
		}
		else
		{
		?>
	   <center><button type="submit" name="F_Submit" id="F_Submit" class="btn  btn-outline-success btn-lg ">
	   Add New Faculty</button> </center>

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
                <h3 class="card-title"><b>Existing Faculty Members </b></h3>
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
              				$sel = $dbh->prepare('select * from Faculty order by Role,Department asc');
    					$sel->execute();
    					$results=$sel->fetchAll(PDO::FETCH_OBJ);

              ?>

              <!--   Display  CompanyWise Registraion Count  -->



              <div class="card-body table-responsive p-0" style="height: 400px;">
                <table class="table table-head-fixed table-hover text-nowrap" id="ft">
                  <thead style="cursor: pointer;">
                    <tr>
                      <th style="width:15%">Edit</th>
                      <th style="width:15%">Role</th>
                    	<th style="width:5%">ID</th>
                      <th style="width:5%">Name</th>
                      <th style="width:5%">Designation</th>
                    	<th style="width:5%">Department</th>

                    </tr>
                  </thead>
                  <tbody>
                  	<?php
                  	foreach($results as $result)
			{
			echo "<tr>";

			?>

                      	<td><a href="Faculty.php?F_ID=<?php echo $result->Faculty_ID  ; ?>"><i class="nav-icon fas fa-edit"></i> Edit </a></td>
												<?php
												if($result->Role=="Faculty")
												{
													?>
												<td><?php echo "Course Cordinator"  ; ?></td>
											<?php }else{?>
												<td><?php echo $result->Role  ; ?></td>
											<?php }?>
                      	<td><?php echo $result->Faculty_ID  ; ?></td>
                        <td><?php echo $result->Name  ; ?></td>
  											<td><?php echo $result->Designation  ; ?></td>
  											<td><?php echo $result->Department  ; ?></td>

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
$("#F_ID").change(function ()
{
     var F_ID = $("#F_ID").val();
     var EF_ID = $("#EF_ID").val();

     if(F_ID!="")
     {
      $.ajax({
	type: 'POST',
	url: 'Ajax/Validate_FID.php',
	data: {EF_ID:EF_ID,F_ID:F_ID},
	success:function(data)
		{
		//$("#Program").html(data);
			if(data!="Success")
			{
			alert(data);
			$("#F_ID").val("");
			}
			else
			{

			}
		}
	    });
	}
});




$('th').click(function(){
    var table = $(this).parents('table').eq(0);
  //  var table = $('#ft')
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()));
    this.asc = !this.asc;
    if (!this.asc){rows = rows.reverse()}
    for (var i = 0; i < rows.length; i++){table.append(rows[i]);}
});
function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index), valB = getCellValue(b, index);
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB);
    }
}
function getCellValue(row, index){ return $(row).children('td').eq(index).text() ;}
</script>
