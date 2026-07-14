# Installation

1. Copy the plugin folder to `e107_plugins/alt_auth/`.
2. Go to **Admin → Plugin Manager**, find *Alternate Authentication*, and install it.
3. Installation creates the `alt_auth` table and adds five preferences with safe defaults —
   nothing changes about how people log in yet.
4. Open **Admin → Alternate Authentication** and configure the method you want.

After installation the primary authentication type is still `e107`, so the site behaves exactly
as before. Logins only start going elsewhere once you change
*Primary authorisation type* on the [Main configuration](../admin/main-configuration.md) page.

## Recommended order of work

1. Configure the method's connection details on its own page (e.g. *Configure otherdb*).
2. **Test it** on the same page — see [Testing a connection](../admin/testing.md). Do this
   *before* switching the primary type.
3. Only when the test succeeds, go back to Main configuration and select the method.
4. Decide what should happen when the external source is unreachable or rejects the password.

{% hint style="danger" %}
Switching the primary authorisation type to a method that does not actually work can lock you
out of your own site. Set *Failed connection action* and *Failed password action* to
**Use secondary authorisation** with a secondary type of `e107` while you are still testing.
{% endhint %}

## Uninstalling

Removing the plugin drops the `alt_auth` table, which holds all the connection settings for
every method. Note down anything you might want to re-enter.
