# RADIUS

**Configure RADIUS auth** (`LAN_RADIUS_06`) — `radius_conf.php`

Authenticate against an external RADIUS server.

Help text: *"This authentication method is used with an external RADIUS server. It requires that
PHP's RADIUS extension is enabled."* (`LAN_AUTHENTICATE_HELP`)

{% hint style="warning" %}
If PHP's `radius` extension is missing, the page shows a warning (`LAN_RADIUS_11`) and the method
reports *"method not available"*. The extension is not bundled with most default PHP builds — you
will usually have to install it yourself.
{% endhint %}

## Settings

| Field | LAN key | Notes |
| --- | --- | --- |
| Server address | `LAN_RADIUS_01` | Host name or IP of the RADIUS server. |
| Shared secret | `LAN_RADIUS_02` | The secret this site and the RADIUS server share. Stored in the site's database — see [Security](../reference/security.md). |

## Field transfer

The field table (`LAN_ALT_27`) is shown only if the RADIUS method exposes fields to copy. In
practice RADIUS answers a yes/no question and returns little else, so most sites leave this empty
and let e107 fill the local record from what the user enters at signup.

See [Field mapping](../reference/field-mapping.md).
