<?php 
get_header();

$query = "CREATE TABLE IF NOT EXISTS student_hall_tickets (
  ID int NOT NULL,
  StudentName varchar(255),
  Gender varchar(255),
  CentreCode varchar(255),
  RollNo varchar(255),
  QPVersion varchar(255),
  ExamCentre varchar(255),
  DateOfBirth varchar(255),
  PhoneNo char(10),
  EmailID varchar(255),
  PRIMARY KEY (ID)
)";

global $wpdb;
$create_table = $wpdb->query(
  $wpdb->prepare($query)
);

$data_validate = "SELECT * FROM student_hall_tickets WHERE EmailID='ramkumar.internest@gmail.com' OR EmailID='praveen.internest@gmail.com'";

$check_table = $wpdb->query(
  $wpdb->prepare($data_validate)
);

if($check_table < 1){
  $table_values = $wpdb->insert(
    'student_hall_tickets',
    array(
      'ID'=> 1,
      'StudentName'=>'Ramkumar R',
      'Gender'=>'Male',
      'CentreCode'=>'1101',
      'RollNo'=>'1101 1123 123',
      'QPVersion'=>'Tamil',
      'ExamCentre'=>'Sowdambikaa Matric. Boys/Girls Hr. Sec. School, Thuraiyur,\n Trichy Dt. (M) 97507 82444',
      'DateOfBirth'=>'2023-12-11',
      'PhoneNo'=>'9353460964',
      'EmailID'=>'ramkumar.internest@gmail.com'
    )
    );
}

?>
<section class="hallticket-section">
<header>
  <h3>Download Your Hall Ticket</h3>
  <p>Please fill out the following form to download your hall ticket for the Dinamalar – Sowdambikaa NEET Mock Exam.</p>
</header>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email_address = htmlspecialchars($_POST['email-address']);
  $phone_number = htmlspecialchars($_POST['phone-number']);
  $dob = htmlspecialchars($_POST['dob']);
  if (empty($email_address) or empty($phone_number) and empty($dob)) {
    echo "<p style='color: red;'>Use your email address or phone number and Date of Birth to download your hall ticket</p>";
  } else {
    global $wpdb;
    $ticket_query = "SELECT * FROM student_hall_tickets WHERE EmailID='$email_address' or PhoneNo='$phone_number' and DateOfBirth='$dob'";
    $result_data = $wpdb->get_results($ticket_query);
	if(count($result_data)>0){
		$student_data = array(
		"student_name" => $result_data[0]->StudentName,
		"gender" => $result_data[0]->Gender,
		"exam_center" => $result_data[0]->ExamCentre,
		"roll_no" => $result_data[0]->RollNo,
		"centre_code" => $result_data[0]->CentreCode,
		"qp_version" => $result_data[0]->QPVersion
	  );
	  echo "<script>fillForm(".json_encode($student_data).")</script>";
	}else{
		echo "<p style='color: red;'>No match found. Kindly check the details you have entered.</p>";
	}
	
	}
}
?>
<form action="/download-hallticket/" method="post" id="hallticket-form" class="hallticket-form">
  <div class="form-field">
    <label for="email">Email Address</label>
    <input type="email" id="email" name="email-address" placeholder="Enter your email address">
  </div>
  <div class="optional-container"><p>(or)</p></div>
  <div  class="form-field">
    <label for="phone">Phone Number</label>
    <input type="tel" name="phone-number" placeholder="Enter your phone number" id="phone">
  </div>
  <div  class="form-field">
    <label for="dob">Date of Birth</label>
    <input type="date" name="dob" id="dob" required>
  </div>
  <button type="submit" class="download-button">Download</button>
</form>
</section>

<?php
get_footer();
?>
