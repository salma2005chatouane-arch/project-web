create database if not exists gestionn_formations;
use gestionn_formations;

create table if not exists users (
    id int auto_increment primary key,
    username varchar(100) not null unique,
    password varchar(255) not null,
    nom varchar(255) not null,
    role enum('admin', 'rh', 'formateur', 'employe') default 'employe',
    created_at timestamp default current_timestamp
);

create table if not exists formations (
    id int auto_increment primary key,
    nom varchar(255) not null,
    duree int not null,
    description text
);

create table if not exists formateurs (
    id int auto_increment primary key,
    nom varchar(255) not null,
    email varchar(255) not null,
    specialite varchar(255)
);

create table if not exists sessions (
    id int auto_increment primary key,
    formation_id int,
    formateur_id int,
    date_debut date,
    date_fin date,
    foreign key (formation_id) references formations(id),
    foreign key (formateur_id) references formateurs(id)
);

create table if not exists inscriptions (
    id int auto_increment primary key,
    session_id int,
    nom_employe varchar(255) not null,
    prenom_employe varchar(255) not null,
    email_employe varchar(255) not null,
    service varchar(100),
    statut varchar(20) default 'confirmee',
    foreign key (session_id) references sessions(id)
);

insert into users (username, password, nom, role) values
('admin', '1234', 'Admin', 'admin'),
('rh', '1234', 'RH', 'rh'),
('formateur', '1234', 'Formateur', 'formateur'),
('employe', '1234', 'Employe Test', 'employe'),
('yassine', '1234', 'Yassine Mansouri', 'employe'),
('leila', '1234', 'Leila Haddad', 'employe'),
('omar', '1234', 'Omar Tazi', 'employe'),
('fatima', '1234', 'Fatima Zohra', 'employe');

insert into formateurs (nom, email, specialite) values
('hassan kamil', 'hassan.kamil@entreprise.SI', 'React et frameworks JS'),
('douaa amine', 'douaa.09@entreprise.SI', 'Design UI/UX'),
('ahmed sajid', 'sajid.ahmed@entreprise.SI', 'PHP et bases de données'),
('sanna mohamed', 'sanaa.mohamed@entreprise.SI', 'Sécurité informatique'),
('mohammed amine abir', 'medamineabir@entreprise.SI', 'SQL et Architecture'),
('anass ferhan', 'anassferhan@entreprise.SI', 'JavaScript et frontend');

insert into formations (nom, duree, description) values
('Développement Web Avancé', 35, 'Apprendre HTML, CSS, JavaScript et PHP'),
('Management d équipe', 14, 'Techniques de leadership et gestion de conflits'),
('Sécurité Informatique', 7, 'Bonnes pratiques pour sécuriser les données'),
('Excel Avancé', 7, 'Tableaux croisés dynamiques et macros'),
('Communication Professionnelle', 14, 'Améliorer ses présentations et emails'),
('Python pour la Data', 21, 'Introduction à Python, Pandas et Matplotlib'),
('Agilité et Scrum', 14, 'Comprendre les frameworks agiles');

insert into sessions (formation_id, formateur_id, date_debut, date_fin) values
(1, 1, '2024-01-10', '2024-01-15'),
(2, 2, '2024-01-20', '2024-01-22'),
(3, 3, '2025-02-01', '2025-02-02'),
(4, 4, '2025-03-10', '2025-03-11'),
(5, 5, '2023-12-01', '2023-12-03'),
(6, 6, '2024-02-05', '2024-02-08');

insert into inscriptions (session_id, nom_employe, prenom_employe, email_employe, service, statut) values
(1, 'Mansouri', 'Yassine', 'yassine@company.fr', 'Informatique', 'confirmee'),
(1, 'Haddad', 'Leila', 'leila@company.fr', 'Marketing', 'confirmee'),
(2, 'Tazi', 'Omar', 'omar@company.fr', 'RH', 'confirmee'),
(5, 'Zohra', 'Fatima', 'fatima@company.fr', 'Finance', 'confirmee'),
(5, 'Mansouri', 'Yassine', 'yassine@company.fr', 'Informatique', 'confirmee'),
(6, 'Haddad', 'Leila', 'leila@company.fr', 'Marketing', 'confirmee');
