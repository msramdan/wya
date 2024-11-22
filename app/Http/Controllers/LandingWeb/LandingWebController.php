<?php

namespace App\Http\Controllers\LandingWeb;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LandingWebController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function list()
    {
        $aduans = DB::table('aduans')
            ->where('type', 'Public')
            ->paginate(9);
        return view('frontend.list', compact('aduans'));
    }

    public function detail($id)
    {
        // Fetch the Aduan by ID and ensure it is of type 'Public'
        $aduan = DB::table('aduans')
            ->where('id', $id)
            ->where('type', 'Public')
            ->first();

        // If Aduan is not found, abort with a 404
        if (!$aduan) {
            return redirect()->route('aduans.index')->with('error', 'Aduan not found.');
        }

        // If found, return the detail view
        return view('frontend.detail', compact('aduan'));
    }


    public function form()
    {
        return view('frontend.form');
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'judul' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'type' => 'required|in:Public,Private',
            'g-recaptcha-response' => 'required|captcha',  // Assuming you're using Google reCAPTCHA
        ]);

        // Generate token for Private type, otherwise set it to null
        $token = $request->type == 'Private' ? strtoupper(bin2hex(random_bytes(3))) : null;

        // Use Query Builder to insert data into 'aduans' table
        try {
            DB::table('aduans')->insert([
                'nama' => $request->nama,
                'email' => $request->email,
                'judul' => $request->judul,
                'keterangan' => $request->keterangan,
                'type' => $request->type,
                'tanggal' => now(),
                'is_read' => 'No',
                'status' => 'Dalam Penanganan',
                'token' => $token,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // If the type is Private, add token information to the session
            if ($request->type == 'Private') {
                return redirect()->route('web.form')->with('success', 'Laporan berhasil dikirim. Token untuk melihat Aduan: <b>' . $token . '</b>');
            }

            return redirect()->route('web.form')->with('success', 'Laporan berhasil dikirim.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengirim laporan.');
        }
    }



    public function private()
    {
        return view('frontend.private');
    }

    public function search(Request $request)
    {
        if ($request->has('query')) {
            $query = $request->get('query');
            $suggestions = DB::table('aduans')
                ->where('judul', 'like', "%{$query}%")
                ->where('type', 'Public') // If you want to filter by type
                ->limit(5) // Limit the number of suggestions
                ->get(['judul', 'id']); // Return relevant fields

            // Prepare suggestions with their respective URLs (if needed)
            $suggestions = $suggestions->map(function ($item) {
                return [
                    'judul' => $item->judul,
                    'url' => route('web.detail', $item->id) // Assuming you have a show route for Aduan
                ];
            });

            return response()->json(['suggestions' => $suggestions]);
        }
    }
}
