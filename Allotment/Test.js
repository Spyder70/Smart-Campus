
 
 
$("#Dept_Name, #Program, #Batch,#Sem,#Section,#Cycle ").change(function () 
{
 var Sected_Allot = $("#Allot").val();
 var Batch = $("#Batch").val();
 var Sem = $("#Sem").val();
 var Dept_Name = $("#Dept_Name").val();
 var Program = $("#Program").val();
 var Section = $("#Section").val();
 if(Sected_Allot =="Section")
 {
 	if(Batch !="" && Sem !="")
   	{
   	$.ajax({
	type: 'POST',
	url: 'Ajax/Fetch_Alloted.php',
	data: {Batch:Batch,Sem:Sem,Dept_Name:Dept_Name,Program:Program,Section:Section},
	success:function(data)
		{
		$("#List_Table").html(data);
		}
	    });
   	 }
 }
 });
