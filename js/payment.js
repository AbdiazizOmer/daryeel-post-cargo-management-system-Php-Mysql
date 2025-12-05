fill_customer_ordering();
fillaccoun();
fill_payment_methods();
fill_amount();
subt();
loadData();
let btnAction= "Insert";
//Button click shown modal
$("#btnadd").click(function(){
    $("#paymentModal").modal("show");
})
//FILL CUSTOMERS ORDERING
function fill_customer_ordering() {

    let sendingData = {
      "action": "read_customer_ordering"
    }
  
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "Api/payment.php",
      data: sendingData,
  
      success: function (data) {
        let status = data.status;
        let response = data.data;
        let html = '';
        let tr = '';
  
        if (status) {
          response.forEach(res => {
            html += `<option value="${res['cust_id']}">${res['name']}</option>`;
  
          })
  
          $("#customer_idd").append(html);
  
  
        } else {
          displaymessage("error", response);
        }
  
      },
      error: function (data) {
  
      }
  
    })
}
//Fill bank name
function fillaccoun() {

    let sendingData = {
        "action": "read_all_account"
    }

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "Api/charges.php",
        data: sendingData,

        success: function (data) {
            let status = data.status;
            let response = data.data;
            let html = '';
            let tr = '';

            if (status) {
                response.forEach(res => {
                    html += `<option value="${res['id']}">${res['bank_name']}</option>`;

                })

                $("#Accountt_id").append(html);


            } else {
                console.log(response);
            }

        },
        error: function (data) {

        }

    })
}

//Fill payment methods
function fill_payment_methods() {

    let sendingData = {
        "action": "read_payment_methods"
    }

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "Api/payment.php",
        data: sendingData,

        success: function (data) {
            let status = data.status;
            let response = data.data;
            let html = '';
            let tr = '';

            if (status) {
                response.forEach(res => {
                    html += `<option value="${res['id']}">${res['name']}</option>`;

                })

                $("#p_method_id").append(html);


            } else {
                console.log(response);
            }

        },
        error: function (data) {

        }

    })
}



function fill_amount(customer_id) {
    let sendingData = {
      "action": "read_amount",
      "customer_id": customer_id
  
    }
  
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/payment.php",
      data: sendingData,
  
      success: function (data) {
        let status = data.status;
        let response = data.data;
        console.log("name", response)
        let html = '';
        let tr = '';
  
        if (status) {
  
          response.forEach(res => {
            $("#amount").val(res['balance']);
            // console.log(response);
  
          })
  
  
  
        } else {
          console.log(response);
        }
  
      },
      error: function (data) {
  
      }
  
    })
}

$("#paymentForm").on("change", "select.customer_name", function () {
    let customer_id = $(this).val();
    console.log("name", customer_id);
    fill_amount(customer_id);
  
})

function subt(){
    var elm = document.forms["paymentForm"];
  
    if (elm["amount"].value != "" && elm["amount_paid"].value != "")
      {elm["balance"].value = Math.round(parseFloat(elm["amount"].value) - parseFloat(elm["amount_paid"].value),'e2');
  }
}

$("#paymentForm").submit(function(event){
    event.preventDefault();

    let conrl=$(".contrl").val();
    
    if(conrl <= 0){
        iziToast.error({timeout: 1000,title: 'Error..',message: 'Please Select Options',
            onClosing: function () {
                $("#paymentForm")[0].reset();
            }
        });
        return;
    }
    
    

    // //gets the form data
    let form_data =new FormData($("#paymentForm")[0]);
    //ads action to the form
    if(btnAction == "Insert"){
        form_data.append("action","register_payment");
    }else{
        form_data.append("action","");
    }
    

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/payment.php",
        data : form_data,
        processData : false,
        contentType : false,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let responses = data.dataa;
            if(response){
                $("#paymentForm")[0].reset();
                $("#paymentModal").modal("hide");
                setTimeout(5000);
                iziToast.success({timeout: 1000,title: 'Saving..',message: response,
                    onClosing: function () {
                        location.reload(true);
                    }
                });
            }if (responses) {
                $("#paymentForm")[0].reset();
                $("#paymentModal").modal("hide");
                setTimeout(5000);
                iziToast.error({timeout: 1000,title: 'Error..',message: responses,
                    onClosing: function () {
                        location.reload(true);
                    }
                });
            } 
            

                
            
            
            
            btnAction ="Insert";
        },
        error : function(data){
            console.log(data);
        }
    })


})

//read all Main menues to table
function loadData(){
    let sendingData ={
        "action":"read_all_payment"
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/payment.php",
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
                        if(r == "payment_id"){tr += `<td>${res[r]}</td>`;}
                        if(r == "name"){tr += `<td>${res[r]}</td>`;}
                        if(r == "Total_amount"){tr += `<td>${res[r]}</td>`;}
                        if(r == "amount_paid"){tr += `<td>${res[r]}</td>`;}
                        if(r == "balance"){
                            if (res[r] == 0) {
                                tr += `<td><span class="btn btn-success btn-sm">✔</span></td>`;
                              } else {
                                tr += `<td><span class="btn btn-danger btn-sm">$ ${res[r]}</span></td>`;
                              }
                        }
                        if(r == "bank_name"){tr += `<td>${res[r]}</td>`;}
                        if(r == "payment_method"){tr += `<td>${res[r]}</td>`;}
                        if(r == "date"){tr += `<td>${res[r]}</td>`;}
                        
                    }
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