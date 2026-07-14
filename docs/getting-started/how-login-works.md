# How login works

When someone submits the login form, e107 hands the username and password to `alt_auth`, which
runs the following sequence.

## 1. The primary method is asked

The method named in *Primary authorisation type* is loaded (`<method>_auth.php`) and asked to
validate the credentials. It answers with exactly one of:

| Result | Meaning |
|---|---|
| success | username and password are valid |
| invalid user | the source does not know this username |
| bad password | the username exists, the password does not match |
| could not connect | the server or database was unreachable |
| method not available | the required PHP extension is not loaded |
| unknown cause | anything else |

## 2. What happens on failure

Two of those outcomes are configurable, on the
[Main configuration](../admin/main-configuration.md) page:

* **invalid user** → the *Secondary authorisation type* is tried. This is how "external users
  and local users can both log in" is achieved: set the secondary type to `e107`.
* **bad password** → *Failed password action*: fail the login, or fall back to the secondary type.
* **could not connect** → *Failed connection action*: fail the login, or fall back to the
  secondary type.

## 3. What happens on success

This is the part worth understanding, because it explains why the local user table still matters.

1. The submitted password is hashed **the e107 way** and becomes the local `user_password`.
   From this point the local record could authenticate the user on its own.
2. Any fields the external source returned (email, display name, avatar, …) are mapped onto
   local `user` columns according to your [field mapping](../reference/field-mapping.md), passing
   through the optional [conversion](../reference/field-mapping.md#conversion-methods) step.
3. Selected [extended user fields](../reference/field-mapping.md#extended-user-fields) are
   written to `user_extended`.
4. If the user **already exists locally**, only the changed values are written.
5. If the user **does not exist locally**, a local account is created for them.
6. e107's normal login then proceeds against the (now up-to-date) local record.

{% hint style="info" %}
Consequence: the external system is the source of truth for *authentication*, and the local
e107 record is the source of truth for everything else — classes, permissions, sessions. A user
removed from the external directory keeps their local record; disable or ban them in e107 too.
{% endhint %}

## 4. Optional: creating the user in the *other* direction

The preference *Create missing users in the authentication source on login* reverses one step:
when an e107 user logs in and is **missing from the `otherdb` database**, the plugin creates
them there with a random, unusable password.

This is intended for a shared user base between two applications, where e107 is where people
sign up. It is deliberately narrow:

* it only applies to the **`otherdb`** method,
* it only writes the login name and a random password hash — no other fields,
* it never re-writes an existing row,
* it is wrapped so that any failure is logged and **cannot break the login**.

The random password is not recorded anywhere and cannot be used to log into the other
application; the user must reset it there.
