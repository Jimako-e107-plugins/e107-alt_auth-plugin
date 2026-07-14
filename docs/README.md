# alt\_auth

An e107 plugin that lets your visitors log in with credentials that live **somewhere other
than this site's own user table** — a second e107 database, a foreign application database,
an LDAP / Active Directory server, or a RADIUS server.

It also solves a second, related problem: a user table that was **imported** into e107 from
another system and still holds passwords in that system's format. `alt_auth` can validate
against those hashes and quietly re-hash them into e107's own format on first successful
login.

## At a glance

|                    |                                                                          |
| ------------------ | ------------------------------------------------------------------------ |
| Requires           | e107 2.4, PDO enabled — see [Requirements](getting-started/requirements.md) |
| Admin access       | Main administrator only (`getperms('P')`)                                 |
| Authentication methods | `e107db`, `otherdb`, `importdb`, `ldap`, `radius`                    |
| Own table          | `alt_auth` (parameter store)                                             |
| Front-end          | None — the plugin has no front-end pages, menus or shortcodes            |

## What it does on a successful login

Whatever the method, the outcome is always the same: **the local e107 user record wins.**
The external source is only asked *"is this username and password valid, and what else do you
know about this person?"*. The answer is then written into the local `user` table — including
the password, re-hashed the e107 way — so that the site keeps working normally afterwards.

See [How login works](getting-started/how-login-works.md) for the exact sequence.

{% hint style="warning" %}
Connection details for the external source (server, database user, **password**) are stored in
the site's own database, only lightly obfuscated — not encrypted. Read
[Security](reference/security.md) before pointing this plugin at anything you care about.
{% endhint %}
