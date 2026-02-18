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
19: in run(): Role::firstOrCreate(['name' => 'admin']); + Role::firstOrCreate(['name' => 'user']);
20: php artisan make:seeder AdminSeeder
21: open AdminSeeder.php
22: voeg: use Illuminate\Support\Facades\Hash;
23: in run() methode voeg:
    $admin = User::firstorcreate(
        ['email' => 'admin@example.com'],
        [
            'name' => 'Admin'
            'password' => Hash::make('admin123'),
        ]
    );

    $admin->assignRole('admin');
24: php artisan make:seeder UserSeeder
25: stap 22 + 23 in UserSeeder
26: in run() methode van UserSeeder voeg:
    User::factory(10)->create()->each(function ($user) {
        $user->assignRole('user');
    });
27: open: database/seeders/DatabaseSeeder.php
28: in run() methode voeg:
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminUserSeeder::class,
            UserSeeder::class,
        ]);
    }
29: php artisan migrate:fresh --seed
```