$( document ).ready(function() {

    /**
     * Loading SMS current list
     */
    $('#notifyUserSection').val('');
    function ajax(options) {
      return new Promise(function (resolve, reject) {
        $.ajax(options).done(resolve).fail(reject);
      });
    }
    ajax({
      url: 'list',
      type: "POST",
      contentType: 'application/json; charset=utf-8',
    }).then(
      function fulfillHandler(data) {
        const smsData = JSON.parse(data);
        const jsonString = smsData.data;
        var oTblReport = $("#smsView")
        oTblReport.DataTable ({
            "order": [[ 0, "desc" ]] ,
            "data" : jsonString,        
            "columns" : [
                { "data" : "id" },
                { "data" : "sending_number" },
                { "data" : "to_number" },
                { "data" : "msg" },
                { "data" : "time" },
                { "data" : "status", render: function ( data, type, row ) {
                    if ( Number(data) === 1  ) {
                      return '<span class="label label-success" >Success</span>';
                    } else {
                      return '<span class="label label-default" >Failed</span>';
                    }
                  } 
                }
            ]
        });
      },
      function rejectHandler(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown)
      }
    ).catch(function errorHandler(error) {
      console.log(error)
    });

    /**
     * Loads new sms sending modal
     */
    $('#newSmsModal').on('show.bs.modal',(event) => {
      addPhoneValidation();
      const form =  $("#newMsgForm");
      const $inputs = $('#newMsgForm :input');
        form.validate({
            rules: {
              fromNumber: {
                  required: true,
                  minlength: 3,
                  phoneCheck: true,

              },
              toNumber:{
                  required: true,
                  minlength: 3,
                  phoneCheck: true,

              },
              message: {
                  required: true,
                  minlength: 1,
              },
            },
            messages: {
              fromNumber: {
                required: "Please enter From Number",
                minlength: "Enter at least {0} characters",
              },
              toNumber: {
                required: "Please enter To Number",
                minlength: "Enter at least {0} characters",

              },
              message: {
                required: "Please enter message",
                minlength: "Enter at least {0} characters",
                    
              },
            },
           submitHandler: function(form) {
            let values = {};
            $inputs.each(function() {
                values[this.name] =  $(this).val();
            });
            if (values['fromNumber'] === values['toNumber']) {
              $('#validationErrSection').append( "<strong>From Number</strong> and <strong>To Number</strong> cannot be the same" );
              return false
            }
            
            // adding security key to avoid spam 
            values['key'] = 'security111333';
            $.ajax({
                url: 'send',
                type: "POST",
                data: values,
              }).then(
                function fulfillHandler(data) {
                  const response = JSON.parse(data);
                  if (response.status === false &&  response.msg) {
                    $('#notifyUserSection').append( response.msg );
                    return false;
                  }
  
                  //adding new row to the table
                  const table = $('#smsView').DataTable();
                  const rowData = {
                    "id": response.id,
                    "sending_number": values.fromNumber,
                    "to_number":values.toNumber,
                    "msg": values.message,
                    "time": response.time,
                    "status":response.smsStatus,
                  };
                  table.row.add(rowData).draw();
                  $('#newSmsModal').modal('hide');

                },
                function rejectHandler(jqXHR, textStatus, errorThrown) {
                  $('#notifyUserSection').append('an error occourd - conctivity issue');
                }
              ).catch(function errorHandler(error) {
                $('#notifyUserSection').append('an error occourd -'+ error);
              });
          }
         });
     });
    function addPhoneValidation(){
        $.validator.addMethod("phoneCheck",(value, element) => {
            if ( /^[0-9-+]+$/g.test(value)) {
                return true;
            } else {
                return false;
            };
        }, "Invalid phone number");
    }

  });