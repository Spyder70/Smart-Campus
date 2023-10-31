<?php
session_start();
//require("connect.php");
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

require("../Authenticate/DataEntry.php");
//$Link_ACompany="active";
//$Link_CHead="menu-open";

$PageName="Student Details";
$S_Admission="active";
$Register_Head="menu-open";



$C_msg="";


if($_POST)
{


$D_Create=date("Y-m-d H:i:s");
$D_Update=date("Y-m-d H:i:s");

$Dept_Name=$_POST['Dept_Name'];
$Program=$_POST['Program'];
$Admission_Type=$_POST['Admission_Type'];
$Admission_Quota=$_POST['Admission_Quota'];
$Allotted_Category=$_POST['Allotted_Category'];
$CET_COMEDK_Order=$_POST['CET_COMEDK_Order'];
$CET_COMEDK_TAT=$_POST['CET_COMEDK_TAT'];
$CET_COMEDK_Rank=$_POST['CET_COMEDK_Rank'];
$CET_COMEDK_Date=$_POST['CET_COMEDK_Date'];

$CET_COMEDK_Fee=$_POST['CET_COMEDK_Fee'];
$College_Fee=$_POST['College_Fee'];

if(trim($CET_COMEDK_Fee)=="")$CET_COMEDK_Fee=0;
if(trim($College_Feetrim)=="")$College_Fee=0;

$DOJ=$_POST['DOJ'];
$Praaptha_No=$_POST['Praaptha_No'];


$Batch=$_POST['Batch'];
$Sem=$_POST['Sem'];
$Section=$_POST['Section'];
$Cycle=$_POST['Cycle'];
$C_Roll_Number=$_POST['C_Roll_Number'];
$C_USN=$_POST['C_USN'];
$Old_USN=$_POST['Old_USN'];


$Student_Name=$_POST['Student_Name'];
$Gender=$_POST['Gender'];
$Blood=$_POST['Blood'];
$Aadhaar=$_POST['Aadhaar'];
$DOB=$_POST['DOB'];
$Religion=$_POST['Religion'];
$Caste=$_POST['Caste'];
$Category=$_POST['Category'];
$Mother_Tongue=$_POST['Mother_Tongue'];
$State_Domicile=$_POST['State_Domicile'];
$Nationality=$_POST['Nationality'];
$Father_Name=$_POST['Father_Name'];
$Father_Designation=$_POST['Father_Designation'];
$Father_Income=$_POST['Father_Income'];
$Mother_Name=$_POST['Mother_Name'];
$Mother_Designation=$_POST['Mother_Designation'];
$Mother_Income=$_POST['Mother_Income'];


if(trim($Father_Income)=="")$Father_Income=0;
if(trim($Mother_Income)=="")$Mother_Income=0;

$Father_CID=$_POST['Father_CID'];
$Father_Mob=$_POST['Father_Mob'];
$Father_Email=$_POST['Father_Email'];
$Mother_CID=$_POST['Mother_CID'];
$Mother_Mob=$_POST['Mother_Mob'];
$Mother_Email=$_POST['Mother_Email'];
$Guardian_CID=$_POST['Guardian_CID'];
$Guardian_Mob=$_POST['Guardian_Mob'];
$Guardian_Email=$_POST['Guardian_Email'];
$Student_CID=$_POST['Student_CID'];
$Student_Mob=$_POST['Student_Mob'];
$Student_Email=$_POST['Student_Email'];

if(trim($Mother_Mob)=="")$Mother_Mob=0;
if(trim($Guardian_Mob)=="")$Guardian_Mob=0;

$C_Address=trim($_POST['C_Address']);
$C_Post="";
$C_Taluk=trim($_POST['C_Taluk']);
$C_District=trim($_POST['C_District']);
$C_State=trim($_POST['C_State']);
$C_Pin=trim($_POST['C_Pin']);

$P_Address=trim($_POST['P_Address']);
$P_Post="";
$P_Taluk=trim($_POST['P_Taluk']);
$P_District=trim($_POST['P_District']);
$P_State=trim($_POST['P_State']);
$P_Pin=trim($_POST['P_Pin']);


$Q_Course=$_POST['Q_Course'];
$Q_Reg_No=$_POST['Q_Reg_No'];
$College_Name=$_POST['College_Name'];
$Pass_Year=$_POST['Pass_Year'];
$Area_type=$_POST['Area_type'];
$Board_Name=$_POST['Board_Name'];
$Board_State=$_POST['Board_State'];
$Leaving_Date=$_POST['Leaving_Date'];

$Total_Max=$_POST['Total_Max'];
$Total_Obtain=$_POST['Total_Obtain'];
$Total_Percent=$_POST['Total_Percent'];

if(trim($Total_Max)=="")$Total_Max=0;
if(trim($Total_Obtain)=="")$Total_Obtain=0;
if(trim($Total_Percent)=="")$Total_Percent=0;

$P_Max=$_POST['P_Max'];
$C_Max=$_POST['C_Max'];
$M_Max=$_POST['M_Max'];
$E_Max=$_POST['E_Max'];

if(trim($P_Max)=="")$P_Max=0;
if(trim($C_Max)=="")$C_Max=0;
if(trim($M_Max)=="")$M_Max=0;
if(trim($E_Max)=="")$E_Max=0;

$P_Obtain=$_POST['P_Obtain'];
$C_Obtain=$_POST['C_Obtain'];
$M_Obtain=$_POST['M_Obtain'];
$E_Obtain=$_POST['E_Obtain'];

if(trim($P_Obtain)=="")$P_Obtain=0;
if(trim($C_Obtain)=="")$C_Obtain=0;
if(trim($M_Obtain)=="")$M_Obtain=0;
if(trim($E_Obtain)=="")$E_Obtain=0;

$Tot_PCM_Max=$_POST['Tot_PCM_Max'];
$Tot_PCM_Obtain=$_POST['Tot_PCM_Obtain'];
$PCM_Percent=$_POST['PCM_Percent'];

if(trim($Tot_PCM_Max)=="")$Tot_PCM_Max=0;
if(trim($Tot_PCM_Obtain)=="")$Tot_PCM_Obtain=0;
if(trim($PCM_Percent)=="")$PCM_Percent=0;

$Status="R";

$Intwo==0;
if(isset($_POST['A_Submit']))
{

$sqlIn ="SELECT C_USN FROM Student_Info where Praaptha_No=:Praaptha_No1";
    				$queryIn= $dbh -> prepare($sqlIn);
    				$queryIn-> bindParam(':Praaptha_No1', $Praaptha_No);
    				$queryIn-> execute();
    				if($queryIn->rowCount() > 0)
    				{
    				$Intwo==1;
    				goto In2;
    				}


try
{

$sql2="insert into Student_Info(

Dept_Name,
Program,
Admission_Type,
Admission_Quota,
Allotted_Category,
CET_COMEDK_Order,
CET_COMEDK_TAT,
CET_COMEDK_Rank,
CET_COMEDK_Date,
CET_COMEDK_Fee,
College_Fee,
DOJ,
Praaptha_No,
Batch,
Sem,
Section,
Cycle,
C_Roll_Number,
C_USN,
Old_USN,
Student_Name,
Gender,
Blood,
Aadhaar,
DOB,
Religion,
Caste,
Category,
Mother_Tongue,
State_Domicile,
Nationality,
Father_Name,
Father_Designation,
Father_Income,
Mother_Name,
Mother_Designation,
Mother_Income,
Father_CID,
Father_Mob,
Father_Email,
Mother_CID,
Mother_Mob,
Mother_Email,
Guardian_CID,
Guardian_Mob,
Guardian_Email,
Student_CID,
Student_Mob,
Student_Email,
C_Address,
C_Post,
C_Taluk,
C_District,
C_State,
C_Pin,
P_Address,
P_Post,
P_Taluk,
P_District,
P_State,
P_Pin,
Q_Course,
Q_Reg_No,
College_Name,
Pass_Year,
Area_type,
Board_Name,
Board_State,
Leaving_Date,
Total_Max,
Total_Obtain,
Total_Percent,
P_Max,
C_Max,
M_Max,
E_Max,
Tot_PCM_Max,
P_Obtain,
C_Obtain,
M_Obtain,
E_Obtain,
Tot_PCM_Obtain,
PCM_Percent,
D_Create,
D_Update,
Status
)values(
:Dept_Name_B,
:Program_B,
:Admission_Type_B,
:Admission_Quota_B,
:Allotted_Category_B,
:CET_COMEDK_Order_B,
:CET_COMEDK_TAT_B,
:CET_COMEDK_Rank_B,
:CET_COMEDK_Date_B,
:CET_COMEDK_Fee_B,
:College_Fee_B,
:DOJ_B,
:Praaptha_No_B,
:Batch_B,
:Sem_B,
:Section_B,
:Cycle_B,
:C_Roll_Number_B,
:C_USN_B,
:Old_USN_B,
:Student_Name_B,
:Gender_B,
:Blood_B,
:Aadhaar_B,
:DOB_B,
:Religion_B,
:Caste_B,
:Category_B,
:Mother_Tongue_B,
:State_Domicile_B,
:Nationality_B,
:Father_Name_B,
:Father_Designation_B,
:Father_Income_B,
:Mother_Name_B,
:Mother_Designation_B,
:Mother_Income_B,
:Father_CID_B,
:Father_Mob_B,
:Father_Email_B,
:Mother_CID_B,
:Mother_Mob_B,
:Mother_Email_B,
:Guardian_CID_B,
:Guardian_Mob_B,
:Guardian_Email_B,
:Student_CID_B,
:Student_Mob_B,
:Student_Email_B,
:C_Address_B,
:C_Post_B,
:C_Taluk_B,
:C_District_B,
:C_State_B,
:C_Pin_B,
:P_Address_B,
:P_Post_B,
:P_Taluk_B,
:P_District_B,
:P_State_B,
:P_Pin_B,
:Q_Course_B,
:Q_Reg_No_B,
:College_Name_B,
:Pass_Year_B,
:Area_type_B,
:Board_Name_B,
:Board_State_B,
:Leaving_Date_B,
:Total_Max_B,
:Total_Obtain_B,
:Total_Percent_B,
:P_Max_B,
:C_Max_B,
:M_Max_B,
:E_Max_B,
:Tot_PCM_Max_B,
:P_Obtain_B,
:C_Obtain_B,
:M_Obtain_B,
:E_Obtain_B,
:Tot_PCM_Obtain_B,
:PCM_Percent_B,
:D_Create_B,
:D_Update_B,
:Status_B
)";

$query2 = $dbh->prepare($sql2);


$query2->bindParam(':Dept_Name_B',$Dept_Name);
$query2->bindParam(':Program_B',$Program);
$query2->bindParam(':Admission_Type_B',$Admission_Type);
$query2->bindParam(':Admission_Quota_B',$Admission_Quota);
$query2->bindParam(':Allotted_Category_B',$Allotted_Category);
$query2->bindParam(':CET_COMEDK_Order_B',$CET_COMEDK_Order);
$query2->bindParam(':CET_COMEDK_TAT_B',$CET_COMEDK_TAT);
$query2->bindParam(':CET_COMEDK_Rank_B',$CET_COMEDK_Rank);
$query2->bindParam(':CET_COMEDK_Date_B',$CET_COMEDK_Date);
$query2->bindParam(':CET_COMEDK_Fee_B',$CET_COMEDK_Fee);
$query2->bindParam(':College_Fee_B',$College_Fee);
$query2->bindParam(':DOJ_B',$DOJ);
$query2->bindParam(':Praaptha_No_B',$Praaptha_No);
$query2->bindParam(':Batch_B',$Batch);
$query2->bindParam(':Sem_B',$Sem);
$query2->bindParam(':Section_B',$Section);
$query2->bindParam(':Cycle_B',$Cycle);
$query2->bindParam(':C_Roll_Number_B',$C_Roll_Number);
$query2->bindParam(':C_USN_B',$C_USN);
$query2->bindParam(':Old_USN_B',$Old_USN);
$query2->bindParam(':Student_Name_B',$Student_Name);
$query2->bindParam(':Gender_B',$Gender);
$query2->bindParam(':Blood_B',$Blood);
$query2->bindParam(':Aadhaar_B',$Aadhaar);
$query2->bindParam(':DOB_B',$DOB);
$query2->bindParam(':Religion_B',$Religion);
$query2->bindParam(':Caste_B',$Caste);
$query2->bindParam(':Category_B',$Category);
$query2->bindParam(':Mother_Tongue_B',$Mother_Tongue);
$query2->bindParam(':State_Domicile_B',$State_Domicile);
$query2->bindParam(':Nationality_B',$Nationality);
$query2->bindParam(':Father_Name_B',$Father_Name);
$query2->bindParam(':Father_Designation_B',$Father_Designation);
$query2->bindParam(':Father_Income_B',$Father_Income);
$query2->bindParam(':Mother_Name_B',$Mother_Name);
$query2->bindParam(':Mother_Designation_B',$Mother_Designation);
$query2->bindParam(':Mother_Income_B',$Mother_Income);
$query2->bindParam(':Father_CID_B',$Father_CID);
$query2->bindParam(':Father_Mob_B',$Father_Mob);
$query2->bindParam(':Father_Email_B',$Father_Email);
$query2->bindParam(':Mother_CID_B',$Mother_CID);
$query2->bindParam(':Mother_Mob_B',$Mother_Mob);
$query2->bindParam(':Mother_Email_B',$Mother_Email);
$query2->bindParam(':Guardian_CID_B',$Guardian_CID);
$query2->bindParam(':Guardian_Mob_B',$Guardian_Mob);
$query2->bindParam(':Guardian_Email_B',$Guardian_Email);
$query2->bindParam(':Student_CID_B',$Student_CID);
$query2->bindParam(':Student_Mob_B',$Student_Mob);
$query2->bindParam(':Student_Email_B',$Student_Email);
$query2->bindParam(':C_Address_B',$C_Address);
$query2->bindParam(':C_Post_B',$C_Post);
$query2->bindParam(':C_Taluk_B',$C_Taluk);
$query2->bindParam(':C_District_B',$C_District);
$query2->bindParam(':C_State_B',$C_State);
$query2->bindParam(':C_Pin_B',$C_Pin);
$query2->bindParam(':P_Address_B',$P_Address);
$query2->bindParam(':P_Post_B',$P_Post);
$query2->bindParam(':P_Taluk_B',$P_Taluk);
$query2->bindParam(':P_District_B',$P_District);
$query2->bindParam(':P_State_B',$P_State);
$query2->bindParam(':P_Pin_B',$P_Pin);
$query2->bindParam(':Q_Course_B',$Q_Course);
$query2->bindParam(':Q_Reg_No_B',$Q_Reg_No);
$query2->bindParam(':College_Name_B',$College_Name);
$query2->bindParam(':Pass_Year_B',$Pass_Year);
$query2->bindParam(':Area_type_B',$Area_type);
$query2->bindParam(':Board_Name_B',$Board_Name);
$query2->bindParam(':Board_State_B',$Board_State);
$query2->bindParam(':Leaving_Date_B',$Leaving_Date);
$query2->bindParam(':Total_Max_B',$Total_Max);
$query2->bindParam(':Total_Obtain_B',$Total_Obtain);
$query2->bindParam(':Total_Percent_B',$Total_Percent);
$query2->bindParam(':P_Max_B',$P_Max);
$query2->bindParam(':C_Max_B',$C_Max);
$query2->bindParam(':M_Max_B',$M_Max);
$query2->bindParam(':E_Max_B',$E_Max);
$query2->bindParam(':Tot_PCM_Max_B',$Tot_PCM_Max);
$query2->bindParam(':P_Obtain_B',$P_Obtain);
$query2->bindParam(':C_Obtain_B',$C_Obtain);
$query2->bindParam(':M_Obtain_B',$M_Obtain);
$query2->bindParam(':E_Obtain_B',$E_Obtain);
$query2->bindParam(':Tot_PCM_Obtain_B',$Tot_PCM_Obtain);
$query2->bindParam(':PCM_Percent_B',$PCM_Percent);
$query2->bindParam(':D_Create_B',$D_Create);
$query2->bindParam(':D_Update_B',$D_Update);
$query2->bindParam(':Status_B',$Status);

$query2->execute();


}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}

$C_msg="Registration Successfull";
$last_id = $dbh->lastInsertId();

In2:
if($Intwo==1)
{
$C_msg="Student Already Exist..!";
}

}//Insert End
if(isset($_POST['A_Update']))
{
$G_Student_ID=$_POST['G_Student_ID'];

try
{

$sql2="update Student_Info   SET
Dept_Name=:Dept_Name_B,
Program=:Program_B,
Admission_Type=:Admission_Type_B,
Admission_Quota=:Admission_Quota_B,
Allotted_Category=:Allotted_Category_B,
CET_COMEDK_Order=:CET_COMEDK_Order_B,
CET_COMEDK_TAT=:CET_COMEDK_TAT_B,
CET_COMEDK_Rank=:CET_COMEDK_Rank_B,
CET_COMEDK_Date=:CET_COMEDK_Date_B,
CET_COMEDK_Fee=:CET_COMEDK_Fee_B,
College_Fee=:College_Fee_B,
DOJ=:DOJ_B,
Praaptha_No=:Praaptha_No_B,
Batch=:Batch_B,
Sem=:Sem_B,
Section=:Section_B,
Cycle=:Cycle_B,
C_Roll_Number=:C_Roll_Number_B,
C_USN=:C_USN_B,
Old_USN=:Old_USN_B,
Student_Name=:Student_Name_B,
Gender=:Gender_B,
Blood=:Blood_B,
Aadhaar=:Aadhaar_B,
DOB=:DOB_B,
Religion=:Religion_B,
Caste=:Caste_B,
Category=:Category_B,
Mother_Tongue=:Mother_Tongue_B,
State_Domicile=:State_Domicile_B,
Nationality=:Nationality_B,
Father_Name=:Father_Name_B,
Father_Designation=:Father_Designation_B,
Father_Income=:Father_Income_B,
Mother_Name=:Mother_Name_B,
Mother_Designation=:Mother_Designation_B,
Mother_Income=:Mother_Income_B,
Father_CID=:Father_CID_B,
Father_Mob=:Father_Mob_B,
Father_Email=:Father_Email_B,
Mother_CID=:Mother_CID_B,
Mother_Mob=:Mother_Mob_B,
Mother_Email=:Mother_Email_B,
Guardian_CID=:Guardian_CID_B,
Guardian_Mob=:Guardian_Mob_B,
Guardian_Email=:Guardian_Email_B,
Student_CID=:Student_CID_B,
Student_Mob=:Student_Mob_B,
Student_Email=:Student_Email_B,
C_Address=:C_Address_B,
C_Post=:C_Post_B,
C_Taluk=:C_Taluk_B,
C_District=:C_District_B,
C_State=:C_State_B,
C_Pin=:C_Pin_B,
P_Address=:P_Address_B,
P_Post=:P_Post_B,
P_Taluk=:P_Taluk_B,
P_District=:P_District_B,
P_State=:P_State_B,
P_Pin=:P_Pin_B,
Q_Course=:Q_Course_B,
Q_Reg_No=:Q_Reg_No_B,
College_Name=:College_Name_B,
Pass_Year=:Pass_Year_B,
Area_type=:Area_type_B,
Board_Name=:Board_Name_B,
Board_State=:Board_State_B,
Leaving_Date=:Leaving_Date_B,
Total_Max=:Total_Max_B,
Total_Obtain=:Total_Obtain_B,
Total_Percent=:Total_Percent_B,
P_Max=:P_Max_B,
C_Max=:C_Max_B,
M_Max=:M_Max_B,
E_Max=:E_Max_B,
Tot_PCM_Max=:Tot_PCM_Max_B,
P_Obtain=:P_Obtain_B,
C_Obtain=:C_Obtain_B,
M_Obtain=:M_Obtain_B,
E_Obtain=:E_Obtain_B,
Tot_PCM_Obtain=:Tot_PCM_Obtain_B,
PCM_Percent=:PCM_Percent_B,
D_Update=:D_Update_B



where  Student_ID=:G_Student_ID_B";



$query2 = $dbh->prepare($sql2);


$query2->bindParam(':Dept_Name_B',$Dept_Name);
$query2->bindParam(':Program_B',$Program);
$query2->bindParam(':Admission_Type_B',$Admission_Type);
$query2->bindParam(':Admission_Quota_B',$Admission_Quota);
$query2->bindParam(':Allotted_Category_B',$Allotted_Category);
$query2->bindParam(':CET_COMEDK_Order_B',$CET_COMEDK_Order);
$query2->bindParam(':CET_COMEDK_TAT_B',$CET_COMEDK_TAT);
$query2->bindParam(':CET_COMEDK_Rank_B',$CET_COMEDK_Rank);
$query2->bindParam(':CET_COMEDK_Date_B',$CET_COMEDK_Date);
$query2->bindParam(':CET_COMEDK_Fee_B',$CET_COMEDK_Fee);
$query2->bindParam(':College_Fee_B',$College_Fee);
$query2->bindParam(':DOJ_B',$DOJ);
$query2->bindParam(':Praaptha_No_B',$Praaptha_No);
$query2->bindParam(':Batch_B',$Batch);
$query2->bindParam(':Sem_B',$Sem);
$query2->bindParam(':Section_B',$Section);
$query2->bindParam(':Cycle_B',$Cycle);
$query2->bindParam(':C_Roll_Number_B',$C_Roll_Number);
$query2->bindParam(':C_USN_B',$C_USN);
$query2->bindParam(':Old_USN_B',$Old_USN);
$query2->bindParam(':Student_Name_B',$Student_Name);
$query2->bindParam(':Gender_B',$Gender);
$query2->bindParam(':Blood_B',$Blood);
$query2->bindParam(':Aadhaar_B',$Aadhaar);
$query2->bindParam(':DOB_B',$DOB);
$query2->bindParam(':Religion_B',$Religion);
$query2->bindParam(':Caste_B',$Caste);
$query2->bindParam(':Category_B',$Category);
$query2->bindParam(':Mother_Tongue_B',$Mother_Tongue);
$query2->bindParam(':State_Domicile_B',$State_Domicile);
$query2->bindParam(':Nationality_B',$Nationality);
$query2->bindParam(':Father_Name_B',$Father_Name);
$query2->bindParam(':Father_Designation_B',$Father_Designation);
$query2->bindParam(':Father_Income_B',$Father_Income);
$query2->bindParam(':Mother_Name_B',$Mother_Name);
$query2->bindParam(':Mother_Designation_B',$Mother_Designation);
$query2->bindParam(':Mother_Income_B',$Mother_Income);
$query2->bindParam(':Father_CID_B',$Father_CID);
$query2->bindParam(':Father_Mob_B',$Father_Mob);
$query2->bindParam(':Father_Email_B',$Father_Email);
$query2->bindParam(':Mother_CID_B',$Mother_CID);
$query2->bindParam(':Mother_Mob_B',$Mother_Mob);
$query2->bindParam(':Mother_Email_B',$Mother_Email);
$query2->bindParam(':Guardian_CID_B',$Guardian_CID);
$query2->bindParam(':Guardian_Mob_B',$Guardian_Mob);
$query2->bindParam(':Guardian_Email_B',$Guardian_Email);
$query2->bindParam(':Student_CID_B',$Student_CID);
$query2->bindParam(':Student_Mob_B',$Student_Mob);
$query2->bindParam(':Student_Email_B',$Student_Email);
$query2->bindParam(':C_Address_B',$C_Address);
$query2->bindParam(':C_Post_B',$C_Post);
$query2->bindParam(':C_Taluk_B',$C_Taluk);
$query2->bindParam(':C_District_B',$C_District);
$query2->bindParam(':C_State_B',$C_State);
$query2->bindParam(':C_Pin_B',$C_Pin);
$query2->bindParam(':P_Address_B',$P_Address);
$query2->bindParam(':P_Post_B',$P_Post);
$query2->bindParam(':P_Taluk_B',$P_Taluk);
$query2->bindParam(':P_District_B',$P_District);
$query2->bindParam(':P_State_B',$P_State);
$query2->bindParam(':P_Pin_B',$P_Pin);
$query2->bindParam(':Q_Course_B',$Q_Course);
$query2->bindParam(':Q_Reg_No_B',$Q_Reg_No);
$query2->bindParam(':College_Name_B',$College_Name);
$query2->bindParam(':Pass_Year_B',$Pass_Year);
$query2->bindParam(':Area_type_B',$Area_type);
$query2->bindParam(':Board_Name_B',$Board_Name);
$query2->bindParam(':Board_State_B',$Board_State);
$query2->bindParam(':Leaving_Date_B',$Leaving_Date);
$query2->bindParam(':Total_Max_B',$Total_Max);
$query2->bindParam(':Total_Obtain_B',$Total_Obtain);
$query2->bindParam(':Total_Percent_B',$Total_Percent);
$query2->bindParam(':P_Max_B',$P_Max);
$query2->bindParam(':C_Max_B',$C_Max);
$query2->bindParam(':M_Max_B',$M_Max);
$query2->bindParam(':E_Max_B',$E_Max);
$query2->bindParam(':Tot_PCM_Max_B',$Tot_PCM_Max);
$query2->bindParam(':P_Obtain_B',$P_Obtain);
$query2->bindParam(':C_Obtain_B',$C_Obtain);
$query2->bindParam(':M_Obtain_B',$M_Obtain);
$query2->bindParam(':E_Obtain_B',$E_Obtain);
$query2->bindParam(':Tot_PCM_Obtain_B',$Tot_PCM_Obtain);
$query2->bindParam(':PCM_Percent_B',$PCM_Percent);
$query2->bindParam(':D_Update_B',$D_Update);
$query2->bindParam(':G_Student_ID_B',$G_Student_ID);

$query2->execute();


}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}

$C_msg=" Updated Successfully";

}//Update End
}// POST End


//Delete Starts
if(isset($_POST['A_Delete']))
{
$G_Student_ID=$_POST['G_Student_ID'];
try
{
$sql3="Delete from Student_Info where Student_ID=:G_Student_ID_B";
$query3 = $dbh->prepare($sql3);
$query3->bindParam(':G_Student_ID_B',$G_Student_ID);
$query3->execute();
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
$C_msg=" Deleted Successfully";
header("location:../Students/Students.php");
//exit;
}//Delete End





if($_GET)
{
//Fetch and Display
    $S_ID=$_GET['S_ID'];
    $_SESSION['Get_print']=$S_ID;
    $sql ="SELECT * FROM Student_Info where  Student_ID=:S_ID_B";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':S_ID_B', $S_ID);
    $query-> execute();
    $results2=$query->fetchAll(PDO::FETCH_OBJ);
    foreach($results2 as $res2){}

}
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
    <section class="content">
      <div class="container-fluid">

        <form method="post" action="Admission.php" name="Admission" id="Admission">
           <input type="hidden" name="G_Student_ID" id="G_Student_ID" value="<?php echo $S_ID; ?>">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default" >
          <div class="card-header" style="background-color:#90D3F4">
            <h3 class="card-title" style="font-weight:bold;color:blue;">1.Admission and CET/COMEDK Details:</h3>
            <div class="card-tools">
            <?php if(isset($_SESSION['Get_print'])) { ?>
            <a href="PrintStudent.php" target="_blank">
            <button type="button" id="dwn" class="btn btn-primary ">
             <i class="fas fa-print"></i> Print PDF File
             </button></a>
             <?php } ?>
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>


              <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button> -->

            </div>
          </div>
          <!-- /.card-header -->



          <div class="card-body" >
            <div class="row">

              <div class="col-md-4">
		  <div class="form-group">
                   <label>Course Name <font color="red">*</font></label>
                   <select class="form-control select2" id="Dept_Name" name="Dept_Name"  required>

                    	<?php
                    	if($_GET)
                    	{?>
                    	   <option value="<?php echo $res2->Dept_Name;?>" selected="selected"> <?php echo $res2->Dept_Name;?> </option>
                    	<?php
                    	}
                    	else
                    	{ ?>
                    	<option selected="selected"></option>
                    	<?php
                    	}

                      	$sql ="SELECT DISTINCT Dept_Name FROM Department order by Dept_Name ";
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


		<div class="col-md-2	">
		  <div class="form-group">
                   <label>Program <font color="red">*</font></label>

                   <select class="form-control select2"  id="Program" name="Program"  required>

                    <?php
                    if($_GET)
                    {?>
                    	   <option value="<?php echo $res2->Program;?>" selected="selected"> <?php echo $res2->Program;?> </option>
                    <?php
                    }
                    else
                    { ?>
                    	<option selected="selected"></option>
                    <?php
                    }?>

                  </select>
                  </div>
                <!-- /.form-group -->
		</div>


		<div class="col-md-2">
		  <div class="form-group">
                   <label style="font-size:14px">Admission Type <font color="red">*</font></label>

                   <select class="form-control select2"  id="Admission_Type" name="Admission_Type"  required>
                    <?php
                    if($_GET)
                    {?>
                    	   <option value="<?php echo $res2->Admission_Type;?>" selected="selected"><?php
                    	   echo strtoupper($res2->Admission_Type);?></option>
                    <?php
                    }
                    else
                    { ?>
                    	<option selected="selected"></option>
                    <?php
                    }?>

                    <option value="Regular">REGULAR</option>
                    <option value="Lateral Entry">LATERAL ENTRY</option>
                    <option value="Transfer Entry">TRANSFER ENTRY</option>
                    <option value="Re-Admission">RE-ADMISSION</option>
                  </select>
                  </div>
                <!-- /.form-group -->
		</div>





		<div class="col-md-2">
		  <div class="form-group">
                   <label style="font-size:14px">Admission Quota <font color="red">*</font></label>

                   <select class="form-control select2"  id="Admission_Quota" name="Admission_Quota"    required>

                    <?php
                    if($_GET)
                    {?>
                    	   <option value="<?php echo $res2->Admission_Quota;?>" selected="selected"> <?php echo $res2->Admission_Quota;?> </option>
                    <?php
                    }
                    else
                    { ?>
                    	<option selected="selected"></option>
                    <?php
                    }?>
                       <option value="MANAGEMENT">MANAGEMENT</option>
                       <option value="NATA">NATA</option>
                       <option value="NRI">NRI</option>
                       <option value="J&K-PMSSS">J&K-PMSSS</option>
                      <!-- <option value="J&K">J&K</option>

                       <option value="PGCET">PGCET</option>
                       <option value="COMED-K">COMED-K</option>
                       <option value="CET-SNQ">CET-SNQ</option> -->

                  </select>
                  </div>
                <!-- /.form-group -->
		</div>



		<div class="col-md-2">
		  <div class="form-group">
                   <label style="font-size:14px">Allotted Category <font color="red">*</font></label>

                   <select class="form-control select2"  id="Allotted_Category" name="Allotted_Category"  required>


                    <?php
                    if($_GET)
                    {?>
                    	   <option value="<?php echo $res2->Allotted_Category;?>" selected="selected"> <?php echo $res2->Allotted_Category;?> </option>
                    <?php
                    }
                    else
                    { ?>
                    	<option value="NONE" selected="selected">NONE</option>
                    <?php
                    }?>

                      <option value="NONE">NONE</option>
                      <option value="1G">1G</option>	<option value="1GH">1GH</option>	<option value="1GK">1GK</option>
<option value="1GKH">1GKH</option>	<option value="1GRK">1GRK</option>	<option value="1R">1R</option>
<option value="2A">2A</option>	<option value="2AG">2AG</option>	<option value="2GH">2GH</option>
<option value="2GK">2GK</option>	<option value="2GKH">2GKH</option>	<option value="2AGR">2AGR</option>
<option value="2AGRH">2AGRH</option>	<option value="2AGRK">2AGRK</option>	<option value="2AGRKH">2AGRKH</option>
<option value="2AR">2AR</option>	<option value="2B">2B</option>	<option value="2BG">2BG</option>
<option value="2BGH">2BGH</option>	<option value="2BGK">2BGK</option>	<option value="2BGRK">2BGRK</option>
<option value="2BR">2BR</option>	<option value="3A">3A</option>	<option value="3AG">3AG</option>
<option value="3AGH">3AGH</option>	<option value="3AGK">3AGK</option>	<option value="3AGR">3AGR</option>
<option value="3AGRH">3AGRH</option>	<option value="3AGRK">3AGRK</option>	<option value="3AGRKH">3AGRKH</option>
<option value="3AR">3AR</option>	<option value="3B">3B</option>	<option value="3BG">3BG</option>
<option value="3BGH">3BGH</option>	<option value="3BGK">3BGK</option>	<option value="3BGKH">3BGKH</option>
<option value="3BGR">3BGR</option>	<option value="3BGRH">3BGRH</option>	<option value="3BGRK">3BGRK</option>
<option value="3BGRKH">3BGRKH</option><option value="3BR">3BR</option>	<option value="GM">GM</option>
<option value="GMH">GMH</option>	<option value="GMK">GMK</option>	<option value="GMR">GMR</option>
<option value="GMRK">GMRK</option>	<option value="SC">SC</option>	<option value="SCG">SCG</option>
<option value="SCGH">SCGH</option>	<option value="SCGK">SCGK</option>	<option value="SCGKH">SCGKH</option>
<option value="SCGR">SCGR</option>	<option value="SCGRK">SCGRK</option>	<option value="SCGRKH">SCGRKH</option>
<option value="SCR">SCR</option>	<option value="SCRH">SCRH</option>	<option value="ST">ST</option>
<option value="STG">STG</option>	<option value="STGH">STGH</option>	<option value="STGK">STGK</option>
<option value="STGKH">STGKH</option>	<option value="STGRK">STGRK</option>	<option value="STR">STR</option>
<option value="SNQ">SNQ</option>	<option value="SPORTS">SPORTS</option>  <option value="EX-D">EX-D</option>
                  </select>
                  </div>
                <!-- /.form-group -->
		</div>







		<div class="col-md-3">
		 <div class="form-group">
                  <label style="font-size:14.5px">NATA Roll No</label>

                   <input  type="text" class="form-control input" name="CET_COMEDK_Order" id="CET_COMEDK_Order"
                   value="<?php echo $res2->CET_COMEDK_Order; ?>"  onKeyPress="if(this.value.length==19) return false;" autocomplete="off"/>
                 </div>
                 <!-- /.form-group -->
		</div>

<!--
		<div class="col-md-3">
		 <div class="form-group">
                  <label>CET/COMEDK TAT No</label>

                   <input  type="text" class="form-control input"  name="CET_COMEDK_TAT" id="CET_COMEDK_TAT"
                   value="<?php echo $res2->CET_COMEDK_TAT; ?>"  onKeyPress="if(this.value.length==19) return false;" autocomplete="off"/>
                 </div>
                 <!-- /.form-group
		</div>

-->











		<div class="col-md-3">
		 <div class="form-group">
                  <label>NATA MARKS</label>

                   <input  type="number" class="form-control input"  name="CET_COMEDK_Rank" id="CET_COMEDK_Rank"
                    value="<?php echo $res2->CET_COMEDK_Rank; ?>" onKeyPress="if(this.value.length==10) return false;"  autocomplete="off"/>
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-3">
		 <div class="form-group">
                  <label>Allotment Date</label>

                   <input  type="date" class="form-control input" name="CET_COMEDK_Date" id="CET_COMEDK_Date"
                    value="<?php echo $res2->CET_COMEDK_Date; ?>" />
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-3">
		 <div class="form-group">
                  <label>Fee Paid at NATA</label>

                   <input  type="number" class="form-control input"  name="CET_COMEDK_Fee" id="CET_COMEDK_Fee"
                   value="<?php echo $res2->CET_COMEDK_Fee; ?>"  onKeyPress="if(this.value.length==16) return false;" autocomplete="off"/>
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-3">
		 <div class="form-group">
                  <label>Fee Paid at College </label>

                   <input  type="number" class="form-control input"  name="College_Fee" id="College_Fee"
                   value="<?php echo $res2->College_Fee; ?>" onKeyPress="if(this.value.length==16) return false;"  autocomplete="off"/>
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-3">
		 <div class="form-group">
                  <label>Praaptha No <font color="red">*</font></label>

                   <input  type="text" class="form-control input"  name="Praaptha_No" id="Praaptha_No" required
                   value="<?php echo $res2->Praaptha_No; ?>"  onKeyPress="if(this.value.length==19) return false;"  autocomplete="off"/>
                 </div>
                 <!-- /.form-group -->
		</div>



		<div class="col-md-3">
		 <div class="form-group">
                  <label>Date of Joining <font color="red">*</font></label>

                   <input  type="date" class="form-control input" name="DOJ" id="DOJ"  required
                   value="<?php echo $res2->DOJ; ?>" />
                 </div>
                 <!-- /.form-group -->
		</div>








               <div class="col-md-2">
		  <div class="form-group">
                   <label>Batch <font color="red">*</font></label>

                   <select class="form-control select2"  id="Batch" name="Batch"  required>


                    <?php
                    if($_GET)
                    {?>
                    	   <option value="<?php echo $res2->Batch;?>" selected="selected"> <?php echo $res2->Batch;?> </option>
                    <?php
                    }
                    else
                    { ?>
                    	<option selected="selected"></option>
                    <?php
                    }?>


                       <?php
                       for($i=(date("Y")); $i>=(date("Y")-8);$i--)
                       {  ?>
                       <option value="<?php echo $i ?>"><?php echo $i ?></option>
                      <?php }
                       ?>
                  </select>
                  </div>
                <!-- /.form-group -->
		</div>



                 <div class="col-md-1">
		  <div class="form-group">
                   <label>Sem <font color="red">*</font></label>

                   <select class="form-control select2"  id="Sem" name="Sem"  required>

                    <?php
                    if($_GET)
                    {?>
                    	   <option value="<?php echo $res2->Sem;?>" selected="selected"> <?php echo $res2->Sem;?> </option>
                    <?php
                    }
                    else
                    { ?>
                    	<option value="Sem" selected="selected">Semester</option>
                    <?php
                    }?>

                       <?php
                       for($i=1; $i<=10;$i++)
                       {  ?>
                       <option value="<?php echo $i ?>"><?php echo $i ?></optio	n>
                      <?php }
                       ?>
                  </select>
                  </div>
                <!-- /.form-group -->
		</div>
<!--

               <div class="col-md-1">
		  <div class="form-group">
                   <label>Section</label>


                    <input  type="text" class="form-control input"  id="Section" name="Section"
                    value="<?php echo $res2->Section; ?>" readonly />

                  </div>
                <!-- /.form-group
		</div>
-->

<!--
               <div class="col-md-2">
		  <div class="form-group">
                   <label>Cycle</label>

                   <input  type="text" class="form-control input"  id="Cycle" name="Cycle"
                    value="<?php echo $res2->Cycle; ?>" readonly />


                  </div>
                <!-- /.form-group
		</div>
-->


                <div class="col-md-2">
		  <div class="form-group">
                   <label>Roll Number</label>

                   <input  type="text" class="form-control input"  name="C_Roll_Number" id="C_Roll_Number"
                    value="<?php echo $res2->C_Roll_Number; ?>"
                   placeholder="eg:20CSA01"  readonly/>
                  </div>
                <!-- /.form-group -->
		</div>



                <div class="col-md-2">
		  <div class="form-group">
                   <label>USN</label>

                  <input  type="text" class="form-control input"  name="C_USN" id="C_USN"  placeholder="eg:4NM10CS001"
                   value="<?php echo $res2->C_USN; ?>"  onkeyup="this.value = this.value.toUpperCase();" onKeyPress="if(this.value.length==14) return false;"  autocomplete="off"/>
                  </div>
                <!-- /.form-group -->
		</div>

<!--
                <div class="col-md-2">
		  <div class="form-group">
                   <label>Old USN</label>

                  <input  type="text" class="form-control input"  name="Old_USN" id="Old_USN" placeholder="Branch Change"
                   value="<?php echo $res2->Old_USN; ?>" onkeyup="this.value = this.value.toUpperCase();" onKeyPress="if(this.value.length==14) return false;"   autocomplete="off"/>
                  </div>
                <!-- /.form-group
		</div>

-->


              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
         </div>






















           <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header" style="background-color:#90D3F4">
          <h3 class="card-title" style="font-weight:bold;color:blue;">2.Personal Details:</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>

            </div>
          </div>
          <!-- /.card-header -->



          <div class="card-body" >
            <div class="row">

            <div class="col-md-3">
		 <div class="form-group">
                  <label>Student Name <font color="red">*</font></label>

                   <input  type="text" class="form-control input" name="Student_Name" id="Student_Name"
                    value="<?php echo $res2->Student_Name; ?>" onkeyup="this.value = this.value.toUpperCase();" required
                     autocomplete="off" onKeyPress="if(this.value.length==49) return false;" />
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-3">
		  <div class="form-group">
                   <label>Gender <font color="red">*</font></label>

                   <select class="form-control select2"  id="Gender" name="Gender"  required>

                    <?php
                    if($_GET)
                    {?>
                    	   <option value="<?php echo $res2->Gender;?>" selected="selected"> <?php echo $res2->Gender;?> </option>
                    <?php
                    }
                    else
                    { ?>
                    	<option selected="selected"></option>
                    <?php
                    }?>

                     <option value="MALE">MALE</option>
                     <option value="FEMALE">FEMALE</option>
                     <option value="TRANSGENDER">TRANSGENDER</option>
                  </select>
                  </div>
                <!-- /.form-group -->
		</div>



		<div class="col-md-3">
		 <div class="form-group">
                  <label>Date of Birth <font color="red">*</font></label>

                   <input  type="Date" class="form-control input" name="DOB" id="DOB"
                    value="<?php echo $res2->DOB; ?>"  required/>
                 </div>
                 <!-- /.form-group -->
		</div>





		<div class="col-md-3">
		 <div class="form-group">
                  <label>Student's Aadhaar No/Passport No <font color="red">*</font></label>

                   <input  type="text" class="form-control input" name="Aadhaar" id="Aadhaar"
                    value="<?php echo $res2->Aadhaar; ?>"  required  onKeyPress="if(this.value.length==14) return false;" autocomplete="off" />
                 </div>
                 <!-- /.form-group -->
		</div>




		<div class="col-md-3">
		  <div class="form-group">
                   <label>Blood Group <font color="red"></font></label>

                   <select class="form-control select2"  id="Blood" name="Blood"  >


                    <?php
                    if($_GET)
                    {?>
                    	   <option value="<?php echo $res2->Blood;?>" selected="selected"> <?php echo $res2->Blood;?> </option>
                    <?php
                    }
                    else
                    { ?>
                    	<option selected="selected"></option>
                    <?php
                    }?>



					     <option value="A+ve">A+ve</option>
                                            <option value="A-ve">A-ve</option>
                                            <option value="B+ve">B+ve</option>
                                            <option value="B-ve">B-ve</option>
                                            <option value="AB+ve">AB+ve</option>
                                            <option value="AB-ve">AB-ve</option>
                                            <option value="O+ve">O+ve</option>
                                            <option value="O-ve">O-ve</option>
                  </select>
                  </div>
                <!-- /.form-group -->
		</div>





		<div class="col-md-3">
		  <div class="form-group">
                   <label>Religion <font color="red">*</font></label>

                   <select class="form-control select2"  id="Religion" name="Religion"  required>

                    <?php
                    if($_GET)
                    {?>
                    	   <option value="<?php echo $res2->Religion;?>" selected="selected"> <?php echo $res2->Religion;?> </option>
                    <?php
                    }
                    else
                    { ?>
                    	<option selected="selected"></option>
                    <?php
                    }?>

 					     <option value="HINDU">HINDU</option>
                                            <option value="CHRISTIAN">CHRISTIAN</option>
                                            <option value="MUSLIM">MUSLIM</option>
                                             <option value="OTHER">OTHER</option>
                  </select>
                  </div>
                <!-- /.form-group -->
		</div>








		<div class="col-md-3">
		  <div class="form-group">
                   <label>Category <font color="red">*</font></label>

                   <select class="form-control select2"  id="Category" name="Category"  required>

                    <?php
                    if($_GET)
                    {?>
                    	   <option value="<?php echo $res2->Category;?>" selected="selected"> <?php echo $res2->Category;?> </option>
                    <?php
                    }
                    else
                    { ?>
                    	   <option value="NONE" selected="selected">NONE</option>
                    <?php
                    }?>

                      			     <option value="NONE">NONE</option>
					     <option value="GM">GM</option>
                                            <option value="Cat-1">Cat-1</option>
                                            <option value="2A">2A</option>
                                            <option value="2B">2B</option>
                                            <option value="3A">3A</option>
                                            <option value="3B">3B</option>
                                            <option value="SC">SC</option>
                                            <option value="ST">ST</option>
					    <option value="OBC">OBC</option>
                  </select>
                  </div>
                <!-- /.form-group -->
		</div>


		<div class="col-md-3">
		 <div class="form-group">
                  <label>Caste <font color="red"></font></label>

                   <input  type="text" class="form-control input" name="Caste" id="Caste"
                    value="<?php echo $res2->Caste; ?>" onkeyup="this.value = this.value.toUpperCase();" onKeyPress="if(this.value.length==29) return false;"  />
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-4">
		 <div class="form-group">
                  <label>Mother Tongue <font color="red"></font></label>

                   <input  type="text" class="form-control input" name="Mother_Tongue" id="Mother_Tongue"
                   onKeyPress="if(this.value.length==29) return false;"  value="<?php echo $res2->Mother_Tongue; ?>" onkeyup="this.value = this.value.toUpperCase();" />
                 </div>
                 <!-- /.form-group -->
		</div>


<!-- Nationality START-->

<div class="col-md-4">
  <div class="form-group">
               <label>Nationality <font color="red">*</font></label>

               <select class="form-control select2"  id="Nationality" name="Nationality"  required>

                <?php
                if($_GET)
                {?>
                     <option value="<?php echo $res2->Nationality;?>" selected="selected"> <?php echo $res2->Nationality;?> </option>
                <?php
                }
                else
                { ?>
                  <option selected="selected"></option>
                <?php
                }?>


                  <OPTION VALUE="INDIAN">INDIAN</OPTION>
                  <OPTION VALUE="AFGHAN">AFGHAN</OPTION>
                  <OPTION VALUE="ALBANIAN">ALBANIAN</OPTION>
                  <OPTION VALUE="ALGERIAN">ALGERIAN</OPTION>
                  <OPTION VALUE="AMERICAN">AMERICAN</OPTION>
                  <OPTION VALUE="ANDORRAN">ANDORRAN</OPTION>
                  <OPTION VALUE="ANGOLAN">ANGOLAN</OPTION>
                  <OPTION VALUE="ANTIGUANS">ANTIGUANS</OPTION>
                  <OPTION VALUE="ARGENTINEAN">ARGENTINEAN</OPTION>
                  <OPTION VALUE="ARMENIAN">ARMENIAN</OPTION>
                  <OPTION VALUE="AUSTRALIAN">AUSTRALIAN</OPTION>
                  <OPTION VALUE="AUSTRIAN">AUSTRIAN</OPTION>
                  <OPTION VALUE="AZERBAIJANI">AZERBAIJANI</OPTION>
                  <OPTION VALUE="BAHAMIAN">BAHAMIAN</OPTION>
                  <OPTION VALUE="BAHRAINI">BAHRAINI</OPTION>
                  <OPTION VALUE="BANGLADESHI">BANGLADESHI</OPTION>
                  <OPTION VALUE="BARBADIAN">BARBADIAN</OPTION>
                  <OPTION VALUE="BARBUDANS">BARBUDANS</OPTION>
                  <OPTION VALUE="BATSWANA">BATSWANA</OPTION>
                  <OPTION VALUE="BELARUSIAN">BELARUSIAN</OPTION>
                  <OPTION VALUE="BELGIAN">BELGIAN</OPTION>
                  <OPTION VALUE="BELIZEAN">BELIZEAN</OPTION>
                  <OPTION VALUE="BENINESE">BENINESE</OPTION>
                  <OPTION VALUE="BHUTANESE">BHUTANESE</OPTION>
                  <OPTION VALUE="BOLIVIAN">BOLIVIAN</OPTION>
                  <OPTION VALUE="BOSNIAN">BOSNIAN</OPTION>
                  <OPTION VALUE="BRAZILIAN">BRAZILIAN</OPTION>
                  <OPTION VALUE="BRITISH">BRITISH</OPTION>
                  <OPTION VALUE="BRUNEIAN">BRUNEIAN</OPTION>
                  <OPTION VALUE="BULGARIAN">BULGARIAN</OPTION>
                  <OPTION VALUE="BURKINABE">BURKINABE</OPTION>
                  <OPTION VALUE="BURMESE">BURMESE</OPTION>
                  <OPTION VALUE="BURUNDIAN">BURUNDIAN</OPTION>
                  <OPTION VALUE="CAMBODIAN">CAMBODIAN</OPTION>
                  <OPTION VALUE="CAMEROONIAN">CAMEROONIAN</OPTION>
                  <OPTION VALUE="CANADIAN">CANADIAN</OPTION>
                  <OPTION VALUE="CAPE VERDEAN">CAPE VERDEAN</OPTION>
                  <OPTION VALUE="CENTRAL AFRICAN">CENTRAL AFRICAN</OPTION>
                  <OPTION VALUE="CHADIAN">CHADIAN</OPTION>
                  <OPTION VALUE="CHILEAN">CHILEAN</OPTION>
                  <OPTION VALUE="CHINESE">CHINESE</OPTION>
                  <OPTION VALUE="COLOMBIAN">COLOMBIAN</OPTION>
                  <OPTION VALUE="COMORAN">COMORAN</OPTION>
                  <OPTION VALUE="CONGOLESE">CONGOLESE</OPTION>
                  <OPTION VALUE="COSTA RICAN">COSTA RICAN</OPTION>
                  <OPTION VALUE="CROATIAN">CROATIAN</OPTION>
                  <OPTION VALUE="CUBAN">CUBAN</OPTION>
                  <OPTION VALUE="CYPRIOT">CYPRIOT</OPTION>
                  <OPTION VALUE="CZECH">CZECH</OPTION>
                  <OPTION VALUE="DANISH">DANISH</OPTION>
                  <OPTION VALUE="DJIBOUTI">DJIBOUTI</OPTION>
                  <OPTION VALUE="DOMINICAN">DOMINICAN</OPTION>
                  <OPTION VALUE="DUTCH">DUTCH</OPTION>
                  <OPTION VALUE="EAST TIMORESE">EAST TIMORESE</OPTION>
                  <OPTION VALUE="ECUADOREAN">ECUADOREAN</OPTION>
                  <OPTION VALUE="EGYPTIAN">EGYPTIAN</OPTION>
                  <OPTION VALUE="EMIRIAN">EMIRIAN</OPTION>
                  <OPTION VALUE="EQUATORIAL GUINEAN">EQUATORIAL GUINEAN</OPTION>
                  <OPTION VALUE="ERITREAN">ERITREAN</OPTION>
                  <OPTION VALUE="ESTONIAN">ESTONIAN</OPTION>
                  <OPTION VALUE="ETHIOPIAN">ETHIOPIAN</OPTION>
                  <OPTION VALUE="FIJIAN">FIJIAN</OPTION>
                  <OPTION VALUE="FILIPINO">FILIPINO</OPTION>
                  <OPTION VALUE="FINNISH">FINNISH</OPTION>
                  <OPTION VALUE="FRENCH">FRENCH</OPTION>
                  <OPTION VALUE="GABONESE">GABONESE</OPTION>
                  <OPTION VALUE="GAMBIAN">GAMBIAN</OPTION>
                  <OPTION VALUE="GEORGIAN">GEORGIAN</OPTION>
                  <OPTION VALUE="GERMAN">GERMAN</OPTION>
                  <OPTION VALUE="GHANAIAN">GHANAIAN</OPTION>
                  <OPTION VALUE="GREEK">GREEK</OPTION>
                  <OPTION VALUE="GRENADIAN">GRENADIAN</OPTION>
                  <OPTION VALUE="GUATEMALAN">GUATEMALAN</OPTION>
                  <OPTION VALUE="GUINEA-BISSAUAN">GUINEA-BISSAUAN</OPTION>
                  <OPTION VALUE="GUINEAN">GUINEAN</OPTION>
                  <OPTION VALUE="GUYANESE">GUYANESE</OPTION>
                  <OPTION VALUE="HAITIAN">HAITIAN</OPTION>
                  <OPTION VALUE="HERZEGOVINIAN">HERZEGOVINIAN</OPTION>
                  <OPTION VALUE="HONDURAN">HONDURAN</OPTION>
                  <OPTION VALUE="HUNGARIAN">HUNGARIAN</OPTION>
                  <OPTION VALUE="ICELANDER">ICELANDER</OPTION>
                  <OPTION VALUE="INDONESIAN">INDONESIAN</OPTION>
                  <OPTION VALUE="IRANIAN">IRANIAN</OPTION>
                  <OPTION VALUE="IRAQI">IRAQI</OPTION>
                  <OPTION VALUE="IRISH">IRISH</OPTION>
                  <OPTION VALUE="ISRAELI">ISRAELI</OPTION>
                  <OPTION VALUE="ITALIAN">ITALIAN</OPTION>
                  <OPTION VALUE="IVORIAN">IVORIAN</OPTION>
                  <OPTION VALUE="JAMAICAN">JAMAICAN</OPTION>
                  <OPTION VALUE="JAPANESE">JAPANESE</OPTION>
                  <OPTION VALUE="JORDANIAN">JORDANIAN</OPTION>
                  <OPTION VALUE="KAZAKHSTANI">KAZAKHSTANI</OPTION>
                  <OPTION VALUE="KENYAN">KENYAN</OPTION>
                  <OPTION VALUE="KITTIAN AND NEVISIAN">KITTIAN AND NEVISIAN</OPTION>
                  <OPTION VALUE="KUWAITI">KUWAITI</OPTION>
                  <OPTION VALUE="KYRGYZ">KYRGYZ</OPTION>
                  <OPTION VALUE="LAOTIAN">LAOTIAN</OPTION>
                  <OPTION VALUE="LATVIAN">LATVIAN</OPTION>
                  <OPTION VALUE="LEBANESE">LEBANESE</OPTION>
                  <OPTION VALUE="LIBERIAN">LIBERIAN</OPTION>
                  <OPTION VALUE="LIBYAN">LIBYAN</OPTION>
                  <OPTION VALUE="LIECHTENSTEINER">LIECHTENSTEINER</OPTION>
                  <OPTION VALUE="LITHUANIAN">LITHUANIAN</OPTION>
                  <OPTION VALUE="LUXEMBOURGER">LUXEMBOURGER</OPTION>
                  <OPTION VALUE="MACEDONIAN">MACEDONIAN</OPTION>
                  <OPTION VALUE="MALAGASY">MALAGASY</OPTION>
                  <OPTION VALUE="MALAWIAN">MALAWIAN</OPTION>
                  <OPTION VALUE="MALAYSIAN">MALAYSIAN</OPTION>
                  <OPTION VALUE="MALDIVAN">MALDIVAN</OPTION>
                  <OPTION VALUE="MALIAN">MALIAN</OPTION>
                  <OPTION VALUE="MALTESE">MALTESE</OPTION>
                  <OPTION VALUE="MARSHALLESE">MARSHALLESE</OPTION>
                  <OPTION VALUE="MAURITANIAN">MAURITANIAN</OPTION>
                  <OPTION VALUE="MAURITIAN">MAURITIAN</OPTION>
                  <OPTION VALUE="MEXICAN">MEXICAN</OPTION>
                  <OPTION VALUE="MICRONESIAN">MICRONESIAN</OPTION>
                  <OPTION VALUE="MOLDOVAN">MOLDOVAN</OPTION>
                  <OPTION VALUE="MONACAN">MONACAN</OPTION>
                  <OPTION VALUE="MONGOLIAN">MONGOLIAN</OPTION>
                  <OPTION VALUE="MOROCCAN">MOROCCAN</OPTION>
                  <OPTION VALUE="MOSOTHO">MOSOTHO</OPTION>
                  <OPTION VALUE="MOTSWANA">MOTSWANA</OPTION>
                  <OPTION VALUE="MOZAMBICAN">MOZAMBICAN</OPTION>
                  <OPTION VALUE="NAMIBIAN">NAMIBIAN</OPTION>
                  <OPTION VALUE="NAURUAN">NAURUAN</OPTION>
                  <OPTION VALUE="NEPALESE">NEPALESE</OPTION>
                  <OPTION VALUE="NEW ZEALANDER">NEW ZEALANDER</OPTION>
                  <OPTION VALUE="NI-VANUATU">NI-VANUATU</OPTION>
                  <OPTION VALUE="NICARAGUAN">NICARAGUAN</OPTION>
                  <OPTION VALUE="NIGERIEN">NIGERIEN</OPTION>
                  <OPTION VALUE="NORTH KOREAN">NORTH KOREAN</OPTION>
                  <OPTION VALUE="NORTHERN IRISH">NORTHERN IRISH</OPTION>
                  <OPTION VALUE="NORWEGIAN">NORWEGIAN</OPTION>
                  <OPTION VALUE="OMANI">OMANI</OPTION>
                  <OPTION VALUE="PAKISTANI">PAKISTANI</OPTION>
                  <OPTION VALUE="PALAUAN">PALAUAN</OPTION>
                  <OPTION VALUE="PANAMANIAN">PANAMANIAN</OPTION>
                  <OPTION VALUE="PAPUA NEW GUINEAN">PAPUA NEW GUINEAN</OPTION>
                  <OPTION VALUE="PARAGUAYAN">PARAGUAYAN</OPTION>
                  <OPTION VALUE="PERUVIAN">PERUVIAN</OPTION>
                  <OPTION VALUE="POLISH">POLISH</OPTION>
                  <OPTION VALUE="PORTUGUESE">PORTUGUESE</OPTION>
                  <OPTION VALUE="QATARI">QATARI</OPTION>
                  <OPTION VALUE="ROMANIAN">ROMANIAN</OPTION>
                  <OPTION VALUE="RUSSIAN">RUSSIAN</OPTION>
                  <OPTION VALUE="RWANDAN">RWANDAN</OPTION>
                  <OPTION VALUE="SAINT LUCIAN">SAINT LUCIAN</OPTION>
                  <OPTION VALUE="SALVADORAN">SALVADORAN</OPTION>
                  <OPTION VALUE="SAMOAN">SAMOAN</OPTION>
                  <OPTION VALUE="SAN MARINESE">SAN MARINESE</OPTION>
                  <OPTION VALUE="SAO TOMEAN">SAO TOMEAN</OPTION>
                  <OPTION VALUE="SAUDI">SAUDI</OPTION>
                  <OPTION VALUE="SCOTTISH">SCOTTISH</OPTION>
                  <OPTION VALUE="SENEGALESE">SENEGALESE</OPTION>
                  <OPTION VALUE="SERBIAN">SERBIAN</OPTION>
                  <OPTION VALUE="SEYCHELLOIS">SEYCHELLOIS</OPTION>
                  <OPTION VALUE="SIERRA LEONEAN">SIERRA LEONEAN</OPTION>
                  <OPTION VALUE="SINGAPOREAN">SINGAPOREAN</OPTION>
                  <OPTION VALUE="SLOVAKIAN">SLOVAKIAN</OPTION>
                  <OPTION VALUE="SLOVENIAN">SLOVENIAN</OPTION>
                  <OPTION VALUE="SOLOMON ISLANDER">SOLOMON ISLANDER</OPTION>
                  <OPTION VALUE="SOMALI">SOMALI</OPTION>
                  <OPTION VALUE="SOUTH AFRICAN">SOUTH AFRICAN</OPTION>
                  <OPTION VALUE="SOUTH KOREAN">SOUTH KOREAN</OPTION>
                  <OPTION VALUE="SPANISH">SPANISH</OPTION>
                  <OPTION VALUE="SRI LANKAN">SRI LANKAN</OPTION>
                  <OPTION VALUE="SUDANESE">SUDANESE</OPTION>
                  <OPTION VALUE="SURINAMER">SURINAMER</OPTION>
                  <OPTION VALUE="SWAZI">SWAZI</OPTION>
                  <OPTION VALUE="SWEDISH">SWEDISH</OPTION>
                  <OPTION VALUE="SWISS">SWISS</OPTION>
                  <OPTION VALUE="SYRIAN">SYRIAN</OPTION>
                  <OPTION VALUE="TAIWANESE">TAIWANESE</OPTION>
                  <OPTION VALUE="TAJIK">TAJIK</OPTION>
                  <OPTION VALUE="TANZANIAN">TANZANIAN</OPTION>
                  <OPTION VALUE="THAI">THAI</OPTION>
                  <OPTION VALUE="TOGOLESE">TOGOLESE</OPTION>
                  <OPTION VALUE="TONGAN">TONGAN</OPTION>
                  <OPTION VALUE="TRINIDADIAN OR TOBAGONIAN">TRINIDADIAN OR TOBAGONIAN</OPTION>
                  <OPTION VALUE="TUNISIAN">TUNISIAN</OPTION>
                  <OPTION VALUE="TURKISH">TURKISH</OPTION>
                  <OPTION VALUE="TUVALUAN">TUVALUAN</OPTION>
                  <OPTION VALUE="UGANDAN">UGANDAN</OPTION>
                  <OPTION VALUE="UKRAINIAN">UKRAINIAN</OPTION>
                  <OPTION VALUE="URUGUAYAN">URUGUAYAN</OPTION>
                  <OPTION VALUE="UZBEKISTANI">UZBEKISTANI</OPTION>
                  <OPTION VALUE="VENEZUELAN">VENEZUELAN</OPTION>
                  <OPTION VALUE="VIETNAMESE">VIETNAMESE</OPTION>
                  <OPTION VALUE="WELSH">WELSH</OPTION>
                  <OPTION VALUE="YEMENITE">YEMENITE</OPTION>
                  <OPTION VALUE="ZAMBIAN">ZAMBIAN</OPTION>
                  <OPTION VALUE="ZIMBABWEAN">ZIMBABWEAN</OPTION>
              </select>
              </div>
            <!-- /.form-group -->
</div>
<!-- Nationality END -->
		<div class="col-md-4">
		  <div class="form-group">
                   <label>State of Domicile <font color="red">*</font></label>

                   <select class="form-control select2"  id="State_Domicile" name="State_Domicile"  required>

                    <?php
                    if($_GET)
                    {?>
                    	   <option value="<?php echo $res2->State_Domicile;?>" selected="selected"> <?php echo $res2->State_Domicile;?> </option>
                    <?php
                    }
                    else
                    { ?>
                    	<option selected="selected"></option>
                    <?php
                    }?>


<option value="ANDHRA PRADESH">ANDHRA PRADESH</option>
<option value="ANDAMAN AND NICOBAR ISLANDS">ANDAMAN AND NICOBAR ISLANDS</option>
<option value="ARUNACHAL PRADESH">ARUNACHAL PRADESH</option>
<option value="ASSAM">ASSAM</option>
<option value="BIHAR">BIHAR</option>
<option value="CHANDIGARH">CHANDIGARH</option>
<option value="CHHATTISGARH">CHHATTISGARH</option>
<option value="DADAR AND NAGAR HAVELI">DADAR AND NAGAR HAVELI</option>
<option value="DAMAN AND DIU">DAMAN AND DIU</option>
<option value="DELHI">DELHI</option>
<option value="LAKSHADWEEP">LAKSHADWEEP</option>
<option value="PUDUCHERRY">PUDUCHERRY</option>
<option value="GOA">GOA</option>
<option value="GUJARAT">GUJARAT</option>
<option value="HARYANA">HARYANA</option>
<option value="HIMACHAL PRADESH">HIMACHAL PRADESH</option>
<option value="JAMMU AND KASHMIR">JAMMU AND KASHMIR</option>
<option value="JHARKHAND">JHARKHAND</option>
<option value="KARNATAKA">KARNATAKA</option>
<option value="KERALA">KERALA</option>
<option value="MADHYA PRADESH">MADHYA PRADESH</option>
<option value="MAHARASHTRA">MAHARASHTRA</option>
<option value="MANIPUR">MANIPUR</option>
<option value="MEGHALAYA">MEGHALAYA</option>
<option value="MIZORAM">MIZORAM</option>
<option value="NAGALAND">NAGALAND</option>
<option value="ODISHA">ODISHA</option>
<option value="PUNJAB">PUNJAB</option>
<option value="RAJASTHAN">RAJASTHAN</option>
<option value="SIKKIM">SIKKIM</option>
<option value="TAMIL NADU">TAMIL NADU</option>
<option value="TELANGANA">TELANGANA</option>
<option value="TRIPURA">TRIPURA</option>
<option value="UTTAR PRADESH">UTTAR PRADESH</option>
<option value="UTTARAKHAND">UTTARAKHAND</option>
<option value="WEST BENGAL">WEST BENGAL</option>
<option value="NRI">NRI</option>
<option value="OTHERS">OTHERS</option>
                  </select>
                  </div>
                <!-- /.form-group -->
		</div>





		<div class="col-md-4">
		 <div class="form-group">
                  <label>Father Name <font color="red">*</font></label>

                   <input  type="text" class="form-control input" name="Father_Name" id="Father_Name" autocomplete="off"
                    value="<?php echo $res2->Father_Name; ?>" onkeyup="this.value = this.value.toUpperCase();"
                    onKeyPress="if(this.value.length==49) return false;"  required/>
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-4">
		 <div class="form-group">
                  <label>Father Occupation/Designation <font color="red">*</font></label>

                   <input  type="text" class="form-control input" name="Father_Designation" id="Father_Designation"
                    value="<?php echo $res2->Father_Designation; ?>" onkeyup="this.value = this.value.toUpperCase();"
                    onKeyPress="if(this.value.length==69) return false;"  />
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-4">
		 <div class="form-group">
                  <label>Father Annual Income <font color="red">*</font></label>

                   <input  type="number" class="form-control input" name="Father_Income" id="Father_Income" autocomplete="off"
              onKeyPress="if(this.value.length==17) return false;"      value="<?php
                    if($_GET){
                     	echo $res2->Father_Income;
		            }?>"   />
                 </div>
                 <!-- /.form-group -->
		</div>




		<div class="col-md-4">
		 <div class="form-group">
                  <label>Mother Name <font color="red">*</font></label>

                   <input  type="text" class="form-control input" name="Mother_Name" id="Mother_Name" autocomplete="off"
                     onKeyPress="if(this.value.length==49) return false;"
                    value="<?php echo $res2->Mother_Name; ?>" onkeyup="this.value = this.value.toUpperCase();" required />
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-4">
		 <div class="form-group">
                  <label>Mother Occupation/Designation <font color="red">*</font></label>

                   <input  type="text" class="form-control input" name="Mother_Designation" id="Mother_Designation"
                     onKeyPress="if(this.value.length==69) return false;"
                     value="<?php echo $res2->Mother_Designation; ?>" onkeyup="this.value = this.value.toUpperCase();"  />
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-4">
		 <div class="form-group">
                  <label>Mother Annual Income <font color="red">*</font></label>

                   <input  type="number"  onKeyPress="if(this.value.length==17) return false;" class="form-control input" name="Mother_Income"  id="Mother_Income" autocomplete="off"
                    value="<?php
                    if($_GET) {
                     	echo $res2->Mother_Income;
                       }
                    ?>"   />
                 </div>
                 <!-- /.form-group -->
		</div>



              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
         </div>





















          <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header" style="background-color:#90D3F4">
          <h3 class="card-title" style="font-weight:bold;color:blue;">3.Contact Details:</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" >
                <i class="fas fa-minus" ></i>
              </button>

            </div>
          </div>
          <!-- /.card-header -->



          <div class="card-body" >
            <div class="row">

<!--Country Code Start -->
              <div class="col-md-1.5">
                <div class="form-group">
                             <label>Country Code <font color="red"></font></label>

                             <select class="form-control select2"  id="Father_CID" name="Father_CID"  >


                              <?php
                              if($_GET)
                              {?>
                                   <option value="<?php echo $res2->Father_CID;?>" selected="selected"> <?php echo $res2->$Father_CID;?> </option>
                              <?php
                              }
                              else
                              { ?>
                                <option selected="selected"></option>
                              <?php
                              }?>



                              <option value="+1">United States (+1)</option>
                              <option value="+86">China (+86)</option>
                              <option value="+81">Japan (+81)</option>
                              <option value="+49">Germany (+49)</option>
                              <option value="+44">United Kingdom (+44)</option>
                              <option value="+33">France (+33)</option>
                              <option value="+91">India (+91)</option>
                              <option value="+55">Brazil (+55)</option>
                              <option value="+7">Russia (+7)</option>
                              <option value="+39">Italy (+39)</option>
                              <option value="+82">South Korea (+82)</option>
                              <option value="+52">Mexico (+52)</option>
                              <option value="+34">Spain (+34)</option>
                              <option value="+62">Indonesia (+62)</option>
                              <option value="+90">Turkey (+90)</option>
                              <option value="+1">Canada (+1)</option>
                              <option value="+61">Australia (+61)</option>
                              <option value="+966">Saudi Arabia (+966)</option>
                              <option value="+54">Argentina (+54)</option>
                              <option value="+48">Poland (+48)</option>
                              <option value="OTHERS">OTHERS</option>
                            </select>
                            </div>
                          <!-- /.form-group -->
              </div>
<!--Country Code Ends -->
             <div class="col-md-2">
		 <div class="form-group">
                  <label>Father Mobile  <font color="red">*</font></label>

                   <input  type="number" class="form-control input" name="Father_Mob" id="Father_Mob" autocomplete="off"
                    value="<?php echo $res2->Father_Mob; ?>"  onKeyPress="if(this.value.length==15) return false;" required />
                 </div>
                 <!-- /.form-group -->
	     </div>



	     <div class="col-md-4">
		 <div class="form-group">
                  <label>Father Email </label>

                   <input  type="Email" class="form-control input" name="Father_Email" id="Father_Email" autocomplete="off"
                    value="<?php echo $res2->Father_Email; ?>"  onKeyPress="if(this.value.length==69) return false;" />
                 </div>
                 <!-- /.form-group -->
	     </div>
       &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp

       <!--Country Code Start -->
                     <div class="col-md-1.5">
                       <div class="form-group">
                                    <label>Country Code <font color="red"></font></label>

                                    <select class="form-control select2"  id="Mother_CID" name="Mother_CID"  >


                                     <?php
                                     if($_GET)
                                     {?>
                                          <option value="<?php echo $res2->Mother_CID;?>" selected="selected"> <?php echo $res2->Mother_CID;?> </option>
                                     <?php
                                     }
                                     else
                                     { ?>
                                       <option selected="selected"></option>
                                     <?php
                                     }?>



                                     <option value="+1">United States (+1)</option>
                                     <option value="+86">China (+86)</option>
                                     <option value="+81">Japan (+81)</option>
                                     <option value="+49">Germany (+49)</option>
                                     <option value="+44">United Kingdom (+44)</option>
                                     <option value="+33">France (+33)</option>
                                     <option value="+91">India (+91)</option>
                                     <option value="+55">Brazil (+55)</option>
                                     <option value="+7">Russia (+7)</option>
                                     <option value="+39">Italy (+39)</option>
                                     <option value="+82">South Korea (+82)</option>
                                     <option value="+52">Mexico (+52)</option>
                                     <option value="+34">Spain (+34)</option>
                                     <option value="+62">Indonesia (+62)</option>
                                     <option value="+90">Turkey (+90)</option>
                                     <option value="+1">Canada (+1)</option>
                                     <option value="+61">Australia (+61)</option>
                                     <option value="+966">Saudi Arabia (+966)</option>
                                     <option value="+54">Argentina (+54)</option>
                                     <option value="+48">Poland (+48)</option>
                                     <option value="OTHERS">OTHERS</option>
                                   </select>
                                   </div>
                                 <!-- /.form-group -->
                     </div>
       <!--Country Code Ends -->
	     <div class="col-md-2">
		 <div class="form-group">
                  <label>Mother Mobile  </label>

                   <input  type="number" class="form-control input" name="Mother_Mob" id="Mother_Mob" autocomplete="off"
                    value="<?php echo $res2->Mother_Mob; ?>"  onKeyPress="if(this.value.length==15) return false;"/>
                 </div>
                 <!-- /.form-group -->
	     </div>


	      <div class="col-md-4">
		 <div class="form-group">
                  <label>Mother Email </label>

                   <input  type="Email" class="form-control input" name="Mother_Email" id="Mother_Email"  autocomplete="off"
                    value="<?php echo $res2->Mother_Email; ?>"  onKeyPress="if(this.value.length==69) return false;"/>
                 </div>
                 <!-- /.form-group -->
	     </div>
             &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
       <!--Country Code Start -->
                     <div class="col-md-1.5">
                       <div class="form-group">
                                    <label>Country Code <font color="red"></font></label>

                                    <select class="form-control select2"  id="Guardian_CID" name="Guardian_CID"  >


                                     <?php
                                     if($_GET)
                                     {?>
                                          <option value="<?php echo $res2->Guardian_CID;?>" selected="selected"> <?php echo $res2->Guardian_CID;?> </option>
                                     <?php
                                     }
                                     else
                                     { ?>
                                       <option selected="selected"></option>
                                     <?php
                                     }?>



                                     <option value="+1">United States (+1)</option>
                                     <option value="+86">China (+86)</option>
                                     <option value="+81">Japan (+81)</option>
                                     <option value="+49">Germany (+49)</option>
                                     <option value="+44">United Kingdom (+44)</option>
                                     <option value="+33">France (+33)</option>
                                     <option value="+91">India (+91)</option>
                                     <option value="+55">Brazil (+55)</option>
                                     <option value="+7">Russia (+7)</option>
                                     <option value="+39">Italy (+39)</option>
                                     <option value="+82">South Korea (+82)</option>
                                     <option value="+52">Mexico (+52)</option>
                                     <option value="+34">Spain (+34)</option>
                                     <option value="+62">Indonesia (+62)</option>
                                     <option value="+90">Turkey (+90)</option>
                                     <option value="+1">Canada (+1)</option>
                                     <option value="+61">Australia (+61)</option>
                                     <option value="+966">Saudi Arabia (+966)</option>
                                     <option value="+54">Argentina (+54)</option>
                                     <option value="+48">Poland (+48)</option>
                                     <option value="OTHERS">OTHERS</option>
                                   </select>
                                   </div>
                                 <!-- /.form-group -->
                     </div>
       <!--Country Code Ends -->
	     <div class="col-md-2">
		 <div class="form-group">
                  <label>Guardian Mobile </label>

                   <input  type="number" class="form-control input" name="Guardian_Mob" id="Guardian_Mob"  autocomplete="off"
                    value="<?php echo $res2->Guardian_Mob; ?>"  onKeyPress="if(this.value.length==15) return false;"/>
                 </div>
                 <!-- /.form-group -->
	     </div>



	     <div class="col-md-4">
		 <div class="form-group">
                  <label>Guardian Email  </label>

                   <input  type="Email" class="form-control input" name="Guardian_Email" id="Guardian_Email"  autocomplete="off"
                    value="<?php echo $res2->Guardian_Email; ?>"  onKeyPress="if(this.value.length==69) return false;" />
                 </div>
                 <!-- /.form-group -->
	     </div>
       &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
       <!--Country Code Start -->
                     <div class="col-md-1.5">
                       <div class="form-group">
                                    <label>Country Code <font color="red"></font></label>

                                    <select class="form-control select2"  id="Student_CID" name="Student_CID"  >


                                     <?php
                                     if($_GET)
                                     {?>
                                          <option value="<?php echo $res2->Student_CID;?>" selected="selected"> <?php echo $res2->Student_CID;?> </option>
                                     <?php
                                     }
                                     else
                                     { ?>
                                       <option selected="selected"></option>
                                     <?php
                                     }?>




                                <option value="+1">United States (+1)</option>
                                <option value="+86">China (+86)</option>
                                <option value="+81">Japan (+81)</option>
                                <option value="+49">Germany (+49)</option>
                                <option value="+44">United Kingdom (+44)</option>
                                <option value="+33">France (+33)</option>
                                <option value="+91">India (+91)</option>
                                <option value="+55">Brazil (+55)</option>
                                <option value="+7">Russia (+7)</option>
                                <option value="+39">Italy (+39)</option>
                                <option value="+82">South Korea (+82)</option>
                                <option value="+52">Mexico (+52)</option>
                                <option value="+34">Spain (+34)</option>
                                <option value="+62">Indonesia (+62)</option>
                                <option value="+90">Turkey (+90)</option>
                                <option value="+1">Canada (+1)</option>
                                <option value="+61">Australia (+61)</option>
                                <option value="+966">Saudi Arabia (+966)</option>
                                <option value="+54">Argentina (+54)</option>
                                <option value="+48">Poland (+48)</option>
                                <option value="OTHERS">OTHERS</option>
                                   </select>
                                   </div>
                                 <!-- /.form-group -->
                     </div>
       <!--Country Code Ends -->
	     <div class="col-md-2">
		 <div class="form-group">
                  <label>Student Mobile <font color="red">*</font></label>

                   <input  type="number" class="form-control input" name="Student_Mob" id="Student_Mob"  autocomplete="off"
                    value="<?php echo $res2->Student_Mob; ?>" required  onKeyPress="if(this.value.length==15) return false;"/>
                 </div>
                 <!-- /.form-group -->
	     </div>



	     <div class="col-md-4">
		 <div class="form-group">
                  <label>Student Email <font color="red">*</font></label>

                   <input  type="Email" class="form-control input" name="Student_Email" id="Student_Email"  autocomplete="off"
                    value="<?php echo $res2->Student_Email; ?>"  onKeyPress="if(this.value.length==69) return false;" required/>
                 </div>
                 <!-- /.form-group -->
	     </div>





	     <div class="col-md-6" style="background-color:#cf3">
		 <div class="form-group">
                  <label>COMMUNICATION ADDRESS <font color="red">*</font></label>
                    <textarea class="form-control textarea" rows="2" id="C_Address" name="C_Address" required
                    onkeyup="this.value = this.value.toUpperCase();" autocomplete="off"  onKeyPress="if(this.value.length==299) return false;"
                    ><?php echo $res2->C_Address; ?></textarea>
                 </div>
                 <!-- /.form-group -->
	     </div>








	     <div class="col-md-6" style="background-color:#cf3">
		  <div class="form-group">
                   <label>State <font color="red">*</font></label>

                   <select class="form-control select2"  id="C_State" name="C_State"  required>


                    <?php
                    if($_GET)
                    {?>
                    	   <option value="<?php echo $res2->C_State;?>" selected="selected"> <?php echo $res2->C_State;?> </option>
                    <?php
                    }
                    else
                    { ?>
                    	<option selected="selected"></option>
                    <?php
                    }?>


<option value="OTHER">OTHER</option>
<option value="ANDHRA PRADESH">ANDHRA PRADESH</option>
<option value="ANDAMAN AND NICOBAR ISLANDS">ANDAMAN AND NICOBAR ISLANDS</option>
<option value="ARUNACHAL PRADESH">ARUNACHAL PRADESH</option>
<option value="ASSAM">ASSAM</option>
<option value="BIHAR">BIHAR</option>
<option value="CHANDIGARH">CHANDIGARH</option>
<option value="CHHATTISGARH">CHHATTISGARH</option>
<option value="DADAR AND NAGAR HAVELI">DADAR AND NAGAR HAVELI</option>
<option value="DAMAN AND DIU">DAMAN AND DIU</option>
<option value="DELHI">DELHI</option>
<option value="LAKSHADWEEP">LAKSHADWEEP</option>
<option value="PUDUCHERRY">PUDUCHERRY</option>
<option value="GOA">GOA</option>
<option value="GUJARAT">GUJARAT</option>
<option value="HARYANA">HARYANA</option>
<option value="HIMACHAL PRADESH">HIMACHAL PRADESH</option>
<option value="JAMMU AND KASHMIR">JAMMU AND KASHMIR</option>
<option value="JHARKHAND">JHARKHAND</option>
<option value="KARNATAKA">KARNATAKA</option>
<option value="KERALA">KERALA</option>
<option value="MADHYA PRADESH">MADHYA PRADESH</option>
<option value="MAHARASHTRA">MAHARASHTRA</option>
<option value="MANIPUR">MANIPUR</option>
<option value="MEGHALAYA">MEGHALAYA</option>
<option value="MIZORAM">MIZORAM</option>
<option value="NAGALAND">NAGALAND</option>
<option value="ODISHA">ODISHA</option>
<option value="PUNJAB">PUNJAB</option>
<option value="RAJASTHAN">RAJASTHAN</option>
<option value="SIKKIM">SIKKIM</option>
<option value="TAMIL NADU">TAMIL NADU</option>
<option value="TELANGANA">TELANGANA</option>
<option value="TRIPURA">TRIPURA</option>
<option value="UTTAR PRADESH">UTTAR PRADESH</option>
<option value="UTTARAKHAND">UTTARAKHAND</option>
<option value="WEST BENGAL">WEST BENGAL</option>

                  </select>
                  </div>
                <!-- /.form-group -->
		</div>



	     <div class="col-md-5" style="background-color:#cf3">
		 <div class="form-group">
                  <label>District <font color="red">*</font></label>

                   <input  type="text" class="form-control input" name="C_District" id="C_District" required
                   onkeyup="this.value = this.value.toUpperCase();"  autocomplete="off"  onKeyPress="if(this.value.length==69) return false;"
                   value="<?php echo $res2->C_District; ?>" />
                 </div>
                 <!-- /.form-group -->
	     </div>

	      <div class="col-md-4" style="background-color:#cf3">

		 <div class="form-group">
                  <label>Taluk <font color="red">*</font></label>

                   <input  type="text" class="form-control input" name="C_Taluk" id="C_Taluk" required
                   onkeyup="this.value = this.value.toUpperCase();"  autocomplete="off"  onKeyPress="if(this.value.length==69) return false;"
                   value="<?php echo $res2->C_Taluk; ?>" />
                 </div>
                 <!-- /.form-group -->

	     </div>


                 <div class="col-md-3" style="background-color:#cf3">
                  <div class="form-group">
                  <label>PIN Code <font color="red">*</font></label>

                   <input  type="number" class="form-control input" name="C_Pin" id="C_Pin" required  autocomplete="off"
                   value="<?php echo $res2->C_Pin; ?>"  onKeyPress="if(this.value.length==9) return false;" />
                 </div>
                 <!-- /.form-group -->

	     </div>






	     <div class="col-md-2" style="background-color:#ef6">
                 <!-- /.form-group -->
	     </div>


	     <div class="col-md-8" style="background-color:#ef6">
		 <div class="form-group" >
                  <label style="margin-left:25px;text-align:center;color:blue"><i>Permanent Address Same As Cummunication Address</i></label>

                  <center><input style="margin-top:8px; width: 25px; height: 25px;"type="checkbox" name="Same" id="Same"></center>
                 </div>
                 <!-- /.form-group -->
	     </div>

	      <div class="col-md-2" style="background-color:#ef6">
                 <!-- /.form-group -->
	     </div>









	     <div class="col-md-6" style="background-color:#ee3">
		 <div class="form-group">
                  <label>PERMANENT ADDRESS <font color="red">*</font></label>
                    <textarea class="form-control textarea" rows="2" id="P_Address" name="P_Address" required
                    onkeyup="this.value = this.value.toUpperCase();"  autocomplete="off"  onKeyPress="if(this.value.length==299) return false;"
                     ><?php echo $res2->P_Address; ?></textarea>
                 </div>
                 <!-- /.form-group -->
	     </div>




		<div class="col-md-6" style="background-color:#ee3">
		  <div class="form-group">
                   <label>State <font color="red">*</font></label>

                   <select class="form-control select2"  id="P_State" name="P_State"  required>

                    <?php
                    if($_GET)
                    {?>
                    	   <option value="<?php echo $res2->P_State;?>" selected="selected"> <?php echo $res2->P_State;?> </option>
                    <?php
                    }
                    else
                    { ?>
                    	<option selected="selected"></option>
                    <?php
                    }?>


<option value="OTHER">OTHER</option>
<option value="ANDHRA PRADESH">ANDHRA PRADESH</option>
<option value="ANDAMAN AND NICOBAR ISLANDS">ANDAMAN AND NICOBAR ISLANDS</option>
<option value="ARUNACHAL PRADESH">ARUNACHAL PRADESH</option>
<option value="ASSAM">ASSAM</option>
<option value="BIHAR">BIHAR</option>
<option value="CHANDIGARH">CHANDIGARH</option>
<option value="CHHATTISGARH">CHHATTISGARH</option>
<option value="DADAR AND NAGAR HAVELI">DADAR AND NAGAR HAVELI</option>
<option value="DAMAN AND DIU">DAMAN AND DIU</option>
<option value="DELHI">DELHI</option>
<option value="LAKSHADWEEP">LAKSHADWEEP</option>
<option value="PUDUCHERRY">PUDUCHERRY</option>
<option value="GOA">GOA</option>
<option value="GUJARAT">GUJARAT</option>
<option value="HARYANA">HARYANA</option>
<option value="HIMACHAL PRADESH">HIMACHAL PRADESH</option>
<option value="JAMMU AND KASHMIR">JAMMU AND KASHMIR</option>
<option value="JHARKHAND">JHARKHAND</option>
<option value="KARNATAKA">KARNATAKA</option>
<option value="KERALA">KERALA</option>
<option value="MADHYA PRADESH">MADHYA PRADESH</option>
<option value="MAHARASHTRA">MAHARASHTRA</option>
<option value="MANIPUR">MANIPUR</option>
<option value="MEGHALAYA">MEGHALAYA</option>
<option value="MIZORAM">MIZORAM</option>
<option value="NAGALAND">NAGALAND</option>
<option value="ODISHA">ODISHA</option>
<option value="PUNJAB">PUNJAB</option>
<option value="RAJASTHAN">RAJASTHAN</option>
<option value="SIKKIM">SIKKIM</option>
<option value="TAMIL NADU">TAMIL NADU</option>
<option value="TELANGANA">TELANGANA</option>
<option value="TRIPURA">TRIPURA</option>
<option value="UTTAR PRADESH">UTTAR PRADESH</option>
<option value="UTTARAKHAND">UTTARAKHAND</option>
<option value="WEST BENGAL">WEST BENGAL</option>

                  </select>
                  </div>
                <!-- /.form-group -->
		</div>


		 <div class="col-md-5" style="background-color:#ee3">
		 <div class="form-group">
                  <label>District <font color="red">*</font></label>

                   <input  type="text" class="form-control input" name="P_District" id="P_District" required  autocomplete="off"
                   onkeyup="this.value = this.value.toUpperCase();"  onKeyPress="if(this.value.length==69) return false;"
                   value="<?php echo $res2->P_District; ?>" />
                 </div>
                 <!-- /.form-group -->
	     </div>



	    <div class="col-md-4" style="background-color:#ee3">

		 <div class="form-group">
                  <label>Taluk <font color="red">*</font></label>

                   <input  type="text" class="form-control input" name="P_Taluk" id="P_Taluk" required  autocomplete="off"
                   onkeyup="this.value = this.value.toUpperCase();"   onKeyPress="if(this.value.length==69) return false;"
                   value="<?php echo $res2->P_Taluk; ?>" />
                 </div>
                 <!-- /.form-group -->
	     </div>




                 <div class="col-md-3" style="background-color:#ee3">
                  <div class="form-group">
                  <label>PIN Code <font color="red">*</font></label>

                   <input  type="number" class="form-control input" name="P_Pin" id="P_Pin" required  autocomplete="off"
                   value="<?php echo $res2->P_Pin; ?>"  onKeyPress="if(this.value.length==9) return false;" />
                 </div>
                 <!-- /.form-group -->

	     </div>






              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
         </div>
















        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header" style="background-color:#90D3F4">
          <h3 class="card-title" style="font-weight:bold;color:blue;">4.PUC/12th/Degree Study Details:</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>

            </div>
          </div>
          <!-- /.card-header -->



          <div class="card-body" >
            <div class="row">




		<div class="col-md-2">
		  <div class="form-group">
                   <label style="font-size:14px">Qualified Course <font color="red">*</font></label>

                   <select class="form-control select2"  id="Q_Course" name="Q_Course"  required>

                    <?php
                    if($_GET)
                    {?>
                    	   <option value="<?php echo $res2->Q_Course;?>" selected="selected"> <?php echo $res2->Q_Course;?> </option>
                    <?php
                    }
                    else
                    { ?>
                    	<option selected="selected"></option>
                    <?php
                    }?>

                      			     <option value="PUC">PUC</option>
                                            <option value="CBSE">CBSE</option>
                                            <option value="HSC">HSC</option>
                                            <option value="ICSE">ICSE</option>
                                            <option value="Diploma">Diploma</option>
                                            <option value="EQ">EQ</option>
                                            <option value="Degree">Degree</option>
                                            <option value="Intermediate">Intermediate</option>
                  </select>
                  </div>
                <!-- /.form-group -->
		</div>



		<div class="col-md-5">
		 <div class="form-group">
                  <label>College Name <font color="red">*</font></label>

                   <input  type="text" class="form-control input" name="College_Name" id="College_Name"  autocomplete="off"
                   value="<?php echo $res2->College_Name; ?>" onkeyup="this.value = this.value.toUpperCase();"
                    onKeyPress="if(this.value.length==99) return false;" required/>
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-5">
		 <div class="form-group">
                  <label>Name of the Board <font color="red">*</font></label>

                   <input  type="text" class="form-control input" name="Board_Name" id="Board_Name"  autocomplete="on"
                   value="<?php echo $res2->Board_Name; ?>" onkeyup="this.value = this.value.toUpperCase();"
                    onKeyPress="if(this.value.length==99) return false;" required />
                 </div>
                 <!-- /.form-group -->
		</div>








		<div class="col-md-2">
		  <div class="form-group">
                   <label>Area Type <font color="red">*</font></label>

                   <select class="form-control select2"  id="Area_type" name="Area_type"  required>

                    <?php
                    if($_GET)
                    {?>
                    	   <option value="<?php echo $res2->Area_type;?>" selected="selected"> <?php echo $res2->Area_type;?> </option>
                    <?php
                    }
                    else
                    { ?>
                    	<option selected="selected"></option>
                    <?php
                    }?>

		          	<option value="URBAN">URBAN</option>
         			<option value="RURAL">RURAL</option>
                  </select>
                  </div>
                <!-- /.form-group -->
		</div>




		<div class="col-md-4">
		  <div class="form-group">
                   <label>Board State <font color="red">*</font></label>

                   <select class="form-control select2"  id="Board_State" name="Board_State"  required>


                    <?php
                    if($_GET)
                    {?>
                    	   <option value="<?php echo $res2->Board_State;?>" selected="selected"> <?php echo $res2->Board_State;?> </option>
                    <?php
                    }
                    else
                    { ?>
                    	<option selected="selected"></option>
                    <?php
                    }?>


<option value="OTHER">OTHER</option>
<option value="ANDHRA PRADESH">ANDHRA PRADESH</option>
<option value="ANDAMAN AND NICOBAR ISLANDS">ANDAMAN AND NICOBAR ISLANDS</option>
<option value="ARUNACHAL PRADESH">ARUNACHAL PRADESH</option>
<option value="ASSAM">ASSAM</option>
<option value="BIHAR">BIHAR</option>
<option value="CHANDIGARH">CHANDIGARH</option>
<option value="CHHATTISGARH">CHHATTISGARH</option>
<option value="DADAR AND NAGAR HAVELI">DADAR AND NAGAR HAVELI</option>
<option value="DAMAN AND DIU">DAMAN AND DIU</option>
<option value="DELHI">DELHI</option>
<option value="LAKSHADWEEP">LAKSHADWEEP</option>
<option value="PUDUCHERRY">PUDUCHERRY</option>
<option value="GOA">GOA</option>
<option value="GUJARAT">GUJARAT</option>
<option value="HARYANA">HARYANA</option>
<option value="HIMACHAL PRADESH">HIMACHAL PRADESH</option>
<option value="JAMMU AND KASHMIR">JAMMU AND KASHMIR</option>
<option value="JHARKHAND">JHARKHAND</option>
<option value="KARNATAKA">KARNATAKA</option>
<option value="KERALA">KERALA</option>
<option value="MADHYA PRADESH">MADHYA PRADESH</option>
<option value="MAHARASHTRA">MAHARASHTRA</option>
<option value="MANIPUR">MANIPUR</option>
<option value="MEGHALAYA">MEGHALAYA</option>
<option value="MIZORAM">MIZORAM</option>
<option value="NAGALAND">NAGALAND</option>
<option value="ODISHA">ODISHA</option>
<option value="PUNJAB">PUNJAB</option>
<option value="RAJASTHAN">RAJASTHAN</option>
<option value="SIKKIM">SIKKIM</option>
<option value="TAMIL NADU">TAMIL NADU</option>
<option value="TELANGANA">TELANGANA</option>
<option value="TRIPURA">TRIPURA</option>
<option value="UTTAR PRADESH">UTTAR PRADESH</option>
<option value="UTTARAKHAND">UTTARAKHAND</option>
<option value="WEST BENGAL">WEST BENGAL</option>
</select>
                  </div>
                <!-- /.form-group -->
		</div>




		<div class="col-md-3">
		 <div class="form-group">
                  <label>Year of Passing <font color="red">*</font></label>

                   <input  type="month" class="form-control input" name="Pass_Year" id="Pass_Year"
                   value="<?php echo $res2->Pass_Year; ?>" required />
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-3">
		 <div class="form-group">
                  <label>Date of Leaving <font color="red"></font></label>

                   <input  type="date" class="form-control input" name="Leaving_Date" id="Leaving_Date"
                   value="<?php echo $res2->Leaving_Date; ?>"  />
                 </div>
                 <!-- /.form-group -->
		</div>



		<div class="col-md-3">
		 <div class="form-group">
                  <label style="font-size:15px">Registration/Roll Number <font color="red">*</font></label>

                   <input  type="text" class="form-control input" name="Q_Reg_No" id="Q_Reg_No"  autocomplete="off"
                   value="<?php echo $res2->Q_Reg_No; ?>"  onkeyup="this.value = this.value.toUpperCase();"
                    onKeyPress="if(this.value.length==19) return false;" required/>
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-3">
		 <div class="form-group">
                  <label>Total Maximum Marks <font color="red">*</font></label>

                  <input type="number" class="form-control input" name="Total_Max" id="Total_Max"
                   onKeyPress="if(this.value.length==8) return false;"
                   value="<?php
                    if($_GET)
                     	echo $res2->Total_Max;
                    else
                    	echo 600;
                    ?>"

                  required/>
                 </div>
                 <!-- /.form-group -->
		</div>





		<div class="col-md-3">
		 <div class="form-group">
                  <label>Total Marks Obtained <font color="red">*</font></label>

                  <input type="number" class="form-control input" name="Total_Obtain" id="Total_Obtain"
                  value="<?php echo $res2->Total_Obtain; ?>"  onKeyPress="if(this.value.length==8) return false;" required autocomplete="off"/>
                 </div>
                 <!-- /.form-group -->
		</div>


		<div class="col-md-3">
		 <div class="form-group">
                  <label>Percentage/CGPA <font color="red">*</font></label>

                   <input type="number" class="form-control input" readonly name="Total_Percent" id="Total_Percent"

                     value="<?php
                    if($_GET)
                     	echo $res2->Total_Percent;
                    else
                    	echo 0;
                    ?>"

                    required/>
                 </div>
                 <!-- /.form-group -->
		</div>




           <style>
table {
  width:90%;
  margin-left: auto;
  margin-right: auto;
  font-size:15px;
  font-weight:bold;
}
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 15px;
  text-align: left;
}


#t03 tr:nth-child(even) {
  background-color: #eee;
}
#t03 tr:nth-child(odd) {
 background-color: #fff;
}
#t03 th {
  background-color: #6BB0D3;
  color: white;
}
</style>












		<div class="col-md-12">
		 <div class="form-group"  style="overflow-x:auto;">


		 <table id="t03">
		 	   <tr><th colspan="4" style="font-size:24px;"><center>PUC/12th MARKS</th></tr>
                          <tr>
                               	<th style="background-color:#5393B2;"><center>SUBJECTS</th>
                               	<th style="background-color:#5393B2;"><center>MAXIMUM MARKS</th>
                               	<th style="background-color:#5393B2;"><center>MARKS OBTAINED</th>
                               	<th style="background-color:#5393B2;"><center>PERCENTAGE/CGPA</th>
                          </tr>



                          <tr>
                          	<th><center>Physics</th>
                          	<td><input type="number" class="form-control input" name="P_Max" id="P_Max"
                          	 onKeyPress="if(this.value.length==8) return false;"
                          	  value="<?php
                    			if($_GET)
                     				echo $res2->P_Max;
                    			else
                    				echo 100;
                    			?>"
                          	 required/></td>
                               <td><input type="number" class="form-control input" name="P_Obtain" id="P_Obtain" autocomplete="off"
                                onKeyPress="if(this.value.length==8) return false;"
                                 value="<?php
                    			if($_GET)
                     				echo $res2->P_Obtain;
                    			?>"

                                required/></td>
                               <td></td>
                          </tr>



                          <tr>
                          <th><center>Chemistry</th>
                               <td><input type="number" class="form-control input" name="C_Max" id="C_Max"
                                onKeyPress="if(this.value.length==8) return false;"
                               value="<?php
                    			if($_GET)
                     				echo $res2->C_Max;
                    			else
                    				echo 100;
                    			?>"

                                required/></td>
                           	<td><input type="number" class="form-control input" name="C_Obtain" id="C_Obtain" autocomplete="off"
                           	 onKeyPress="if(this.value.length==8) return false;"
                           	value="<?php
                    			if($_GET)
                     				echo $res2->C_Obtain;

                    			?>"

                           	 required/></td>
                           	<td></td>
                          </tr>




                          <tr>
                              <th><center>Mathematics</th>
                              <td><input type="number" class="form-control input" name="M_Max" id="M_Max"
                               onKeyPress="if(this.value.length==8) return false;"
                              	value="<?php
                    			if($_GET)
                     				echo $res2->M_Max;
                    			else
                    				echo 100;
                    			?>"

                              required/></td>
                              <td><input type="number" class="form-control input" name="M_Obtain" id="M_Obtain" autocomplete="off"
                               onKeyPress="if(this.value.length==8) return false;"
                              value="<?php
                    			if($_GET)
                     				echo $res2->M_Obtain;

                    			?>"

                               required/></td>
                              <td></td>
                         </tr>


                         <tr>
                             <th><center>Total (PCM)</th>
                             <td><input type="number" class="form-control input" readonly name="Tot_PCM_Max" id="Tot_PCM_Max"

                              value="<?php
                    			if($_GET)
                     				echo $res2->Tot_PCM_Max;
                    			else
                    				echo 300;
                    			?>"


                              required/></td>
                             <td><input type="number" class="form-control input" readonly name="Tot_PCM_Obtain" id="Tot_PCM_Obtain"

                             value="<?php
                    			if($_GET)
                     				echo $res2->Tot_PCM_Obtain;
                    			else
                    				echo 0;
                    			?>"


                              required/></td>
                             <td><input type="number" class="form-control input" readonly name="PCM_Percent" id="PCM_Percent"


                             value="<?php
                    			if($_GET)
                     				echo $res2->PCM_Percent;
                    			else
                    				echo 0;
                    			?>"

                              required/></td>
                         </tr>



                          <tr>
                              <th><center>English</th>
                               <td><input type="number" class="form-control input" name="E_Max" id="E_Max"
                                onKeyPress="if(this.value.length==8) return false;"
                                value="<?php
                    			if($_GET)
                     				echo $res2->E_Max;
                    			else
                    				echo 100;
                    			?>"

                                required /></td>
                              <td><input type="number" class="form-control input" name="E_Obtain" id="E_Obtain" autocomplete="off"
                               onKeyPress="if(this.value.length==8) return false;"
                              value="<?php
                    			if($_GET)
                     				echo $res2->E_Obtain;

                    			?>"

                               required /></td>
                              <td></td>
                         </tr>

                      </table>




               </div>
                 <!-- /.form-group -->
		</div>




              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
         </div>






        <div class="card-footer">

        <?php
        if($_GET)
	{
	?>
	    <center><button type="submit" name="A_Update" id="A_Update" class="btn  btn-outline-success btn-lg ">Update Student Info</button>
      <button type="submit" name="A_Delete" id="A_Delete" class="btn  btn-outline-danger btn-lg ">Delete Student Info</button></center>

	<?php
	}
	else
	{
	?>
	   <center><button type="submit" name="A_Submit" id="A_Submit" class="btn  btn-outline-success btn-lg ">Submit Student Info</button></center>

	<?php
	}
	?>
          </div>




















         </form>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->





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
$(document).ready(function ()
{

var flag=0;

$("#Same").click(function(){
 if($(this).is(":checked"))
 {

    var ad1 = $("#C_Address").val();

    var tk1 = $("#C_Taluk").val();

    var dst1 = $("#C_District").val();
    var st1 = $("#C_State :selected").text();
    var pn1 = $("#C_Pin").val();
    $("#P_Address").val(ad1);


    $("#P_Taluk").val(tk1);
    $("#P_District").val(dst1);

    $("#P_State").val(st1).change();
    $("#P_Pin").val(pn1);
 }
 else
 {

    $("#P_Address").val("");

    $("#P_Taluk").val("");
    $("#P_District").val("");

    $("#P_State").val("").change();
    $("#P_Pin").val("");
 }

});


 $("#P_Max, #C_Max, #M_Max").change(function ()

 {
 var pm = parseInt($("#P_Max").val());
 var cm = parseInt($("#C_Max").val());
 var mm = parseInt($("#M_Max").val());
 if($("#P_Max").val()==""){pm=0;}
 if($("#C_Max").val()==""){cm=0;}
 if($("#M_Max").val()==""){mm=0;}
 var pcmm=pm+cm+mm;
 var pcmo = parseInt($("#Tot_PCM_Obtain").val());
 $("#Tot_PCM_Max").val(pcmm);
 $("#PCM_Percent").val( parseFloat((pcmo/pcmm)*100).toFixed(2));
 });


  $("#P_Obtain, #C_Obtain, #M_Obtain").change(function ()
 {
 var pm = parseInt($("#P_Obtain").val());
 var cm = parseInt($("#C_Obtain").val());
 var mm = parseInt($("#M_Obtain").val());
 if($("#P_Obtain").val()==""){pm=0;}
 if($("#C_Obtain").val()==""){cm=0;}
 if($("#M_Obtain").val()==""){mm=0;}
 var pcmo=pm+cm+mm;
 var pcmm = parseInt($("#Tot_PCM_Max").val());
 $("#Tot_PCM_Obtain").val(pcmo);
 $("#PCM_Percent").val( parseFloat((pcmo/pcmm)*100).toFixed(2));
 });


 $("#Total_Obtain, #Total_Max").change(function ()
 {
  var pmax = parseInt($("#Total_Max").val());
  var pobt = parseInt($("#Total_Obtain").val());
  $("#Total_Percent").val(parseFloat((pobt/pmax)*100).toFixed(2));
 });







$("#Dept_Name").change(function ()
{
    var val = $(this).val();

    $.ajax({
	type: 'POST',
	url: 'Ajax/Dept_Fetch.php',
	data: {d_name:val},
	success:function(data)
		{
		$("#Program").html(data);
		}
	    });



});

function test123()
{
var C_USN = $("#C_USN").val();
     var Old_USN = $("#Old_USN").val();
     var Praaptha_No = $("#Praaptha_No").val();
     var Batch = $("#Batch").val();
     var Section = $("#Section").val();
     var Sem = $("#Sem").val();
     var C_Roll_Number = $("#C_Roll_Number").val();
     var Aadhaar = $("#Aadhaar").val();
     var G_Student_ID = $("#G_Student_ID").val();

     if(G_Student_ID=="")
     {
      $.ajax({
	type: 'POST',
	url: 'Ajax/Validate_Fetch.php',
	data: {C_USN:C_USN,Old_USN:Old_USN,Praaptha_No:Praaptha_No,Batch:Batch,
	Section:Section,C_Roll_Number:C_Roll_Number,Aadhaar:Aadhaar,Sem:Sem},
	success:function(data)
		{
		//$("#Program").html(data);
			if(data!="Success")
			{
			alert(data);
			flag=1;
			}
			else
			{
			flag=0;
			}
		}
	    });
      }
      else
      {
      $.ajax({
	type: 'POST',
	url: 'Ajax/Validate_update.php',
	data: {C_USN:C_USN,Old_USN:Old_USN,Praaptha_No:Praaptha_No,Batch:Batch,
	Section:Section,C_Roll_Number:C_Roll_Number,Aadhaar:Aadhaar,Sem:Sem,G_Student_ID:G_Student_ID},
	success:function(data)
		{
		//$("#Program").html(data);
			if(data!="Success")
			{
			alert(data);
			flag=1;
			}
			else
			{
			flag=0;
			}
		}
	    });
      }
}

$("#C_USN,#Praaptha_No,#C_Roll_Number,#Aadhaar").change(function ()
{
    test123();
});




 $("#Admission").submit(function(event){

     var SelDate = new Date($("#DOB").val());
     var C_USN = $("#C_USN").val();
     var Old_USN = $("#Old_USN").val();
     var Section = $("#Section").val();
     var C_Roll_Number = $("#C_Roll_Number").val();


     if(flag==1)
     {
       test123();
       event.preventDefault();
       return false;
     }

     if(C_Roll_Number!="")
     {
       if(Section=="NA")
       {
       alert("Please Select The Section");
       $("#Section").focus();
       event.preventDefault();
        return false;
       }
     }



     if(Old_USN!="")
     {
      if(Old_USN==C_USN)
      {
       alert("No Difference in Present USN and OLD USN ");
       $("#C_USN").focus();
       event.preventDefault();
        return false;
      }
      else if(C_USN=="")
       {
       alert("Please Provide the Present USN");
       $("#C_USN").focus();
       event.preventDefault();
        return false;
       }
      }

     var Tdate = new Date();
     var diff = new Date(Tdate - SelDate);
     var days = diff/1000/60/60/24;

     if(days<5150)
     {
       // $("#DOB").val(""); //Empty the date
       alert("DOB is invalied");
       $("#DOB").focus();
       event.preventDefault();
       return false;
     }




});





});
</script>
