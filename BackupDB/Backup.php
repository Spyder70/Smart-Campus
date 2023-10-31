<?php
session_start();
require("../DB/config.php");
require("../Authenticate/Admin.php");

// Get connection object and set the charset
//$conn2 = mysqli_connect($host, $username, $password, $database_name);


$PageName="Download The Database Backup";
$Report_Head="menu-open";
$Sql_Back="active";

if($_POST)
{

$conn2 = mysqli_connect(DB_HOST, DB_USER, DB_PASS,DB_NAME );
$conn2->set_charset("utf8");


// Get All Table Names From the Database
$tables = array();
$sql = "SHOW TABLES";
$result = mysqli_query($conn2, $sql);

while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}

$sqlScript = "";
foreach ($tables as $table) {
    
    // Prepare SQLscript for creating table structure
    $query = "SHOW CREATE TABLE $table";
    $result = mysqli_query($conn2, $query);
    $row = mysqli_fetch_row($result);
    
    $sqlScript .= "\n\n" . $row[1] . ";\n\n";
    
    
    $query = "SELECT * FROM $table";
    $result = mysqli_query($conn2, $query);
    
    $columnCount = mysqli_num_fields($result);
    
    // Prepare SQLscript for dumping data for each table
    for ($i = 0; $i < $columnCount; $i ++) {
        while ($row = mysqli_fetch_row($result)) {
            $sqlScript .= "INSERT INTO $table VALUES(";
            for ($j = 0; $j < $columnCount; $j ++) {
                $row[$j] = $row[$j];
                
                if (isset($row[$j])) {
                    $sqlScript .= '"' . $row[$j] . '"';
                } else {
                    $sqlScript .= '""';
                }
                if ($j < ($columnCount - 1)) {
                    $sqlScript .= ',';
                }
            }
            $sqlScript .= ");\n";
        }
    }
    
    $sqlScript .= "\n"; 
}

if(!empty($sqlScript))
{
    // Save the SQL script to a backup file
    $backup_file_name = 'DB' . date("Y-m-d_h-i-s"). '.sql';
    $fileHandler = fopen($backup_file_name, 'w+');
    $number_of_lines = fwrite($fileHandler, $sqlScript);
    fclose($fileHandler); 
    
    //Now zip that file
    $zip = new ZipArchive();
    $filename = "backups_".date("Y-m-d_h-i-s").".zip";
    if ($zip->open($filename, ZIPARCHIVE::CREATE) !== TRUE) 
    {
   	//exit("cannot open $filenamen");
    }
    $zip->addFile($backup_file_name , 'DB' . date("Y-m-d_h-i-s"). '.sql');
    $zip->close();
    //Now delete the .sql file without any warning
    unlink($backup_file_name); 
    //Return the path to the zip backup file
    //return "$filename";   
  

    chmod($filename,0755);
    // Download the SQL backup file to the browser
    header('Content-type: application/zip');
    header('Content-Disposition: attachment; filename="'.basename($filename).'"');
    header("Content-length: " . filesize($filename));
    header("Pragma: no-cache");
    header("Expires: 0");
    readfile($filename);
    	
    ob_clean();
    flush();
    unlink($filename);
    
}

}
$Add_Error="";
?>
  <?php require('../Head/Head.php'); ?>
  
  
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
         
         

	<div id="myModal" class="modal">
  	<!-- Modal content -->
  	<div class="modal-content">
    		<span class="close">&times;</span>
    		<p><?php echo $Add_Error; ?></p>
  	</div>
	</div>
        </div>
      </div><!-- /.container-fluid -->
    </section>



    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header" style="text-align:center">
                <h2 ><b>Back Up the Database </b></h2>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" >
                <div class="card-body">
                 
                 
                 
                
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                 <center> <button type="submit" name="Factory" id="Factory" class="btn btn-danger" 
                  style="height:80px;width:300px;font-size:24px;">Download The Zip</button>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php   echo $Add_Error;    ?>
                </div>
              </form>
            </div>
            <!-- /.card -->
            
            
            </div>
            
             
             <!-- /.card -->   
        <!-- Main row -
        <div class="row">
          <!-- Left col 
        
        </div>
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
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
	if($Add_Error!="")
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
