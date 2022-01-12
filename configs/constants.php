<?php

# Credentials
define("USERNAME", "9349f4ef03");
define("PASSWORD", "Y6giX3");
define("SITEID", "a1456bfc");
define("STOREID", "52235119");
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
