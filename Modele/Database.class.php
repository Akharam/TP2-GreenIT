<?php
	/**
	 * Modèle
	 * Database.class.php
	 *
	 * Méthodes liées à l'accès à la base de donnée.
	 */

	use PDO;
	use PDOException;

	require_once 'config.php';

	/**
	 * Class BaseDB
	 *
	 * Classe de base de données de base.
	 *
	 * @package SDN
	 */
	class BaseDB
	{

		private $db;

		private $username;
		private $password;
		private $database;

		/**
		 * Créé une nouvelle instance du gestionnaire de base de données.
		 */
		public function __construct($username, $password, $database)
		{
			$this->username = $username;
			$this->password = $password;
			$this->database = $database;

			$this->connexionBDD();
		}

		/**
		 * Établit la connexion à la base de données.
		 */
		private function connexionBDD()
		{
			try {
				//connexion à la base de données
				$this->db = new PDO('oci:host='.BDD_HOSTNAME.';dbname='.BDD_DATABASE.';charset=utf8', BDD_USERNAME, BDD_PASSWORD);
			} catch (PDOException $e) {
				die('Erreur lors de la connexion à la base : ' . $e->getMessage() );
			}
		}

		public function __destruct()
		{
			$this->close();
		}

		/**
		 * Fermeture de la base de données.
		 */
		public function close()
		{
			if ($this->db !== null) {
				$this->db = null;
			}
		}

		/**
		 * Commence une transaction.
		 */
		public function beginTransaction()
		{
			$this->db->beginTransaction();
		}

		/**
		 * Commit les changements effectués durant la transaction.
		 */
		public function commit()
		{
			$this->db->commit();
		}

		/**
		 * Exécute une requête retournant des lignes sur la base de données Oracle.
		 *
		 * @param string $sql la requête à exécuter, avec des placeholders
		 * @param array $bindings les valeurs des placeholders
		 * @return array une liste des résultats retournés
		 */
		protected function executerRequeteAvecResultat($sql, $bindings = null)
		{
			return $this->executerRequete($sql, $bindings)->fetchAll(PDO::FETCH_ASSOC);
		}

		/**
		 * Exécute une requête qui ne retourne pas de lignes (ex: INSERT INTO) sur la base de données Oracle.
		 *
		 * @param string $sql la requête à exécuter, avec des placeholders
		 * @param array $bindings les valeurs des placeholders
		 * @throws PDOException si la requête a échoué
		 * @return PDOStatement le statement correspondant à la requête exécutée
		 */
		protected function executerRequete($sql, $bindings = null)
		{
			$stmt = $this->db->prepare($sql);

			if ($bindings !== null && is_array($bindings)) {
				foreach ($bindings as $key => $value) {
					$stmt->bindValue($key, $value);
				}
			}
			//$this->afficher($stmt);
			$succes = $stmt->execute();
			//$this->afficher($succes);

			if (!$succes) {
				$error = $stmt->errorInfo();
				throw new PDOException($error[0] . ': ' . $error[2]);
			}

			return $stmt;
		}
	}

/**
	 * Class Database
	 *
	 * Gère toutes les méthodes d'accès à la base de données.
	 * Si vous avez besoin d'accéder à la base de données, créez une méthode adéquate ici.
	 * Pareil pour l'écriture.
	 *
	 * @package SDN
	 */
	class Database extends BaseDB
	{

		function __construct()
		{
			parent::__construct(BDD_USERNAME, BDD_PASSWORD, BDD_DATABASE);
		}
		
		/**
		 * Affiche un tableau
		 */
		function afficher($tab) {
			echo "<PRE><hr>";
			print_r($tab);
			echo "<hr></PRE>";
		}
        	/**
		 * Fonction qui recupere tous les pays
		 */
		function getEtudiants($grp)
		{
			$sql = "select nom,prenom from etudiants where groupe = ". $grp; //La requete qui recupere les pays

			$res = $this->executerRequeteAvecResultat($sql); //On recupere le resultat de la requete en l'executant
			
			return $res;
		}
    }
?>