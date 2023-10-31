<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Admin.php");
require_once('../PrintPDF/tcpdf_include.php');


$Faculty_ID=$_SESSION['F_ID'];
$Faculty_Name=$_SESSION['F_Name'];

if($_POST)
{

/*  PDF Report Generating START  */


/*

select Course_Registration.Student_ID,Course_Registration.Sub_ID, Course_Subjects.Subject_Code,Course_Subjects.Subject_Name, Total_Attendance.Total_Class,Total_Attendance.Total_Present from Course_Registration Left JOIN Course_Subjects ON Course_Registration.Sub_ID= Course_Subjects.Sub_ID Left JOIN Total_Attendance ON Course_Registration.Student_ID=Total_Attendance.Student_ID 



*/




$C_Date=$_POST['C_Date'];
$Occasion=$_POST['Occasion'];
$FileName=$C_Date."_".$Occasion;

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
		//$this->SetY(-15);
		// Set font
		//$this->SetFont('helvetica', '', 12);
		// Page number
		//$this->Cell(0, 20, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
		//$this->Cell(0, 20, 'Signature', 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
		
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
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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


$sqla ="SELECT Student_ID FROM Course_Registration where Course_Date='$C_Date' group by Student_ID ";
$querya= $dbh -> prepare($sqla);
$querya-> execute();
$results1=$querya->fetchAll(PDO::FETCH_OBJ);
    
foreach($results1 as $res1)
{
  $Stud_ID  = $res1->Student_ID ;
  
  $sqlb ="SELECT Student_Name,C_Roll_Number,C_USN,Sem,P_Address,P_Post,P_Taluk,P_District,P_State,P_Pin FROM Student_Info 
  where Student_ID='$Stud_ID'";
  $queryb= $dbh -> prepare($sqlb);
  $queryb-> execute();
  $rowb = $queryb->fetch();
  $Stud_Name=$rowb['Student_Name'];  $Stud_Roll=$rowb['C_Roll_Number'];
  $Stud_USN=$rowb['C_USN'];        
  
  if($Stud_USN==""){$Stud_USN=$Stud_Roll;}
  $Stud_Sem=$rowb['Sem'];
  $P_Address=str_replace("\n","<br>",$rowb['P_Address']);     
  $P_Post=$rowb['P_Post'];           $P_Taluk=$rowb['P_Taluk'];   
  $P_District=$rowb['P_District'];   $P_State=$rowb['P_State'];         $P_Pin=$rowb['P_Pin'];
  
  
$Par1="<hr>
<span style=\"font-size:14px;color:black;\">Phone: 08258-281264</span>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Date: $tdy</span>

<h3 style=\"text-align:center;font-weight:bold;font-size:18px;color:blue;\">PROGRESS REPORT</h3>

<p align=\"justify\" style=\"font-size:14px;solid black;\">
To,<br>
$P_Address<br>
$P_Taluk, $P_District<br>
$P_State<br>
$P_Post-$P_Pin<br>
<br>
<span style=\"font-size:14px;solid black;\">Dear Parent,</span><br>
The progress report of your ward Miss/Mr $Stud_Name-$Stud_USN studying in $Stud_Sem semester is as shown below:</p>
";
 

$Par1=$Par1."<table  style=\"font-size:10px;border:1px solid black;\" border=\"1\" cellpadding=\"5\">	
	<tr>
	<th style=\"text-align:center;border:1px solid black;width:31px;\"><b>Sl.<br>No.</b></th>	
	<th style=\"text-align:center;border:1px solid black;width:300px;\"><b>SUBJECTS</b></th>
	<th style=\"text-align:center;border:1px solid black;width:45px;\"><b>Task-1</b></th>
	<th style=\"text-align:center;border:1px solid black;width:45px;\"><b>Task-2</b></th>
	<th style=\"text-align:center;border:1px solid black;width:45px;\"><b>MSE-1</b></th>
	<th style=\"text-align:center;border:1px solid black;width:45px;\"><b>MSE-2</b></th>			
	<th style=\"text-align:center;border:1px solid black;width:45px;\"><b>Classes<br>Held</b></th>
	<th style=\"text-align:center;border:1px solid black;width:50px;\"><b>Classes<br>Attended</b></th>	
	
		
	
	</tr>";
  
  $sqlc="SELECT CS.Subject_Name,CS.Subject_Code,CS.Sub_ID from
  Course_Subjects as CS,Course_Registration as CR
  WHERE CR.Student_ID='$Stud_ID' and CR.Course_Date='$C_Date' and CR.Sub_ID=CS.Sub_ID and CS.Course_Date='$C_Date'" ;     
  $queryc= $dbh -> prepare($sqlc);
  $queryc-> execute();
  $resultsc=$queryc->fetchAll(PDO::FETCH_OBJ);
  
  $slno=0;


  foreach($resultsc as $rowc)
  {     
    $slno=$slno+1;
    $s_id=$rowc->Sub_ID;
    $s_code=$rowc->Subject_Code; $s_name=$rowc->Subject_Name;
    
    $sqlh="SELECT Total_Class,Total_Present from Total_Attendance WHERE Student_ID='$Stud_ID' and Sub_ID='$s_id'" ;     
    $queryh= $dbh -> prepare($sqlh);
    $queryh-> execute();
    $rowh = $queryh->fetch();
   
    
    $tot_c=$rowh['Total_Class'];   $tot_p=$rowh['Total_Present'];
    $Att_per=($tot_p*100)/$tot_c;
    $att_sig="";
    if($Att_per<85)
    {
        $att_sig="#";
        if($Att_per<75)
        {
            $att_sig="!";
        }
    }
    
    
    
$Par1=$Par1."
<tr style=\"text-align:center;\">
<th>$slno</th>
<td style=\"text-align:left;\">$s_name</td>";


  $poor_m1="";$poor_c1;
  $poor_m2="";$poor_c2;
  $tk_1=$tk_2=$ms_1=$ms_2="";
  $tx_1=$tx_2=$mx_1=$mx_2="";
  
  $sqlf="SELECT Occasion,Mark,Max_Mark,Attendance from Student_CIA WHERE Student_ID='$Stud_ID' and Sub_ID='$s_id' " ;     
  $queryf= $dbh -> prepare($sqlf);
  $queryf-> execute();
  $resultsf=$queryf->fetchAll(PDO::FETCH_OBJ);
  foreach($resultsf as $rowd)
  {     
   
   $exmt=$rowd->Occasion;
   $e_mrk=(float)$rowd->Mark;       $e_mrk=ltrim($e_mrk, '0');      $e_mrk = rtrim($e_mrk, '.');
   $ck_att=$rowd->Attendance;
   $mx_mk=$rowd->Max_Mark;
   
   if($exmt=='TASK_1'){$tk_1=$e_mrk;$tx_1=$mx_mk; if($ck_att=="A"){$tk_1="AB";} }
   if($exmt=='TASK_2'){$tk_2=$e_mrk;$tx_2=$mx_mk; if($ck_att=="A"){$tk_2="AB";} }
 //if($exmt=='TASK_3'){$tk_3=$e_mrk;$tx_3=$mx_mk; if($ck_att=="A"){$tk_3="AB";} }
   
   if($exmt=='MSE_1') {$ms_1=$e_mrk;$mx_1=$mx_mk; 
   if($ck_att=="A"){$ms_1="AB";}else{$poor_c1=($ms_1*100)/$mx_1;
      if($poor_c1<50){$poor_m1='*';} } }
      
   if($exmt=='MSE_2') {$ms_2=$e_mrk;$mx_2=$mx_mk; 
   if($ck_att=="A"){$ms_2="AB";}else{$poor_c2=($ms_2*100)/$mx_2;
      if($poor_c2<50){$poor_m2='*';} } }

  }
 
    
$Par1=$Par1."
<td>$tk_1</td>
<td>$tk_2</td>
<td>$ms_1 $poor_m1</td>
<td>$ms_2 $poor_m2</td>
<td>$tot_c  </td>
<td>$tot_p $att_sig</td>

</tr>";
  }
  
$Par1=$Par1."</table>

<br><br>  <span style=\"font-size:14px;\"><b>Please note:</b><br>
1. The above attendance is as on : $tdy.<br>
2. As per the university norms students are expected to maintain atleast 85% attendance in each subject.<br>
3. '*' indicates poor marks, 'AB' absent for the tests, '#' attendance less than 85%,'!' attendance less than 75%.<br>
3. Please instruct your ward to improve her/his performance.<br>
4. For any further queries, please contact the coordinator.<br>
</span>

<br><br><br><br><br>
SIGNATURE OF COORDINATOR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SIGNATURE OF PRINCIPAL";

$pdf->AddPage();

$txt = <<<EOD
          $Par1
          EOD;

$pdf->writeHTML($txt, true, false, true, false, '');
ob_clean();

}

// add a page
//$pdf->AddPage('L');
// set some text to print



// print a block of text using Write()

//$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);
//$pdf->writeHTMLCell(0, 0, '', '', $txt, 0, 1, 0, true, '', true);
//$pdf->writeHTML($txt, true, false, true, false, '');
// ---------------------------------------------------------

//Close and output PDF document
//$pdf->Output($FileName.'.pdf', 'D');
//Download PDF document
$pdf->Output($FileName.'.pdf', 'I');


}
//POST ENDS
/* PDF Report Ends */ 

?>
