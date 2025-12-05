$("#tellphone").attr("disabled", true);

$("#type").on("change", function(){
    if($("#type").val()== 0){
    $("#tellphone").attr("disabled", true);

    }else{
        $("#tellphone").attr("disabled", false);
    }
})

$("#printtstatement").on("click", function(){
    printStatement();
    
})

function printStatement(){
    let printarea= document.querySelector("#prinT_Area");
  
    
    let newwindow= window.open("");
    newwindow.document.write(`<html><head><title></title>`);
    newwindow.document.write(`<style media="print">
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap');
    body{
        font-family: 'Poppins', sans-serif;
    }

    table{
      width:100%;
  }

    th{
        background-color : #40E0D0 !important;
        color: white !important;
       
    }
      
    th , td{
        padding:10px !important;
        text-align: left !important;

    }

    th , td{
        
        border-bottom : 1px solid #ddd !important;
    }
    
    
    </style>`);
    newwindow.document.write(`</head><body>`);
    newwindow.document.write(printarea.innerHTML);
    newwindow.document.write(`</body></html>`);
    newwindow.print();
    newwindow.close();

    
}


$("#exporttstatement").on("click", function(){
    let file= new Blob([$('#prinT_Area').html()], {type:"application/vnd.ms-excel"});
    let url= URL.createObjectURL(file);
    let a= $("<a />", {
        href: url,
        download: "print_statement.xls"}).appendTo("body").get(0).click();
        e.preventDefault();

});




$("#pracelform").on("submit", function(event){
    
    event.preventDefault();
    $("#pracelreport tr").html("");


    let tellphone= $("#tellphone").val();
    
 
  
    let sendingData = {
       
         "tellphone" : tellphone,
         
        "action": "read_pracel_statements",
       
    }
    


  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "api/pracel.php",
    data : sendingData,
    success: function(data){
        let status= data.status;
        let response= data.data;
   
        let tr= '';
        let th= '';

        if(status){
            response.forEach(res=>{

                th = "<tr>";
                for(let r in res){
                th += `<th>${r}</th>`;
               }

               th += "</tr>";


                tr += "<tr>";
                for(let r in res){

              
                tr += `<td>${res[r]}</td>`;
               

                }

                tr+= "</tr>"
              
            })

            $("#pracelreport thead").append(th);
            $("#pracelreport tbody").append(tr);
        }

    },
    error: function(data){

    }

  })

})



