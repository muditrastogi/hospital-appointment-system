<?php

require('fpdf181/fpdf.php');

//Connect to your database
    session_start();
    if(!isset($_SESSION['id']))
    header('Location: login.php'); 

    $appid = $_POST['appid'];


    $conn = new mysqli("localhost", "root" , "", "has");
    $u_id=$_SESSION['id'];
    
    $sql_app=" SELECT * from appointments WHERE app_id = '$appid' ";

    $result_app = $conn->query($sql_app);
    $row_app=mysqli_fetch_array($result_app);
    $app_id=$row_app['app_id'];
    $u_id=$row_app['user_id'];
    $patient_name=$row_app['patient_name'];
    $patient_age=$row_app['patient_age'];
    $gender=$row_app['gender'];
    $doc_id=$row_app['doc_id'];
    $hos_id=$row_app['hos_id'];
    $date=$row_app['date'];
    $time_slot=$row_app['time_slot'];

    $sql_doc="SELECT * from doctor WHERE doc_id ='$doc_id'";
    $result_doc = $conn->query($sql_doc);
    $row_doc=mysqli_fetch_array($result_doc);
    $doc_name=$row_doc['name'];
    $count = mysqli_num_rows($result_app);

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('image/logo.jpg',10,6,50);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(40,10,'TRUE CARE',1,0,'C');
    // Line break
    $this->Ln(40);


}



// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);

$pdf->Write(5,'         USER-ID                  :'.$u_id.'');
$pdf->Ln(10);
$pdf->Write(10,'        Appointment ID          :'.$appid.'');
$pdf->Ln(10);
$pdf->Write(5,'         Patient NAME            :'.$patient_name.'');
$pdf->Ln(10);
$pdf->Write(5,'         Age                      :'.$patient_age.'');
$pdf->Ln(10);
$pdf->Write(5,'         Gender                  :'.$gender.'');
$pdf->Ln(10);
$pdf->Write(5,'         Hospital ID             :'.$hos_id.'');
$pdf->Ln(10);
$pdf->Write(5,'         Doctor ID               :'.$doc_id.'');
$pdf->Ln(10);
$pdf->Write(5,'         Doctor Name             :'.$doc_name.'');
$pdf->Ln(10);
$pdf->Write(5,'         Date                    :'.$date.'');
$pdf->Ln(10);
$pdf->Write(5,'         Time Slot               :'.$time_slot.'');
$pdf->Ln(10);   


$pdf->Write(5,'Patient Signature    :');
$pdf->Ln(10);


$pdf->Write(5,'Doctor Signature     :');

$pdf->Ln(10);
//Create a new PDF file
// $pdf=new FPDF();
// $pdf->AddPage();

// //Fields Name position
// $Y_Fields_Name_position = 10;
// //Table position, under Fields Name
// $Y_Table_Position = 26;

// //First create each Field Name
// //Gray color filling each Field Name box
// $pdf->SetFillColor(232,232,232);
// //Bold Font for Field Name
// $pdf->SetFont('Arial','B',12);
// $pdf->SetY($Y_Fields_Name_position);
// $pdf->SetX(45);
// $pdf->Cell(10,6,'CODE',1,0,'L',1);
// $pdf->SetX(65);
// $pdf->Cell(100,6,'NAME',1,0,'L',1);
// $pdf->SetX(135);
// $pdf->Cell(30,6,'PRICE',1,0,'R',1);
// $pdf->Ln();

// //Now show the 3 columns
// $pdf->SetFont('Arial','',12);
// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(45);
// $pdf->MultiCell(10,6,$app_id,1);
// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(65);
// $pdf->MultiCell(100,6,$app_id,1);
// $pdf->SetY($Y_Table_Position);
// $pdf->SetX(135);
// $pdf->MultiCell(30,6,$date,1,'R');
// $pdf->SetX(135);


// //Create lines (boxes) for each ROW (Product)
// //If you don't use the following code, you don't create the lines separating each row
// $i = 0;
// $pdf->SetY($Y_Table_Position);
// // while ($i < $number_of_products)
// // {
// //     $pdf->SetX(45);
// //     $pdf->MultiCell(110,6,'',1);
// //     $i = $i +1;
// // }

$pdf->Output();
?>
