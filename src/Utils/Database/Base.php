<?php
	namespace Utils\Database;

	class Base {
		protected $localPass;
		protected $host;
		protected $username;
		protected $password;
		protected $dbname;
		protected $port;
		protected $conn;

		public function __construct(array $config) {
			$notFound = [];
			foreach([ 'localPass', 'host', 'username', 'password', 'dbName' ] as $field) {
				if(empty($config[$field])) {
					$notFound[] = $field;
				}
			}

			if(count($notFound)) {
				throw new \Exception('The following required fields were not provided in the config file: ' . join(', ', $notFound) . '.');
			}

			$this->localPass = $config['localPass'];
			$this->host = $config['host'];
			$this->username = $config['username'];
			$this->password = $config['password'];
			$this->port = $config['port'] ?? 3306;
			$this->dbname = $config['dbName'];
		}

		public function isLocalPassValid(string $pass) : bool {
			return password_verify($pass, $this->localPass);
		}

		public function connect() : array {
			$this->conn = new \mysqli($this->host, $this->username, $this->password, $this->dbname, $this->port);
			return [ 'success' => !!$this->conn->connect_error, 'error' => $this->conn->connect_error ];
		}

		public function disconnect() {
			$this->conn->close();
		}
	}