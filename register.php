<?php
$file_path = 'users.json';

function read_users() {
    global $file_path;
    if (!file_exists($file_path)) {
        file_put_contents($file_path, json_encode([]));
    }
    $json_data = file_get_contents($file_path);
    return json_decode($json_data, true);
}

function write_users($users) {
    global $file_path;
    file_put_contents($file_path, json_encode($users));
}

$users = read_users();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $college = $_POST['college'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    foreach ($users as $user) {
        if ($user['username'] === $username) {
            echo json_encode(['success' => false, 'message' => 'Username already exists']);
            exit;
        }
    }

    $users[] = [
        'name' => $name,
        'address' => $address,
        'dob' => $dob,
        'college' => $college,
        'username' => $username,
        'password' => $password
    ];
    write_users($users);

    echo json_encode(['success' => true, 'users' => array_column($users, 'username')]);
    exit;
}

echo json_encode(['users' => array_column($users, 'username')]);
?>
