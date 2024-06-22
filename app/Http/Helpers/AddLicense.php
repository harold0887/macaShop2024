<?php

namespace App\Http\Helpers;

use App\Models\Order;
use App\Models\Product;
use setasign\Fpdi\Fpdi;

class AddLicense
{

    public  $order, $product, $licencia, $message, $licenciaExternal;


    public function __construct($id, $order)
    {

        $this->product = Product::findOrFail($id);
        $this->order = Order::findOrFail($order);
        $this->message = "Documento con derechos de autor © Material didáctico MaCa. Queda prohibida su reventa";
        $this->licencia = "w" . $this->order->user->id . "- licencia de uso personal para " . $this->order->user->name . " - " . $this->order->user->email;
        $this->licenciaExternal = "MaCa-" . substr($this->order->id, -5)  . " - licencia de uso personal para " . $this->order->user->email;
    }

    public function setLicense()
    {
        //Agregar folio a PDFs
        $pdf = new Fpdi();
        set_time_limit(0);
        if (env('APP_ENV') == 'local') {
            $patch = "storage/" . $this->product->document;
        } else {
            $patch = "public/storage/" . $this->product->document;
        }

        $pageCount = $pdf->setSourceFile($patch);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->AddPage($size['orientation']);
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
            $pdf->SetFont('Arial', 'i', 8);
            //$pdf->SetTextColor(181, 178, 178);
            $pdf->SetXY(2, 0);
            $pdf->Write(8, utf8_decode($this->message));
            $pdf->SetXY(2, 4);
            $pdf->Write(8, utf8_decode($this->licencia));
        }

        $pdf->Output('pdf/newpdf.pdf', 'F');
        return true;
    }
    public function download()
    {

        //dd("llego a la descarga");
        //Agregar folio a PDF
        $pdf = new Fpdi();
        set_time_limit(0);

        if (env('APP_ENV') == 'local') {
            $patch = "storage/" . $this->product->document;
        } else {
            $patch = "public/storage/" . $this->product->document;
        }

        //$pdf->setSourceFile($patch);
        $pageCount = $pdf->setSourceFile($patch);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->AddPage($size['orientation']);
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
            $pdf->SetFont('Arial', 'i', 8);
            //$pdf->SetTextColor(181, 178, 178);
            $pdf->SetXY(2, 0);
            $pdf->Write(8, utf8_decode($this->message));
            $pdf->SetXY(2, 4);
            $pdf->Write(8, utf8_decode($this->licencia));
        }
        $pdf->Output('pdf/newpdf.pdf', 'F');

        return true;
    }
    public function setLicenseExternal()
    {
        //Agregar folio a PDFs
        $pdf = new Fpdi();
        set_time_limit(0);
        if (env('APP_ENV') == 'local') {
            $patch = "storage/" . $this->product->document;
        } else {
            $patch = "public/storage/" . $this->product->document;
        }

        $pageCount = $pdf->setSourceFile($patch);
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->AddPage($size['orientation']);
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
            $pdf->SetFont('Arial', 'i', 8);
            //$pdf->SetTextColor(181, 178, 178);
            $pdf->SetXY(2, 0);
            $pdf->Write(8, utf8_decode($this->message));
            $pdf->SetXY(2, 4);
            $pdf->Write(8, utf8_decode($this->licenciaExternal));
        }

        $pdf->Output('pdf/newpdf.pdf', 'F');
        return true;
    }
}
