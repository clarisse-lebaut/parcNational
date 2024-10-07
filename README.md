# parcNational

En cas de problèmes de connexion via les comptes Google ou Facebook, il est nécessaire de configurer les fichiers php.ini et phpForApache.ini dans la version de PHP que vous possédez
[curl]
; A default value for the CURLOPT_CAINFO option. This is required to be an
; absolute path.
curl.cainfo = "C:/wamp64/bin/php/cacert.pem"

[openssl]
; The location of a Certificate Authority (CA) file on the local filesystem
; to use when verifying the identity of SSL/TLS peers. Most users should
; not specify a value for this directive as PHP will attempt to use the
; OS-managed cert stores in its absence. If specified, this value may still
; be overridden on a per-stream basis via the "cafile" SSL stream context
; option.
openssl.cafile = "C:/wamp64/bin/php/cacert.pem"


Pour pouvoir envoyer un email avec la confirmation d'achat d'un abo il faut installer :
composer require phpmailer/phpmailer