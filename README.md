# Project Setup Documentatie

``` text
Opzet van het project:

1: Database maken
2: Terminal: laravel new "naam project"
3: cd
4: npm install
5: .env file: establish connection database
6: php artisan migrate
7: composer require laravel/breeze --dev
8: php artisan breeze:install blade
9: test /register + /login
10: composer require spatie/laravel-permission
11: php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

-- Git --

12: git init
13: git add .
14: git commit -m " "
15: remote repo aanmaken

-- HTTPS Route --

git remote add origin
git remote -v
git branch
git push -u origin master

-- SSH Route --

git remote add origin
git remote -v
ls ~/.ssh

-- if exists: --

cat ~/.ssh/id_rsa.pub
copy output
add ssh key in repo

-- else --

ssh-keygen -t ed25519 -C "jouw@email.com"
ls ~/.ssh
cat ~/.ssh/id_rsa.pub
copy output
add ssh key in repo

-- git done! --

-- if using mysql: --
app/Providers/AppServiceProvider.php
voeg: use Illuminate\Support\Facades\Schema;
in de boot() methode: Schema::defaultStringLength(191);

16: app/Models/User.php -> heeft HasRoles import nodig -> en in de class HasRoles
17: php artisan make:seeder RoleSeeder
18: open: RoleSeeder.php
19: voeg: use Spatie\Permission\Models\Role;
20: in run(): Role::firstOrCreate(['name' => 'admin']); + Role::firstOrCreate(['name' => 'user']);
21: php artisan make:seeder AdminSeeder
22: open: AdminSeeder.php
23: voeg: use Illuminate\Support\Facades\Hash; use App\Models\User;
24: in run() methode voeg:
    $admin = User::firstorcreate(
        ['email' => 'admin@example.com'],
        [
            'name' => 'Admin'
            'password' => Hash::make('admin123'),
        ]
    );
    $admin->assignRole('admin');
25: php artisan make:seeder UserSeeder
26: stap 22 + 23 + 24 in UserSeeder
27: voeg: use Illuminate\Support\Facades\Hash; use App\Models\User;
28: in run() methode van UserSeeder voeg:
    User::factory(10)->create()->each(function ($user) {
        $user->assignRole('user');
    });
29: open: database/seeders/DatabaseSeeder.php
30: in run() methode voeg:
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminUserSeeder::class,
            UserSeeder::class,
        ]);
    }
31: php artisan migrate:fresh --seed
32: open: bootstrap/app.php
33: ->withMiddleware(function ($middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
34: open: web.php om een test route toe te voegen
35: Route::get('/admin', function () {
        return 'Admin dashboard';
    })->middleware(['auth', 'role:admin']);
36: php artisan make:controller Admin/DashboardController
37: php artisan make:controller DashboardController
38: open: Admin/DashboardController.php
39: voeg:
    use App\Models\User;

    public function index()
    {
        $users = User::with('roles')->get();
        $userCount = $users->count();

        return view('admin.dashboard', compact('users', 'userCount'));
    }
40: open: web.php
41: voeg: use App\Http\Controllers\Admin\DashboardController;
    Route::middleware(['auth', 'role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])
                ->name('dashboard');
        });
42: maak view aan resources/views/admin -> dashboard.blade.php
43: maak view aan recources/views -> dashboard.blade.php
```