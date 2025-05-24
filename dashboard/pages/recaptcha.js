$(document).ready(function() {
  var modal = $('#newTicketModal');
  var btn = $('#newTicketBtn');
  var span = $('#closeModal');

  btn.on('click', function() {
    modal.show();
  });

  span.on('click', function() {
    modal.hide();
  });

  $(window).on('click', function(event) {
    if (event.target == modal[0]) {
      modal.hide();
    }
  });

  $('#submitTicket').on('click', function() {
  var title = $('#ticketTitle').val();
  var message = $('#ticketMessage').val();

  if (title && message) {
    grecaptcha.ready(function() {
    grecaptcha.execute('6LfbZUgqAAAAAE7dui7Q2z3OChVMJuv--hvzkLtz', {action: 'submit'}).then(function(token) {
      
        $.ajax({
            url: 'https://prosecurelsp.com/users/dashboard/pages/controllers/new_ticket.php',
            method: 'POST',
            data: {
                title: title,
                message: message,
                recaptcha_token: token  
            },
            success: function(response) {
                alert(response);
                $('#newTicketModal').hide();
                location.reload();
            },
            error: function(error) {
                alert('Error creating ticket. Please try again.');
            }
        });
    });
});
  } else {
    alert('Please fill in all fields.');
  }
});

});