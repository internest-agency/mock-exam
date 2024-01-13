const { PDFDocument } = PDFLib;

async function fillForm() {
  const formUrl = 'http://localhost/Sowdambikaa/wp-content/uploads/2024/01/Sowdambikaa-Hallticket.pdf';
  const formPdfBytes = await fetch(formUrl).then(res => res.arrayBuffer());

  const pdfDoc = await PDFDocument.load(formPdfBytes);

  console.log(pdfDoc);

  const form = await pdfDoc.getForm();

  const studentName = form.getTextField('student-name');
  const gender = form.getTextField('gender');
  const examCentre = form.getTextField('exam-centre');
  const rollNo = form.getTextField('roll-no');
  const centreCode = form.getTextField('center-code');
  const qpVersion = form.getTextField('qp-version');

  studentName.setText("Ramkumar R");
  gender.setText("Male");
  examCentre.setText("Sowdambikaa Matric. Boys/Girls Hr. Sec. School, Thuraiyur, Trichy Dt. (M) 97507 82444");
  rollNo.setText("0101 100 001");
  centreCode.setText("0101");
  qpVersion.setText("Tamil");

  const pdfBytes = await pdfDoc.save();

  download(pdfBytes, 'Ramkumar-Hallticket.pdf', 'application/pdf');
  console.log("Download has been started");
}

fillForm();