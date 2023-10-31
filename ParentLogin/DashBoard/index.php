<?php
session_start();
//require("connect.php");
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  // erase  notice
require("../DB/config.php");
include('Checklog.php');
$Status = null;
$ST_ID = $_SESSION['Student_ID'];
$Dept = $_SESSION['Dept_Name'];
$Pgm = $_SESSION['Program'];
$Sem = $_SESSION['Sem'];
$Section = $_SESSION['Section'];
$SName = $_SESSION['Student_Name'];
$USN = trim($_SESSION['C_USN']);

if (isset($_POST['Check'])) {

  $sql44c = "UPDATE Student_CIA SET Status = 1 WHERE Student_ID='$ST_ID'";
  $query44c = $dbh->prepare($sql44c);
  $query44c->execute();
}


$sqla = "Select Student_Info.Student_Name,Student_Info.C_Roll_Number,Student_Info.C_USN,Student_Info.Sem,
         Student_Info.Father_Name,
	 Student_Info.P_Address,Student_Info.P_State,Student_Info.P_Post,Student_Info.P_Pin, Student_Info.P_Taluk,
	 Student_Info.P_District,Student_Info.C_Address,Student_Info.C_State,Student_Info.C_Post,Student_Info.C_Pin,
	 Student_Info.C_Taluk, Student_Info.C_District  from Student_Info
	 where Student_Info.Student_ID='$ST_ID' ";




$querya = $dbh->prepare($sqla);
$querya->execute();
$results1 = $querya->fetchAll(PDO::FETCH_OBJ);

$Par1 = "";
$Flag = 0;
$FinalAddr = "";
foreach ($results1 as $res1) {
  if ($USN == "") {
    $USN = $res1->C_Roll_Number;
  }


  $Father_name = $res1->Father_Name;
  if ($res1->P_Address != "") {
    $P_Address = str_replace("\n", "<br>", $res1->P_Address);
    $P_Post = trim($res1->P_Post);
    $P_Taluk = trim($res1->P_Taluk);
    $P_District = trim($res1->P_District);
    $P_State = trim($res1->P_State);
    $P_Pin = trim($res1->P_Pin);
  } else {
    $P_Address = str_replace("\n", "<br>", $res1->C_Address);
    $P_Post = trim($res1->C_Post);
    $P_Taluk = trim($res1->C_Taluk);
    $P_District = trim($res1->C_District);
    $P_State = trim($res1->C_State);
    $P_Pin = trim($res1->C_Pin);
  }

  $FinalAddr = "" . $Father_name . "<br>";
  if ($P_Address != "") {
    $FinalAddr = $FinalAddr . $P_Address . "<br>";
  }
  if ($P_Taluk != "") {
    $FinalAddr = $FinalAddr . $P_Taluk . ",";
  }
  if ($P_Post != "") {
    $FinalAddr = $FinalAddr . $P_Post . "<br>";
  }
  if ($P_District != "") {
    $FinalAddr = $FinalAddr . $P_District . "<br>";
  }
  if ($P_State != "") {
    $FinalAddr = $FinalAddr . $P_State . "-";
  }
  if ($P_Pin != "") {
    $FinalAddr = $FinalAddr . $P_Pin . "<br>";
  }
}

?>



<!DOCTYPE html>
<html style="font-size: 16px;">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="page_type" content="np-template-header-footer-from-plugin">
  <title>NMAMIT | PARENT</title>
  <link rel="stylesheet" href="nicepage.css" media="screen">
  <link rel="stylesheet" href="Home.css" media="screen">
  <script class="u-script" type="text/javascript" src="jquery.js" defer=""></script>
  <script class="u-script" type="text/javascript" src="nicepage.js" defer=""></script>

  <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i">
  <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i">

  <!------------======================= the navbar links ==============------->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap Navbar with Logo Image</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <!------------======================= the navbar links ends ==============------->

  <script type="application/ld+json">
    {
      "logo": "images/logo.png"
    }
  </script>
  <meta name="theme-color" content="#478ac9">
  <meta property="og:title" content="Home">
  <meta property="og:description" content="">
  <meta property="og:type" content="website">
</head>

<body style="max-height:400px;max-width:1600px;overflow:auto;" data-home-page="index.php" data-home-page-title="Home" class="u-body">
  <header class="u-clearfix u-header u-header" id="sec-1610">
    <!--------------=============== Navbar Starts ---------================-->
    <div class="m-4">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
          <a href="#" class="navbar-brand">
            <img src="images/logo.png" height="28" alt="Logo">
          </a>
          <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarCollapse">

            <div class="navbar-nav ms-auto">
              <a href="index.php" class="nav-item nav-link active">Home</a>
              <a href="../Logout.php" class="nav-item nav-link active">Logout</a>
            </div>
          </div>
        </div>
      </nav>
    </div>
    <!--------------=============== Navbar Starts ---------================-->
  </header>

  <form id="myform" method="post" action="index.php">
    <section class="u-align-center u-clearfix u-image u-shading u-section-1" id="carousel_2382" data-image-width="1600" data-image-height="1067">
      <div class="u-clearfix u-sheet u-valign-middle-lg u-valign-middle-md u-valign-middle-sm u-valign-middle-xl u-sheet-1">
        <h2 class="u-custom-font u-font-source-sans-pro u-text u-text-1"><?php echo "$SName [$USN]"; ?></h2>
        <!--  <p class="u-text u-text-2"><?php echo "$Dept Engineering $Sem Sem $Pgm ($Section Section)"; ?></p> -->
        <?php echo "
<p align='justify' style='font-size:15px;font-weight:bold'>

To,<br>
$FinalAddr
<br>
<span style='font-size:15px;'>Dear Parent,</span><br>
The progress report of your ward Miss/Mr $SName-$USN studying in $Sem sem $Pgm '$Section' Section is as shown below:</p>";
        ?>
<!-------------------- ============== Table section starts --------------=================--->
        <div class="table-responsive">
          <table class="u-table-entity" style="width: 110px;">
            <style>
              .table-responsive {
                overflow-x: auto;
              }

              @media (max-width: 767px) {
                .u-table-entity {
                  width: 100%;
                }

                .u-table-entity th,
                .u-table-entity td {
                  padding: 8px;
                  text-align: left;
                }
              }
            </style>
            <colgroup>
              <col width="15%">
              <col width="60%">
              <col width="25%">
              <col width="25%">
              <col width="25%">
              <col width="25%">
              <col width="25%">
              <col width="25%">
              <col width="25%">
              <col width="25%">
              <col width="25%">
              <col width="25%">
              <col width="25%">
              <col width="25%">
              <col width="25%">
              <col width="40%">
              <col width="45%">


            </colgroup>
            <thead class="u-align-center u-palette-5-dark-3 u-table-header u-table-header-1">
              <tr style="height: 77px; width: 100px;">
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-1"></th>
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-1">Subject Name&nbsp;</th>
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-2">Task 1</th>
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-3">Task 2</th>
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-4">Task 3</th>
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-5">Task 4</th>
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-6">Task 5</th>
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-7">Task 6</th>
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-8">Task 7</th>
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-9">Task 8</th>
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-9">Task 9</th>
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-11">Task 10</th>
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-12">MSE I</th>
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-14">MSE II</th>
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-14">MSE III</th>
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-15">Classes<br>Held
                </th>
                <th class="u-border-2 u-border-no-left u-border-no-right u-border-palette-5-dark-1 u-table-cell u-table-cell-8">Classes<br>Attended
                </th>
              </tr>
            </thead>
            <tbody class="u-black u-table-body u-table-body-1">
              <?php

              $sqla = " Select Course_Registration.Student_ID, Course_Registration.Sub_ID,Course_Subjects.Subject_Code,
      Course_Subjects.Subject_Name,Course_Subjects.Hours, Total_Attendance.Total_Class,Total_Attendance.Total_Present
      from Course_Registration
      Left JOIN Course_Subjects ON Course_Registration.Sub_ID= Course_Subjects.Sub_ID
      Left JOIN Student_Info ON Course_Registration.Student_ID= Student_Info.Student_ID
      Left JOIN Total_Attendance ON Course_Registration.Student_ID=Total_Attendance.Student_ID
      and Course_Registration.Sub_ID= Total_Attendance.Sub_ID
      where Course_Registration.Student_ID='$ST_ID'  and Course_Subjects.Sem='$Sem'   ORDER BY Course_Subjects.Hours ASC";

              $Slno = 0;
              $querya = $dbh->prepare($sqla);
              $querya->execute();
              $results1 = $querya->fetchAll(PDO::FETCH_OBJ);
              foreach ($results1 as $res1) {

                // add the subject Card code over here
                $Slno = $Slno + 1;
                $s_id = $res1->Sub_ID;
                $s_code = $res1->Subject_Code;
                $s_name = $res1->Subject_Name;
                $tot_c = $res1->Total_Class;
                $tot_p = $res1->Total_Present;


                if ($tot_c != 0) {
                  $Att = ($tot_p / $tot_c) * 100;
                } else {
                  echo "Error: Division by zero";
                }

                $Att_per = $Att;
                $att_sig = "";
                if ($Att_per < 85) {
                  $att_sig = "#";
                  if ($Att_per < 75) {
                    $att_sig = "!";
                  }
                }

                $poor_m1 = "";
                $poor_c1 = "";
                $poor_m2 = "";
                $poor_c2 = "";
                $poor_m3 = "";
                $poor_c3 = "";
                $tk_1 = "";
                $tk_2 = "";
                $tk_3 = "";
                $tk_4 = "";
                $tk_5 = "";
                $tk_6 = "";
                $tk_7 = "";
                $tk_8 = "";
                $tk_9 = "";
                $tk_10 = "";
                $ms_1 = "";
                $ms_2 = "";
                $ms_3 = "";
                $tx_1 = "";
                $tx_2 = "";
                $tx_3 = "";
                $tx_4 = "";
                $tx_5 = "";
                $tx_6 = "";
                $tx_7 = "";
                $tx_8 = "";
                $tx_9 = "";
                $tx_10 = "";
                $mx_1 = "";
                $mx_2 = "";
                $mx_3 = "";

                $sqlf = "SELECT Occasion,Mark,Status,Max_Mark,Attendance from Student_CIA WHERE Student_ID='$ST_ID' and Sub_ID='$s_id' ";
                $queryf = $dbh->prepare($sqlf);
                $queryf->execute();
                $resultsf = $queryf->fetchAll(PDO::FETCH_OBJ);
                foreach ($resultsf as $rowd) {

                  $exmt = $rowd->Occasion;
                  $Status = $rowd->Status;
                  $e_mrk = $rowd->Mark;
                  $ck_att = $rowd->Attendance;
                  $mx_mk = $rowd->Max_Mark;

                  if ($rowd->Mark == 0) {
                    $e_mrk = 0;
                  }

                  if ($exmt == 'TASK_1') {
                    $tk_1 = $e_mrk;
                    $tx_1 = $mx_mk;
                    if ($ck_att == "A") {
                      $tk_1 = "AB";
                    }
                  }
                  if ($exmt == 'TASK_2') {
                    $tk_2 = $e_mrk;
                    $tx_2 = $mx_mk;
                    if ($ck_att == "A") {
                      $tk_2 = "AB";
                    }
                  }
                  if ($exmt == 'TASK_3') {
                    $tk_3 = $e_mrk;
                    $tx_3 = $mx_mk;
                    if ($ck_att == "A") {
                      $tk_3 = "AB";
                    }
                  }
                  if ($exmt == 'TASK_4') {
                    $tk_4 = $e_mrk;
                    $tx_4 = $mx_mk;
                    if ($ck_att == "A") {
                      $tk_4 = "AB";
                    }
                  }
                  if ($exmt == 'TASK_5') {
                    $tk_5 = $e_mrk;
                    $tx_5 = $mx_mk;
                    if ($ck_att == "A") {
                      $tk_5 = "AB";
                    }
                  }
                  if ($exmt == 'TASK_6') {
                    $tk_6 = $e_mrk;
                    $tx_6 = $mx_mk;
                    if ($ck_att == "A") {
                      $tk_6 = "AB";
                    }
                  }
                  if ($exmt == 'TASK_7') {
                    $tk_7 = $e_mrk;
                    $tx_7 = $mx_mk;
                    if ($ck_att == "A") {
                      $tk_7 = "AB";
                    }
                  }
                  if ($exmt == 'TASK_8') {
                    $tk_8 = $e_mrk;
                    $tx_8 = $mx_mk;
                    if ($ck_att == "A") {
                      $tk_8 = "AB";
                    }
                  }
                  if ($exmt == 'TASK_9') {
                    $tk_9 = $e_mrk;
                    $tx_9 = $mx_mk;
                    if ($ck_att == "A") {
                      $tk_9 = "AB";
                    }
                  }
                  if ($exmt == 'TASK_10') {
                    $tk_10 = $e_mrk;
                    $tx_10 = $mx_mk;
                    if ($ck_att == "A") {
                      $tk_10 = "AB";
                    }
                  }
                  if ($exmt == 'MSE_1') {
                    $ms_1 = $e_mrk;
                    $mx_1 = $mx_mk;
                    if ($ck_att == "A") {
                      $ms_1 = "AB";
                    } else {
                      $poor_c1 = ($ms_1 * 100) / $mx_1;
                      if ($poor_c1 < 50) {
                        $poor_m1 = '*';
                      }
                    }
                  }

                  if ($exmt == 'MSE_2') {
                    $ms_2 = $e_mrk;
                    $mx_2 = $mx_mk;
                    if ($ck_att == "A") {
                      $ms_2 = "AB";
                    } else {
                      $poor_c2 = ($ms_2 * 100) / $mx_2;
                      if ($poor_c2 < 50) {
                        $poor_m2 = '*';
                      }
                    }
                  }
                  if ($exmt == 'MSE_3') {
                    $ms_3 = $e_mrk;
                    $mx_3 = $mx_mk;
                    if ($ck_att == "A") {
                      $ms_3 = "AB";
                    } else {
                      $poor_c3 = ($ms_3 * 100) / $mx_3;
                      if ($poor_c3 < 50) {
                        $poor_m3 = '*';
                      }
                    }
                  }
                }

              ?>
                <tr style="height: 49px;">
                  <td class="u-border-1 u-border-palette-5-dark-1 u-first-column u-table-cell u-table-cell-18">
                    <?php echo $Slno; ?></td>
                  <td class="u-border-1 u-border-palette-5-dark-1 u-table-cell u-table-cell-10">
                    <?php echo $s_name;
                    echo $Status; ?></td>
                  <td class="u-border-1 u-border-palette-5-dark-1 u-table-cell u-table-cell-11" style="text-align:center;color: <?php echo ($tk_1 === 'AB' || $tk_1 === '*') ? 'red' : 'white'; ?>;">
                    <?php echo $tk_1; ?></td>
                  <td class="u-border-1 u-border-palette-5-dark-1 u-table-cell u-table-cell-12" style="text-align:center;color: <?php echo ($tk_2 === 'AB' || $tk_2 === '*') ? 'red' : 'white'; ?>;">
                    <?php echo $tk_2; ?></td>
                  <td class="u-border-1 u-border-palette-5-dark-1 u-table-cell u-table-cell-13" style="text-align:center;color: <?php echo ($tk_3 === 'AB' || $tk_3 === '*') ? 'red' : 'white'; ?>;">
                    <?php echo $tk_3; ?></td>
                  <td class="u-border-1 u-border-palette-5-dark-1 u-table-cell u-table-cell-11" style="text-align:center;color: <?php echo ($tk_4 === 'AB' || $tk_4 === '*') ? 'red' : 'white'; ?>;">
                    <?php echo $tk_4; ?></td>
                  <td class="u-border-1 u-border-palette-5-dark-1 u-table-cell u-table-cell-12" style="text-align:center;color: <?php echo ($tk_5 === 'AB' || $tk_5 === '*') ? 'red' : 'white'; ?>;">
                    <?php echo $tk_5; ?></td>
                  <td class="u-border-1 u-border-palette-5-dark-1 u-table-cell u-table-cell-13" style="text-align:center;color: <?php echo ($tk_6 === 'AB' || $tk_6 === '*') ? 'red' : 'white'; ?>;">
                    <?php echo $tk_6; ?></td>
                  <td class="u-border-1 u-border-palette-5-dark-1 u-table-cell u-table-cell-11" style="text-align:center;color: <?php echo ($tk_7 === 'AB' || $tk_7 === '*') ? 'red' : 'white'; ?>;">
                    <?php echo $tk_7; ?></td>
                  <td class="u-border-1 u-border-palette-5-dark-1 u-table-cell u-table-cell-12" style="text-align:center;color: <?php echo ($tk_8 === 'AB' || $tk_8 === '*') ? 'red' : 'white'; ?>;">
                    <?php echo $tk_8; ?></td>
                  <td class="u-border-1 u-border-palette-5-dark-1 u-table-cell u-table-cell-13" style="text-align:center;color: <?php echo ($tk_9 === 'AB' || $tk_9 === '*') ? 'red' : 'white'; ?>;">
                    <?php echo $tk_9; ?></td>
                  <td class="u-border-1 u-border-palette-5-dark-1 u-table-cell u-table-cell-13" style="text-align:center;color: <?php echo ($tk_10 === 'AB' || $tk_10 === '*') ? 'red' : 'white'; ?>;">
                    <?php echo $tk_10; ?></td>
                  <td class="u-border-1 u-border-palette-5-dark-1 u-table-cell u-table-cell-14" style="text-align:center;color: <?php echo ($ms_1 === 'AB' || $poor_m1 === '*') ? 'red' : 'white'; ?>;">
                    <?php echo "$ms_1 $poor_m1"; ?></td>
                  <td class="u-border-1 u-border-palette-5-dark-1 u-table-cell u-table-cell-15" style="text-align:center;color: <?php echo ($ms_2 === 'AB' || $poor_m2 === '*') ? 'red' : 'white'; ?>;">
                    <?php echo "$ms_2 $poor_m2"; ?></td>
                  <td class="u-border-1 u-border-palette-5-dark-1 u-table-cell u-table-cell-15" style="text-align:center;color: <?php echo ($ms_3 === 'AB' || $poor_m3 === '*') ? 'red' : 'white'; ?>;">
                    <?php echo "$ms_3 $poor_m3"; ?></td>

                  <td class="u-border-1 u-border-palette-5-dark-1 u-table-cell u-table-cell-16" style="text-align:center">
                    <?php echo  $tot_c; ?></td>
                  <td class="u-border-1 u-border-palette-5-dark-1 u-table-cell u-table-cell-17" style="text-align:center;color: <?php echo ($att_sig === '!' || $poor_m1 === '#') ? 'red' : 'white'; ?>;">
                    <?php echo "$tot_p $att_sig"; ?></td>

                </tr>
              <?php
              }
              ?>


            </tbody>
          </table>
        </div>
        <!-------------------- ============== Table section ends --------------=================--->

        <p class="u-align-left u-text u-text-body-alt-color u-text-3" ><u style="color:red;">Note :</u>
        </p>
        <?php
        $date = new DateTime('now', new DateTimeZone('Asia/Kolkata'));
        //$tdytm=$date->format('d-M-Y H:i:s a');
        //$tdy=$date->format('d/M/Y');
        $tdy = date("d/M/Y", strtotime("yesterday"));
        ?>
        <ol class="u-align-left u-text u-text-body-alt-color u-text-4">
          <li style="color:red;">The above attendance is as on : <?php echo $tdy; ?>.</li>
          <li style="color:red;">As per the university norms students are expected to maintain atleast 85% attendance in each subject.</li>
          <li style="color:red;">'*' indicates poor marks, 'AB' absent for the tests, '#' attendance less than 85%,'!' attendance less than 75%.</li>
          <li style="color:red;">Please instruct your ward to improve her/his performance.</li>
          <li style="color:red;">Keep watch on the performance of your ward by visiting our website <a href='http://nmamit.nitte.edu.in' target="_blank">nmamit.nitte.edu.in</a> and click on "student info"</li>
          <li style="color:red;">For any further queries, please contact the <?php
                                                          if ($Sem <= 2) {
                                                            echo "First year coordinator.";
                                                          } else {
                                                            echo "Head of the department.";
                                                          }  ?></li>
          <li style="color:red;">Kindly press checked button after viewing the marks to confirm your view.
            <style>
              .container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                /* Adjust the height based on your layout */
              }

              .abutton {
                display: inline-block;
                padding: 12px 24px;
                background-color: #fff;
                /* Green background color */
                color: black;
                /* Text color */
                font-size: 16px;
                border: none;
                border-radius: 4px;
                transition: background-color 0.3s ease;
                cursor: pointer;
                margin-top: 20px;
                /* Adjust the value to move the button down */
              }
            </style>
            <style>
              .button {
                display: inline-block;
                background-color: white;
                color: black;
                border: 1px solid #28a745;
                padding: 12px 24px;
                margin: 10px;
                border-radius: 4px;
                padding: 12px 24px;
                transition: background-color 0.3s ease;
                cursor: pointer;
                margin-top: 20px;
              }

              .button:hover {
                background-color: #bfbfbf;
              }
            </style>

            <?php

            if ($Status == 1) {
            } else {
            ?>
              <center><button type="submit" name="Check" id="Check" class="button" style="Width:60%;">Confirm Marks</button></center>
            <?php  } ?>



        </ol>
      </div>
    </section>
  </form>

  <!--  <footer class="u-align-center u-clearfix u-footer u-grey-80 u-footer" id="sec-d48f">
    <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
      <p class="u-small-text u-text u-text-variant u-text-1">


        <span style="font-weight:bold;float:left" title="Code By : pravee.shetty@nitte.edu.in"> <img style="border-radius:50%;" src="https://lh3.googleusercontent.com/ogw/AOh-ky1qTpocixTP4JmClXHcuhgfypvNWKuuXgwOilUD=s32-c-mo"></span>

        <a href="http://nmamit.nitte.edu.in" class="td-none u-active-none u-border-none u-btn u-button-style u-hover-none u-none u-text-palette-1-base u-btn-1" target="_blank"><b>NMAMIT Nitte - 2023</b></a>
        <a class="td-none u-active-none u-border-none u-btn u-button-style u-hover-none u-none u-text-palette-1-base u-btn-1" href="https://nicepage.com/website-builder" target="_blank" style="float:right"> Source : nicepage.com</a>
      </p>


    </div>
  </footer> -->
</body>

</html>
