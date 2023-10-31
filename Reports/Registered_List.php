<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Admin.php");


//$Course_Registration_Head="menu-open";
//$Add_Subjects="active";

$PageName="Subject Registration List";
$AReport_Head="menu-open";
$Sub_Reg_list="active";
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




    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      
        <form method="post" action="">
      
         <!-- SELECT2 EXAMPLE -->
        <div class="card card-default" style="margin-top:-25px;">
          
          <!-- /.card-header -->
        
          
          
          <div class="card-body" >
            <div class="row">
            
            
		<div class="col-md-2">
		 <div class="form-group">
                  <label>Course Date</label>
                 
                   <select class="form-control select2"  id="C_Date" name="C_Date"  required>
                   
                    <option selected="selected"></option>
                   <?php 
                    	
                    	$sql ="SELECT Course_Date FROM Course_Subjects Group By Course_Date order by Course_Date desc  ";
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
		
		
		<div class="col-md-1">
		  <div class="form-group">
                   <label>Sem</label>
                  
                   <select class="form-control select2"  id="Sem" name="Sem"  required>
                    <option selected="selected"></option>
                    
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		<div class="col-md-2">
		  <div class="form-group">
                   <label>Branch</label>
                  
                   <select class="form-control select2"  id="Branch" name="Branch"  required>
                    <option selected="selected"></option>
                    
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		<div class="col-md-2">
		  <div class="form-group">
                   <label>Subject Type</label>
                  
                   <select class="form-control select2"  id="Sub_type" name="Sub_type"  required>
                    <option selected="selected"></option>
                    
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		
			
		
		<div class="col-md-7" id="SectionS" name="SectionS">
		  <div class="form-group">
                   <label>Choose Subject</label>
                  
                   <select class="form-control select2"  id="Subject" name="Subject"  required>
                    <option selected="selected"></option>
                    
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
                       
         </form>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
 
  



<section class="content">
  <div class="container-fluid">
       <div class="row" id="Sub_Table">
          
          
        
          
          
      
         
          
          
        </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</section><!-- /.content -->







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



 $("#SectionS").hide();
 function Clr_F()
 {
    $("#SectionS").hide();
    $("#Subject").val("").change();
    $("#Subject").prop('required',false);
 }
  function Clr_S()
 {
   $("#SectionS").show();
   $("#Subject").prop('required',true);
 }





$("#C_Date").change(function() 
{
    var val = $("#C_Date").val();
    var val2="Exam_Type";
    if(val!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Show_Registered.php',
	data: {C_Date:val,Fetch:val2},
	success:function(data)
		{
		Clr_F();
		$("#Sub_Table").html("");
		$("#Exam_Type").html(data);
		}
	    });  
     }
     else
     {
      Clr_F();
      $("#Exam_Type").html("");
      $("#Sub_Table").html("");
     }
     
});



$("#Exam_Type").change(function() 
{
    var val = $("#C_Date").val();
    var Exam_Type = $("#Exam_Type").val();
    var val2="Sem";
    if(val!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Show_Registered.php',
	data: {C_Date:val,Exam_Type:Exam_Type,Fetch:val2},
	success:function(data)
		{
		Clr_F();
		$("#Sub_Table").html("");
		$("#Sem").html(data);
		}
	    });  
     }
     else
     {
      Clr_F();
      $("#Sem").html("");
      $("#Sub_Table").html("");
     }
});



$("#Sem").change(function() 
{
    var Sem = $("#Sem").val();
    var C_Date = $("#C_Date").val();
    var Exam_Type = $("#Exam_Type").val();
    var val2="Branch";
    if(Sem!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Show_Registered.php',
	data: {C_Date:C_Date,Exam_Type:Exam_Type,Sem:Sem,Fetch:val2},
	success:function(data)
		{
		Clr_F();
		$("#Sub_Table").html("");
		$("#Branch").html(data);
		}
	    });  
     }
     else
     {
      Clr_F();
      $("#Branch").html("");
      $("#Sub_Table").html("");
     }
});


$("#Branch").change(function() 
{
    var C_Date = $("#C_Date").val();
    var Exam_Type = $("#Exam_Type").val();
    var Sem = $("#Sem").val();
    var Branch = $("#Branch").val();
    var val2="SubjectType";
    if(Branch!="")
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Show_Registered.php',
	data: {C_Date:C_Date,Exam_Type:Exam_Type,Sem:Sem,Branch:Branch,Fetch:val2},
	success:function(data)
		{
		Clr_F();
		$("#Sub_type").html(data);
		$("#Sub_Table").html("");
		}
	    });  
     }
     else
     {
      Clr_F();
      $("#Sub_type").html("");
      $("#Sub_Table").html("");
     }
   
});




$("#Sub_type").change(function() 
{
    var C_Date = $("#C_Date").val();
    var Exam_Type = $("#Exam_Type").val();
    var Sem = $("#Sem").val();
    var Branch = $("#Branch").val();
    var Sub_type = $("#Sub_type").val();
    var val2="Subject";
    if(Sub_type!="" && Sub_type!="Core") //choose elective subject 
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Show_Registered.php',
	data: {C_Date:C_Date,Exam_Type:Exam_Type,Sem:Sem,Branch:Branch,Sub_type:Sub_type,Fetch:val2},
	success:function(data)
		{
		 Clr_S();
		 $("#Sub_Table").html("");
		 $("#Subject").html(data);
		 
		//$("#Subject").html(data);
		}
	    });  
     }
     if(Sub_type=="Core") // go for Core
     {
        val2="Core";
        Clr_F();
        $.ajax({
	type: 'POST',
	url: 'Ajax/Show_Registered.php',
	data: {C_Date:C_Date,Exam_Type:Exam_Type,Sem:Sem,Branch:Branch,Sub_type:Sub_type,Fetch:val2},
	success:function(data)
		{
		 Clr_F();
		 $("#Sub_Table").html(data);
		 
		//$("#Subject").html(data);
		}
	    });  
     
     }
      if(Sub_type=="")
     {
       Clr_F();
       $("#Sub_Table").html("");
     }
});


$("#Subject").change(function() 
{
    var C_Date = $("#C_Date").val();
    var Exam_Type = $("#Exam_Type").val();
    var Sem = $("#Sem").val();
    var Branch = $("#Branch").val();
    var Sub_type = $("#Sub_type").val();
    var Sub_code = $("#Subject").val();
    var val2="Ele";
    if(Sub_code!="" && Sub_type!="Core") //choose elective subject 
    {
    $.ajax({
	type: 'POST',
	url: 'Ajax/Show_Registered.php',
	data: {C_Date:C_Date,Exam_Type:Exam_Type,Sem:Sem,Branch:Branch,Sub_type:Sub_type,Sub_code:Sub_code,Fetch:val2},
	success:function(data)
		{
		 $("#Sub_Table").html(data);
		}
	    });  
     }
     if(Sub_code=="")
     {
       $("#Sub_Table").html("");
     }
});


</script>

