<?php 
get_header();
?>

<section class="hallticket-section">
<header>
  <h3>Download Your Hall Ticket</h3>
  <p>Please fill out the following form to download your hall ticket for the Dinamalar – Sowdambikaa NEET Mock Exam.</p>
</header>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $phone_number = htmlspecialchars($_POST['phone-number']);
  if (empty($phone_number)) {
    echo "Enter your registered phone number.";
  } else {
    global $wpdb;
    $ticket_query = "SELECT * FROM student_hall_tickets WHERE PhoneNo='$phone_number'";
    $result_data = $wpdb->get_results($ticket_query);
    $student_data = array(
      "student_name" => $result_data[0]->StudentName,
      "gender" => $result_data[0]->Gender,
      "exam_center" => $result_data[0]->ExamCentre,
      "roll_no" => $result_data[0]->RollNo,
      "centre_code" => $result_data[0]->CentreCode,
      "qp_version" => $result_data[0]->QPVersion
    );
    echo "<script>fillForm(".json_encode($student_data).")</script>";
  }
}
?>
<form action="/Sowdambikaa/pdf/" method="post" id="hallticket-form" class="hallticket-form">
  <div  class="form-field">
    <label for="phone">Phone Number</label>
    <input type="tel" name="phone-number" placeholder="Enter your phone number" id="phone" required>
  </div>
  <button type="submit" class="download-button">Download</button>
</form>
</section>

<?php
get_footer();
?>
