getparcells();
loadPendingData();
loadPaidgData();
loadPrices();
get_total_expense();
function getparcells(){
  
    let sendingData ={
      "action": "get_total_parcells",
    }
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/index.php",
      data : sendingData,
  
        success : function(data){
            let status= data.status;
            let response= data.data;
          
  
            if(status){
                let amount =response['id'];
                let sign ="$ ";
  
                document.querySelector("#getparcells").innerText =amount;
  
            }else{
              displaymessagee("error", response);
            }
  
        },
        error: function(data){
  
        }
  
    })
}
function get_total_expense(){
  
    let sendingData ={
      "action": "get_total_expense",
    }
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/index.php",
      data : sendingData,
  
        success : function(data){
            let status= data.status;
            let response= data.data;
          
  
            if(status){
                let amount =response['expense'];
                let sign ="$ ";
  
                document.querySelector("#getexpense").innerText =amount;
  
            }else{
              displaymessagee("error", response);
            }
  
        },
        error: function(data){
  
        }
  
    })
}

function loadPendingData(){
  let sendingData ={
      "action":"readPendigPracels"
  };

  $.ajax({
      method: "POST",
      dataType: "JSON",
      url: "api/index.php",
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
                      if(r == "TrackingID"){tr += `<td>${res[r]}</td>`;}
                      if(r == "name"){tr += `<td>${res[r]}</td>`;}
                      if(r == "weight_Kg"){tr += `<td>${res[r]}KG</td>`;}
                      if(r == "balance"){tr += `<td>$${res[r]}</td>`;}
                      if(r == "status_price"){
                          if (res[r] == 'Pending') {
                              tr += `<td><span class="btn btn-danger btn-sm">Pending</span></td>`;
                            } else {
                              tr += `<td><span class="btn btn-danger btn-sm">$ ${res[r]}</span></td>`;
                            }
                      }
                      
                  }
                 tr+= "</tr>"
              });
              $("#pending tbody").append(tr);
          }else{
              console.log(response);
          }

          

      },
      error : function(data){

      }
  })
}

function loadPaidgData(){
    let sendingData ={
        "action":"readPaidPracels"
    };
  
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: "api/index.php",
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
                        if(r == "name"){tr += `<td>${res[r]}</td>`;}
                        if(r == "total_balance"){tr += `<td><span class="btn btn-primary btn-sm">$ ${res[r]}</span></td>`;}
                        
                    }
                   tr+= "</tr>"
                });
                $("#paid tbody").append(tr);
            }else{
                console.log(response);
            }
  
            
  
        },
        error : function(data){
  
        }
    })
}

// //read all office to table
function loadPrices(){
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
                        if(r == "from"){tr += `<td>${res[r]}</td>`;}
                        if(r == "to"){tr += `<td>${res[r]}</td>`;}
                        if(r == "type"){tr += `<td>${res[r]}</td>`;}
                        if(r == "price"){tr += `<td>$ ${res[r]}</td>`;}
                        
                    }
                   tr+= "</tr>"
                });
                $("#table3 tbody").append(tr);
            }else{
                console.log(response);
            }

            

        },
        error : function(data){

        }
    })
}