<?php

namespace App\Http\Controllers;

use App\Models\BirthdayMessage;
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
        $timezone = 'Asia/Jakarta';
        $setting = BirthdaySetting::query()->firstOrFail();

        $now = Carbon::now($timezone);
        $unlockAt = Carbon::parse($setting->getRawOriginal('unlock_at'), $timezone);
        $birthDate = Carbon::parse($setting->getRawOriginal('birth_date'), $timezone);
        $previewUnlock = filter_var(env('BIRTHDAY_PREVIEW_UNLOCK', false), FILTER_VALIDATE_BOOLEAN);
        $ageReferenceDate = $previewUnlock && $now->lt($unlockAt) ? $unlockAt : $now;
        $age = (int) $birthDate->diffInYears($ageReferenceDate);

        $data = [
            'setting' => $setting,
            'unlockAt' => $unlockAt,
            'unlockAtIso' => $unlockAt->toIso8601String(),
            'now' => $now,
        ];

        if (! $previewUnlock && $now->lt($unlockAt)) {
            return view('birthday.locked', compact('data'));
        }

        $messages = BirthdayMessage::query()
            ->orderBy('sort_order')
            ->get();

        $memories = Memory::query()
            ->orderBy('sort_order')
            ->get();

        $reasons = Reason::query()
            ->orderBy('sort_order')
            ->get();

        $wishes = Wish::query()
            ->orderBy('sort_order')
            ->get();

        $data = array_merge($data, compact(
            'age',
            'messages',
            'memories',
            'reasons',
            'wishes'
        ));

        return view('birthday.index', compact('data'));
    }
}
