redMainMenue();
loadData();


$("#user_id").on("change",function(){
  $("input[type='checkbox']").prop('checked',false);
  let id =$(this).val();
  loadAllPermision(id);
})

//Red employee option
function loadAllPermision(id){
 
  let sendingData ={
      "action": "getUserAuthoretes",
      "user_id":id
  }

  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: "api/userAuthority.php",
    data : sendingData,

      success : function(data){
          let status= data.status;
          let response= data.data;
          let html='';
          let tr= '';

          if(status){
            if(response.length >= 1){

              response.forEach(res=>{
                
                 $(`input[type='checkbox'][name='roleAuthority[]'][value='${res['category_id']}']`).prop("checked",true);
                 $(`input[type='checkbox'][name='system_link[]'][value='${res['link_id']}']`).prop("checked",true);

              })
            }else{
              $("input[type='checkbox']").prop('checked',false); 
             
            }
          }else{
            displaymessage("error", response);
          }


      },
      error: function(data){

      }

  })
} 

//Red all user option
function redMainMenue(){
 
    let sendingData ={
        "action": "redAllusers"
    }
  
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/userAuthority.php",
      data : sendingData,
  
        success : function(data){
            let status= data.status;
            let response= data.data;
            let html='';
            let tr= '';
  
            if(status){
                response.forEach(res=>{
                  html+= `<option value="${res['id']}">${res['fullName']}</option>`;
                   
                })
  
                $("#user_id").append(html);
  
               
            }else{
              displaymessage("error", response);
            }
  
        },
        error: function(data){
  
        }
  
    })
}  

//chicked all authorates
$("#all_authority").on("change",function(){
  if($(this).is(":checked")){
    $("input[type='checkbox']").prop('checked',true);
  }else{
    $("input[type='checkbox']").prop('checked',false);
  }
})

$("#authorityArea").on("change","input[name='roleAuthority[]']",function(){
  let value = $(this).val();
  // console.log(value);
  if($(this).is(":checked")){
    $(`#authorityArea input[type='checkbox'][role='${value}']`).prop('checked',true);
  }else{
    $(`#authorityArea input[type='checkbox'][role='${value}']`).prop('checked',false);
  }
})


function loadData(){
  let sendingData ={
      "action":"readSystemAuthority"
  };

  $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/userAuthority.php",
      data : sendingData,

      success :function(data){
          let status = data.status;
          let response = data.data;
          let html='';
          let role='';
          let system_link ='';

          if(status){

              response.forEach(res => {
                  for (let r in res){
                      if(res['category'] !== role){
                        html +=`
                        </fieldset>
                        </div></div>
                        <div class="col-sm-3">
                          <fieldset class="authority-border">
                            <legend class="float-none authority-border">
                                <input type="checkbox" id="all_sub_authority" name="roleAuthority[]" value="${res['m_id']}">
                                ${res['category']}
                            </legend>
                          
                        



                        `;
                        role =res['category'];
                      }
                      if(res['link_name'] !== system_link){
                        html +=`
                        <div class="control-group">
                          <lebel class="control-lebel input-lebel">
                              <input type="checkbox" name="system_link[]" catogary_id"${res['m_id']}" link_id="${res['sub_id']}" role="${res['m_id']}" value="${res['sub_id']}" style="margin-left: 28px !important;">
                              ${res['link_name']}
                          </lebel>
                        </div>
                        
                        `;
                        system_link =res['link_name'];
                      }
                      
                  }
                  
              });
              $("#authorityArea").append(html);
          }else{
              console.log(response);
          }
      },
      error : function(data){

      }
  })
}



$("#userAuthorize").submit(function(event){
  event.preventDefault();
  let actions=[];
  let user_id=$("#user_id").val();
  if(user_id==0){
    iziToast.error({timeout: 1000,title: 'Error..',message: 'Please Select User',
        onClosing: function () {
          $("#userAuthorize")[0].reset();
        }
    });
      return;
  }

  $("input[name='system_link[]']").each(function(){
    if($(this).is(":checked")){
      actions.push($(this).val());
    }
  });
  console.log(actions);
  let sendingData={}
  sendingData={
    "user_id":user_id,
    "action_id":actions,
    "action":"userAutorityRegister"
  }

  $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/userAuthority.php",
      data : sendingData,

      success :function(data){
          let status = data.status;
          let response = data.data;
          if(response){
            // console.log(response);
              // $("#priceMoal").modal("hide");
              // setTimeout(5000);
              iziToast.success({timeout: 1000,title: 'Saving..',message: response,
                onClosing: function () {
                  location.reload(true);
                }
            });
              
              
              // btnAction ="Update";
          }else{
            console.log(response);

              // $("#priceMoal").modal("hide");
              // setTimeout(5000);
              // Swal.fire(
              //     'Success',response,'success').then(function(){location.reload();});
              
              
              // btnAction ="Update";

          }
 
      },
      error : function(data){
          console.log(data);
      }
  })


})