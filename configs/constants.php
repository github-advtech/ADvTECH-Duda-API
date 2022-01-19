<?php

# Credentials
define("USERNAME", "52ca4c1a8b");
define("PASSWORD", "dnJ8cbLeJtoV");
define("SITEID", "db6c93a5");
define("STOREID", "67036782");
define("ECWID_AUTH_TOKEN", "secret_tHwZUAWXk5QRGtuybbJsBZhBGWpMdRSk");
define("LOBSTER_TOKEN_CLIENT_ID", "capsicum-userprovisioning-prod");
define("LOBSTER_TOKEN_CLIENT_SECRET", "c1cbe61c-7bd4-d3e2-a027-85fdff9449e0");

# Paths
define("LOGS_FOLDER_PATH", getcwd().DIRECTORY_SEPARATOR."logs". DIRECTORY_SEPARATOR);

# Endpoints
define("ECWID_URL", "https://app.ecwid.com/api/v3/");
define("LOBSTER_TOKEN_URL", "https://lobster-access.com/sts/connect/token");
define("LOBSTER_USER_INVITE_URL", "https://hospitalityfutures.lobster-access.com/userprovisioning/api/invite");
define("DUDA_STORE_TOKEN_URL", "https://api.duda.co/api/store/".STOREID."/accessData");

# Defaults
date_default_timezone_set("Africa/Johannesburg");
