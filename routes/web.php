<?php

use App\Enums\UserRolesEnum;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardHomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LoyaltyProgramPageController;
use App\Http\Controllers\ChatBotController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/test', [App\Http\Controllers\AdminDashboardHome::class, 'index'])->name('test');

Route::get('/', [App\Http\Controllers\HomePageController::class, 'index'])->name('home');

// Route::post('/chat', [ChatBotController::class, 'chat'])->name('chat');
// Route::post('/chat-with-image', [ChatBotController::class, 'chatWithImage'])->name('chat.image');

Route::get('/about', function () {
    return view('web.about');
})->name('about');

Route::get('/loyalty-program', [LoyaltyProgramPageController::class, 'show']);

Route::get('/services', [App\Http\Controllers\DisplayService::class, 'index'])->name('services');
Route::get('/services/{slug}', [App\Http\Controllers\DisplayService::class, 'show'])->name('view-service');

// Route::get('/services/{id}', [App\Http\Controllers\ServiceDisplay::class, 'show'])->name('services.show');
Route::get('/deals', [App\Http\Controllers\DisplayDeal::class, 'index'])->name('deals');

Route::get('/admin/dashboard', [AdminDashboardHomeController::class, 'index'])
    ->name('admin.dashboard')
    ->middleware('validateRole:Manager,Staff');

// Users needs to be logged in for these routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [App\Http\Controllers\DashboardHomeController::class, 'index'])->name('dashboard');

        // Routes for Manager only
        Route::middleware([
            'validateRole:Manager'
        ])->group(function () {
            Route::prefix('manage')->group(function () {
                // User management - using existing UserController
                Route::resource('users', App\Http\Controllers\UserController::class)->name('index', 'manageusers');
                Route::put('users/{id}/suspend', [App\Http\Controllers\UserSuspensionController::class, 'suspend'])
                    ->name('manageusers.suspend');
                Route::put('users/{id}/activate', [App\Http\Controllers\UserSuspensionController::class, 'activate'])
                    ->name('manageusers.activate');
                
                // Add inside the manager middleware group
                Route::get('/loyalty/settings', function () {
                    return view('dashboard.loyalty.settings');
                })->name('loyalty.settings');

                // Location management - using existing view
                Route::get('locations', function () {
                    return view('dashboard.manage-locations.index');
                })->name('managelocations');

                // Add this with other dashboard routes, in the manager middleware group
                Route::get('loyalty', function () {
                    return view('dashboard.loyalty.index');
                })->name('manageloyalty');

                Route::get('loyalty/rewards', function () {
                    return view('dashboard.loyalty.rewards');
                })->name('managerewards');

                Route::get('hairstyle-categories', function () {
                    return view('dashboard.manage-hairstyle-categories.index');
                })->name('managehairstylecategories');
            });
        });

        // Routes for both Manager and Staff
        Route::middleware([
            'validateRole:Manager,Staff'
        ])->group(function () {
            Route::prefix('manage')->group(function () {
                // Services management - using existing views and controllers
                Route::get('services', function () {
                    return view('dashboard.manage-services.index');
                })->name('manageservices');

                // Deals management
                Route::get('deals', function () {
                    return view('dashboard.manage-deals.index');
                })->name('managedeals');

                // Categories management - Add this new route
                Route::get('categories', function () {
                    return view('dashboard.manage-categories.index');
                })->name('managecategories');

                // Appointments management
                Route::get('appointments', function () {
                    return view('dashboard.manage-appointments.index');
                })->name('manageappointments');

                // Appointment Schedule
                Route::get('appointment-schedule', [App\Http\Controllers\AppointmentScheduleController::class, 'index'])
                    ->name('appointment.schedule');

                Route::get('hairstyles', function () {
                    return view('dashboard.manage-hairstyles.index');
                })->name('managehairstyles');

                // Transaction History
                Route::get('/loyalty/transactions', function () {
                    return view('dashboard.loyalty.transactions');
                })->name('loyalty.transactions');
            });
        });

        // Routes for Customers
        Route::middleware([
            'validateRole:Customer'
        ])->group(function () {
            // Using existing DisplayService controller for viewing services
            Route::get('/services', [App\Http\Controllers\DisplayService::class, 'index'])
                ->name('services');
            
            Route::get('/hairstyles', function () {
                $categories = App\Models\HairstyleCategory::with('hairstyles')->get();
                return view('web.hairstyles', compact('categories'));
            })->name('hairstyles');
            
            // Using existing ManageAppointments component for customer appointments
            Route::get('/appointments/history', function () {
                return view('dashboard.appointments.history');
            })->name('appointments.history');

            Route::middleware(['auth'])->group(function () {
                Route::get('/dashboard/loyalty', function () {
                    return view('dashboard.customer.loyalty');
                })->name('customer.loyalty');
            });

            Route::middleware(['auth'])->group(function () {
                Route::get('/cart', [CartController::class, 'index'])->name('cart');
                Route::post('/cart/remove-item/{cart_service_id}', [CartController::class, 'removeItem'])->name('cart.remove-item');
                Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
            });
        });
    });
});
