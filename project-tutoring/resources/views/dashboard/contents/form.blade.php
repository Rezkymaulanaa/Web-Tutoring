{{-- Form bersama untuk tambah & edit materi --}}
@php($content ??= null)

<p class="text-sm text-ink-600">Isian bertanda <span class="text-danger">*</span> wajib diisi.</p>

@if ($courses->isEmpty())
    <x-empty-state title="Anda belum punya course" icon="heroicon-o-book-open">
        Materi harus berada di dalam course.
        <a href="{{ route('dashboard.courses.create') }}" class="font-medium text-ink-900 hover:underline">Buat course dulu</a>.
    </x-empty-state>
@endif

<div class="space-y-5">
    <x-form.input name="title" label="Judul materi" :value="$content?->title" required />
    <x-form.select name="course_id" label="Course" :options="$courses->pluck('course', 'id')" :value="$content?->course_id"
                   placeholder="Pilih course" required />
    <x-form.textarea name="content" label="Isi materi" :value="$content?->content" required rows="12"
                     hint="Baris baru akan tetap ditampilkan seperti yang Anda tulis." />
    <x-form.input name="youtube_link" type="url" label="Link video YouTube" :value="$content?->youtube_link"
                  inputmode="url" placeholder="https://youtu.be/…"
                  hint="Contoh: https://youtu.be/AbCdEf12345 atau https://www.youtube.com/watch?v=AbCdEf12345" />
</div>
