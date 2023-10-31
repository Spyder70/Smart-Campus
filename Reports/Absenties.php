<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Support.php");


//$Course_Registration_Head="menu-open";
//$Add_Subjects="active";

$PageName="Absenties List";
$AReport_Head="menu-open";
$Absenties_List="active";
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


<form method="post" action="Absenties.php">

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
                   <label>Exam Type</label>
                   <select class="form-control select2"  id="Exam_Type" name="Exam_Type"  required>
                  
                    <option value="" selected="selected"></option>
                    
                   
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		
		
		<div class="col-md-2">
		  <div class="form-group">
                   <label>Cycle/Branch</label>
                  
                   <select class="form-control select2"  id="B_Type" name="B_Type"  required>
                    <option value=""></option>
                   <!-- <option value="Cycle">Cycle</option>-->
                    <option value="Program">Branch</option>
                    
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		
		<div class="col-md-2" id="Sec_Program">
		  <div class="form-group">
                   <label>Branch </label>
                   
                   <select class="form-control select2"  id="Program" name="Program"  required>
                    	<option value="All">--All--</option>
                    	<?php
                       $sql ="SELECT Short_Name FROM Department ";
    			$query= $dbh -> prepare($sql);
    			$query-> execute();
    			$results2=$query->fetchAll(PDO::FETCH_OBJ);
    			
    			foreach($results2 as $result2)
    			{  ?>
    			<option value="<?php echo $result2->Short_Name;?>"> <?php echo $result2->Short_Name;?> </option>
    			<?php 
    			} 
    			?>	
                    	
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		
		<div class="col-md-2" id="Sec_Cycle">
		  <div class="form-group">
                   <label>Cycle : <font color="red">*</font></label>
                   
                   <select class="form-control select2"  id="Cycle" name="Cycle"  required>
                    	<option value="All">--All--</option>
                    	<option value="PHY">Physics</option>
                    	<option value="CHE">Chemistry</option>
                    	
                  </select>
                  </div> 
                <!-- /.form-group -->
          	</div> 
          	
          	<div class="col-md-2">
		  <div class="form-group">
                   <label>Semester</label>
                  
                   <select class="form-control select2"  id="Semester" name="Semester"  required>
                    <option value="All">--All--</option>
                    <option value="1">1</option>	<option value="2">2</option>
                    <option value="3">3</option>	<option value="4">4</option>
                    <option value="5">5</option>	<option value="6">6</option>    
                    <option value="7">7</option>	<option value="8">8</option> 
                    <option value="9">9</option>	<option value="10">10</option> 
                    
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		
		<div class="col-md-2">
		  <div class="form-group">
                   <label>Section</label>
                  
                   <select class="form-control select2"  id="Section" name="Section"  required>
                       <!--<option value="All">--All--</option>-->
                 <?php  
                       foreach (range('A', 'A') as $i)
                       {  ?>
                       <option value="<?php echo $i ?>"><?php echo $i ?></option>
                 <?php }  ?>                                      
                    
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		
		
		<div class="col-md-3">
		 <div class="form-group">
                  <label>From Date </label>
                 
                   <input style="font-size:17px;" type="date"  
                   class="form-control input" style="width: 100%;" 
                    name="Fr_Date" id="Fr_Date" />
                 </div>
                 <!-- /.form-group -->
		</div>
		
		
		<div class="col-md-3">
		 <div class="form-group">
                  <label>To Date </label>
                 
                   <input style="font-size:17px;" type="date"  
                   class="form-control input" style="width: 100%;" 
                    name="To_Date" id="To_Date" />
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
      <div class="container-fluid" id="TBY">
        
        
          
        
        
       
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

var TBY="";
function sortTable(ttt) {

TBY=ttt;
  var table = $(TBY).parents('table').eq(0);
  //  var table = $('#ft')
    var rows = table.find('tr:gt(0)').toArray().sort(comparer($(TBY).index()));
    this.asc = !this.asc;
    if (!this.asc){rows = rows.reverse()}
    for (var i = 0; i < rows.length; i++){table.append(rows[i]);}
}
function comparer(index) {
    return function(a, b) {
        var valA = getCellValue(a, index), valB = getCellValue(b, index);
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB);
    }
}
function getCellValue(row, index){ return $(row).children('td').eq(index).text() ;}

</script>


<script>


$("#Sec_Program").hide(); 
$("#Sec_Cycle").hide();

function Clr_F()
{
$("#Program").val("All").change();
$("#Cycle").val("All").change();

$("#Sec_Program").hide(); 
$("#Sec_Cycle").hide();
}


$("#B_Type").change(function() 
{
Clr_F();
var b_type = $("#B_Type").val();
if(b_type=="Program"){
$("#Sec_Program").show();
}else if(b_type=="Cycle"){
$("#Sec_Cycle").show();
}
});


$("#C_Date").change(function() 
{
    
    var val = $("#C_Date").val();
    var val2="Exam_Type";
    if(val!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Absenties_Fetch.php',
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
      $("#TBY").html("");
     }
     
});



$("#Exam_Type").change(function() 
{
  
    var val = $("#C_Date").val();
    var Exam_Type = $("#Exam_Type").val();
    var val2="Subjects";
    if(Exam_Type!="")
    {
    
    }
     else
     {
      $("#TBY").html("");
     }
});


$("#C_Date,#Exam_Type,#B_Type,#Program,#Cycle,#Semester,#Section,#To_Date,#Fr_Date").change(function() 
{
var c_date = $("#C_Date").val();
var ex_type = $("#Exam_Type").val();
var b_type = $("#B_Type").val();
var program = $("#Program").val();
var cycle = $("#Cycle").val();
var sem = $("#Semester").val();
var section = $("#Section").val();
var from_d = $("#Fr_Date").val();
var to_d = $("#To_Date").val();
var val2="ShowList";
    if(c_date!="" && ex_type!="" && from_d!="" && to_d!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Absenties_Fetch.php',
	data: {C_Date:c_date,Exam_Type:ex_type,B_Type:b_type,Program:program,Cycle:cycle,Semester:sem,
	Section:section,Fr_Date:from_d,To_Date:to_d,Fetch:val2},
	success:function(data)
		{
                //$("#TBY").html("");
		$("#TBY").html(data);
		
		}
	    });  
     }
     else
     {}

});



</script>

