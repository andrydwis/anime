<?php

use App\Models\Region;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('regions')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->timestamps();
        });

        // Seeder from api
        $regions = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')->json();
        foreach ($regions as $region) {
            $province = new Region;
            $province->id = $region['id'];
            $province->name = $region['name'];
            $province->slug = Str::slug($region['name']);
            $province->save();
        
            $cities = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/regencies/'.$region['id'].'.json')->json();
            // Fix: Change loop variable to $cityData
            foreach ($cities as $cityData) {
                $city = new Region;
                $city->id = $cityData['id'];
                $city->parent_id = $cityData['province_id'];
                $city->name = $cityData['name'];
                $city->slug = Str::slug($cityData['name']);
                $city->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
