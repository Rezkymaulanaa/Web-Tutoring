<?php

namespace App\Http\Requests;

use App\Models\Content;
use App\Models\Course;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContentRequest extends FormRequest
{
    /**
     * Materi hanya boleh ditambahkan atau dipindahkan ke course yang boleh dikelola user.
     * Jika course tidak ada, biarkan rule `exists` yang menolak.
     */
    public function authorize(): bool
    {
        $course = Course::find($this->input('course_id'));

        return ! $course || $this->user()->can('update', $course);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'youtube_link' => ['nullable', 'url', 'regex:'.Content::YOUTUBE_PATTERN],
            'course_id' => ['required', 'exists:courses,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'youtube_link.regex' => 'Link harus berupa link video YouTube.',
        ];
    }
}
