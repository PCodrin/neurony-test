### Laravel Docker setup

Create a `.env` file:

    cp .env.example .env
    
    Update the `.env` file with your database credentials.
    
Create a `docker-compose.yml` file from the template:
    
    cp docker-compose.yml.template docker-compose.yml

Build and run the Docker container

    docker-compose up -d --build

### Email Testing

Create an mailtrap.io account and edit `.env` file with your mailtrap credentials:
```dotenv
  MAIL_MAILER=smtp
  MAIL_HOST=smtp.mailtrap.io
  MAIL_PORT=2525
  MAIL_USERNAME=your_mailtrap_username
  MAIL_PASSWORD=your_mailtrap_password
  MAIL_ENCRYPTION=tls
```

### Running Unit Tests

To run the PHPUnit tests for your Laravel application:

```bash
docker-compose exec app php artisan test
