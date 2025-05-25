<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Crud;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeadlineReminderMail;

class CheckLaporanDeadline extends Command
{
    protected $signature = 'laporan:check-deadline';
    protected $description = 'Kirim notifikasi email jika laporan melewati deadline dan belum selesai';

    public function handle()
    {
        $today = now()->toDateString();

        $laporans = Crud::with('petugas')
            ->where('status', 'pending')
            ->where('deadline', '<', $today)
            ->where('notified', false)
            ->get();

        foreach ($laporans as $laporan) {
            if ($laporan->petugas && $laporan->petugas->email) {
                Mail::to($laporan->petugas->email)
                    ->send(new DeadlineReminderMail($laporan));

                $laporan->notified = true;
                $laporan->save();

                $this->info("Email terkirim ke {$laporan->petugas->email}");
            if ($laporans->isEmpty()) {
                $this->info("Tidak ada laporan yang melewati deadline.");
            }

            }
        }

        return Command::SUCCESS;
    }
}


