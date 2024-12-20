<?php

namespace Database\Seeders;

use App\Models\EventType as ModelsEventType;
use Illuminate\Database\Seeder;

class EventTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $eventTypes = [
            "Dry Off" => ["goat_count"],
            "Perawatan" => ["diagnosis", "treated_by"],
            "Vaksinasi" => ["vaccine"],
            "Perkawinan" => ["male_tag", "female_tag"],
            "Pemberatan" => ["target_weight", "gain_weight"],
            "Pemerahan" => ["result"],
            "Melahirkan" => ["kids_no", "father_tag", "mother_tag"],
            "Penyembelihan" => ["goat_count"],
            "Indentifikasi(Tagging)" => ["tag_no"],
            "Other" => ["event_name", "event_desc"]
        ];

        foreach($eventTypes as $type => $field) {
            ModelsEventType::create([
                'name' => $type,
                'slug' => \Illuminate\Support\Str::slug($type),
                'field' => $field
            ]);
        }
    }
}
