<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\superhero;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [superhero::class,'index']);
Route::post('/detailsHero', [superhero::class,'getDetailsHero'])->name('detailsHero');
Route::post('/detailsSuperhero-skill', [superhero::class,'getDetailsSkill'])->name('detailsSuperhero-skill');;
Route::delete('/deleteskillOfHero/', [superhero::class,'deleteskillOfHero'])->name('deleteskillOfHero');
Route::post('/searchSkill', [superhero::class,'searchSkill'])->name('searchSkill');



Route::delete('/delete/{id}', [superhero::class,'destroy'])->name('delete');
Route::post('/search', [superhero::class,'search'])->name('search');
Route::post('/simulasi', [superhero::class,'simulasi'])->name('simulasi');
Route::post('/detailsHeroSkill', [superhero::class,'getDetailsHeroSkill'])->name('detailsHeroSkill');
Route::get('/search/{id}', [superhero::class,'getSuperhero']);
Route::post('/detailsSkillH', [superhero::class,'getDetailsSkillHero'])->name('detailsSkillH');
