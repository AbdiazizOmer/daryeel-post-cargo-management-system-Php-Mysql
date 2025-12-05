redCustomerPracel();
loadData();







let btnAction= "Insert";
//Button click shown modal
$("#btnadd").click(function(){
    $("#invoiceModal").modal("show");
    $("#idup").css("display", "none");  // To hide
})

function redCustomerPracel(){
 
    let sendingData ={
        "action": "readCusPracelOption"
    }
  
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/invoice.php",
      data : sendingData,
  
        success : function(data){
            let status= data.status;
            let response= data.data;
            let id= data.id;
            let html='';
            let tr= '';
  
            if(status){
                response.forEach(res=>{
                  html+= `<option value="${res['id']}">${res['TrackingID']} - ${res['name']}</option>`;
                  ///////////////////////////price///////////////////
                  $('#cname').on('change',function(){
                    let form_data =new FormData($("#invoiceForm")[0]);
                    form_data.append("action","redPrice");
                    
                    ///////////////ok
                    $.ajax({
                        method: "POST",
                        dataType: "JSON",
                        url: "api/invoice.php",
                        data : form_data,
                        processData : false,
                        contentType : false,
                    
                          success : function(data){
                              let status= data.status;
                              let response= data.data;
                              let id= data.id;
                              let re= data.refre;
                              let html='';
                              let tr= '';
                    
                              if(status){
                                  let price = response;
                                  
                                  let invid = id;
                                  let refid = re;
                                  $("#price").val(price);
                                  $("#id").val(invid);
                                  $("#num").val(refid);
                              }else{
                                  Swal.fire(
                                      'Price Not Found',response,'warning').then(function(){location.reload();});
                                  ;
                                
                              }
                    
                          },
                          error: function(data){
                    
                          }
                    
                      })

                  });
                   
                })
                
                $("#cname").append(html);
  
               
            }else{
              displaymessage("error", response);
            }
  
        },
        error: function(data){
  
        }
  
    })
}

//insert invoice
$("#invoiceForm").submit(function(event){
    event.preventDefault();
    //gets the form data
    let form_data =new FormData($("#invoiceForm")[0]);
    //ads action to the form
    if(btnAction == "Insert"){
        form_data.append("action","InvoiceRegister");
    }else{
        form_data.append("action","updateInvoice");
    }
    
  
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/invoice.php",
        data : form_data,
        processData : false,
        contentType : false,
  
        success :function(data){
            let status = data.status;
            let response = data.data;
            $("#invoiceForm")[0].reset();
  
            $("#invoiceModal").modal("hide");
            setTimeout(5000);
            Swal.fire(
                'Success',response,'success').then(function(){location.reload();});
            
            
            btnAction ="Insert";
        },
        error : function(data){
            console.log(data);
        }
    })
  
  
})

// //read all Invoice to table
function loadData(){
    let sendingData ={
        "action":"readAll"
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/invoice.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            let tr ='';

            if(status){

                response.forEach(res => {
                    tr += "<tr>";
                    for (let r in res){
                        if(r == "invoice_id"){tr += `<td>${res[r]}</td>`;}
                        if(r == "ref_id"){tr += `<td>${res[r]}</td>`;}
                        if(r == "name"){tr += `<td>${res[r]}</td>`;}
                        if(r == "issued_date"){tr += `<td>${res[r]}</td>`;}
                        
                        if(r == "invoice_total"){tr += `<td>$ ${res[r]}</td>`;}
                        if(r == "status"){
                            if(res[r]=="Paid"){
                                tr += `<td><span class='badge bg-primary'>${res[r]}</span></td>`;
                            }else{
                                tr += `<td><span class='badge bg-danger'>${res[r]}</span></td>`;
                            }
                            
                        }
                        
                    }
                    tr += `<td> 
                    <a class="btn btn-primary update_info btn-sm " update_id=${res['invoice_id']}><i class="fas fa-edit"style="color: #fff"></i></a>
                    <a class="btn btn-success print_info btn-sm " print_id=${res['invoice_id']}><i class="fas fa-print"style="color: #fff"></i></a>
                    </td>`
                   tr+= "</tr>"
                });
                $("#table1 tbody").append(tr);
            }else{
                console.log(response);
            }

            

        },
        error : function(data){

        }
    })
}
//read jobs to modal to update
function fetchInfo(id){
    let sendingData ={
        "action":"readInvoiceInfo",
        "id" : id
    }

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/invoice.php",
        data : sendingData,
        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            if(status){
                btnAction ="Update";
                $("#update_id").val(response[0].invoice_id);
                //document.getElementById(id).hidden=true;
                $("#id").css("display", "none");  // To hide
                $("#idup").val(response[0].invoice_id);
                $("#num").val(response[0].ref_id);
                $("#price").val(response[0].invoice_total);
                html+= `<option selected value="${response[0].cus_id}">${response[0].ref_id} - ${response[0].name}</option>`;
                // $("#office_id").val(response[0].office_id);
                // $("#job_id").val(response[0].job_id);
                // $("#show").attr('src',`img/${response[0].image}`);
                $("#invoiceModal").modal("show");
                $("#cname").append(html);

               
            }else{
                displaymessagee("error", response);
            }

            

        },
        error : function(data){

        }
    })
}

function printDiv(){
    var printContents = document.getElementById("printarea").innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
}

function printInfo(id){
    let sendingData ={
        "action":"readInvoicePrint",
        "id" : id
    }

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/invoice.php",
        data : sendingData,
        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            if(status){
                
                console.log(response[0].name);
                
                $("#costname").append(response[0].name);   
                $("#costaddress").append(response[0].address);
                $("#costtell").append(response[0].tell);
                $("#rename").append(response[0].re_name);
                $("#readd").append(response[0].re_address);
                $("#retell").append(response[0].re_tell);
                $("#inid").append(response[0].invoice_id);
                $("#indate").append(response[0].issued_date);
                $("#dep").append(response[0].dep);
                $("#dis").append(response[0].dis);
                $("#kg").append(response[0].weight_Kg);
                $("#totall").append(response[0].price);
                $("#totalll").append(response[0].price);
                $("#tbp").append(response[0].tbprice);
                printDiv();
               
            }else{
                displaymessagee("error", response);
            }

            

        },
        error : function(data){

        }
    })
}





//Clicke update button and then get id clicked
$("#table1").on("click","a.update_info",function(){
    let id =$(this).attr("update_id");
    fetchInfo(id);
})
//Clicke print button and then get id clicked
$("#table1").on("click","a.print_info",function(){
    let id =$(this).attr("print_id");
    printInfo(id);
})
































