
## How to Run the Project

1. Start the services using Docker Compose:
    ```bash
    docker-compose up --build
    ```

2. Run the import script by visiting the following URL:
    ```
    http://api.cc.localhost/import_data.php
    ```

## Hosts

- **API Host:** [http://api.cc.localhost](http://api.cc.localhost)
- **Database Host:** [http://db.cc.localhost](http://db.cc.localhost)
- **Frontend Host:** [http://cc.localhost](http://cc.localhost)
- **Traefik Dashboard:** [http://127.0.0.1:8080/dashboard/#/](http://127.0.0.1:8080/dashboard/#/)

## Additional Information

- **Database Credentials:** Refer to the `docker-compose.yml` file.
- **API Documentation:** Available in the `swagger.yml` file.

