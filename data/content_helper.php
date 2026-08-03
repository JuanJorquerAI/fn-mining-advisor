<?php
/**
 * FN Mining Advisor — Helper for content storage and authentication
 */

define('DATA_DIR', __DIR__);
define('CONTENT_FILE', DATA_DIR . '/content.json');
define('AUTH_FILE', DATA_DIR . '/auth.json');

// Initialize default auth if not present
function getAuthData() {
    if (!file_exists(AUTH_FILE)) {
        $defaultAuth = [
            'username' => 'admin',
            // Default password: "admin123"
            'password_hash' => '$2y$10$V14GvXqPjHhE9uV4z5E5q.zY9Pz4yG5O.K7E3F2E1D0C9B8A7' 
        ];
        // We will generate hash properly if array is fresh
        $defaultAuth['password_hash'] = password_hash('admin123', PASSWORD_DEFAULT);
        file_put_contents(AUTH_FILE, json_encode($defaultAuth, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $defaultAuth;
    }
    $raw = file_get_contents(AUTH_FILE);
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

function updatePassword($newPassword) {
    $auth = getAuthData();
    $auth['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
    return file_put_contents(AUTH_FILE, json_encode($auth, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}

function updateUsernameAndPassword($newUsername, $newPassword) {
    $auth = getAuthData();
    if (!empty($newUsername)) {
        $auth['username'] = trim($newUsername);
    }
    if (!empty($newPassword)) {
        $auth['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
    }
    return file_put_contents(AUTH_FILE, json_encode($auth, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}

// Read all content
function getAllContent() {
    if (!file_exists(CONTENT_FILE)) {
        return [];
    }
    $raw = file_get_contents(CONTENT_FILE);
    $data = json_decode($raw, true);
    return is_array($data) ? $data : [];
}

// Save all content
function saveAllContent($data) {
    return file_put_contents(CONTENT_FILE, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
}

// Get nested value by key path (e.g. "hero.heading")
function getContent($keyPath, $default = '') {
    static $content = null;
    if ($content === null) {
        $content = getAllContent();
    }
    
    $keys = explode('.', $keyPath);
    $curr = $content;
    foreach ($keys as $k) {
        if (isset($curr[$k])) {
            $curr = $curr[$k];
        } else {
            return $default;
        }
    }
    return is_string($curr) ? $curr : $default;
}

// Safe HTML output helper
function e($keyPath, $default = '') {
    echo htmlspecialchars(getContent($keyPath, $default), ENT_QUOTES, 'UTF-8');
}

// Multiline safe HTML output helper (preserves line breaks)
function e_nl2br($keyPath, $default = '') {
    echo nl2br(htmlspecialchars(getContent($keyPath, $default), ENT_QUOTES, 'UTF-8'));
}
