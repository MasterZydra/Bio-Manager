<?php

declare(strict_types = 1);

namespace Framework\PDF;

use Framework\Facades\Path;
use TCPDF;

require_once Path::join(__DIR__, '..', '..', 'ext', 'TCPDF', 'tcpdf.php');

class PDF
{
    private ?TCPDF $pdf = null;

    public function createPDF(string $author, string $title, string $subject, string $html): self
    {
        $this->pdf = new TCPDF();

        // Document information
        $this->pdf->setCreator(PDF_AUTHOR);
        $this->pdf->setAuthor($author);
        $this->pdf->setTitle($title);
        $this->pdf->setSubject($subject);

        // Configure layout
        $this->pdf->setPrintHeader(false);
        $this->pdf->setPrintFooter(false);
        $this->pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->pdf->setAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $this->pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $this->pdf->setFont('dejavusans', '', 10);
        
        // Add content
        $this->pdf->AddPage();
        $this->pdf->writeHTML($html, reseth: true);

        return $this;
    }

    /** Show the created PDF in the browser */
    public function showInBrowser(string $fileName): void
    {
        $this->pdf->Output($fileName . '.pdf');
    }
}