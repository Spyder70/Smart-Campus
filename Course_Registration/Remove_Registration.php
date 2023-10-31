<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Admin.php");


$Course_Registration_Head="menu-open";
$Remove_CRegistration="active";

$PageName="USN Based Course Un-Resgistration";
//$L_Department="active";



$C_msg="";


if($_POST)
{

$Course_Date=$_POST['C_Date'];
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
$NT_Exist_USN="";  // usn exist in coursereg
$Err_USN="";    // Error in insert to coursereg
$SbCode_NF="";  // Subjectcode not found
$USN_NF="";     // Usn not found

$BCSV="TempStudR.csv";
move_uploaded_file($BCSV_tmp,$BCSV);
chmod("TempStudR.csv",0777);

// SET GLOBAL local_infile=1;  in mysql terminal


 $headr=0;
 $insr=0;
 $noinsr=0;
 if ($Exam_Type=="Regular" and $Subject_Type=="Core")
 {
 
    $affectedRows=$dbh->exec
    (
	"LOAD DATA LOCAL INFILE 'TempStudR.csv'
         INTO TABLE `TempCoreRegStud` FIELDS TERMINATED BY ','
         LINES TERMINATED BY '\\n' IGNORE 1 LINES (USN,Sem)"
    );



     $tmps="Select * from TempCoreRegStud";
     $tmps_query= $dbh -> prepare($tmps);
     $tmps_query-> execute();
     $tmp_res=$tmps_query->fetchAll(PDO::FETCH_OBJ);
     
 
     foreach($tmp_res as $trow)
     {
	
 		//take  usn/roll,sem
 	 	$B_USN=trim($trow->USN);
 	 	$B_Sem=trim($trow->Sem);
 		
 		$sid_sql="Select Student_ID,Cycle,Program from Student_Info where C_USN='$B_USN'";
		$sid_query= $dbh -> prepare($sid_sql);
		$sid_query-> execute();
		$row = $sid_query->fetch();
		$count = $sid_query->rowCount();
		if($count==0)
		{
		  $USN_NF=$USN_NF.$B_USN."\n"; 
		  continue;
		}
		$B_Student_ID=$row['Student_ID'];
		$B_Cycle=$row['Cycle'];
		$B_Program=$row['Program'];
		
		
		$sql1="Select Course_Type  from Department where Short_Name='$B_Program'";
		$query1 = $dbh->prepare($sql1);
		$query1->execute();
		$row2= $query1->fetch();
		$C_Type=$row2['Course_Type'];
		if($C_Type=='UG' and $B_Sem<=2){
			$F_Branch=$B_Cycle;}
		else{
			$F_Branch=$B_Program;}
		
		$sid_sql="Select CS.Sub_ID,CS.Subject_Code from Course_Subjects as CS where Exists
		(Select CR.Sub_ID from Course_Registration  as CR  where CR.Student_ID='$B_Student_ID' and CR.Sub_ID=CS.Sub_ID) and 
		CS.Course_Date='$Course_Date' and CS.Exam_Type='$Exam_Type' and 
		CS.Subject_Type='$Subject_Type' and CS.Branch='$F_Branch' and CS.Sem='$B_Sem'";
		$sid_query= $dbh -> prepare($sid_sql);
		$sid_query-> execute();
		
		$count = $sid_query->rowCount();
		if($count==0)
		{
		  $NT_Exist_USN=$NT_Exist_USN.$B_USN."\n"; 
		  continue;
		}
		else
		{
			$insr=$insr+1;
			$Fresult=$sid_query->fetchAll(PDO::FETCH_OBJ);
			foreach($Fresult as $Fres)
			{
		  		$F_Sub_ID=$Fres->Sub_ID;
		  		$F_SubCode=$Fres->Subject_Code;
		  		$sql="delete from Course_Registration where Sub_ID='$F_Sub_ID' and Student_ID='$B_Student_ID'";
 		  		$query = $dbh->prepare($sql);	
		  		$query->execute();
		  		$count1 = $query->rowCount();
		  		if($count1==0)
		  		{
		    			$noinsr=$noinsr+1;
		    			$Err_USN=$Err_USN.$B_USN."-".$F_SubCode."\n";
		  		}
		  		
		    	}
		}
	$headr=$headr+1;			
     	}//For Ends
 }
 else
 {
    $affectedRows=$dbh->exec
    (
	"LOAD DATA LOCAL INFILE 'TempStudR.csv'
         INTO TABLE `TempEleRegStud` FIELDS TERMINATED BY ','
         LINES TERMINATED BY '\\n' IGNORE 1 LINES (USN,Subject_Code,Sub_Name)"
    );

     $tmps="Select * from TempEleRegStud";
     $tmps_query= $dbh -> prepare($tmps);
     $tmps_query-> execute();
     $tmp_res=$tmps_query->fetchAll(PDO::FETCH_OBJ);
     foreach($tmp_res as $trow)
     {
 		
 	 	$B_USN=trim($trow->USN);
 		$B_SCode=trim($trow->Sub_Code);
 		$B_SName=trim($trow->Sub_Name);
 		
 		$sid_sql="SELECT Sub_ID from Course_Subjects where 
 		Course_Date='$Course_Date' and Subject_Code='$B_SCode' and Subject_Type='$Subject_Type' and Subject_Name='$B_SName'";
		$sid_query= $dbh -> prepare($sid_sql);
		$sid_query-> execute();
		$row = $sid_query->fetch();
		$B_Sub_ID=$row['Sub_ID'];
		$count = $sid_query->rowCount();
		if($count==0)
		{
		  $SbCode_NF=$SbCode_NF.$B_SCode."\n"; 
		  continue;
		}
		
		
		$sid_sql="Select Student_ID from Student_Info where C_USN='$B_USN'";
		$sid_query= $dbh -> prepare($sid_sql);
		$sid_query-> execute();
		$row = $sid_query->fetch();
		$B_Student_ID=$row['Student_ID'];
		$count = $sid_query->rowCount();
		if($count==0)
		{
		  $USN_NF=$USN_NF.$B_USN."\n"; 
		  continue;
		}
		
		
		$sql1="select CourseReg_ID from Course_Registration where 
		Student_ID='$B_Student_ID' and Sub_ID='$B_Sub_ID'";
		$query1 = $dbh->prepare($sql1);	
		$query1->execute();
		$count = $query1->rowCount();
 		
 		if($count!=0)
 		{
 		  $sql="delete from Course_Registration where Sub_ID='$B_Sub_ID' and Student_ID='$B_Student_ID'";
 		  $query = $dbh->prepare($sql);	
		  $query->execute();
		  $count1 = $query->rowCount();
		  if($count1==0)
		  {
		    $noinsr=$noinsr+1;
		    $Err_USN=$Err_USN.$B_USN."-".$B_SCode."\n";
		  }
		  else
		    $insr=$insr+1;
 		}
 		else
 		{
 		//Not  Exist
 		$NT_Exist_USN=$NT_Exist_USN.$B_USN."-".$B_SCode."\n";
 		}
 	$headr=$headr+1;
 	}//For Ends
 }//else Ends
                                    // Log File Generation
if($NT_Exist_USN!="" or $Err_USN!="" or $SbCode_NF!="" or $USN_NF!="")
{
$_SESSION["NT_Exist_USN"]=$NT_Exist_USN;
$_SESSION["Err_USN"]=$Err_USN;
$_SESSION["SbCode_NF"]=$SbCode_NF;
$_SESSION["USN_NF"]=$USN_NF;
$C_msg="Got Some Error..! <br>Check the Log File<br> <a href='Download/Remove_Log.php'>Click Here :(</a> ";
}
else 
{
  $C_msg=" $headr Rows Successfully Executed.. :)";
}
}//Submit End*/
} //if its csv Ends
else 
{
$C_msg="Please Upload <br>Proper CSV File..!$ext";
}

$tmps="delete from TempCoreRegStud where 1";
     $tmps_query= $dbh -> prepare($tmps);
     $tmps_query-> execute();
     
$tmps="delete from TempEleRegStud where 1";
     $tmps_query= $dbh -> prepare($tmps);
     $tmps_query-> execute();

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
      
        <form method="post" id="myform" action="Remove_Registration.php" enctype="multipart/form-data">
      
         <!-- SELECT2 EXAMPLE -->
        <div class="card card-default" style="margin-top:-25px;">
          
          <!-- /.card-header -->
        
          
          
          <div class="card-body" >
            <div class="row">
            
            
		<div class="col-md-2">
		 <div class="form-group">
                  <label>Course Date</label>
                 
                     <select class="form-control select2 float-right"  id="C_Date" name="C_Date"  required>
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
                 <!-- /.form-group -->
		</div>
		
		
		
		<div class="col-md-2">
		  <div class="form-group">
                   <label>Exam Type</label>
                   <select class="form-control select2"  id="Exam_Type" name="Exam_Type"  required>
                  
                    <option selected="selected"></option>
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
                  
                    <option selected="selected"></option>
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
                        <label class="custom-file-label" id="Choose_csv">Choose file</label>
                      </div>
                      
                    </div>
               </div>
               </div>
               
               
		<div class="col-md-2" style="text-align:center" id="core_csv">
		 <div class="form-group">
                  <label>Sample CSV File</label>
                 
                   <a href="Download/Download.php" target="_blank">Download File</a>
                 </div>
                 <!-- /.form-group -->
		</div>
		
		<div class="col-md-2" style="text-align:center" id="other_csv">
		 <div class="form-group">
                  <label>Sample CSV File</label>
                   <a href="Download/Download2.php" target="_blank">Download File</a>
                 </div>
                 <!-- /.form-group -->
		</div>
		
		
              <!-- /.col -->
            </div>
            <!-- /.row -->
             <div class="card-footer">
          
        	
	   
	   <center><button type="submit" name="D_Submit" id="D_Submit" class="btn  btn-outline-success btn-lg ">
	   Un-Register Uploaded USN</button></center>
	   	
		
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



    
 


//Onchange of Course Date...Show Exam Types on that date
$("#C_Date").change(function () 
{
     var C_Date = $("#C_Date").val();
     var Role="Fetch_Exam";
     
     if(C_Date!="")
     {
      $.ajax({
	type: 'POST',
	url: 'Ajax/USN_Based/Fetch_Data.php',
	data: {C_Date:C_Date,Role:Role},
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
});


$("#other_csv").hide();

$("#Exam_Type").change(function () 
{
     var C_Date = $("#C_Date").val();
     var Exam_Type = $("#Exam_Type").val();
     var Subject_Type = $("#Subject_Type").val();
     var Role="Fetch_SType";
     if(Subject_Type=="Core" && Exam_Type =="Regular")
     {
      // show USN CSV       label 
      $("#Choose_csv").html("Choose USN,SEM File");
      $("#other_csv").hide();
      $("#core_csv").show();
       
     }
     else if(Subject_Type!="" && Exam_Type !="")
     {
      // show Subcode,Usn csv       label
       $("#Choose_csv").text("Choose  USN,Sub_Code File");
       $("#core_csv").hide();
       $("#other_csv").show();
       
     }
     if(Exam_Type!="")
     {
      $.ajax({
	type: 'POST',
	url: 'Ajax/USN_Based/Fetch_Data.php',
	data: {C_Date:C_Date,Exam_Type:Exam_Type,Role:Role},
	success:function(data)
		{
		$("#Subject_Type").html(data);
		
		}
	    });
      }
      else
      {
      $("#Subject_Type").html("");
      }
});


$("#Subject_Type").change(function () 
{
     var C_Date = $("#C_Date").val();
     var Exam_Type = $("#Exam_Type").val();
     var Subject_Type = $("#Subject_Type").val();
     var Role="Fetch_Subject";
     
     if(Subject_Type=="Core" && Exam_Type =="Regular")
     {
        //show USN CSV label
        $("#Choose_csv").text("Choose USN,SEM File");
        $("#other_csv").hide();
        $("#core_csv").show();
     }
     else if(Subject_Type!="")
     {
       // show Subcode,Usn csv   label
       $("#Choose_csv").text("USN,Sub_Code,Sub_Name File");
       $("#core_csv").hide();
       $("#other_csv").show();
       
      $.ajax({
	type: 'POST',
	url: 'Ajax/USN_Based/Fetch_Data.php',
	data: {C_Date:C_Date,Exam_Type:Exam_Type,Subject_Type:Subject_Type,Role:Role},
	success:function(data)
		{
		$("#Subject_Name").html(data);
		}
	    });
      
     }
});
</script>

