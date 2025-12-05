redCustomer();
redOffice();
redType();
loadData();
redarea();

let btnAction= "Insert";
$("#btnadd").click(function(){
    $("#PracelModel").modal("show");
})

// Red Customer option
function redCustomer(){
 
    let sendingData ={
        "action": "readCustomersOption"
    }
  
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/pracel.php",
      data : sendingData,
  
        success : function(data){
            let status= data.status;
            let response= data.data;
            let html='';
            let tr= '';
  
            if(status){
                response.forEach(res=>{
                  html+= `<option value="${res['id']}">${res['id']} - ${res['name']}</option>`;
                   
                })
  
                $("#cnamee").append(html);
  
               
            }else{
              displaymessage("error", response);
            }
  
        },
        error: function(data){
  
        }
  
    })
}

// //Red office option
function redOffice(){
 
    let sendingData ={
        "action": "readOfficeOption"
    }
  
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/pracel.php",
      data : sendingData,
  
        success : function(data){
            let status= data.status;
            let response= data.data;
            let html='';
            let tr= '';
  
            if(status){
                response.forEach(res=>{
                  html+= `<option value="${res['office_id']}">${res['city']} - ${res['country']}</option>`;
                   
                })
  
                $("#dep").append(html);
                
  
               
            }else{
              displaymessage("error", response);
            }
  
        },
        error: function(data){
  
        }
  
    })
}

function redarea(){
 
    let sendingData ={
        "action": "readAreaOption"
    }
  
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/price.php",
      data : sendingData,
  
        success : function(data){
            let status= data.status;
            let response= data.data;
            let html='';
            let tr= '';
  
            if(status){
                response.forEach(res=>{
                  html+= `<option value="${res['id']}">${res['areaname']} - ${res['country']}</option>`;
                   
                })
  
                $("#dist").append(html);
  
               
            }else{
              displaymessage("error", response);
            }
  
        },
        error: function(data){
  
        }
  
    })
}

//Red type option
function redType(){
 
    let sendingData ={
        "action": "readTypeOption"
    }
  
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/pracel.php",
      data : sendingData,
  
        success : function(data){
            let status= data.status;
            let response= data.data;
            let html='';
            let tr= '';
  
            if(status){
                response.forEach(res=>{
                  html+= `<option value="${res['id']}">${res['name']}, ${res['couriorType']}</option>`;
                   
                })
  
                $("#typee").append(html);
  
               
            }else{
              displaymessage("error", response);
            }
  
        },
        error: function(data){
  
        }
  
    })
}
//caculate price
$('#typee').on('change',function(){
    let form_data =new FormData($("#pracelForm")[0]);
    form_data.append("action","redPriceUpdate");
    
  
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/pracel.php",
      data : form_data,
      processData : false,
      contentType : false,
  
        success : function(data){
            let status= data.status;
            let response= data.data;
            let html='';
            let tr= '';
  
            if(status){
                let price = response;
                $("#pricee").val(price);

                $('#weightt').on('change',function(){
                    const weight = document.querySelector('#weightt').value;
                    if(weight <= 0){
                        iziToast.error({timeout: 1000,title: 'Error..',message: 'Weight Not Found',
                            onClosing: function () {
                                $("#pracelForm")[0].reset();
                            }
                        });
                        ;
                    }else{
                        let total = price * weight;
                        $("#pricee").val(total);

                       
                    }
                });
                
  
               
            }else{

                iziToast.error({timeout: 1000,title: 'Error..',message: response,
                    onClosing: function () {
                        $("#pracelForm")[0].reset();
                    }
                });
              
            }
  
        },
        error: function(data){
  
        }
  
    })

    

});


//insert and update pracel
$("#pracelForm").submit(function(event){
    event.preventDefault();

    let conrl=$(".contrl").val();
    if(conrl==0){
        iziToast.error({timeout: 1000,title: 'Error..',message: 'Please Select Options',
            onClosing: function () {
                $("#pracelForm")[0].reset();
            }
        });
        return;
    }
    

    //gets the form data
    let form_data =new FormData($("#pracelForm")[0]);
    //ads action to the form
    if(btnAction == "Insert"){
        form_data.append("action","PracelRegister");
    }else{
        form_data.append("action","updatePracell");
    }
    

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/pracel.php",
        data : form_data,
        processData : false,
        contentType : false,

        success :function(data){
            let status = data.status;
            let response = data.data;
            
                $("#pracelForm")[0].reset();

                $("#pracelModal").modal("hide");
                setTimeout(5000);
                iziToast.success({timeout: 1000,title: 'Saving..',message: response,
                    onClosing: function () {
                        location.reload(true);
                    }
                });
            btnAction ="Insert";
        },
        error : function(data){
            console.log(data);
        }
    })


})

// //read all pracel to table
function loadData(){
    let sendingData ={
        "action":"readAll"
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/pracel.php",
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
                        if(r == "id"){tr += `<td>${res[r]}</td>`;}
                        if(r == "TrackingID"){tr += `<td>${res[r]}</td>`;}
                        if(r == "name"){tr += `<td>${res[r]}</td>`;}
                        if(r == "weight_Kg"){tr += `<td>${res[r]} KG</td>`;}
                        if(r == "price"){tr += `<td>$${res[r]}</td>`;}
                        if(r == "status"){
                            if(res[r]=="1"){tr += `<td><span class='badge  bg-info'>Pending</span></td>`;}
                            else if(res[r]=="2"){tr += `<td><span class='badge bg-primary'>Order Confirmed</span></td>`;}
                            else if(res[r]=="3"){tr += `<td><span class='badge bg-secondary'>Prepare Order</span></td>`;}
                            else if(res[r]=="4"){tr += `<td><span class='badge bg-primary'>On the way</span></td>`;}
                            else if(res[r]=="5"){tr += `<td><span class='badge bg-secondary'>Arrived At Destination</span></td>`;}
                            else if(res[r]=="6"){tr += `<td><span class='badge bg-success'>Delivered</span></td>`;}
                            else if(res[r]=="7"){tr += `<td><span class='badge bg-danger'>Canceled</span></td>`;}
                            else{
                                tr += `<td><span class='badge bg-danger'>Unsuccessful delivery</td>`;
                            }
                            
                        }

                        if(r == "balance"){tr += `<td>$${res[r]}</td>`;}
                        if(r == "status_price"){
                            if(res[r]=="Pending"){tr += `<td><span class='badge  bg-danger'>Pending</span></td>`;}
                            else{
                                if(res[r]=="Paid"){tr += `<td><span class='badge  bg-success'>Paid</span></td>`;}
                        }

                        }
                        
                    }
                    tr += `<td> 
                    <a class="btn btn-info view_info btn-sm " view_id=${res['id']}><i class="fas fa-eye"style="color: #fff"></i></a>
                    
                    <a class="btn btn-primary update_info btn-sm " update_id=${res['id']}><i class="fas fa-edit"style="color: #fff"></i></a>
                
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


// // read pracels to modal view
function fetchInfo(id){
    let sendingData ={
        "action":"readpracelInfo",
        "id" : id
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/pracel.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            let html1='';
            let html2='';
            let tr ='';

            if(status){
                $("#update_id").val(response[0].id);
                $("#trid").append(response[0].TrackingID);
                $("#sname").append(response[0].cname);
                $("#add").append(response[0].address);
                $("#tel").append(response[0].tell);
                $("#rname").append(response[0].re_name);
                $("#radd").append(response[0].re_address);
                $("#rtel").append(response[0].re_tell);
                $("#weight").append(response[0].weight_Kg,' kg');
                $("#price").append(response[0].price);
                $("#height").append(response[0].item_name);
                $("#courier").append(response[0].name);                
                $("#fromm").append(response[0].departure);
                $("#too").append(response[0].destination);
                // $("#status").append(response[0].status);
                $("#price").val(response[0].price);
                if(response[0].status == "1"){$("#status").append("<span class='badge badge-pill bg-info'>Pending</span>");}
                else if(response[0].status == "2"){$("#status").append("<span class='badge badge-pill bg-primary'>Order Confirmed</span>");}
                else if(response[0].status == "3"){$("#status").append("<span class='badge badge-pill bg-secondary'>Prepare Order</span>");}
                else if(response[0].status == "4"){$("#status").append("<span class='badge badge-pill bg-primary'>On the way</span>");}
                else if(response[0].status == "5"){$("#status").append("<span class='badge badge-pill bg-secondary'>Arrived At Destination</span>");}
                else if(response[0].status == "6"){$("#status").append("<span class='badge badge-pill bg-success'>Delivered</span>");}
                else if(response[0].status == "7"){$("#status").append("<span class='badge badge-pill bg-danger'>Canceled</span>");}
                if(response[0].status_price == "Paid"){
                    $("#paidd").append("<span class='badge badge-pill bg-success'>Paid</span>");
                 }else if(response[0].status_price == "Pending"){
                    $("#paidd").append("<span class='badge badge-pill bg-danger'>Pending</span>");
                 }

                $("#viewmodal").modal("show");
                
               
            }else{
                console.log(response);
            }

            

        },
        error : function(data){

        }
    })
}

// Clicke view button and then get id clicked
$("#table1").on("click","a.view_info",function(){
    let id =$(this).attr("view_id");
    console.log(id);
    fetchInfo(id);
})

// // Clicke update button and then get id clicked
$("#table1").on("click","a.update_info",function(){
    let id =$(this).attr("update_id");
    fetchInfoToUpdate(id);
})


//Click btn status update
$("#update_status").click(function(){
    $("#viewmodal").modal("hide");
    $("#statusUpdate").modal("show");
})

//Click btn close status update inside
$("#btnclose").click(function(){
    $("#statusUpdate").modal("hide");
    $("#viewmodal").modal("show");

})

// //Update Status
$("#updatestatus").submit(function(event){
    event.preventDefault();
    

    //gets the form data
    let form_data =new FormData($("#updatestatus")[0]);
    //ads action to the form
    form_data.append("action","updateStatus");
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/pracel.php",
        data : form_data,
        processData : false,
        contentType : false,

        success :function(data){
            let status = data.status;
            let response = data.data;
            $("#updatestatus")[0].reset();
            
                $("#statusUpdate").modal("hide");
                setTimeout(5000);
                iziToast.success({timeout: 1000,title: 'Saving..',message: response,
                    onClosing: function () {
                        location.reload(true);
                    }
                });
        },
        error : function(data){
            console.log(data);
        }
    })


})


// read Account to modal to update
function fetchInfoToUpdate(id){
    let sendingData ={
        "action":"readpracelInfo",
        "id" : id
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/pracel.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            let html1='';
            let html2='';
            let tr ='';

            if(status){
                $("#update_idd").val(response[0].id);
                cnamee+= `<option selected value="${response[0].cusid}">${response[0].cusid} - ${response[0].cname}</option>`;
                dep+= `<option selected value="${response[0].fromid}">${response[0].departure}</option>`;
                dist+= `<option selected value="${response[0].toid}">${response[0].destination}</option>`;
                typee+= `<option selected value="${response[0].courioerid}">${response[0].name}</option>`;
                $("#renamee").val(response[0].re_name);
                $("#raddresss").val(response[0].re_address);
                $("#rtelll").val(response[0].re_tell);
                $("#weightt").val(response[0].weight_Kg);
                $("#heightt").val(response[0].item_name);
                $("#pricee").val(response[0].price);


                $("#PracelModel").modal("show");
                $("#cnamee").append(cnamee);
                $("#dep").append(dep);
                $("#dist").append(dist);
                $("#typee").append(typee);
                btnAction ="Update";
                
               
            }else{
                console.log(response);
            }

            

        },
        error : function(data){

        }
    })
}
