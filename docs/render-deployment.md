# Deploying to Render

This Laravel application uses the Dockerfile in the repository root. In Render,
create a **Web Service** for this repository, select the `main` branch and the
**Docker** runtime, and leave the Root Directory blank. Do not enter Node build
or start commands; Render builds the Dockerfile and starts Apache on port
`10000`.

Create a Render PostgreSQL database in the same region as the web service. In
the web service's **Environment** settings, add these variables. For
`DB_URL`, copy the PostgreSQL database's **Internal Database URL** (not its
External Database URL):

| Variable | Value |
| --- | --- |
| `APP_NAME` | `Apna Kisaan` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | Generate a new key with `php artisan key:generate --show`, then paste the full output |
| `APP_URL` | Your Render HTTPS service URL, e.g. `https://apna-kisaan.onrender.com` |
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

In Render's web-service environment, remove old local-database variables
(`DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`) when
switching to `DB_URL`. In particular, `127.0.0.1` refers to the web-service
container itself, not the PostgreSQL service. Render's PostgreSQL internal URL
contains the correct host, port, database, username, and password.

If deployment logs still show `127.0.0.1:3306`, the web service has not received
the correct `DB_URL` yet. Save its Environment changes and redeploy. Do not put
shell commands such as `git push` in `.env`; each environment variable must be
on its own `NAME=value` line. The repository's `.env.example` is only a local
development template; Render uses the web service's Environment settings, not
the ignored local `.env` file.

The `APP_KEY` previously pasted into chat should be considered exposed. Replace
it in Render with a newly generated key. Changing it signs out existing users
and makes data encrypted with the old key unreadable.

The container filesystem is not persistent. Files uploaded by users need
persistent/object storage if the application adds upload functionality.
