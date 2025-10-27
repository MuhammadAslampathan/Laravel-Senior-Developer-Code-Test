<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Translation;
use App\Models\Language;
use App\Models\Tag;
use Illuminate\Support\Str;

class GenerateTranslations extends Command
{
    protected $signature = 'translations:generate {count=100000}';
    protected $description = 'Generate large translation dataset for performance testing';

    public function handle()
    {
        $count = (int)$this->argument('count');
        $this->info("Generating {$count} translations...");

        $languages = Language::pluck('id')->toArray();
        if (empty($languages)) {
            $this->warn('No languages found. Please add at least one.');
            return;
        }

        $tags = Tag::pluck('id')->toArray();

        $batchSize = 1000;
        $records = [];

        for ($i = 1; $i <= $count; $i++) {
            $records[] = [
                'key' => 'key_' . Str::random(10) . "_$i",
                'value' => 'Translation value ' . Str::random(20),
                'language_id' => $languages[array_rand($languages)],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($records) >= $batchSize) {
                Translation::insert($records);
                $records = [];
                $this->info("Inserted $i records...");
            }
        }

        if (!empty($records)) {
            Translation::insert($records);
        }

        $this->info("✅ Done generating $count translations!");
    }
}
