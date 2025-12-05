loadData();
redOffice();
redType();
redarea();

let btnAction= "Insert";

//Button click shown modal
$("#btnadd").click(function(){
    $("#priceMoal").modal("show");
})

//Red office option
function redOffice(){
 
    let sendingData ={
        "action": "readOfficeOption"
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
                  html+= `<option value="${res['office_id']}">${res['city']} - ${res['country']}</option>`;
                   
                })
  
                $("#from").append(html);
  
               
            }else{
              displaymessage("error", response);
            }
  
        },
        error: function(data){
  
        }
  
    })
}

//Red office option
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
  
                $("#to").append(html);
  
               
            }else{
              displaymessage("error", response);
            }
  
        },
        error: function(data){
  
        }
  
    })
}
//Red courior option
function redType(){
 
    let sendingData ={
        "action": "readCouriorOption"
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
                  html+= `<option value="${res['id']}">${res['name']} - ${res['couriorType']}</option>`;
                   
                })
  
                $("#type").append(html);
  
               
            }else{
              displaymessage("error", response);
            }
  
        },
        error: function(data){
  
        }
  
    })
}

//insert Account
$("#priceForm").submit(function(event){
    event.preventDefault();
    let conrl=$(".contrl").val();
    let conrl1=$(".contrl1").val();
    let conrl2=$(".contrl2").val();
    if(conrl==0 || conrl1==0 || conrl2==0){
        iziToast.error({timeout: 1000,title: 'Error..',message: 'Please Select Options',
            onClosing: function () {
                $("#priceForm")[0].reset();
            }
        });
        return;
    }

    //gets the form data
    let form_data =new FormData($("#priceForm")[0]);
    //ads action to the form
    if(btnAction == "Insert"){
        form_data.append("action","PriceRegister");
    }else{
        form_data.append("action","updatePrice");
    }
    

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/price.php",
        data : form_data,
        processData : false,
        contentType : false,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let response2 = data.array_data;
            $("#priceForm")[0].reset();
            if(response2){
                $("#priceMoal").modal("hide");
                setTimeout(5000);
                iziToast.error({timeout: 1000,title: 'Error..',message: response2,
                    onClosing: function () {
                        location.reload(true);
                    }
                });
                
                
                btnAction ="Insert";
            }else{
                $("#priceMoal").modal("hide");
                setTimeout(5000);
                iziToast.success({timeout: 1000,title: 'Saving..',message: response,
                    onClosing: function () {
                        location.reload(true);
                    }
                });
                
                
                btnAction ="Insert";

            }

            
        },
        error : function(data){
            console.log(data);
        }
    })


})

// //read all office to table
function loadData(){
    let sendingData ={
        "action":"readAll"
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/price.php",
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
       // 

                        if(r == "id"){tr += `<td>${res[r]}</td>`;}
                        if(r == "from"){tr += `<td>${res[r]}</td>`;}
                        if(r == "to"){tr += `<td>${res[r]}</td>`;}
                        if(r == "type"){tr += `<td>${res[r]}</td>`;}
                        if(r == "price"){
                            tr += `<td><input type="number" class="form-control pr" id="pr" price_id=${res['id']} name="pr" value="${res[r]}"></td>`;
                        }
                        
                    }
                    tr += `<td> 
                    <a class="btn btn-primary update_info btn-sm " update_id=${res['id']}><i class="fas fa-edit"style="color: #fff"></i></a>
                    &nbsp;&nbsp 
                    <a class="btn btn-danger delete_info  btn-sm" delete_id=${res['id']}><i class="fas fa-trash"style="color: #fff"></i></a> </td>`
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

// read Account to modal to update
function fetchInfo(id){
    let sendingData ={
        "action":"readPriceInfo",
        "id" : id
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/price.php",
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
                html+= `<option selected value="${response[0].fromid}">${response[0].from}</option>`;
                html1+= `<option selected value="${response[0].toid}">${response[0].to}</option>`;
                html2+= `<option selected value="${response[0].cid}">${response[0].type}</option>`;
                $("#price").val(response[0].price);

                $("#priceMoal").modal("show");
                $("#from").append(html);
                $("#to").append(html1);
                $("#type").append(html2);
                btnAction ="Update";
                
               
            }else{
                console.log(response);
            }

            

        },
        error : function(data){

        }
    })
}

function updatePrice(id,value){
    let sendingData ={
        "action":"UpdatePriceOnchane",
        "id" : id,
        "value" :value
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/price.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';

            if(status){
                
                iziToast.success({timeout: 1000,title: 'Saving..',message: response,
                    onClosing: function () {
                        location.reload(true);
                    }
                });
               
            }else{
                console.log(response);
            }

            

        },
        error : function(data){

        }
    })
}

//read price to modal to update
function deleteInfo(id){
    let sendingData ={
        "action":"daleteAccount",
        "id" : id
    };
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                method: "POST",
                dataType: "JSON",
                url: "api/price.php",
                data : sendingData,
        
                success :function(data){
                    let status = data.status;
                    let response = data.data;
                    let html='';
                    let tr ='';
        
                    if(status){
                        iziToast.success({timeout: 1000,title: 'Deleted..',message: 'Your file has been deleted',
                            onClosing: function () {
                                location.reload(true);
                            }
                        });
                       
                    }else{
                        console.log(response);
                    }
        
                    
        
                },
                error : function(data){
        
                }
            })
          
        }
      })

    
}

// Clicke update button and then get id clicked
$("#table1").on("click","a.update_info",function(){
    let id =$(this).attr("update_id");
    fetchInfo(id);
})

$("#table1").on("change","input.pr",function(){

    let id =$(this).attr("price_id");        
    var value = $(this).val();
    updatePrice(id,value);
})

//Clicke delete button and then get id clicked



$("#table1").on("click","a.delete_info",function(){
    let id =$(this).attr("delete_id");
    deleteInfo(id);
})