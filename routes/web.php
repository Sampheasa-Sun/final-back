<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\AdminController;
// Public routes
Route::get('/', fn() => view('welcome'));

// Route::get('/admin/sign_up', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
// Route::post('/admin/register', [AdminAuthController::class, 'register']);

Route::get('/admin/login', [AdminAuthController::class , 'showLoginForm'])->name('admin.login');
Route::get('/login', fn() => redirect()->route('admin.login'))->name('login');
Route::post('/admin/login', [AdminAuthController::class , 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class , 'logout'])->name('admin.logout');

Route::get('/admin/password/reset', [ForgotPasswordController::class , 'showLinkRequestForm'])->name('admin.password.request');
Route::post('/admin/password/email', [ForgotPasswordController::class , 'sendResetLinkEmail'])->name('admin.password.email');

// Protected routes for authenticated admins
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', [dashboardController::class , 'index'])->name('dashboard');
    // New users this month
    Route::get('/admin/users/new-this-month', [UserController::class , 'newUsersThisMonth'])->name('admin.users.newThisMonth');
    Route::get('/admin/articles/all', [AdminArticleController::class , 'allArticles'])->name('admin.articles.all');
    Route::get('/admin/articles/pending_review', [AdminArticleController::class , 'pendingReview'])->name('admin.articles.pending');


    Route::get('/admin_setting', [AdminSettingController::class , 'show'])->name('admin.settings');
    Route::post('/admin_setting', [AdminSettingController::class , 'update'])->name('admin.settings.update');



    Route::get('/manage_user', [UserController::class , 'index'])->name('admin.manage.users');
    Route::match(['get', 'post'], '/manage_user/{user}/ban', [UserController::class , 'ban'])->name('admin.users.ban');
    Route::match(['get', 'post'], '/manage_user/{user}/unban', [UserController::class , 'unban'])->name('admin.users.unban');
    Route::post('/manage_user/promote/{email}', [UserController::class , 'promote'])->name('admin.users.promote');
    Route::post('/manage_user/demote/{email}', [UserController::class , 'demote'])->name('admin.users.demote');

    Route::get('/manage_user/{user}/edit', [UserController::class , 'editUser'])->name('admin.users.edit');
    Route::put('/manage_user/{user}', [UserController::class , 'updateUser'])->name('admin.users.update');


    Route::get('/articles', [AdminArticleController::class , 'index'])->name('admin.articles.index');
    Route::post('/articles/{article}/approve', [AdminArticleController::class , 'approve'])->name('admin.articles.approve');
    Route::post('/articles/{article}/reject', [AdminArticleController::class , 'reject'])->name('admin.articles.reject');
    Route::get('/articles/statused', [AdminArticleController::class , 'statusedArticles'])->name('admin.articles.statused');
    Route::get('/articles/{article}', [AdminArticleController::class , 'show'])->name('admin.articles.show');
});
