loadData();
redMainMenue();
fillLinks();

$("#btnadd").click(function(){
    $("#SubModal").modal("show");
})
let btnAction= "Insert";

//Red employee option
function redMainMenue(){
 
    let sendingData ={
        "action": "readMainMenuesOption"
    }
  
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/sub_menues.php",
      data : sendingData,
  
        success : function(data){
            let status= data.status;
            let response= data.data;
            let html='';
            let tr= '';
  
            if(status){
                response.forEach(res=>{
                  html+= `<option value="${res['m_id']}">${res['text']}</option>`;
                   
                })
  
                $("#menue").append(html);
  
               
            }else{
              displaymessage("error", response);
            }
  
        },
        error: function(data){
  
        }
  
    })
}
////Red All Files
function fillLinks(){
    let sendingData ={
        "action":"readAllFiles"
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/sub_menues.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            if(status){
                response.forEach(res => {
                    html += `<option value="${res}">${res}</option>`;
                });
                $("#url").append(html);
            }else{
                console.log(response);
            }

            

        },
        error : function(data){

        }
    })
}

//insert Account
$("#SubModal").submit(function(event){
    event.preventDefault();

    let url=$("#url").val();
    let menue=$("#menue").val();
    if(menue==0 || url==0){
        iziToast.error({timeout: 1000,title: 'Error..',message: 'Please Select Options',
            onClosing: function () {
                $("#SubForm")[0].reset();
            }
        });
        return;
    }

    //gets the form data
    let form_data =new FormData($("#SubForm")[0]);
    //ads action to the form
    if(btnAction == "Insert"){
        form_data.append("action","SubMenuesRegister");
    }else{
        form_data.append("action","updateSubMenue");
    }
    

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/sub_menues.php",
        data : form_data,
        processData : false,
        contentType : false,

        success :function(data){
            let status = data.status;
            let response = data.data;
            $("#SubForm")[0].reset();

            $("#SubModal").modal("hide");
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

//read all sub menues to table
function loadData(){
    let sendingData ={
        "action":"readAll"
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/sub_menues.php",
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
                        tr += `<td>${res[r]}</td>`
                    }
                    tr += `<td> 
                    <a class="btn btn-primary update_info btn-sm" update_id=${res['sub_id']} style="float: right;"><i class="fas fa-edit"style="color: #fff"></i></a>
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

//read Account to modal to update
function fetchInfo(id){
    let sendingData ={
        "action":"readSubInfo",
        "id" : id
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/sub_menues.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            let html2 ='';

            if(status){
                $("#update_id").val(response[0].sub_id);
                html+= `<option selected value="${response[0].m_id}">${response[0].mid}</option>`;
                $("#text").val(response[0].text);
                html2+= `<option selected value="${response[0].url}">${response[0].url}</option>`;
                $("#SubModal").modal("show");

                $("#menue").append(html);
                $("#url").append(html2);
                btnAction ="Update";
                
               
            }else{
                console.log(response);
            }

            

        },
        error : function(data){

        }
    })
}

// Clicke update button and then get id clicked
$("#table1").on("click","a.update_info",function(){
    let id =$(this).attr("update_id");
    fetchInfo(id);
})