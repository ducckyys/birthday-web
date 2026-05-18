<?php

namespace App\Http\Controllers;

use App\Models\BirthdayMessage;
use App\Models\BirthdayPhoto;
use App\Models\BirthdaySetting;
use App\Models\Memory;
use App\Models\Reason;
use App\Models\Wish;
use Carbon\Carbon;
use Illuminate\View\View;

class BirthdayController extends Controller
{
    public function index(): View
    {
        $data = $this->getBirthdayData();
        $setting = $data['setting'];
        $timerIsActive = $setting->is_timer_active ?? true;
        $previewIsEnabled = $setting->is_preview_enabled ?? false;

        if (! $previewIsEnabled && $timerIsActive && $data['now']->lt($data['unlockAt'])) {
            return view('birthday.locked', compact('data'));
        }

        return view('birthday.index', compact('data'));
    }

    public function preview(): View
    {
        $data = $this->getBirthdayData();

        return view('birthday.index', compact('data'));
    }

    private function getBirthdayData(): array
    {
        $timezone = 'Asia/Jakarta';
        $setting = BirthdaySetting::query()->firstOrFail();

        $now = Carbon::now($timezone);
        $unlockAt = Carbon::parse($setting->getRawOriginal('unlock_at'), $timezone);
        $birthDate = Carbon::parse($setting->getRawOriginal('birth_date'), $timezone);
        $ageReferenceDate = $now->lt($unlockAt) ? $unlockAt : $now;
        $age = (int) $birthDate->diffInYears($ageReferenceDate);

        $messages = BirthdayMessage::query()
            ->orderBy('sort_order')
            ->get();

        $memories = Memory::query()
            ->orderBy('sort_order')
            ->get();

        $photos = BirthdayPhoto::query()
            ->orderBy('sort_order')
            ->get();

        $reasons = Reason::query()
            ->orderBy('sort_order')
            ->get();

        $wishes = Wish::query()
            ->orderBy('sort_order')
            ->get();

        return [
            'setting' => $setting,
            'unlockAt' => $unlockAt,
            'unlockAtIso' => $unlockAt->toIso8601String(),
            'unlockAtJakarta' => $unlockAt->format('Y-m-d H:i:s'),
            'now' => $now,
            'age' => $age,
            'messages' => $messages,
            'photos' => $photos,
            'memories' => $memories,
            'reasons' => $reasons,
            'wishes' => $wishes,
        ];
    }
}
