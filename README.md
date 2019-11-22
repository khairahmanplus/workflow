1. Clone project.

    ```shell
    git clone https://github.com/khairahmanplus/workflow
    ```

2. Change to directory project.

    ```shell
    cd workflow
    ```

3. Copy `.env.example` to `.env`.

    ```shell
    cp .env.example .env
    ```

4. Install packages.

    ```shell
    composer install
    ```

5. Generate application key.

    ```shell
    php artisan key:generate
    ```

6. Edit `.env` with your database and email credentials.

7. Run migration and seeder.

    ```shell
    php artisan migrate:fresh --seed
    ```

8. Run application web server.

    ```shell
    php artisan serve
    ```

9. Happy developing.
