<?php
        namespace App\Http\Controllers;

        use App\Models\Produk;
        use App\Models\Umkm;
        use Illuminate\Http\Request;

        class ProdukController extends Controller
        {
            /**
             * Display a listing of the resource.
             */
            public function index(Request $request)
            {
                // Query dasar dengan relasi UMKM
                $produks = Produk::with('umkm');

                // Fitur Search
                if ($request->has('search') && $request->search != '') {
                    $search = $request->search;
                    $produks->where(function ($query) use ($search) {
                        $query->where('nama_produk', 'like', "%{$search}%")
                            ->orWhere('jenis_produk', 'like', "%{$search}%") // TAMBAHKAN
                            ->orWhere('deskripsi', 'like', "%{$search}%")
                            ->orWhereHas('umkm', function ($q) use ($search) {
                                $q->where('nama_usaha', 'like', "%{$search}%");
                            });
                    });
                }



                // Fitur Filter UMKM
                if ($request->has('umkm_id') && $request->umkm_id != '') {
                    $produks->where('umkm_id', $request->umkm_id);
                }

                // Fitur Filter Stok
                if ($request->has('stok_filter') && $request->stok_filter != '') {
                    if ($request->stok_filter == 'tersedia') {
                        $produks->where('stok', '>', 0);
                    } elseif ($request->stok_filter == 'habis') {
                        $produks->where('stok', '=', 0);
                    }
                }

                // Filter jenis produk
                if ($request->has('jenis_produk') && $request->jenis_produk != '') {
                    $produks->where('jenis_produk', $request->jenis_produk);
                }

                // Ambil data dengan pagination
                $produks = $produks->orderBy('created_at', 'desc')->paginate(10);

                // Tambahkan parameter request ke pagination
                $produks->appends($request->all());

                // Ambil data UMKM untuk dropdown filter
                $umkms = Umkm::all();

                // Ambil jenis produk unik untuk filter
                $jenisProduk = Produk::select('jenis_produk')->distinct()->whereNotNull('jenis_produk')->pluck('jenis_produk');

                return view('pages.produk.index', compact('produks', 'umkms', 'jenisProduk'));
            }

            /**
             * Show the form for creating a new resource.
             */
            public function create()
            {
                // Ambil data UMKM untuk dropdown

                $umkms = Umkm::all();
                return view('pages.produk.create', compact('umkms'));
            }

            /**
             * Store a newly created resource in storage.
             */
            public function store(Request $request)
            {
                $request->validate([
                    'nama_produk'  => 'required|string|max:100',
                    'umkm_id'      => 'required|exists:umkm,umkm_id',
                    'jenis_produk' => 'nullable|string|max:100', // TAMBAHKAN
                    'deskripsi'    => 'nullable|string',
                    'harga'        => 'required|numeric|min:0',
                    'stok'         => 'required|integer|min:0',
                ]);

                try {
                    Produk::create([
                        'nama_produk'  => $request->nama_produk,
                        'umkm_id'      => $request->umkm_id,
                        'jenis_produk' => $request->jenis_produk,
                        'deskripsi'    => $request->deskripsi,
                        'harga'        => $request->harga,
                        'stok'         => $request->stok,
                    ]);

                    return redirect()->route('produk.index')
                        ->with('success', 'Produk berhasil ditambahkan!');

                } catch (\Exception $e) {
                    return redirect()->back()
                        ->with('error', 'Gagal menyimpan produk: ' . $e->getMessage())
                        ->withInput();
                }
            }

            /**
             * Display the specified resource.
             */
            public function show($id)
            {
                $produk = Produk::with('umkm')->findOrFail($id);

                return view('pages.produk.show', compact('produk'));
            }

            /**
             * Show the form for editing the specified resource.
             */
            public function edit($id)
            {
                $produk = Produk::findOrFail($id);
$umkms = Umkm::all();

                return view('pages.produk.edit', compact('produk', 'umkms'));
            }

            /**
             * Update the specified resource in storage.
             */
            public function update(Request $request, $id)
            {
                $request->validate([
                    'nama_produk'  => 'required|string|max:100',
                    'umkm_id'      => 'required|exists:umkm,umkm_id',
                    'jenis_produk' => 'nullable|string|max:100', // TAMBAHKAN
                    'deskripsi'    => 'nullable|string',
                    'harga'        => 'required|numeric|min:0',
                    'stok'         => 'required|integer|min:0',
                ]);

                try {
                    $produk = Produk::findOrFail($id);
                    $produk->update([
                        'nama_produk'  => $request->nama_produk,
                        'umkm_id'      => $request->umkm_id,
                        'jenis_produk' => $request->jenis_produk,
                        'deskripsi'    => $request->deskripsi,
                        'harga'        => $request->harga,
                        'stok'         => $request->stok,
                    ]);

                    return redirect()->route('produk.index')
                        ->with('success', 'Produk berhasil diperbarui!');

                } catch (\Exception $e) {
                    return redirect()->back()
                        ->with('error', 'Gagal memperbarui produk: ' . $e->getMessage())
                        ->withInput();
                }
            }

            /**
             * Remove the specified resource from storage.
             */
            public function destroy($id)
            {
                try {
                    $produk = Produk::findOrFail($id);
                    $produk->delete();

                    return redirect()->route('produk.index')
                        ->with('success', 'Produk berhasil dihapus!');

                } catch (\Exception $e) {
                    return redirect()->back()
                        ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
                }
            }
    }

