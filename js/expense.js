fillaccoun();
loadData();
//Button click shown modal

let btnAction= "Insert";

$("#btnadd").click(function(){
    $("#expenseModal").modal("show");
})


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

                $("#account_id").append(html);


            } else {
                console.log(response);
            }

        },
        error: function (data) {

        }

    })
}

//insert Account
$("#expenseForm").submit(function(event){
    event.preventDefault();

    let conrl=$(".contrl").val();
    if(conrl==0){
        iziToast.error({timeout: 1000,title: 'Error..',message: 'Please Select Options',
            onClosing: function () {
                $("#expenseForm")[0].reset();
            }
        });
        return;
    }
    

    //gets the form data
    let form_data =new FormData($("#expenseForm")[0]);
    //ads action to the form
    if(btnAction == "Insert"){
        form_data.append("action","register_expense");
    }else{
        form_data.append("action","");
    }
    

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/expense.php",
        data : form_data,
        processData : false,
        contentType : false,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let responses = data.dataa;
            if(response){
                $("#expenseForm")[0].reset();

                $("#expenseModal").modal("hide");
                setTimeout(5000);
                iziToast.success({timeout: 1000,title: 'Saving..',message: response,
                    onClosing: function () {
                        location.reload(true);
                    }
                });
            }else if(responses){
                $("#expenseForm")[0].reset();

                $("#expenseModal").modal("hide");
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

//read all office to table
function loadData(){
    let sendingData ={
        "action":"readAll"
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/expense.php",
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
                        if(r == "amount"){tr += `<td>$${res[r]}</td>`;}
                        if(r == "type"){
                            if(res[r]=="Income"){tr += `<td><span class='badge  bg-success'>Income</span></td>`;}
                            if(res[r]=="Expense"){tr += `<td><span class='badge  bg-danger'>Expense</span></td>`;}
                        }
                        if(r == "description"){tr += `<td>${res[r]}</td>`;}
                        if(r == "userName"){tr += `<td >${res[r]}</td>`;}
                        if(r == "bank_name"){tr += `<td >${res[r]}</td>`;}
                        if(r == "date"){tr += `<td >${res[r]}</td>`;}
                        
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