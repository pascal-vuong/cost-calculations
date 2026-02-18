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

16: 