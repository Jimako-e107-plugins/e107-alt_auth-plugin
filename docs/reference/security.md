# Security

`alt_auth` is, by its nature, a plugin that holds the keys to another system. Read this before
production use.

## Stored credentials are obfuscated, not encrypted

Everything you type on a method page — including the **password of the foreign database account**,
the **LDAP browsing password** and the **RADIUS shared secret** — is stored in the site's own
`alt_auth` table, Base64-encoded twice. That is obfuscation. It stops a value being read by
accident; it stops nobody who is actually looking.

Practical consequences:

* A read-only SQL injection anywhere on the site, or a leaked database backup, exposes the
  foreign system's credentials as well as e107's.
* **Give the foreign database account the least privilege that works** — usually `SELECT` on the
  single user table. Grant `INSERT` only if you enable the outbound sync, and only on that table.
* Never reuse a password here that is used anywhere else.

The LDAP browsing password is additionally rendered in a **plain text input**, not a password
input, so it is visible on screen to anyone standing behind the administrator.

## Access to the admin pages

Every configuration page requires the **main administrator** permission (`getperms('P')`) and
that the plugin is installed. Anyone who can reach these pages can point authentication at a
server they control — treat this permission as equivalent to full site ownership.

## The connection itself

The database methods open a direct MySQL connection to the foreign server. That connection is
**not** forced to use TLS. If the foreign database is on another host, either put the traffic on
a private network / VPN, or accept that credentials cross the wire in the clear.

## SQL injection

The values used to build the foreign queries — table name, column names — come from the admin
configuration, not from the visitor, and the visitor's username is bound as a parameter (prepared
statement). The exposure is therefore limited to what an administrator configures.

## Passwords in transit through the plugin

On a successful login the submitted password is re-hashed with e107's own hashing and written to
the local record. It is not stored in the foreign format locally, and it is not logged.

The [outbound sync](../getting-started/how-login-works.md#4-optional-creating-the-user-in-the-other-direction)
generates a **random** password for the row it creates in the foreign database, hashes it, and
discards it. The account it creates cannot be logged into until the user resets it on that side.

## Lock-out risk

Not a vulnerability, but the most common way to lose a site: pointing the primary authorisation
type at an external source and leaving both *Failed connection action* and *Failed password
action* on **Failed login**. If the external source goes away, so does your admin access. Keep a
secondary type of `e107` at least until you are confident.
