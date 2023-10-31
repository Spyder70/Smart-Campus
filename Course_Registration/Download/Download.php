 <?php
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=SampleCoreReg.csv");
    readfile('SampleCoreReg.csv');
  ?>
