<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Masalah;
use App\Models\Produk;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Carbon;

class HistoryController extends Controller
{
    //
    public function getCollection()
    {
        $query = Masalah::query();
        $query->join('lmljs', 'masalahs.lmlj_id', '=', 'lmljs.id');
        $query->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id');
        $query->leftJoin('tembusans', 'lmljs.id', '=', 'tembusans.lmlj_id');

        // Pengkondisian
        $query->where([['masalahs.unit_tujuan_id', auth()->user()->unit->id], ['masalahs.status', '=', 4]]);
        $query->orwhere([['forwards.unit_id', auth()->user()->unit->id], ['masalahs.status', '=', 4]]);
        $query->orwhere([['lmljs.unit_pengaju_id', auth()->user()->unit->id], ['masalahs.status', '=', 4]]);
        if (auth()->user()->role_id == 2) {
            $query->orwhere([['tembusans.unit_id', auth()->user()->unit->id], ['masalahs.status', '=', 4]]);
        }

        $list_get = [
            'masalahs.*',
            'lmljs.id AS lmlj_id',
            'lmljs.produk_id',
            'lmljs.pengaju_id',
            'lmljs.spv_pengaju_id',
            'lmljs.unit_pengaju_id',
            'tembusans.unit_id AS unit_tembusan_id',
            'tembusans.status AS status_tembusan',
            'forwards.unit_id AS unit_forward_id',
            'forwards.status AS status_forward'
        ];


        $collection = $query->get($list_get)->unique('id');
        foreach ($collection as $item) {
            $item->color = $this->getUrgensiColor($item->target);
            $item->text_status = $this->getStatusText($item->status);
            $item->color_status = $this->getStatusColor($item->status);
        }
        return $collection;
    }
    public function getCollectionAjuan($startDate, $endDate)
    {
        $query = Masalah::query();
        $query->with('media');
        $query->join('lmljs', 'masalahs.lmlj_id', '=', 'lmljs.id');
        $query->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id');
        $query->leftJoin('tembusans', 'lmljs.id', '=', 'tembusans.lmlj_id');

        $from = Carbon::createFromFormat('d-m-Y', $startDate);
        $to = Carbon::createFromFormat('d-m-Y', $endDate);
        // dd($to);
        // $to = Carbon::now();
        // $query->where([['masalahs.created_at', '>=', $from], ['masalahs.created_at', '<=', $to]]);
        $query->where([['masalahs.unit_tujuan_id', auth()->user()->unit->id], ['masalahs.status', '=', 4], ['masalahs.created_at', '>=', $from], ['masalahs.created_at', '<=', $to]]);
        $query->orwhere([['forwards.unit_id', auth()->user()->unit->id], ['masalahs.created_at', '>=', $from], ['masalahs.created_at', '<=', $to], ['masalahs.status', '=', 4]]);
        if (auth()->user()->role_id == 2) {
            $query->orwhere([['tembusans.unit_id', auth()->user()->unit->id], ['masalahs.created_at', '>=', $from], ['masalahs.created_at', '<=', $to], ['masalahs.status', '=', 4]]);
        }

        $list_get = [
            'masalahs.*',
            'lmljs.id AS lmlj_id',
            'lmljs.produk_id',
            'lmljs.pengaju_id',
            'lmljs.spv_pengaju_id',
            'lmljs.unit_pengaju_id',
            'tembusans.unit_id AS unit_tembusan_id',
            'tembusans.status AS status_tembusan',
            'forwards.unit_id AS unit_forward_id',
            'forwards.status AS status_forward'
        ];


        $collection = $query->get($list_get)->unique('id');
        return $collection;
    }
    public function getCollectionPengjauan($startDate, $endDate)
    {
        $query = Masalah::query();
        $query->with('media');
        $query->join('lmljs', 'masalahs.lmlj_id', '=', 'lmljs.id');
        $query->leftJoin('forwards', 'masalahs.id', '=', 'forwards.masalah_id');
        $query->leftJoin('tembusans', 'lmljs.id', '=', 'tembusans.lmlj_id');

        // Pengkondisian
        $from = Carbon::createFromFormat('d-m-Y', $startDate);
        $to = Carbon::createFromFormat('d-m-Y', $endDate);
        $query->where([['masalahs.created_at', '>=', $from], ['masalahs.created_at', '<=', $to]]);
        $query->where([['lmljs.unit_pengaju_id', auth()->user()->unit->id], ['masalahs.status', '=', 4]]);
        $list_get = [
            'masalahs.*',
            'lmljs.id AS lmlj_id',
            'lmljs.produk_id',
            'lmljs.pengaju_id',
            'lmljs.spv_pengaju_id',
            'lmljs.unit_pengaju_id',
            'tembusans.unit_id AS unit_tembusan_id',
            'tembusans.status AS status_tembusan',
            'forwards.unit_id AS unit_forward_id',
            'forwards.status AS status_forward'
        ];
        $collection = $query->get($list_get)->unique('id');
        return $collection;
    }

    public function index()
    {
        $collection = $this->getCollection();
        // dd($collection);
        $data = [
            'title' => 'History LMLJ',
            'slug'  => 'history',
            'masalah' => $collection,
            'kotak_masuk' => $this->getKotakMasuk(),
            'produk'    => Produk::all(),
            'number' => 1
        ];

        // dd(auth()->user()->unit->id);
        // dd($collection);
        return view('lmlj.history-lmlj', $data);
    }

    public function getHistoryLmlj(Request $request)
    {
        $collection = $this->getCollection();

        $response = array(
            'status' => 'success',
            'awal' => $request->tanggal_awal,
            'akhir' => $request->tanggal_akhir,
            'unit_id' => $request->unit_id,
        );
        return response()->json($collection);
    }

    public function printHistory($startDate, $endDate)
    {

        $filename = __DIR__ . '/../../../public/template/template-report.xlsx';
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($filename);
        $pengajuan = $this->getCollectionPengjauan($startDate, $endDate);
        $ajuan = $this->getCollectionAjuan($startDate, $endDate);
        // dd($pengajuan);
        // dd($ajuan);

        $sheet = $spreadsheet->getSheetByName('PENGAJUAN');
        $no = 1;
        $sheet->setCellValue('A1', 'PENGAJUAN LMLJ ' . date('Y') . ' – ' . auth()->user()->unit->unit);
        foreach ($pengajuan as $item) {
            $sheet->setCellValue('A' . ($no + 2), $no);
            $sheet->setCellValue('B' . ($no + 2), $item->created_at->format('d-m-Y'));
            $sheet->setCellValue('C' . ($no + 2), $item->nolmlj);
            $temp = "";
            $i = 1;
            $temp = $i . ". Tujuan : " . $item->unit->unit . "\n";
            $i++;
            if ($item->forward->count() > 0) {
                foreach ($item->forward as $forward) {
                    $temp = $temp . $i . ". Forward : " . $forward->unit->unit . "\n";
                    $i++;
                }
            }
            if ($item->lmlj->tembusan->count() > 0) {
                foreach ($item->lmlj->tembusan as $tembusan) {
                    $temp = $temp . $i . ". Tembusan : " . $tembusan->unit->unit . "\n";
                    $i++;
                }
            }
            $sheet->setCellValue('D' . ($no + 2), $temp);
            $sheet->setCellValue('E' . ($no + 2), $item->produk->nama);
            $sheet->setCellValue('F' . ($no + 2), $item->komponen->nama);
            if ($item->media->count() > 0) {
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $imgSrc = __DIR__ . '/../../../public/upload_media/masalah/' . $item->pengaju->unit->unit . '/' . $item->media[0]->file;
                $drawing->setPath($imgSrc);
                $drawing->setCoordinates('G' . ($no + 2));
                $drawing->setWidthAndHeight(180, 360);
                $drawing->setWorksheet($spreadsheet->getActiveSheet());
                $spreadsheet->getActiveSheet()->getRowDimension(($no + 2))->setRowHeight(250);
            }
            $temp = "";
            $i = 1;
            foreach ($item->detailmasalah as $masalah) {
                $temp = $temp . $i . ". " . $masalah->detail . "\n";
                $i++;
            }
            $sheet->setCellValue('H' . ($no + 2), $temp);
            $sheet->getStyle('H' . ($no + 2))->getAlignment()->setWrapText(true);
            $sheet->setCellValue('I' . ($no + 2), $item->updated_at->format('d-m-Y'));
            $temp = "";
            $i = 1;
            foreach ($item->jawaban as $jawaban) {
                $temp = $temp . $i . ". " . $jawaban->perbaikan[0]->created_at->format('d-m-Y') . " -> " . $jawaban->perbaikan[0]->perbaikan . " by unit " . $jawaban->unit->unit . "\n";
                $i++;
            }


            $sheet->setCellValue('J' . ($no + 2), $temp);
            $sheet->getStyle('J' . ($no + 2))->getAlignment()->setWrapText(true);
            if ($item->jawaban[0]->media->count() > 0) {
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $imgSrc = __DIR__ . '/../../../public/upload_media/jawaban/' . $item->pengaju->unit->unit . '/' . $item->jawaban[0]->media[0]->file;
                $drawing->setPath($imgSrc);
                $drawing->setCoordinates('K' . ($no + 2));
                $drawing->setWidthAndHeight(180, 360);
                $drawing->setWorksheet($spreadsheet->getActiveSheet());
                $spreadsheet->getActiveSheet()->getRowDimension(($no + 2))->setRowHeight(250);
                if ($item->jawaban[0]->media->count() == 2) {
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $imgSrc = __DIR__ . '/../../../public/upload_media/jawaban/' . $item->pengaju->unit->unit . '/' . $item->jawaban[0]->media[1]->file;
                    $drawing->setPath($imgSrc);
                    $drawing->setCoordinates('L' . ($no + 2));
                    $drawing->setWidthAndHeight(180, 360);
                    $drawing->setWorksheet($spreadsheet->getActiveSheet());
                }
            }
            $temp = null;
            $i = 1;
            // dd($item->jawaban[1]->keputusan);
            foreach ($item->jawaban as $jawaban) {
                $temp = $temp . $i . ". " . $jawaban->keputusan . "\n";
                $i++;
            }
            $sheet->setCellValue('M' . ($no + 2), $temp);
            // dd($temp);


            $no++;
        }

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => 'FF000000'),
                ),
            ),
        );
        $sheet->getStyle('A3:M' . ($no + 1))->applyFromArray($styleArray);

        $sheet = $spreadsheet->getSheetByName('AJUAN');
        $no = 1;
        $sheet->setCellValue('A1', 'AJUAN LMLJ ' . date('Y') . ' – ' . auth()->user()->unit->unit);
        foreach ($ajuan as $item) {
            $sheet->setCellValue('A' . ($no + 2), $no);
            $sheet->setCellValue('B' . ($no + 2), $item->created_at->format('d-m-Y'));
            $sheet->setCellValue('C' . ($no + 2), $item->nolmlj);
            $sheet->setCellValue('D' . ($no + 2), $item->pengaju->unit->unit);
            $sheet->setCellValue('E' . ($no + 2), $item->produk->nama);
            $sheet->setCellValue('F' . ($no + 2), $item->komponen->nama);
            if ($item->media->count() > 0) {
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $imgSrc = __DIR__ . '/../../../public/upload_media/masalah/' . $item->pengaju->unit->unit . '/' . $item->media[0]->file;
                $drawing->setPath($imgSrc);
                $drawing->setCoordinates('G' . ($no + 2));
                $drawing->setWidthAndHeight(180, 360);
                $drawing->setWorksheet($spreadsheet->getActiveSheet());
                $spreadsheet->getActiveSheet()->getRowDimension(($no + 2))->setRowHeight(250);
            }
            foreach ($item->detailmasalah as $masalah) {
                $sheet->setCellValue('H' . ($no + 2), $masalah->detail);
            }
            $temp = "";
            $i = 1;
            foreach ($item->detailmasalah as $masalah) {
                $temp = $temp . $i . ". " . $masalah->detail . "\n";
                $i++;
                // $sheet->setCellValue('H' . ($no + 2), $masalah->detail);
            }
            $sheet->setCellValue('H' . ($no + 2), $temp);
            $sheet->getStyle('H' . ($no + 2))->getAlignment()->setWrapText(true);
            if ($item->jawaban[0]->media->count() > 0) {
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $imgSrc = __DIR__ . '/../../../public/upload_media/jawaban/' . $item->pengaju->unit->unit . '/' . $item->jawaban[0]->media[0]->file;
                // dd($imgSrc);
                // $imgSrc = __DIR__ . '/../../../public/upload_media/masalah/satu/SATU-LMLJ-08-22-0001-M1-01.jpg';
                $drawing->setPath($imgSrc);
                $drawing->setCoordinates('K' . ($no + 2));
                $drawing->setWidthAndHeight(180, 360);
                $drawing->setWorksheet($spreadsheet->getActiveSheet());
                $spreadsheet->getActiveSheet()->getRowDimension(($no + 2))->setRowHeight(250);
                if ($item->jawaban[0]->media->count() == 2) {
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $imgSrc = __DIR__ . '/../../../public/upload_media/jawaban/' . $item->pengaju->unit->unit . '/' . $item->jawaban[0]->media[1]->file;
                    // dd($imgSrc);
                    // $imgSrc = __DIR__ . '/../../../public/upload_media/masalah/satu/SATU-LMLJ-08-22-0001-M1-01.jpg';
                    $drawing->setPath($imgSrc);
                    $drawing->setCoordinates('L' . ($no + 2));
                    $drawing->setWidthAndHeight(180, 360);
                    $drawing->setWorksheet($spreadsheet->getActiveSheet());
                }
            }
            $temp = "";
            $i = 1;
            foreach ($item->jawaban as $jawaban) {
                $temp = $temp . $i . ". " . $jawaban->keputusan . "\n";
                $i++;
            }
            $sheet->setCellValue('M' . ($no + 2), $temp);

            $no++;
        }

        $sheet->getStyle('A3:M' . ($no + 1))->applyFromArray($styleArray);



        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="test.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'xlsx');
        $writer->save('php://output');
    }
}
