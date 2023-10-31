<?php
require("../../../DB/config.php");
		
			
			
			$StartA  = trim($_POST['StartA']);
			$EndB    = trim($_POST['EndB']);
			$ACycle  = trim($_POST['ACycle']);
			
			if( $StartA!="" && $EndB !="" && $ACycle!="")
			{
			    if($StartA<=$EndB)
			    {
				foreach (range($StartA,$EndB) as $i)
                      		{  
                      		  $Add_sql=" Update Student_Info set Student_Info.Cycle='$ACycle' 
                      		  where  Student_Info.Section='$i'  
                      		  and ( Student_Info.Sem='1'  or Student_Info.Sem='2')
			          and Student_Info.Program In( Select D1.Short_Name from Department as D1
                                 where D1.Course_Type='UG') ";
                                 //echo $Add_sql;
                       	  $Add_query= $dbh -> prepare($Add_sql);
				  $Add_query-> execute();
                      		
                      	       }
                          }
			}
			
		
			
			$Add_sql=" Select S1.Section
			          from Student_Info as S1 where S1.Cycle='PHY' 
			          and ( S1.Sem='1'  or S1.Sem='2')
			          and S1.Program In( Select D1.Short_Name from Department as D1
                                 where D1.Course_Type='UG') Group By S1.Section  order by S1.Section";
			
			
                       $Add_query= $dbh -> prepare($Add_sql);
			$Add_query-> execute();
    			$Fresult=$Add_query->fetchAll(PDO::FETCH_OBJ);
			
			  
?>

<style>
.lets{
  padding: 8px 5px;
  font: bold 14px'lucida sans', 'trebuchet MS', 'Tahoma';
  border: 1px solid #a4c3ca;
  background: #f1f1f1;
  border-radius: 5px;
  margin-left:-15px;
 
  margin-top:-8px;
  margin-bottom:-8px;
 
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25) inset, 0 1px 0 rgba(255, 255, 255, 1);

}
</style>

 <div class="col-6">
  
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title"><b>
                PHYSICS Cycle Sections 
                </b></h3>
		
              </div>
              <!-- /.card-header -->
             
         
              <div class="card-body table-responsive p-0" style="height: 400px;font-size:13px;">
                <table class="table table-head-fixed table-hover text-nowrap" id="mt1">
                  
                  <thead style="cursor: pointer;">
                    <tr>
                       <th id="a4" onclick="sortTable('#a4')">Section</th>
                    </tr>
                  </thead>
                  <tbody id="TBODY" >
                  
                  	<?php  
                  	
                  	
                  	 			
    			foreach($Fresult as $Fres)
			{
			
			echo "<tr>";
                     	?>
                     
  			<td ><?php echo $Fres->Section  ; ?></td>
  			
  			
                      	<?php
                      	echo "</tr>";
                      	}
                  	
			?>
                      
                    
                  
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              
            </div>
            <!-- /.card -->
           
          </div>
        
          
          
          
          
          
        <?php  
          
          
          
         $Add_sql=" Select S1.Section
			          from Student_Info as S1 where S1.Cycle='CHE' 
			          and ( S1.Sem='1'  or S1.Sem='2')
			          and S1.Program In( Select D1.Short_Name from Department as D1
                                 where D1.Course_Type='UG') Group By S1.Section order by S1.Section";
			
			
                       $Add_query= $dbh -> prepare($Add_sql);
			$Add_query-> execute();
    			$Fresult=$Add_query->fetchAll(PDO::FETCH_OBJ);
			
			         
			
    			
?>

 <div class="col-6">
 	
              <div class="card card-outline card-secondary">
              <div class="card-header">
                <h3 class="card-title"><b>
                CHEMISTRY Cycle Sections 
                </b></h3>
		
              </div>
              <!-- /.card-header -->
              
         	
              <div class="card-body table-responsive p-0" style="height: 400px;font-size:12px;">
                <table class="table table-head-fixed table-hover text-nowrap"  id="mt2">
                  
                      
                  <thead style="cursor: pointer;">
                    <tr>
                       <th id="b4" onclick="sortTable('#b4')">Section</th>
                    </tr>
                  </thead>
                  <tbody id="TBODY">
                  
                  	<?php  
                  	
                  	
                  	 			
    			foreach($Fresult as $Fres)
			{
			
			echo "<tr>";
                     	?>
                     
  			<td ><?php echo $Fres->Section  ; ?></td>
  			
  			
                      	<?php
                      	echo "</tr>";
                      	}
                  	
			?>
                      
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
             
            </div>
            <!-- /.card -->
            
          </div>
          
         
    
          
          
	
<?php   
  
?>
                      

