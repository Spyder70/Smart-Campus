<?php
session_start();
require("../../DB/config.php");
$Faculty_ID=$_SESSION['F_ID'];
if(isset($_POST['Fetch']))
{

	if($_POST['Fetch']=="Exam_Type")
	{
		$C_Date = $_POST['C_Date'];
          	$sql ="SELECT Exam_Type FROM Course_Subjects where Course_Date='$C_Date' group by Exam_Type order by Exam_Type asc";
    		$query= $dbh -> prepare($sql);
    		
    		$query-> execute();
    		$results2=$query->fetchAll(PDO::FETCH_OBJ);
    		?>
    		<option value="" selected="selected"></option>
    		<?php
    		foreach($results2 as $result2)
    		{  ?>
    		<option value="<?php echo $result2->Exam_Type;?>"> <?php echo $result2->Exam_Type;?> </option>
    		<?php 
    		} 
    		
    	}
	if($_POST['Fetch']=="Sem")
	{
		$C_Date = $_POST['C_Date'];
		$Exam_Type = $_POST['Exam_Type'];
          	$sql ="SELECT Sem FROM Course_Subjects where Course_Date='$C_Date' and Exam_Type='$Exam_Type' group by Sem order by Sem asc";
    		$query= $dbh -> prepare($sql);
    		
    		$query-> execute();
    		$results2=$query->fetchAll(PDO::FETCH_OBJ);
    		?>
    		<option selected="selected"></option>
    		<?php
    		foreach($results2 as $result2)
    		{  ?>
    		<option value="<?php echo $result2->Sem;?>"> <?php echo $result2->Sem;?> </option>
    		<?php 
    		} 
    	}
    	if($_POST['Fetch']=="Branch")
	{
		$C_Date = $_POST['C_Date'];
		$Sem = $_POST['Sem'];
		$Exam_Type = $_POST['Exam_Type'];
          	$sql ="SELECT Branch FROM Course_Subjects where 
          	Course_Date='$C_Date' and Sem='$Sem' and Exam_Type='$Exam_Type' group by Branch order by Branch";
    		$query= $dbh -> prepare($sql);
    		
    		$query-> execute();
    		$results2=$query->fetchAll(PDO::FETCH_OBJ);
    		?>
    		<option selected="selected"></option>
    		<?php
    		foreach($results2 as $result2)
    		{  ?>
    		<option value="<?php echo $result2->Branch;?>"> <?php echo $result2->Branch;?> </option>
    		<?php 
    		} 
	
	}
	if($_POST['Fetch']=="SubjectType")
	{
		$C_Date = $_POST['C_Date'];
		$Sem = $_POST['Sem'];
		$Branch = $_POST['Branch'];
		$Exam_Type = $_POST['Exam_Type'];
		$sql ="SELECT Subject_Type FROM Course_Subjects where 
          	Course_Date='$C_Date' and Sem='$Sem' and Exam_Type='$Exam_Type' group by Subject_Type order by Subject_Type asc";
    		$query= $dbh -> prepare($sql);
    		$query-> execute();
    		$results2=$query->fetchAll(PDO::FETCH_OBJ);
    		?>
    		<option selected="selected"></option>
    		<?php
    		foreach($results2 as $result2)
    		{  ?>
    		<option value="<?php echo $result2->Subject_Type;?>"> <?php echo $result2->Subject_Type;?> </option>
    		<?php 
    		} 
		
	}
	if($_POST['Fetch']=="Subject")
	{
		$C_Date = $_POST['C_Date'];
		$Sem = $_POST['Sem'];
		$Branch = $_POST['Branch'];
		$Exam_Type = $_POST['Exam_Type'];
		$Subject_Type = $_POST['Sub_type'];
		if($Subject_Type=="Global Elective")
		{
		$sql ="SELECT Sub_ID,Subject_Code,Subject_Name FROM Course_Subjects where 
          	Course_Date='$C_Date' and Sem='$Sem' and Exam_Type='$Exam_Type' and Subject_Type='$Subject_Type' order by Subject_Code";
		}
		else
		{
          	$sql ="SELECT Sub_ID,Subject_Code,Subject_Name FROM Course_Subjects where 
          	Course_Date='$C_Date' and Sem='$Sem' and Branch='$Branch' and Exam_Type='$Exam_Type' and Subject_Type='$Subject_Type' order by Subject_Code";
          	}
    		$query= $dbh -> prepare($sql);
    		
    		$query-> execute();
    		$results2=$query->fetchAll(PDO::FETCH_OBJ);
    		?>
    		<option selected="selected"></option>
    		<?php
    		foreach($results2 as $result2)
    		{  ?>
    		<option value="<?php echo $result2->Sub_ID;?>"> <?php echo $result2->Subject_Code." - ".$result2->Subject_Name;?> </option>
    		<?php 
    		} 
	
	}
	
	
	
	if($_POST['Fetch']=="Core")
	{
	$C_Date = $_POST['C_Date'];
	$Sem = $_POST['Sem'];
	$Branch = $_POST['Branch'];
	$Exam_Type = $_POST['Exam_Type'];
	$Sub_type = $_POST['Sub_type'];
	
	$FileName="CoreSubjectRegistrerd-".$Branch ."-".$Sem;	
		
	$sid_sql="Select Sub_ID,Subject_Code,Subject_Name,Credit,Th_Pract from Course_Subjects where Course_Date='$C_Date' and
                 Exam_Type='$Exam_Type' and Branch='$Branch' and Sem='$Sem' and Subject_Type='$Sub_type'";
	$sid_query= $dbh -> prepare($sid_sql);
	$sid_query-> execute();
	$count = $sid_query->rowCount();
	$Cresult=$sid_query->fetchAll(PDO::FETCH_OBJ);   

	if( ($Branch=='PHY' or $Branch=='CHE') and ($Sem<=2))
	{
	$str_lst=" and S1.Cycle='$Branch' order by S1.C_USN,S1.C_Roll_Number";
	}
	else
	{
	$str_lst=" and S1.Program='$Branch'  order by S1.C_USN,S1.C_Roll_Number ";
	}
	 
	 
	$sql ="Select S1.Student_ID,S1.C_USN,S1.C_Roll_Number,S1.Student_Name
		from Student_Info as S1 Where S1.Sem='$Sem' ";
                       
        $sql= $sql.$str_lst;
     
     	$query= $dbh -> prepare($sql);
	$query-> execute();
    	$Fresult=$query->fetchAll(PDO::FETCH_OBJ);
    	
    	?>
    	
    	
    	  <div class="col-12">
            <div class="card card-primary" >
              <div class="card-header" style="background:orange">
              <span style="color:black;font-weight:bold;">Students List of Core Subjects</span>
              
              
               <button type="button" id="dwn" class="btn btn-primary float-right" style="margin-right: 5px;" 
               onClick="tableToExcel('testTable1','Student' ,'<?php echo $FileName.".xls"; ?>')">
                    <i class="fas fa-download"></i> Download As Excel
                  </button>
              </div>
              <!-- /.card-header -->
              
               <style>
		 #testTable1 td,th{
		  border: 1px solid #ddd;
		 }
		 </style>
              
             
              
              <!--   Display  CompanyWise Registraion Count  -->
            
              
              
              <div class="card-body table-responsive p-0" style="height: 400px;" >
		
		 <!-- 4 -->
            
                <table class="table table-head-fixed table-hover text-nowrap" id="testTable1">
                
                  <thead>
                      <tr>
                      <th id="a1" onclick="sortTable('#a1')">Sl.No</th>
                      <th id="a2" onclick="sortTable('#a2')">USN No</th>
                      <th id="a3" onclick="sortTable('#a3')">Roll No</th>
                      <th id="a4" onclick="sortTable('#a4')">Name</th>
                    </tr>
                  </thead>
                  
                  
                  <tbody id="TBODY">
                  
                  	<?php 
                  	$i=1;  			
    			foreach($Fresult as $Fres)
			{
			$STD_ID=$Fres->Student_ID;
	 		$sid_sql="Select count(*) as STot from Course_Registration where 
	 		Course_Date='$C_Date' and Student_ID='$STD_ID' and Sub_ID IN(
		 	Select Sub_ID from Course_Subjects where Course_Date='$C_Date' and
         		Exam_Type='$Exam_Type' and Branch='$Branch' and Sem='$Sem' and Subject_Type='$Sub_type')";
	 		$sid_query= $dbh -> prepare($sid_sql);
	 		$sid_query-> execute();
	 		$ct = $sid_query->fetch();
	 		$Found=$ct['STot'];
	 		
	 		if($Found == $count)
	 		{
			?>
			<tr>
			<td><?php echo $i; $i=$i+1; ?></td>
                      	<td><?php echo $Fres->C_USN  ; ?></td>
  			<td><?php echo $Fres->C_Roll_Number  ; ?></td>
  			<td><?php echo $Fres->Student_Name  ; ?></td>
  			</tr>
                      	<?php
                      	}
                      	
                      	}
                  	
			?>
                      
                    
                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
		
	<?php
	}
	if($_POST['Fetch']=="Ele")
	{
	$C_Date = $_POST['C_Date'];
	$Sem = $_POST['Sem'];
	$Branch = $_POST['Branch'];
	$Exam_Type = $_POST['Exam_Type'];
	$Subject_Type = $_POST['Sub_type'];
	$Sub_ID = $_POST['Sub_code']; 
	
	$sid_sql="Select Subject_Code,Subject_Name from Course_Subjects where Course_Date='$C_Date' and Sub_ID='$Sub_ID' ";
	$sid_query= $dbh -> prepare($sid_sql);
	$sid_query-> execute();
	$ct = $sid_query->fetch();
	$SubCode=$ct['Subject_Code'];	$SubName=$ct['Subject_Name'];
	
	$FileName="$SubCode-$SubName-Registered";	
		
	$sid_sql="Select Course_Registration.Sub_ID,
 	Course_Registration.Student_ID,Student_Info.Student_Name,Student_Info.C_Roll_Number,
	Student_Info.C_USN,Student_Info.Program from Course_Registration
	Left JOIN Student_Info ON Course_Registration.Student_ID= Student_Info.Student_ID 
	where Course_Registration.Course_Date='$C_Date' and Course_Registration.Sub_ID='$Sub_ID' 
	ORDER BY `Course_Registration`.`Student_ID` ASC  ";
	
     	$query= $dbh -> prepare($sid_sql);
	$query-> execute();
    	$Fresult=$query->fetchAll(PDO::FETCH_OBJ);
    	
    	?>
    	
    	
    	  <div class="col-12">
            <div class="card card-primary" >
              <div class="card-header" style="background:orange">
              <span style="color:black;font-weight:bold;">Students Registered To - <?php echo $SubCode; ?></span>
              
              
               <button type="button" id="dwn" class="btn btn-primary float-right" style="margin-right: 5px;" 
               onClick="tableToExcel('testTable1','Student' ,'<?php echo $FileName.".xls"; ?>')">
                    <i class="fas fa-download"></i> Download As Excel
                  </button>
              </div>
              <!-- /.card-header -->
              
               <style>
		 #testTable1 td,th{
		  border: 1px solid #ddd;
		 }
		 </style>
              
             
              
              <!--   Fetch and display  -->
            
              
              
              <div class="card-body table-responsive p-0" style="height: 400px;" >
		
		 <!-- 4 -->
            
                <table class="table table-head-fixed table-hover text-nowrap" id="testTable1">
                
                  <thead>
                      <tr>
                      <th id="a1" onclick="sortTable('#a1')">Sl.No</th>
                      <th id="a2" onclick="sortTable('#a2')">USN No</th>
                      <th id="a3" onclick="sortTable('#a3')">Roll No</th>
                      <th id="a4" onclick="sortTable('#a4')">Name</th>
                      <th id="a4" onclick="sortTable('#a4')">Branch</th>
                    </tr>
                  </thead>
                  
                  
                  <tbody id="TBODY">
                  
                  	<?php 
                  	$i=1;  			
    			foreach($Fresult as $Fres)
			{
			
			?>
			<tr>
			<td><?php echo $i; $i=$i+1; ?></td>
                      	<td><?php echo $Fres->C_USN  ; ?></td>
  			<td><?php echo $Fres->C_Roll_Number  ; ?></td>
  			<td><?php echo $Fres->Student_Name  ; ?></td>
  			<td><?php echo $Fres->Program  ; ?></td>
  			</tr>
                      	<?php
                      	}
                      	
                  	
			?>
                      
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
		
	<?php
	}
	
}
//$query->close;
//$dbh=null;
?>
