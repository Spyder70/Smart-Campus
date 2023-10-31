<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
//require("../Authenticate/Support.php");
require_once('../PrintPDF/tcpdf_include.php');


$Faculty_ID=$_SESSION['F_ID'];
$Faculty_Name=$_SESSION['F_Name'];

if($_POST)
{

/*  PDF Report Generating START  */


/*

select Course_Registration.Student_ID,Course_Registration.Sub_ID, Course_Subjects.Subject_Code,Course_Subjects.Subject_Name, Total_Attendance.Total_Class,Total_Attendance.Total_Present from Course_Registration Left JOIN Course_Subjects ON Course_Registration.Sub_ID= Course_Subjects.Sub_ID Left JOIN Total_Attendance ON Course_Registration.Student_ID=Total_Attendance.Student_ID 


Select Course_Registration.Student_ID, Student_Info.Student_Name,Student_Info.C_Roll_Number,Student_Info.C_USN,Student_Info.Sem, Student_Info.P_Address,Student_Info.P_State,Student_Info.P_Post,Student_Info.P_Pin, Student_Info.P_Taluk, Student_Info.P_District, Course_Registration.Sub_ID, Course_Subjects.Subject_Code,Course_Subjects.Subject_Name, Total_Attendance.Total_Class,Total_Attendance.Total_Present from Course_Registration 
Left JOIN Course_Subjects ON Course_Registration.Sub_ID= Course_Subjects.Sub_ID 
Left JOIN Student_Info ON Course_Registration.Student_ID= Student_Info.Student_ID 
Left JOIN Total_Attendance ON Course_Registration.Student_ID=Total_Attendance.Student_ID and Course_Registration.Sub_ID= Total_Attendance.Sub_ID where Course_Registration.Course_Date='$C_Date' and Student_Info.sem='$SSem' ORDER BY `Course_Registration`.`Student_ID` ASC 



*/




$C_Date=$_POST['C_Date'];
$SBranch=$_POST['Branch'];
$SSem=$_POST['Sem'];
$SSection=$_POST['Section'];

$FileName=$C_Date."_".$SBranch."Sem-".$SSem."_Section-".$SSection;

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



if($SSem<=2)
{
$LRule="</table>
<br><br>  <span style=\"font-size:14px;\"><b><u>Please note:</u></b><br>
1. The above attendance is as on : $tdy.<br>
2. As per the university norms students are expected to maintain atleast 85% attendance in each subject.<br>
3. '*' indicates poor marks, 'AB' absent for the tests, '#' attendance less than 85%,'!' attendance less than 75%.<br>
4. Please instruct your ward to improve her/his performance,You can track the performance of your ward by<br>
   visiting our website <b>nmamit.nitte.edu.in</b> Goto LIFE@NMAMIT then Parent login under Student info.<br>
   <b>Username as mobile number</b> given by you during admission time, and <b>Password as USN</b> of the ward.<br>
6. For any further queries, please contact the coordinator.<br>
</span>


<br><br><br><br>
SIGNATURE OF COORDINATOR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SIGNATURE OF PRINCIPAL";
}
else
{
$LRule="</table>
<br><br>  <span style=\"font-size:14px;\"><b><u>Please note:</u></b><br>
1. The above attendance is as on : $tdy.<br>
2. As per the university norms students are expected to maintain atleast 85% attendance in each subject.<br>
3. '*' indicates poor marks, 'AB' absent for the tests, '#' attendance less than 85%,'!' attendance less than 75%.<br>
4. Please instruct your ward to improve her/his performance,You can track the performance of your ward by<br>
   visiting our website <b>nmamit.nitte.edu.in</b> Goto LIFE@NMAMIT then Parent login under Student info.<br>
   <b>Username as mobile number</b> given by you during admission time, and <b>Password as USN</b> of the ward.<br>
6. For any further queries, please contact the Head of the Department.<br>
</span>

<br><br><br><br>
SIGNATURE OF HOD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SIGNATURE OF PRINCIPAL";
}






$sqla ="Select Course_Registration.Student_ID, Student_Info.Student_Name,Student_Info.C_Roll_Number,Student_Info.C_USN,Student_Info.Sem,
Student_Info.Section,Student_Info.Father_Name,Student_Info.P_Address,Student_Info.P_State,Student_Info.P_Post,Student_Info.P_Pin, Student_Info.P_Taluk,
Student_Info.P_District,Student_Info.C_Address,Student_Info.C_State,Student_Info.C_Post,Student_Info.C_Pin, 
Student_Info.C_Taluk, Student_Info.C_District,Course_Registration.Sub_ID,Course_Subjects.Subject_Code,
Course_Subjects.Subject_Name,Course_Subjects.Grade, Total_Attendance.Total_Class,Total_Attendance.Total_Present 
from Course_Registration 
Left JOIN Course_Subjects ON Course_Registration.Sub_ID= Course_Subjects.Sub_ID 
Left JOIN Student_Info ON Course_Registration.Student_ID= Student_Info.Student_ID 
Left JOIN Total_Attendance ON Course_Registration.Student_ID=Total_Attendance.Student_ID and Course_Registration.Sub_ID= Total_Attendance.Sub_ID where Course_Registration.Course_Date='$C_Date' and Student_Info.Sem='$SSem' 
and Student_Info.Section='$SSection' and ";

if($SBranch=="CHE" or $SBranch=="PHY")
{
$sqla =$sqla."Student_Info.Cycle='$SBranch'
ORDER BY `Course_Registration`.`Student_ID`,Course_Subjects.Grade ASC ";
}
else
{
$sqla =$sqla."Student_Info.Program='$SBranch'
ORDER BY `Course_Registration`.`Student_ID`,Course_Subjects.Grade ASC ";
}



$querya= $dbh -> prepare($sqla);
$querya-> execute();
$results1=$querya->fetchAll(PDO::FETCH_OBJ);

$Par1="";
$Flag=0;    
foreach($results1 as $res1)
{

StartA:
  if($Flag==0)
  {
  $Flag=1;  
  $Stud_ID  = $res1->Student_ID ;
  
  $Stud_Name=$res1->Student_Name;  $Stud_Roll=$res1->C_Roll_Number;
  $Stud_USN=$res1->C_USN;      
  $Stud_Section=$res1->Section;     
  
  if($Stud_USN==""){$Stud_USN=$Stud_Roll;}
  $Stud_Sem=$res1->Sem;
  $Father_name=$res1->Father_Name;
  if($res1->P_Address!="")
  {
  $P_Address=str_replace("\n","<br>",$res1->P_Address);     
  $P_Post=trim($res1->P_Post);           $P_Taluk=trim($res1->P_Taluk);   
  $P_District=trim($res1->P_District);   $P_State=trim($res1->P_State);         $P_Pin=trim($res1->P_Pin);
  }
  else
  {
  $P_Address=str_replace("\n","<br>",$res1->C_Address);     
  $P_Post=trim($res1->C_Post);           $P_Taluk=trim($res1->C_Taluk);   
  $P_District=trim($res1->C_District);   $P_State=trim($res1->C_State);         $P_Pin=trim($res1->C_Pin);
  }
  $FinalAddr="".$Father_name."<br>";

  if($P_Address!=""){$FinalAddr=$FinalAddr.$P_Address."<br>";}
  if($P_Taluk!=""){$FinalAddr=$FinalAddr.$P_Taluk.",";}
  if($P_Post!=""){$FinalAddr=$FinalAddr.$P_Post."<br>";}
  if($P_District!=""){$FinalAddr=$FinalAddr.$P_District."<br>";}   
  if($P_State!=""){$FinalAddr=$FinalAddr.$P_State."-";}
  if($P_Pin!=""){$FinalAddr=$FinalAddr.$P_Pin."<br>";} 

 
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
$FinalAddr
<br>
<span style=\"font-size:14px;solid black;\">Dear Parent,</span><br>
The progress report of your ward Miss/Mr $Stud_Name-$Stud_USN studying in $Stud_Sem semester '$Stud_Section' Section is as shown below:</p>
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
}//Flag=0 ends 






// Last Part of the Page 

if( $Stud_ID != $res1->Student_ID )
{
$Par1=$Par1.$LRule;

$pdf->AddPage();

$txt = <<<EOD
          $Par1
          EOD;

$pdf->writeHTML($txt, true, false, true, false, '');
ob_clean();

$Flag=0;

goto StartA;
} // Page Ends  move to Start







if ( $Stud_ID == $res1->Student_ID )
{

    $s_id=$res1->Sub_ID;
    $s_code=$res1->Subject_Code; $s_name=$res1->Subject_Name;
    $tot_c=$res1->Total_Class;   $tot_p=$res1->Total_Present;
    
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
<th>$Flag</th>
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
$Flag=$Flag+1;
}


} //Main Forloop 


$Par1=$Par1.$LRule;

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
//$pdf->Output($FileName.'.pdf', 'D');
//Download PDF document
$pdf->Output($FileName.'.pdf', 'D');


}
//POST ENDS
/* PDF Report Ends */ 

?>
