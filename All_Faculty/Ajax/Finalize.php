<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../../DB/config.php");
require("../../Authenticate/Faculty.php");


//$Course_Registration_Head="menu-open";
//$Add_Subjects="active";

/*$PageName="Students Attendance Register ";
$Report_Head="menu-open";
$Attendance_Register="active";*/
$Faculty_ID=$_SESSION['F_ID'];


$C_Date=$_POST['C_Date'];
$FS_ID=$_POST['FS_ID'];
$Exam_Type=$_POST['Exam_Type'];


$sqla ="SELECT * FROM Faculty_Subjects where FS_ID='$FS_ID' ";
$querya= $dbh -> prepare($sqla);
$querya-> execute();
$rowa = $querya->fetch();
$Sub_ID=$rowa['Sub_ID'];
$Section=$rowa['Section'];
$L_Batch=$rowa['LBatch'];
$Finalized=$rowa['Finalized'];

if($L_Batch==1)
{
$sqla ="SELECT FS_ID FROM Faculty_Subjects where Course_Date='$C_Date' and Sub_ID='$Sub_ID' and Section='$Section'";
$query4c= $dbh -> prepare($sqla);
$query4c-> execute();
$rows4c=$query4c->fetchAll(PDO::FETCH_OBJ);
$strCon=""; $cti=0; $Flag=0;
foreach($rows4c as $rw4c)
{
	$LabFSID=$rw4c->FS_ID;
	if($cti>0)
	{
	$strCon=$strCon." or  FS_ID='$LabFSID' ";
	}
	else
	{
	$strCon=" FS_ID='$LabFSID' ";
	}
	$cti=$cti+1;
	$Tot_CIA=0;

	$sqld ="SELECT SUM(Max_Mark) as Tot_CIA FROM CIA_Entered where FS_ID='$LabFSID'";
  	$queryd= $dbh -> prepare($sqld);
  	$queryd-> execute();
  	$rowd = $queryd->fetch();
  	$Tot_CIA=$rowd['Tot_CIA'];
  	if($Tot_CIA!=175)
 	{
  	   $Flag=1; break;
	}
}
if($Flag==0)
{
	 	$fnl="Update Faculty_Subjects set Finalized='1' where ".$strCon;
		$qfnl= $dbh -> prepare($fnl);
		$qfnl-> execute();
		echo "MSE Marks and Attendance Finalized \n CIE SHEET Report Enabled for Download";
}
else
{
	echo "Please Do check whether you filled all the details..!\n Unable To Finalize the Details.\n Do Confirm All Batch details were updated ...\n Total MAX CIA Marks Should be 175";
}
} // if Not Lab
else
{
	$sqld ="SELECT SUM(Max_Mark) as Tot_CIA FROM CIA_Entered where FS_ID='$FS_ID'";
  	$queryd= $dbh -> prepare($sqld);
  	$queryd-> execute();
  	$rowd = $queryd->fetch();
  	$Tot_CIA=$rowd['Tot_CIA'];
  	if($Tot_CIA>=150 || $Tot_CIA<=175)
 	{
		$fnl="Update Faculty_Subjects set Finalized='1' where  FS_ID='$FS_ID'";
		$qfnl= $dbh -> prepare($fnl);
		$qfnl-> execute();
		echo "MSE Marks and Attendance Finalized \n CIE SHEET Report Enabled for Download";

	}
	else
	{
		echo "Please Do check whether you filled all the details..!\n Unable To Finalize the Details.\n Do Check All CIE Entry...\n Total MAX CIA Marks Should be 175";
	}
}
