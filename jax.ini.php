; <?php /*
[DB_DataObject]
database        = mysql://root:password@localhost/hostname
schema_location = ./includes/DataObjects
class_location  = ./includes/DataObjects
require_prefix  = ./includes/DataObjects/
class_prefix    = DataObjects_
ignore_sequence_keys = ALL

; [JAX_Paths]
; JX_CONTENT_PATH = /content
; JX_MODULE_PATH  = /modules
; JX_INCLUDE_PATH = /includes
; SMARTY_DIR = /includes/Smarty/
; JX_BASE_LOG = /jax.log

[JAX]
JX_DEFAULT_MODULE = news
JX_DEFAULT_HANDLER = null
JX_LOGIN_TYPE = email ; can also be "email"
JX_TEMPLATE = default ; change to override
IMAGE_TRANSFORM_LIB_PATH = /usr/bin

[JAX_Config]
JX_HOSTED_PATH = /var/www/%s/html

[JAX_Error_Handling]
handler = JxErrorHandler
level = 2047
warnings = true
logging = true
log_notices = false
log_warnings = true
; */ ?>
