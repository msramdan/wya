<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Employee;
use App\Models\Hospital;
use App\Models\Equipment;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;



class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $start_date = intval($request->query('start_date'));
        $end_date = intval($request->query('end_date'));
        $hospitals = Hospital::all();
        $hospital_id = intval($request->query('hospital_id'));
        $sessionId = Auth::user()->roles->first()->hospital_id;
        if ($sessionId == null) {
            if (isset($hospital_id) && !empty($hospital_id)) {
                $ids = $hospital_id;
            } else {
                $ids = Hospital::first()->id;
            }
        } else {
            $ids = Auth::user()->roles->first()->hospital_id;
        }
        $countVendor = Vendor::where('hospital_id', $ids)->count();
        $countEmployee = Employee::where('hospital_id', $ids)->count();
        $countEquipment = Equipment::where('hospital_id', $ids)->count();
        $countWorkOrder = WorkOrder::where('hospital_id', $ids)->count();
        $vendor = Vendor::where('hospital_id', $ids)->get();
        $employees = Employee::where('hospital_id', $ids)->get();

        $in = DB::table('sparepart_trace')
            ->join('spareparts', 'sparepart_trace.sparepart_id', '=', 'spareparts.id')
            ->select('sparepart_trace.*', 'spareparts.hospital_id')
            ->where('hospital_id', $ids)
            ->where('type', '=', 'In')
            ->limit(10);
        $out = DB::table('sparepart_trace')
            ->join('spareparts', 'sparepart_trace.sparepart_id', '=', 'spareparts.id')
            ->select('sparepart_trace.*', 'spareparts.hospital_id')
            ->where('hospital_id', $ids)
            ->where('type', '=', 'Out')
            ->limit(10);
        if (isset($start_date) && !empty($start_date)) {
            $from = date("Y-m-d H:i:s", substr($request->query('start_date'), 0, 10));
            $microFrom = $start_date;
            $in = $in->where('sparepart_trace.created_at', '>=', $from);
            $out = $out->where('sparepart_trace.created_at', '>=', $from);
        } else {
            $from = date('Y-m-d') . " 00:00:00";
            $microFrom = strtotime($from) * 1000;
            $in = $in->where('sparepart_trace.created_at', '>=', $from);
            $out = $out->where('sparepart_trace.created_at', '>=', $from);
        }
        if (isset($end_date) && !empty($end_date)) {
            $to = date("Y-m-d H:i:s", substr($request->query('end_date'), 0, 10));
            $microTo = $end_date;
            $in = $in->where('sparepart_trace.created_at', '<=', $to);
            $out = $out->where('sparepart_trace.created_at', '<=', $to);
        } else {
            $to = date('Y-m-d') . " 23:59:59";
            $microTo = strtotime($to) * 1000;
            $in = $in->where('sparepart_trace.created_at', '<=', $to);
            $out = $out->where('sparepart_trace.created_at', '<=', $to);
        }
        $sql = "SELECT * FROM `spareparts` WHERE hospital_id='$ids' and stock < opname limit 10";
        return view('dashboard', [
            'vendor' => $vendor,
            'employees' => $employees,
            'microFrom' => $microFrom,
            'microTo' => $microTo,
            'in' => $in->orderBy('id', 'desc')->get(),
            'out' => $out->orderBy('id', 'desc')->get(),
            'dataOpname' => DB::select($sql),
            'hispotals' => $hospitals,
            'ids' => $ids,
            'countVendor' => $countVendor,
            'countEmployee' => $countEmployee,
            'countEquipment' => $countEquipment,
            'countWorkOrder' => $countWorkOrder
        ]);
    }
    public function getTotalWorkOrder(Request $request)
    {
        if (request()->ajax()) {
            $workOrders = WorkOrder::with('equipment:id,barcode', 'user:id,name', 'hospital:id,name')->orderBy('work_orders.id', 'DESC');
            $type_wo = $request->query('type_wo');

            if ($request->has('hospital_id') && !empty($request->hospital_id)) {
                $workOrders = $workOrders->where('hospital_id', $request->hospital_id);
            } else {
                $hospital = Hospital::first();
                $workOrders = $workOrders->where('hospital_id', $hospital->id);
            }
            if (Auth::user()->roles->first()->hospital_id) {
                $workOrders = $workOrders->where('hospital_id', Auth::user()->roles->first()->hospital_id);
            }

            return DataTables::of($workOrders)
                ->addIndexColumn()
                ->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })->addColumn('wo_number', function ($row) {
                    return $row->wo_number;
                })
                ->addColumn('approval_users_id', function ($row) {
                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;
                        return $row;
                    });

                    return json_decode($arrApprovalUsers);
                })
                ->addColumn('note', function ($row) {
                    return str($row->note)->limit(100);
                })
                ->addColumn('equipment', function ($row) {
                    return $row->equipment ? $row->equipment->barcode : '';
                })->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '';
                })->addColumn('action', function ($row) {
                    $displayAction = true;
                    if ($row->status_wo == 'accepted' || $row->status_wo == 'rejected' || $row->status_wo == 'on-going' || $row->status_wo == 'finished') {
                        $displayAction = false;
                    } else {
                        foreach (json_decode($row->approval_users_id, true) as $rowApproval) {
                            if ($rowApproval['status'] == 'accepted' || $rowApproval['status'] == 'rejected') {
                                $displayAction = false;
                            }
                        }
                    }

                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;

                        return $row;
                    });
                })
                ->make(true);
        }
    }
    public function getTotalEquipment(Request $request)
    {
        if (request()->ajax()) {
            $equipments = Equipment::with('nomenklatur:id,name_nomenklatur', 'equipment_category:id,category_name', 'vendor:id,name_vendor', 'equipment_location:id,location_name', 'hospital:id,name')->orderBy('equipment.id', 'DESC');
            if ($request->has('hospital_id') && !empty($request->hospital_id)) {
                $equipments = $equipments->where('hospital_id', $request->hospital_id);
            }
            if (Auth::user()->roles->first()->hospital_id) {
                $equipments = $equipments->where('hospital_id', Auth::user()->roles->first()->hospital_id);
            }

            return DataTables::of($equipments)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })
                ->addColumn('nomenklatur', function ($row) {
                    return $row->nomenklatur ? $row->nomenklatur->name_nomenklatur : '';
                })->addColumn('equipment_category', function ($row) {
                    return $row->equipment_category ? $row->equipment_category->category_name : '';
                })->addColumn('vendor', function ($row) {
                    return $row->vendor ? $row->vendor->name_vendor : '';
                })->addColumn('equipment_location', function ($row) {
                    return $row->equipment_location ? $row->equipment_location->location_name : '';
                })
                ->make(true);
        }
    }
    public function getTotalEmployee(Request $request)
    {
        if (request()->ajax()) {
            $employees = Employee::with('employee_type:id,name_employee_type', 'department:id,name_department', 'position:id,name_position', 'province:id,provinsi', 'kabkot:id,provinsi_id', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id', 'hospital:id,name');

            if ($request->has('hospital_id') && !empty($request->hospital_id)) {
                $employees = $employees->where('hospital_id', $request->hospital_id);
            }

            if (Auth::user()->roles->first()->hospital_id) {
                $employees = $employees->where('hospital_id', Auth::user()->roles->first()->hospital_id);
            }

            return DataTables::of($employees)
                ->addIndexColumn()
                ->addColumn('address', function ($row) {
                    return str($row->address)->limit(100);
                })
                ->addColumn('employee_status', function ($row) {
                    if ($row->employee_status) {
                        return 'Aktif';
                    } else {
                        return 'Non Aktif';
                    }
                })
                ->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })
                ->addColumn('employee_type', function ($row) {
                    return $row->employee_type ? $row->employee_type->name_employee_type : '';
                })->addColumn('department', function ($row) {
                    return $row->department ? $row->department->name_department : '';
                })->addColumn('position', function ($row) {
                    return $row->position ? $row->position->name_position : '';
                })->addColumn('province', function ($row) {
                    return $row->province ? $row->province->provinsi : '';
                })->addColumn('kabkot', function ($row) {
                    return $row->kabkot ? $row->kabkot->provinsi_id : '';
                })->addColumn('kecamatan', function ($row) {
                    return $row->kecamatan ? $row->kecamatan->kabkot_id : '';
                })->addColumn('kelurahan', function ($row) {
                    return $row->kelurahan ? $row->kelurahan->kecamatan_id : '';
                })
                ->make(true);
        }
    }
    public function getTotalVendor(Request $request)
    {
        if (request()->ajax()) {
            $vendors = Vendor::with('category_vendor:id,name_category_vendors', 'province:id,provinsi', 'kabkot:id,provinsi_id', 'kecamatan:id,kabkot_id', 'kelurahan:id,kecamatan_id', 'hospital:id,name');
            if ($request->has('hospital_id') && !empty($request->hospital_id)) {
                $vendors = $vendors->where('hospital_id', $request->hospital_id);
            }
            if (Auth::user()->roles->first()->hospital_id) {
                $vendors = $vendors->where('hospital_id', Auth::user()->roles->first()->hospital_id);
            }
            return DataTables::of($vendors)
                ->addIndexColumn()
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i:s');
                })->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d M Y H:i:s');
                })
                ->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })
                ->addColumn('category_vendor', function ($row) {
                    return $row->category_vendor ? $row->category_vendor->name_category_vendors : '';
                })->addColumn('province', function ($row) {
                    return $row->province ? $row->province->provinsi : '';
                })->addColumn('kabkot', function ($row) {
                    return $row->kabkot ? $row->kabkot->provinsi_id : '';
                })->addColumn('kecamatan', function ($row) {
                    return $row->kecamatan ? $row->kecamatan->kabkot_id : '';
                })->addColumn('kelurahan', function ($row) {
                    return $row->kelurahan ? $row->kelurahan->kecamatan_id : '';
                })
                ->toJson();
        }
    }
    public function getTotalWoByStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = totalWoByStatusDetail($request->status, $request->microFrom, $request->microTo, $request->ids);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })->addColumn('wo_number', function ($row) {
                    return $row->wo_number;
                })
                ->addColumn('approval_users_id', function ($row) {
                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;
                        return $row;
                    });

                    return json_decode($arrApprovalUsers);
                })
                ->addColumn('note', function ($row) {
                    return str($row->note)->limit(100);
                })
                ->addColumn('equipment', function ($row) {
                    return $row->equipment ? $row->equipment->barcode : '';
                })->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '';
                })->addColumn('action', function ($row) {
                    $displayAction = true;
                    if ($row->status_wo == 'accepted' || $row->status_wo == 'rejected' || $row->status_wo == 'on-going' || $row->status_wo == 'finished') {
                        $displayAction = false;
                    } else {
                        foreach (json_decode($row->approval_users_id, true) as $rowApproval) {
                            if ($rowApproval['status'] == 'accepted' || $rowApproval['status'] == 'rejected') {
                                $displayAction = false;
                            }
                        }
                    }

                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;

                        return $row;
                    });
                })
                ->make(true);
        }
    }
    public function getTotalWoByCategory(Request $request)
    {
        if ($request->ajax()) {
            $data = totalWoByCategoryDetail($request->status, $request->microFrom, $request->microTo, $request->ids);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })->addColumn('wo_number', function ($row) {
                    return $row->wo_number;
                })
                ->addColumn('approval_users_id', function ($row) {
                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;
                        return $row;
                    });

                    return json_decode($arrApprovalUsers);
                })
                ->addColumn('note', function ($row) {
                    return str($row->note)->limit(100);
                })
                ->addColumn('equipment', function ($row) {
                    return $row->equipment ? $row->equipment->barcode : '';
                })->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '';
                })->addColumn('action', function ($row) {
                    $displayAction = true;
                    if ($row->status_wo == 'accepted' || $row->status_wo == 'rejected' || $row->status_wo == 'on-going' || $row->status_wo == 'finished') {
                        $displayAction = false;
                    } else {
                        foreach (json_decode($row->approval_users_id, true) as $rowApproval) {
                            if ($rowApproval['status'] == 'accepted' || $rowApproval['status'] == 'rejected') {
                                $displayAction = false;
                            }
                        }
                    }

                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;

                        return $row;
                    });

                    return view('work-orders.include.action', ['model' => $row, 'displayAction' => $displayAction, 'arrApprovalUsers' => $arrApprovalUsers]);
                })
                ->make(true);
        }
    }
    public function getTotalWoByType(Request $request)
    {
        if ($request->ajax()) {
            $data = totalWoByTypeDetail($request->status, $request->microFrom, $request->microTo, $request->ids);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hospital', function ($row) {
                    return $row->hospital ? $row->hospital->name : '';
                })->addColumn('wo_number', function ($row) {
                    return $row->wo_number;
                })
                ->addColumn('approval_users_id', function ($row) {
                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;
                        return $row;
                    });

                    return json_decode($arrApprovalUsers);
                })
                ->addColumn('note', function ($row) {
                    return str($row->note)->limit(100);
                })
                ->addColumn('equipment', function ($row) {
                    return $row->equipment ? $row->equipment->barcode : '';
                })->addColumn('user', function ($row) {
                    return $row->user ? $row->user->name : '';
                })->addColumn('action', function ($row) {
                    $displayAction = true;
                    if ($row->status_wo == 'accepted' || $row->status_wo == 'rejected' || $row->status_wo == 'on-going' || $row->status_wo == 'finished') {
                        $displayAction = false;
                    } else {
                        foreach (json_decode($row->approval_users_id, true) as $rowApproval) {
                            if ($rowApproval['status'] == 'accepted' || $rowApproval['status'] == 'rejected') {
                                $displayAction = false;
                            }
                        }
                    }

                    $arrApprovalUsers = collect(json_decode($row->approval_users_id))->map(function ($row) {
                        $row->user_name = User::find($row->user_id)->name;

                        return $row;
                    });

                    return view('work-orders.include.action', ['model' => $row, 'displayAction' => $displayAction, 'arrApprovalUsers' => $arrApprovalUsers]);
                })
                ->make(true);
        }
    }

    public function generalReport(Request $request)
    {
        $start_date = intval($request->query('start_date'));
        $end_date = intval($request->query('end_date'));
        
        if (isset($start_date) && !empty($start_date)) {
            $from = date("Y-m-d H:i:s", substr($request->query('start_date'), 0, 10));
        } else {
            // $from = date('Y-m-d') . " 00:00:00";
            $from = date('d l Y');
        }
        if (isset($end_date) && !empty($end_date)) {
            $to = date("Y-m-d H:i:s", substr($request->query('end_date'), 0, 10));
        } else {
            // $to = date('Y-m-d') . " 23:59:59";
            $to = date('d l Y');
        }
        $get_hospital_id = Auth::user()->roles->first()->hospital_id;
        $penyaji = '';
        if ($get_hospital_id == null) {
            $hospital = Hospital::firstWhere('id', $request->hospital_id);
            $penyaji = $hospital->name;
        }else{
            $hospital = Hospital::firstWhere('id', Auth::user()->roles->first()->hospital_id);
            $penyaji = $hospital->name;
        }

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $fontStyleName = 'oneUserDefinedStyle';
        $phpWord->addFontStyle(
            $fontStyleName,
            array('name' => 'calibri', 'size' => 12)
        );
        $styleFont2 = array('bold' => true, 'size' => 12, 'name' => 'Calibri');
        $phpWord->addTitleStyle(null, array('size' => 20, 'bold' => false), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $phpWord->addTitleStyle(1, array('size' => 24, 'bold' => false), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $phpWord->addTitleStyle(2, array('size' => 18, 'color' => '000'), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $phpWord->addTitleStyle(3, array('size' => 14, 'italic' => true));
        $phpWord->addTitleStyle(4, array('size' => 12, 'bold' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));

        $paragraphStyleName = 'pStyle';
        $phpWord->addParagraphStyle($paragraphStyleName, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH));

        $multilevelNumberingStyleName = 'multilevel';
        $phpWord->addNumberingStyle(
            $multilevelNumberingStyleName,
            array(
                'type'   => 'multilevel',
                'levels' => array(
                    array('format' => 'decimal', 'text' => '%1.', 'left' => 360, 'hanging' => 360, 'tabPos' => 360, 'bold' => true),
                    array('format' => 'upperLetter', 'text' => '%2.', 'left' => 720, 'hanging' => 360, 'tabPos' => 720, 'bold' => true),
                    array('format' => 'decimal', 'text' => '%3.', 'left' => 1080, 'hanging' => 360, 'tabPos' => 1080, 'bold' => true),
                    array('format' => 'bullet', 'text' => '%4.', 'left' => 1280, 'hanging' => 360, 'tabPos' => 1280, 'bold' => true),
                ),
            )
        );

        // Add first page
        $section = $phpWord->addSection();
        $section->addTitle('General Report', 0);
        $section->addTitle($penyaji, 0);
        $section->addTextBreak(4);
        $section->addTitle('PROGRAM', 1);
        $section->addTitle('Inspection Preventive Maintenace', 1);
        $section->addTextBreak(17);
        $section->addTitle('Di Sajikan Oleh', 2);
        $section->addTitle($penyaji, 2);
        $section->addTitle($from . ' - ' . $to, 2);

        // Create a second page
        $section->addPageBreak();
        $section->addTitle('BAB I', 4);
        $section->addTitle('PENDAHULUAN', 4);
        $section->addTextBreak();
        $section->addText('             Infrastruktur Pelayanan Kesehatan adalah suatu alat dan/atau tempat yang digunakan untuk menyelenggarakan upaya kesehatan, baik promotif, preventif, kuratif maupun rehabilitatif yang dilakukan oleh pemerintah maupun masyarakat. Infrastruktur pada sebuah institusi Rumah Sakit pada umumnya dapat di klasifikasikan menjadi 5 sektor, diantaranya adalah Medical Equipment, Non Medical Equipment, Building, Human Resource dan Operational', $fontStyleName, $paragraphStyleName);
        $section->addImage(public_path('gr.png'), array('width' => 250, 'height' => 150));
        $section->addText('             Medical Equipment adalah infrastruktur terbesar dengan capaian persentase sekitar 37%. Sebagai infrastruktur Rumah Sakit terbesar tentu diharapkan agar peralatan medik tetap dalam kinerja optimal sehingga pelayan Rumah Sakit tidak terhambat. Terkait dengan peraturan Kementrian Kesehatan RI No.35 tentang pentingnya pemeliharaan dan panduan pemeliharaan untuk asset Rumah Sakit bahwa menjamin tersedianya alat kesehatan sesuai standar pelayanan, persyaratan mutu, keamanan, manfaat, keselamatan, dan laik pakai perlu adanya pemeliharaan secara periodik.', $fontStyleName, $paragraphStyleName);
        $section->addText('             Untuk itu perlu dilakukan Program Inspeksi, Pengujian dan Pemeliharaan Peralatan Medik (Inspection Preventive Maintenance). Dimana program ini merupakan suatu pengamatan secara sistematik yang disertai analisis teknis dan ekonomis untuk menjamin berfungsinya suatu alat kesehatan dan memperpanjang usia alat itu sendiri. Tujuannya untuk memastikan keandalan asset agar memperoleh suatu kualitas alat yang aman, laik pakai, serta menghilangkan potensi kegagalan peralatan.', $fontStyleName, $paragraphStyleName);
        $section->addText('             Berdasarkan hasil pengolahan data pada pemeliharaan periodik, diperoleh statistik yang dapat dimanfaatkan untuk program manajemen peralatan medik, sebagai perencanaan jangka panjang untuk upgrade dan penggantian alat. Dalam upaya pelaksanaannya, diperlukan aplikasi penunjang untuk melakukan pengelolaan peralatan medik.', $fontStyleName, $paragraphStyleName);
        $section->addText('             Aplikasi Manajemen Aset Rumah Sakit (MARS) dapat memenuhi kebutuhan Program Inspeksi, Pengujian dan Pemeliharaan Peralatan Medik tersebut, karena meliputi pencatatan dan pelaporan sesuai dengan Peraturan Menteri Kesehatan (PMK) No.15 Tahun 2023 tentang Pemeliharaan Alat Kesehatan di Fasilitas Pelayanan Kesehatan. Beberapa fitur yang terdapat pada aplikasi MARS diantaranya:', $fontStyleName, $paragraphStyleName);
        $section->addText(" 1. Manajemen Preventive Maintenane", $fontStyleName, $paragraphStyleName);
        $section->addText(" 2. Manajemen Inventory", $fontStyleName, $paragraphStyleName);
        $section->addText(" 3. Manajemen Peralatan dan Sparepart", $fontStyleName, $paragraphStyleName);
        $section->addText(" 4. Manajemen Expense", $fontStyleName, $paragraphStyleName);
        $section->addText(" 5. Manajemen Dokumen", $fontStyleName, $paragraphStyleName);
        $section->addText(" 6. General Report", $fontStyleName, $paragraphStyleName);
        $section->addText('             Statistik dari setiap fitur diperlukan sebagai rujukan pengembangan dan tolak ukur dalam Manajemen Fasilitas dan Keselamatan (MFK) dari Rumah Sakit. ', $fontStyleName, $paragraphStyleName);

        // Create a four page
        $section->addPageBreak();
        $section->addTitle('BAB II', 4);
        $section->addTitle('MANAJEMEN PERALATAN MEDIK', 4);
        $section->addTextBreak();

        $section->addText("2.1      MANAJEMEN INSPECTION PREVENTIVE MAINTENANCE (IPM)", $styleFont2, $paragraphStyleName);
        $section->addText('             Secara umum, Manajemen Inspection Preventive Maintenance (IPM) meliputi 4 (empat) jenis kegiatan yaitu: Preventive Maintenace, Service, Kalibrasi dan Training Berdasarkan hasil pengamatan berkala dalam periode 01 Maret – 31 Maret 2023 dilaporkan statistik sebagai berikut:', $fontStyleName, $paragraphStyleName);

        $section->addListItem('Preventive Maintenance', 2, null, $multilevelNumberingStyleName);
        $section->addText("Pada periode tersebut tercatat 1 kegiatan Preventive Maintenance Peralatan Medik yang telah terlaksana dari 10 jadwal kegiatan Preventive Maintenance yang telah di rencanakan.", $fontStyleName, $paragraphStyleName);
        $section->addText("Pencapaian pelaksanaan kegiatan Preventive Maintenance adalah sebesar 10% (Sepuluh Persen) dari JAdwal yang telah di rencanakan.", $fontStyleName, $paragraphStyleName);

        $section->addListItem('Service', 2, null, $multilevelNumberingStyleName);
        $section->addText("Pada periode tersebut kami mencatat terdapat 5 kegiatan Service Peralatan Medik yang telah terlaksana dari 5 jadwal kegiatan Service yang telah di rencanakan.", $fontStyleName, $paragraphStyleName);
        $section->addText("Pencapaian pelaksanaan kegiatan Service adalah sebesar 100% (Seratus Persen) dari JAdwal yang telah di rencanakan.", $fontStyleName, $paragraphStyleName);

        $section->addListItem('Kalibrasi', 2, null, $multilevelNumberingStyleName);
        $section->addText("Pada periode tersebut kami mencatat terdapat 4 kegiatan kalibrasi Peralatan Medik yang terlaksana dari 8 jadwal kegiatan Kalibrasi yang telah di rencanakan.", $fontStyleName, $paragraphStyleName);
        $section->addText("Pencapaian pelaksanaan kegiatan Kalibrasi adalah sebesar 50% (Lima puluh Persen) dari JAdwal yang telah di rencanakan.", $fontStyleName, $paragraphStyleName);

        $section->addListItem('Training', 2, null, $multilevelNumberingStyleName);
        $section->addText("Pada periode tersebut kami mencatat terdapat 2 kegiatan Training terlaksana dari 8 jadwal kegiatan Training yang telah di rencanakan, baik itu kegiatan Training yang dilakukan secara internal ataupun kegiatan yang di selenggarakan oleh Pihak Ketiga.", $fontStyleName, $paragraphStyleName);
        $section->addText("Pencapaian pelaksanaan kegiatan Training adalah sebesar 25% (Seratus Persen) dari JAdwal yang telah di rencanakan.", $fontStyleName, $paragraphStyleName);

        // Create a five page
        $section->addPageBreak();
        $section->addText("2.2      MANAJEMEN INVENTORY", $styleFont2, $paragraphStyleName);
        $section->addText('             Inventory Peralatan terbagi menjadi beberapa kategori Peralatan, dengan rincian sebagai berikut :', $fontStyleName, $paragraphStyleName);
        $section->addText("             •    Alat Medis terdapat 11 unit Peralatan dengan Total Asset Rp 1.196.120.911,-", $fontStyleName, $paragraphStyleName);
        $section->addText("             •    Alat Non Medis terdapat 1 unit Peralatan dengan Total Asset Rp 10.000.000,-", $fontStyleName, $paragraphStyleName);
        $section->addText("             •    Dengan Akumulasi Total Aset Peralatan sejumlah Rp 1.206.120.911,-", $fontStyleName, $paragraphStyleName);

        $section->addText("2.3      MANAJEMEN PERALATAN DAN SPAREPART", $styleFont2, $paragraphStyleName);
        $section->addText("1.       Asset Peralatan", $fontStyleName, $paragraphStyleName);
        $section->addText("Sampai dengan periode dibuat nya laporan ini, dapat kami sajikan data Inventory beserta Total Asset yang dimiliki :", $fontStyleName, $paragraphStyleName);
        $section->addText("             •    Alat Medis terdapat 11 unit Peralatan dengan Total Asset Rp 1.196.120.911,-", $fontStyleName, $paragraphStyleName);
        $section->addText("             •    Alat Non Medis terdapat 1 unit Peralatan dengan Total Asset Rp 10.000.000,-", $fontStyleName, $paragraphStyleName);
        $section->addText("             •    Dengan Akumulasi Total Aset Peralatan sejumlah Rp 1.206.120.911,-", $fontStyleName, $paragraphStyleName);

        $section->addText("2.       Riwayat Peralatan", $fontStyleName, $paragraphStyleName);
        $section->addText("Selain menyajikan jumlah peralatan yang dimiliki, disajikan juga riwayat peralatan masing-masing peralatannya, riwayat yang disajikan merupakan riwayat service, riwayat kalibrasi, riwayat maintenance, riwayat training, riwayat penggantian sparepart hingga riwayat pengeluaran biaya-biaya selama peralatan tersebut beroperasi (dicetak secara terpisah sebagai lampiran).", $fontStyleName, $paragraphStyleName);
        $section->addText("3.       Asset Sparepart", $fontStyleName, $paragraphStyleName);
        $section->addText("Telah dilakukan pendataan dan pencatatan Aset Sparepart yang di miliki oleh Rumah Sakit dan tercatat memiliki Total Aset Sparepart sebesar Rp 45.488.000,- ", $fontStyleName, $paragraphStyleName);
        $section->addText("4.       Riwayat Sparepart", $fontStyleName, $paragraphStyleName);
        $section->addText("Kami juga menyajikan data riwayat keluar masuk nya sparepart dan asesoris  yang kami sajikan terpisah sebagai lampiran.", $fontStyleName, $paragraphStyleName);


        $section->addText("2.4      MANAJEMEN EXPENSES", $styleFont2, $paragraphStyleName);
        $section->addText("             Selain pencatatan dan pelaporan kegiatan Inspection Preventive Maintenance, tercatat juga biaya-biaya pengeluaran untuk kegiatan Service, Kalibrasi dan Penggantian Sparepart yang secara otomatis tersimpan pada Riwayat Peralatan masing-masing. ", $fontStyleName, $paragraphStyleName);
        $section->addText("             Pada periode ini tercatat biaya pengeluaran untuk kegiatan Service sebesar Rp. 30.000.000,-", $fontStyleName, $paragraphStyleName);
        $section->addText("             Pada periode ini tercatat biaya pengeluaran untuk kegiatan Kalibrasi sebesar Rp. 10.000.000,-", $fontStyleName, $paragraphStyleName);
        $section->addText("             Pada periode ini tercatat biaya pengeluaran untuk kegiatan Penggantian Sparepart dan Asesoris sebesar Rp. 20.000.000,-", $fontStyleName, $paragraphStyleName);


        $section->addText("2.5      MANAJEMEN DOKUMEN", $styleFont2, $paragraphStyleName);
        $section->addText("2.6      GENERAL REPORT", $styleFont2, $paragraphStyleName);
        $section->addText("             Dari statistik yang tercatat selama periode 01 Maret 2023 sampai dengan 31 Maret 2023, dapat dilaporkan bahwa:", $fontStyleName, $paragraphStyleName);

        $section->addText("     1.  Program Inspection Preventive Maintenance (IPM) telah terlaksana dengan presentase 0% dari total asset peralatan Rumah Sakit.", $fontStyleName, $paragraphStyleName);
        $section->addText("     2.   Pemeliharaan pada program Inspection Preventive Maintenance (IPM) yang telah dilakukan mencapai 0% dari Work Order yang diajukan.", $fontStyleName, $paragraphStyleName);

        $section->addText("Dengan rincian 4 kategori Status Work Order sebagai berikut:", $fontStyleName, $paragraphStyleName);

        $section->addText("     1.   Approved terdapat 0 kasus", $fontStyleName, $paragraphStyleName);
        $section->addText("     2.   Rejected terdapat 0 kasus", $fontStyleName, $paragraphStyleName);
        $section->addText("     3.   On Progress terdapat 0 kasus", $fontStyleName, $paragraphStyleName);
        $section->addText("     4.   Finished/Closed terdapat 0 kasus", $fontStyleName, $paragraphStyleName);

        // Create a seventh page
        $section->addPageBreak();
        $section->addTitle('BAB III', 4);
        $section->addTitle('Kesimpulan', 4);
        $section->addTextBreak(1);
        $section->addText('             Berdasarkan ukuran statistik yang menunjukkan pemeliharaan atas peralatan medik, manajemen dapat menarik kesimpulan bahwa program Inspection Preventive Maintenance (IPM) memiliki peranan dan manfaat yang sangat penting dalam upaya peningkatan mutu pelayanan Rumah Sakit. Statistik tersebut dapat digunakan sebagai bahan acuan perencanaan program IPM berikutnya ataupun perencanaan penambahan peralatan medik.', $fontStyleName, $paragraphStyleName);
        $section->addTextBreak(0);
        $section->addText('             Demikian Laporan ini dapat kami sampaikan, semoga bermanfaat dalam upaya peningkatan mutu pelayanan Rumah Sakit.', $fontStyleName, $paragraphStyleName);
        $section->addTextBreak(2);
        $section->addText("                                                                                                                     Jakarta, " . date('d') . ' ' . getMonthIndo(date('m')) . ' ' . date('Y'));
        $section->addText("                                                                                                                     PT. Mitra Tera Akurasi");
        $section->addTextBreak(4);
        $section->addText("                                                                                                                         (Manager Teknik)");



        // Add footer
        $footer = $section->addFooter();
        $footer->addLink('https://marsweb.id', 'Present by Manajemen Aset Rumah Sakit (MARS)');
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path('General-Report.docx'));
        } catch (Exception $e) {
        }
        return response()->download(storage_path('General-Report.docx'));
    }
}
