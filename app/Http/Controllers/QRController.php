<?php

namespace App\Http\Controllers;

use App\Models\QRTemplateModel;
use Illuminate\View\View;

class QRController extends Controller
{
    public function index(): View
    {
        $vendor = auth()->user()->restorant;
        $linkToTheMenu = $vendor->getLinkAttribute();

        $areas = $vendor->areas()->with('tables')->get()->toArray();
        $tables = [];
        foreach ($areas as $key => $area) {
            foreach ($area['tables'] as $table) {
                $tables[$table['id']] = $area['name'] . ' - ' . $table['name'];
            }
        }
        //Brij Negi Update
        $qr_template = explode(',', config('settings.templates'));
        $qr_template_zip = env('linkToTemplates', '/impactfront/img/templates.zip');

        $path = '/uploads/qr-template/' . $vendor->id . '/';
        $customQRTemplate = QRTemplateModel::where('restaurant_id', $vendor->id)->get();

        if ($customQRTemplate->isNotEmpty()) {
            $zipPath = public_path('/uploads/qr-template/qrtemplate_' . $vendor->id . '.zip');
            if (file_exists($zipPath)) {
                $qr_template = $customQRTemplate->pluck('path')
                    ->map(function ($item) use ($path) {
                        return $path . $item;
                    })
                    ->toArray();

                $qr_template_zip = '/uploads/qr-template/qrtemplate_' . $vendor->id . '.zip';
            }
        }

        $dataToPass = [
            'url' => $linkToTheMenu,
            'titleGenerator' => __('Restaurant QR Generators'),
            'selectQRStyle' => __('SELECT QR STYLE'),
            'selectQRColor' => __('SELECT QR COLOR'),
            'color1' => __('Color 1'),
            'color2' => __('Color 2'),
            'titleDownload' => __('QR Downloader'),
            'selectTable' => __('Select Table'),
            'tables' => $tables,
            'allTables' => __('No specific table'),
            'downloadJPG' => __('Download JPG'),
            'titleTemplate' => __('Menu Print template'),
            'downloadPrintTemplates' => __('Download Print Templates'),
            'templates' => $qr_template,
            'linkToTemplates' => $qr_template_zip,
        ];

        return view('qrsaas.qrgen')->with('data', json_encode($dataToPass));
    }
}
