<script src="https://smtpjs.com/v3/smtp.js">
    function sendEmail() {
  Email.send({
    Host : "smtp.mailtrap.io",
    Username : "msandhiya8248@gmail.com",
    Password : "sandhiya@13",
    To : 'sandhiya1302@gmail.com.com',
    From : "msandhiya8248@gmail.com",
    Subject : "Test email",
    Body : "<html><h2>Header</h2><strong>Bold text</strong><br></br><em>Italic</em></html>"
  }).then(
    message => alert(message)
  );
}
</script>
<input type="button" value="Send Email" onclick="sendEmail()">
