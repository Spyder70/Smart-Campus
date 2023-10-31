<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/DataEntry.php");
//$Link_CHead="menu-open";
//$Link_ACompany="active";

$PageName="Entire Student Details";
$AReport_Head="menu-open";
$S_StudentsDB="active";



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
            
            
	
		
		
		
		
		<div class="col-md-3	">
		  <div class="form-group">
                   <label>Program <font color="red">*</font></label>
                   
                   <select class="form-control select2"  id="Program" name="Program"  required>
                      <option selected="selected"></option>
                    <!--	<option value="ALL">ALL</option>
                      <option value="UG">UG</option>
                      <option value="PG">PG</option>-->
                       <option value="UG">UG</option>
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

        $sql ="SELECT DISTINCT Sem FROM Student_Info order by Sem asc";
        $query= $dbh -> prepare($sql);
        $query-> execute();
        $results2=$query->fetchAll(PDO::FETCH_OBJ);
        foreach($results2 as $result2)
        {  ?>
        <option value="<?php echo $result2->Sem;?>"> <?php echo $result2->Sem;?> </option>
        <?php 
        } ?>
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
		
		
        
         </form>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
 
  








<section class="content"  id="TBODY">
      
  
             
                
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


 
 
 $("#Program,#Batch,#Sem ").change(function () 
 {
   //alert("Clear");
   var Program = $("#Program").val();
   var Batch = $("#Batch").val();
   var Sem = $("#Sem").val();
      
   
   if(Program !="" && Batch !="" && Sem !="")
   {
   	$.ajax({
	  type: 'POST',
	  url: 'Ajax/Stud_DB_Fetch.php',
	  data: {Program:Program,Batch:Batch,Sem:Sem},
	  success:function(data)
		{
		$("#TBODY").html(data);
		}
	  }); 	
   }
 });
 
 
 

 
 /*
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
*/
}); 
</script>

