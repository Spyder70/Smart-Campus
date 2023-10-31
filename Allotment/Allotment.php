<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Admin.php");
//$Link_CHead="menu-open";
//$Link_ACompany="active";

$PageName="Students Allotment";
$Register_Head="menu-open";
$S_Allotment="active";




$C_msg="";


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







<form class="AAU" id="AAU">

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
    <section class="content" style="margin-top:-20px;" id="maincontent">
      <div class="container-fluid">
      
        
      
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default" style="background-color:#FCF9F9;">
          
          <!-- /.card-header -->
        
          
          
          <div class="card-body" >
            <div class="row">
            
            
            
            <div class="col-md-2">
		  <div class="form-group">
                   <label>Allot : <font color="red">*</font></label>
                   
                   <select class="form-control select2"  id="Allot" name="Allot"  required>
                    	<option selected="selected"></option>
                    	<option value="Section">Section</option>
                    	<option value="Roll_Number">Roll Number</option>
                    	<option value="USN">USN</option>
                    	<option value="Cycle">Cycle</option>
                    	<option value="Lab_Slots">Lab Slots</option>
                  </select>
                  </div> 
                <!-- /.form-group -->
          </div>
          
          
            
            
            <div class="col-md-2" id="Sec_Batch">
		  <div class="form-group">
                   <label>Academic Batch <font color="red">*</font></label>
                   <select class="form-control select2" id="Batch" name="Batch"  required>
                    
                    	
                    	<option selected="selected"></option>
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
            
            
		
		 <div class="col-md-1" id="Sec_Type">
		  <div class="form-group">
                   <label>Type : <font color="red">*</font></label>
                   
                   <select class="form-control select2"  id="C_Type" name="C_Type"  required>
                    	<option selected="selected"></option>
                    	<option value="UG">UG</option>
                    	<option value="PG">PG</option>
                    	
                  </select>
                  </div> 
                <!-- /.form-group -->
          	</div> 
		
		
		
		<div class="col-md-1" id="Sec_Sem">
		  <div class="form-group">
                   <label>Sem <font color="red">*</font></label>
                   
                   <select class="form-control select2"  id="Sem" name="Sem"  required>
                    	
                   
                    	<option selected="selected"></option>
                       <?php  
                       for($i=1; $i<=8;$i++)
                       {  ?>
                       <option value="<?php echo $i ?>"><?php echo $i ?></optio	n>
                      <?php }
                       ?>
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		
		
		<div class="col-md-4" id="Sec_Dept">
		  <div class="form-group">
                   <label>Course Name </label>
                   <select class="form-control select2" id="Dept_Name" name="Dept_Name"  required>
                    
                    	
                    	<option selected="selected"></option>
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
		
		
		<div class="col-md-2" id="Sec_Program">
		  <div class="form-group">
                   <label>Program </label>
                   
                   <select class="form-control select2"  id="Program" name="Program"  required>
                    	<option selected="selected"></option>
                  </select>
                  </div> 
                <!-- /.form-group -->
		</div>
		
		
		
		
		
		
		
		<div class="col-md-2" id="Sec_Section">
		 <div class="form-group">
                  <label id="L_Sec">Section :</label>
                 
                 <select class="form-control select2"  id="Section" name="Section"  required>
                    	
                    	
                    
                    	<option value="" selected="selected"></option>
                    	
                    	
                       <?php  
                        foreach (range('A', 'Z') as $i)
                       {  ?>
                       <option value="<?php echo $i ?>"><?php echo $i ?></option>
                      <?php } 
                       ?>
                       <option value="FT">FT</option>
                  </select>
                 </div>
                 <!-- /.form-group -->
		</div>
		
		
		<div class="col-md-2" id="Sec_LBatch">
		  <div class="form-group">
                   <label>Assign Batch <font color="red">*</font></label>
                   
                   <select class="form-control select2"  id="LBatch" name="LBatch"  required>
                    	<option selected="selected"></option>
                    	<option value="1">1</option>
                    	<option value="2">2</option>
                    	<option value="3">3</option>
                    	<option value="4">4</option>
                    	
                  </select>
                  </div> 
                <!-- /.form-group -->
          	</div> 
		
		
		  
		
		<div class="col-md-3" id="Sec_Pre">
		  <div class="form-group">
                   <label id="RollStart">Start Roll Number With :  </label>
                   
                  <input  type="text" class="form-control input" name="Pre_Roll" id="Pre_Roll" 
                    placeholder="Eg: 21A --> 21A001" onkeyup="this.value=this.value.toUpperCase();" required />
                  </div> 
                <!-- /.form-group -->
		</div>
		
		
		
		
		<div class="col-md-2" id="Sec_SectionA">
		 <div class="form-group">
                  <label id="L_Sec">From Section</label>
                 
                 <select class="form-control select2"  id="SectionA" name="SectionA"  required>
                    	
                    	
                    
                    	<option value="" selected="selected"></option>
                    	
                    	
                       <?php  
                        foreach (range('A', 'Z') as $i)
                       {  ?>
                       <option value="<?php echo $i ?>"><?php echo $i ?></option>
                      <?php }
                       ?>
                  </select>
                 </div>
                 <!-- /.form-group -->
		</div>
		
		
		<div class="col-md-2" id="Sec_SectionB">
		 <div class="form-group">
                  <label id="L_Sec">To Section</label>
                 
                 <select class="form-control select2"  id="SectionB" name="SectionB"  required>
                    	
                    	
                    
                    	<option value="" selected="selected"></option>
                    	
                    	
                       <?php  
                        foreach (range('A', 'Z') as $i)
                       {  ?>
                       <option value="<?php echo $i ?>"><?php echo $i ?></option>
                      <?php }
                       ?>
                  </select>
                 </div>
                 <!-- /.form-group -->
		</div>
		
		 
		<div class="col-md-3" id="Sec_Ass_Cycle">
		  <div class="form-group">
                   <label>Assign Cycle : <font color="red">*</font></label>
                   
                   <select class="form-control select2"  id="Ass_Cycle" name="Ass_Cycle"  required>
                    	<option selected="selected"></option>
                    	<option value="PHY">Physics</option>
                    	<option value="CHE">Chemistry</option>
                    	
                  </select>
                  </div> 
                <!-- /.form-group -->
          	</div> 
		
		
		 <div class="col-md-3" id="Sec_App_Cycle">
		  <div class="form-group" style="text-align:center;">
                   <label >Apply Cycle <font color="red"></font></label>
                   
                   <button type="button" onclick="Cycle_Process()" class="btn btn-block bg-gradient-success">Apply</button>
                
                  </div> 
                <!-- /.form-group -->
          	</div> 
		
		
		
		
		
		
		
		
          <!-- /.card-body -->
         </div>
         
           
        
         
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
 
  








<section class="content">
      <div class="container-fluid">
        <div class="row" id="List_Table">
          
          
        
          
          
          
          
          
          
          
          
          
          
        </div>
        <!-- /.row -->
        
         <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
 </div>
  <!-- /.content-wrapper -->



</form>






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




function Clear_T(f)
{
if(f=="mt1")
  $('#mt1').find('input:text').val('');
if(f=="mt2")
  $('#mt2').find('input:text').val('');
}



//$(document).ready(function () {

    $("#Sec_Batch").hide(); 
    $("#Sec_Sem").hide();
    $("#Sec_Dept").hide();
    $("#Sec_Program").hide();
    $("#Sec_Section").hide(); // Section	
    $("#Sec_Type").hide(); // Roll Number
    $("#Sec_Pre").hide();  // Roll Number
    $("#Sec_SectionA").hide();
    $("#Sec_SectionB").hide();
    $("#Sec_Ass_Cycle").hide();
    $("#Sec_App_Cycle").hide();
    $("#Sec_LBatch").hide();
    

 function Clr_F()
 {
    $("#List_Table").html("");
    
    $("#Batch").val("").change(); 
    $("#Sem").val("").change();
    $("#Dept_Name").val("").change();
    $("#Section").val("").change();
    $("#C_Type").val("").change();
    $("#Pre_Roll").val("").change();
    $("#SectionA").val("").change();
    $("#SectionB").val("").change();
    $("#Ass_Cycle").val("").change();
    $("#LBatch").val("").change();
    
    
    $("#Sec_Batch").hide(); 
    $("#Sec_Sem").hide();
    $("#Sec_Dept").hide();
    $("#Sec_Program").hide();
    $("#Sec_Section").hide(); // Section	
    $("#Sec_Type").hide(); // Roll Number
    $("#Sec_Pre").hide();  // Roll Number
    $("#Sec_SectionA").hide();
    $("#Sec_SectionB").hide();
    $("#Sec_Ass_Cycle").hide();
    $("#Sec_App_Cycle").hide();
    $("#Sec_LBatch").hide();
}



$("#Allot").change(function () 
 {
   var Sected_Allot = $("#Allot").val();
   
   if(Sected_Allot =="Section")
   {
   Clr_F();
   $("#Sec_Batch").show(); 
   $("#Sec_Sem").show();
   $("#Sec_Dept").show();
   $("#Sec_Program").show();
   $("#Sec_Section").show();
   $("#L_Sec").html("Assign Section :");
   }
   if(Sected_Allot =="Roll_Number")
   {
    Clr_F();
    $("#Sec_Batch").show(); 
    $("#Sec_Sem").show();
    $("#Sec_Dept").show();
    $("#Sec_Program").show();
    $("#Sec_Type").show();
    $("#Sec_Section").show();	
    $("#Sec_Pre").show();
    $("#L_Sec").html("Section :");	
    $("#RollStart").html("Start RollNumber With :");
    $('#Pre_Roll').attr("placeholder", "Eg: 20CSA");
   }
   if(Sected_Allot =="USN")
   {
    Clr_F();
    $("#Sec_Batch").show(); 
    $("#Sec_Sem").show();
    $("#Sec_Dept").show();
    $("#Sec_Program").show();
    $("#Sec_Type").show();
    $("#Sec_Section").show();	
    $("#Sec_Pre").show();
    $("#L_Sec").html("Section :");
    $("#RollStart").html("Start USN With :");
    $('#Pre_Roll').attr("placeholder", "Eg: 4NM20CS");
   	
   }
   if(Sected_Allot =="Cycle")
   {
    Clr_F();
    $("#Sec_SectionA").show();
    $("#Sec_SectionB").show();
    $("#Sec_Ass_Cycle").show();
    $("#Sec_App_Cycle").show();
    Cycle_Process();
    	
   }
   if(Sected_Allot =="Lab_Slots")
   {
   Clr_F();
    $("#Sec_Batch").show(); 
    $("#Sec_Sem").show();
    $("#Sec_Dept").show();
    $("#Sec_Program").show();
    $("#Sec_Type").show();
    $("#Sec_Section").show();	
    $("#Sec_LBatch").show();
  	
   }
  
 });
 



$('#Pre_Roll').keyup(function(){
var Sected_Allot =$("#Allot").val();
if(Sected_Allot =="Roll_Number")
 {
 	RollChange();
  
 }
else if(Sected_Allot =="USN")
 {
 	USNChange();
 }
});
 
 
$("#Dept_Name, #Program, #Batch,#Sem,#Section,#C_Type,#Pre_Roll,#LBatch").change(function () 
{
 var Sected_Allot =$("#Allot").val();
 var Batch = $("#Batch").val();
 var Sem = $("#Sem").val();
 var Dept_Name = $("#Dept_Name").val();
 var Program = $("#Program").val();
 var C_Type = $("#C_Type").val();
 var Section = $("#Section").val();
 var Pre_Roll = $("#Pre_Roll").val();
 
 if(Sected_Allot =="Section")
 {
 	if(Batch !="" && Sem !="" && Section!="" && Dept_Name!="" && Program!="" )
   	{
   	$.ajax({
	type: 'POST',
	url: 'Ajax/Section/Add_Remove_Section.php',
	data: {Batch:Batch,Sem:Sem,Dept_Name:Dept_Name,Program:Program,Section:Section},
	success:function(data)
		{
		$("#List_Table").html(data);
		}
	    });
   	 }
   	 else
   	 {
   	 	$("#List_Table").html("");
   	 }
 }
 else if(Sected_Allot =="Roll_Number")
 {
 	RollChange();
  
 }
 else if(Sected_Allot =="USN")
 {
 	USNChange();
 }
 else if(Sected_Allot =="Lab_Slots")
 {
 	LabAllot();
 }
 
 });

/* Not Used
 $("#C_Type").change(function () 
 {
    var val = $(this).val();
    
    $.ajax({
	type: 'POST',
	url: 'Ajax/Course_Fetch.php',
	data: {c_type:val},
	success:function(data)
		{
		$("#Dept_Name").html(data);
		$("#List_Table").html("");
		}
	    });                
 });*/
 
 $("#Dept_Name").change(function () 
 {
    var val = $(this).val();
    
   /* 
    $("#Batch").val("").change(); 
    $("#Sem").val("").change();
    $("#TBODY").html("");
    if(val!="") 
    $("#Search_By").val("").change();
     */
     
    $.ajax({
	type: 'POST',
	url: 'Ajax/Dept_Fetch.php',
	data: {d_name:val},
	success:function(data)
		{
		$("#Program").html(data);
		$("#List_Table").html("");
		}
	    });                
 });

// }); // main jquery



 /*  SECTION ALLOTMENT  */  

function Add_Section(sid)
{
 var Role="Add";
 var Student_ID=sid;
 var Batch = $("#Batch").val();
 var Sem = $("#Sem").val();
 var Dept_Name = $("#Dept_Name").val();
 var Program = $("#Program").val();
 var Section = $("#Section").val();
 $.ajax({
	type: 'POST',
	url: 'Ajax/Section/Add_Remove_Section.php',
	data: {Role:Role,Student_ID:Student_ID,Batch:Batch,Sem:Sem,Dept_Name:Dept_Name,Program:Program,Section:Section},
	success:function(data)
		{
		$("#List_Table").html(data);
		}
	    });
 
}
function Remove_Section(sid)
{
 var Role="Remove";
 var Student_ID=sid;
 var Batch = $("#Batch").val();
 var Sem = $("#Sem").val();
 var Dept_Name = $("#Dept_Name").val();
 var Program = $("#Program").val();
 var Section = $("#Section").val();
 
 $.ajax({
	type: 'POST',
	url: 'Ajax/Section/Add_Remove_Section.php',
	data: {Role:Role,Student_ID:Student_ID,Batch:Batch,Sem:Sem,Dept_Name:Dept_Name,Program:Program,Section:Section},
	success:function(data)
		{
		$("#List_Table").html(data);
		}
	    });
 
}


/*  ROLL NUMBER Section   */

function RollChange() // on change of PreRoll Text
{
 var Sected_Allot =$("#Allot").val();
 var Batch = $("#Batch").val();
 var Sem = $("#Sem").val();
 var Dept_Name = $("#Dept_Name").val();
 var Program = $("#Program").val();
 var C_Type = $("#C_Type").val();
 var Section = $("#Section").val();
 var Pre_Roll = $("#Pre_Roll").val();
if(Batch !="" && C_Type !="" && Sem !="")
   	{
   	   if((C_Type =="UG" && Sem <="2") || (Dept_Name!="" && Program!=""))
   	   {
   		$.ajax({
		type: 'POST',
		url: 'Ajax/Roll/Roll_Allot.php',
		data: {Batch:Batch,C_Type:C_Type,Sem:Sem,Dept_Name:Dept_Name,Program:Program,Section:Section,Pre_Roll:Pre_Roll},
		success:function(data)
		{
		$("#List_Table").html(data);
		}
	    	});
	    
	    }
	    else
   	    {
   	 	$("#List_Table").html("");
   	    }
	    
   	 }
   	 else
   	 {
   	 	$("#List_Table").html("");
   	 }
}

// Traverse through All Fields 
function Check_Roll(stid,mts)
{
  var n_stid=document.getElementById(stid).value;
  var flag=0;
  var dt1,CapS1;
  $('#mt1 , #mt2').find('input:text').each(function( value ) 
  {
   
  	if(n_stid!="")
  	{
  		if(n_stid==this.value)
  		flag=flag+1;
  	
  	}
  });
  if(flag==2)
  {
		alert(n_stid+" is Already There in the list");
		document.getElementById(stid).value="";
  }
  else
  {
          
  	if(n_stid!="")
  	{
  	$.ajax({
		type: 'POST',
		url: 'Ajax/Roll/Validate_Roll.php',
		data: {C_Roll:n_stid,stid:stid,mts:mts},
		success:function(data)
			{
				if(data=="Found")
				{
				alert(n_stid+" is Already Assigned");
				document.getElementById(stid).value="";
				}
			}
	   	 });
 	 }
  }
}
function Update_Roll(stat)// Updating table
{
var aj_return;
 var Gurl="";
 
        if(stat=="Add")
        	Gurl='Ajax/Roll/Add_Roll.php';
        if(stat=="Update")
        	Gurl='Ajax/Roll/Update_Roll.php';
        if(stat!="")
        {
	        $.ajax({
		type: 'POST',
		url: Gurl,
		data: $('form').serialize(),
		async:false,
		success:function(dat)
			{
			   
			   if(dat.trim()=="OK"){ 
			   //alert("Successfully Updated..");
			   aj_return=1;
			}
			}
	   	 });
	   	 
	   if(aj_return==1)	
	   {
	    alert("Successfully Updated..");
	    RollChange();
	    //location.reload();
	   } 
	   	 	
	 }   	 	  
}




/*  USN ALLOTMENT Section   */

function USNChange() // on change of PreRoll Text
{
 var Sected_Allot =$("#Allot").val();
 var Batch = $("#Batch").val();
 var Sem = $("#Sem").val();
 var Dept_Name = $("#Dept_Name").val();
 var Program = $("#Program").val();
 var C_Type = $("#C_Type").val();
 var Section = $("#Section").val();
 var Pre_Roll = $("#Pre_Roll").val();
if(Batch !="" && C_Type !="" && Sem !="")
   	{
   	   if((C_Type =="UG" && Sem <="2") || (Dept_Name!="" && Program!=""))
   	   {   
   		$.ajax({
		type: 'POST',
		url: 'Ajax/USN/USN_Allot.php',
		data: {Batch:Batch,C_Type:C_Type,Sem:Sem,Dept_Name:Dept_Name,Program:Program,Section:Section,Pre_Roll:Pre_Roll},
		success:function(data)
		{
		$("#List_Table").html(data);
		}
	    	});
	    
	    }
	    else
   	    {
   	 	$("#List_Table").html("");
   	    }
	    
   	 }
   	 else
   	 {
   	 	$("#List_Table").html("");
   	 }
}

// Traverse through All Fields 
function Check_USN(stid,mts)
{
  var n_stid=document.getElementById(stid).value;
  var flag=0;
  var dt1,CapS1;
  $('#mt1 , #mt2').find('input:text').each(function( value ) 
  {
   
  	if(n_stid!="")
  	{
  		if(n_stid==this.value)
  		flag=flag+1;
  	
  	}
  });
  if(flag==2)
  {
		alert(n_stid+" is Already There in the list");
		document.getElementById(stid).value="";
  }
  else
  {
          
  	if(n_stid!="")
  	{
  	$.ajax({
		type: 'POST',
		url: 'Ajax/USN/Validate_USN.php',
		data: {C_Roll:n_stid,stid:stid,mts:mts},
		success:function(data)
			{
				if(data=="Found")
				{
				alert(n_stid+" is Already Assigned");
				document.getElementById(stid).value="";
				}
			}
	   	 });
 	 }
  }
}
function Update_USN(stat)// Updating table
{

	//var n_stid=document.getElementById(stid).value;
 
        if(stat=="Add")
        	Gurl='Ajax/USN/Add_USN.php';
        if(stat=="Update")
        	Gurl='Ajax/USN/Update_USN.php';
        if(stat!="")
        {
	        $.ajax({
		type: 'POST',
		url: Gurl,
		data: $('form').serialize(),
		async:false,
		success:function(dat)
			{
			   
			   if(dat.trim()=="OK"){ 
			   //alert("Successfully Updated..");
			   aj_return=1;
			}
			}
	   	 });
	   	 
	   if(aj_return==1)	
	   {
	    alert("Successfully Updated..");
	    USNChange();
	    //location.reload();
	   } 
	   	 	
	 }   	 	  
}

function Cycle_Process()// Updating table
{
 var StartA = $("#SectionA").val();
 var EndB = $("#SectionB").val();
 var ACycle = $("#Ass_Cycle").val();
 //alert(EndB);
// if( StartA!="" and EndB !="" and ACycle!="")
 //{		
        $.ajax({
	type: 'POST',
	url: 'Ajax/Cycle/Cycle.php',
	data: {StartA:StartA,EndB:EndB,ACycle:ACycle},
	
	success:function(data)
		{
		$("#List_Table").html(data);
		}
	});
//}	
	   	 
	   	 	  
}


/*  Lab_Batch ALLOTMENT Section   */

function LabAllot() 
{
 var Sected_Allot =$("#Allot").val();
 var Batch = $("#Batch").val();
 var C_Type = $("#C_Type").val();
 var Sem = $("#Sem").val();
 var Dept_Name = $("#Dept_Name").val();
 var Program = $("#Program").val();
 var Section = $("#Section").val();
 var LBatch = $("#LBatch").val();
 if(Batch !="" && C_Type !="" && Sem !="" && Dept_Name !="" && Program !="" && Section !="" && LBatch !="")
 {
 	$.ajax({
		type: 'POST',
		url: 'Ajax/LAB/LAB_Allot.php',
		data: {Batch:Batch,C_Type:C_Type,Sem:Sem,Dept_Name:Dept_Name,Program:Program,Section:Section,LBatch:LBatch},
		success:function(data)
		{
		$("#List_Table").html(data);
		}
	    	});
 }
}
 
 
function Add_LAB(sid)
{
 var Role="Add";
 var Student_ID=sid;
 var Batch = $("#Batch").val();
 var C_Type = $("#C_Type").val();
 var Sem = $("#Sem").val();
 var Dept_Name = $("#Dept_Name").val();
 var Program = $("#Program").val();
 var Section = $("#Section").val();
 var LBatch = $("#LBatch").val();
 if(Batch !="" && C_Type !="" && Sem !="" && Dept_Name !="" && Program !="" && Section !="" && LBatch !="")
 {
 $.ajax({
	type: 'POST',
	url: 'Ajax/LAB/LAB_Allot.php',
	data: {Role:Role,Student_ID:Student_ID,Batch:Batch,C_Type:C_Type,Sem:Sem,Dept_Name:Dept_Name,Program:Program,Section:Section,LBatch:LBatch},
	success:function(data)
		{
		$("#List_Table").html(data);
		}
	    });
 }
 
}
function Remove_LAB(sid)
{
 var Role="Remove";
 var Student_ID=sid;
 var Batch = $("#Batch").val();
 var C_Type = $("#C_Type").val();
 var Sem = $("#Sem").val();
 var Dept_Name = $("#Dept_Name").val();
 var Program = $("#Program").val();
 var Section = $("#Section").val();
 var LBatch = $("#LBatch").val();
 if(Batch !="" && C_Type !="" && Sem !="" && Dept_Name !="" && Program !="" && Section !="" && LBatch !="")
 {
 $.ajax({
	type: 'POST',
	url: 'Ajax/LAB/LAB_Allot.php',
	data: {Role:Role,Student_ID:Student_ID,Batch:Batch,C_Type:C_Type,Sem:Sem,Dept_Name:Dept_Name,Program:Program,Section:Section,LBatch:LBatch},
	success:function(data)
		{
		$("#List_Table").html(data);
		}
	    });
 
}
}

</script>





