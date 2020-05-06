<?php

use App\Enums\GenreType;
use App\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    const GENRES = [
        GenreType::COUNTRY,
        GenreType::DISCO,
        GenreType::JAZZ,
        GenreType::POP,
        GenreType::ROCK,
        GenreType::THE_BLUES
    ];
    public function run()
    {
        foreach(self::GENRES as $genre) {
            $genreModel = new Genre();
            $genreModel->active = true;
            $genreModel->type = $genre;
            $genreModel->save();
        }
    }
}
