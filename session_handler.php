<?php

class CustomSessionHandler implements SessionHandlerInterface {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function open($savePath, $sessionName) {
        return true;
    }

    public function close() {
        return true;
    }

    public function read($sessionId) {
        $stmt = $this->db->prepare("SELECT data FROM session_logs WHERE session_id = ?");
        $stmt->execute([$sessionId]);
        $data = $stmt->fetchColumn();
        return $data !== false ? $data : '';
    }

    public function write($sessionId, $data) {
        $stmt = $this->db->prepare("REPLACE INTO session_logs (session_id, data) VALUES (?, ?)");
        return $stmt->execute([$sessionId, $data]);
    }

    public function destroy($sessionId) {
        $stmt = $this->db->prepare("DELETE FROM session_logs WHERE session_id = ?");
        return $stmt->execute([$sessionId]);
    }

    public function gc($maxlifetime) {
        $stmt = $this->db->prepare("DELETE FROM session_logs WHERE created_at < NOW() - INTERVAL :maxlifetime SECOND");
        return $stmt->execute(['maxlifetime' => $maxlifetime]);
    }
}

// Replace 'your_database_name', 'your_username', and 'your_password' with your actual database credentials
$db = new PDO('mysql:host=localhost;dbname=your_database_name', 'your_username', 'your_password');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$handler = new CustomSessionHandler($db);
session_set_save_handler($handler, true);
session_start();
