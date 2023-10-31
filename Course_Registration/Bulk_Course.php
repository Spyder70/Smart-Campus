<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Admin.php");


$Course_Registration_Head="menu-open";
$CB_Subjects="active";

$PageName="Add Bulk Course Subjects";
//$L_Department="active";



$C_msg="";


if($_POST)
{

$Course_Date=$_POST['Course_Date'];
$Exam_Type=$_POST['Exam_Type'];
$Subject_Type=$_POST['Subject_Type'];

$BCSV=$_FILES["BCSV"]["name"];
$BCSV_tmp=$_FILES["BCSV"]["tmp_name"];
$ext=pathinfo($BCSV,PATHINFO_EXTENSION);
if($ext=="csv" or $ext=="Csv" or $ext=="CSV")
{


if(isset($_POST['D_Submit']))
{
$Err_sub="";
//$BCSV=basename($BCSV,$ext);
$BCSV=$Exam_Type."[".date('d-m-yy h-i-sa')."].csv";
move_uploaded_file($BCSV_tmp,"Upload/".$BCSV);

 if (($fp = fopen("Upload/".$BCSV, "r")) !== FALSE)
 {
 $headr=0;
 $insr=0;
 while (($csv_row = fgetcsv($fp)) !== false)
 {
 	if($headr!=0)
 	{
 	 	$B_Branch=$csv_row[0];
 		$B_Sem=$csv_row[1];
 		$B_SCode=trim($csv_row[2]);
 		$B_SName=trim($csv_row[3]);
 		$B_Credit=$csv_row[4];
 		$B_Th_Pract=$csv_row[5];
 		$B_Grade=$csv_row[6];
 		$B_Area=$csv_row[7];
 		$B_Scheme=$csv_row[8];
 		
 		$sql1="select Sub_ID from Course_Subjects where Course_Date='$Course_Date' and Subject_Code='$B_SCode' 
 		       and Exam_Type='$Exam_Type' and Branch='$B_Branch' and Subject_Name='$B_SName'";
		$query1 = $dbh->prepare($sql1);	
		$query1->execute();
		$count = $query1->rowCount();
		if($count==0)
		{
		
		$sql2="insert into Course_Subjects (Course_Date,Exam_Type,Subject_Type,Subject_Code
                      ,Subject_Name,Sem,Branch,Credit,Th_Pract,Grade,Area,Scheme)
                       values('$Course_Date','$Exam_Type','$Subject_Type','$B_SCode','$B_SName','$B_Sem','$B_Branch',
                       '$B_Credit','$B_Th_Pract','$B_Grade','$B_Area','$B_Scheme')";
           		$query2 = $dbh->prepare($sql2);	
			if($query2->execute())
			{
				$insr=$insr+1;
				$last_id = $dbh->lastInsertId();
				if($Subject_Type=="Core" and  $Exam_Type=="Regular")
				{
			// insert for all applicable student_id's 
			/*
			        if($B_Branch=="CHE" or $B_Branch="PHY"){
				$sql3="insert into Course_Registration(Sub_ID,Student_ID) SELECT '$last_id' as Sub_ID,Student_ID from Student_Info 
				where Sem='$B_Sem-1'and Cycle='$B_Branch' and Status='R'";}
				else{
				$sql3="insert into Course_Registration(Sub_ID,Student_ID) SELECT '$last_id' as Sub_ID,Student_ID from Student_Info 
				where Sem='$B_Sem-1'and Program='$B_Branch' and Status='R'";}
		
				$query3 = $dbh->prepare($sql3);	
				$query3->execute();
				*/
				}
			}
		}
		else
		{
		$Err_sub=$Err_sub.$B_SCode."<br>";
		}
 	}
 	$headr=$headr+1;
 }
  $C_msg="$insr Subject Added Successfully<br>";
  if($Err_sub!="")
  {
  $C_msg=$C_msg."Already Existing : <br>".$Err_sub;
  }
 }
 else
 {
 $C_msg="Error in Reading CSV";
 }

}//Insert End*/
}
else 
{
$C_msg="Please Upload <br>Proper CSV File..!$ext";
}

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
  margin-left:300px;
  border: 1px solid #888;
  width: 30%;
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
      
        <form id="myform"  method="post" action="Bulk_Course.php" enctype="multipart/form-data">
      
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
                    <option value="Core">Core</option>
                    <option value="Elective">Elective</option>
                    <option value="Global Elective">Global Elective</option>
                   
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		
		
		<div class="col-md-4">
		<div class="form-group">
                    <label for="BCSV">Browse File</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="BCSV" name="BCSV" required>
                        <label class="custom-file-label" for="BCSV">Choose file</label>
                      </div>
                      
                    </div>
               </div>
               </div>
               
               
		<div class="col-md-2" style="text-align:center">
		 <div class="form-group">
                  <label>Sample CSV File</label>
                 
                   <a href="Download/DownloadBC.php" target="_blank">Download File</a>
                 </div>
                 <!-- /.form-group -->
		</div>
		
		
              <!-- /.col -->
            </div>
            <!-- /.row -->
             <div class="card-footer">
	   <center><button type="submit" name="D_Submit" id="D_Submit" class="btn  btn-outline-success btn-lg ">
	   Upload Subjects</button></center>
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
                <h3 class="card-title"><b>Subjects Of Course Date  </b></h3>
		
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 200px;">
              
                   
                     <select class="form-control select2 float-right"  id="S_CDate" name="S_CDate"  required>
                     <option selected="selected"></option>
                   <?php 
                    	
                    	$sql ="SELECT Course_Date FROM Course_Subjects Group By Course_Date  Order By Course_Date DESC";
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
                </div>  
              </div>
              <!-- /.card-header -->
              
            
              
              <!--   Display  CompanyWise Registraion Count  -->
            
              <div class="card-body table-responsive p-0" style="height: 400px;">
                <table class="table table-head-fixed table-hover text-nowrap">
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
                      <th>Grade</th>
                      <th>Area</th>
                      <th>Scheme</th>
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

//Loading Gif 
$( "#myform" ).submit(function() {
 $(".se-pre-con").fadeIn();;
});

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

