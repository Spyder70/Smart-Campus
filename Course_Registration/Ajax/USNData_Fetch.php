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
          	Course_Date='$C_Date' and Sem='$Sem' and Exam_Type='$Exam_Type' group by Branch order by Branch asc";
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
	if($_POST['Fetch']=="ShowUSN")
	{
		$C_Date = $_POST['C_Date'];
		$Sem = $_POST['Sem'];
		$Branch = $_POST['Branch'];
		$Exam_Type = $_POST['Exam_Type'];
		
		if( ($Branch=='PHY' or $Branch=='CHE') and ($Sem<=2))
		{
		$str_lst=" and S1.Cycle='$Branch' order by S1.C_USN,S1.C_Roll_Number asc";
		}
		else
		{
		$str_lst=" and S1.Program='$Branch' order by S1.C_USN,S1.C_Roll_Number asc";
		}
		
		$sql ="Select S1.Student_ID,S1.C_USN,S1.C_Roll_Number
		from Student_Info as S1 Where S1.Sem='$Sem'";
                       
        	$sql= $sql.$str_lst;
     
     		$query= $dbh -> prepare($sql);
		$query-> execute();
    		$Fresult=$query->fetchAll(PDO::FETCH_OBJ);
	
    		?>
    		<option selected="selected"></option>
    		<?php
    		foreach($Fresult as $Fres)
    		{  ?>
    		<option value="<?php echo $Fres->Student_ID;?>"> 
    		<?php if($Fres->C_USN=="") {
    		echo $Fres->C_Roll_Number;}else{
    		echo $Fres->C_USN;}?> </option>
    		<?php 
    		} 
		
	}
	
	/****************/
	
	if($_POST['Fetch']=="Add_Ele")
	{
	$TopCh=1;
	$C_Date = $_POST['C_Date'];
	$Sem = $_POST['Sem'];
	$Branch = $_POST['Branch'];
	$Exam_Type = $_POST['Exam_Type'];
	$Studid = $_POST['Studid'];
	$Sub_ID=$_POST['subid'];
	
	$sqlE="Select Student_ID from Course_Registration where Course_Date='$C_Date' and Sub_ID='$Sub_ID' and Student_ID='$Studid'";
	$queryE = $dbh->prepare($sqlE);	
	$queryE->execute();
	$ENO = $queryE->rowCount();
	if($ENO==0)
	{
	   $sqlA ="insert into Course_Registration (Course_Date,Sub_ID,Student_ID) values('$C_Date','$Sub_ID','$Studid')";
	   $queryA= $dbh -> prepare($sqlA);
	   $queryA-> execute();
	}
	exit;
	}
	if($_POST['Fetch']=="Remove_Ele")
	{
	$TopCh=-1;
	$C_Date = $_POST['C_Date'];
	$Sem = $_POST['Sem'];
	$Branch = $_POST['Branch'];
	$Exam_Type = $_POST['Exam_Type'];
	$Studid = $_POST['Studid'];
	$Sub_ID=$_POST['subid'];
	
	$sqlA ="delete from Course_Registration where  Student_ID='$Studid' and Sub_ID='$Sub_ID' and Course_Date='$C_Date'";
	$queryA= $dbh -> prepare($sqlA);
	$queryA-> execute();

        $sqlA ="delete from Student_Attendance where  Student_ID='$Studid' and Sub_ID='$Sub_ID' and Course_Date='$C_Date'";
	$queryA= $dbh -> prepare($sqlA);
	$queryA-> execute();
	
	$sqlA ="delete from Student_CIA where  Student_ID='$Studid' and Sub_ID='$Sub_ID' and Course_Date='$C_Date'";
	$queryA= $dbh -> prepare($sqlA);
	$queryA-> execute();
	
	$sqlA ="delete from Total_Attendance where  Student_ID='$Studid' and Sub_ID='$Sub_ID' and Course_Date='$C_Date'";
	$queryA= $dbh -> prepare($sqlA);
	$queryA-> execute();
	exit;
	}
	
	/****************/
	
	if($_POST['Fetch']=="ShowSubjects")
	{
		$C_Date = $_POST['C_Date'];
		$Sem = $_POST['Sem'];
		$Branch = $_POST['Branch'];
		$Exam_Type = $_POST['Exam_Type'];
		$Studid = $_POST['Studid'];
		
          	$sid_sql="Select Sub_ID,Subject_Code,Subject_Name,Credit,Th_Pract from Course_Subjects where Course_Date='$C_Date' and
                 Exam_Type='$Exam_Type' and Branch='$Branch' and Sem='$Sem' and Subject_Type='Core'";
		$sid_query= $dbh -> prepare($sid_sql);
		$sid_query-> execute();
		$Cresult=$sid_query->fetchAll(PDO::FETCH_OBJ); 
		
		$sid_sql="Select Sub_ID,Subject_Code,Subject_Name,Credit,Th_Pract from Course_Subjects where Course_Date='$C_Date' and
                 Exam_Type='$Exam_Type' and Branch='$Branch' and Sem='$Sem' and Subject_Type='Elective'";
		$sid_query= $dbh -> prepare($sid_sql);
		$sid_query-> execute();
		$Eresult=$sid_query->fetchAll(PDO::FETCH_OBJ);
		
		$sid_sql="Select Sub_ID,Subject_Code,Subject_Name,Credit,Th_Pract from Course_Subjects where Course_Date='$C_Date' and
                 Exam_Type='$Exam_Type'  and Sem='$Sem' and Subject_Type='Global Elective'";
		$sid_query= $dbh -> prepare($sid_sql);
		$sid_query-> execute();
		$Gresult=$sid_query->fetchAll(PDO::FETCH_OBJ);
		
		
    		?>
    		
    	<div class="col-6">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><b> Core Subjects of <?php echo "$Branch $Sem-Sem"; ?> </b></h3>
		
              </div>
              <!-- /.card-header -->
              
         
              <div class="card-body table-responsive p-0" style="height: 400px;font-size:12px;">
                
                <table class="table table-head-fixed table-hover text-nowrap" id="mt1">
                 <thead style="cursor: pointer;">
                    <tr>
                      <th id="a1" onclick="sortTable('#a1')">Select</th>
                      <th id="a2" onclick="sortTable('#a2')">Sub_Code</th>
                      <th id="a3" onclick="sortTable('#a3')">Subject Name</th>
                      <th id="a4" onclick="sortTable('#a4')">Credits</th>
                    </tr>
                  </thead>
                  
                  
                  <tbody id="TBODY">
                  
                  	<?php   			
    			foreach($Cresult as $Cres)
			{
			echo "<tr>";
			
			$Sub_ID=$Cres->Sub_ID;
	 		$sid_sql="Select count(*) as STot from Course_Registration where 
	 		Course_Date='$C_Date' and Student_ID='$Studid' and Sub_ID ='$Sub_ID'";
	 		$sid_query= $dbh -> prepare($sid_sql);
	 		$sid_query-> execute();
	 		$ct = $sid_query->fetch();
	 		$Found=$ct['STot'];
	 		
	 		if($Found == 1){
			?>
                       <td><input type="checkbox" id="<?php echo $Sub_ID;?>" value="<?php echo $Sub_ID;?>" onclick="AdRm_sub('<?php echo $Sub_ID;?>')" checked /> </td>
                       <?php } else { ?>
                       <td><input type="checkbox" id="<?php echo $Sub_ID;?>" value="<?php echo $Sub_ID;?>" onclick="AdRm_sub('<?php echo $Sub_ID;?>')"  /></td>
                        <?php } ?>
                     
                      	
                      	<td><?php echo $Cres->Subject_Code  ; ?></td>
  			<td><?php echo $Cres->Subject_Name  ; ?></td>
  			<td><?php echo $Cres->Credit  ; ?></td>
  			
                      	<?php
                      	echo "</tr>";
                      	}
                  	
			?>
                      
                    
                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          
          
          
          
          
          
        
    
          <div class="col-6">
            <div class="card card-lime">
              <div class="card-header">
                <h3 class="card-title"><b> Global/Elective Subjects of <?php echo $Branch." $Sem-Sem"; ?></b></h3>
               
		
              </div>
              <!-- /.card-header -->
              
              
              <div class="card-body table-responsive p-0" style="height: 400px;font-size:12px;">
              
                <table class="table table-head-fixed table-hover text-nowrap" id="mt2">
                 <thead style="cursor: pointer;">
                    <tr>
                      <th id="a1" onclick="sortTable('#a1')">Select</th>
                      <th id="a2" onclick="sortTable('#a2')">Sub_Code</th>
                      <th id="a3" onclick="sortTable('#a3')">Subject Name</th>
                      <th id="a4" onclick="sortTable('#a4')">Credits</th>
                    </tr>
                  </thead>
                  
                  
                  <tbody id="TBODY">
                  
                  	<?php   			
    			foreach($Eresult as $Eres)
			{
			echo "<tr>";
			
			$Sub_ID=$Eres->Sub_ID;
	 		$sid_sql="Select count(*) as STot from Course_Registration where 
	 		Course_Date='$C_Date' and Student_ID='$Studid' and Sub_ID ='$Sub_ID'";
	 		$sid_query= $dbh -> prepare($sid_sql);
	 		$sid_query-> execute();
	 		$ct = $sid_query->fetch();
	 		$Found=$ct['STot'];
	 		
	 		if($Found == 1){
			?>
                       <td><input type="checkbox" id="<?php echo $Sub_ID;?>" value="<?php echo $Sub_ID;?>" onclick="AdRm_sub('<?php echo $Sub_ID;?>')" checked /> </td>
                       <?php } else { ?>
                       <td><input type="checkbox" id="<?php echo $Sub_ID;?>" value="<?php echo $Sub_ID;?>" onclick="AdRm_sub('<?php echo $Sub_ID;?>')"  /></td>
                        <?php } ?>
                     
                      	
                      	<td><?php echo $Eres->Subject_Code  ; ?></td>
  			<td><?php echo $Eres->Subject_Name  ; ?></td>
  			<td><?php echo $Eres->Credit  ; ?></td>
  			
                      	<?php
                      	echo "</tr>";
                      	}
                  	
			?>
			
			<tr><th colspan='4'><center>Global Electives</center></th></tr>
			<?php   
						
    			foreach($Gresult as $Gres)
			{
			echo "<tr>";
			
			$Sub_ID=$Gres->Sub_ID;
	 		$sid_sql="Select count(*) as STot from Course_Registration where 
	 		Course_Date='$C_Date' and Student_ID='$Studid' and Sub_ID ='$Sub_ID'";
	 		$sid_query= $dbh -> prepare($sid_sql);
	 		$sid_query-> execute();
	 		$ct = $sid_query->fetch();
	 		$Found=$ct['STot'];
	 		
	 		if($Found == 1){
			?>
                       <td><input type="checkbox" id="<?php echo $Sub_ID;?>" value="<?php echo $Sub_ID;?>" onclick="AdRm_sub('<?php echo $Sub_ID;?>')" checked /> </td>
                       <?php } else { ?>
                       <td><input type="checkbox" id="<?php echo $Sub_ID;?>" value="<?php echo $Sub_ID;?>" onclick="AdRm_sub('<?php echo $Sub_ID;?>')"  /></td>
                        <?php } ?>
                     
                      	
                      	<td><?php echo $Gres->Subject_Code  ; ?></td>
  			<td><?php echo $Gres->Subject_Name  ; ?></td>
  			<td><?php echo $Gres->Credit  ; ?></td>
  			
                      	<?php
                      	echo "</tr>";
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
