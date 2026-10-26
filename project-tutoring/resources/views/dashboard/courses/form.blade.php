{{-- Form bersama untuk tambah & edit course --}}
@php($course ??= null)

<p class="text-sm text-slate-600">Isian bertanda <span class="text-red-700">*</span> wajib diisi.</p>

<div class="grid gap-5 sm:grid-cols-2">
    <x-form.input name="course" label="Nama course" :value="$course?->course" required class="sm:col-span-2" />
    <x-form.textarea name="deskripsi" label="Deskripsi" :value="$course?->deskripsi" required rows="5" class="sm:col-span-2"
                     hint="Jelaskan singkat apa yang akan dipelajari siswa." />
    <x-form.input name="start_date" type="date" label="Tanggal mulai" :value="$course?->start_date?->format('Y-m-d')" required />
    <x-form.input name="end_date" type="date" label="Tanggal selesai" :value="$course?->end_date?->format('Y-m-d')" required
                  hint="Harus setelah tanggal mulai." />
</div>
