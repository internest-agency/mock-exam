const { PDFDocument } = PDFLib

async function fillForm(studentData) {
  // Fetch the PDF with form fields
  const formUrl = 'http://localhost/Sowdambikaa/wp-content/uploads/2024/01/Sowdambikaa-Hallticket.pdf';
  const formPdfBytes = await fetch(formUrl).then(res => res.arrayBuffer());

  // Load a PDF with form fields
  const pdfDoc = await PDFDocument.load(formPdfBytes);

  // Get the form containing all the fields
  const form = pdfDoc.getForm();

  // Get all fields in the PDF by their names
  const studentName = form.getTextField('student-name');
  const gender = form.getTextField('gender');
  const examCentre = form.getTextField('exam-centre');
  const rollNo = form.getTextField('roll-no');
  const centreCode = form.getTextField('centre-code');
  const qpVersion = form.getTextField('qp-version');

  studentName.setText(studentData.student_name);
  gender.setText(studentData.gender);
  examCentre.setText(studentData.exam_center);
  rollNo.setText(studentData.roll_no);
  centreCode.setText(studentData.centre_code);
  qpVersion.setText(studentData.qp_version);

  form.flatten();
  // Serialize the PDFDocument to bytes (a Uint8Array)
  const pdfBytes = await pdfDoc.save();

  // Trigger the browser to download the PDF document
  saveUint8ArrayToPDF(pdfBytes, `${studentData.student_name}-hallticket`);
}

function saveUint8ArrayToPDF(uint8Array, fileName) {
  const blob = new Blob([uint8Array], { type: 'application/pdf' });
  const url = URL.createObjectURL(blob);
  const link = document.createElement('a');
  link.href = url;
  link.download = fileName;
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
  URL.revokeObjectURL(url);
}