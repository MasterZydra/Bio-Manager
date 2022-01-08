<?php

/*
* pdfGenerator.php
* ----------------
* This file contains the class 'pdfGenerator'.
* The class generates an PDF document out of given HTML code.
* The document then can be safed or shown in the browser.
*
* @Author: David Hein
*/

include_once 'ext/TCPDF/tcpdf.php';

class pdfGenerator
{
    function __construct()
    {
        $this -> pdf = null;
    }

    public function createPDF($author, $title, $subject, $htmlCode)
    {
        $this -> pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Document informations
        $this -> pdf -> SetCreator(PDF_CREATOR);
        $this -> pdf -> SetAuthor($author);
        $this -> pdf -> SetTitle($title);
        $this -> pdf -> SetSubject($subject);

        // Deactivate Header und Footer
        $this -> pdf -> SetPrintHeader(false);
        $this -> pdf -> SetPrintFooter(false);

        // Use monospaced font
        $this -> pdf -> SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // Set Margins
        $this -> pdf -> SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        // Automatic Autobreak of the pages
        $this -> pdf -> SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // Image Scale
        $this -> pdf -> setImageScale(PDF_IMAGE_SCALE_RATIO);

        // Set font and font size
        $this -> pdf -> SetFont('dejavusans', '', 10);

        // Add new page
        $this -> pdf -> AddPage();

        // Add HTML code to page and generate PDF out of it
        $this -> pdf -> writeHTML($htmlCode, true, false, true, false, '');
    }

    public function showInBrowser($fileName)
    {
        // Show PDF to user in browser window
        $this -> pdf -> Output($fileName . '.pdf', 'I');
    }
}
