<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/DataEntry.php");
//$Link_CHead="menu-open";
//$Link_ACompany="active";

$PageName="All Student Details";
$Register_Head="menu-open";
$S_Students="active";



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




    <!-- Main content -->
    <section class="content" style="margin-top:-20px;">
      <div class="container-fluid">
      
        <form method="post" action="Students.php" style="font-size:14px;">
      
       <!-- SELECT2 EXAMPLE -->
        <div class="card card-default" style="margin-top:-25px;">
          
          <!-- /.card-header -->
        
          
          
          <div class="card-body" >
            <div class="row">
            
            
	
		
		<div class="col-md-5">
		  <div class="form-group">
                   <label>Course Name <font color="red">*</font></label>
                   <select class="form-control select2" id="Dept_Name" name="Dept_Name"  required>
                    
                    	
                    	<option selected="selected"></option>
                        <option value="ALL">ALL</option>
                    	<?php
                      	$sql ="SELECT DISTINCT Dept_Name FROM Department order by Dept_Name";
    			$query= $dbh -> prepare($sql);
    			$query-> execute();
    			$results2=$query->fetchAll(PDO::FETCH_OBJ);
    			foreach($results2 as $result2)
    			{  ?>
    			<option value="<?php echo $result2->Dept_Name;?>"> <?php echo $result2->Dept_Name;?> </option>
    			<?php 
    			} ?>
    			
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		
		<div class="col-md-3	">
		  <div class="form-group">
                   <label>Program <font color="red">*</font></label>
                   
                   <select class="form-control select2"  id="Program" name="Program"  required>
                    	<option selected="selected"></option>
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		
		<div class="col-md-2">
		  <div class="form-group">
                   <label>Academic Batch <font color="red">*</font></label>
                   <select class="form-control select2" id="Batch" name="Batch"  required>
                    
                    	
                    	<option selected="selected"></option>
			<option value="ALL">ALL</option>
                    	<?php
                    	
                    	
                      	$sql ="SELECT DISTINCT Batch FROM Student_Info order by Batch desc";
    			$query= $dbh -> prepare($sql);
    			$query-> execute();
    			$results2=$query->fetchAll(PDO::FETCH_OBJ);
    			foreach($results2 as $result2)
    			{  ?>
    			<option value="<?php echo $result2->Batch;?>"> <?php echo $result2->Batch;?> </option>
    			<?php 
    			} ?>
    			
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		
		
		 <div class="col-md-2">
		  <div class="form-group">
                   <label>Sem <font color="red">*</font></label>
                   
                   <select class="form-control select2"  id="Sem" name="Sem"  required>
                    	
                   
                    	<option selected="selected"></option>
			<option value="ALL">ALL</option>
                       <?php  
                       for($i=1; $i<=10;$i++)
                       {  ?>
                       <option value="<?php echo $i ?>"><?php echo $i ?></optio	n>
                      <?php }
                       ?>
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		
<hr width="100%"
        size="20" style="margin-top:0px" color="gray"
        noshade>
		
		
		
				
		<div class="col-md-4">
		 <div class="form-group">
                  <label>Search  By :</label>
                 
                  <select class="form-control select2"  id="Search_By" name="Search_By"  required>
                  
                    	<option selected></option>
                       <option value="C_USN">USN</option>
                       <option value="Student_Name">Name</option>
                      <!-- <option value="C_Roll_Number">Roll Number</option> -->
                      
                  </select>
                 </div>
                 <!-- /.form-group -->
		</div>
		
		
		
		<div class="col-md-4">
		 <div class="form-group">
                  <label>Search</label>
                 
                   <select class="form-control select2"  id="Search_Text" name="Search_Text"  required>
                    	<option selected="selected"></option>
                  </select>
                 </div>
                 <!-- /.form-group -->
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
                <h3 class="card-title"><b>Students List </b></h3>



		<button type="button" id="dwn" class="btn btn-primary float-right" style="margin-right: 5px;" 
               onClick="tableToExcel('testTable1','Student' ,'StudentsList.xls')">
                    <i class="fas fa-download"></i> Download As Excel
                  </button>

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
              				
              
              ?>
              
              <!--   Display  CompanyWise Registraion Count  -->
            <style>
		 #testTable1 td,th{
		  border: 1px solid #ddd;
		 }
		 </style>
              
              
              <div class="card-body table-responsive p-0" style="height: 400px;font-size:14px;">
                <table class="table table-head-fixed table-hover text-nowrap" id='testTable1'>
                  <thead style="cursor: pointer;">
                    <tr>
                      <th style="width:5%">Edit</th>
                      <th style="width:5%">USN No</th>
                      <th style="width:5%">Roll No</th>
                      <th style="width:20%">Name</th>
                      <th style="width:5%">Gender</th>
                      <th style="width:5%">Branch</th>
                      <th style="width:5%">Sem</th>
                      <th style="width:5%">Section</th>
                      <th style="width:8%">DOB</th>
                      <th style="width:8%">DOJ</th>
                      <th style="width:8%">Quota</th>
                      <th>Phone</th>
                      <th>PCM %</th>
                      
                     
                    </tr>
                  </thead>
                  <tbody id="TBODY">
                  	<?php
                  	
                  	
			?>
                      
                    
                  
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
$(document).ready(function () {


 $("#Dept_Name").change(function () 
 {
    var val = $(this).val();
    
    $("#Batch").val("").change(); 
    $("#Sem").val("").change();
    $("#TBODY").html("");
    if(val!="") 
    $("#Search_By").val("").change();
    $("#Search_Text").val("").change();
    $.ajax({
	type: 'POST',
	url: 'Ajax/Dept_Fetch.php',
	data: {d_name:val},
	success:function(data)
		{
		$("#Program").html(data);
		}
	    });    
	  
	             
 });
 
 
 
 $("#Search_By").change(function () 
 {
    var val = $(this).val();
    
    $("#Program").val("").change();
    $("#Batch").val("").change(); 
    $("#Sem").val("").change();
    $("#TBODY").html("");
    if(val!="") 
    $("#Dept_Name").val("").change();
    $("#Search_Text").val("").change();
    
    $.ajax({
	type: 'POST',
	url: 'Ajax/Text_Fetch.php',
	data: {s_by:val},
	success:function(data)
		{
		$("#Search_Text").html(data);
		}
	    });               
 });
 
 
 
 
 
 
 $("#Dept_Name, #Program, #Batch,#Sem ").change(function () 
 {
   //alert("Clear");
   var Dept_Name = $("#Dept_Name").val();
   var Program = $("#Program").val();
   var Batch = $("#Batch").val();
   var Sem = $("#Sem").val();
      
   
  
   
   if(Dept_Name !="" && Program !="" && Batch !="" && Sem !="")
   {
   	$.ajax({
	type: 'POST',
	url: 'Ajax/Stud_Fetch.php',
	data: {Dept_Name:Dept_Name,Program:Program,Batch:Batch,Sem:Sem},
	success:function(data)
		{
		$("#TBODY").html(data);
		}
	    }); 	
   }
 });
 
 
 
 
 
 $("#Search_By, #Search_Text").change(function () 
 {
   //alert("Clear");
   var Search_By = $("#Search_By").val();
   var Search_Text = $("#Search_Text").val();
   
   if(Search_By !="" && Search_Text !="")
   {
   	$.ajax({
	type: 'POST',
	url: 'Ajax/Stud_Fetch.php',
	data: {Search_By:Search_By,Search_Text:Search_Text},
	success:function(data)
		{
		$("#TBODY").html(data);
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

});
</script>

