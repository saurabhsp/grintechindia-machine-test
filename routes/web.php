<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AgentController;

Route::get('/', function () {
    return view('welcome');
});



//Admin Signup sirf 
Route::get('admin/signup', [AdminAuthController::class, 'showSignupForm'])->name('admin.signup');
Route::post('admin/signup', [AdminAuthController::class, 'adminSignup']);

Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'adminLogin']);

Route::get('admin/dashboard', [AdminAuthController::class, 'showDashboard'])->name('admin.dashboard');
Route::get('admin/logout', [AdminAuthController::class, 'adminLogout'])->name('admin.logout');

//agents

Route::middleware(['admin.auth'])->group(function () {
    Route::get('admin/agents', [AgentController::class, 'index'])->name('admin.agents'); // Show all agents
    Route::get('admin/agents/create', [AgentController::class, 'create'])->name('admin.agents.create'); // Show Add Agent form
    Route::post('admin/agents/store', [AgentController::class, 'store'])->name('admin.agents.store'); // Handle form submission
    Route::get('admin/agents/{id}/edit', [AgentController::class, 'edit'])->name('admin.agents.edit'); // Show Edit Agent form
    Route::post('admin/agents/{id}/update', [AgentController::class, 'update'])->name('admin.agents.update'); // Update agent
    Route::get('admin/agents/{id}/delete', [AgentController::class, 'destroy'])->name('admin.agents.delete'); // Delete agent
});