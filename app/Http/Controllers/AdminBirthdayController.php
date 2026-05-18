<?php

namespace App\Http\Controllers;

use App\Models\BirthdayMessage;
use App\Models\BirthdayPhoto;
use App\Models\BirthdaySetting;
use App\Models\Memory;
use App\Models\Reason;
use App\Models\Wish;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;

class AdminBirthdayController extends Controller
{
    public function edit(): View
    {
        $timezone = 'Asia/Jakarta';
        $setting = BirthdaySetting::query()->first();
        $unlockAt = $setting
            ? Carbon::parse($setting->getRawOriginal('unlock_at'), $timezone)
            : Carbon::parse('2026-05-23 00:00:00', $timezone);

        return view('birthday.admin', [
            'setting' => $setting,
            'unlockDate' => $unlockAt->format('Y-m-d'),
            'unlockTime' => $unlockAt->format('H:i'),
            'messages' => BirthdayMessage::query()->orderBy('sort_order')->orderBy('id')->get(),
            'photos' => BirthdayPhoto::query()->orderBy('sort_order')->orderBy('id')->get(),
            'memories' => Memory::query()->orderBy('sort_order')->orderBy('id')->get(),
            'reasons' => Reason::query()->orderBy('sort_order')->orderBy('id')->get(),
            'wishes' => Wish::query()->orderBy('sort_order')->orderBy('id')->get(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'girlfriend_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date'],
            'unlock_date' => ['required', 'date'],
            'unlock_time' => ['required', 'date_format:H:i'],
            'locked_title' => ['required', 'string', 'max:255'],
            'locked_subtitle' => ['required', 'string', 'max:255'],
            'locked_message' => ['required', 'string'],
            'hero_date_label' => ['required', 'string', 'max:255'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_subtitle' => ['required', 'string', 'max:255'],
            'age_badge_text' => ['required', 'string', 'max:255'],
            'hero_button_text' => ['required', 'string', 'max:255'],
            'messages_section_kicker' => ['required', 'string', 'max:255'],
            'messages_section_title' => ['required', 'string', 'max:255'],
            'photo_section_kicker' => ['required', 'string', 'max:255'],
            'photo_section_title' => ['required', 'string', 'max:255'],
            'photo_letter_button_text' => ['required', 'string', 'max:255'],
            'photo_letter_open_title' => ['required', 'string', 'max:255'],
            'memories_section_kicker' => ['required', 'string', 'max:255'],
            'memories_section_title' => ['required', 'string', 'max:255'],
            'reasons_section_kicker' => ['required', 'string', 'max:255'],
            'reasons_section_title' => ['required', 'string', 'max:255'],
            'wishes_section_kicker' => ['required', 'string', 'max:255'],
            'wishes_section_title' => ['required', 'string', 'max:255'],
            'closing_message' => ['required', 'string'],
            'music_url' => ['nullable', 'string', 'max:2048'],
            'music_volume' => ['nullable', 'numeric', 'min:0', 'max:1'],
        ]);

        $timezone = 'Asia/Jakarta';
        $unlockAt = Carbon::createFromFormat(
            'Y-m-d H:i',
            $validated['unlock_date'].' '.$validated['unlock_time'],
            $timezone
        );

        $setting = BirthdaySetting::query()->first() ?? new BirthdaySetting([
            'birth_date' => '2004-05-23',
        ]);

        $setting->fill([
            'girlfriend_name' => $validated['girlfriend_name'],
            'birth_date' => $validated['birth_date'],
            'unlock_at' => $unlockAt->format('Y-m-d H:i:s'),
            'is_timer_active' => $request->boolean('is_timer_active'),
            'is_preview_enabled' => $request->boolean('is_preview_enabled'),
            'locked_title' => $validated['locked_title'],
            'locked_subtitle' => $validated['locked_subtitle'],
            'locked_message' => $validated['locked_message'],
            'hero_date_label' => $validated['hero_date_label'],
            'hero_title' => $validated['hero_title'],
            'hero_subtitle' => $validated['hero_subtitle'],
            'age_badge_text' => $validated['age_badge_text'],
            'hero_button_text' => $validated['hero_button_text'],
            'messages_section_kicker' => $validated['messages_section_kicker'],
            'messages_section_title' => $validated['messages_section_title'],
            'photo_section_kicker' => $validated['photo_section_kicker'],
            'photo_section_title' => $validated['photo_section_title'],
            'photo_letter_button_text' => $validated['photo_letter_button_text'],
            'photo_letter_open_title' => $validated['photo_letter_open_title'],
            'memories_section_kicker' => $validated['memories_section_kicker'],
            'memories_section_title' => $validated['memories_section_title'],
            'reasons_section_kicker' => $validated['reasons_section_kicker'],
            'reasons_section_title' => $validated['reasons_section_title'],
            'wishes_section_kicker' => $validated['wishes_section_kicker'],
            'wishes_section_title' => $validated['wishes_section_title'],
            'closing_message' => $validated['closing_message'],
            'music_enabled' => $request->boolean('music_enabled'),
            'music_url' => $validated['music_url'] ?? null,
            'music_volume' => $validated['music_volume'] ?? 0.5,
        ]);

        if (! $setting->birth_date) {
            $setting->birth_date = '2004-05-23';
        }

        $setting->save();

        return redirect()
            ->route('birthday.admin.edit')
            ->with('success', 'Pengaturan ulang tahun berhasil disimpan.');
    }

    public function storeMessage(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        BirthdayMessage::query()->create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'sort_order' => $validated['sort_order'] ?? $this->nextSortOrder(BirthdayMessage::class),
        ]);

        return $this->backWithSaved('Birthday message berhasil ditambahkan.');
    }

    public function updateMessage(Request $request, BirthdayMessage $message): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $message->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return $this->backWithSaved('Birthday message berhasil diperbarui.');
    }

    public function destroyMessage(BirthdayMessage $message): RedirectResponse
    {
        $message->delete();

        return $this->backWithSaved('Birthday message berhasil dihapus.');
    }

    public function storeMemory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        Memory::query()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'sort_order' => $validated['sort_order'] ?? $this->nextSortOrder(Memory::class),
        ]);

        return $this->backWithSaved('Memory berhasil ditambahkan.');
    }

    public function updateMemory(Request $request, Memory $memory): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $memory->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return $this->backWithSaved('Memory berhasil diperbarui.');
    }

    public function destroyMemory(Memory $memory): RedirectResponse
    {
        $memory->delete();

        return $this->backWithSaved('Memory berhasil dihapus.');
    }

    public function storeReason(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        Reason::query()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'icon' => ($validated['icon'] ?? null) ?: 'heart',
            'sort_order' => $validated['sort_order'] ?? $this->nextSortOrder(Reason::class),
        ]);

        return $this->backWithSaved('Alasan berhasil ditambahkan.');
    }

    public function updateReason(Request $request, Reason $reason): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $reason->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'icon' => ($validated['icon'] ?? null) ?: 'heart',
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return $this->backWithSaved('Alasan berhasil diperbarui.');
    }

    public function destroyReason(Reason $reason): RedirectResponse
    {
        $reason->delete();

        return $this->backWithSaved('Alasan berhasil dihapus.');
    }

    public function storeWish(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        Wish::query()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'sort_order' => $validated['sort_order'] ?? $this->nextSortOrder(Wish::class),
        ]);

        return $this->backWithSaved('Wish berhasil ditambahkan.');
    }

    public function updateWish(Request $request, Wish $wish): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $wish->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return $this->backWithSaved('Wish berhasil diperbarui.');
    }

    public function destroyWish(Wish $wish): RedirectResponse
    {
        $wish->delete();

        return $this->backWithSaved('Wish berhasil dihapus.');
    }

    public function storePhoto(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'caption' => ['nullable', 'string'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        BirthdayPhoto::query()->create([
            'title' => $validated['title'],
            'caption' => $validated['caption'] ?? null,
            'image_path' => $this->storePhotoImage($request->file('image')),
            'sort_order' => $validated['sort_order'] ?? $this->nextSortOrder(BirthdayPhoto::class),
        ]);

        return $this->backWithSaved('Foto berhasil ditambahkan.');
    }

    public function updatePhoto(Request $request, BirthdayPhoto $photo): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'caption' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $data = [
            'title' => $validated['title'],
            'caption' => $validated['caption'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        if ($request->hasFile('image')) {
            $this->deletePhotoFile($photo->image_path);
            $data['image_path'] = $this->storePhotoImage($request->file('image'));
        }

        $photo->update($data);

        return $this->backWithSaved('Foto berhasil diperbarui.');
    }

    public function destroyPhoto(BirthdayPhoto $photo): RedirectResponse
    {
        $this->deletePhotoFile($photo->image_path);
        $photo->delete();

        return $this->backWithSaved('Foto berhasil dihapus.');
    }

    private function nextSortOrder(string $modelClass): int
    {
        return ((int) $modelClass::query()->max('sort_order')) + 1;
    }

    private function storePhotoImage(UploadedFile $file): string
    {
        $directory = public_path('photos');

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $filename = now()->format('YmdHis').'-'.uniqid('nayla-', true).'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return '/photos/'.$filename;
    }

    private function deletePhotoFile(?string $imagePath): void
    {
        if (! $imagePath) {
            return;
        }

        $normalizedPath = ltrim($imagePath, '/');

        if (! str_starts_with($normalizedPath, 'photos/')) {
            return;
        }

        $absolutePath = public_path($normalizedPath);

        if (is_file($absolutePath)) {
            unlink($absolutePath);
        }
    }

    private function backWithSaved(string $message): RedirectResponse
    {
        return redirect()
            ->route('birthday.admin.edit')
            ->with('success', $message);
    }
}
