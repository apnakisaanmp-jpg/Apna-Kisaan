# Deploying to Render

This Laravel application uses the Dockerfile in the repository root. In Render,
create a **Web Service** for this repository, select the `main` branch and the
**Docker** runtime, and leave the Root Directory blank. Do not enter Node build
or start commands; Render builds the Dockerfile and starts Apache on port
`10000`.

Create a Render PostgreSQL database in the same region as the web service. Add
these environment variables to the web service:

| Variable | Value |
| --- | --- |
| `APP_NAME` | `Apna Kisaan` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | Generate locally with `php artisan key:generate --show`, then paste the full output |
| `APP_URL` | Your Render HTTPS service URL |
| `ASSET_URL` | The same Render HTTPS service URL |
| `DB_CONNECTION` | `pgsql` |
| `DB_URL` | The PostgreSQL **Internal Database URL** from Render |
| `SESSION_DRIVER` | `database` |
| `CACHE_STORE` | `database` |
| `QUEUE_CONNECTION` | `database` |
| `LOG_CHANNEL` | `stderr` |
| `LOG_LEVEL` | `info` |

Keep `APP_KEY` secret and unchanged between deploys. Do not commit `.env` or
paste its contents into a public file. The container runs
`php artisan migrate --force` at startup; the web service will not start if a
migration fails. Start with one web-service instance so migrations are not run
concurrently by multiple instances.

The container filesystem is not persistent. Files uploaded by users need
persistent/object storage if the application adds upload functionality.
