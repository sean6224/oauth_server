# Symfony OAuth2 Server - In a week there will be a stable version

## Project Description

This project is an OAuth2 server built using the Symfony framework. It uses the CQRS (Command Query Responsibility Segregation) pattern, DDD (Domain-Driven Design), API Platform, and PostgreSQL database. The goal of this project is to provide a secure and scalable authorization and authentication service for web and mobile applications.

# Symfony OAuth2 Server—Version History

| Version | Coding Name | Release Date | Notes                     |
|---------|-------------|--------------|---------------------------|
| 0.9     | BetaWave    | 29.06.2024   | Initial release candidate |
| 1.0     | TBD         | TBD          | Stable release            |

## Requirements

- Docker and Docker Compose
- PHP 8.2 or higher (inside Docker container)
- Symfony 6.4
- PostgreSQL 14 or higher (inside Docker container)

## Installation

1. **Clone the repository**

    ```bash
    git clone https://github.com/sean6224/Oauth_Server.git
    cd Oauth_Server
    ```

2. **Changing URL and Reverse Proxy (Traefik)**

    - To change your localhost address, modify `SERVER_NAME` and `TRUSTED_HOSTS` in the `.env` file. Always use `.localhost` as part of the address. For example, if you have `oauth.needrise.localhost` and want to change it to `login.company.localhost`, set it accordingly.

    - To change Traefik's address, update the `docker/traefik/traefik.config.yml` file ([traefik.config.yml](/docker/traefik/traefik.config.yml)). Modify `Host('traefik.needrise.localhost')` under `traefik-dashboard` and `Host('oauth.needrise.localhost')` under `api`. Ensure you follow the same address rule as mentioned above.

    - Remember to update the address in the `generate-localhost-certs.sh` script.


3. **Configure the Database**

   Configure the PostgreSQL database connection in the `.env` file:

    ```dotenv
    DATABASE_NAME=rse
    DATABASE_HOST=database
    DATABASE_USER=root
    DATABASE_PASSWORD=dl5rXGLyyYQ6xcoi
    ```

    - `DATABASE_NAME`: Name of the PostgreSQL database.
    - `DATABASE_HOST`: Hostname of the PostgreSQL database (the service name from `docker-compose.yml`).
    - `DATABASE_USER`: Username for the PostgreSQL database.
    - `DATABASE_PASSWORD`: Password for the PostgreSQL database.


4. **Changing the Appearance of Twig Templates**

   To modify Twig templates, navigate to the [Presentation/Templates](/src/Presentation/Templates) directory.


5. **Change Configurations for Sending Email in `.env`**

   Configure email settings in the `.env` file for Symfony Mailer:

    ```dotenv
    ###> symfony/mailer ###
    MAILER_NAME=CompanyName
    MAILER_FROM_ADDRESS=setemail@setemail.com
    ###< symfony/mailer ###

    ###> symfony/google-mailer ###
    # Gmail SHOULD NOT be used in production, use it in development only.
    MAILER_DSN=gmail+smtp://test:set@default
    ###< symfony/google-mailer ###
    ```

    - `MAILER_NAME`: Name of your mailer.
    - `MAILER_FROM_ADDRESS`: Default sender email address.
    - `MAILER_DSN`: Symfony Mailer DSN (Data Source Name) for Gmail in development environment.


6. **Oauth Server Commands**
   - Installation of oauth server:
       ```bash
       make install
       ```
   - Stopping oauth server:
     ```bash
     make stop
     ```
   - Running oauth server:
     ```bash
     make start
     ```  

7. **Accessing Services**
   - Api https://oauth.needrise.localhost
   - Treatise https://traefik.needrise.localhost

## Contributing

If you want to contribute to the project, please open an issue or pull request on GitHub. We welcome contributions from the community!

## License

This project is licensed under the MIT License. See the [LICENSE](./LICENSE) file for more details.
