<?php

// Already There in Add Attendance 

/* $Faculty_ID=$_SESSION['F_ID'];
  
  $C_Date = $_POST['C_Date'];
  $Exam_Type = $_POST['Exam_Type'];
  $FS_ID = $_POST['Subject'];
  $L_Batch = $_POST['L_Batch'];
  $A_Date = $_POST['A_Date'];
  $Period = $_POST['Period'];
  $Att = $_POST['Att'];
 
  $sqla ="SELECT * FROM Faculty_Subjects where FS_ID='$FS_ID' ";
  $querya= $dbh -> prepare($sqla);
  $querya-> execute();
  $rowa = $querya->fetch();
  $Sub_ID=$rowa['Sub_ID'];
  $Section=$rowa['Section'];
  -------------------------------------*/


$sqlz="delete from Total_Attendance where FS_ID='$FS_ID'";
  	$queryz = $dbh->prepare($sqlz);
	$queryz->execute();

		
		
//check For Regular+Core+Lab or not 
$sqlb ="SELECT * FROM Course_Subjects where Sub_ID='$Sub_ID' ";
$queryb= $dbh -> prepare($sqlb);
$queryb-> execute();
$rowb = $queryb->fetch();
$Exam_Type=$rowb['Exam_Type'];
$Sub_Type=$rowb['Subject_Type'];
$Th_Pract=$rowb['Th_Pract'];
$Sub_Name=$rowb['Subject_Name'];
$Sub_Code=$rowb['Subject_Code'];
$Sub_Branch=$rowb['Branch'];
$Sub_Sem=$rowb['Sem'];

		$sql = "select Att_Date,Period,LBatch from Subject_Handled where FS_ID='$FS_ID'";

               
      		$sql_mid1=""; $sql_mid2="";
    	  	$sql3="Select SI.Student_ID,SI.LBatch from 
    	  	Course_Registration as CR ,Student_Info as SI ";
    	  	
    	  	if($Exam_Type=="Regular" and $Sub_Type=="Core"){
    	  	$sql_mid1="and SI.Section='$Section' ";
    	  	}
    	  	
    	  	if($L_Batch>=1){ 
    	  	$sql3=$sql3." ";
    	  	$sql_mid2="and SI.LBatch='$L_Batch' ";
    	  	}
    	  	$sql3=$sql3." where CR.Sub_ID='$Sub_ID' ";
    	  	
    	  	
    	  	$sql_end="and CR.Student_ID=SI.Student_ID  group by SI.Student_ID ";
    	  	
    	  	$sql3= $sql3.$sql_mid1.$sql_mid2.$sql_end;
    	  	
    	  	
		$queryIn= $dbh -> prepare($sql3);
    	  	$queryIn-> execute();
    	  	$countIn = $queryIn->rowCount();
    	  	$rowsAll=$queryIn->fetchAll(PDO::FETCH_OBJ);
    	  	
    	  	$slno=0;
    	  	$TotClass=0;
    	  	$TotalAbsent=0;
    		foreach($rowsAll as $resIn)
    		{  
    		
    			$slno=$slno+1;
    		
    			$Std_id=$resIn->Student_ID;
    			$Std_LB=$resIn->LBatch;
    			
    			
    			$sql4= "select Att_Date,Period,LBatch from Subject_Handled where FS_ID='$FS_ID'";
			$query4= $dbh -> prepare($sql4);
    	  		$query4-> execute();
    	  		$count4 = $query4->rowCount();
    	  		$rows4=$query4->fetchAll(PDO::FETCH_OBJ); 
    	  		
    	  		$TotClass=$count4;
    	  		
    			$sql5= "select SAtt_ID from Student_Attendance where Student_ID='$Std_id' and Sub_ID='$Sub_ID'";
			$query5= $dbh -> prepare($sql5);
    	  		$query5-> execute();
    	  		$count5 = $query5->rowCount();
    	  		
    	  		$TotalAbsent=$count5;  
    		
    		  $TotC=0;     
    		  $TotP=0;
    		  $TotPer=0;
    		  if($TotClass>0)
    		  {    
    		  $TotC= $TotClass;
    		  $TotP=$TotClass - $TotalAbsent;
    		  $TotPer= ( $TotP * 100)/$TotClass;
    		  $TotPer=round($TotPer,2); 
    		  }  
    		  
    		$sql3="insert into Total_Attendance(Course_Date,Student_ID,Faculty_ID,FS_ID,Sub_ID,LBatch,Total_Class,Total_Present)  
			values('$C_Date','$Std_id','$Faculty_ID','$FS_ID','$Sub_ID','$L_Batch','$TotC','$TotP')";
		$query3 = $dbh->prepare($sql3);
		$query3->execute();
    		      
    	    }
    		
    		?>
    		
  			
                

