 <?php
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=SampleSubjetcs.csv");
    readfile('SampleSubjetcs.csv');
  ?>
