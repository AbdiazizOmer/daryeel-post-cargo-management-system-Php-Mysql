loadData();
redJobs();
redOffice();

let btnAction= "Insert";

//Image Show
let fileImage = document.querySelector("#image");
let showImage = document.querySelector("#show");
const redear = new FileReader();
fileImage.addEventListener("change",(e)=>{
    const selectedFile = e.target.files[0];
    redear.readAsDataURL(selectedFile)
})
redear.onload =e =>{
    showImage.src = e.target.result;
}
// End Image Show Area

// //Button click shown modal
$("#btnadd").click(function(){
    $("#employeeemodal").modal("show");
})

//Red jobs option
function redJobs(){
 
    let sendingData ={
        "action": "readJobsOption"
    }
  
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/employee.php",
      data : sendingData,
  
        success : function(data){
            let status= data.status;
            let response= data.data;
            let html='';
            let tr= '';
  
            if(status){
                response.forEach(res=>{
                  html+= `<option value="${res['job_id']}">${res['name']}</option>`;
                   
                })
  
                $("#job_id").append(html);
  
               
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
      url: "api/employee.php",
      data : sendingData,
  
        success : function(data){
            let status= data.status;
            let response= data.data;
            let html='';
            let tr= '';
  
            if(status){
                response.forEach(res=>{
                  html+= `<option value="${res['office_id']}">${res['address']},${res['city']},${res['country']}</option>`;
                   
                })
  
                $("#office_id").append(html);
  
               
            }else{
              displaymessage("error", response);
            }
  
        },
        error: function(data){
  
        }
  
    })
}

//insert Employee
$("#Employeeform").submit(function(event){
  event.preventDefault();
  //gets the form data
  let form_data =new FormData($("#Employeeform")[0]);
  form_data.append("image", $("input[type=file]")[0].files[0]);
  //ads action to the form
  if(btnAction == "Insert"){
      form_data.append("action","EmployeeRegister");
  }else{
      form_data.append("action","updateEmployee");
  }
  

  $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/employee.php",
      data : form_data,
      processData : false,
      contentType : false,

      success :function(data){
          let status = data.status;
          let response = data.data;
          $("#Employeeform")[0].reset();

          $("#employeeemodal").modal("hide");
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

//read all jobs to table
function loadData(){
    $("#table1 tr").html('');
    let sendingData ={
        "action":"readAll"
    };

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/employee.php",
        data : sendingData,

        success :function(data){
            let status = data.status;
            let response = data.data;
            let html='';
            let tr ='';
            let th ='';

            if(status){

                response.forEach(res => {
                    th = "<tr>";
                    for(let i in res){
                    th+= `<th>${i}</th>`;
                    }

                    th+= "<th>Action</th></tr>";

                    tr += "<tr>";
                    tr += "<tr>";
                    for (let r in res){
                        if(r == "IMAGE#"){
                            tr += `<td><div class="avatar me-3"><img  src="img/${res[r]}"></div></td>`;
                        }else{
                            tr += `<td>${res[r]}</td>`;
                        }
                    }
                    tr += `<td> 
                    <a class="btn btn-primary update_info btn-sm " update_id=${res['EMPID#']}><i class="fas fa-edit"style="color: #fff"></i></a>
                   </td>`
                   tr+= "</tr>"
                });
                $("#table1 thead").append(th);
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
        "action":"readEmployeeeInfo",
        "id" : id
    }

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/employee.php",
        data : sendingData,
        success :function(data){
            let status = data.status;
            let response = data.data;
            if(status){
                btnAction ="Update";
                $("#update_id").val(response[0].emp_id);
                $("#name").val(response[0].fullName);
                $("#address").val(response[0].address);
                $("#tell").val(response[0].tell);
                $("#office_id").val(response[0].office_id);
                $("#job_id").val(response[0].job_id);
                $("#show").attr('src',`img/${response[0].image}`);
                $("#employeeemodal").modal("show");
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