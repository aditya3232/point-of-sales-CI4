<?php 

// library Cetakpdf merupakan superclass, diamana nanti akan digunakan oleh controller item method print_barcode 
// (dlm hali ini subclassnya adalah class item yg berada di controller item)
// agar dapat digunakan oleh subclass item jangan lupa inisialisasi superclasnya(library Cetakpdf) di Basecontroller



// menunjukkan tempat
namespace App\Libraries;

// reference the Dompdf namespace
use Dompdf\Dompdf;

Class Cetakpdf {

    function PdfGenerator($html, $filename, $paper, $orientation)
    {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper($paper, $orientation);

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        // array('Attachment' => 0) agar file pdfnya tidak langsung terdownload, tapi open di new tab
        $dompdf->stream($filename, array("Attachment"=>0));
    }
}