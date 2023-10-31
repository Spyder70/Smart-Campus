<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
require("../Authenticate/Faculty.php");
include_once('tcpdf_include.php');


$Faculty_ID=$_SESSION['F_ID'];
$Faculty_Name=$_SESSION['F_Name'];

if($_POST)
{
/* FROM  CIA_Report hiddent */
$C_Date=trim($_POST['C_DateP']);
$FS_ID=trim($_POST['FS_IDP']);
$Exam_Type=trim($_POST['Exam_TypeP']);

/* Printing Month-Year in CIA Sheet  */
$PMonth=$C_Date;
if($C_Date=="2022-01-27"){ $PMonth="JUNE 2022"; }
if($C_Date=="2022-08-08"){ $PMonth="DECEMBER 2022"; }

$sqla ="SELECT * FROM Faculty_Subjects where FS_ID='$FS_ID' ";
$querya= $dbh -> prepare($sqla);
$querya-> execute();
$rowa = $querya->fetch();
$Sub_ID=$rowa['Sub_ID'];
$Section=$rowa['Section'];
$L_Batch=$rowa['LBatch'];
$Finalized=$rowa['Finalized'];


$sqlb ="SELECT * FROM Course_Subjects where Sub_ID='$Sub_ID' ";
$queryb= $dbh -> prepare($sqlb);
$queryb-> execute();
$rowb = $queryb->fetch();
$Sub_Type=$rowb['Subject_Type'];
$Th_Pract=$rowb['Th_Pract'];
$Bra_Full="";
$Sub_Name=$rowb['Subject_Name'];
$Sub_Code=$rowb['Subject_Code'];
$Sub_Branch=$rowb['Branch'];
$Sub_Sem=$rowb['Sem'];
$Credits=$rowb['Credit'];
$Hours=$rowb['Hours'];

if($Sub_Branch=='MAT' || $Sub_Branch=='HUM' || $Sub_Branch=='PHY' || $Sub_Branch=='CHE' )
{
$Bra_Full=$Sub_Branch;
}
else
{
$sqldc="SELECT Course_Name  FROM Department WHERE Short_Name='$Sub_Branch'";
$querydc= $dbh -> prepare($sqldc);
$querydc-> execute();
$rowdc = $querydc->fetch();
$Bra_Full=$rowdc['Course_Name'];
}


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
	global $C_Date,$Sub_Branch,$Bra_Full,$Sub_Sem,$Section,$Sub_Name,$Sub_Code,$Faculty_Name,$Credits,$PMonth;

		// Logo
		$image_file = K_PATH_IMAGES.'logo2.jpg';
		$this->Image($image_file, 12, 5, 185, 18, 'JPG', '', 'T', false, 200, 'C', false, false, 0, false, false, false);
		// Set font
		$this->Ln(5);
		$this->SetFont('helvetica', 'B', 12);
		$this->Cell(0, 30, 'Continuous Internal Assessment Submission Form : '.$PMonth , 0, false, 'C', 0, '', 0, false, 'T', 'M');



		$this->Ln(5);
		$this->SetFont('helvetica', 'B', 11);
		$this->Cell(0, 30, 'Cycle/Branch : '. $Bra_Full, 0, false, 'L', 0, '', 0, false, 'T', 'M');

		if(trim($Section) =="")
		{
		$this->Cell(0,30, 'Sem : '.$Sub_Sem        , 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}
		else
		{
		$this->Cell(0,30, 'Sem : '.$Sub_Sem.'         Section : '.$Section, 0, false, 'R', 0, '', 0, false, 'T', 'M');
		}

		$this->Ln(5);
		$this->SetFont('helvetica', 'B', 11);
		$this->Cell(0, 30, 'Course Name : '. $Sub_Name, 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->Cell(0,30, 'Course Code : '.$Sub_Code         , 0, false, 'R', 0, '', 0, false, 'T', 'M');

		$this->Ln(5);
		$this->SetFont('helvetica', 'B', 11);
		$this->Cell(0, 30, 'Faculty Name : '.$Faculty_Name, 0, false, 'L', 0, '', 0, false, 'T', 'M');
		$this->Cell(0,30, 'Credits : '.$Credits.'   Hours : '.$Hours, 0, false, 'R', 0, '', 0, false, 'T', 'M');
	
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
$pdf->SetAuthor('Architecture College');
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
$pdf->SetMargins(PDF_MARGIN_LEFT+5, PDF_MARGIN_TOP+18, PDF_MARGIN_RIGHT);
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


$HeadOne=0;
$Linec=0;






               $sql_mid1=""; $sql_mid2="";
    	  	$sql3="Select SI.Student_ID,SI.C_Roll_Number,SI.C_USN,SI.Student_Name,SI.LBatch from
    	  	Course_Registration as CR ,Student_Info as SI ";

    	  	if($Exam_Type=="Regular" and $Sub_Type=="Core"){
    	  	$sql_mid1="and SI.Section='$Section' ";
    	  	}

    	  	if($L_Batch>1){
    	  	$sql3=$sql3." ";
    	  	$sql_mid2="and SI.LBatch='$L_Batch' ";
    	  	}

    	  	$sql3=$sql3." where CR.Sub_ID='$Sub_ID' ";


    	  	$sql_end="and CR.Student_ID=SI.Student_ID  order by SI.C_USN,SI.C_Roll_Number ";

    	  	$sql3= $sql3.$sql_mid1.$sql_mid2.$sql_end;


		$queryIn= $dbh -> prepare($sql3);
    	  	$queryIn-> execute();
    	  	$countIn = $queryIn->rowCount();
    	  	$rowsAll=$queryIn->fetchAll(PDO::FETCH_OBJ);


    	        $pdf->AddPage('L');

    	        $n_sz=600;
    	        $t1=$t2=$t3=$t4=$t5=$t6=$t7=$t8=$t9=$t10=$m1=$m2=$m3=0;
    	        $T1_Mx=0;  $T2_Mx=0; $T3_Mx=0;	$T4_Mx=0;  $T5_Mx=0; $T6_Mx=0;	$T7_Mx=0;  $T8_Mx=0; $T9_Mx=0; $T10_Mx=0; $M1_Mx=0;  $M2_Mx=0; $M3_Mx=0; $AllMax=0;
    	        $sql4c ="SELECT Occasion,Max_Mark from CIA_Entered WHERE FS_ID='$FS_ID'";
		$query4c= $dbh -> prepare($sql4c);
		$query4c-> execute();
    		$rows4c=$query4c->fetchAll(PDO::FETCH_OBJ);
    		foreach($rows4c as $rw4c)
    		{
    		  $exmt=$rw4c->Occasion;
    		   if($exmt=='TASK_1' and $t1==0)
    		   { $T1_Mx=$rw4c->Max_Mark;if($T1_Mx!=0){ $n_sz=$n_sz-60;if($Th_Pract=="P" ||$Th_Pract=="S"){$n_sz=$n_sz-10;} $t1=$t1+1;}}
    		   if($exmt=='TASK_2' and $t2==0)
    		   { $T2_Mx=$rw4c->Max_Mark;if($T2_Mx!=0){ $n_sz=$n_sz-60;$t2=$t2+1;}}
    		   if($exmt=='TASK_3' and $t3==0)
    		   { $T3_Mx=$rw4c->Max_Mark;if($T3_Mx!=0){ $n_sz=$n_sz-60;$t3=$t3+1;}}
					 if($exmt=='TASK_4' and $t4==0)
					{ $T4_Mx=$rw4c->Max_Mark;if($T4_Mx!=0){ $n_sz=$n_sz-60;$t4=$t4+1;}}
					if($exmt=='TASK_5' and $t5==0)
					{ $T5_Mx=$rw4c->Max_Mark;if($T5_Mx!=0){ $n_sz=$n_sz-60;$t5=$t5+1;}}
					if($exmt=='TASK_6' and $t6==0)
					{ $T6_Mx=$rw4c->Max_Mark;if($T6_Mx!=0){ $n_sz=$n_sz-60;$t6=$t6+1;}}
					if($exmt=='TASK_7' and $t7==0)
					{ $T7_Mx=$rw4c->Max_Mark;if($T7_Mx!=0){ $n_sz=$n_sz-60;$t7=$t7+1;}}
					if($exmt=='TASK_8' and $t8==0)
					{ $T8_Mx=$rw4c->Max_Mark;if($T8_Mx!=0){ $n_sz=$n_sz-60;$t8=$t8+1;}}
					if($exmt=='TASK_9' and $t9==0)
					{ $T9_Mx=$rw4c->Max_Mark;if($T9_Mx!=0){ $n_sz=$n_sz-60;$t9=$t9+1;}}
					if($exmt=='TASK_10' and $t10==0)
					{ $T10_Mx=$rw4c->Max_Mark;if($T10_Mx!=0){ $n_sz=$n_sz-60;$t10=$t10+1;}}
    		   if($exmt=='MSE_1' and $m1==0)
    		   { $M1_Mx=$rw4c->Max_Mark;if($M1_Mx!=0){ $n_sz=$n_sz-60;if($Th_Pract=="P" || $Th_Pract=="S"){$n_sz=$n_sz-5;}$m1=$m1+1;}}
    		   if($exmt=='MSE_2' and $m2==0)
    		   { $M2_Mx=$rw4c->Max_Mark;if($M2_Mx!=0){ $n_sz=$n_sz-60;$m2=$m2+1;}}
					 if($exmt=='MSE_3' and $m3==0)
    		   { $M3_Mx=$rw4c->Max_Mark;if($M3_Mx!=0){ $n_sz=$n_sz-60;$m3=$m3+1;}}
    		}

  			$AllMax=$T1_Mx+$T2_Mx+$T3_Mx+$T4_Mx+$T5_Mx+$T6_Mx+$T7_Mx+$T8_Mx+$T9_Mx+$T10_Mx+$M1_Mx+$M2_Mx+$M3_Mx;



		     	if($Th_Pract=="T" ||$Th_Pract=="S")
		     	{


		     	$txt1 = $txt1."
                                   <table  style=\"font-size:13px;border:2px solid black;\" border=\"1\" cellpadding=\"3\">
                                   <thead>
                                   <tr nobr=\"true\"  style=\"text-align:center;font-weight:bold;\">
                                   <th width=\"30px\">Sl.<br>No</th>
                                   <th width=\"90px\">USN/Roll<br>Number</th>
                                   <th width=\"150px\">Name</th>
                                   <th width=\"87px\">No of classes<br>held: $countT<br>Attendance %</th>";
                                   if($t1!=0){
                       $txt1 = $txt1."<th width=\"63px\">Assignment_1<br>(Max:$T1_Mx)</th>"; }
                                   if($t2!=0){
                       $txt1 = $txt1."<th width=\"60px\">Assignment_2<br>(Max:$T2_Mx)</th>"; }
                                   if($t3!=0){
                       $txt1 = $txt1."<th width=\"60px\">Assignment_3<br>(Max:$T3_Mx)</th>"; }
											 						 if($t4!=0){
					 						 $txt1 = $txt1."<th width=\"60px\">Assignment_4<br>(Max:$T4_Mx)</th>"; }
											 						 if($t5!=0){
											 $txt1 = $txt1."<th width=\"60px\">Assignment_5<br>(Max:$T5_Mx)</th>"; }
											 						 if($t6!=0){
					 						 $txt1 = $txt1."<th width=\"60px\">Assignment_6<br>(Max:$T6_Mx)</th>"; }
											 						 if($t7!=0){
					 						 $txt1 = $txt1."<th width=\"60px\">Assignment_7<br>(Max:$T7_Mx)</th>"; }
											 						 if($t8!=0){
					 						 $txt1 = $txt1."<th width=\"60px\">Assignment_8<br>(Max:$T8_Mx)</th>"; }
											 						 if($t9!=0){
					 						 $txt1 = $txt1."<th width=\"60px\">Assignment_9<br>(Max:$T9_Mx)</th>"; }
											 						 if($t10!=0){
					 						 $txt1 = $txt1."<th width=\"60px\">Assignment_10<br>(Max:$T10_Mx)</th>"; }
                                   if($m1!=0){
                       $txt1 = $txt1."<th width=\"60px\">MSE1<br>(Max:$M1_Mx)</th>"; }
                                   if($m2!=0){
                       $txt1 = $txt1."<th width=\"60px\">MSE2<br>(Max:$M2_Mx)</th>"; }
											 						 if($m3!=0){
					 						 $txt1 = $txt1."<th width=\"60px\">MSE2<br>(Max:$M3_Mx)</th>"; }
                       $txt1 = $txt1."<th width=\"60px\">Total<br>Max:$AllMax</th>
                                   <th width=\"55px\">Remark<br>(NE)</th>
                                   </tr>
                                   </thead> <tbody>";

                       }
                       else
                       {
                       $n_sz=$n_sz-50;
		     	$txt1 = $txt1."


                                   <table  style=\"font-size:13px;border:2px solid black;\" border=\"1\" cellpadding=\"3\">
                                   <thead>
                                   <tr nobr=\"true\"  style=\"text-align:center;font-weight:bold;\">
                                   <th width=\"30px\">Sl.<br>No</th>
                                   <th width=\"100px\">USN/Roll<br>Number</th>
                                   <th width=\"87px\">Name</th>
                                   <th width=\"40px\">Lab<br>Batch</th>
                                   <th width=\"87px\">No of classes<br>held: $countT<br>Attendance %</th>";
                                   if($t1!=0){
                       $txt1 = $txt1."<th width=\"65px\">Task1<br>(Max:$T1_Mx)</th>"; }
                       		   if($m1!=0){
                       $txt1 = $txt1."<th width=\"65px\">MSE1<br>(Max:$M1_Mx)</th>"; }
                       $txt1 = $txt1."<th width=\"65px\">Total<br>Max:$AllMax</th>
                                   <th width=\"65px\">Remark<br>(NE)</th>
                                   </tr>
                                   </thead> <tbody>";
                       }


                                $slno=0;
    		foreach($rowsAll as $resIn)
    		{

    			$slno=$slno+1;
    			$Std_id=$resIn->Student_ID;
    			$Std_USN=$resIn->C_USN;
    			$Std_Roll=$resIn->C_Roll_Number;
    			$Std_Name=$resIn->Student_Name;
    			$Std_LB=$resIn->LBatch;

    			$Final_No=$Std_USN;
    			if($Std_USN==""){$Final_No=$Std_Roll;}

    			$sql4= "select Total_Class,Total_Present from Total_Attendance where Sub_ID='$Sub_ID' and Student_ID='$Std_id'";
			$queryb= $dbh -> prepare($sql4);
			$queryb-> execute();
			$rowb = $queryb->fetch();
			$Tot_Class=$rowb['Total_Class'];
	 		$Tot_Present=$rowb['Total_Present'];
	                $Tot_per=0;

			if($Tot_Present>0){$Tot_per= ($Tot_Present * 100)/$Tot_Class;}
    		        $Tot_per=round($Tot_per,2);


    		  $T1_M=0;  $T2_M=0; $T3_M=0; $T4_M=0;  $T5_M=0; $T6_M=0; $T7_M=0;  $T8_M=0; $T9_M=0; $T10_M=0;  $M1_M=0;  $M2_M=0; $M3_M=0;
    		  $sql4c ="SELECT Occasion,Mark,Attendance,Weightage,Max_Mark from Student_CIA WHERE Student_ID='$Std_id' and Sub_ID='$Sub_ID'";
		  $query4c= $dbh -> prepare($sql4c);
		  $query4c-> execute();
    		  $rows4c=$query4c->fetchAll(PDO::FETCH_OBJ);
    		  foreach($rows4c as $rw4c)
    		  {
    		  	$exmt=$rw4c->Occasion;
    		  	$pr_at=$rw4c->Attendance;
						$Weightage=$rw4c->Weightage;

     			if($exmt=='TASK_1'){$T1_M=$rw4c->Mark;if($pr_at=='A'){$T1_M='0';}}
    			if($exmt=='TASK_2'){$T2_M=$rw4c->Mark;if($pr_at=='A'){$T2_M='0';}}
    			if($exmt=='TASK_3'){$T3_M=$rw4c->Mark;if($pr_at=='A'){$T3_M='AB';}}
					if($exmt=='TASK_4'){$T4_M=$rw4c->Mark;if($pr_at=='A'){$T4_M='0';}}
					if($exmt=='TASK_5'){$T5_M=$rw4c->Mark;if($pr_at=='A'){$T5_M='0';}}
					if($exmt=='TASK_6'){$T6_M=$rw4c->Mark;if($pr_at=='A'){$T6_M='0';}}
					if($exmt=='TASK_7'){$T7_M=$rw4c->Mark;if($pr_at=='A'){$T7_M='0';}}
					if($exmt=='TASK_8'){$T8_M=$rw4c->Mark;if($pr_at=='A'){$T8_M='0';}}
					if($exmt=='TASK_9'){$T9_M=$rw4c->Mark;if($pr_at=='A'){$T9_M='0';}}
					if($exmt=='TASK_10'){$T10_M=$rw4c->Mark;if($pr_at=='A'){$T10_M='0';}}
					if($exmt=='MSE_1'){$M1_M=$rw4c->Mark;$Max1=$rw4c->Max_Mark;if($pr_at=='A'){$M1_M='0';}}
 			    if($exmt=='MSE_2'){$M2_M=$rw4c->Mark;$Max2=$rw4c->Max_Mark;if($pr_at=='A'){$M2_M='0';}}
 			    if($exmt=='MSE_3'){$M3_M=$rw4c->Mark;$Max3=$rw4c->Max_Mark;if($pr_at=='A'){$M3_M='0';}}
    		  }


					// Calculate highest and second highest round marks
					          $highestMax = max($Max1, $Max2, $Max3);
					          $secondHighestMax = max(min($Max1, $Max2,), min($Max1,$Max3), min($Max2, $Max3));
					          $MaxMarks=$highestMax+ $secondHighestMax;


					          $highestround = max($M1_M, $M2_M, $M3_M);
					          $secondHighestround = max(min($M1_M, $M2_M,), min($M1_M,$M3_M), min($M2_M, $M3_M));

					          $Task_maxround="";
					          $Task_maxround=$T1_M+$T2_M+$T3_M+$T4_M+$T5_M+$T6_M+$T7_M+$T8_M+$T9_M+$T10_M;

					          //For Default Option
					          $Final=  $Task_maxround/10;
					          $MSE_maxround=$highestround+$secondHighestround;
					          $AllMaxround=$Final+$MSE_maxround;
					    		  $Std_Mark=round($AllMaxround);

					          //For 50-50 Option
					          $FinalTask5050=  ($Task_maxround*25)/100;
					          $MSE_5050=$highestround+$secondHighestround;
					          $MSE=($MSE_5050*100)/$MaxMarks;
					          $MSE100=($MSE*0.25);
					          $Round5050=$FinalTask5050+$MSE100;
					    		  $Std_Mark5050=round($Round5050);

    		  $Std_Status="";
    		  if(($Tot_per<85 or $Std_Mark<25 or $Std_Mark5050<25) and $countT>0){ $Std_Status="<span style='color:red'>NE</span>"; }



    		  if($Th_Pract=="T" ||$Th_Pract=="S")
    		  {
    		     $txt1 = $txt1."
                                   <tr nobr=\"true\" >
                                   <td width=\"30px\"> $slno    </td>
                                   <td width=\"90px\"> $Final_No</td>

                                   <td width=\"150px\"> $Std_Name</td>
                                   <td width=\"87px\" style=\"text-align:center;\"> $Tot_per </td>";
                                    if($t1!=0){
                     $txt1 = $txt1."<td width=\"63px\" style=\"text-align:center;\"> $T1_M    </td>";}
                                    if($t2!=0){
                     $txt1 = $txt1."<td width=\"60px\" style=\"text-align:center;\"> $T2_M    </td>";}
                                    if($t3!=0){
                     $txt1 = $txt1."<td width=\"60px\" style=\"text-align:center;\"> $T3_M    </td>";}
										 								if($t4!=0){
										 $txt1 = $txt1."<td width=\"60px\" style=\"text-align:center;\"> $T4_M    </td>";}
										 								if($t5!=0){
										 $txt1 = $txt1."<td width=\"60px\" style=\"text-align:center;\"> $T5_M    </td>";}
										 								if($t6!=0){
										 $txt1 = $txt1."<td width=\"60px\" style=\"text-align:center;\"> $T6_M    </td>";}
										 								if($t7!=0){
										 $txt1 = $txt1."<td width=\"60px\" style=\"text-align:center;\"> $T7_M    </td>";}
										 								if($t8!=0){
										 $txt1 = $txt1."<td width=\"60px\" style=\"text-align:center;\"> $T8_M    </td>";}
										 								if($t9!=0){
										 $txt1 = $txt1."<td width=\"60px\" style=\"text-align:center;\"> $T9_M    </td>";}
										 								if($t10!=0){
										 $txt1 = $txt1."<td width=\"60px\" style=\"text-align:center;\"> $T10_M    </td>";}
                                    if($m1!=0){
                     $txt1 = $txt1."<td width=\"60px\" style=\"text-align:center;\"> $M1_M    </td>";}
                                   if($m2!=0){
                     $txt1 = $txt1."<td width=\"60px\" style=\"text-align:center;\"> $M2_M    </td>";}
										 							 if($m3!=0){
			 							 $txt1 = $txt1."<td width=\"60px\" style=\"text-align:center;\"> $M3_M    </td>";}
										 if ($Weightage == "Default")
										 {
                     $txt1 = $txt1."<td width=\"60px\" style=\"text-align:center;\"> $Std_Mark</td>
										 <td width=\"55px\" style=\"text-align:center;\"> $Std_Status</td>
										 </tr> ";
									   }
										 elseif ($Weightage == "50-50")
										{
										 $txt1 = $txt1."<td width=\"60px\" style=\"text-align:center;\">  $Std_Mark5050</td>
										<td width=\"55px\" style=\"text-align:center;\"> $Std_Status</td>
										</tr> ";
										}
										else {
											$txt1 = $txt1."<td width=\"60px\" style=\"text-align:center;\"> </td>
 										<td width=\"55px\" style=\"text-align:center;\"> $Std_Status</td>
 										</tr> ";
										}


    		  }
    		  else
    		  {

    		       $txt1 = $txt1."
                                   <tr nobr=\"true\" >
                                   <td width=\"30px\"> $slno    </td>
                                   <td width=\"100px\"> $Final_No</td>
                                   <td width=\"".$n_sz."px\"> $Std_Name</td>
                                   <td width=\"40px\" style=\"text-align:center;\"> $Section$Std_LB  </td>
                                   <td width=\"87px\" style=\"text-align:center;\"> $Tot_per </td>";
                                   if($t1!=0){
                     $txt1 = $txt1."<td width=\"65px\" style=\"text-align:center;\"> $T1_M    </td>";}
                                   if($m1!=0){
                     $txt1 = $txt1."<td width=\"65px\" style=\"text-align:center;\"> $M1_M    </td>";}
                     $txt1 = $txt1."<td width=\"65px\" style=\"text-align:center;\"> $Std_Mark</td>
                                   <td width=\"65px\" style=\"text-align:center;\"> $Std_Status</td>
                                   </tr> ";
    		  }





    		}
    		 $txt1=$txt1." </tbody></table>";
    		 $txt = <<<EOD
                        $txt1
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
$pdf->Output($FileName.'.pdf', 'D');


}
//POST ENDS
/* PDF Report Ends */

?>
