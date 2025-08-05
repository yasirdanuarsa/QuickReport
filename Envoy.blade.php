@servers(['production' => ['root@165.22.103.46']])

@setup
    $repo = 'https://github.com/yasirdanuarsa/QuickReport.git';
    $appDir = '/var/www/monev';
    $branch = 'main';

    date_default_timezone_set('Asia/Jakarta');
    $date = date('YmdHis');

    $builds = $appDir . '/sources';
    $deployment = $builds . '/' . $date;

    $serve = $appDir . '/source';
    $env = $appDir . '/.env';
    $storage = $appDir . '/storage';
@endsetup

@story('deploy')
    git
    install
    live
@endstory

@task('git', ['on' => 'production'])
    echo "🚀 Cloning repository..."
    git clone -b {{ $branch }} "{{ $repo }}" {{ $deployment }}
@endtask

@task('install', ['on' => 'production'])
    echo "🚀 Preparing project directory..."
    cd {{ $deployment }}

    rm -rf {{ $deployment }}/storage
    ln -nfs {{ $env }} {{ $deployment }}/.env
    ln -nfs {{ $storage }} {{ $deployment }}/storage

    echo "🚀 Installing PHP dependencies... "
    composer install --prefer-dist --no-dev

    echo "🚀 Running Migrations..."
    php artisan migrate --force || { echo "❌ Migration failed"; exit 1; }

    {{-- echo "🚀 Running Seeders..."
    php artisan db:seed --class=UserSeeder --force || { echo "❌ Seeder failed"; } --}}
@endtask

@task('live', ['on' => 'production'])
    echo "🚀 Activating new deployment..."
    cd {{ $deployment }}
    ln -nfs {{ $deployment }} {{ $serve }}

    cd /var/www/monev/source

    composer dump-autoload
    php artisan config:clear
    php artisan cache:clear
    php artisan route:clear

    echo "🚀 Loading NVM and using Node.js... "
    export NVM_DIR="$HOME/.nvm"
    [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
    nvm use 22 || { echo '❌ Failed to load Node.js via NVM'; exit 1; }

    echo "🚀 Installing NPM dependencies..."
    npm install --no-audit --no-fund --prefer-offline || { echo '❌ NPM install failed'; exit 1; }

    echo "🚀 Building assets with Vite..."
    npm run build || { echo '❌ Vite build failed'; exit 1; }

    echo "🚀 Setting file permissions..."
    chown -R www-data: /var/www

    echo "🚀 Restarting PHP-FPM and Nginx..."
    systemctl restart php8.3-fpm
    systemctl restart nginx
@endtask