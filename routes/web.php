<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AgentAuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// Admin Authentication Routes
Route::get('admin/signup', [AdminAuthController::class, 'showSignupForm'])->name('admin.signup');
Route::post('admin/signup', [AdminAuthController::class, 'adminSignup']);
Route::get('admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminAuthController::class, 'adminLogin'])->name('admin.login.submit');
Route::get('admin/logout', [AdminAuthController::class, 'adminLogout'])->name('admin.logout');

// Admin Dashboard & Agent Management (Protected by Admin Middleware)
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminAuthController::class, 'showDashboard'])->name('admin.dashboard');

    // Agent Management Routes
    // Route::get('admin/agents', [AgentController::class, 'index'])->name('admin.agents');
    Route::get('admin/agents/create', [AdminAuthController::class, 'create'])->name('admin.agents.create');
    Route::post('admin/agents/store', [AdminAuthController::class, 'store'])->name('admin.agents.store');
    Route::get('admin/agents/{id}/edit', [AdminAuthController::class, 'edit'])->name('admin.agents.edit');
    Route::post('admin/agents/{id}/update', [AdminAuthController::class, 'update'])->name('admin.agents.update');
    Route::get('admin/agents/{id}/delete', [AdminAuthController::class, 'destroy'])->name('admin.agents.delete');
    Route::get('admin/agents/{id}/toggle-status', [AdminAuthController::class, 'toggleStatus'])->name('admin.agents.toggle-status');
});

Route::get('showdata', [AgentAuthController::class, 'showdata']);
Route::get('agent/login', [AgentAuthController::class, 'showLoginForm'])->name('agent.login');
Route::post('agent/login', [AgentAuthController::class, 'agentLogin']);
Route::get('agent/logout', [AgentAuthController::class, 'agentLogout'])->name('agent.logout');


// Agent Dashboard & User Management (Protected by Agent Middleware)
Route::middleware(['agent'])->group(function () {
    Route::get('agent/dashboard', [AgentAuthController::class, 'showDashboard'])->name('agent.dashboard');
    Route::get('agent/users', [UserController::class, 'index'])->name('agent.users.index');
    Route::get('agent/users/create', [UserController::class, 'create'])->name('agent.users.create');
    Route::post('agent/users/store', [UserController::class, 'store'])->name('agent.users.store');
    Route::get('agent/users/{id}/edit', [UserController::class, 'edit'])->name('agent.users.edit');
    Route::post('agent/users/{id}/update', [UserController::class, 'update'])->name('agent.users.update');
    Route::get('agent/users/{id}/delete', [UserController::class, 'destroy'])->name('agent.users.delete');
});
