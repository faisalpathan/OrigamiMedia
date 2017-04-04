$(document).ready(function() {


// delete the video ka form hai
        $(".myForm").on("submit", function(e){
              			e.preventDefault();
              			swal({
                            title: "Are you sure?",
                            text: "You will not be able to recover this video!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes, delete it!",
                            cancelButtonText: "No, cancel it!",
                            closeOnConfirm: false,
                            closeOnCancel: false
                          },
                            function(isConfirm){
                              if (isConfirm) {
                                swal("Deleted!", "Your imaginary file has been deleted.", "success");
                                $('.myForm').unbind(e);
                                $('.myForm').submit();
                              } else {
                                swal("Cancelled", "Your video  is safe :)", "error");
                              }
                            });
                              /*return 
                              confirm("Do you want to delete this item?");
                               */
        });


        $(".editChannelDetails").on("submit" ,function(e1) {
              e1.preventDefault();
              var form = this;
              swal("Edited Successfully!", "Your Channel Settings are updated!", "success")
              
              setTimeout(function () {
                  form.submit();
              }, 1800);              
        });

});