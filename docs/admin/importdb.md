# Imported database (`importdb`)

**Configure imported database password type** (`IMPORTDB_LAN_10`) — `importdb_conf.php`

This method has **no connection settings at all** — and that is the point. It is used when the
users of another system have already been **imported into this e107 database**, but their
passwords are still stored in the old system's format.

Help text on the page (`IMPORTDB_LAN_11`) and in the help panel (`LAN_AUTHENTICATE_HELP`):
this option is for a user base imported into e107 whose passwords are in an incompatible format.

| Field | LAN key | Notes |
| --- | --- | --- |
| Password Method | `IMPORTDB_LAN_9` | The format the imported hashes are in. Every supported format is offered — see [Password formats](../reference/password-formats.md). |

## What it does

On login, the password is checked against the local `user_password` **using the old format**.
If it matches, the login succeeds and the password is re-hashed into e107's own format and saved.

The result is a **gradual, invisible migration**: each user converts themselves the first time
they log in, without a password reset e-mail and without anyone having to know their password.

## Suggested use

1. Import the user table (login name, e-mail, the old hash) into e107's `user` table.
2. Set the primary authorisation type to `importdb`.
3. Set the secondary type to `e107` — already-converted users then authenticate normally.
4. After enough time has passed, switch the primary type back to `e107`. Anyone who never logged
   in during that window still holds an old hash and will need a password reset.

{% hint style="info" %}
There is no report showing how many users are still on the old format. Judging when step 4 is
safe is a manual decision.
{% endhint %}
