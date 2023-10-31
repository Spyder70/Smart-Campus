 <?php
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=SampleElectiveReg.csv");
    readfile('SampleElectiveReg.csv');
  ?>
