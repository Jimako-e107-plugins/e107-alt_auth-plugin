# Requirements

| | |
|---|---|
| e107 | 2.4.0 or newer (`compatibility="2.4.0"` in `plugin.xml`) |
| PHP | The version required by your e107 installation |
| PDO | **Required.** All database-backed methods open their own PDO connection |
| PHP `ldap` extension | Only for the [LDAP](../admin/ldap.md) method |
| PHP `radius` extension | Only for the [RADIUS](../admin/radius.md) method |

## PDO

`e107db`, `otherdb` and the outbound sync all connect to a *foreign* database. e107's own `db`
class always talks to the site's database, so it cannot be used for this — the plugin opens a
separate `PDO` connection instead.

If PDO is not enabled, the main configuration page tells you so and the database methods will
not work. Enable it by adding this line to `e107_config.php`:

```php
define('e_PDO', true);
```

{% hint style="warning" %}
If PDO is not correctly configured on your server, switching e107 to PDO may prevent the site
from connecting to its own database at all. Check with your host first.
{% endhint %}

## Optional PHP extensions

The LDAP and RADIUS methods each need the matching PHP extension. If it is missing, the plugin
does not crash — the configuration page shows a warning, and the method reports
*"method not available"* instead of authenticating. Every other method keeps working.
