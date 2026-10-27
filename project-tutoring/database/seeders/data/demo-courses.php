<?php

/*
 * Data demo kelas & materi untuk DemoContentSeeder.
 * Setiap link YouTube sudah dicek: video publik dan boleh di-embed (per Oktober 2026).
 * Baris kosong ("\n\n") menjadi pemisah paragraf di halaman materi.
 */

$p = fn (string ...$paragraphs) => implode("\n\n", $paragraphs);

return [
    [
        'course' => 'Matematika: Fungsi Kuadrat',
        'deskripsi' => $p(
            'Kenali fungsi kuadrat dari bentuk umumnya sampai penerapannya dalam masalah sehari-hari, seperti lintasan bola dan luas maksimum.',
            'Cocok untuk siswa kelas X. Setiap materi dilengkapi contoh soal yang dibahas langkah demi langkah.'
        ),
        'start_date' => '2026-10-05',
        'end_date' => '2026-12-18',
        'contents' => [
            [
                'title' => 'Bentuk Umum Fungsi Kuadrat',
                'youtube_link' => 'https://www.youtube.com/watch?v=plHH1AWXrVM',
                'content' => $p(
                    'Fungsi kuadrat adalah fungsi yang pangkat tertinggi variabelnya adalah dua. Bentuk umumnya: f(x) = ax² + bx + c, dengan a, b, dan c bilangan real serta a ≠ 0.',
                    'Nilai a menentukan arah parabola. Jika a > 0, parabola terbuka ke atas dan fungsi memiliki nilai minimum. Jika a < 0, parabola terbuka ke bawah dan fungsi memiliki nilai maksimum.',
                    'Nilai c adalah titik potong grafik dengan sumbu y, yaitu titik (0, c), karena f(0) = c.',
                    'Contoh: f(x) = x² − 4x + 3. Di sini a = 1, b = −4, c = 3. Grafiknya terbuka ke atas dan memotong sumbu y di (0, 3). Coba hitung f(1) dan f(3): keduanya bernilai 0. Artinya grafik memotong sumbu x di x = 1 dan x = 3.'
                ),
            ],
            [
                'title' => 'Menggambar Grafik Fungsi Kuadrat',
                'youtube_link' => 'https://www.youtube.com/watch?v=ze_knW-6w2c',
                'content' => $p(
                    'Grafik fungsi kuadrat berbentuk parabola. Untuk menggambarnya dengan rapi, cari empat hal berikut secara berurutan.',
                    '1. Titik potong sumbu x: selesaikan f(x) = 0.
2. Titik potong sumbu y: hitung f(0).
3. Sumbu simetri: x = −b / (2a).
4. Titik puncak: substitusikan nilai sumbu simetri ke f(x).',
                    'Contoh: f(x) = x² − 4x + 3.
Titik potong sumbu x: x² − 4x + 3 = (x − 1)(x − 3) = 0, jadi x = 1 atau x = 3.
Titik potong sumbu y: f(0) = 3, jadi (0, 3).
Sumbu simetri: x = −(−4) / (2 · 1) = 2.
Titik puncak: f(2) = 4 − 8 + 3 = −1, jadi (2, −1).',
                    'Letakkan kelima titik itu pada bidang koordinat, lalu hubungkan dengan kurva mulus yang simetris terhadap garis x = 2.'
                ),
            ],
            [
                'title' => 'Titik Puncak dan Nilai Ekstrem',
                'youtube_link' => null,
                'content' => $p(
                    'Titik puncak (titik balik) adalah titik tertinggi atau terendah parabola. Koordinatnya dapat dihitung langsung dengan rumus:
x = −b / (2a)
y = −D / (4a), dengan D = b² − 4ac',
                    'Nilai y pada titik puncak disebut nilai ekstrem. Jika a > 0 nilai itu adalah nilai minimum; jika a < 0 nilai itu adalah nilai maksimum.',
                    'Contoh: f(x) = −x² + 6x − 5, sehingga a = −1, b = 6, c = −5.
x = −6 / (2 · −1) = 3
D = 6² − 4 · (−1) · (−5) = 36 − 20 = 16
y = −16 / (4 · −1) = 4',
                    'Titik puncaknya (3, 4). Karena a < 0, nilai maksimum fungsi adalah 4. Periksa kembali: f(3) = −9 + 18 − 5 = 4. Hasilnya sama.'
                ),
            ],
            [
                'title' => 'Diskriminan dan Posisi Grafik',
                'youtube_link' => null,
                'content' => $p(
                    'Diskriminan D = b² − 4ac menunjukkan berapa kali grafik memotong sumbu x:
D > 0: memotong sumbu x di dua titik berbeda.
D = 0: menyinggung sumbu x di satu titik.
D < 0: tidak memotong sumbu x sama sekali.',
                    'Gabungan tanda a dan D menghasilkan dua istilah penting:
Definit positif (a > 0 dan D < 0): grafik selalu di atas sumbu x, nilai fungsi selalu positif.
Definit negatif (a < 0 dan D < 0): grafik selalu di bawah sumbu x, nilai fungsi selalu negatif.',
                    'Contoh: f(x) = x² + 2x + 5. D = 2² − 4 · 1 · 5 = 4 − 20 = −16. Karena a > 0 dan D < 0, fungsi ini definit positif: berapa pun nilai x, hasilnya selalu lebih dari nol.'
                ),
            ],
            [
                'title' => 'Penerapan Fungsi Kuadrat',
                'youtube_link' => null,
                'content' => $p(
                    'Banyak masalah nyata membentuk fungsi kuadrat, terutama yang meminta nilai terbesar atau terkecil.',
                    'Contoh 1, lintasan bola. Bola dilempar ke atas dengan tinggi h(t) = −5t² + 20t meter setelah t detik.
Waktu mencapai titik tertinggi: t = −20 / (2 · −5) = 2 detik.
Tinggi maksimum: h(2) = −20 + 40 = 20 meter.
Bola kembali ke tanah saat h(t) = 0: t(−5t + 20) = 0, jadi t = 4 detik.',
                    'Contoh 2, luas maksimum. Pagar sepanjang 40 meter dipakai untuk membuat kebun berbentuk persegi panjang. Jika lebarnya x meter, panjangnya (20 − x) meter, sehingga luas L(x) = x(20 − x) = −x² + 20x.
Luas maksimum terjadi saat x = −20 / (2 · −1) = 10 meter, yaitu L = 10 · 10 = 100 m². Kebun terluas ternyata berbentuk persegi.'
                ),
            ],
        ],
    ],

    [
        'course' => 'Fisika: Gerak Lurus',
        'deskripsi' => $p(
            'Pelajari cara mendeskripsikan gerak benda: jarak dan perpindahan, gerak lurus beraturan, gerak lurus berubah beraturan, sampai gerak jatuh bebas.',
            'Di akhir kelas, kamu akan bisa membaca grafik gerak dan menyelesaikan soal kinematika dasar.'
        ),
        'start_date' => '2026-10-12',
        'end_date' => '2026-12-11',
        'contents' => [
            [
                'title' => 'Jarak, Perpindahan, Kelajuan, dan Kecepatan',
                'youtube_link' => null,
                'content' => $p(
                    'Jarak adalah panjang lintasan yang ditempuh benda. Jarak termasuk besaran skalar: hanya punya nilai.',
                    'Perpindahan adalah perubahan posisi benda dari titik awal ke titik akhir. Perpindahan termasuk besaran vektor: punya nilai dan arah.',
                    'Contoh: Rani berjalan 4 meter ke timur, lalu 3 meter ke utara.
Jarak yang ditempuh: 4 + 3 = 7 meter.
Perpindahannya: √(4² + 3²) = √25 = 5 meter, ke arah timur laut.',
                    'Kelajuan = jarak / waktu, sedangkan kecepatan = perpindahan / waktu. Jika perjalanan Rani memakan waktu 10 detik, kelajuan rata-ratanya 0,7 m/s, tetapi kecepatan rata-ratanya hanya 0,5 m/s.'
                ),
            ],
            [
                'title' => 'Gerak Lurus Beraturan (GLB)',
                'youtube_link' => null,
                'content' => $p(
                    'Gerak lurus beraturan adalah gerak pada lintasan lurus dengan kecepatan tetap. Karena kecepatannya tidak berubah, percepatannya nol.',
                    'Rumus GLB: s = v · t
s = jarak (m), v = kecepatan (m/s), t = waktu (s)',
                    'Pada grafik kecepatan terhadap waktu (v–t), GLB tampak sebagai garis mendatar. Pada grafik jarak terhadap waktu (s–t), GLB tampak sebagai garis lurus miring.',
                    'Contoh: mobil melaju tetap 72 km/jam selama 15 detik. Ubah dulu satuannya: 72 km/jam = 72.000 m / 3.600 s = 20 m/s. Jarak yang ditempuh: s = 20 · 15 = 300 meter.'
                ),
            ],
            [
                'title' => 'Gerak Lurus Berubah Beraturan (GLBB)',
                'youtube_link' => 'https://www.youtube.com/watch?v=ZQi1SnC3xjQ',
                'content' => $p(
                    'Gerak lurus berubah beraturan adalah gerak pada lintasan lurus dengan percepatan tetap. Kecepatannya bertambah (dipercepat) atau berkurang (diperlambat) secara teratur.',
                    'Tiga rumus GLBB:
vt = v0 + a · t
s = v0 · t + ½ · a · t²
vt² = v0² + 2 · a · s
v0 = kecepatan awal, vt = kecepatan akhir, a = percepatan',
                    'Contoh: sepeda motor mula-mula diam, lalu dipercepat 2 m/s² selama 5 detik.
vt = 0 + 2 · 5 = 10 m/s
s = 0 + ½ · 2 · 5² = 25 meter',
                    'Untuk gerak diperlambat, misalnya saat mengerem, percepatan bernilai negatif.'
                ),
            ],
            [
                'title' => 'Gerak Jatuh Bebas',
                'youtube_link' => null,
                'content' => $p(
                    'Gerak jatuh bebas adalah GLBB tanpa kecepatan awal (v0 = 0) dengan percepatan gravitasi g ≈ 9,8 m/s². Dalam soal, g sering dibulatkan menjadi 10 m/s².',
                    'Rumusnya diturunkan dari GLBB:
h = ½ · g · t²
v = g · t
v = √(2 · g · h)',
                    'Contoh: bola dijatuhkan dari ketinggian 20 meter (g = 10 m/s²).
Waktu sampai tanah: t = √(2h / g) = √(40 / 10) = 2 detik.
Kecepatan saat menyentuh tanah: v = 10 · 2 = 20 m/s.',
                    'Jika hambatan udara diabaikan, massa benda tidak memengaruhi gerak jatuh bebas. Bola besi dan bola kertas yang dijatuhkan bersamaan di ruang hampa akan sampai di tanah pada saat yang sama.'
                ),
            ],
            [
                'title' => 'Membaca Grafik Gerak',
                'youtube_link' => null,
                'content' => $p(
                    'Grafik adalah cara cepat memahami gerak. Ada tiga aturan yang perlu diingat:
1. Kemiringan grafik s–t menunjukkan kecepatan.
2. Kemiringan grafik v–t menunjukkan percepatan.
3. Luas daerah di bawah grafik v–t menunjukkan perpindahan.',
                    'Contoh: grafik v–t berupa garis lurus dari 0 m/s pada t = 0 sampai 10 m/s pada t = 5 s.
Percepatan = kemiringan = (10 − 0) / (5 − 0) = 2 m/s².
Perpindahan = luas segitiga = ½ · 5 · 10 = 25 meter.',
                    'Hasil ini sama persis dengan contoh sepeda motor di materi GLBB. Grafik dan rumus hanyalah dua cara berbeda untuk menjawab pertanyaan yang sama.'
                ),
            ],
        ],
    ],

    [
        'course' => 'Biologi: Sel sebagai Unit Kehidupan',
        'deskripsi' => $p(
            'Semua makhluk hidup tersusun atas sel. Kelas ini membahas sejarah penemuan sel, jenis-jenis sel, organel dan fungsinya, serta cara zat keluar-masuk sel.',
            'Disusun untuk siswa kelas XI dengan ringkasan di setiap akhir materi.'
        ),
        'start_date' => '2026-11-02',
        'end_date' => '2027-01-29',
        'contents' => [
            [
                'title' => 'Sejarah Penemuan dan Teori Sel',
                'youtube_link' => null,
                'content' => $p(
                    'Pada tahun 1665, Robert Hooke mengamati irisan gabus dengan mikroskop sederhana dan melihat ruang-ruang kecil yang ia sebut cell (sel). Yang ia lihat sebenarnya dinding sel yang sudah mati.',
                    'Antonie van Leeuwenhoek kemudian menjadi orang pertama yang mengamati sel hidup, misalnya bakteri dan protozoa, dengan mikroskop buatannya sendiri.',
                    'Matthias Schleiden (1838) menyimpulkan bahwa tumbuhan tersusun atas sel, dan Theodor Schwann (1839) menyimpulkan hal yang sama untuk hewan. Rudolf Virchow (1855) melengkapinya dengan pernyataan omnis cellula e cellula: setiap sel berasal dari sel sebelumnya.',
                    'Ringkasan teori sel: sel adalah unit struktural dan fungsional terkecil makhluk hidup, dan sel baru hanya terbentuk dari pembelahan sel yang sudah ada.'
                ),
            ],
            [
                'title' => 'Sel Prokariotik dan Eukariotik',
                'youtube_link' => 'https://www.youtube.com/watch?v=vjSgOwx_5O8',
                'content' => $p(
                    'Berdasarkan ada tidaknya membran inti, sel dibedakan menjadi dua jenis.',
                    'Sel prokariotik tidak memiliki membran inti. Materi genetiknya berada di daerah sitoplasma yang disebut nukleoid, dan sel ini tidak memiliki organel bermembran. Contoh: bakteri dan arkea.',
                    'Sel eukariotik memiliki inti sel yang dibungkus membran, serta organel bermembran seperti mitokondria dan badan Golgi. Contoh: sel hewan, tumbuhan, jamur, dan protista.',
                    'Persamaan keduanya: sama-sama memiliki membran plasma, sitoplasma, ribosom, dan DNA sebagai materi genetik.'
                ),
            ],
            [
                'title' => 'Organel Sel dan Fungsinya',
                'youtube_link' => 'https://www.youtube.com/watch?v=Xxm6xtjsFx0',
                'content' => $p(
                    'Organel adalah "alat" di dalam sel yang masing-masing punya tugas khusus.',
                    'Nukleus: pusat pengendali sel, menyimpan DNA.
Ribosom: tempat sintesis protein.
Retikulum endoplasma kasar: ditempeli ribosom, membantu sintesis dan pengangkutan protein.
Retikulum endoplasma halus: sintesis lipid dan penetralan racun.
Badan Golgi: memodifikasi, mengemas, dan mengirim protein dan lipid.
Mitokondria: tempat respirasi seluler yang menghasilkan energi (ATP).
Lisosom: mencerna zat dan organel yang sudah rusak.
Kloroplas (khusus tumbuhan): tempat fotosintesis.
Vakuola: menyimpan air, cadangan makanan, dan sisa metabolisme.',
                    'Cara mudah mengingatnya: bayangkan sel sebagai pabrik. Nukleus adalah kantor direksi, ribosom adalah mesin produksi, badan Golgi adalah bagian pengemasan, dan mitokondria adalah pembangkit listriknya.'
                ),
            ],
            [
                'title' => 'Transpor Melalui Membran',
                'youtube_link' => null,
                'content' => $p(
                    'Membran plasma bersifat selektif permeabel: hanya zat tertentu yang dapat melewatinya. Strukturnya dijelaskan oleh model mosaik fluida, yaitu lapisan ganda fosfolipid yang disisipi protein.',
                    'Transpor pasif tidak memerlukan energi dan berlangsung mengikuti perbedaan konsentrasi:
Difusi: perpindahan zat dari konsentrasi tinggi ke rendah.
Difusi terfasilitasi: difusi yang dibantu protein transpor.
Osmosis: perpindahan air dari larutan hipotonis ke larutan hipertonis.',
                    'Transpor aktif memerlukan energi (ATP) karena melawan perbedaan konsentrasi. Contohnya pompa natrium-kalium yang mengeluarkan 3 ion Na⁺ dan memasukkan 2 ion K⁺, serta endositosis dan eksositosis untuk partikel besar.',
                    'Contoh osmosis: sel darah merah di dalam larutan hipertonis akan mengerut (krenasi), sedangkan di dalam larutan hipotonis akan membengkak dan dapat pecah (lisis).'
                ),
            ],
            [
                'title' => 'Perbedaan Sel Hewan dan Sel Tumbuhan',
                'youtube_link' => null,
                'content' => $p(
                    'Sel hewan dan sel tumbuhan sama-sama eukariotik, tetapi punya beberapa perbedaan penting.',
                    'Sel tumbuhan:
Memiliki dinding sel dari selulosa, sehingga bentuknya tetap.
Memiliki kloroplas untuk fotosintesis.
Memiliki vakuola sentral yang besar.
Menyimpan cadangan makanan dalam bentuk amilum.',
                    'Sel hewan:
Tidak memiliki dinding sel, sehingga bentuknya bervariasi.
Tidak memiliki kloroplas.
Vakuolanya kecil atau tidak ada.
Memiliki sentriol yang berperan saat pembelahan sel.
Menyimpan cadangan makanan dalam bentuk glikogen.',
                    'Latihan: amati sel bawang merah dan sel epitel pipi di bawah mikroskop, lalu catat perbedaan bentuk dan bagian yang terlihat.'
                ),
            ],
        ],
    ],

    [
        'course' => 'Kimia: Struktur Atom dan Konfigurasi Elektron',
        'deskripsi' => $p(
            'Mengupas isi atom: partikel penyusunnya, perkembangan model atom, cara menuliskan konfigurasi elektron, dan hubungannya dengan letak unsur di sistem periodik.',
            'Fondasi penting sebelum mempelajari ikatan kimia di kelas berikutnya.'
        ),
        'start_date' => '2026-11-09',
        'end_date' => '2027-02-05',
        'contents' => [
            [
                'title' => 'Partikel Penyusun Atom',
                'youtube_link' => null,
                'content' => $p(
                    'Atom tersusun atas tiga partikel dasar:
Proton: bermuatan positif, berada di inti atom.
Neutron: tidak bermuatan, berada di inti atom.
Elektron: bermuatan negatif, bergerak mengelilingi inti. Massanya sekitar 1/1836 massa proton.',
                    'Notasi atom ditulis dengan nomor massa (A) di kiri atas dan nomor atom (Z) di kiri bawah lambang unsur.
Nomor atom (Z) = jumlah proton.
Nomor massa (A) = jumlah proton + neutron.',
                    'Contoh: natrium dengan A = 23 dan Z = 11 memiliki 11 proton, 11 elektron (karena atomnya netral), dan 23 − 11 = 12 neutron.',
                    'Atom-atom unsur yang sama dengan nomor massa berbeda disebut isotop, misalnya karbon-12 dan karbon-14.'
                ),
            ],
            [
                'title' => 'Perkembangan Model Atom',
                'youtube_link' => null,
                'content' => $p(
                    'Gambaran tentang atom terus diperbaiki seiring ditemukannya bukti baru.',
                    'Dalton: atom adalah bola pejal yang tidak dapat dibagi.
Thomson: setelah menemukan elektron, ia menggambarkan atom seperti roti kismis, yaitu bola positif dengan elektron tersebar di dalamnya.
Rutherford: percobaan hamburan sinar alfa pada lempeng emas menunjukkan bahwa atom memiliki inti kecil bermuatan positif, dan sebagian besar atom adalah ruang kosong.
Bohr: elektron bergerak pada lintasan dengan tingkat energi tertentu. Model ini berhasil menjelaskan spektrum atom hidrogen.
Mekanika kuantum: posisi elektron tidak dapat dipastikan, sehingga dijelaskan dengan orbital, yaitu daerah dengan peluang terbesar menemukan elektron.',
                    'Model mekanika kuantum adalah model yang dipakai sampai sekarang dan menjadi dasar penulisan konfigurasi elektron.'
                ),
            ],
            [
                'title' => 'Konfigurasi Elektron',
                'youtube_link' => 'https://www.youtube.com/watch?v=c6aQPwRnUw0',
                'content' => $p(
                    'Konfigurasi elektron adalah susunan elektron di dalam atom.',
                    'Berdasarkan kulit (model Bohr), kapasitas maksimum setiap kulit adalah 2n²: K = 2, L = 8, M = 18, N = 32. Kulit terluar paling banyak berisi 8 elektron.
Na (11): 2 8 1
Cl (17): 2 8 7
Ca (20): 2 8 8 2',
                    'Berdasarkan subkulit (prinsip Aufbau), elektron mengisi subkulit dari energi terendah: 1s 2s 2p 3s 3p 4s 3d 4p 5s 4d 5p …
Subkulit s maksimal 2 elektron, p maksimal 6, d maksimal 10.
Contoh Fe (26): 1s² 2s² 2p⁶ 3s² 3p⁶ 4s² 3d⁶',
                    'Elektron pada kulit terluar disebut elektron valensi. Elektron valensi inilah yang menentukan sifat kimia suatu unsur.'
                ),
            ],
            [
                'title' => 'Diagram Orbital dan Aturan Pengisian',
                'youtube_link' => 'https://www.youtube.com/watch?v=1eCjOIwqW3Y',
                'content' => $p(
                    'Diagram orbital menggambarkan elektron di setiap orbital. Ada tiga aturan pengisian:
Aufbau: elektron mengisi orbital dari energi terendah.
Pauli: satu orbital berisi paling banyak 2 elektron dengan arah spin berlawanan.
Hund: orbital dengan energi setara diisi satu per satu dulu dengan spin searah, baru kemudian berpasangan.',
                    'Contoh nitrogen (7): 1s² 2s² 2p³. Ketiga elektron 2p masing-masing menempati satu orbital, sehingga ada tiga elektron tidak berpasangan.
Oksigen (8): 1s² 2s² 2p⁴. Satu orbital 2p berisi pasangan elektron, dua orbital lainnya berisi satu elektron.',
                    'Ada pengecualian karena subkulit d yang setengah penuh atau penuh lebih stabil:
Cr (24): [Ar] 4s¹ 3d⁵, bukan 4s² 3d⁴
Cu (29): [Ar] 4s¹ 3d¹⁰, bukan 4s² 3d⁹'
                ),
            ],
            [
                'title' => 'Letak Unsur dalam Sistem Periodik',
                'youtube_link' => null,
                'content' => $p(
                    'Konfigurasi elektron dapat dipakai untuk menentukan letak unsur di sistem periodik tanpa menghafal tabel.',
                    'Periode = nilai n (nomor kulit) terbesar.
Golongan A: elektron valensi berada di subkulit s atau s dan p. Jumlah elektron valensinya menunjukkan nomor golongan.
Golongan B: elektron terakhir mengisi subkulit d.',
                    'Contoh:
Cl (17): [Ne] 3s² 3p⁵ → n terbesar 3, elektron valensi 7 → periode 3, golongan VIIA.
Ca (20): [Ar] 4s² → periode 4, golongan IIA.
Fe (26): [Ar] 4s² 3d⁶ → periode 4, golongan VIIIB.',
                    'Unsur dalam satu golongan memiliki elektron valensi yang sama, sehingga sifat kimianya mirip. Inilah alasan natrium dan kalium sama-sama sangat reaktif terhadap air.'
                ),
            ],
        ],
    ],

    [
        'course' => 'Bahasa Indonesia: Menulis Teks Eksposisi',
        'deskripsi' => $p(
            'Belajar menyampaikan pendapat secara tertulis dengan argumen yang kuat. Mulai dari mengenali teks eksposisi, memahami strukturnya, sampai menyunting tulisan sendiri.',
            'Setiap materi ditutup dengan latihan menulis singkat.'
        ),
        'start_date' => '2026-10-19',
        'end_date' => '2026-12-04',
        'contents' => [
            [
                'title' => 'Mengenal Teks Eksposisi',
                'youtube_link' => 'https://www.youtube.com/watch?v=ADkguH0A5LM',
                'content' => $p(
                    'Teks eksposisi adalah teks yang berisi pendapat penulis tentang suatu isu, didukung argumen dan fakta, dengan tujuan meyakinkan pembaca bahwa pendapat itu benar.',
                    'Ciri-cirinya:
Berisi pendapat yang didukung fakta.
Disusun secara logis dan argumentatif.
Ditutup dengan penegasan ulang pendapat penulis.',
                    'Teks eksposisi sering tertukar dengan teks persuasi. Bedanya, eksposisi berhenti pada meyakinkan pembaca tentang suatu pendapat, sedangkan persuasi juga mengajak pembaca untuk melakukan sesuatu.',
                    'Contoh topik eksposisi: "Literasi digital perlu diajarkan sejak SMP" atau "Sekolah perlu menyediakan lebih banyak ruang terbuka hijau".'
                ),
            ],
            [
                'title' => 'Struktur Teks Eksposisi',
                'youtube_link' => null,
                'content' => $p(
                    'Teks eksposisi terdiri atas tiga bagian.',
                    'Tesis: pernyataan pendapat penulis, biasanya di paragraf pertama.
Argumentasi: alasan-alasan yang mendukung tesis, masing-masing disertai bukti berupa data, contoh, atau pendapat ahli.
Penegasan ulang: simpulan yang menegaskan kembali tesis dengan kalimat berbeda.',
                    'Contoh singkat.
Tesis: Siswa perlu dibiasakan membaca minimal 15 menit setiap hari.
Argumen: Kebiasaan membaca memperluas kosakata, melatih konsentrasi, dan membantu siswa memahami soal cerita di semua mata pelajaran.
Penegasan ulang: Lima belas menit sehari adalah investasi kecil dengan manfaat besar bagi prestasi siswa.',
                    'Latihan: pilih satu isu di sekolahmu, lalu tulis satu kalimat tesis dan tiga alasan pendukungnya.'
                ),
            ],
            [
                'title' => 'Kaidah Kebahasaan Teks Eksposisi',
                'youtube_link' => 'https://www.youtube.com/watch?v=5K9Z5YO2u3k',
                'content' => $p(
                    'Teks eksposisi memiliki ciri kebahasaan yang membuatnya terdengar objektif dan meyakinkan.',
                    'Istilah teknis sesuai topik, misalnya "literasi", "infrastruktur", atau "emisi".
Konjungsi kausalitas: karena, sebab, oleh karena itu, sehingga, akibatnya.
Konjungsi penjelas dan urutan: pertama, selanjutnya, selain itu, bahkan.
Kata kerja mental: berpendapat, menganggap, meyakini, memprediksi.
Kata rujukan: berdasarkan, merujuk pada, menurut data.',
                    'Contoh kalimat yang menerapkan kaidah tersebut: "Berdasarkan data perpustakaan sekolah, jumlah peminjam buku naik 30 persen. Oleh karena itu, program membaca pagi layak dilanjutkan."',
                    'Latihan: tulis ulang argumenmu dari materi sebelumnya dengan memakai minimal dua konjungsi kausalitas.'
                ),
            ],
            [
                'title' => 'Menyusun Argumen yang Kuat',
                'youtube_link' => null,
                'content' => $p(
                    'Argumen yang kuat memiliki tiga bagian: klaim (apa yang kamu yakini), bukti (apa yang mendukungnya), dan penjelasan (mengapa bukti itu mendukung klaim).',
                    'Jenis bukti yang dapat dipakai:
Data atau statistik, lengkap dengan sumbernya.
Contoh nyata atau pengalaman yang dapat diperiksa.
Pendapat ahli di bidang yang relevan.',
                    'Hindari kesalahan berpikir berikut:
Generalisasi berlebihan: "Semua siswa malas membaca."
Menyerang pribadi, bukan pendapatnya.
Mengutip sumber yang tidak jelas: "Kata orang di internet…"',
                    'Latihan: pilih argumen terlemahmu, lalu perkuat dengan satu data dan satu contoh nyata.'
                ),
            ],
            [
                'title' => 'Menyunting Teks Eksposisi',
                'youtube_link' => null,
                'content' => $p(
                    'Menyunting adalah langkah terakhir sebelum tulisan dibaca orang lain. Gunakan daftar periksa berikut.',
                    'Isi:
Apakah tesis dinyatakan dengan jelas di awal?
Apakah setiap argumen didukung bukti?
Apakah penegasan ulang sejalan dengan tesis?',
                    'Bahasa:
Ejaan dan tanda baca sesuai EYD Edisi V.
Kalimat efektif: tidak bertele-tele dan tidak ambigu.
Penggunaan huruf kapital dan kata baku sudah tepat.',
                    'Tips: baca tulisanmu dengan suara keras. Kalimat yang membuatmu tersendat biasanya perlu diperbaiki. Setelah itu, minta seorang teman membacanya dan menyebutkan satu bagian yang paling meyakinkan serta satu bagian yang paling lemah.'
                ),
            ],
        ],
    ],

    [
        'course' => 'Pemrograman Web Dasar',
        'deskripsi' => $p(
            'Membangun halaman web pertamamu dengan HTML, CSS, dan JavaScript, sekaligus memastikan halaman itu bisa dipakai semua orang, termasuk pengguna pembaca layar.',
            'Tidak perlu pengalaman pemrograman sebelumnya. Cukup siapkan browser dan editor teks.'
        ),
        'start_date' => '2026-11-16',
        'end_date' => '2027-02-12',
        'contents' => [
            [
                'title' => 'Cara Kerja Sebuah Website',
                'youtube_link' => null,
                'content' => $p(
                    'Saat kamu mengetik alamat web di browser, beberapa hal terjadi dalam hitungan detik.',
                    '1. Browser menanyakan alamat IP dari nama domain itu ke DNS.
2. Browser mengirim permintaan (HTTP request) ke server di alamat tersebut.
3. Server mengirim balik respons berisi HTML, CSS, JavaScript, dan gambar.
4. Browser menyusun semua file itu menjadi halaman yang kamu lihat.',
                    'HTTPS adalah versi HTTP yang terenkripsi, sehingga data seperti password tidak bisa dibaca orang lain di jaringan yang sama.',
                    'Tiga bahasa utama halaman web punya peran berbeda:
HTML menentukan struktur dan isi.
CSS mengatur tampilan.
JavaScript menambahkan perilaku dan interaksi.'
                ),
            ],
            [
                'title' => 'Struktur Dokumen HTML',
                'youtube_link' => 'https://www.youtube.com/watch?v=N2-S9elYMI0',
                'content' => $p(
                    'Setiap halaman HTML dimulai dengan kerangka yang sama:
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Judul Halaman</title>
</head>
<body>
… isi halaman …
</body>
</html>',
                    'Atribut lang="id" memberi tahu browser dan pembaca layar bahwa halaman berbahasa Indonesia, sehingga pengucapannya benar.',
                    'Gunakan elemen semantik sesuai maknanya: header, nav, main, article, dan footer. Judul ditulis berurutan dari h1 sampai h6 tanpa melompat tingkat.',
                    'Setiap gambar wajib memiliki atribut alt yang menjelaskan isinya. Jika gambar hanya hiasan, isi alt dengan teks kosong (alt="").'
                ),
            ],
            [
                'title' => 'Menata Tampilan dengan CSS',
                'youtube_link' => null,
                'content' => $p(
                    'Aturan CSS terdiri atas selektor, properti, dan nilai. Contoh:
h1 { color: navy; font-size: 2rem; }',
                    'Simpan CSS di file terpisah dan hubungkan dari bagian head:
<link rel="stylesheet" href="style.css">',
                    'Setiap elemen diperlakukan sebagai kotak (box model) yang terdiri atas content, padding, border, dan margin. Memahami box model membuat pengaturan jarak menjadi jauh lebih mudah.',
                    'Untuk menyusun elemen berdampingan, gunakan flexbox:
.menu { display: flex; gap: 1rem; }',
                    'Agar halaman nyaman dibuka di HP, gunakan media query:
@media (min-width: 768px) { .kolom { width: 50%; } }'
                ),
            ],
            [
                'title' => 'Formulir yang Mudah Diakses',
                'youtube_link' => null,
                'content' => $p(
                    'Formulir adalah bagian yang paling sering menyulitkan pengguna. Beberapa kebiasaan sederhana membuatnya bisa dipakai semua orang.',
                    'Hubungkan setiap input dengan label:
<label for="email">Email</label>
<input id="email" type="email" autocomplete="email">',
                    'Jangan hanya mengandalkan placeholder sebagai label, karena teksnya menghilang saat pengguna mulai mengetik.',
                    'Pilih type input yang sesuai (email, tel, number, date) dan isi atribut autocomplete, supaya browser dapat membantu mengisinya.',
                    'Tulis pesan error yang menjelaskan cara memperbaikinya, misalnya "Password minimal 8 karakter", bukan sekadar "Input salah". Terakhir, coba isi seluruh formulir hanya dengan tombol Tab dan Enter, tanpa mouse.'
                ),
            ],
            [
                'title' => 'Interaksi dengan JavaScript',
                'youtube_link' => null,
                'content' => $p(
                    'JavaScript membuat halaman merespons tindakan pengguna. Muat file JavaScript di bagian head dengan atribut defer, agar dijalankan setelah HTML selesai dibaca:
<script src="app.js" defer></script>',
                    'Langkah dasarnya ada tiga: pilih elemen, dengarkan event, lalu ubah sesuatu. Contoh tombol buka-tutup menu:
const tombol = document.querySelector("#tombol-menu");
const menu = document.querySelector("#menu");
tombol.addEventListener("click", () => {
const terbuka = tombol.getAttribute("aria-expanded") === "true";
tombol.setAttribute("aria-expanded", String(!terbuka));
menu.hidden = terbuka;
});',
                    'Perhatikan atribut aria-expanded. Atribut ini memberi tahu pengguna pembaca layar apakah menu sedang terbuka atau tertutup. Interaksi yang baik bukan hanya terlihat berfungsi, tetapi juga dapat dipahami oleh semua pengguna.'
                ),
            ],
        ],
    ],
];
