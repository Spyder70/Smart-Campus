<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Admin.php");
require_once('../PrintPDF/tcpdf_include.php');


$Faculty_ID=$_SESSION['F_ID'];
$Faculty_Name=$_SESSION['F_Name'];
$Std_ID=$_SESSION['Get_print'];
if(isset($_SESSION['Get_print']))
{

/*  PDF Report Generating START  */





class MYPDF extends TCPDF 
{

	//Page header
	public function Header() 
	{
	        global $C_Date,$Sub_Branch,$Sub_Sem,$Section,$Sub_Name,$Sub_Code,$Faculty_Name,$Credits;
		// Logo
		$image_file = K_PATH_IMAGES.'logo2.jpg';
		$this->Image($image_file, 12, 5, 185, 18, 'JPG', '', 'T', false, 200, 'C', false, false, 0, false, false, false);
		// Set font  
		//$this->Ln(5);
		
		$this->SetFont('helvetica', 'B', 12);
		
		 
        	
	}

	// Page footer
	public function Footer() 
	{
		// Position at 15 mm from bottom
		$this->SetY(-20);
		// Set font
		$this->SetFont('helvetica', '', 12);
		/* Page number
	        $this->Cell(0, 20, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(),
	        0, false, 'C', 0, '', 0, false, 'T', 'M');  */
	
		$this->Cell(0,20, 'NAME AND SIGNATURE OF PARENT', 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->Cell(0,20, 'SIGNATURE OF STUDENT'         , 0, false, 'R', 0, '', 0, false, 'T', 'M');
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
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP-3, PDF_MARGIN_RIGHT-4);
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

$date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
//$tdytm=$date->format('d-M-Y H:i:s a');
$tdy=$date->format('d/M/Y');


$sqla ="SELECT *  FROM Student_Info where Student_ID='$Std_ID'";
$querya= $dbh -> prepare($sqla);
$querya-> execute();
$results1=$querya->fetchAll(PDO::FETCH_OBJ);
    
foreach($results1 as $res1)
{

  $Stud_ID  = $res1->Student_ID ;
  $Stud_Name  = $res1->Student_Name ;
  $FileName=$Stud_Name;
  $Dept=$res1->Dept_Name;  			$Program=$res1->Program;  		$Admission_Type=strtoupper($res1->Admission_Type);  
  $Admission_Quota=$res1->Admission_Quota;	$Allotted_Category=$res1->Allotted_Category;	$CET_COMEDK_Order=$res1->CET_COMEDK_Order;
  $CET_COMEDK_TAT=$res1->CET_COMEDK_TAT;	$CET_COMEDK_Rank=$res1->CET_COMEDK_Rank;  	$CET_COMEDK_Date=$res1->CET_COMEDK_Date;
  $CET_COMEDK_Fee=$res1->CET_COMEDK_Fee;  	$College_Fee=$res1->College_Fee;  		$DOJ=$res1->DOJ;  
  $Batch=$res1->Batch;  			$Gender=$res1->Gender;				$Blood=$res1->Blood;  
  $Aadhaar=$res1->Aadhaar;  			$DOB=$res1->DOB;  				$Religion=$res1->Religion;  
  $Caste=$res1->Caste;				$Category=$res1->Category;  			$Mother_Tongue=$res1->Mother_Tongue;
  $State_Domicile=$res1->State_Domicile;  	$Father_Name=$res1->Father_Name;  	$Father_Designation=$res1->Father_Designation;
  $Father_Income=$res1->Father_Income;  	$Mother_Name=$res1->Mother_Name; 	$Mother_Designation=$res1->Mother_Designation;
  $Mother_Income=$res1->Mother_Income;  	$Father_Mob=$res1->Father_Mob;	$Father_Email=$res1->Father_Email;
  $Mother_Mob=$res1->Mother_Mob;  		$Mother_Email=$res1->Mother_Email;  	$Guardian_Mob=$res1->Guardian_Mob;
  $Guardian_Email=$res1->Guardian_Email;	$Student_Mob=$res1->Student_Mob;  	$Student_Email=$res1->Student_Email;
  $C_Address=$res1->C_Address;  		$C_Post=$res1->C_Post;  		$C_Taluk=$res1->C_Taluk;
  $C_District=$res1->C_District;  		$C_State=$res1->C_State;  		$C_Pin=$res1->C_Pin;  
  $P_Address=$res1->P_Address;  		$P_Post=$res1->P_Post;			$P_Post=$res1->P_Post;
  $P_Taluk=$res1->P_Taluk;			$P_District=$res1->P_District;	$P_State=$res1->P_State;
  $P_Pin=$res1->P_Pin;				$Q_Course=$res1->Q_Course;		$Q_Reg_No=$res1->Q_Reg_No;
  $College_Name=$res1->College_Name;		$Pass_Year=$res1->Pass_Year;		$Area_type=$res1->Area_type;
  $Board_Name=$res1->Board_Name;		$Board_State=$res1->Board_State;	$Leaving_Date=$res1->Leaving_Date;
  $Total_Max=$res1->Total_Max;		$Total_Obtain=$res1->Total_Obtain;	$Total_Percent=$res1->Total_Percent;
  $P_Max=$res1->P_Max;				$C_Max=$res1->C_Max;			$M_Max=$res1->M_Max;
  $E_Max=$res1->E_Max;				$Tot_PCM_Max=$res1->Tot_PCM_Max;	$P_Obtain=$res1->P_Obtain;
  $C_Obtain=$res1->C_Obtain;			$M_Obtain=$res1->M_Obtain;		$E_Obtain=$res1->E_Obtain;
  $Tot_PCM_Obtain=$res1->Tot_PCM_Obtain;	$PCM_Percent=$res1->PCM_Percent;			
  
/*  
  $P_Address=str_replace("\n","<br>",$rowb['P_Address']);     
  $P_Post=$rowb['P_Post'];           $P_Taluk=$rowb['P_Taluk'];   
  $P_District=$rowb['P_District'];   $P_State=$rowb['P_State'];         $P_Pin=$rowb['P_Pin'];
  */
  $FinalAddr="";
  $FinalAddrC="";
  if($P_Address!=""){$FinalAddr=$FinalAddr.$P_Address."<br>";}
  if($P_Taluk!=""){$FinalAddr=$FinalAddr.$P_Taluk.",";}
  if($P_Post!=""){$FinalAddr=$FinalAddr.$P_Post."<br>";}
  if($P_District!=""){$FinalAddr=$FinalAddr.$P_District."<br>";}   
  if($P_State!=""){$FinalAddr=$FinalAddr.$P_State."-";}
  if($P_Pin!=""){$FinalAddr=$FinalAddr.$P_Pin."";} 
  
  if($C_Address!=""){$FinalAddrC=$FinalAddrC.$C_Address."<br>";}
  if($C_Taluk!=""){$FinalAddrC=$FinalAddrC.$C_Taluk.",";}
  if($C_Post!=""){$FinalAddrC=$FinalAddrC.$C_Post."<br>";}
  if($C_District!=""){$FinalAddrC=$FinalAddrC.$C_District."<br>";}   
  if($C_State!=""){$FinalAddrC=$FinalAddrC.$C_State."-";}
  if($C_Pin!=""){$FinalAddrC=$FinalAddrC.$C_Pin."";} 
  
  
$Par1="<hr>
<span style=\"font-size:12px;color:black;\">Phone: 08258-281264
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Date of Join: $DOJ </span><br>

<span style=\"text-align:center;\"><b>$Stud_Name</b></span><br>
Student Details :<br>
<table style=\"font-size:11px;border:1px solid black;\" cellpadding=\"5px\" border=\"1\">
<tr><td style=\"width:193px;\"><b>$Dept($Program)</b></td>
    <td style=\"width:155px;\">Admission Type: $Admission_Type</td>
    <td style=\"width:155px;\">Admission Quota: $Admission_Quota</td>
    <td style=\"width:155px;\">Allotted Category: $Allotted_Category</td>
</tr>
<tr><td>CET/COMEDK Order: $CET_COMEDK_Order</td>
    <td>CET/COMEDK TAT: $CET_COMEDK_TAT</td>
    <td>CET/COMEDK Rank: $CET_COMEDK_Rank</td>
    <td>CET/COMEDK Date: $CET_COMEDK_Date</td>
</tr>
<tr><td>CET_COMEDK_Fee: $CET_COMEDK_Fee</td>
    <td>College_Fee: $College_Fee</td>
    <td>DOJ: $DOJ</td>
    <td>Batch: $Batch</td>
</tr>
<tr><td>Aadhaar: $Aadhaar</td>
    <td>DOB: $DOB</td>
    <td>Gender: $Gender</td>
    <td>Blood: $Blood</td>
</tr>
<tr><td>Religion: $Religion</td>
    <td>Caste: $Caste</td>
    <td>Category: $Category</td>
    <td>Mother_Tongue: $Mother_Tongue</td>
</tr>
<tr><td>State_Domicile: $State_Domicile</td>
    <td>Student_Mob: $Student_Mob</td>
    <td colspan=\"2\">Student_Email: $Student_Email</td>
    
</tr>
</table>
<br><br>


Address Details :<br>
<table style=\"font-size:11px;border:1px solid black;\" cellpadding=\"5px\" border=\"1\">
<tr><th style=\"text-align:center;width:330px;\"><b>COMMUNICATION ADDRESS</b></th>
    <th style=\"text-align:center;width:330px;\"><b>PERMANENT ADDRESS</b></th>   
</tr>
<tr><td>$FinalAddr</td>
    <td>$FinalAddrC</td>
</tr>
</table>
<br><br>

Parent Details :<br>
<table style=\"font-size:11px;border:1px solid black;\" cellpadding=\"5px\" border=\"1\">

<tr><th style=\"width:300px;\">Father Name: $Father_Name</th>
    <td colspan=\"2\" style=\"width:360px;\">Father Occupation: $Father_Designation</td>
</tr>
<tr><th style=\"width:300px;\">Mother Name:$Mother_Name</th>
    <td colspan=\"2\">Mother Occupation:$Mother_Designation</td>
</tr>
<tr><td style=\"width:160px;\">Father Phone:$Father_Mob</td>
    <td style=\"width:320px;\">Father Email:$Father_Email</td>
    <td>Father Annual Income:$Father_Income</td>
</tr>
<tr><td>Mother Phone:$Mother_Mob</td>
    <td>Mother Email:$Mother_Email</td>
    <td>Mother Annual Income:$Mother_Income</td>
</tr>
<tr><td>Guardian Phone:$Guardian_Mob</td><td>Guardian Email:$Guardian_Email</td><td></td></tr>
</table> 
<br><br>


Previous Education Details :<br>
<table style=\"font-size:11px;border:1px solid black;\" cellpadding=\"5px\" border=\"1\">
<tr><td style=\"width:155px;\">Qualifying Course: <b>$Q_Course</b></td>
    <td style=\"width:155px;\">Registration No: $Q_Reg_No</td>
    <td style=\"width:193px;\">College Name: $College_Name</td>
    <td style=\"width:155px;\">Passing Year: $Pass_Year</td>
</tr>
<tr><td >Leaving Date: <b>$Leaving_Date</b></td>
    <td >Area type: $Area_type</td>
    <td >Board Name: $Board_Name</td>
    <td >Board State: $Board_State</td>
</tr>
<tr><td >Total Max Mark: <b>$Total_Max</b></td>
    <td >Obtained Total: $Total_Obtain</td>
    <td >Percentage : $Total_Percent</td>
    <td ></td>
</tr>
</table>
<br><br>

Subject-Wise Marks Details :<br>
<table style=\"font-size:11px;border:1px solid black;\" cellpadding=\"5px\" border=\"1\">
<tr style=\"text-align:center;\">
    <th style=\"width:115px;\"></th>
    <th style=\"width:85px;\"><b>PHYSICS</b></th>
    <th style=\"width:85px;\"><b>CHEMISTRY</b></th>
    <th style=\"width:85px;\"><b>MATHS</b></th>
    <th style=\"width:115px;\"><b>Total(PCM)</b></th>
    <th style=\"width:85px;\"><b>%(PCM)</b></th>
    <th style=\"width:85px;\"><b>ENGLISH</b></th>
    
</tr>
<tr style=\"text-align:center;\">
   <td><b>MAXIMUM</b></td>
   <td>$P_Max</td>
   <td>$C_Max</td>
   <td>$M_Max</td>
   <td>$Tot_PCM_Max</td>
   <td>100%</td>
   <td>$E_Max</td>
  
</tr>
<tr style=\"text-align:center;\">
   <td><b>OBTAINED</b></td>
   <td>$P_Obtain</td>
   <td>$C_Obtain</td>
   <td>$M_Obtain</td>
   <td>$Tot_PCM_Obtain</td>
   <td>$PCM_Percent</td>
   <td>$E_Obtain</td>

</tr>

</table>
<br><br>
";
 
 
 } 
  
$pdf->AddPage();

$txt = <<<EOD
          $Par1
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
