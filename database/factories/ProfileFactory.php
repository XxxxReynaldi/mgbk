<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'id_user' => $this->faker->randomElement([4, 5, 6, 7, 8, 9, 10, 11, 12, 13]),
            'nama_lengkap' => $this->faker->name,
            'foto_profil' => '',
            'alamat_sekolah' => $this->faker->address,
            'nama_kepala_sekolah' => $this->faker->name,
            'id_sekolah' => $this->faker->randomElement([1, 2, 3, 4, 5, 10]),
            'tambahan_informasi' => '',
            'logo_sekolah' => '',
        ];
    }
}
