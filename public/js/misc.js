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
    swal("Cancelled", "Your imaginary file is safe :)", "error");
  }
});


        		/*return 
        		confirm("Do you want to delete this item?");
            */
    });
