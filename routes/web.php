<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\{
    DashboardController, SettingsController,
    ServicesController, ProjectsController,
    TechnologiesController, ContentController
};

// ── Public Site ────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ── Auth (Breeze/built-in) ─────────────────────────────────────────────


// ── Admin (requires auth + is_admin) ──────────────────────────────────
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Settings
        Route::get('settings',        [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings',        [SettingsController::class, 'update'])->name('settings.update');

        // Services
        Route::get('services',        [ServicesController::class, 'index'])->name('services.index');
        Route::get('services/create', [ServicesController::class, 'create'])->name('services.create');
        Route::post('services',       [ServicesController::class, 'store'])->name('services.store');
        Route::get('services/{service}/edit', [ServicesController::class, 'edit'])->name('services.edit');
        Route::put('services/{service}',      [ServicesController::class, 'update'])->name('services.update');
        Route::delete('services/{service}',   [ServicesController::class, 'destroy'])->name('services.destroy');
        Route::post('services/reorder',       [ServicesController::class, 'reorder'])->name('services.reorder');

        // Projects
        Route::get('projects',        [ProjectsController::class, 'index'])->name('projects.index');
        Route::get('projects/create', [ProjectsController::class, 'create'])->name('projects.create');
        Route::post('projects',       [ProjectsController::class, 'store'])->name('projects.store');
        Route::get('projects/{project}/edit', [ProjectsController::class, 'edit'])->name('projects.edit');
        Route::put('projects/{project}',      [ProjectsController::class, 'update'])->name('projects.update');
        Route::delete('projects/{project}',   [ProjectsController::class, 'destroy'])->name('projects.destroy');
        Route::post('projects/reorder',       [ProjectsController::class, 'reorder'])->name('projects.reorder');

        // Technologies — Rings
        Route::get('technologies',                [TechnologiesController::class, 'index'])->name('technologies.index');
        Route::get('technologies/rings/create',   [TechnologiesController::class, 'createRing'])->name('technologies.rings.create');
        Route::post('technologies/rings',         [TechnologiesController::class, 'storeRing'])->name('technologies.rings.store');
        Route::get('technologies/rings/{ring}/edit', [TechnologiesController::class, 'editRing'])->name('technologies.rings.edit');
        Route::put('technologies/rings/{ring}',      [TechnologiesController::class, 'updateRing'])->name('technologies.rings.update');
        Route::delete('technologies/rings/{ring}',   [TechnologiesController::class, 'destroyRing'])->name('technologies.rings.destroy');

        // Technologies — Nodes
        Route::get('technologies/rings/{ring}/techs/create',         [TechnologiesController::class, 'createTech'])->name('technologies.techs.create');
        Route::post('technologies/rings/{ring}/techs',               [TechnologiesController::class, 'storeTech'])->name('technologies.techs.store');
        Route::get('technologies/rings/{ring}/techs/{tech}/edit',    [TechnologiesController::class, 'editTech'])->name('technologies.techs.edit');
        Route::put('technologies/rings/{ring}/techs/{tech}',         [TechnologiesController::class, 'updateTech'])->name('technologies.techs.update');
        Route::delete('technologies/rings/{ring}/techs/{tech}',      [TechnologiesController::class, 'destroyTech'])->name('technologies.techs.destroy');
        Route::post('technologies/reorder',                          [TechnologiesController::class, 'reorderTech'])->name('technologies.techs.reorder');

        // Content Pages
        Route::get('content/navigation',   [ContentController::class, 'navIndex'])->name('content.navigation');
        Route::post('content/navigation',  [ContentController::class, 'navStore'])->name('content.navigation.store');
        Route::put('content/navigation/{link}',    [ContentController::class, 'navUpdate'])->name('content.navigation.update');
        Route::delete('content/navigation/{link}', [ContentController::class, 'navDestroy'])->name('content.navigation.destroy');
        Route::post('content/navigation/reorder',  [ContentController::class, 'navReorder'])->name('content.navigation.reorder');

        Route::get('content/hero',   [ContentController::class, 'hero'])->name('content.hero');
        Route::put('content/hero',   [ContentController::class, 'heroUpdate'])->name('content.hero.update');

        Route::get('content/about',              [ContentController::class, 'about'])->name('content.about');
        Route::put('content/about',              [ContentController::class, 'aboutUpdate'])->name('content.about.update');
        Route::post('content/about/stats',       [ContentController::class, 'statStore'])->name('content.about.stat.store');
        Route::put('content/about/stats/{stat}', [ContentController::class, 'statUpdate'])->name('content.about.stat.update');
        Route::delete('content/about/stats/{stat}', [ContentController::class, 'statDestroy'])->name('content.about.stat.destroy');
        Route::post('content/about/skills',          [ContentController::class, 'skillStore'])->name('content.about.skill.store');
        Route::put('content/about/skills/{skill}',   [ContentController::class, 'skillUpdate'])->name('content.about.skill.update');
        Route::delete('content/about/skills/{skill}',[ContentController::class, 'skillDestroy'])->name('content.about.skill.destroy');

        Route::get('content/contact',  [ContentController::class, 'contact'])->name('content.contact');
        Route::put('content/contact',  [ContentController::class, 'contactUpdate'])->name('content.contact.update');
        Route::post('content/contact/items',         [ContentController::class, 'contactItemStore'])->name('content.contact.item.store');
        Route::put('content/contact/items/{item}',   [ContentController::class, 'contactItemUpdate'])->name('content.contact.item.update');
        Route::delete('content/contact/items/{item}',[ContentController::class, 'contactItemDestroy'])->name('content.contact.item.destroy');
        Route::post('content/socials',               [ContentController::class, 'socialStore'])->name('content.social.store');
        Route::put('content/socials/{social}',       [ContentController::class, 'socialUpdate'])->name('content.social.update');
        Route::delete('content/socials/{social}',    [ContentController::class, 'socialDestroy'])->name('content.social.destroy');
    });
    use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');