loadData();

$("#btnadd").click(function(){
    $("#MainModal").modal("show");
})
let btnAction= "Insert";
//insert Account
$("#MainForm").submit(function(event){
    event.preventDefault();
    

    //gets the form data
    let form_data =new FormData($("#MainForm")[0]);
    //ads action to the form
    if(btnAction == "Insert"){
        form_data.append("action","MainMenuesRegister");
    }else{
        form_data.append("action","updateMainMenue");
    }
    

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/main_menues.php",
        data : form_data,
        processData : false,
        contentType : false,

        success :function(data){
            let status = data.status;
            let response = data.data;
            $("#MainForm")[0].reset();

            $("#MainModal").modal("hide");
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

//read all Main menues to table
function loadData(){
    let sendingData ={
        "action":"readAll"
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/main_menues.php",
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
                        if(r == "m_id"){tr += `<td>${res[r]}</td>`;}
                        if(r == "icon"){tr += `<td>${res[r]}</td>`;}
                        if(r == "text"){tr += `<td>${res[r]}</td>`;}
                        if(r == "url"){tr += `<td>${res[r]}</td>`;}
                        
                    }
                    tr += `<td> 
                    <a class="btn btn-primary update_info btn-sm" update_id=${res['m_id']} style="float: right;"><i class="fas fa-edit"style="color: #fff"></i></a>
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
        "action":"readMainInfo",
        "id" : id
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/main_menues.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            let tr ='';

            if(status){
                $("#update_id").val(response[0].m_id);
                $("#name").val(response[0].text);
                $("#icon").val(response[0].icon);
                $("#url").val(response[0].url);
                $("#MainModal").modal("show");

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