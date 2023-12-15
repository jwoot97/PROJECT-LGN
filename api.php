<?php

require_once 'db_config.php';

# INIT DATA ARRAY
$data = [];

# CORS HEADERS
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");

# GET ALL USER DATA FROM DB
function collectAllData() {
	global $conn;
	$result = $conn->query("SELECT * FROM users");

	# GET ALL USER DATA
	$data = [];
	while ($row = $result->fetch_assoc()) {
		$data[] = $row;
	}

	return $data;
}

# GET ALL EMAILS FROM DB
function collectEmails() {
    global $conn;
    $result = $conn->query("SELECT email FROM users");

    # GET ALL EMAILS
    $emails = [];
    while ($row = $result->fetch_assoc()) {
        $emails[] = $row['email'];
    }

    return $emails;
}

# GET PASSWORD FROM DB
function collectPass($email) {
	global $conn;

	$email = $conn->real_escape_string($email);
	$stmt = $conn->prepare("SELECT pass FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();

	# GET PASSWORD IF USER EXISTS
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		return $row['pass'];
	} else {
		return null;
	}
}

# INSERT USER INTO DB [ EMAIL & PASSWORD ]
function insertUser($email, $pass_user) {
	global $conn;

	$email = $conn->real_escape_string($email);
	$pass_user = $conn->real_escape_string($pass_user);
	$stmt = $conn->prepare("INSERT INTO users (email, pass, is_locked) VALUES (?, ?,  0)");
    $stmt->bind_param("ss", $email, $pass_user);

    $stmt->execute();
    $result = $stmt->get_result();

    # CHECK FOR POSITIVE RESULT
    if ($stmt->affected_rows > 0) {
        return true;
    } else {
        return false;
    }
}

function login() {
    # READ JSON
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);
}

function signup() {
    # READ JSON
    $inputJSON = file_get_contents('php://input');
    $input = json_decode($inputJSON, true);
}

# ROUTE HANDLING
$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'];

if ($method === 'POST') {
	# ROUTE1: LOGIN
	if ($path === '/login') {
		$input = json_decode(file_get_contents('php://input'), true);

		# VALIDATE JSON PAYLOAD
		if (empty($input['email']) || empty($input['pass_user'])) {
			http_response_code(400);
			echo json_encode(['error' => 'Invalid request']);
		} else {
			$email = $input['email'];
			$pass_user = base64_encode($input['pass_user']);
			$pass_db = collectPass($email);

			# VALIDATE LOGIN
			if ($pass_user === $pass_db) {
				echo json_encode(['message' => 'Login successful']);
			} else {
				http_response_code(401);
				echo json_encode(['error' => 'Invalid email or password']);
			}
		}
	}
	# ROUTE2: SIGNUP
	elseif ($path === '/signup') {
		$input = json_decode(file_get_contents('php://input'), true);

		# VALIDATE JSON PAYLOAD
		if (empty($input['email']) || empty($input['pass_user'])) {
			http_response_code(400);
			echo json_encode(['error' => 'Invalid request']);
		} else {
			# VALIDATE EMAIL FORMAT
			$email = $input['email'];
			$email_regex = '/^[\w-]+@([\w-]+\.)+[\w-]+$/';

			if (preg_match($email_regex, $email)) {
				$pass_user = base64_encode($input['pass_user']);
				$db_emails = collectEmails();

				# IF EMAIL EXISTS IN DB
				if (in_array($email, $db_emails)) {
					http_response_code(409);
					echo json_encode(['error' => 'User exists with the entered email']);
				} else {
					insertUser($email, $pass_user);
					echo json_encode(['message' => 'Signup complete']);
				}
			} else {
				http_response_code(400);
				echo json_encode(['error' => 'Email format invalid']);
			}
		}
	}
	# ROUTE3: COLLECT ALL DATA [ TEST METHOD ]
	elseif ($path === '/collectAllData') {
		$allUserData = collectAllData();
		echo json_encode($allUserData);
	}
} else {
	http_response_code(405);
	echo json_encode(['error' => 'Method Not Allowed']);
}

?>