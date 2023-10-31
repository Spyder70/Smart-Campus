<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Faculty.php");
require_once('tcpdf_include.php');


$Faculty_ID=$_SESSION['F_ID'];
$Faculty_Name=$_SESSION['F_Name'];

if($_POST)
{

/*  PDF Report Generating START  */


$C_Date=$_POST['C_DateP'];
$FS_ID=$_POST['FS_IDP'];
$Exam_Type=$_POST['Exam_TypeP'];

$sqla ="SELECT * FROM Faculty_Subjects where FS_ID='$FS_ID' ";
$querya= $dbh -> prepare($sqla);
$querya-> execute();
$rowa = $querya->fetch();
$Sub_ID=$rowa['Sub_ID'];
$Section=$rowa['Section'];
$Finalized=$rowa['Finalized'];		
		
//check For Regular+Core+Lab or not 
$sqlb ="SELECT * FROM Course_Subjects where Sub_ID='$Sub_ID' ";
$queryb= $dbh -> prepare($sqlb);
$queryb-> execute();
$rowb = $queryb->fetch();
$Sub_Type=$rowb['Subject_Type'];
$Th_Pract=$rowb['Th_Pract'];
$Sub_Name=$rowb['Subject_Name'];
$Sub_Code=$rowb['Subject_Code'];
$Sub_Branch=$rowb['Branch'];
$Sub_Sem=$rowb['Sem'];
$Credits=$rowb['Credit'];

$sql = "select Att_Date,Period,LBatch from Subject_Handled where FS_ID='$FS_ID'";
$FileName="CIA_SHEET_".$Sub_Code;
$queryT= $dbh -> prepare($sql);
$queryT-> execute();
$countT = $queryT->rowCount();







class MYPDF extends TCPDF 
{

	//Page header
	public function Header() 
	{
	global $C_Date,$Sub_Branch,$Sub_Sem,$Section,$Sub_Name,$Sub_Code,$Faculty_Name,$Credits;
	
		// Logo
		$image_file = K_PATH_IMAGES.'logo2.jpg';
		$this->Image($image_file, 12, 5, 185, 18, 'JPG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);
		// Set font  
		$this->Ln(5);
		$this->SetFont('helvetica', 'B', 12);
		$this->Cell(0, 30, 'Continuous Internal Assessment Submission Form : '.$C_Date, 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
		

		$this->Ln(5);
		$this->SetFont('helvetica', 'B', 11);
		$this->Cell(0, 30, 'Cycle/Branch : '. $Sub_Branch, 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->Cell(0,30, 'Sem : '.$Sub_Sem.'         Section : '.$Section, 0, false, 'R', 0, '', 0, false, 'T', 'M');
		
		$this->Ln(5);
		$this->SetFont('helvetica', 'B', 11);
		$this->Cell(0, 30, 'Course Name : '. $Sub_Name, 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->Cell(0,30, 'Course Code : '.$Sub_Code         , 0, false, 'R', 0, '', 0, false, 'T', 'M');
		
		$this->Ln(5);
		$this->SetFont('helvetica', 'B', 11);
		$this->Cell(0, 30, 'Faculty Name : '.$Faculty_Name, 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->Cell(0,30, 'Credits : '.$Credits         , 0, false, 'R', 0, '', 0, false, 'T', 'M');
		$this->Ln(5);
		 
        	
	}

	// Page footer
	public function Footer() 
	{
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', '', 12);
		/* Page number
	        $this->Cell(0, 20, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(),
	        0, false, 'C', 0, '', 0, false, 'T', 'M');  */
	
		$this->Cell(0,20, 'NAME AND SIGNATURE OF FACULTY                    
		VERIFIED BY :', 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->Cell(0,20, 'SIGNATURE OF THE HOD'         , 0, false, 'R', 0, '', 0, false, 'T', 'M');
		//$this->Cell(0,20, 'VERIFIED BY :'                , 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
		
	}
}


// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NMAMIT NITTE');
$pdf->SetTitle('PDF Report');
$pdf->SetSubject('Smart Campus');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP+18, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);




// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) 
{
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 12);
$pdf->AddPage(L);


$table_start="";
$table_data="";

	     




               $sql_mid1=""; $sql_mid2="";
    	  	$sql3="Select SI.Student_ID,SI.C_Roll_Number,SI.C_USN,SI.Student_Name from 
    	  	Course_Registration as CR ,Student_Info as SI ";
    	  	
    	  	if($Exam_Type=="Regular" and $Sub_Type=="Core"){
    	  	$sql_mid1="and SI.Section='$Section' ";
    	  	}
    	  	
    	  	/*if($Th_Pract=="P"){ 
    	  	$sql3=$sql3." , Lab_Slot as LS ";
    	  	$sql_mid2="and LS.LBatch='$L_Batch' and LS.Student_ID=SI.Student_ID and  LS.Student_ID=CR.Student_ID ";
    	  	}*/
    	  	$sql3=$sql3." where CR.Sub_ID='$Sub_ID' ";
    	  	
    	  	
    	  	$sql_end="and CR.Student_ID=SI.Student_ID  order by SI.C_USN,SI.C_Roll_Number ";
    	  	
    	  	$sql3= $sql3.$sql_mid1.$sql_mid2.$sql_end;
    	  	
    	  	
		$queryIn= $dbh -> prepare($sql3);
    	  	$queryIn-> execute();
    	  	$countIn = $queryIn->rowCount();
    	  	$rowsAll=$queryIn->fetchAll(PDO::FETCH_OBJ);
    	  	
    	  	
    	  	$table_start = " <table  style='font-size:15px;border:2px solid black;' border='1' cellpadding='5'>
                                   <thead>
                                   <tr nobr='true' style='text-align:center;'>
                                   <th width='4px'>Sl.<br>No</th>
                                   <th width='5px'>Roll<br>Number</th>
                                   <th width='10px'>USN</th>
                                   <th >Name</th>
                                   <th width='5px'>Lab<br>Batch</th>
                                   <th width='5px'>Attendance<br>out of $countT (%)</th>
                                   <th width='5px'>Task1<br>(Max:5)</th>
                                   <th width='5px'>Task2<br>(Max:5)</th>
                                   <th width='5px'>MSE1<br>(Max:20)</th>
                                   <th width='5px'>MSE2<br>(Max:20)</th>
                                   <th width='5px'>Total<br>(Max:50)</th>
                                   <th width='5px'>Remarks<br>(W/NE)</th>
                     
                                   </tr>
                                   </thead><tbody>";
    	  	
    	  	$slno=0;
    		foreach($rowsAll as $resIn)
    		{  
    		
    			$slno=$slno+1;
    			$Std_id=$resIn->Student_ID;
    			$Std_USN=$resIn->C_USN;
    			$Std_Roll=$resIn->C_Roll_Number;
    			$Std_Name=$resIn->Student_Name;
    			
    			$sql3b ="SELECT LBatch FROM Lab_Slot where Student_ID='$Std_id' ";
			$query3b= $dbh -> prepare($sql3b);
			$query3b-> execute();
			$row3b = $query3b->fetch();
			$Std_LB=$row3b['LBatch'];
			
    			
    			$sql4= "select Att_Date,Period,LBatch from Subject_Handled where FS_ID='$FS_ID'";
			$query4= $dbh -> prepare($sql4);
    	  		$query4-> execute();
    	  		$count4 = $query4->rowCount();
    	  		$rows4=$query4->fetchAll(PDO::FETCH_OBJ); 
    	  		
    	  		$Theory_tot=0;
    	  		$Lab_tot=0;
    	  		
    	  		$Theory_totA=0;
    	  		$Lab_totA=0;
    	  		
    	  		$Theory_Per=0;
    	  		$Lab_Per=0;
    	  		
    	  		foreach($rows4 as $rw4)
    			{
    			   $C_AD=$rw4->Att_Date;
    			   $C_PD=$rw4->Period;
    			   $C_LB=$rw4->LBatch;
    			   
    			   if($C_LB=="")    //if its Theory
    			   {
    			   $Theory_tot=$Theory_tot+1;
    			      	$sql5= "select SAtt_ID from Student_Attendance where
    			      	        Att_Date='$C_AD' and Period='$C_PD' and  Student_ID='$Std_id' and FS_ID='$FS_ID'";
				$query5= $dbh -> prepare($sql5);
    	  			$query5-> execute();
    	  			$count5 = $query5->rowCount();
    	  			if($count5>0)
    	  			  {/*Absent*/}
    	  			else
    	  			  $Theory_totA=$Theory_totA+1;
    	  			
    			   }
    			   else
    			   {
    			      if($Std_LB==$C_LB) // Lab Subject
    			      {
    			      $Lab_tot=$Lab_tot+1;
    			  	$sql5= "select SAtt_ID from Student_Attendance where
    			      	        Att_Date='$C_AD' and Period='$C_PD' and  Student_ID='$Std_id' and FS_ID='$FS_ID'";
				$query5= $dbh -> prepare($sql5);
    	  			$query5-> execute();
    	  			$count5 = $query5->rowCount();
    	  			if($count5>0)
    	  			  {/*Absent*/}
    	  			else
    	  			  $Lab_totA=$Lab_totA+1;
    			      }
    			      else
    			      {
    			       // Not in the Batch 
    			      }
    			   
    			   }
    		       }
    		       
    		  $Theory_Per= ($Theory_totA * 100)/$Theory_tot;
    		  $Theory_Per=round($Theory_Per,2);   
    		  
    		  $Lab_Per= ($Lab_totA * 100)/$Lab_tot;
    		  $Lab_Per=round($Lab_Per,2); 
    		  
    		  $T1_M=0;  $T2_M=0;  $M1_M=0;  $M2_M=0;
    		  $sql4c ="SELECT Occasion,Mark from Student_CIA WHERE Student_ID='$Std_id' and FS_ID='$FS_ID'";
		  $query4c= $dbh -> prepare($sql4c);
		  $query4c-> execute();
    		  $rows4c=$query4c->fetchAll(PDO::FETCH_OBJ); 
    		  foreach($rows4c as $rw4c)
    		  {
    		  $exmt=$rw4c->Occasion;
    			   if($exmt=='TASK_1') { $T1_M=$rw4c->Mark; }
    			   if($exmt=='TASK_2') { $T2_M=$rw4c->Mark; }
    			   if($exmt=='MSE_1')  { $M1_M=$rw4c->Mark; }
    			   if($exmt=='MSE_2')  { $M2_M=$rw4c->Mark; }   
    		  }
    		  $Std_Mark=$T1_M+$T1_M+$M1_M+$M1_M;
    		      
    		 
    		  if($Theory_tot>0)
    		  {
    		     if($Theory_Per<75 or $Std_Mark<20){ $Std_Status="NE"; }
    		   
    		     
                           $table_start =  $table_start. "<tr nobr='true' >
                                   <tr nobr='true' >
                                   <td> $slno    </td>
                                   <td> $Std_Roll</td>
                                   <td> $Std_USN </td>
                                   <td> $Std_Name</td>
                                   <td> $Std_LB  </td>
                                   <td> $Theory_Per </td>
                                   <td> $T1_M    </td>
                                   <td> $T2_M    </td>
                                   <td> $M1_M    </td>
                                   <td> $M2_M    </td>
                                   <td> $Std_Mark</td>
                                   <td> $Std_Status</td>
                                   </tr> ";
                            
    		   
    		  }
    		  else if($Lab_tot>0)
    		  {
    		       if($Lab_Per<75 or $Std_Mark<20){ $Std_Status="NE"; }
    		       
    		        
                            $table_start =  $table_start. "
                                   <tr nobr='true' >
                                   <td> $slno    </td>
                                   <td> $Std_Roll</td>
                                   <td> $Std_USN </td>
                                   <td> $Std_Name</td>
                                   <td> $Std_LB  </td>
                                   <td> $Lab_Per </td>
                                   <td> $T1_M    </td>
                                   <td> $T2_M    </td>
                                   <td> $M1_M    </td>
                                   <td> $M2_M    </td>
                                   <td> $Std_Mark</td>
                                   <td> $Std_Status</td>
                                   </tr> ";
    		   
    		  }
    		  
    		 
    		 
            }

$table_start=$table_start." </tbody></table>";
$txt = <<<EOD
          $table_start
       EOD;
    		  $pdf->writeHTML($txt, true, false, true, false, '');
    		  ob_clean();


// add a page
//$pdf->AddPage('L');
// set some text to print



// print a block of text using Write()

//$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
//$pdf->writeHTMLCell(0, 0, '', '', $txt, 0, 1, 0, true, '', true);
//$pdf->writeHTML($txt, true, false, true, false, '');
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output($FileName.'.pdf', 'I');


}
//POST ENDS
/* PDF Report Ends */ 

?>
