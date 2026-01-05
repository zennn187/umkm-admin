<?php

namespace App\Http\Controllers;

use App\Models\UlasanProduk;
use App\Models\Produk;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UlasanProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = UlasanProduk::with(['produk.umkm', 'warga'])
                    ->latestFirst();

        // SEARCH
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('komentar', 'like', "%{$search}%")
                  ->orWhereHas('produk', function($q) use ($search) {
                      $q->where('nama_produk', 'like', "%{$search}%");
                  })
                  ->orWhereHas('warga', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // FILTER PRODUK
        if ($request->filled('produk_id')) {
            $query->where('produk_id', $request->produk_id);
        }

        // FILTER RATING
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // FILTER TANGGAL
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // FILTER VERIFIED
        if ($request->filled('is_verified')) {
            $query->where('is_verified', $request->is_verified == 'true');
        }

        // FILTER VISIBLE
        if ($request->filled('is_visible')) {
            $query->where('is_visible', $request->is_visible == 'true');
        }

        // SORTING
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // PAGINATION
        $ulasans = $query->paginate($request->get('per_page', 10))
                        ->withQueryString();

        // STATISTIK
        $totalUlasan = UlasanProduk::count();
        $avgRating = UlasanProduk::avg('rating') ?: 0;
        $verifiedCount = UlasanProduk::where('is_verified', true)->count();
        $todayCount = UlasanProduk::whereDate('created_at', today())->count();

        // DATA UNTUK FILTER
        $produks = Produk::where('status', 'Aktif')
                        ->orderBy('nama_produk')
                        ->get();

        return view('pages.ulasanproduk.index', compact(
            'ulasans',
            'produks',
            'totalUlasan',
            'avgRating',
            'verifiedCount',
            'todayCount'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produks = Produk::where('status', 'Aktif')
                        ->with('umkm')
                        ->orderBy('nama_produk')
                        ->get();

        $wargas = Warga::orderBy('name')
                      ->get(['warga_id', 'name', 'nik', 'telp']);

        return view('pages.ulasanproduk.create', compact('produks', 'wargas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required|exists:produk,produk_id',
            'warga_id' => 'required|exists:warga,warga_id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:10|max:2000',
            'is_verified' => 'nullable|boolean',
            'is_visible' => 'nullable|boolean',
        ], [
            'produk_id.required' => 'Produk harus dipilih.',
            'warga_id.required' => 'Warga harus dipilih.',
            'rating.required' => 'Rating harus diisi.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'komentar.required' => 'Komentar harus diisi.',
            'komentar.min' => 'Komentar minimal 10 karakter.',
            'komentar.max' => 'Komentar maksimal 2000 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validasi gagal. Silakan periksa data yang dimasukkan.');
        }

        DB::beginTransaction();

        try {
            // Cek apakah warga sudah memberi ulasan untuk produk ini
            $existingReview = UlasanProduk::where('produk_id', $request->produk_id)
                                        ->where('warga_id', $request->warga_id)
                                        ->first();

            if ($existingReview) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Warga ini sudah memberikan ulasan untuk produk ini. Silakan edit ulasan yang sudah ada.');
            }

            // Buat ulasan baru
            $ulasan = UlasanProduk::create([
                'produk_id' => $request->produk_id,
                'warga_id' => $request->warga_id,
                'rating' => $request->rating,
                'komentar' => $request->komentar,
                'is_verified' => $request->boolean('is_verified', false),
                'is_visible' => $request->boolean('is_visible', true),
            ]);

            DB::commit();

            return redirect()->route('ulasan-produk.index')
                ->with('success', 'Ulasan berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan ulasan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ulasan = UlasanProduk::with(['produk.umkm', 'produk.media', 'warga'])
                            ->findOrFail($id);

        // Hitung statistik untuk produk ini
        $produkStats = UlasanProduk::where('produk_id', $ulasan->produk_id)
                                ->selectRaw('COUNT(*) as total, AVG(rating) as average')
                                ->first();

        // Ambil ulasan lain dari produk yang sama
        $otherReviews = UlasanProduk::where('produk_id', $ulasan->produk_id)
                                    ->where('ulasan_id', '!=', $id)
                                    ->with('warga')
                                    ->latest()
                                    ->limit(5)
                                    ->get();

        return view('pages.ulasanproduk.show', compact('ulasan', 'produkStats', 'otherReviews'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ulasan = UlasanProduk::with(['produk', 'warga'])
                            ->findOrFail($id);

        $produks = Produk::where('status', 'Aktif')
                        ->with('umkm')
                        ->orderBy('nama_produk')
                        ->get();

        $wargas = Warga::orderBy('name')
                      ->get(['warga_id', 'name', 'nik', 'telp']);

        return view('pages.ulasanproduk.edit', compact('ulasan', 'produks', 'wargas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $ulasan = UlasanProduk::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'produk_id' => 'required|exists:produk,produk_id',
            'warga_id' => 'required|exists:warga,warga_id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string|min:10|max:2000',
            'is_verified' => 'nullable|boolean',
            'is_visible' => 'nullable|boolean',
        ], [
            'produk_id.required' => 'Produk harus dipilih.',
            'warga_id.required' => 'Warga harus dipilih.',
            'rating.required' => 'Rating harus diisi.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'komentar.required' => 'Komentar harus diisi.',
            'komentar.min' => 'Komentar minimal 10 karakter.',
            'komentar.max' => 'Komentar maksimal 2000 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validasi gagal. Silakan periksa data yang dimasukkan.');
        }

        DB::beginTransaction();

        try {
            // Cek apakah warga sudah memberi ulasan untuk produk ini (selain ulasan ini)
            $existingReview = UlasanProduk::where('produk_id', $request->produk_id)
                                        ->where('warga_id', $request->warga_id)
                                        ->where('ulasan_id', '!=', $id)
                                        ->first();

            if ($existingReview) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Warga ini sudah memberikan ulasan untuk produk ini.');
            }

            // Update ulasan
            $ulasan->update([
                'produk_id' => $request->produk_id,
                'warga_id' => $request->warga_id,
                'rating' => $request->rating,
                'komentar' => $request->komentar,
                'is_verified' => $request->boolean('is_verified', $ulasan->is_verified),
                'is_visible' => $request->boolean('is_visible', $ulasan->is_visible),
            ]);

            DB::commit();

            return redirect()->route('ulasan-produk.show', $ulasan->ulasan_id)
                ->with('success', 'Ulasan berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui ulasan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $ulasan = UlasanProduk::findOrFail($id);
            $ulasan->delete();

            DB::commit();

            return redirect()->route('ulasan-produk.index')
                ->with('success', 'Ulasan berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal menghapus ulasan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle verification status.
     */
    public function toggleVerification($id)
    {
        try {
            $ulasan = UlasanProduk::findOrFail($id);
            $ulasan->update([
                'is_verified' => !$ulasan->is_verified
            ]);

            return redirect()->back()
                ->with('success', 'Status verifikasi berhasil diubah.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengubah status verifikasi: ' . $e->getMessage());
        }
    }

    /**
     * Toggle visibility status.
     */
    public function toggleVisibility($id)
    {
        try {
            $ulasan = UlasanProduk::findOrFail($id);
            $ulasan->update([
                'is_visible' => !$ulasan->is_visible
            ]);

            return redirect()->back()
                ->with('success', 'Status visibilitas berhasil diubah.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengubah status visibilitas: ' . $e->getMessage());
        }
    }

    /**
     * Get reviews by product ID (API).
     */
    public function byProduk($produkId)
    {
        $reviews = UlasanProduk::with('warga')
                            ->where('produk_id', $produkId)
                            ->where('is_visible', true)
                            ->latest()
                            ->paginate(10);

        $averageRating = UlasanProduk::where('produk_id', $produkId)
                                    ->where('is_visible', true)
                                    ->avg('rating');

        $ratingCounts = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingCounts[$i] = UlasanProduk::where('produk_id', $produkId)
                                          ->where('rating', $i)
                                          ->where('is_visible', true)
                                          ->count();
        }

        return response()->json([
            'success' => true,
            'data' => $reviews,
            'stats' => [
                'average_rating' => round($averageRating, 1),
                'total_reviews' => $reviews->total(),
                'rating_counts' => $ratingCounts,
            ]
        ]);
    }

    /**
     * Export reviews to CSV/Excel.
     */
    public function export(Request $request)
    {
        $query = UlasanProduk::with(['produk', 'warga']);

        if ($request->filled('produk_id')) {
            $query->where('produk_id', $request->produk_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $ulasans = $query->latest()->get();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $ulasans,
                'count' => $ulasans->count()
            ]);
        }

        // CSV Export
        $fileName = 'ulasan-produk-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($ulasans) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM untuk Excel
            fwrite($file, "\xEF\xBB\xBF");

            // Header
            fputcsv($file, [
                'ID Ulasan',
                'Produk',
                'Warga',
                'Rating (1-5)',
                'Komentar',
                'Terverifikasi',
                'Terlihat',
                'Tanggal Dibuat',
                'Tanggal Diupdate'
            ]);

            // Data
            foreach ($ulasans as $ulasan) {
                fputcsv($file, [
                    $ulasan->ulasan_id,
                    $ulasan->produk->nama_produk ?? 'N/A',
                    $ulasan->warga->name ?? 'N/A',
                    $ulasan->rating,
                    $ulasan->komentar,
                    $ulasan->is_verified ? 'Ya' : 'Tidak',
                    $ulasan->is_visible ? 'Ya' : 'Tidak',
                    $ulasan->created_at->format('d/m/Y H:i'),
                    $ulasan->updated_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Bulk delete reviews.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:ulasan_produk,ulasan_id',
        ]);

        DB::beginTransaction();

        try {
            $count = UlasanProduk::whereIn('ulasan_id', $request->ids)->delete();

            DB::commit();

            return redirect()->route('ulasan-produk.index')
                ->with('success', "{$count} ulasan berhasil dihapus.");

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal menghapus ulasan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk verify reviews.
     */
    public function bulkVerify(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:ulasan_produk,ulasan_id',
        ]);

        DB::beginTransaction();

        try {
            $count = UlasanProduk::whereIn('ulasan_id', $request->ids)
                                ->update(['is_verified' => true]);

            DB::commit();

            return redirect()->route('ulasan-produk.index')
                ->with('success', "{$count} ulasan berhasil diverifikasi.");

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->with('error', 'Gagal memverifikasi ulasan: ' . $e->getMessage());
        }
    }
}
