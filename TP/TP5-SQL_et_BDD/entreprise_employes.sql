
-- # Création d'une BDD en langage SQL, si elle n'existe pas
-- CREATE DATABASE IF NOT EXISTS entreprise;

-- # Sélection de la BDD utilisée
-- USE entreprise;

-- # Création dune table en langage SQL
CREATE TABLE employes (
  id_employes INT NOT NULL AUTO_INCREMENT,
  prenom VARCHAR(20) NOT NULL,
  nom VARCHAR(20) NOT NULL,
  civilite ENUM('m','f') NOT NULL,
  service VARCHAR(30) NOT NULL,
  date_embauche DATE NOT NULL,
  salaire INT NOT NULL,
  PRIMARY KEY (id_employes)
) ENGINE=InnoDB;

-- # Création de données et insertion dans la table 'employes'
INSERT INTO employes (id_employes, prenom, nom, civilite, service, date_embauche, salaire) VALUES
(350, 'Jean-pierre', 'Laborde', 'm', 'direction', '2010-12-09', 5000),
(388, 'Clement', 'Gallet', 'm', 'commercial', '2010-12-15', 2300),
(415, 'Thomas', 'Winter', 'm', 'commercial', '2011-05-03', 3550),
(417, 'Chloe', 'Dubar', 'f', 'production', '2011-09-05', 1900),
(491, 'Elodie', 'Fellier', 'f', 'secretariat', '2011-11-22', 1600),
(509, 'Fabrice', 'Grand', 'm', 'comptabilite', '2011-12-30', 2900),
(547, 'Melanie', 'Collier', 'f', 'commercial', '2012-01-08', 3100),
(592, 'Laura', 'Blanchet', 'f', 'direction', '2012-05-09', 4500),
(627, 'Guillaume', 'Miller', 'm', 'commercial', '2012-07-02', 1900),
(655, 'Celine', 'Perrin', 'f', 'commercial', '2012-09-10', 2700),
(699, 'Julien', 'Cottet', 'm', 'secretariat', '2013-01-05', 1390),
(701, 'Mathieu', 'Vignal', 'm', 'informatique', '2013-04-03', 2500),
(739, 'Thierry', 'Desprez', 'm', 'secretariat', '2013-07-17', 1500),
(780, 'Amandine', 'Thoyer', 'f', 'communication', '2014-01-23', 2100),
(802, 'Damien', 'Durand', 'm', 'informatique', '2014-07-05', 2250),
(854, 'Daniel', 'Chevel', 'm', 'informatique', '2015-09-28', 3100),
(876, 'Nathalie', 'Martin', 'f', 'juridique', '2016-01-12', 3550),
(900, 'Benoit', 'Lagarde', 'm', 'production', '2016-06-03', 2550),
(933, 'Emilie', 'Sennard', 'f', 'commercial', '2017-01-11', 1800),
(990, 'Stephanie', 'Lafaye', 'f', 'assistant', '2017-03-01', 1775);


-- # (NULL, 'Jean-pierre', 'Laborde', 'm', 'direction', '2010-12-09', 5000),
-- # (NULL, 'Clement', 'Gallet', 'm', 'commercial', '2010-12-15', 2300),
-- # (NULL, 'Thomas', 'Winter', 'm', 'commercial', '2011-05-03', 3550),
-- # (NULL, 'Chloe', 'Dubar', 'f', 'production', '2011-09-05', 1900),
-- # (NULL, 'Elodie', 'Fellier', 'f', 'secretariat', '2011-11-22', 1600),
-- # (NULL, 'Fabrice', 'Grand', 'm', 'comptabilite', '2011-12-30', 2900),
-- # (NULL, 'Melanie', 'Collier', 'f', 'commercial', '2012-01-08', 3100),
-- # (NULL, 'Laura', 'Blanchet', 'f', 'direction', '2012-05-09', 4500),
-- # (NULL, 'Guillaume', 'Miller', 'm', 'commercial', '2012-07-02', 1900),
-- # (NULL, 'Celine', 'Perrin', 'f', 'commercial', '2012-09-10', 2700),
-- # (NULL, 'Julien', 'Cottet', 'm', 'secretariat', '2013-01-05', 1390),
-- # (NULL, 'Mathieu', 'Vignal', 'm', 'informatique', '2013-04-03', 2500),
-- # (NULL, 'Thierry', 'Desprez', 'm', 'secretariat', '2013-07-17', 1500),
-- # (NULL, 'Amandine', 'Thoyer', 'f', 'communication', '2014-01-23', 2100),
-- # (NULL, 'Damien', 'Durand', 'm', 'informatique', '2014-07-05', 2250),
-- # (NULL, 'Daniel', 'Chevel', 'm', 'informatique', '2015-09-28', 3100),
-- # (NULL, 'Nathalie', 'Martin', 'f', 'juridique', '2016-01-12', 3550),
-- # (NULL, 'Benoit', 'Lagarde', 'm', 'production', '2016-06-03', 2550),
-- # (NULL, 'Emilie', 'Sennard', 'f', 'commercial', '2017-01-11', 1800),
-- # (NULL, 'Stephanie', 'Lafaye', 'f', 'assistant', '2017-03-01', 1775);