<?php

require "utils/fetch.php";
require "utils/request.php";
require "utils/response.php";
require "models/Logger.php";
require "enums/OrderEventType.php";
require "enums/LoggerType.php";
require "enums/OrderStatus.php";
require "enums/ContentType.php";
require "constants.php";

header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");